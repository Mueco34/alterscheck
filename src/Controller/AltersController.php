<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AltersController extends AbstractController
{
    #[Route('/alter', name: 'app_alter')]
    public function index(Request $request): Response
    {
        $name = $request->request->get('name');
        $alter = $request->request->get('alter');
        $ergebnis = null;

        if ($name && $alter !== null) {
            $alter = (int)$alter;
            $geburtsjahr = date("Y") - $alter;

            if ($alter < 0 || $alter > 120) {
                $ergebnis = "Ungültiges Alter!";
            } elseif ($alter < 18) {
                $ergebnis = "Hallo $name, du bist noch minderjährig. Du wirst in " . (18 - $alter) . " Jahr(en) volljährig.";
            } else {
                $ergebnis = "Hallo $name, du bist volljährig!";
            }

            $ergebnis .= "<br>Dein geschätztes Geburtsjahr: $geburtsjahr";

            // Korrekte Reihenfolge
            $dateipfad = $this->getParameter('kernel.project_dir') . '/var/data/alter_daten.csv';
            $dateiExistiert = file_exists($dateipfad);
            $csvDatei = fopen($dateipfad, 'a');

            if (!$dateiExistiert) {
                fputcsv($csvDatei, ['Name', 'Alter', 'Geburtsjahr', 'Ergebnis']);
            }

            fputcsv($csvDatei, [$name, $alter, $geburtsjahr, strip_tags($ergebnis)]);
            fclose($csvDatei);
        }

        return $this->render('alters/index.html.twig', [
            'ergebnis' => $ergebnis,
        ]);
    }

    #[Route('/api/alter', name: 'api_alter')]
    public function api(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        $alter = (int) $request->query->get('alter');

        if (!$name || $alter <= 0 || $alter > 120) {
            return $this->json([
                'error' => 'Ungültige Eingabe'
            ], 400);
        }

        $status = ($alter >= 18) ? 'volljährig' : 'minderjährig';
        $geburtsjahr = date("Y") - $alter;

        return $this->json([
            'name' => $name,
            'alter' => $alter,
            'status' => $status,
            'geburtsjahr' => $geburtsjahr
        ]);
    }

    #[Route('/alle', name: 'app_alle')]
    #[IsGranted('ROLE_USER')]
    public function alle(): Response
    {
        $eintraege = [];
        $dateipfad = $this->getParameter('kernel.project_dir') . '/var/data/alter_daten.csv';

        if (file_exists($dateipfad)) {
            if (($handle = fopen($dateipfad, 'r')) !== false) {
                $kopfzeile = fgetcsv($handle);
                while (($daten = fgetcsv($handle)) !== false) {
                    $eintraege[] = [
                        'name' => $daten[0],
                        'alter' => $daten[1],
                        'geburtsjahr' => $daten[2],
                        'ergebnis' => $daten[3],
                    ];
                }
                fclose($handle);
            }
        }

        return $this->render('alters/alle.html.twig', [
            'eintraege' => $eintraege,
        ]);
    }
    #[Route('/download', name: 'app_download')]
    #[IsGranted('ROLE_USER')]
    public function download(): Response
    {
        $dateipfad = $this->getParameter('kernel.project_dir') . '/var/data/alter_daten.csv';

        if (!file_exists($dateipfad)) {
            $this->addFlash('danger', '❌ Datei nicht gefunden.');
            return $this->redirectToRoute('app_alter');
        }

        return $this->file($dateipfad, 'alter_daten.csv');
    }

}
