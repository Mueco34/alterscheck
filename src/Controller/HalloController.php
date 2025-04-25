<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HalloController extends AbstractController
{
    #[Route('/hallo', name: 'app_hallo')]
    public function index(): Response
    {
        return $this->render('hallo/index.html.twig', [
            'controller_name' => 'Mücahid', // <-- dein Name hier
        ]);
        
    }
}
