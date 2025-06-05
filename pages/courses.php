<?php
$title = 'Kurse - Agil Shop';
ob_start();
?>
    
    <main>
        <div class="container">
            <section class="category-header">
                <h2>Tauben Kurse</h2>
                <p>Erweitern Sie Ihr Wissen über Tauben mit unseren fachkundigen Online-Kursen. Von der Taubensprache bis zum Zusammenleben mit Tauben in der Stadt - hier finden Sie alles!</p>
            </section>
            
            <section class="category-products">
                <!-- Loading indicator -->
                <div id="loading" class="loading-container" style="text-align: center; padding: 50px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--accent-color);"></i>
                    <p>Kurse werden geladen...</p>
                </div>
                
                <!-- Products will be loaded here from the database -->
                <div class="product-grid" id="courses-container">
                    <!-- Dynamic content will be inserted here by JavaScript -->
                </div>
            </section>
            
            <section class="course-info">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Online Lernplattform</h3>
                    <p>Alle Kurse sind über unsere benutzerfreundliche Online-Plattform zugänglich. Lernen Sie in Ihrem eigenen Tempo, wann immer und wo immer Sie möchten.</p>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Zertifizierte Experten</h3>
                    <p>Unsere Kurse werden von zertifizierten Taubenexperten erstellt und unterrichtet, die jahrelange Erfahrung in der Arbeit mit diesen faszinierenden Vögeln haben.</p>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Unbegrenzter Zugang</h3>
                    <p>Nach dem Kauf erhalten Sie unbegrenzten Zugang zu allen Kursinhalten. Sehen Sie sich die Lektionen so oft an, wie Sie möchten.</p>
                </div>            </section>
        </div>
    </main>
    
<?php
$content = ob_get_clean();
include __DIR__ . '/../app.php';
?>
