<?php
$title = 'Taubenfotos - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <section class="category-header">
                <h2>Taubenfotos</h2>
                <p>Entdecken Sie unsere exklusive Sammlung von Taubenfotos, die die Schönheit und Majestät dieser faszinierenden Vögel einfangen.</p>
            </section>
            
            <section class="category-products">
                <!-- Loading indicator -->
                <div id="loading" class="loading-container" style="text-align: center; padding: 50px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--accent-color);"></i>
                    <p>Produkte werden geladen...</p>
                </div>
                
                <!-- Products will be loaded here from the database -->
                <div class="product-grid" id="photos-container">
                    <!-- Dynamic content will be inserted here by JavaScript -->
                </div>
            </section>
        </div>
    </main>
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
