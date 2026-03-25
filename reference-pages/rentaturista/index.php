<!DOCTYPE html>
<html lang="es-AR" prefix="og: https://ogp.me/ns#">
<head>
    <!-- Critical Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    
    <!-- SEO Meta Tags -->
    <title>RentaTurista | Alquiler Vacacional en Villa Carlos Paz - Propiedades Verificadas</title>
    <meta name="description" content="Encuentra tu alojamiento ideal en Villa Carlos Paz. Casas, departamentos y cabañas con asistencia 24/7. Plataforma local con propiedades verificadas y los mejores precios.">
    <meta name="keywords" content="alquiler villa carlos paz, hospedaje cordoba, casas vacacionales, departamentos turisticos, cabañas sierras">
    <meta name="author" content="RentaTurista">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="canonical" href="https://rentaturista.com">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://rentaturista.com">
    <meta property="og:title" content="RentaTurista - Tu hospedaje ideal en Villa Carlos Paz">
    <meta property="og:description" content="Plataforma local de alquileres vacacionales con asistencia humana 24/7 y tecnología IA.">
    <meta property="og:image" content="https://rentaturista.com/img/og-image.jpg">
    <meta property="og:locale" content="es_AR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="RentaTurista - Alquiler Vacacional Villa Carlos Paz">
    <meta name="twitter:description" content="Encuentra tu alojamiento perfecto con asistencia local 24/7">
    
    <!-- Geo Tags -->
    <meta name="geo.region" content="AR-X">
    <meta name="geo.placename" content="Villa Carlos Paz">
    <meta name="geo.position" content="-31.4135;-64.4945">
    
    <!-- Preloads -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//unpkg.com">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
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
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            line-height: 1.6;
            color: var(--gray-800);
            background: var(--white);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Hero Section - Split Layout */
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--white);
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: var(--white);
            position: relative;
        }

        .hero-inner {
            max-width: 600px;
            width: 100%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            border: 1px solid rgba(255, 107, 53, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .hero-title {
            font-size: clamp(3.5rem, 7vw, 5.5rem);
            font-weight: 600;
            line-height: 1.05;
            margin-bottom: 1.25rem;
            letter-spacing: -0.03em;
            color: var(--gray-900);
            position: relative;
            display: inline-block;
        }

        .hero-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 120px;
            height: 6px;
            background: linear-gradient(90deg, var(--orange-primary) 0%, var(--orange-light) 100%);
            border-radius: 3px;
        }

        .hero-subtitle {
            font-size: clamp(1.125rem, 2vw, 1.25rem);
            font-weight: 400;
            line-height: 1.7;
            margin-bottom: 2rem;
            color: var(--gray-600);
            margin-top: 1.5rem;
        }

        .hero-cta-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--orange-primary);
            color: var(--white);
            padding: 1.125rem 2.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.125rem;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
            border: 2px solid var(--orange-primary);
        }

        .hero-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.4);
            background: var(--orange-dark);
            border-color: var(--orange-dark);
        }

        .hero-cta-secondary {
            background: var(--white);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .hero-cta-secondary:hover {
            background: var(--orange-primary);
            color: var(--white);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .hero-scroll {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: var(--orange-primary);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            transition: var(--transition);
            font-family: var(--font-primary);
            letter-spacing: 0.05em;
        }

        .hero-scroll:hover {
            color: var(--orange-dark);
            transform: translateX(-50%) translateY(5px);
        }

        .hero-scroll span {
            animation: fadeInOut 2s ease-in-out infinite;
        }

        .hero-scroll i {
            width: 28px;
            height: 28px;
            animation: floatUpDown 1.5s ease-in-out infinite;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        .hero-scroll.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Hero Slider Side */
        .hero-slider-container {
            position: relative;
            overflow: hidden;
            background: var(--gray-100);
        }

        .hero-slider {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: scale(1.1);
            transition: opacity 1.2s ease-in-out, transform 8s ease-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .hero-slide:nth-child(1) {
            background-image: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&h=1600&fit=crop');
        }
        .hero-slide:nth-child(2) {
            background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&h=1600&fit=crop');
        }
        .hero-slide:nth-child(3) {
            background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&h=1600&fit=crop');
        }
        .hero-slide:nth-child(4) {
            background-image: url('https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1200&h=1600&fit=crop');
        }

        .slider-controls {
            position: absolute;
            bottom: 3rem;
            right: 3rem;
            z-index: 15;
            display: flex;
            gap: 0.625rem;
        }

        .slider-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .slider-dot:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.1);
        }

        .slider-dot.active {
            background: var(--white);
            transform: scale(1.2);
            border-color: var(--white);
        }

        /* Section Styles */
        section {
            padding: 6rem 0;
        }

        .section-dark {
            background: var(--gray-50);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 3vw, 2rem);
        }

        .section-header {
            margin-bottom: 3rem;
        }

        .section-label {
            display: inline-block;
            color: var(--orange-primary);
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.5rem);
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .section-description {
            font-size: 1.0625rem;
            color: var(--gray-600);
            max-width: 700px;
            line-height: 1.7;
        }

        /* Featured Section */
        .featured-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .featured-image {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-2xl);
            min-height: 500px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(255, 107, 53, 0.05) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .featured-content p {
            font-size: 1.125rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .featured-features {
            list-style: none;
            margin-bottom: 2.5rem;
        }

        .featured-features li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.25rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        .featured-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        /* Unified Card Design */
        .slider-container {
            position: relative;
        }

        .slider-wrapper {
            overflow: hidden;
            margin: 0 -0.5rem;
        }

        .slider-track {
            display: flex;
            gap: 1rem;
            padding: 0.5rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            scroll-behavior: smooth;
        }

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

        .unified-card {
            min-width: 320px;
            max-width: 320px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .unified-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .card-image {
            position: relative;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-image > i {
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

        .card-rating-badge {
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

        .card-content {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-type {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.375rem;
            text-transform: capitalize;
        }

        .card-title {
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

        .card-features {
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

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .card-price-container {
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

        /* Explore Card */
        .explore-card {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            cursor: pointer;
            min-height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .explore-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 32px rgba(255, 107, 53, 0.4);
        }

        .explore-content {
            padding: 2.5rem 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.25rem;
            height: 100%;
        }

        .explore-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            margin-bottom: 0.5rem;
        }

        .explore-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--white);
            line-height: 1.3;
            margin: 0;
        }

        .explore-description {
            font-size: 0.9375rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.5;
            margin: 0;
        }

        .explore-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            color: var(--orange-primary);
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 0.5rem;
        }

        .explore-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            gap: 0.75rem;
        }

        /* Navigation Controls */
        .slider-controls-nav {
            display: none;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        @media (min-width: 1025px) {
            .slider-controls-nav {
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

        /* Trust Section */
        .trust-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .trust-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .trust-content p {
            font-size: 1.125rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .trust-features {
            list-style: none;
            margin-bottom: 2.5rem;
        }

        .trust-features li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.25rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        .trust-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .trust-visual {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.05) 0%, rgba(255, 107, 53, 0.02) 100%);
            border-radius: 24px;
            padding: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 500px;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            text-align: center;
            padding: 5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="1.5" fill="%23fff" opacity="0.1"/></svg>') repeat;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 600;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .cta-description {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--white);
            color: var(--orange-primary);
            padding: 1.125rem 2.75rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.125rem;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        /* Loading State */
        .loading-skeleton {
            background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .hero-slider-container {
                order: -1;
                min-height: 40vh;
            }

            .hero-content {
                padding: 3rem 2rem;
            }

            .hero-scroll {
                bottom: -1rem;
            }

            .featured-grid,
            .trust-grid {
                grid-template-columns: 1fr;
            }

            .featured-image {
                order: -1;
                min-height: 400px;
            }

            .unified-card {
                min-width: 280px;
                max-width: 280px;
            }

            .explore-card {
                min-width: 280px;
                max-width: 280px;
            }
        }

        @media (max-width: 768px) {
            section {
                padding: 4rem 0;
            }

            .hero-slider-container {
                min-height: 35vh;
            }

            .hero-content {
                padding: 2.5rem 1.5rem 1.5rem;
            }

            .hero-cta-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .hero-cta {
                width: 100%;
                justify-content: center;
            }

            .unified-card {
                min-width: 260px;
                max-width: 260px;
            }

            .explore-card {
                min-width: 260px;
                max-width: 260px;
            }
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-inner">
                <div class="hero-badge">
                    <i data-lucide="star" size="16"></i>
                    Plataforma Local
                </div>
                <h1 class="hero-title">
                    Tu hospedaje ideal en Villa Carlos Paz
                </h1>
                <p class="hero-subtitle">
                    Descubre alojamientos verificados con asistencia humana 24/7 y tecnología de vanguardia para una experiencia perfecta
                </p>
                <div class="hero-cta-group">
                    <a href="#hospedajes" class="hero-cta">
                        <i data-lucide="search" size="20"></i>
                        Explorar hospedajes
                    </a>
                    <a href="mapa.php" class="hero-cta hero-cta-secondary">
                        <i data-lucide="map" size="20"></i>
                        Mapa
                    </a>
                </div>
            </div>
            
            <button class="hero-scroll" id="scrollIndicator" onclick="document.querySelector('#explorar').scrollIntoView({behavior: 'smooth'})">
                <span>Descubre más</span>
                <i data-lucide="chevron-down" size="24"></i>
            </button>
        </div>

        <div class="hero-slider-container">
            <div class="hero-slider">
                <div class="hero-slide active"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
            </div>

            <div class="slider-controls">
                <div class="slider-dot active" data-slide="0"></div>
                <div class="slider-dot" data-slide="1"></div>
                <div class="slider-dot" data-slide="2"></div>
                <div class="slider-dot" data-slide="3"></div>
            </div>
        </div>
    </section>

    <!-- Featured Section -->
    <section id="explorar">
        <div class="container">
            <div class="featured-grid">
                <div class="featured-image">
                    <i data-lucide="map-pin-house" size="120" style="color: var(--orange-primary); opacity: 0.3;"></i>
                </div>

                <div class="featured-content">
                    <div class="section-label">Explora</div>
                    <h2>Encuentra tu lugar perfecto</h2>
                    <p>
                        Descubre propiedades verificadas en las mejores ubicaciones de Villa Carlos Paz. Cada alojamiento es inspeccionado por nuestro equipo local para garantizar calidad y comodidad.
                    </p>
                    
                    <ul class="featured-features">
                        <li>
                            <div class="featured-icon">
                                <i data-lucide="shield-check" size="20"></i>
                            </div>
                            <div>
                                <strong>Propiedades Verificadas</strong><br>
                                Cada hospedaje pasa por un riguroso control de calidad
                            </div>
                        </li>
                        <li>
                            <div class="featured-icon">
                                <i data-lucide="map-pin" size="20"></i>
                            </div>
                            <div>
                                <strong>Ubicaciones Premium</strong><br>
                                En las mejores zonas de Villa Carlos Paz
                            </div>
                        </li>
                        <li>
                            <div class="featured-icon">
                                <i data-lucide="sparkles" size="20"></i>
                            </div>
                            <div>
                                <strong>Experiencia Completa</strong><br>
                                Desde la reserva hasta el check-out, te acompañamos
                            </div>
                        </li>
                    </ul>

                    <a href="mapa.php" class="hero-cta">
                        <i data-lucide="map" size="20"></i>
                        Ver en el mapa
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Properties Section -->
    <section id="hospedajes" class="section-dark">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Alojamientos</div>
                <h2 class="section-title">Propiedades destacadas</h2>
                <p class="section-description">
                    Una selección cuidadosa de las mejores propiedades, todas verificadas por nuestro equipo local
                </p>
            </div>

            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider-track" id="sliderTrack">
                        <!-- Loading skeleton -->
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                    </div>
                </div>
                
                <div class="slider-controls-nav">
                    <button class="slider-nav prev" id="prevBtnProperties" onclick="slidePropertiesLeft()">
                        <i data-lucide="chevron-left" size="20"></i>
                    </button>
                    <button class="slider-nav next" id="nextBtnProperties" onclick="slidePropertiesRight()">
                        <i data-lucide="chevron-right" size="20"></i>
                    </button>
                </div>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="busqueda.php" class="hero-cta">
                    <i data-lucide="search" size="20"></i>
                    Ver todas las propiedades
                </a>
            </div>
        </div>
    </section>

    <!-- Activities Section -->
    <section id="actividades">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Descubre</div>
                <h2 class="section-title">Actividades en Villa Carlos Paz</h2>
                <p class="section-description">
                    Los mejores lugares para comer, visitar y disfrutar durante tu estadía
                </p>
            </div>

            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider-track" id="activitiesTrack">
                        <!-- Loading skeleton -->
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                        <div class="unified-card loading-skeleton" style="min-height: 400px;"></div>
                    </div>
                </div>
                
                <div class="slider-controls-nav">
                    <button class="slider-nav prev" id="prevBtnActivities" onclick="slideActivitiesLeft()">
                        <i data-lucide="chevron-left" size="20"></i>
                    </button>
                    <button class="slider-nav next" id="nextBtnActivities" onclick="slideActivitiesRight()">
                        <i data-lucide="chevron-right" size="20"></i>
                    </button>
                </div>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="actividades.php" class="hero-cta">
                    <i data-lucide="compass" size="20"></i>
                    Ver todas las actividades
                </a>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section id="mapa" class="section-dark">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-content">
                    <div class="section-label">Explora</div>
                    <h2>Descubre Villa Carlos Paz en el mapa</h2>
                    <p>
                        Visualiza todas las propiedades y lugares de interés en un mapa interactivo. Encuentra el hospedaje perfecto según su ubicación y descubre qué hay cerca.
                    </p>
                    
                    <ul class="trust-features">
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="map-pin" size="20"></i>
                            </div>
                            <div>
                                <strong>Ubicaciones exactas</strong><br>
                                Visualiza todas las propiedades y actividades disponibles
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="layers" size="20"></i>
                            </div>
                            <div>
                                <strong>Filtros inteligentes</strong><br>
                                Encuentra exactamente lo que buscas con filtros avanzados
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="navigation" size="20"></i>
                            </div>
                            <div>
                                <strong>Distancias precisas</strong><br>
                                Conoce las distancias a playas, centros y atracciones
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="eye" size="20"></i>
                            </div>
                            <div>
                                <strong>Vista satelital</strong><br>
                                Explora el entorno de cada propiedad en detalle
                            </div>
                        </li>
                    </ul>

                    <a href="mapa.php" class="hero-cta">
                        <i data-lucide="map" size="20"></i>
                        Abrir mapa interactivo
                    </a>
                </div>

                <div class="trust-visual">
                    <i data-lucide="map" size="120" style="color: var(--orange-primary); opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Section -->
    <section id="ia">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-visual">
                    <i data-lucide="sparkles" size="120" style="color: var(--orange-primary); opacity: 0.3;"></i>
                </div>

                <div class="trust-content">
                    <div class="section-label">Tecnología</div>
                    <h2>IA turística creada por locales</h2>
                    <p>
                        Optimiza tu visita con inteligencia artificial que conoce Villa Carlos Paz como la palma de su mano, desarrollada con el conocimiento de nuestro equipo local.
                    </p>
                    
                    <ul class="trust-features">
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="compass" size="20"></i>
                            </div>
                            <div>
                                <strong>Descubre lo auténtico</strong><br>
                                Actividades y lugares más allá de lo turístico
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="utensils" size="20"></i>
                            </div>
                            <div>
                                <strong>Gastronomía personalizada</strong><br>
                                Recomendaciones según tus gustos y presupuesto
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="navigation" size="20"></i>
                            </div>
                            <div>
                                <strong>Movilidad eficiente</strong><br>
                                Rutas, horarios y consejos de transporte actualizados
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="calendar" size="20"></i>
                            </div>
                            <div>
                                <strong>Eventos en tiempo real</strong><br>
                                Qué está pasando durante tu estadía
                            </div>
                        </li>
                    </ul>

                    <a href="#" class="hero-cta">
                        <i data-lucide="sparkles" size="20"></i>
                        Probar la IA turística
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section id="ayuda" class="section-dark">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-content">
                    <div class="section-label">Asistencia</div>
                    <h2>Te acompañamos en cada paso</h2>
                    <p>
                        No estás solo durante tu viaje. Nuestro equipo local te asiste desde la reserva hasta el check-out, garantizando una experiencia sin preocupaciones.
                    </p>
                    
                    <ul class="trust-features">
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="message-circle" size="20"></i>
                            </div>
                            <div>
                                <strong>Soporte 24/7 por WhatsApp</strong><br>
                                Respuesta inmediata a cualquier consulta o emergencia
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="key" size="20"></i>
                            </div>
                            <div>
                                <strong>Check-in personalizado</strong><br>
                                Te guiamos paso a paso para un ingreso sin complicaciones
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="map" size="20"></i>
                            </div>
                            <div>
                                <strong>Recomendaciones locales</strong><br>
                                Los mejores lugares que solo los locales conocen
                            </div>
                        </li>
                        <li>
                            <div class="trust-icon">
                                <i data-lucide="shield-check" size="20"></i>
                            </div>
                            <div>
                                <strong>Propiedades verificadas</strong><br>
                                Cada alojamiento es inspeccionado por nuestro equipo
                            </div>
                        </li>
                    </ul>

                    <a href="https://wa.me/5493541123456" class="hero-cta" target="_blank" rel="noopener">
                        <i data-lucide="phone" size="20"></i>
                        Contactar asistencia
                    </a>
                </div>

                <div class="trust-visual">
                    <i data-lucide="users" size="120" style="color: var(--orange-primary); opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">¿Listo para tu próxima aventura?</h2>
            <p class="cta-description">
                Encuentra el alojamiento perfecto y comienza a planificar tu escapada a Villa Carlos Paz
            </p>
            <a href="busqueda.php" class="cta-button">
                <i data-lucide="search" size="20"></i>
                Ver todas las propiedades
            </a>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <script>
        // Configuration
        const API_BASE = './api';
        const API_PROPERTIES = `${API_BASE}/properties`;
        const API_PLACES = `${API_BASE}/places`;

        // Initialize
        document.addEventListener('DOMContentLoaded', async function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            await loadProperties();
            await loadActivities();
            initializeHeroSlider();
            initializeScrollIndicator();
        });

        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');

        function initializeHeroSlider() {
            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 6000);

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });
        }

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        // Scroll Indicator
        function initializeScrollIndicator() {
            const scrollIndicator = document.getElementById('scrollIndicator');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    scrollIndicator?.classList.add('hidden');
                } else {
                    scrollIndicator?.classList.remove('hidden');
                }
            });
        }


    

        // Render Properties
        function renderProperties(properties) {
            const track = document.getElementById('sliderTrack');
            if (!track) return;

            const propertyCards = properties.map(property => createPropertyCard(property)).join('');
            const exploreCard = createExploreCard('busqueda.php', 'Ver todos los hospedajes');
            
            track.innerHTML = propertyCards + exploreCard;
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            updatePropertiesNavButtons();
        }

        // Create Property Card
        function createPropertyCard(property) {
            const typeIcons = {
                'casa': 'home',
                'departamento': 'building-2',
                'cabaña': 'mountain',
                'hotel': 'hotel',
                'hostel': 'users',
                'default': 'home'
            };

            const typeName = property.type?.name || 'Propiedad';
            const typeIcon = typeIcons[typeName.toLowerCase()] || typeIcons.default;
            const imageUrl = property.primary_image || '';
            const hasImage = imageUrl && imageUrl.length > 0;
            
            const bedrooms = property.features?.bedrooms || 0;
            const bathrooms = property.features?.bathrooms || 0;
            const maxGuests = property.features?.max_guests || 0;
            const priceRange = property.pricing?.price_range || 2;
            const rating = property.stats?.average_rating || 0;

            return `
                <div class="unified-card" onclick="location.href='propiedad.php?id=${property.id}'">
                    <div class="card-image">
                        ${hasImage ? 
                            `<img src="${imageUrl}" alt="${property.title}" loading="lazy">` : 
                            `<i data-lucide="${typeIcon}" size="56"></i>`
                        }
                        <button class="favorite-btn" onclick="event.stopPropagation(); toggleFavorite(${property.id})">
                            <i data-lucide="heart" size="20"></i>
                        </button>
                        ${rating > 0 ? `
                            <div class="card-rating-badge">
                                <div class="stars">
                                    <i data-lucide="star" size="12" fill="currentColor"></i>
                                </div>
                                <span class="rating-value">${rating.toFixed(1)}</span>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-content">
                        <div class="card-type">${typeName}</div>
                        <h3 class="card-title">${property.title}</h3>
                        <div class="card-features">
                            ${bedrooms ? `
                                <div class="feature">
                                    <i data-lucide="bed-double" size="14"></i>
                                    <span>${bedrooms}</span>
                                </div>
                            ` : ''}
                            ${bathrooms ? `
                                <div class="feature">
                                    <i data-lucide="bath" size="14"></i>
                                    <span>${bathrooms}</span>
                                </div>
                            ` : ''}
                            ${maxGuests ? `
                                <div class="feature">
                                    <i data-lucide="users" size="14"></i>
                                    <span>${maxGuests}</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="card-footer">
                            <div class="card-price-container">
                                ${renderPriceIcons(priceRange)}
                                <div class="price-label">${getPriceRangeLabel(priceRange)}</div>
                            </div>
                            <a href="propiedad.php?id=${property.id}" class="view-link" onclick="event.stopPropagation()">
                                Ver
                                <i data-lucide="arrow-right" size="14"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render Price Icons
        function renderPriceIcons(priceRange) {
            const totalIcons = 4;
            let icons = '<div class="price-icons">';
            
            for (let i = 1; i <= totalIcons; i++) {
                const className = i <= priceRange ? 'filled' : 'empty';
                icons += `<i data-lucide="dollar-sign" size="16" class="price-icon ${className}"></i>`;
            }
            
            icons += '</div>';
            return icons;
        }

        // Get Price Range Label
        function getPriceRangeLabel(priceRange) {
            const labels = {
                1: 'Hasta $50K',
                2: '$50K - $100K',
                3: '$100K - $150K',
                4: 'Más de $150K'
            };
            return labels[priceRange] || labels[2];
        }

        // Load Activities from API
        async function loadActivities() {
            try {
                const response = await fetch(`${API_PLACES}?status=active&featured=1&limit=6`);
                const data = await response.json();
                
                if (data.success && data.data) {
                    renderActivities(data.data);
                } else {
                    console.error('Error loading activities:', data);
                    renderActivitiesError();
                }
            } catch (error) {
                console.error('Error fetching activities:', error);
                renderActivitiesError();
            }
        }

        // Render Activities
        function renderActivities(activities) {
            const track = document.getElementById('activitiesTrack');
            if (!track) return;

            const activityCards = activities.map(activity => createActivityCard(activity)).join('');
            const exploreCard = createExploreCard('actividades.php', 'Ver todas las actividades');
            
            track.innerHTML = activityCards + exploreCard;
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            updateActivitiesNavButtons();
        }

        // Create Activity Card
        function createActivityCard(activity) {
            const categoryIcons = {
                'restaurant': 'utensils',
                'bar': 'beer',
                'nightlife': 'music',
                'attraction': 'map-pin',
                'beach': 'waves',
                'hiking': 'mountain',
                'shopping': 'shopping-bag',
                'service': 'info',
                'transport': 'bus',
                'default': 'map-pin'
            };

            const icon = categoryIcons[activity.category] || categoryIcons.default;
            const imageUrl = activity.image_url || '';
            const hasImage = imageUrl && imageUrl.length > 0;

            return `
                <div class="unified-card" onclick="location.href='actividad.php?slug=${activity.slug}'">
                    <div class="card-image">
                        ${hasImage ? 
                            `<img src="${imageUrl}" alt="${activity.name}" loading="lazy">` : 
                            `<i data-lucide="${icon}" size="56"></i>`
                        }
                        ${activity.rating > 0 ? `
                            <div class="card-rating-badge">
                                <div class="stars">
                                    <i data-lucide="star" size="12" fill="currentColor"></i>
                                </div>
                                <span class="rating-value">${activity.rating.toFixed(1)}</span>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-content">
                        <div class="card-type">${getCategoryLabel(activity.category)}</div>
                        <h3 class="card-title">${activity.name}</h3>
                        <div class="card-features">
                            ${activity.distance_from_center ? `
                                <div class="feature">
                                    <i data-lucide="map-pin" size="14"></i>
                                    <span>${activity.distance_from_center}km</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="card-footer">
                            <div class="card-price-container">
                                ${activity.price_range ? 
                                    renderPriceIcons(activity.price_range) : 
                                    '<span style="color: var(--gray-600); font-weight: 600; font-size: 0.875rem;">Gratis</span>'
                                }
                            </div>
                            <a href="actividad.php?slug=${activity.slug}" class="view-link" onclick="event.stopPropagation()">
                                Ver
                                <i data-lucide="arrow-right" size="14"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        // Get Category Label
        function getCategoryLabel(category) {
            const labels = {
                'restaurant': 'Restaurante',
                'bar': 'Bar',
                'nightlife': 'Vida Nocturna',
                'attraction': 'Atracción',
                'beach': 'Playa',
                'hiking': 'Trekking',
                'shopping': 'Compras',
                'service': 'Servicio',
                'transport': 'Transporte'
            };
            return labels[category] || 'Lugar';
        }

        // Create Explore Card
        function createExploreCard(href, text) {
            return `
                <div class="unified-card explore-card" onclick="location.href='${href}'">
                    <div class="explore-content">
                        <div class="explore-icon">
                            <i data-lucide="compass" size="64"></i>
                        </div>
                        <h3 class="explore-title">${text}</h3>
                        <p class="explore-description">
                            Descubre más opciones en Villa Carlos Paz
                        </p>
                        <a href="${href}" class="explore-button" onclick="event.stopPropagation()">
                            Ver todos
                            <i data-lucide="arrow-right" size="18"></i>
                        </a>
                    </div>
                </div>
            `;
        }

        // Error Handlers
        function renderPropertiesError() {
            const track = document.getElementById('sliderTrack');
            if (track) {
                track.innerHTML = `
                    <div style="padding: 2rem; text-align: center; color: var(--gray-600);">
                        <p>No se pudieron cargar las propiedades. Por favor, intenta nuevamente.</p>
                    </div>
                `;
            }
        }

        function renderActivitiesError() {
            const track = document.getElementById('activitiesTrack');
            if (track) {
                track.innerHTML = `
                    <div style="padding: 2rem; text-align: center; color: var(--gray-600);">
                        <p>No se pudieron cargar las actividades. Por favor, intenta nuevamente.</p>
                    </div>
                `;
            }
        }

        // Slider Navigation
        let currentPropertySlide = 0;
        let currentActivitySlide = 0;
        const cardWidth = 320 + 16;

        function slidePropertiesLeft() {
            if (currentPropertySlide > 0) {
                currentPropertySlide--;
                const track = document.getElementById('sliderTrack');
                track.style.transform = `translateX(-${currentPropertySlide * cardWidth}px)`;
                updatePropertiesNavButtons();
            }
        }

        function slidePropertiesRight() {
            const track = document.getElementById('sliderTrack');
            const maxSlide = Math.max(0, track.children.length - 4);
            
            if (currentPropertySlide < maxSlide) {
                currentPropertySlide++;
                track.style.transform = `translateX(-${currentPropertySlide * cardWidth}px)`;
                updatePropertiesNavButtons();
            }
        }

        function slideActivitiesLeft() {
            if (currentActivitySlide > 0) {
                currentActivitySlide--;
                const track = document.getElementById('activitiesTrack');
                track.style.transform = `translateX(-${currentActivitySlide * cardWidth}px)`;
                updateActivitiesNavButtons();
            }
        }

        function slideActivitiesRight() {
            const track = document.getElementById('activitiesTrack');
            const maxSlide = Math.max(0, track.children.length - 4);
            
            if (currentActivitySlide < maxSlide) {
                currentActivitySlide++;
                track.style.transform = `translateX(-${currentActivitySlide * cardWidth}px)`;
                updateActivitiesNavButtons();
            }
        }

        function updatePropertiesNavButtons() {
            const track = document.getElementById('sliderTrack');
            if (!track) return;
            
            const maxSlide = Math.max(0, track.children.length - 4);
            const prevBtn = document.getElementById('prevBtnProperties');
            const nextBtn = document.getElementById('nextBtnProperties');
            
            if (prevBtn) prevBtn.disabled = currentPropertySlide === 0;
            if (nextBtn) nextBtn.disabled = currentPropertySlide >= maxSlide;
        }

        function updateActivitiesNavButtons() {
            const track = document.getElementById('activitiesTrack');
            if (!track) return;
            
            const maxSlide = Math.max(0, track.children.length - 4);
            const prevBtn = document.getElementById('prevBtnActivities');
            const nextBtn = document.getElementById('nextBtnActivities');
            
            if (prevBtn) prevBtn.disabled = currentActivitySlide === 0;
            if (nextBtn) nextBtn.disabled = currentActivitySlide >= maxSlide;
        }

        // Favorite Toggle
        function toggleFavorite(id) {
            // TODO: Implement favorite functionality with localStorage or API
            console.log('Toggle favorite:', id);
        }

        // Responsive handling
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 1024) {
                const propertiesTrack = document.getElementById('sliderTrack');
                const activitiesTrack = document.getElementById('activitiesTrack');
                
                if (propertiesTrack) {
                    propertiesTrack.style.transform = 'translateX(0)';
                    currentPropertySlide = 0;
                }
                
                if (activitiesTrack) {
                    activitiesTrack.style.transform = 'translateX(0)';
                    currentActivitySlide = 0;
                }
            }
            updatePropertiesNavButtons();
            updateActivitiesNavButtons();
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>