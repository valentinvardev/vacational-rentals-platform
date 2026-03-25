<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    <title>Propiedades Disponibles - RentaTurista</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        :root {
            --orange-primary: #FF6B35;
            --orange-light: #FF8F64;
            --orange-dark: #E55527;
            
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #E5E5E5;
            --gray-300: #D4D4D4;
            --gray-400: #A3A3A3;
            --gray-500: #737373;
            --gray-600: #525252;
            --gray-700: #404040;
            --gray-800: #262626;
            --gray-900: #171717;
            
            --white: #FFFFFF;
            --black: #000000;
            
            --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background: var(--gray-50);
            color: var(--gray-800);
            overflow-x: hidden;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 3vw, 2rem);
        }

        /* Section */
        .available-section {
            padding: 4rem 0;
        }

        .section-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 700;
            color: var(--gray-900);
        }

        .section-subtitle {
            font-size: 0.9375rem;
            color: var(--gray-600);
            margin-top: 0.5rem;
        }

        /* Slider Container */
        .slider-container {
            position: relative;
        }

        .slider-wrapper {
            overflow: hidden;
            margin: 0 -0.5rem;
        }

        .slider-track {
            display: flex;
            gap: 1.5rem;
            padding: 0.5rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            scroll-behavior: smooth;
        }

        /* Mobile: enable touch scroll */
        @media (max-width: 1024px) {
            .slider-wrapper {
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .slider-wrapper::-webkit-scrollbar {
                display: none;
            }
        }

        /* Property Card */
        .property-card {
            min-width: 320px;
            max-width: 320px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            flex-shrink: 0;
        }

        .property-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .property-image {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .property-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-image > i {
            color: rgba(255, 255, 255, 0.6);
        }

        .favorite-btn {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 36px;
            height: 36px;
            background: transparent;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--white);
            z-index: 10;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .favorite-btn:hover {
            transform: scale(1.15);
        }

        .favorite-btn.active {
            color: #EF4444;
        }

        .property-rating-badge {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .stars {
            color: #FFA500;
            font-size: 0.75rem;
            display: flex;
            gap: 1px;
        }

        .rating-value {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .property-content {
            padding: 1.25rem;
        }

        .property-type {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.375rem;
        }

        .property-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.3;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6em;
        }

        .property-features {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-700);
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .feature i {
            color: var(--gray-500);
        }

        .property-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .property-price-container {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .price-icons {
            display: flex;
            align-items: center;
            gap: 0.125rem;
        }

        .price-icon {
            width: 16px;
            height: 16px;
            color: var(--orange-primary);
        }

        .price-icon.filled {
            opacity: 1;
        }

        .price-icon.empty {
            opacity: 0.2;
        }

        .price-label {
            font-size: 0.6875rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .view-link {
            color: var(--orange-primary);
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: var(--transition);
        }

        .view-link:hover {
            gap: 0.5rem;
        }

        /* Navigation Controls */
        .slider-controls {
            display: none;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        @media (min-width: 1025px) {
            .slider-controls {
                display: flex;
            }
        }

        .slider-nav {
            width: 44px;
            height: 44px;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
        }

        .slider-nav:hover:not(:disabled) {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            transform: scale(1.05);
        }

        .slider-nav:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .property-card {
                min-width: 280px;
                max-width: 280px;
            }
        }

        @media (max-width: 640px) {
            .available-section {
                padding: 2rem 0;
            }

            .property-card {
                min-width: 260px;
                max-width: 260px;
            }
        }
    </style>
</head>
<body>
    <section class="available-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Disponibles en fechas similares</h2>
                    <p class="section-subtitle">Propiedades verificadas con disponibilidad inmediata</p>
                </div>
            </div>

            <!-- Slider -->
            <div class="slider-container">
                <div class="slider-wrapper" id="sliderWrapper">
                    <div class="slider-track" id="sliderTrack">
                        <!-- Property 1 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="home" size="56"></i>
                                <button class="favorite-btn">
                                    <i data-lucide="heart" size="20"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">4.76</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Casa</div>
                                <h3 class="property-title">Hotel en Solor</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>3</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>2</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>6</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                        </div>
                                        <div class="price-label">$100K - $150K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Property 2 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="building-2" size="56"></i>
                                <button class="favorite-btn">
                                    <i data-lucide="heart" size="20"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">5.0</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Departamento</div>
                                <h3 class="property-title">Habitación en San Pedro de Atacama</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>2</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>1</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>4</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                        </div>
                                        <div class="price-label">$50K - $100K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Property 3 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="mountain" size="56"></i>
                                <button class="favorite-btn active">
                                    <i data-lucide="heart" size="20" fill="currentColor"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">4.9</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Cabaña</div>
                                <h3 class="property-title">Cabaña en las Sierras</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>4</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>3</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>8</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                        </div>
                                        <div class="price-label">Más de $150K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Property 4 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="home" size="56"></i>
                                <button class="favorite-btn">
                                    <i data-lucide="heart" size="20"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">4.91</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Casa Rural</div>
                                <h3 class="property-title">Casa rural en San Pedro de Atacama</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>3</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>2</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>6</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                        </div>
                                        <div class="price-label">$100K - $150K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Property 5 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="hotel" size="56"></i>
                                <button class="favorite-btn">
                                    <i data-lucide="heart" size="20"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">4.93</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Habitación</div>
                                <h3 class="property-title">Habitación en San Pedro de Atacama</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>1</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>1</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>2</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                        </div>
                                        <div class="price-label">Hasta $50K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Property 6 -->
                        <div class="property-card">
                            <div class="property-image">
                                <i data-lucide="home" size="56"></i>
                                <button class="favorite-btn">
                                    <i data-lucide="heart" size="20"></i>
                                </button>
                                <div class="property-rating-badge">
                                    <div class="stars">
                                        <i data-lucide="star" size="12" fill="currentColor"></i>
                                    </div>
                                    <span class="rating-value">5.0</span>
                                </div>
                            </div>
                            <div class="property-content">
                                <div class="property-type">Casa</div>
                                <h3 class="property-title">Habitación en San Pedro de Atacama</h3>
                                <div class="property-features">
                                    <div class="feature">
                                        <i data-lucide="bed-double" size="14"></i>
                                        <span>2</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="bath" size="14"></i>
                                        <span>1</span>
                                    </div>
                                    <div class="feature">
                                        <i data-lucide="users" size="14"></i>
                                        <span>4</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <div class="property-price-container">
                                        <div class="price-icons">
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon filled"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                            <i data-lucide="dollar-sign" size="16" class="price-icon empty"></i>
                                        </div>
                                        <div class="price-label">$50K - $100K</div>
                                    </div>
                                    <a href="#" class="view-link">
                                        Ver
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Controls (Desktop only) -->
                <div class="slider-controls">
                    <button class="slider-nav prev" id="prevBtn" onclick="slideLeft()">
                        <i data-lucide="chevron-left" size="20"></i>
                    </button>
                    <button class="slider-nav next" id="nextBtn" onclick="slideRight()">
                        <i data-lucide="chevron-right" size="20"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Slider functionality (Desktop only)
        let currentSlide = 0;
        const cardWidth = 320 + 24; // card width + gap

        function updateNavButtons() {
            const track = document.getElementById('sliderTrack');
            const maxSlide = Math.max(0, track.children.length - 4);
            
            document.getElementById('prevBtn').disabled = currentSlide === 0;
            document.getElementById('nextBtn').disabled = currentSlide >= maxSlide;
        }

        function slideLeft() {
            if (currentSlide > 0) {
                currentSlide--;
                const track = document.getElementById('sliderTrack');
                track.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
                updateNavButtons();
            }
        }

        function slideRight() {
            const track = document.getElementById('sliderTrack');
            const maxSlide = Math.max(0, track.children.length - 4);
            
            if (currentSlide < maxSlide) {
                currentSlide++;
                track.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
                updateNavButtons();
            }
        }

        // Favorite button toggle
        document.querySelectorAll('.favorite-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.toggle('active');
                
                const heart = this.querySelector('i');
                if (this.classList.contains('active')) {
                    heart.setAttribute('fill', 'currentColor');
                } else {
                    heart.removeAttribute('fill');
                }
            });
        });

        // Reset slider on resize
        window.addEventListener('resize', function() {
            const track = document.getElementById('sliderTrack');
            if (window.innerWidth <= 1024) {
                track.style.transform = 'translateX(0)';
                currentSlide = 0;
            }
            updateNavButtons();
        });

        // Initialize nav buttons state
        updateNavButtons();
    </script>
</body>
</html>