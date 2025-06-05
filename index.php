<?php
$title = 'Agil Shop - Tauben Onlineshop';
ob_start();
?>

    <!-- Modernized Hero Section -->
    <section class="hero">
        <div class="hero-content fade-in">
            <div class="hero-text-background">
                <h1>Die Welt der Tauben</h1>
                <p>Von majestätischen Fotos bis hin zu einzigartigem Merch – alles für Taubenliebhaber an einem Ort.</p>
            </div>
            <div class="hero-buttons">
                <a href="/pages/photos.php" class="btn btn-primary">Fotos entdecken</a>
                <a href="/pages/merch.php" class="btn btn-secondary">Merch ansehen</a>
            </div>
        </div>
    </section>

    <main>
        <div class="container">
            <!-- Featured Products Section -->
            <section class="featured-products">
                <h2>Beliebte Produkte</h2>
                
                <!-- Loading indicator -->
                <div id="loading-featured" class="loading-container" style="text-align: center; padding: 30px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--accent-color);"></i>
                    <p>Produkte werden geladen...</p>
                </div>
                
                <div class="product-grid">
                    <!-- Products will be loaded dynamically from the database -->
                </div>
                
                <div class="view-all-container">
                    <a href="/pages/photos.php" class="btn btn-outline">Alle Produkte ansehen</a>
                </div>
            </section>
        </div>
    </main>

<?php
$content = ob_get_clean();
include __DIR__ . '/app.php';
?>
