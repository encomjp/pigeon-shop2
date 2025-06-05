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
                <a href="/pages/courses.php" class="btn btn-secondary">Kurse ansehen</a>
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
              <!-- Reviews Carousel Section -->
            <section class="reviews-section">
                <h2>Das sagen unsere Kunden</h2>
                <div class="reviews-carousel">
                    <div class="reviews-container">
                        <div class="review-card active">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Dank des Kurses verstehe ich endlich, warum meine Nachbarn nachts schreien. Überraschung: Es waren Tauben die ganze Zeit! Wer hätte das gedacht?"</p>
                                <div class="reviewer">
                                    <strong>Lennardo Pfaffino van Hohensachsen</strong>
                                    <span>Nachbarschaftsdetektiv</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Meine ESP32 IoT Tauben funktionieren endlich! Jetzt kann ich meine Nachbarn auch nachts überwachen. Aus rein wissenschaftlichen Gründen, natürlich."</p>
                                <div class="reviewer">
                                    <strong>Waldemar Fech</strong>
                                    <span>IoT-Tauben-Entwickler</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★☆</div>
                                <p>"Wie installiere ich STEAM auf meine Taube? Support sagte ich soll aufhören anzurufen, aber meine Taube möchte Counter-Strike spielen!"</p>
                                <div class="reviewer">
                                    <strong>Marc Frauenhoffer</strong>
                                    <span>Gaming-Tauben-Trainer</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Ich dachte, ich kenne Tauben, aber dieser Kurs lehrte mich, dass sie eigentlich geheime Regierungsdrohnen sind. Jetzt verstehe ich, warum sie mich immer anstarren! 10/10 würde es Verschwörungstheoretikern empfehlen."</p>
                                <div class="reviewer">
                                    <strong>Herr Weindok</strong>
                                    <span>Verschwörungstheoretiker</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★☆</div>
                                <p>"Nach diesem Kurs kann ich endlich mit den Tauben in meinem Garten kommunizieren. Es stellte sich heraus, dass sie sich jahrelang über mein Kochen beschwert haben. Sie bevorzugen Brotkrümel gegenüber meiner Gourmet-Vogelfuttermischung. Wer hätte das gedacht?"</p>
                                <div class="reviewer">
                                    <strong>Herr Wiedmann</strong>
                                    <span>Hobbykoch & Taubenflüsterer</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Dieser Kurs hat mein Leben verändert! Ich lernte, dass Tauben eine komplexe Sozialhierarchie haben. Ich bin jetzt der Bürgermeister meiner lokalen Taubengemeinschaft. Sie wählten mich, nachdem ich 3 Monate lang täglich mein Sandwich mit ihnen teilte."</p>
                                <div class="reviewer">
                                    <strong>Herr Strobel</strong>
                                    <span>Tauben-Bürgermeister & Sandwich-Verteiler</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Ich kaufte diesen Kurs und dachte, es ginge um Brieftauben für mein Postservice-Hobby. Stattdessen lernte ich, wie man einen Tauben-Taxi-Service startet. Das Geschäft boomt! 5 Sterne für unerwartetes Unternehmertum!"</p>
                                <div class="reviewer">
                                    <strong>Frau Schmidt</strong>
                                    <span>Tauben-Taxi-CEO</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★☆☆</div>
                                <p>"Der Kurs war großartig, aber ich glaube, ich habe etwas falsch verstanden. Ich versuche seit 6 Monaten, Tauben Schach zu lehren. Sie fressen immer die Figuren. Werde es mit einem Plastik-Schachset nochmal versuchen."</p>
                                <div class="reviewer">
                                    <strong>Dr. Mueller</strong>
                                    <span>Schachlehrer & Optimist</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="review-card">
                            <div class="review-content">
                                <div class="stars">★★★★★</div>
                                <p>"Dank dieses Kurses habe ich jetzt einen Tauben-Personal-Trainer. Jeden Morgen um 6 Uhr klopft Gerald die Taube an mein Fenster, bis ich joggen gehe. 20 Pfund abgenommen! Bestes Fitnessprogramm aller Zeiten!"</p>
                                <div class="reviewer">
                                    <strong>Herr Weber</strong>
                                    <span>Fitness-Enthusiast & Geralds Mensch</span>
                                </div>
                            </div>
                        </div>
                    </div>                    <div class="carousel-indicators">
                        <span class="indicator active" data-slide="0"></span>
                        <span class="indicator" data-slide="1"></span>
                        <span class="indicator" data-slide="2"></span>
                    </div>
                </div>
            </section>
        </div>
    </main>

<?php
$content = ob_get_clean();
include __DIR__ . '/app.php';
?>
