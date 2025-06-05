<?php
$title = 'Produktdetail - Agil Shop';
ob_start();
?>

    <main>
        <div class="container">
            <!-- Breadcrumb Navigation -->
            <div class="breadcrumb">
                <nav class="breadcrumb-nav">
                    <a href="/index.php"><i class="fas fa-home"></i> Startseite</a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="#" id="category-link">Produkte</a>
                    <span class="breadcrumb-separator">/</span>
                    <span id="product-breadcrumb">Produktdetail</span>
                </nav>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="loading-product">
                <i class="fas fa-spinner fa-spin"></i>
                <h3>Produktdaten werden geladen...</h3>
                <p>Bitte warten Sie einen Moment.</p>
            </div>

            <!-- Product Detail Container -->
            <div class="product-detail-wrapper" id="product-detail-wrapper" style="display: none;">
                <div class="product-detail-container" id="product-detail">
                    <!-- Content will be dynamically loaded -->
                </div>
            </div>

            <!-- Error State -->
            <div id="error-state" class="error-state" style="display: none;">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Produkt nicht gefunden</h3>
                <p>Das gewünschte Produkt konnte nicht gefunden werden.</p>
                <a href="/index.php" class="btn">Zurück zur Startseite</a>
            </div>
        </div>
    </main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
