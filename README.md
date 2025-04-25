🧐 Alterscheck App

Ein kleines Symfony-Projekt, das das Alter eines Benutzers über ein Webformular prüft, die Ergebnisse speichert und weitere Funktionen wie CSV-Download, Login-Schutz und API-Schnittstelle bietet.



🔹 Features

🔢 Altersprüfung via Formular (Name + Alter eingeben)

📊 Speicherung der Daten in einer CSV-Datei

👥 Login-geschützte Bereiche (nur eingeloggte Nutzer sehen "alle" und "download")

📦 CSV-Download aller gespeicherten Altersdaten

🌐 API-Endpoint (JSON) für externe Anfragen

✨ Bootstrap-Design für schönes Frontend




📚 Installation

Projekt clonen:

git clone https://github.com/Mueco34/alterscheck.git
cd alterscheck

Abhängigkeiten installieren:

composer install

Lokalen Webserver starten:

symfony server:start

Im Browser aufrufen:

http://127.0.0.1:8000




### 📊 Wichtige Routen

| **Route**                      | **Funktion**                          | **Schutz**              |
|-------------------------------|---------------------------------------|--------------------------|
| `/alter`                      | Formular für Alterscheck              | ⛓ Öffentlich             |
| `/alle`                       | Alle Einträge aus der CSV anzeigen    | 🔐 Login erforderlich    |
| `/download`                   | CSV-Datei herunterladen               | 🔐 Login erforderlich    |
| `/api/alter?name=Max&alter=22`| API-Zugriff (JSON)                    | ⛓ Öffentlich             |





📊 Benötigte Voraussetzungen

PHP 8.1+

Composer

Symfony CLI

Git




💜 Viel Spaß beim Nutzen und Weiterentwickeln!

Author: Mücahid AkargölGitHub: Mueco34
