<?php
$title = 'Warenkorb - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <!-- Loading State -->
            <div id="cart-loading" class="cart-loading" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i>
                <h3>Warenkorb wird geladen...</h3>
                <p>Bitte warten Sie einen Moment.</p>
            </div>

            <!-- Cart Content -->
            <div id="cart-content" class="cart-wrapper">
                <div class="cart-header">
                    <div class="cart-header-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Ihr Warenkorb</h2>
                </div>
                
                <div class="cart-items" id="cart-items-container">
                    <!-- Cart items will be loaded here by JavaScript -->
                </div>
                
                <div class="cart-summary">
                    <h3>
                        <i class="fas fa-calculator"></i>
                        Bestellübersicht
                    </h3>
                    <div id="cart-total-container">
                        <!-- Subtotal, Shipping, and Total will be loaded here by JavaScript -->
                    </div>
                </div>
                
                <div class="cart-actions">
                    <a href="/index.php" class="continue-shopping">
                        <i class="fas fa-arrow-left"></i> 
                        Weiter einkaufen
                    </a>
                    
                    <div></div> <!-- Spacer for grid layout -->
                    
                    <a href="checkout.php" class="checkout-btn" id="checkout-btn" style="display: none;">
                        Zur Kasse 
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Empty Cart Message -->
            <div id="empty-cart" class="empty-cart" style="display: none;">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Ihr Warenkorb ist leer</h3>
                <p>Entdecken Sie unsere exklusiven Taubenprodukte und fügen Sie Artikel zu Ihrem Warenkorb hinzu.</p>
                <a href="/index.php" class="btn">
                    <i class="fas fa-shopping-bag"></i>
                    Jetzt einkaufen
                </a>
            </div>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
