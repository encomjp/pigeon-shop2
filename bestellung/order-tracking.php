<?php
$title = 'Bestellung verfolgen - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <section class="order-tracking">
                <h2>Bestellverfolgung</h2>
                <p>Geben Sie Ihre Transaktions-ID ein, um den Status Ihrer Bestellung zu überprüfen.</p>
                
                <form id="order-tracking-form" class="tracking-form">
                    <div class="form-group">
                        <input type="text" id="transaction-id" name="transaction-id" placeholder="Bitte geben Sie Ihre Transaktions-ID ein" required>
                        <button type="submit" class="btn">Bestellung suchen</button>
                    </div>
                </form>
                
                <div id="order-details">
                    <!-- Order details will be displayed here via JavaScript -->
                </div>
            </section>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
