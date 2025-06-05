<?php
$title = 'Kasse - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <!-- Checkout Header -->
            <div class="checkout-header">
                <h2>
                    <div class="checkout-header-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    Sichere Kasse
                </h2>
                
                <!-- Progress Steps -->
                <div class="checkout-progress">
                    <div class="progress-step completed">
                        <i class="fas fa-shopping-cart"></i>
                        Warenkorb
                    </div>
                    <div class="progress-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="progress-step completed">
                        <i class="fas fa-credit-card"></i>
                        Kasse
                    </div>
                    <div class="progress-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="progress-step">
                        <i class="fas fa-check-circle"></i>
                        Bestätigung
                    </div>
                </div>
            </div>
            
            <div class="checkout-container">
                <!-- Checkout Form -->
                <div class="checkout-form-wrapper">
                    <form id="checkout-form">
                        <!-- Customer Information -->
                        <div class="form-section">
                            <h3>
                                <div class="form-section-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                Ihre Informationen
                            </h3>
                            
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    Vollständiger Name
                                </label>
                                <input type="text" id="name" name="name" placeholder="Max Mustermann" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    E-Mail-Adresse
                                </label>
                                <input type="email" id="email" name="email" placeholder="max@example.com" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Vollständige Lieferadresse
                                </label>
                                <textarea id="address" name="address" rows="4" placeholder="Straße und Hausnummer&#10;PLZ Stadt&#10;Land" required></textarea>
                            </div>
                        </div>
                        
                        <!-- Payment Information -->
                        <div class="form-section">
                            <h3>
                                <div class="form-section-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                Zahlungsinformationen
                            </h3>
                            
                            <div class="payment-notice">
                                <i class="fas fa-info-circle"></i>
                                Diese Zahlungsinformationen dienen nur zu Demonstrationszwecken. Es wird keine echte Zahlung durchgeführt.
                            </div>
                            
                            <div class="form-group">
                                <label for="card-number">
                                    <i class="fas fa-credit-card"></i>
                                    Kartennummer
                                </label>
                                <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-expiry">
                                        <i class="fas fa-calendar"></i>
                                        Gültig bis
                                    </label>
                                    <input type="text" id="card-expiry" name="card-expiry" placeholder="MM/JJ" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="card-cvc">
                                        <i class="fas fa-lock"></i>
                                        Sicherheitscode
                                    </label>
                                    <input type="text" id="card-cvc" name="card-cvc" placeholder="CVC" maxlength="3">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="place-order-btn" id="place-order-btn">
                            <i class="fas fa-shopping-bag"></i>
                            Bestellung sicher aufgeben
                        </button>
                    </form>
                </div>
                
                <!-- Order Summary -->
                <div class="order-summary">
                    <h3>
                        <div class="summary-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        Bestellübersicht
                    </h3>
                    
                    <div id="order-items-container">
                        <!-- Order items will be inserted here via JavaScript -->
                    </div>
                    
                    <div class="summary-totals">
                        <div class="summary-line">
                            <span class="summary-line-label">Zwischensumme:</span>
                            <span class="summary-line-value" id="summary-subtotal">€0.00</span>
                        </div>
                        <div class="summary-line">
                            <span class="summary-line-label">
                                <i class="fas fa-shipping-fast"></i>
                                Versandkosten:
                            </span>
                            <span class="summary-line-value" id="summary-shipping">€4.95</span>
                        </div>
                        <div class="summary-line total">
                            <span>Gesamtsumme:</span>
                            <span id="summary-total">€4.95</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div class="checkout-loading" id="checkout-loading">
            <div class="loading-content">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h3>Bestellung wird verarbeitet...</h3>
                <p>Bitte warten Sie, während wir Ihre Bestellung bearbeiten.</p>
            </div>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
