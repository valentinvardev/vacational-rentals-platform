<?php
// Get property ID from URL parameter
$propertyId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($propertyId === 0) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es-AR" prefix="og: https://ogp.me/ns#">
<head>
    <!-- Critical Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    
    <!-- SEO Meta Tags - Will be updated dynamically -->
    <title id="pageTitle">Cargando... - RentaTurista</title>
    <meta name="description" id="pageDescription" content="Alquiler vacacional en Villa Carlos Paz">
    <meta name="robots" content="index, follow">
    
    <!-- Preloads -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
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
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            flex-direction: column;
            gap: 1rem;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--gray-200);
            border-top-color: var(--orange-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            color: var(--gray-600);
            font-size: 0.9375rem;
        }

        .error-container {
            max-width: 600px;
            margin: 4rem auto;
            padding: 2rem;
            text-align: center;
        }

        .error-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            color: var(--orange-primary);
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .error-message {
            color: var(--gray-600);
            margin-bottom: 2rem;
        }

        /* Main Container */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }

        /* Gallery Section */
        .gallery-section {
            margin-top: var(--header-height);
            margin-bottom: 3rem;
            position: relative;
        }

        .gallery-container {
            position: relative;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }

        .gallery-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            margin-bottom: 1rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--gray-300);
            color: var(--gray-900);
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }

        .back-btn:hover {
            background: var(--gray-50);
            border-color: var(--gray-900);
        }

        .gallery-actions {
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

        .gallery-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.5rem;
            height: 480px;
            overflow: hidden;
            border-radius: 12px;
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
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item {
            position: relative;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item img,
        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-main:hover img {
            transform: scale(1.05);
        }

        .gallery-item:hover img {
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

        /* Mobile Gallery */
        .mobile-gallery {
            display: none;
        }

        .mobile-gallery-slider {
            position: relative;
            width: 100%;
            height: 360px;
            overflow: hidden;
        }

        .mobile-gallery-track {
            display: flex;
            height: 100%;
            transition: transform 0.3s ease-out;
        }

        .mobile-gallery-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-gallery-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-gallery-controls {
            position: absolute;
            top: 1rem;
            left: 0;
            right: 0;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0 1rem;
        }

        .mobile-back-btn {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: var(--gray-900);
        }

        .mobile-gallery-actions {
            display: flex;
            gap: 0.5rem;
        }

        .gallery-action-btn {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-gallery-nav {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: 15;
        }

        .mobile-nav-btn {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .mobile-nav-btn svg,
        .mobile-nav-btn i {
            color: var(--white) !important;
            stroke: var(--white) !important;
        }

        .mobile-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .mobile-show-photos-btn {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            color: var(--gray-900);
            padding: 0.625rem 1rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            z-index: 15;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-show-photos-btn.visible {
            opacity: 1;
            visibility: visible;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 5rem;
            margin-bottom: 3rem;
            align-items: start;
        }

        .main-content {
            max-width: 100%;
        }

        /* Property Header */
        .property-header {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .property-title {
            font-size: 1.625rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .property-subtitle {
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

        /* Benefits Section */
        .benefits-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .benefit-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .benefit-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
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
            line-height: 1.6;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        /* Amenities Grid */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .amenity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.5rem 0;
        }

        .amenity-icon {
            width: 24px;
            height: 24px;
            min-width: 24px;
            color: var(--gray-700);
        }

        .amenity-text {
            font-size: 0.9375rem;
            color: var(--gray-900);
        }

        .amenity-description {
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-top: 0.125rem;
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
            margin-top: 1.5rem;
        }

        .show-more-btn:hover {
            background: var(--gray-50);
        }

        /* Map Section */
        .location-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .location-icon {
            width: 24px;
            height: 24px;
            color: var(--orange-primary);
        }

        .location-text {
            font-size: 0.9375rem;
            color: var(--gray-900);
            font-weight: 600;
        }

        .map-preview {
            width: 100%;
            height: 360px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .map-preview #propertyMap {
            width: 100%;
            height: 100%;
        }

        /* Reviews */
        .reviews-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .reviews-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 1.375rem;
            font-weight: 600;
        }

        .reviews-rating i {
            color: var(--orange-primary);
            width: 24px;
            height: 24px;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .review-card {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .review-header {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .reviewer-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
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

        .review-date {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .review-stars {
            display: flex;
            gap: 0.125rem;
        }

        .review-stars i {
            color: var(--orange-primary);
            width: 12px;
            height: 12px;
        }

        .review-text {
            font-size: 0.9375rem;
            line-height: 1.6;
            color: var(--gray-700);
        }

        /* Video Section */
        .video-section {
            margin-bottom: 2rem;
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            border-radius: 12px;
            overflow: hidden;
            background: var(--gray-200);
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Booking Card */
        .booking-card {
            position: sticky;
            top: calc(var(--header-height) + 20px);
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            align-self: start;
        }

        .booking-header {
            margin-bottom: 1.5rem;
        }

        .price-display {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            margin-bottom: 0.25rem;
        }

        .price-symbols {
            display: flex;
            align-items: center;
            gap: 0.125rem;
        }

        .price-icon {
            width: 20px;
            height: 20px;
            color: var(--orange-primary);
        }

        .price-icon.filled {
            opacity: 1;
        }

        .price-icon.empty {
            opacity: 0.25;
        }

        .price-range {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .contact-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .quick-response {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-bottom: 0.25rem;
        }

        .quick-response i {
            width: 16px;
            height: 16px;
            color: var(--orange-primary);
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

        .secondary-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
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

        .booking-note {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            text-align: center;
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        /* Similar Properties */
        .similar-properties {
            padding: 3rem 0;
            background: var(--gray-50);
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .similar-properties-inner {
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
            height: 200px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .property-image > i {
            color: rgba(255, 255, 255, 0.6);
        }

        .property-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            text-transform: capitalize;
        }

        .property-card-title {
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

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            overflow-y: auto;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--white);
            border-radius: 12px;
            max-width: 1000px;
            width: 100%;
            position: relative;
            margin: 2rem auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            position: sticky;
            top: 0;
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close {
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
        }

        .modal-close:hover {
            background: var(--gray-100);
        }

        .modal-body {
            padding: 2rem;
        }

        /* Gallery Modal */
        .gallery-modal .modal-content {
            max-width: 1400px;
        }

        .gallery-grid-modal {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1rem;
        }

        .gallery-item-modal {
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .gallery-item-modal:hover {
            transform: scale(1.02);
        }

        .gallery-item-modal i {
            color: var(--gray-500);
        }

        .gallery-item-modal img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Lightbox Modal */
        .lightbox-modal {
            background: rgba(255, 255, 255, 0.98);
        }

        .lightbox-modal .modal-content {
            max-width: 100%;
            width: 100%;
            min-height: 100vh;
            margin: 0;
            border-radius: 0;
            background: var(--white);
            display: flex;
            flex-direction: column;
        }

        .lightbox-modal .modal-header {
            background: var(--white);
            position: fixed;
            width: 100%;
        }

        .lightbox-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 2rem 10rem;
            position: relative;
        }

        .lightbox-image-container {
            max-width: 1200px;
            max-height: 80vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-image-container img {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-900);
            z-index: 10;
        }

        .lightbox-nav:hover:not(:disabled) {
            background: var(--gray-50);
            border-color: var(--gray-900);
            transform: translateY(-50%) scale(1.1);
        }

        .lightbox-nav:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .lightbox-nav.prev {
            left: -60px;
        }

        .lightbox-nav.next {
            right: -60px;
        }

        .lightbox-thumbnails {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 1.5rem;
        }

        .thumbnails-container {
            max-width: 1200px;
            margin: 0 auto;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--gray-300) transparent;
        }

        .thumbnails-container::-webkit-scrollbar {
            height: 6px;
        }

        .thumbnails-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .thumbnails-container::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        .thumbnails-track {
            display: flex;
            gap: 0.75rem;
            padding-bottom: 0.5rem;
        }

        .thumbnail-item {
            min-width: 100px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            opacity: 0.5;
            transition: var(--transition);
            border: 3px solid transparent;
            position: relative;
        }

        .thumbnail-item:hover {
            opacity: 0.8;
        }

        .thumbnail-item.active {
            opacity: 1;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.3);
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Mobile Bottom Bar */
        .mobile-bottom-bar {
            display: none;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .booking-card {
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

            .mobile-price-section {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .mobile-price-symbols {
                display: flex;
                align-items: center;
                gap: 0.125rem;
            }

            .mobile-price-icon {
                width: 20px;
                height: 20px;
                color: var(--orange-primary);
            }

            .mobile-price-icon.filled {
                opacity: 1;
            }

            .mobile-price-icon.empty {
                opacity: 0.25;
            }

            .mobile-price-label {
                font-size: 0.75rem;
                color: var(--gray-600);
                font-weight: 500;
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
            }

            .amenities-grid,
            .reviews-grid {
                grid-template-columns: 1fr;
            }

            .slider-wrapper {
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
                margin: 0 -2.5rem;
                padding: 0 2.5rem;
            }

            .slider-wrapper::-webkit-scrollbar {
                display: none;
            }

            .lightbox-nav.prev {
                left: 1rem;
            }

            .lightbox-nav.next {
                right: 1rem;
            }

            .gallery-grid-modal {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .gallery-item-modal {
                border-radius: 0;
            }
        }

        @media (max-width: 768px) {
            :root {
                --header-height: 60px;
            }

            .main-container {
                padding: 0 1.5rem;
            }

            .gallery-section {
                display: none;
            }

            .mobile-gallery {
                display: block;
                margin-top: var(--header-height);
                margin-bottom: 2rem;
            }

            .property-title {
                font-size: 1.375rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .similar-properties-inner {
                padding: 0 1.5rem;
            }

            .slider-wrapper {
                margin: 0 -1.5rem;
                padding: 0 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <!-- Content will be loaded dynamically -->
    <div id="app">
        <div class="loading-container">
            <div class="loading-spinner"></div>
            <div class="loading-text">Cargando propiedad...</div>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>

    <script>
        // Configuration
        const PROPERTY_ID = <?php echo $propertyId; ?>;
        const API_BASE = './api';
        
        // Global data
        let propertyData = null;
        let propertyImages = [];
        let propertyVideos = [];
        let propertyReviews = [];
        let propertyAmenities = [];
        let nearbyPlaces = [];
        let similarProperties = [];

        // Mobile gallery state
        let currentMobileSlide = 0;
        let mobileAutoSlideInterval = null;
        let mobileInteractionTimeout = null;

        // Lightbox state
        let currentLightboxIndex = 0;

        // Initialize
        document.addEventListener('DOMContentLoaded', async function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            await loadPropertyData();
        });

        // Load all property data
        async function loadPropertyData() {
            try {
                // Load main property data
                const response = await fetch(`${API_BASE}/properties/${PROPERTY_ID}`);
                const data = await response.json();
                
                console.log('API Response:', data);
                
                if (!data.success || !data.data) {
                    showError('Propiedad no encontrada');
                    return;
                }
                
                propertyData = data.data;
                propertyImages = propertyData.images || [];
                propertyReviews = propertyData.reviews || [];
                propertyAmenities = propertyData.amenities || [];
                
                await Promise.all([
                    loadPropertyVideos(),
                    loadNearbyPlaces(),
                    loadSimilarProperties()
                ]);
                
                renderPage();
                
            } catch (error) {
                console.error('Error loading property:', error);
                showError('Error al cargar la propiedad');
            }
        }

        async function loadPropertyVideos() {
            try {
                const response = await fetch(`${API_BASE}/properties/${PROPERTY_ID}/videos`);
                const data = await response.json();
                
                if (data.success) {
                    propertyVideos = data.data || [];
                }
            } catch (error) {
                console.error('Error loading videos:', error);
            }
        }

        async function loadNearbyPlaces() {
            try {
                const response = await fetch(`${API_BASE}/properties/${PROPERTY_ID}/nearby-places`);
                const data = await response.json();
                
                if (data.success) {
                    nearbyPlaces = data.data || [];
                }
            } catch (error) {
                console.error('Error loading nearby places:', error);
            }
        }

        async function loadSimilarProperties() {
            try {
                const typeId = propertyData.type?.id || '';
                const response = await fetch(`${API_BASE}/properties?limit=6&property_type_id=${typeId}&status=active`);
                const data = await response.json();
                
                if (data.success && data.data) {
                    const allProperties = data.data.properties || [];
                    similarProperties = allProperties.filter(p => p.id !== PROPERTY_ID).slice(0, 6);
                }
            } catch (error) {
                console.error('Error loading similar properties:', error);
            }
        }

        function renderPage() {
            document.getElementById('pageTitle').textContent = `${propertyData.title} - RentaTurista | Villa Carlos Paz`;
            document.getElementById('pageDescription').content = propertyData.description || `${propertyData.title} en Villa Carlos Paz`;
            
            const appDiv = document.getElementById('app');
            appDiv.innerHTML = `
                ${renderGallery()}
                ${renderMobileGallery()}
                <div class="main-container">
                    <div class="content-grid">
                        <div class="main-content">
                            ${renderPropertyHeader()}
                            ${renderBenefits()}
                            ${renderDescription()}
                            ${renderAmenities()}
                            ${renderVideo()}
                            ${renderLocation()}
                            ${renderReviews()}
                        </div>
                        ${renderBookingCard()}
                    </div>
                </div>
                ${renderSimilarProperties()}
                ${renderMobileBottomBar()}
                ${renderModals()}
            `;
            
            setTimeout(() => {
                initMap();
                lucide.createIcons();
                initMobileGallery();
            }, 100);
        }

        function showError(message) {
            const appDiv = document.getElementById('app');
            appDiv.innerHTML = `
                <div class="error-container">
                    <i data-lucide="alert-circle" size="64" class="error-icon"></i>
                    <h2 class="error-title">Oops!</h2>
                    <p class="error-message">${message}</p>
                    <a href="busqueda.php" class="primary-cta" style="display: inline-flex; align-items: center; gap: 0.75rem; background: var(--orange-primary); color: var(--white); padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        <i data-lucide="search" size="18"></i>
                        Volver a búsqueda
                    </a>
                </div>
            `;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function renderGallery() {
            const mainImage = propertyImages.find(img => img.is_primary) || propertyImages[0];
            const gridImages = propertyImages.slice(0, 5);
            
            return `
                <section class="gallery-section">
                    <div class="gallery-container">
                        <div class="gallery-top-bar">
                            <button class="back-btn" onclick="window.history.back()">
                                <i data-lucide="chevron-left" size="20"></i>
                                <span>Volver</span>
                            </button>
                            
                            <div class="gallery-actions">
                                <button class="action-btn" id="shareBtn" onclick="shareProperty()">
                                    <i data-lucide="share-2" size="16"></i>
                                    <span>Compartir</span>
                                </button>
                                <button class="action-btn" id="saveBtn" onclick="toggleSave('saveBtn')">
                                    <i data-lucide="heart" size="16"></i>
                                    <span>Guardar</span>
                                </button>
                            </div>
                        </div>

                        <div class="gallery-grid">
                            <div class="gallery-main" onclick="openGalleryModal()">
                                ${mainImage && mainImage.url ? 
                                    `<img src="${mainImage.url}" alt="${propertyData.title}" loading="eager">` :
                                    `<i data-lucide="home" size="80"></i>`
                                }
                                ${propertyImages.length > 0 ? `
                                    <button class="show-all-photos" onclick="event.stopPropagation(); openGalleryModal()">
                                        <i data-lucide="grid" size="16"></i>
                                        Mostrar todas las fotos (${propertyImages.length})
                                    </button>
                                ` : ''}
                            </div>
                            ${gridImages.slice(1, 5).map((img, index) => `
                                <div class="gallery-item" onclick="openGalleryModal()">
                                    ${img.url ? 
                                        `<img src="${img.url}" alt="${propertyData.title}" loading="lazy">` :
                                        `<i data-lucide="${getPlaceholderIcon(index)}" size="48"></i>`
                                    }
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </section>
            `;
        }

        function renderMobileGallery() {
            if (propertyImages.length === 0) {
                return `
                    <div class="mobile-gallery">
                        <div class="mobile-gallery-slider">
                            <div class="mobile-gallery-track">
                                <div class="mobile-gallery-slide">
                                    <i data-lucide="home" size="80"></i>
                                </div>
                            </div>
                            <div class="mobile-gallery-controls">
                                <button class="mobile-back-btn" onclick="window.history.back()">
                                    <i data-lucide="chevron-left" size="20"></i>
                                </button>
                                <div class="mobile-gallery-actions">
                                    <button class="gallery-action-btn" onclick="shareProperty()">
                                        <i data-lucide="share-2" size="18"></i>
                                    </button>
                                    <button class="gallery-action-btn" id="mobileSaveBtn" onclick="toggleSave('mobileSaveBtn')">
                                        <i data-lucide="heart" size="18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            return `
                <div class="mobile-gallery">
                    <div class="mobile-gallery-slider">
                        <div class="mobile-gallery-track" id="mobileGalleryTrack">
                            ${propertyImages.map((img, index) => `
                                <div class="mobile-gallery-slide">
                                    ${img.url ? 
                                        `<img src="${img.url}" alt="${propertyData.title}" loading="${index === 0 ? 'eager' : 'lazy'}">` :
                                        `<i data-lucide="image" size="64"></i>`
                                    }
                                </div>
                            `).join('')}
                        </div>

                        <div class="mobile-gallery-controls">
                            <button class="mobile-back-btn" onclick="window.history.back()">
                                <i data-lucide="chevron-left" size="20"></i>
                            </button>
                            <div class="mobile-gallery-actions">
                                <button class="gallery-action-btn" onclick="shareProperty()">
                                    <i data-lucide="share-2" size="18"></i>
                                </button>
                                <button class="gallery-action-btn" id="mobileSaveBtn" onclick="toggleSave('mobileSaveBtn')">
                                    <i data-lucide="heart" size="18"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mobile-gallery-nav">
                            <button class="mobile-nav-btn" id="mobilePrevBtn" onclick="slideMobileGallery(-1)">
                                <i data-lucide="chevron-left" size="20"></i>
                            </button>
                            <button class="mobile-nav-btn" id="mobileNextBtn" onclick="slideMobileGallery(1)">
                                <i data-lucide="chevron-right" size="20"></i>
                            </button>
                        </div>

                        <button class="mobile-show-photos-btn" id="mobileShowPhotosBtn" onclick="openGalleryModal()">
                            <i data-lucide="grid" size="16"></i>
                            Ver ${propertyImages.length} fotos
                        </button>
                    </div>
                </div>
            `;
        }

        function renderPropertyHeader() {
            const rating = propertyData.stats?.average_rating || 0;
            const reviewsCount = propertyData.stats?.reviews_count || 0;
            const city = propertyData.location?.city || 'Villa Carlos Paz';
            const state = propertyData.location?.state || 'Córdoba';
            
            return `
                <div class="property-header">
                    <h1 class="property-title">${propertyData.title}</h1>
                    <div class="property-subtitle">
                        ${rating > 0 ? `
                            <div class="subtitle-item rating-badge">
                                <i data-lucide="star" size="16" style="fill: currentColor;"></i>
                                <span>${rating.toFixed(1)}</span>
                            </div>
                            <span class="separator">·</span>
                        ` : ''}
                        ${reviewsCount > 0 ? `
                            <div class="subtitle-item">
                                <span>${reviewsCount} reseña${reviewsCount !== 1 ? 's' : ''}</span>
                            </div>
                            <span class="separator">·</span>
                        ` : ''}
                        <div class="subtitle-item">
                            <i data-lucide="map-pin" size="14"></i>
                            <span>${city}, ${state}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderBenefits() {
            const benefits = [];
            
            if (propertyData.policies?.pets_allowed) benefits.push({ icon: 'paw-print', text: 'Pet Friendly' });
            if (propertyData.features?.garage_spaces > 0) {
                benefits.push({ icon: 'car', text: 'Estacionamiento incluido' });
            }
            
            if (benefits.length === 0) return '';
            
            return `
                <div class="benefits-section">
                    <div class="benefits-grid">
                        ${benefits.map(benefit => `
                            <div class="benefit-card">
                                <div class="benefit-icon">
                                    <i data-lucide="${benefit.icon}" size="20"></i>
                                </div>
                                <div class="benefit-text">${benefit.text}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        function renderDescription() {
            if (!propertyData.description) return '';
            
            return `
                <div class="section-question">
                    <h2 class="section-title">¿Cómo es este espacio?</h2>
                    <p class="section-description">${propertyData.description}</p>
                </div>
            `;
        }

        function renderAmenities() {
            const displayedAmenities = [
                { key: 'bedrooms', icon: 'bed-double', text: 'Dormitorios', description: `${propertyData.features?.bedrooms || 0} dormitorios` },
                { key: 'bathrooms', icon: 'bath', text: 'Baños', description: `${propertyData.features?.bathrooms || 0} baño${propertyData.features?.bathrooms !== 1 ? 's' : ''}` },
                { key: 'guests', icon: 'users', text: 'Huéspedes', description: `Hasta ${propertyData.features?.max_guests || 0} personas` },
            ];
            
            if (propertyData.features?.garage_spaces > 0) {
                displayedAmenities.push({ 
                    key: 'parking', 
                    icon: 'car', 
                    text: 'Estacionamiento', 
                    description: `${propertyData.features.garage_spaces} espacio${propertyData.features.garage_spaces !== 1 ? 's' : ''}`
                });
            }
            
            if (propertyData.features?.surface_m2) {
                displayedAmenities.push({
                    key: 'surface',
                    icon: 'ruler',
                    text: 'Superficie',
                    description: `${propertyData.features.surface_m2} m²`
                });
            }
            
            if (propertyAmenities && Array.isArray(propertyAmenities)) {
                propertyAmenities.forEach(amenity => {
                    displayedAmenities.push({
                        key: amenity.id,
                        icon: amenity.icon || 'check',
                        text: amenity.name,
                        description: amenity.value || ''
                    });
                });
            }
            
            if (displayedAmenities.length === 0) return '';

            const shouldShowButton = displayedAmenities.length > 4;
            const visibleAmenities = shouldShowButton ? displayedAmenities.slice(0, 4) : displayedAmenities;
            
            return `
                <div class="section-question">
                    <h2 class="section-title">¿Qué ofrece este lugar?</h2>
                    <div class="amenities-grid">
                        ${visibleAmenities.map(amenity => `
                            <div class="amenity-item">
                                <i data-lucide="${amenity.icon}" size="24" class="amenity-icon"></i>
                                <div>
                                    <div class="amenity-text">${amenity.text}</div>
                                    ${amenity.description ? `<div class="amenity-description">${amenity.description}</div>` : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    ${shouldShowButton ? `
                        <button class="show-more-btn" onclick="openAmenitiesModal()">
                            Mostrar los ${displayedAmenities.length} servicios
                        </button>
                    ` : ''}
                </div>
            `;
        }

        function renderVideo() {
            const primaryVideo = propertyVideos.find(v => v.is_primary) || propertyVideos[0];
            
            if (!primaryVideo) return '';
            
            return `
                <div class="section-question video-section">
                    <h2 class="section-title">Video de la propiedad</h2>
                    <div class="video-container">
                        <iframe 
                            src="${primaryVideo.video_url}" 
                            title="Video de ${propertyData.title}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            `;
        }

        function renderLocation() {
            const city = propertyData.location?.city || 'Villa Carlos Paz';
            const lat = propertyData.location?.latitude;
            const lng = propertyData.location?.longitude;
            
            if (!lat || !lng) {
                return `
                    <div class="section-question">
                        <h2 class="section-title">¿Dónde te vas a alojar?</h2>
                        <div class="location-info">
                            <i data-lucide="map-pin" size="24" class="location-icon"></i>
                            <span class="location-text">${city}</span>
                        </div>
                    </div>
                `;
            }
            
            return `
                <div class="section-question">
                    <h2 class="section-title">¿Dónde te vas a alojar?</h2>
                    <div class="location-info">
                        <i data-lucide="map-pin" size="24" class="location-icon"></i>
                        <span class="location-text">${city}</span>
                    </div>
                    <div class="map-preview">
                        <div id="propertyMap"></div>
                    </div>
                </div>
            `;
        }

        function renderReviews() {
            if (!propertyReviews || propertyReviews.length === 0) return '';
            
            const rating = propertyData.stats?.average_rating || 0;
            const reviewsCount = propertyData.stats?.reviews_count || 0;
            const shouldShowButton = reviewsCount > 4;
            const visibleReviews = shouldShowButton ? propertyReviews.slice(0, 4) : propertyReviews;
            
            return `
                <div class="section-question" id="reviews">
                    <div class="reviews-header">
                        <div class="reviews-rating">
                            <i data-lucide="star" size="24" style="fill: currentColor;"></i>
                            <span>${rating.toFixed(1)}</span>
                        </div>
                        <span class="separator">·</span>
                        <span style="color: var(--gray-700); font-size: 1.375rem; font-weight: 600;">
                            ${reviewsCount} reseña${reviewsCount !== 1 ? 's' : ''}
                        </span>
                    </div>
                    
                    <div class="reviews-grid">
                        ${visibleReviews.map(review => `
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="reviewer-avatar">${getInitials(review.guest_name || review.reviewer_name || 'Usuario')}</div>
                                    <div class="reviewer-info">
                                        <div class="reviewer-details">
                                            <div>
                                                <div class="reviewer-name">${review.guest_name || review.reviewer_name || 'Usuario'}</div>
                                                <div class="review-date">${formatDate(review.created_at)}</div>
                                            </div>
                                            <div class="review-stars">
                                                ${renderStars(review.rating)}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="review-text">${review.comment}</p>
                            </div>
                        `).join('')}
                    </div>

                    ${shouldShowButton ? `
                        <button class="show-more-btn" onclick="openReviewsModal()">
                            Mostrar las ${reviewsCount} reseñas
                        </button>
                    ` : ''}
                </div>
            `;
        }

        function renderBookingCard() {
            const priceRange = propertyData.pricing?.price_range || 2;
            
            return `
                <aside class="booking-card">
                    <div class="booking-header">
                        <div class="price-display">
                            <div class="price-symbols">
                                ${renderPriceIcons(priceRange)}
                            </div>
                        </div>
                        <div class="price-range">${getPriceRangeLabel(priceRange)} por noche</div>
                    </div>

                    <div class="contact-actions">
                        <div class="quick-response">
                            <i data-lucide="zap" size="16"></i>
                            <span>Respuesta rápida</span>
                        </div>
                        <button class="primary-cta" onclick="openContactModal()">
                            <i data-lucide="message-circle" size="18"></i>
                            Consultar disponibilidad
                        </button>
                        
                        <div class="secondary-actions">
                            <a href="https://wa.me/5493541123456?text=${encodeURIComponent(`Hola, me interesa ${propertyData.title}`)}" class="secondary-cta" target="_blank" rel="noopener">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516"/>
                                </svg>
                                WhatsApp
                            </a>
                            <a href="tel:+5493541123456" class="secondary-cta">
                                <i data-lucide="phone" size="18"></i>
                                Llamar
                            </a>
                        </div>
                    </div>

                    <p class="booking-note">
                        Respuesta en menos de 1 hora. Asistencia 24/7.
                    </p>
                </aside>
            `;
        }

        function renderSimilarProperties() {
            if (similarProperties.length === 0) return '';
            
            return `
                <section class="similar-properties">
                    <div class="similar-properties-inner">
                        <div class="section-header-inline">
                            <div class="section-label">Alojamientos</div>
                            <h2 class="section-title">Propiedades similares</h2>
                        </div>

                        <div class="slider-container">
                            <div class="slider-wrapper">
                                <div class="slider-track" id="similarPropertiesTrack">
                                    ${similarProperties.map(property => createPropertyCard(property)).join('')}
                                </div>
                            </div>

                            <div class="slider-controls-nav">
                                <button class="slider-nav" id="similarPrevBtn" onclick="slideSimilarLeft()">
                                    <i data-lucide="chevron-left" size="20"></i>
                                </button>
                                <button class="slider-nav" id="similarNextBtn" onclick="slideSimilarRight()">
                                    <i data-lucide="chevron-right" size="20"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            `;
        }

        function renderMobileBottomBar() {
            const priceRange = propertyData.pricing?.price_range || 2;
            
            return `
                <div class="mobile-bottom-bar" id="mobileBottomBar">
                    <div class="mobile-bottom-content">
                        <div class="mobile-price-section">
                            <div class="mobile-price-symbols">
                                ${renderPriceIcons(priceRange, 'mobile-price-icon')}
                            </div>
                            <div class="mobile-price-label">${getPriceRangeLabel(priceRange)}</div>
                        </div>
                        <button class="mobile-cta" onclick="openContactModal()">
                            Consultar
                        </button>
                    </div>
                </div>
            `;
        }

        function renderModals() {
            return `
                <!-- Gallery Grid Modal -->
                <div class="modal-overlay gallery-modal" id="galleryModal" onclick="closeModal('galleryModal')">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                <i data-lucide="image" size="20"></i>
                                Fotos de la propiedad (${propertyImages.length})
                            </h3>
                            <button class="modal-close" onclick="closeModal('galleryModal')">
                                <i data-lucide="x" size="20"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="gallery-grid-modal">
                                ${propertyImages.map((img, index) => `
                                    <div class="gallery-item-modal" onclick="openLightbox(${index})">
                                        ${img.url ? 
                                            `<img src="${img.url}" alt="${propertyData.title}" loading="lazy">` :
                                            `<i data-lucide="image" size="64"></i>`
                                        }
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lightbox Modal -->
                <div class="modal-overlay lightbox-modal" id="lightboxModal" onclick="closeLightbox()">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                <span id="lightboxCounter">1 / ${propertyImages.length}</span>
                            </h3>
                            <button class="modal-close" onclick="closeLightbox()">
                                <i data-lucide="x" size="20"></i>
                            </button>
                        </div>
                        
                        <div class="lightbox-main">
                            <div class="lightbox-image-container" id="lightboxImageContainer">
                                <img src="" alt="${propertyData.title}" id="lightboxImage">
                                <button class="lightbox-nav prev" id="lightboxPrev" onclick="navigateLightbox(-1)">
                                    <i data-lucide="chevron-left" size="24"></i>
                                </button>
                                <button class="lightbox-nav next" id="lightboxNext" onclick="navigateLightbox(1)">
                                    <i data-lucide="chevron-right" size="24"></i>
                                </button>
                            </div>
                        </div>

                        <div class="lightbox-thumbnails">
                            <div class="thumbnails-container" id="thumbnailsContainer">
                                <div class="thumbnails-track" id="thumbnailsTrack">
                                    ${propertyImages.map((img, index) => `
                                        <div class="thumbnail-item ${index === 0 ? 'active' : ''}" onclick="jumpToLightboxImage(${index})">
                                            ${img.url ? 
                                                `<img src="${img.url}" alt="Thumbnail ${index + 1}">` :
                                                `<i data-lucide="image" size="32"></i>`
                                            }
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amenities Modal -->
                <div class="modal-overlay" id="amenitiesModal" onclick="closeModal('amenitiesModal')">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <div class="modal-header">
                            <h3 class="modal-title">Todos los servicios</h3>
                            <button class="modal-close" onclick="closeModal('amenitiesModal')">
                                <i data-lucide="x" size="20"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="amenities-grid">
                                ${renderAllAmenities()}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Modal -->
                <div class="modal-overlay" id="reviewsModal" onclick="closeModal('reviewsModal')">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <div class="modal-header">
                            <h3 class="modal-title">
                                <i data-lucide="star" size="20" style="fill: var(--orange-primary); color: var(--orange-primary);"></i>
                                ${propertyData.stats?.average_rating.toFixed(1)} · ${propertyData.stats?.reviews_count} reseñas
                            </h3>
                            <button class="modal-close" onclick="closeModal('reviewsModal')">
                                <i data-lucide="x" size="20"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="reviews-grid">
                                ${propertyReviews.map(review => `
                                    <div class="review-card">
                                        <div class="review-header">
                                            <div class="reviewer-avatar">${getInitials(review.guest_name || review.reviewer_name || 'Usuario')}</div>
                                            <div class="reviewer-info">
                                                <div class="reviewer-details">
                                                    <div>
                                                        <div class="reviewer-name">${review.guest_name || review.reviewer_name || 'Usuario'}</div>
                                                        <div class="review-date">${formatDate(review.created_at)}</div>
                                                    </div>
                                                    <div class="review-stars">
                                                        ${renderStars(review.rating)}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="review-text">${review.comment}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Modal -->
                <div class="modal-overlay" id="contactModal" onclick="closeModal('contactModal')">
                    <div class="modal-content" onclick="event.stopPropagation()">
                        <div class="modal-header">
                            <h3 class="modal-title">¿Cómo querés contactarnos?</h3>
                            <button class="modal-close" onclick="closeModal('contactModal')">
                                <i data-lucide="x" size="20"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div style="display: grid; gap: 1rem;">
                                <a href="https://wa.me/5493541123456?text=${encodeURIComponent(`Hola, me interesa ${propertyData.title}`)}" style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; border: 1px solid var(--gray-300); border-radius: 12px; text-decoration: none; color: var(--gray-900);" target="_blank">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--orange-primary), var(--orange-dark)); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.516"/>
                                        </svg>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; font-size: 1rem; margin-bottom: 0.25rem;">WhatsApp</div>
                                        <div style="font-size: 0.875rem; color: var(--gray-600);">Respuesta inmediata</div>
                                    </div>
                                    <i data-lucide="chevron-right" size="20" style="color: var(--gray-400);"></i>
                                </a>

                                <a href="tel:+5493541123456" style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; border: 1px solid var(--gray-300); border-radius: 12px; text-decoration: none; color: var(--gray-900);">
                                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--orange-primary), var(--orange-dark)); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i data-lucide="phone" size="24"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; font-size: 1rem; margin-bottom: 0.25rem;">Teléfono</div>
                                        <div style="font-size: 0.875rem; color: var(--gray-600);">+54 9 3541 123456</div>
                                    </div>
                                    <i data-lucide="chevron-right" size="20" style="color: var(--gray-400);"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderAllAmenities() {
            const allAmenities = [
                { key: 'bedrooms', icon: 'bed-double', text: 'Dormitorios', description: `${propertyData.features?.bedrooms || 0} dormitorios` },
                { key: 'bathrooms', icon: 'bath', text: 'Baños', description: `${propertyData.features?.bathrooms || 0} baño${propertyData.features?.bathrooms !== 1 ? 's' : ''}` },
                { key: 'guests', icon: 'users', text: 'Huéspedes', description: `Hasta ${propertyData.features?.max_guests || 0} personas` },
            ];
            
            if (propertyData.features?.garage_spaces > 0) {
                allAmenities.push({ 
                    key: 'parking', 
                    icon: 'car', 
                    text: 'Estacionamiento', 
                    description: `${propertyData.features.garage_spaces} espacio${propertyData.features.garage_spaces !== 1 ? 's' : ''}`
                });
            }
            
            if (propertyData.features?.surface_m2) {
                allAmenities.push({
                    key: 'surface',
                    icon: 'ruler',
                    text: 'Superficie',
                    description: `${propertyData.features.surface_m2} m²`
                });
            }
            
            if (propertyAmenities && Array.isArray(propertyAmenities)) {
                propertyAmenities.forEach(amenity => {
                    allAmenities.push({
                        key: amenity.id,
                        icon: amenity.icon || 'check',
                        text: amenity.name,
                        description: amenity.value || ''
                    });
                });
            }

            return allAmenities.map(amenity => `
                <div class="amenity-item">
                    <i data-lucide="${amenity.icon}" size="24" class="amenity-icon"></i>
                    <div>
                        <div class="amenity-text">${amenity.text}</div>
                        ${amenity.description ? `<div class="amenity-description">${amenity.description}</div>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function getPlaceholderIcon(index) {
            const icons = ['bed-double', 'waves', 'utensils', 'mountain'];
            return icons[index % icons.length];
        }

        function renderPriceIcons(priceRange, className = 'price-icon') {
            let html = '';
            for (let i = 1; i <= 4; i++) {
                html += `<i data-lucide="dollar-sign" size="20" class="${className} ${i <= priceRange ? 'filled' : 'empty'}"></i>`;
            }
            return html;
        }

        function getPriceRangeLabel(priceRange) {
            const labels = {
                1: 'Hasta $50K',
                2: '$50K - $100K',
                3: '$100K - $150K',
                4: 'Más de $150K'
            };
            return labels[priceRange] || labels[2];
        }

        function getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            return `${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        function renderStars(rating) {
            let html = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    html += `<i data-lucide="star" size="12" style="fill: currentColor;"></i>`;
                } else {
                    html += `<i data-lucide="star" size="12"></i>`;
                }
            }
            return html;
        }

        function createPropertyCard(property) {
            const typeIcons = {
                'casa': 'home',
                'departamento': 'building-2',
                'cabaña': 'mountain',
                'hotel': 'hotel',
                'default': 'home'
            };

            const typeName = property.type?.name?.toLowerCase() || '';
            const icon = typeIcons[typeName] || typeIcons.default;
            const rating = property.stats?.average_rating || 0;
            const priceRange = property.pricing?.price_range || 2;
            
            return `
                <div class="property-card" onclick="location.href='propiedad.php?id=${property.id}'">
                    <div class="property-image">
                        ${property.primary_image ? 
                            `<img src="${property.primary_image}" alt="${property.title}" loading="lazy">` :
                            `<i data-lucide="${icon}" size="56"></i>`
                        }
                        ${rating > 0 ? `
                            <div class="property-rating-badge">
                                <div class="stars">
                                    <i data-lucide="star" size="12" fill="currentColor"></i>
                                </div>
                                <span class="rating-value">${rating.toFixed(1)}</span>
                            </div>
                        ` : ''}
                    </div>
                    <div class="property-content">
                        <div class="property-type">${property.type?.name || 'Propiedad'}</div>
                        <h3 class="property-card-title">${property.title}</h3>
                        <div class="property-features">
                            ${property.features?.bedrooms ? `<div class="feature"><i data-lucide="bed-double" size="14"></i><span>${property.features.bedrooms}</span></div>` : ''}
                            ${property.features?.bathrooms ? `<div class="feature"><i data-lucide="bath" size="14"></i><span>${property.features.bathrooms}</span></div>` : ''}
                            ${property.features?.max_guests ? `<div class="feature"><i data-lucide="users" size="14"></i><span>${property.features.max_guests}</span></div>` : ''}
                        </div>
                        <div class="property-footer">
                            <div class="property-price-container">
                                <div class="price-icons">
                                    ${renderPriceIcons(priceRange, 'price-icon')}
                                </div>
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

        function initMap() {
            const lat = propertyData.location?.latitude;
            const lng = propertyData.location?.longitude;
            
            if (!lat || !lng || typeof L === 'undefined') {
                console.warn('No coordinates available for map or Leaflet not loaded');
                return;
            }
            
            try {
                const map = L.map('propertyMap').setView([lat, lng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 18
                }).addTo(map);

                const city = propertyData.location?.city || 'Villa Carlos Paz';
                
                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center; padding: 8px;">
                            <strong>${propertyData.title}</strong><br>
                            <span style="font-size: 0.875rem; color: #666;">${city}</span>
                        </div>
                    `);
            } catch (error) {
                console.error('Error initializing map:', error);
            }
        }

        function initMobileGallery() {
            if (propertyImages.length <= 1) return;
            
            updateMobileGalleryButtons();
            startMobileAutoSlide();
            
            const track = document.getElementById('mobileGalleryTrack');
            if (!track) return;
            
            let touchStartX = 0;
            let touchEndX = 0;
            
            track.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopMobileAutoSlide();
                hideMobileShowPhotosBtn();
            }, { passive: true });
            
            track.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleMobileSwipe();
                restartMobileAutoSlideAfterDelay();
            }, { passive: true });
            
            function handleMobileSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        slideMobileGallery(1);
                    } else {
                        slideMobileGallery(-1);
                    }
                }
            }
        }

        function slideMobileGallery(direction) {
            const newIndex = currentMobileSlide + direction;
            
            if (newIndex < 0 || newIndex >= propertyImages.length) return;
            
            currentMobileSlide = newIndex;
            updateMobileGalleryPosition();
            updateMobileGalleryButtons();
            
            stopMobileAutoSlide();
            hideMobileShowPhotosBtn();
            restartMobileAutoSlideAfterDelay();
        }

        function updateMobileGalleryPosition() {
            const track = document.getElementById('mobileGalleryTrack');
            if (!track) return;
            
            track.style.transform = `translateX(-${currentMobileSlide * 100}%)`;
        }

        function updateMobileGalleryButtons() {
            const prevBtn = document.getElementById('mobilePrevBtn');
            const nextBtn = document.getElementById('mobileNextBtn');
            
            if (prevBtn) prevBtn.disabled = currentMobileSlide === 0;
            if (nextBtn) nextBtn.disabled = currentMobileSlide === propertyImages.length - 1;
            
            setTimeout(() => lucide.createIcons(), 50);
        }

        function startMobileAutoSlide() {
            if (propertyImages.length <= 1) return;
            
            showMobileShowPhotosBtn();
            
            mobileAutoSlideInterval = setInterval(() => {
                if (currentMobileSlide < propertyImages.length - 1) {
                    slideMobileGallery(1);
                } else {
                    currentMobileSlide = -1;
                    slideMobileGallery(1);
                }
            }, 5000);
        }

        function stopMobileAutoSlide() {
            if (mobileAutoSlideInterval) {
                clearInterval(mobileAutoSlideInterval);
                mobileAutoSlideInterval = null;
            }
        }

        function restartMobileAutoSlideAfterDelay() {
            if (mobileInteractionTimeout) {
                clearTimeout(mobileInteractionTimeout);
            }
            
            mobileInteractionTimeout = setTimeout(() => {
                startMobileAutoSlide();
            }, 3000);
        }

        function showMobileShowPhotosBtn() {
            const btn = document.getElementById('mobileShowPhotosBtn');
            if (btn) {
                btn.classList.add('visible');
            }
        }

        function hideMobileShowPhotosBtn() {
            const btn = document.getElementById('mobileShowPhotosBtn');
            if (btn) {
                btn.classList.remove('visible');
            }
        }

        function openGalleryModal() {
            document.getElementById('galleryModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function openLightbox(index) {
            if (propertyImages.length === 0) return;
            
            closeModal('galleryModal');
            
            currentLightboxIndex = index;
            updateLightboxImage();
            
            setTimeout(() => {
                document.getElementById('lightboxModal').classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => lucide.createIcons(), 100);
            }, 300);
        }

        function closeLightbox() {
            document.getElementById('lightboxModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function navigateLightbox(direction) {
            const newIndex = currentLightboxIndex + direction;
            
            if (newIndex < 0 || newIndex >= propertyImages.length) return;
            
            currentLightboxIndex = newIndex;
            updateLightboxImage();
        }

        function jumpToLightboxImage(index) {
            currentLightboxIndex = index;
            updateLightboxImage();
        }

        function updateLightboxImage() {
            const image = propertyImages[currentLightboxIndex];
            const lightboxImage = document.getElementById('lightboxImage');
            const counter = document.getElementById('lightboxCounter');
            const prevBtn = document.getElementById('lightboxPrev');
            const nextBtn = document.getElementById('lightboxNext');
            
            if (lightboxImage && image) {
                lightboxImage.src = image.url || '';
            }
            
            if (counter) {
                counter.textContent = `${currentLightboxIndex + 1} / ${propertyImages.length}`;
            }
            
            if (prevBtn) prevBtn.disabled = currentLightboxIndex === 0;
            if (nextBtn) nextBtn.disabled = currentLightboxIndex === propertyImages.length - 1;
            
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach((thumb, index) => {
                if (index === currentLightboxIndex) {
                    thumb.classList.add('active');
                    thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    thumb.classList.remove('active');
                }
            });
            
            setTimeout(() => lucide.createIcons(), 50);
        }

        function openAmenitiesModal() {
            document.getElementById('amenitiesModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function openReviewsModal() {
            document.getElementById('reviewsModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function openContactModal() {
            document.getElementById('contactModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = '';
        }

        function shareProperty() {
            if (navigator.share) {
                navigator.share({
                    title: propertyData.title,
                    text: `Mira esta propiedad en RentaTurista`,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('¡Link copiado al portapapeles!');
                });
            }
        }

        function toggleSave(btnId) {
            const btn = document.getElementById(btnId);
            if (!btn) return;
            
            btn.classList.toggle('saved');
            
            const otherBtnId = btnId === 'saveBtn' ? 'mobileSaveBtn' : 'saveBtn';
            const otherBtn = document.getElementById(otherBtnId);
            if (otherBtn) {
                if (btn.classList.contains('saved')) {
                    otherBtn.classList.add('saved');
                } else {
                    otherBtn.classList.remove('saved');
                }
            }
            
            setTimeout(() => lucide.createIcons(), 50);
        }

        let currentSimilarSlide = 0;
        const cardWidth = 336;

        function slideSimilarLeft() {
            if (currentSimilarSlide > 0) {
                currentSimilarSlide--;
                const track = document.getElementById('similarPropertiesTrack');
                track.style.transform = `translateX(-${currentSimilarSlide * cardWidth}px)`;
            }
        }

        function slideSimilarRight() {
            const track = document.getElementById('similarPropertiesTrack');
            const maxSlide = Math.max(0, track.children.length - 3);
            
            if (currentSimilarSlide < maxSlide) {
                currentSimilarSlide++;
                track.style.transform = `translateX(-${currentSimilarSlide * cardWidth}px)`;
            }
        }

        document.addEventListener('keydown', (e) => {
            const lightboxModal = document.getElementById('lightboxModal');
            
            if (lightboxModal && lightboxModal.classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox(1);
                }
                return;
            }
            
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });
    </script>
</body>
</html>