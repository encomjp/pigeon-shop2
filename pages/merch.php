<?php
$title = 'Tauben Merch - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <section class="category-header">
                <h2>Tauben Merchandise</h2>
                <p>Zeigen Sie Ihre Leidenschaft für Tauben mit unserer exklusiven Kollektion von T-Shirts, Tassen und mehr!</p>
            </section>
            
            <section class="category-products">
                <!-- Loading indicator -->
                <div id="loading" class="loading-container" style="text-align: center; padding: 50px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--accent-color);"></i>
                    <p>Produkte werden geladen...</p>
                </div>
                
                <!-- Products will be loaded here from the database -->
                <div class="product-grid" id="merch-container">
                    <!-- Dynamic content will be inserted here by JavaScript -->
                </div>
            </section>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
