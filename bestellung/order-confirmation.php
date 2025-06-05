<?php
$title = 'Bestellbestätigung - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <section class="order-confirmation">
                <div class="success-message">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h2>Vielen Dank für Ihre Bestellung!</h2>
                    <p>Ihre Bestellung wurde erfolgreich aufgegeben und wird bearbeitet.</p>
                    
                    <div id="transaction-details" class="transaction-details">
                        <h3>Ihre Transaktions-ID:</h3>
                        <div class="transaction-id" id="confirmation-transaction-id">
                            <!-- Transaction ID will be inserted here via JavaScript -->
                        </div>
                        <p>Bitte bewahren Sie diese ID für die Nachverfolgung Ihrer Bestellung auf.</p>
                    </div>
                    
                    <div class="next-steps">
                        <p>Was möchten Sie als nächstes tun?</p>
                        <div class="button-group">
                            <a href="//index.php" class="btn btn-secondary"><i class="fas fa-home"></i> Zurück zur Startseite</a>
                            <a href="order-tracking.html" class="btn btn-primary"><i class="fas fa-search"></i> Bestellung verfolgen</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
