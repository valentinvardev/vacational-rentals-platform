<?php
/**
 * RentaTurista - Activity/Place Detail Page
 * Displays detailed information about a place of interest
 */

// Get place slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: /actividades');
    exit;
}

// API configuration
$apiUrl = './api/places';
?>
<!DOCTYPE html>
<html lang="es-AR" prefix="og: https://ogp.me/ns#">
<head>
    <!-- Critical Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    
    <!-- SEO Meta Tags - Will be dynamically updated -->
    <title id="pageTitle">Cargando... - RentaTurista</title>
    <meta name="description" id="pageDescription" content="Descubre lugares increíbles en Villa Carlos Paz">
    <meta name="keywords" content="villa carlos paz, turismo, actividades">
    <meta name="author" content="RentaTurista">
    <meta name="robots" content="index, follow">
    <link rel="canonical" id="pageCanonical" href="https://rentaturista.com/actividad/<?php echo htmlspecialchars($slug); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="place">
    <meta property="og:url" id="ogUrl" content="https://rentaturista.com/actividad/<?php echo htmlspecialchars($slug); ?>">
    <meta property="og:title" id="ogTitle" content="RentaTurista">
    <meta property="og:description" id="ogDescription" content="Descubre lugares increíbles">
    <meta property="og:image" id="ogImage" content="https://rentaturista.com/img/default-place.jpg">

    <!-- Preloads -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//unpkg.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="" defer></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>

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
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
            --header-height: 80px;
            --topbar-height: 70px;
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
        }

        /* Loading State */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--gray-200);
            border-top-color: var(--orange-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-overlay.hidden {
            display: none;
        }

        /* Main Container */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }

        /* Top Bar - Fixed */
        .top-bar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            z-index: 100;
            transition: all 0.3s ease;
            height: var(--topbar-height);
            margin-top: -1px;
        }

        .top-bar.hidden {
            top: 60px;
            transform: translateY(-100%);
        }

        .top-bar-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: var(--gray-900);
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 0.75rem 0.875rem;
            border-radius: 8px;
        }

        .back-btn:hover {
            background: var(--gray-100);
        }

        .top-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-300);
            color: var(--gray-900);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--gray-50);
            border-color: var(--gray-900);
        }

        .action-btn.saved i {
            fill: #EF4444;
            color: #EF4444;
        }

        /* Gallery Section - Full Width */
        .gallery-section {
            margin-top: calc(var(--header-height) + var(--topbar-height));
            margin-bottom: 3rem;
            width: 100%;
            padding: 0;
        }

        .gallery-section .main-container {
            max-width: 100%;
            padding: 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.5rem;
            height: 480px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .gallery-main {
            grid-column: 1;
            grid-row: 1 / 3;
            position: relative;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .gallery-item {
            position: relative;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            overflow: hidden;
        }

        .gallery-item img,
        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-grid:hover .gallery-item img,
        .gallery-grid:hover .gallery-main img {
            transform: scale(1.05);
        }

        .show-all-photos {
            position: absolute;
            bottom: 1.5rem;
            right: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-900);
            color: var(--gray-900);
            padding: 0.625rem 1rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
        }

        .show-all-photos:hover {
            background: var(--gray-50);
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 5rem;
            margin-bottom: 3rem;
            align-items: start;
        }

        /* Main Content */
        .main-content {
            max-width: 100%;
        }

        /* Activity Header */
        .activity-header {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .activity-category-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .activity-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .activity-subtitle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            color: var(--gray-700);
            font-size: 0.9375rem;
        }

        .subtitle-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .rating-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-weight: 600;
        }

        .rating-badge i {
            color: var(--orange-primary);
            width: 16px;
            height: 16px;
        }

        .separator {
            color: var(--gray-400);
        }

        /* Quick Info Cards */
        .quick-info-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .quick-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .info-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
        }

        .info-card-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-card-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .info-card-detail {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        /* Price Display */
        .price-icons-grid {
            display: flex;
            align-items: center;
            gap: 0.125rem;
            margin-top: 0.25rem;
        }

        .price-icon-small {
            width: 16px;
            height: 16px;
            color: var(--orange-primary);
        }

        .price-icon-small.filled {
            opacity: 1;
        }

        .price-icon-small.empty {
            opacity: 0.25;
        }

        /* Section Question Style */
        .section-question {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .section-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
        }

        .section-description {
            font-size: 0.9375rem;
            line-height: 1.7;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.5rem 0;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            min-width: 24px;
            color: var(--orange-primary);
        }

        .feature-text {
            font-size: 0.9375rem;
            color: var(--gray-900);
            font-weight: 500;
        }

        /* Operating Hours */
        .hours-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: var(--gray-50);
            border-radius: 8px;
        }

        .hours-day {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .hours-time {
            font-size: 0.9375rem;
            color: var(--gray-700);
        }

        .hours-item.today {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid var(--orange-primary);
        }

        .hours-item.today .hours-day {
            color: var(--orange-primary);
        }

        /* Google Reviews Section */
        .reviews-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .reviews-summary {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .reviews-rating-large {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
        }

        .rating-stars-large {
            display: flex;
            gap: 0.25rem;
        }

        .rating-stars-large i {
            color: #FFA500;
            width: 20px;
            height: 20px;
        }

        .reviews-count-text {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 0.25rem;
        }

        .google-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-300);
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .google-icon {
            width: 20px;
            height: 20px;
        }

        .google-text {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gray-700);
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .review-card {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding: 1.5rem;
            background: var(--gray-50);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
        }

        .review-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .reviewer-avatar {
            width: 44px;
            height: 44px;
            min-width: 44px;
            background: linear-gradient(135deg, #4285F4 0%, #34A853 100%);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .reviewer-info {
            flex: 1;
        }

        .reviewer-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .reviewer-name {
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--gray-900);
        }

        .reviewer-local-guide {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: var(--gray-600);
            margin-top: 0.125rem;
        }

        .reviewer-local-guide i {
            width: 12px;
            height: 12px;
            color: #4285F4;
        }

        .review-date {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .review-stars {
            display: flex;
            gap: 0.125rem;
            margin-bottom: 0.5rem;
        }

        .review-stars i {
            color: #FFA500;
            width: 14px;
            height: 14px;
        }

        .review-text {
            font-size: 0.9375rem;
            line-height: 1.6;
            color: var(--gray-700);
        }

        .show-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-900);
            color: var(--gray-900);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }

        .show-more-btn:hover {
            background: var(--gray-50);
        }

        /* Similar Activities Section */
        .similar-section {
            padding: 3rem 0;
            background: var(--gray-50);
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .similar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }

        .section-header-inline {
            margin-bottom: 2rem;
        }

        .section-label {
            display: inline-block;
            color: var(--orange-primary);
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .slider-container {
            position: relative;
        }

        .slider-wrapper {
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            gap: 1rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .activity-card {
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

        .activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .activity-image {
            position: relative;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .activity-image > i {
            color: rgba(255, 255, 255, 0.6);
        }

        .activity-rating-badge {
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
        }

        .rating-value {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .activity-content {
            padding: 1.25rem;
        }

        .activity-type {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.375rem;
        }

        .activity-card-title {
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

        .activity-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-700);
            font-size: 0.8125rem;
        }

        .meta-item i {
            color: var(--gray-500);
        }

        .activity-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-price-display {
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
            opacity: 0.25;
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

        /* Map Section */
        .location-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .location-icon-wrapper {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .location-details {
            flex: 1;
        }

        .location-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.125rem;
        }

        .location-address {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .map-preview {
            width: 100%;
            height: 400px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .map-preview #activityMap {
            width: 100%;
            height: 100%;
        }

        .map-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-900);
            color: var(--gray-900);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .map-btn:hover {
            background: var(--gray-50);
        }

        .map-btn.primary {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: var(--white);
        }

        .map-btn.primary:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
        }

        /* Sticky Info Sidebar */
        .info-sidebar {
            position: sticky;
            top: calc(var(--header-height) + var(--topbar-height) + 20px);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            align-self: start;
        }

        .sidebar-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .sidebar-price {
            margin-bottom: 1rem;
        }

        .price-label-sidebar {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .price-display-sidebar {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .contact-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .primary-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }

        .primary-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.3);
        }

        .secondary-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-900);
            color: var(--gray-900);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
        }

        .secondary-cta:hover {
            background: var(--gray-50);
        }

        .sidebar-note {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
        }

        .sidebar-note i {
            width: 14px;
            height: 14px;
            color: var(--orange-primary);
        }

        /* Mobile Bottom Bar */
        .mobile-bottom-bar {
            display: none;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            :root {
                --topbar-height: 60px;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .info-sidebar {
                display: none;
            }

            .mobile-bottom-bar {
                display: block;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: var(--white);
                border-top: 1px solid var(--gray-200);
                padding: 1rem 1.5rem;
                z-index: 98;
                box-shadow: 0 -2px 12px rgba(0, 0, 0, 0.08);
            }

            .mobile-bottom-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
            }

            .mobile-info {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .mobile-price {
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            .mobile-cta {
                background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
                color: var(--white);
                padding: 0.875rem 1.75rem;
                border: none;
                border-radius: 8px;
                font-family: var(--font-primary);
                font-weight: 600;
                font-size: 0.9375rem;
                cursor: pointer;
                white-space: nowrap;
                text-decoration: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            :root {
                --header-height: 60px;
                --topbar-height: 56px;
            }

            .main-container {
                padding: 0 1.5rem;
            }

            .top-bar-content {
                padding: 0 1.5rem;
            }

            .gallery-grid {
                display: block;
                height: 360px;
                position: relative;
            }

            .gallery-main {
                width: 100%;
                height: 100%;
            }

            .activity-title {
                font-size: 1.5rem;
            }

            .quick-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <?php include './includes/header.php'; ?>

    <!-- Top Bar -->
    <div class="top-bar" id="topBar">
        <div class="top-bar-content">
            <button class="back-btn" onclick="window.history.back()">
                <i data-lucide="chevron-left" size="20"></i>
                <span>Volver</span>
            </button>
            
            <div class="top-actions">
                <button class="action-btn desktop-only" id="shareBtn" onclick="shareActivity()">
                    <i data-lucide="share-2" size="16"></i>
                    <span>Compartir</span>
                </button>
                <button class="action-btn desktop-only" id="saveBtn" onclick="toggleSave('saveBtn')">
                    <i data-lucide="heart" size="16"></i>
                    <span>Guardar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="main-container">
            <div class="gallery-grid">
                <div class="gallery-main" id="galleryMain">
                    <i data-lucide="map-pin" size="80" id="placeholderIcon"></i>
                </div>
                <div class="gallery-item">
                    <i data-lucide="image" size="48"></i>
                </div>
                <div class="gallery-item">
                    <i data-lucide="image" size="48"></i>
                </div>
                <div class="gallery-item">
                    <i data-lucide="image" size="48"></i>
                </div>
                <div class="gallery-item">
                    <i data-lucide="image" size="48"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-grid">
            <!-- Left Column -->
            <div class="main-content">
                <!-- Activity Header -->
                <div class="activity-header">
                    <div class="activity-category-badge" id="categoryBadge">
                        <i data-lucide="map-pin" size="16"></i>
                        <span>Cargando...</span>
                    </div>
                    <h1 class="activity-title" id="activityTitle">Cargando...</h1>
                    <div class="activity-subtitle" id="activitySubtitle">
                        <div class="subtitle-item">
                            <i data-lucide="map-pin" size="14"></i>
                            <span>Villa Carlos Paz</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="quick-info-section">
                    <div class="quick-info-grid" id="quickInfoGrid">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>

                <!-- About -->
                <div class="section-question" id="aboutSection">
                    <h2 class="section-title">Acerca de este lugar</h2>
                    <p class="section-description" id="placeDescription">Cargando información...</p>
                </div>

                <!-- Features (if available) -->
                <div class="section-question" id="featuresSection" style="display: none;">
                    <h2 class="section-title">Servicios y comodidades</h2>
                    <div class="features-grid" id="featuresGrid">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>

                <!-- Operating Hours (if available) -->
                <div class="section-question" id="hoursSection" style="display: none;">
                    <h2 class="section-title">Horarios de atención</h2>
                    <div class="hours-list" id="hoursList">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>

                <!-- Location -->
                <div class="section-question">
                    <h2 class="section-title">Ubicación</h2>
                    <div class="location-header">
                        <div class="location-icon-wrapper">
                            <i data-lucide="map-pin" size="20"></i>
                        </div>
                        <div class="location-details">
                            <div class="location-name" id="locationName">Cargando...</div>
                            <div class="location-address" id="locationAddress">Villa Carlos Paz</div>
                        </div>
                    </div>
                    <div class="map-preview">
                        <div id="activityMap"></div>
                    </div>
                    <div class="map-actions" id="mapActions">
                        <!-- Will be populated dynamically -->
                    </div>
                </div>

                <!-- Google Reviews (if available) -->
                <div class="section-question" id="reviewsSection" style="display: none;">
                    <div class="reviews-header">
                        <div class="reviews-summary">
                            <div class="reviews-rating-large">
                                <div class="rating-number" id="ratingNumber">0.0</div>
                                <div class="rating-stars-large" id="ratingStarsLarge">
                                    <!-- Stars will be populated -->
                                </div>
                                <div class="reviews-count-text" id="reviewsCountText">0 reseñas</div>
                            </div>
                        </div>
                        <div class="google-badge">
                            <svg class="google-icon" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="google-text">Reseñas de Google</span>
                        </div>
                    </div>
                    
                    <div class="reviews-grid" id="reviewsGrid">
                        <!-- Reviews will be populated dynamically -->
                    </div>

                    <button class="show-more-btn" id="showMoreReviewsBtn" style="display: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" style="fill: none; stroke: currentColor; stroke-width: 2;">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Ver todas las reseñas en Google</span>
                    </button>
                </div>
            </div>

            <!-- Right Column - Info Sidebar (Desktop only) -->
            <aside class="info-sidebar" id="infoSidebar">
                <!-- Will be populated dynamically -->
            </aside>
        </div>
    </div>

    <!-- Similar Activities -->
    <section class="similar-section" id="similarSection">
        <div class="similar-inner">
            <div class="section-header-inline">
                <div class="section-label">Descubre más</div>
                <h2 class="section-title">Actividades similares</h2>
            </div>

            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider-track" id="similarTrack">
                        <!-- Similar activities will be loaded dynamically -->
                    </div>
                </div>

                <div class="slider-controls-nav">
                    <button class="slider-nav" id="prevBtn" onclick="slideLeft()">
                        <i data-lucide="chevron-left" size="20"></i>
                    </button>
                    <button class="slider-nav" id="nextBtn" onclick="slideRight()">
                        <i data-lucide="chevron-right" size="20"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Bottom Bar -->
    <div class="mobile-bottom-bar" id="mobileBottomBar">
        <!-- Will be populated dynamically -->
    </div>

    <?php include './includes/footer.php'; ?>

    <script>
        const PLACE_SLUG = '<?php echo htmlspecialchars($slug); ?>';
        const API_URL = '/api/places';
        let activityMap;
        let placeData = null;

        // Category translations and icons
        const categoryConfig = {
            restaurant: { label: 'Restaurante', icon: 'utensils' },
            bar: { label: 'Bar', icon: 'beer' },
            nightlife: { label: 'Vida Nocturna', icon: 'music' },
            attraction: { label: 'Atracción', icon: 'map-pin' },
            beach: { label: 'Playa', icon: 'waves' },
            hiking: { label: 'Trekking', icon: 'mountain' },
            shopping: { label: 'Compras', icon: 'shopping-bag' },
            service: { label: 'Servicio', icon: 'info' },
            transport: { label: 'Transporte', icon: 'bus' },
            other: { label: 'Otro', icon: 'map' }
        };

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            loadPlaceData();
        });

        // Load place data from API
        async function loadPlaceData() {
            try {
                const response = await fetch(`${API_URL}?search=${PLACE_SLUG}`);
                const result = await response.json();
                
                if (!result.success || result.data.length === 0) {
                    window.location.href = '/404';
                    return;
                }
                
                placeData = result.data[0];
                renderPlace(placeData);
                
                document.getElementById('loadingOverlay').classList.add('hidden');
            } catch (error) {
                console.error('Error loading place:', error);
                alert('Error al cargar el lugar');
                document.getElementById('loadingOverlay').classList.add('hidden');
            }
        }

        // Render place data
        function renderPlace(place) {
            // Update SEO meta tags
            document.getElementById('pageTitle').textContent = `${place.name} - RentaTurista | Villa Carlos Paz`;
            document.getElementById('pageDescription').setAttribute('content', place.description || `Descubre ${place.name} en Villa Carlos Paz`);
            document.getElementById('ogTitle').setAttribute('content', place.name);
            document.getElementById('ogDescription').setAttribute('content', place.description || `Descubre ${place.name}`);
            
            // Category badge
            const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
            document.getElementById('categoryBadge').innerHTML = `
                <i data-lucide="${categoryInfo.icon}" size="16"></i>
                <span>${categoryInfo.label}</span>
            `;
            
            // Title
            document.getElementById('activityTitle').textContent = place.name;
            
            // Subtitle
            let subtitleHTML = '';
            if (place.rating > 0) {
                subtitleHTML += `
                    <div class="subtitle-item rating-badge">
                        <i data-lucide="star" size="16" style="fill: currentColor;"></i>
                        <span>${place.rating.toFixed(1)}</span>
                    </div>
                    <span class="separator">·</span>
                `;
            }
            subtitleHTML += `
                <div class="subtitle-item">
                    <i data-lucide="map-pin" size="14"></i>
                    <span>${place.address || place.city}</span>
                </div>
            `;
            document.getElementById('activitySubtitle').innerHTML = subtitleHTML;
            
            // Gallery icon
            document.getElementById('placeholderIcon').setAttribute('data-lucide', categoryInfo.icon);
            
            // Quick info cards
            let quickInfoHTML = '';
            
            // Price range
            if (place.price_range) {
                const priceIcons = Array(4).fill(0).map((_, i) => {
                    const filled = i < place.price_range ? 'filled' : 'empty';
                    return `<i data-lucide="dollar-sign" size="16" class="price-icon-small ${filled}"></i>`;
                }).join('');
                
                const priceLabels = ['', 'Económico', 'Moderado', 'Alto', 'Lujo'];
                quickInfoHTML += `
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i data-lucide="wallet" size="20"></i>
                        </div>
                        <div class="info-card-label">Rango de precio</div>
                        <div class="price-icons-grid">${priceIcons}</div>
                        <div class="info-card-detail">${priceLabels[place.price_range]}</div>
                    </div>
                `;
            }
            
            // Distance
            if (place.distance_from_center) {
                quickInfoHTML += `
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i data-lucide="map-pin" size="20"></i>
                        </div>
                        <div class="info-card-label">Distancia</div>
                        <div class="info-card-value">${place.distance_from_center} km</div>
                        <div class="info-card-detail">Del centro</div>
                    </div>
                `;
            }
            
            // Phone
            if (place.phone) {
                quickInfoHTML += `
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i data-lucide="phone" size="20"></i>
                        </div>
                        <div class="info-card-label">Teléfono</div>
                        <div class="info-card-value">${place.phone}</div>
                        <div class="info-card-detail">
                            <a href="tel:${place.phone}" style="color: var(--orange-primary); text-decoration: none;">Llamar ahora</a>
                        </div>
                    </div>
                `;
            }
            
            // Website
            if (place.website) {
                quickInfoHTML += `
                    <div class="info-card">
                        <div class="info-card-icon">
                            <i data-lucide="globe" size="20"></i>
                        </div>
                        <div class="info-card-label">Sitio web</div>
                        <div class="info-card-detail">
                            <a href="${place.website}" target="_blank" style="color: var(--orange-primary); text-decoration: none;">Visitar sitio</a>
                        </div>
                    </div>
                `;
            }
            
            document.getElementById('quickInfoGrid').innerHTML = quickInfoHTML;
            
            // Description
            if (place.description) {
                document.getElementById('placeDescription').textContent = place.description;
            } else {
                document.getElementById('aboutSection').style.display = 'none';
            }
            
            // Location
            document.getElementById('locationName').textContent = place.name;
            document.getElementById('locationAddress').textContent = place.address || place.city;
            
            // Map actions
            let mapActionsHTML = '';
            if (place.latitude && place.longitude) {
                mapActionsHTML = `
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" 
                       target="_blank" 
                       class="map-btn primary">
                        <i data-lucide="navigation" size="18"></i>
                        Cómo llegar
                    </a>
                `;
            }
            if (place.website) {
                mapActionsHTML += `
                    <a href="${place.website}" 
                       target="_blank" 
                       class="map-btn">
                        <i data-lucide="external-link" size="18"></i>
                        Sitio web
                    </a>
                `;
            }
            document.getElementById('mapActions').innerHTML = mapActionsHTML;
            
            // Sidebar
            renderSidebar(place);
            
            // Mobile bottom bar
            renderMobileBar(place);
            
            // Initialize map
            if (place.latitude && place.longitude) {
                initMap(place.latitude, place.longitude, place.name);
            }
            
            // Load similar places
            loadSimilarPlaces(place.id, place.category);
            
            // Re-initialize Lucide icons
            lucide.createIcons();
        }

        // Render sidebar
        function renderSidebar(place) {
            let sidebarHTML = '<div class="sidebar-header">';
            
            // Price
            if (place.price_range) {
                const priceIcons = Array(4).fill(0).map((_, i) => {
                    const filled = i < place.price_range ? 'filled' : 'empty';
                    return `<i data-lucide="dollar-sign" size="20" class="price-icon ${filled}"></i>`;
                }).join('');
                
                sidebarHTML += `
                    <div class="sidebar-price">
                        <div class="price-label-sidebar">Rango de precio</div>
                        <div class="price-display-sidebar">${priceIcons}</div>
                    </div>
                `;
            }
            
            sidebarHTML += '</div><div class="contact-actions">';
            
            // WhatsApp button
            if (place.phone) {
                const phoneClean = place.phone.replace(/[^0-9]/g, '');
                sidebarHTML += `
                    <a href="https://wa.me/549${phoneClean}?text=Hola%2C%20vi%20${encodeURIComponent(place.name)}%20en%20RentaTurista" 
                       class="primary-cta" 
                       target="_blank" 
                       rel="noopener">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516"/>
                        </svg>
                        Contactar por WhatsApp
                    </a>
                `;
            }
            
            // Phone button
            if (place.phone) {
                sidebarHTML += `
                    <a href="tel:${place.phone}" class="secondary-cta">
                        <i data-lucide="phone" size="18"></i>
                        Llamar ahora
                    </a>
                `;
            }
            
            // Directions button
            if (place.latitude && place.longitude) {
                sidebarHTML += `
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" 
                       target="_blank" 
                       class="secondary-cta">
                        <i data-lucide="navigation" size="18"></i>
                        Cómo llegar
                    </a>
                `;
            }
            
            sidebarHTML += '</div>';
            
            document.getElementById('infoSidebar').innerHTML = sidebarHTML;
        }

        // Render mobile bar
        function renderMobileBar(place) {
            let mobileHTML = '<div class="mobile-bottom-content"><div class="mobile-info">';
            
            if (place.price_range) {
                const priceIcons = Array(4).fill(0).map((_, i) => {
                    const filled = i < place.price_range ? 'filled' : 'empty';
                    return `<i data-lucide="dollar-sign" size="18" class="price-icon ${filled}"></i>`;
                }).join('');
                
                mobileHTML += `<div class="mobile-price">${priceIcons}</div>`;
            }
            
            mobileHTML += '</div>';
            
            // CTA button
            if (place.phone) {
                const phoneClean = place.phone.replace(/[^0-9]/g, '');
                mobileHTML += `
                    <a href="https://wa.me/549${phoneClean}?text=Hola%2C%20vi%20${encodeURIComponent(place.name)}%20en%20RentaTurista" 
                       class="mobile-cta" 
                       target="_blank" 
                       rel="noopener">
                        Contactar
                    </a>
                `;
            } else if (place.latitude && place.longitude) {
                mobileHTML += `
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" 
                       class="mobile-cta" 
                       target="_blank">
                        Cómo llegar
                    </a>
                `;
            }
            
            mobileHTML += '</div>';
            
            document.getElementById('mobileBottomBar').innerHTML = mobileHTML;
        }

        // Initialize map
        function initMap(lat, lng, name) {
            activityMap = L.map('activityMap').setView([lat, lng], 16);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(activityMap);

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: linear-gradient(135deg, #FF6B35 0%, #E55527 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);"><i data-lucide="map-pin" size="20" style="color: white; transform: rotate(45deg);"></i></div>',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            L.marker([lat, lng], { icon: customIcon })
                .addTo(activityMap)
                .bindPopup(`
                    <div style="text-align: center; padding: 8px;">
                        <strong>${name}</strong>
                    </div>
                `);
            
            setTimeout(() => lucide.createIcons(), 100);
        }

        // Load similar places
        async function loadSimilarPlaces(currentPlaceId, category) {
            try {
                const response = await fetch(`${API_URL}?category=${category}&limit=20`);
                const result = await response.json();
                
                if (!result.success || result.data.length === 0) {
                    document.getElementById('similarSection').style.display = 'none';
                    return;
                }
                
                // Filter out current place and limit to 8
                const similarPlaces = result.data
                    .filter(p => p.id !== currentPlaceId)
                    .slice(0, 8);
                
                if (similarPlaces.length === 0) {
                    document.getElementById('similarSection').style.display = 'none';
                    return;
                }
                
                const track = document.getElementById('similarTrack');
                track.innerHTML = similarPlaces.map(place => {
                    const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
                    const priceIcons = place.price_range ? Array(4).fill(0).map((_, i) => {
                        const filled = i < place.price_range ? 'filled' : 'empty';
                        return `<i data-lucide="dollar-sign" size="16" class="price-icon ${filled}"></i>`;
                    }).join('') : '';
                    
                    return `
                        <div class="activity-card" onclick="window.location.href='/actividad.php?slug=${place.slug}'">
                            <div class="activity-image">
                                <i data-lucide="${place.icon || categoryInfo.icon}" size="56"></i>
                                ${place.rating > 0 ? `
                                    <div class="activity-rating-badge">
                                        <span class="stars">★</span>
                                        <span class="rating-value">${place.rating.toFixed(1)}</span>
                                    </div>
                                ` : ''}
                            </div>
                            <div class="activity-content">
                                <div class="activity-type">${categoryInfo.label}</div>
                                <h3 class="activity-card-title">${place.name}</h3>
                                <div class="activity-meta">
                                    ${place.distance_from_center ? `
                                        <div class="meta-item">
                                            <i data-lucide="map-pin" size="14"></i>
                                            <span>${place.distance_from_center}km</span>
                                        </div>
                                    ` : ''}
                                    ${place.phone ? `
                                        <div class="meta-item">
                                            <i data-lucide="phone" size="14"></i>
                                            <span>Teléfono</span>
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="activity-footer">
                                    ${priceIcons ? `
                                        <div class="activity-price-display">
                                            <div class="price-icons">${priceIcons}</div>
                                        </div>
                                    ` : '<div></div>'}
                                    <a href="/actividad.php?slug=${place.slug}" class="view-link">
                                        Ver más
                                        <i data-lucide="arrow-right" size="14"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                lucide.createIcons();
                updateSliderNav();
            } catch (error) {
                console.error('Error loading similar places:', error);
                document.getElementById('similarSection').style.display = 'none';
            }
        }

        // Similar Activities Slider
        let currentSlide = 0;
        const cardWidth = 320 + 16; // card width + gap

        function updateSliderNav() {
            const track = document.getElementById('similarTrack');
            const maxSlide = Math.max(0, track.children.length - 3);
            
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            if (prevBtn) prevBtn.disabled = currentSlide === 0;
            if (nextBtn) nextBtn.disabled = currentSlide >= maxSlide;
        }

        function slideLeft() {
            if (currentSlide > 0) {
                currentSlide--;
                const track = document.getElementById('similarTrack');
                track.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
                updateSliderNav();
            }
        }

        function slideRight() {
            const track = document.getElementById('similarTrack');
            const maxSlide = Math.max(0, track.children.length - 3);
            
            if (currentSlide < maxSlide) {
                currentSlide++;
                track.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
                updateSliderNav();
            }
        }

        // Reset slider on resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 1024) {
                const track = document.getElementById('similarTrack');
                if (track) {
                    track.style.transform = 'translateX(0)';
                    currentSlide = 0;
                }
            }
            updateSliderNav();
        });

        // Scroll behavior for top bar
        let lastScroll = 0;
        let isScrollingDown = false;
        const topBar = document.getElementById('topBar');
        const scrollThreshold = 10;

        window.addEventListener('load', () => {
            topBar.classList.remove('hidden');
        });

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (Math.abs(currentScroll - lastScroll) < scrollThreshold) {
                return;
            }
            
            if (currentScroll > lastScroll && currentScroll > 100) {
                if (!isScrollingDown) {
                    topBar.classList.add('hidden');
                    isScrollingDown = true;
                }
            } else {
                if (isScrollingDown || currentScroll <= 100) {
                    topBar.classList.remove('hidden');
                    isScrollingDown = false;
                }
            }
            
            lastScroll = currentScroll;
        });

        // Share functionality
        function shareActivity() {
            if (navigator.share && placeData) {
                navigator.share({
                    title: placeData.name,
                    text: `Mira ${placeData.name} en Villa Carlos Paz`,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('¡Link copiado al portapapeles!');
                });
            }
        }

        // Save functionality
        function toggleSave(btnId) {
            const btn = document.getElementById(btnId);
            const icon = btn.querySelector('i');
            
            if (btn.classList.contains('saved')) {
                btn.classList.remove('saved');
                icon.style.fill = 'none';
            } else {
                btn.classList.add('saved');
                icon.style.fill = 'currentColor';
                icon.style.color = '#EF4444';
            }
            
            lucide.createIcons();
        }
    </script>
</body>
</html>