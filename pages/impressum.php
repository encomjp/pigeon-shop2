<?php
$title = 'Impressum - Agil Shop';
ob_start();
?>

    <main>
        <div class="container">
            <h2>Impressum</h2>
            <div class="legal-content">
                <h3>Angaben gemäß § 5 TMG</h3>
                <p>
                    Max Mustermann<br>
                    Musterstraße 1<br>
                    12345 Musterstadt
                </p>

                <h3>Kontakt</h3>
                <p>
                    Telefon: +49 (0) 123 456789<br>
                    E-Mail: info@agilshop.example.com
                </p>

                <h3>Umsatzsteuer-ID</h3>
                <p>
                    Umsatzsteuer-Identifikationsnummer gemäß § 27 a Umsatzsteuergesetz:<br>
                    DE123456789
                </p>

                <h3>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h3>
                <p>
                    Max Mustermann<br>
                    Anschrift wie oben
                </p>

                <h3>Streitschlichtung</h3>
                <p>
                    Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit: <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener noreferrer">https://ec.europa.eu/consumers/odr</a>.<br>
                    Unsere E-Mail-Adresse finden Sie oben im Impressum.<br>
                    Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.
                </p>

                <!-- Weitere rechtliche Hinweise hier einfügen -->

            </div>
        </div>
    </main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
