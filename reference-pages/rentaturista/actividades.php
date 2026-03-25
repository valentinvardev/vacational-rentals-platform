<?php
/**
 * RentaTurista - Activities List Page
 * Browse and explore all activities and places in Villa Carlos Paz
 */

// API configuration
$apiUrl = './api/places';
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    <title>Explorar Actividades - RentaTurista | Villa Carlos Paz</title>
    <meta name="description" content="Descubre los mejores lugares y experiencias en Villa Carlos Paz. Restaurantes, teatros, vida nocturna, parques y más.">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    
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
        
        .activities-page {
            margin-top: 80px;
            padding: 2.5rem 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 3vw, 2rem);
        }

        /* Page Header */
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title i {
            color: var(--orange-primary);
        }

        .page-subtitle {
            font-size: 1.0625rem;
            color: var(--gray-600);
            line-height: 1.6;
            margin-top: 0.5rem;
        }

        .view-map-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.15);
            cursor: pointer;
        }

        .view-map-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
        }

        /* Search Bar */
        
        .search-bar-wrapper {
            background: var(--white);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            margin-bottom: 3rem;
            border: 2px solid var(--gray-200);
            transition: var(--transition);
        }

        .search-bar-wrapper:focus-within {
            border-color: var(--orange-primary);
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.15);
        }

        .search-bar {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .search-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .search-label {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--gray-900);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-size: 0.9375rem;
            transition: var(--transition);
            background: var(--white);
            color: var(--gray-900);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--orange-primary);
        }

        .search-select {
            appearance: none;
            background-color: var(--white);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23FF6B35' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
            cursor: pointer;
            font-weight: 600;
        }

        .search-btn {
            background: var(--white);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            white-space: nowrap;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            border-color: var(--gray-700);
            color: var(--gray-900);
            background: var(--white);
        }

        /* Mobile Quick Access */
        
        .mobile-quick-access {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 768px) {
            .mobile-quick-access {
                display: grid;
            }

            .page-header .view-map-btn {
                display: none;
            }

            .categories-section {
                display: none;
            }

            .search-bar {
                grid-template-columns: 1fr;
            }

            .search-btn {
                width: 100%;
            }
        }

        .quick-access-card {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.15);
            min-height: 120px;
        }

        .quick-access-card:hover {
            background: rgba(255, 107, 53, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
        }

        .quick-access-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .quick-access-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
        }

        /* Categories Section */
        
        .categories-section {
            margin-bottom: 4rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--orange-primary);
        }

        /* Category Filter Chips */
        .category-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .category-filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-primary);
        }

        .category-filter-chip:hover {
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.15);
        }

        .category-filter-chip.active {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .category-filter-chip.active:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
        }

        .category-filter-chip i {
            color: var(--orange-primary);
            transition: var(--transition);
        }

        .category-filter-chip.active i {
            color: var(--white);
        }

        .category-chip-count {
            font-size: 0.8125rem;
            opacity: 0.85;
            font-weight: 500;
        }

        /* Activities Grid */
        
        .activities-section {
            margin-bottom: 4rem;
        }

        .results-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .results-count {
            font-size: 1rem;
            color: var(--gray-700);
        }

        .results-count strong {
            color: var(--gray-900);
            font-weight: 700;
        }

        .sort-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sort-label {
            font-size: 0.9375rem;
            color: var(--gray-700);
            font-weight: 600;
        }

        .sort-select {
            padding: 0.625rem 0.875rem;
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            font-family: var(--font-primary);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            background: var(--white);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23525252' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            padding-right: 2.25rem;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
            background: var(--gray-100);
            padding: 0.375rem;
            border-radius: 10px;
        }

        .view-btn {
            background: transparent;
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            color: var(--gray-600);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-btn.active {
            background: var(--white);
            color: var(--orange-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .activities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .activities-grid.list-view {
            grid-template-columns: 1fr;
        }

        /* Activity Card */
        
        .activity-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
        }

        .activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--orange-primary);
        }

        .activity-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            overflow: hidden;
        }

        .activity-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .activity-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
        }

        .activity-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(10px);
            color: var(--white);
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .activity-content {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
        }

        .activity-type {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .activity-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
        }

        .rating-stars {
            color: #FFA500;
        }

        .rating-value {
            font-weight: 700;
            color: var(--gray-900);
        }

        .activity-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-location {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .activity-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .activity-detail {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-700);
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .activity-detail i {
            color: var(--orange-primary);
        }

        .activity-footer {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .activity-btn {
            flex: 1;
            padding: 0.625rem 1rem;
            border-radius: 10px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            text-decoration: none;
        }

        .btn-view-map {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
        }

        .btn-view-map:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        .btn-directions {
            background: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            color: var(--white);
        }

        .btn-directions:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
            transform: translateX(2px);
        }

        /* Price display */
        .activity-price-container {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .price-icons {
            display: flex;
            align-items: center;
            gap: 0.125rem;
        }

        .price-icon {
            width: 18px;
            height: 18px;
            color: var(--orange-primary);
        }

        .price-icon.filled {
            opacity: 1;
        }

        .price-icon.empty {
            opacity: 0.2;
        }

        /* List View Styles */
        .activities-grid.list-view .activity-card {
            display: grid;
            grid-template-columns: 300px 1fr;
            flex-direction: row;
        }

        .activities-grid.list-view .activity-image-wrapper {
            height: 100%;
            min-height: 250px;
        }

        .activities-grid.list-view .activity-content {
            padding: 1.5rem;
        }

        /* Empty State */
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.75rem;
        }

        .empty-text {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Map Modal */
        
        .map-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .map-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .map-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--white);
            z-index: 2001;
            display: flex;
            flex-direction: column;
        }

        .map-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            z-index: 10;
        }

        .map-modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .map-modal-title i {
            color: var(--orange-primary);
        }

        .map-modal-close {
            background: var(--gray-100);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .map-modal-close:hover {
            background: var(--gray-200);
            transform: rotate(90deg);
        }

        .map-modal-body {
            flex: 1;
            position: relative;
        }

        #modalMap {
            width: 100%;
            height: 100%;
        }

        /* Activity Preview Popup */
        
        .activity-preview-popup {
            position: fixed;
            top: 100px;
            right: 20px;
            width: 280px;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateX(20px) scale(0.9);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 2100;
            border: 2px solid var(--orange-primary);
        }

        .activity-preview-popup.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0) scale(1);
        }

        .preview-image-wrapper {
            position: relative;
            width: 100%;
            height: 160px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            overflow: hidden;
        }

        .preview-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--white);
            z-index: 11;
            transition: var(--transition);
        }

        .preview-close:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .preview-content {
            padding: 1rem;
        }

        .preview-title {
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .preview-location {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-600);
            font-size: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .preview-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .preview-detail {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-700);
            font-size: 0.75rem;
            font-weight: 600;
        }

        .preview-detail i {
            color: var(--orange-primary);
        }

        .preview-actions {
            display: flex;
            gap: 0.5rem;
        }

        .preview-btn {
            flex: 1;
            padding: 0.5rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            text-decoration: none;
        }

        .preview-btn-directions {
            background: var(--orange-primary);
            border: none;
            color: var(--white);
        }

        .preview-btn-directions:hover {
            background: var(--orange-dark);
        }

        /* Categories Modal */
        
        .categories-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .categories-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .categories-modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 24px 24px 0 0;
            overflow: hidden;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            z-index: 2001;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .categories-modal-overlay.active .categories-modal {
            transform: translateY(0);
        }

        .categories-modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            flex-shrink: 0;
        }

        .categories-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .categories-modal-title i {
            color: var(--orange-primary);
        }

        .categories-modal-close {
            background: var(--gray-100);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-700);
            transition: var(--transition);
        }

        .categories-modal-close:hover {
            background: var(--gray-200);
        }

        .categories-modal-body {
            padding: 1rem;
            overflow-y: auto;
            flex: 1;
        }

        .modal-category-grid {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-category-card {
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-category-card:active {
            transform: scale(0.98);
            background: rgba(255, 107, 53, 0.05);
        }

        .modal-category-card:hover {
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.02);
        }

        .modal-category-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            flex-shrink: 0;
        }

        .modal-category-info {
            flex: 1;
        }

        .modal-category-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0 0 0.25rem 0;
        }

        .modal-category-count {
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin: 0;
        }

        .modal-category-arrow {
            color: var(--gray-400);
            flex-shrink: 0;
        }

        /* Leaflet marker customization */
        .activity-marker {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--orange-primary);
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.35);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-primary);
        }

        .activity-marker:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: scale(1.15);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
        }

        .activity-marker.active {
            background: var(--orange-primary);
            color: var(--white);
            transform: scale(1.1);
        }

        /* Mobile Responsive */
        
        @media (max-width: 1024px) {
            .activities-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .activities-page {
                padding: 1.5rem 0;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .search-bar-wrapper {
                padding: 1rem;
            }

            .results-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .view-toggle {
                display: none;
            }

            .activities-grid {
                grid-template-columns: 1fr;
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

    <main class="activities-page">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        <i data-lucide="compass" size="32"></i>
                        Explorar Actividades
                    </h1>
                    <p class="page-subtitle">Descubre los mejores lugares y experiencias en Villa Carlos Paz</p>
                </div>
                <button class="view-map-btn" onclick="openMapModal()">
                    <i data-lucide="map" size="20"></i>
                    Ver mapa
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar-wrapper">
                <form class="search-bar" id="searchForm" onsubmit="return false;">
                    <div class="search-field">
                        <label class="search-label">Buscar actividad o lugar</label>
                        <input type="text" class="search-input" id="searchInput" placeholder="Restaurante, parque, teatro...">
                    </div>
                    <div class="search-field">
                        <label class="search-label">Categoría</label>
                        <select class="search-input search-select" id="categorySelect">
                            <option value="">Todas las categorías</option>
                            <!-- Will be populated dynamically -->
                        </select>
                    </div>
                    <button type="button" class="search-btn" onclick="performSearch()">
                        <i data-lucide="search" size="20"></i>
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Mobile Quick Access -->
            <div class="mobile-quick-access">
                <div class="quick-access-card" onclick="openMapModal()">
                    <div class="quick-access-icon">
                        <i data-lucide="map" size="24"></i>
                    </div>
                    <h3 class="quick-access-title">Mapa</h3>
                </div>
                <div class="quick-access-card" onclick="openCategoriesModal()">
                    <div class="quick-access-icon">
                        <i data-lucide="grid-3x3" size="24"></i>
                    </div>
                    <h3 class="quick-access-title">Categorías</h3>
                </div>
            </div>

            <!-- Categories Section -->
            <section class="categories-section" id="categoriesSection">
                <div class="section-header">
                    <h2 class="section-title">
                        <i data-lucide="grid-3x3" size="28"></i>
                        Explorar por categoría
                    </h2>
                </div>

                <div class="category-filters" id="categoryFilters">
                    <!-- Will be populated dynamically -->
                </div>
            </section>

            <!-- Activities Section -->
            <section class="activities-section">
                <div class="results-bar">
                    <div class="results-info">
                        <p class="results-count">
                            <strong id="resultsCount">0</strong> actividades disponibles
                        </p>
                    </div>
                    <div class="sort-controls">
                        <label class="sort-label">Ordenar por:</label>
                        <select class="sort-select" id="sortSelect" onchange="sortActivities()">
                            <option value="recommended">Recomendadas</option>
                            <option value="rating">Mejor calificadas</option>
                            <option value="distance">Más cercanas</option>
                            <option value="popular">Más populares</option>
                        </select>
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid" onclick="changeView('grid')">
                                <i data-lucide="grid-3x3" size="20"></i>
                            </button>
                            <button class="view-btn" data-view="list" onclick="changeView('list')">
                                <i data-lucide="list" size="20"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="activities-grid" id="activitiesGrid">
                    <!-- Activities will be loaded here -->
                </div>
            </section>
        </div>
    </main>

    <?php include './includes/footer.php'; ?>

    <!-- Categories Modal -->
    <div class="categories-modal-overlay" id="categoriesModalOverlay" onclick="closeCategoriesModal()">
        <div class="categories-modal" onclick="event.stopPropagation()">
            <div class="categories-modal-header">
                <h3 class="categories-modal-title">
                    <i data-lucide="grid-3x3" size="28"></i>
                    Explorar por categoría
                </h3>
                <button class="categories-modal-close" onclick="closeCategoriesModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="categories-modal-body">
                <div class="modal-category-grid">
                    <!-- Will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Map Modal -->
    <div class="map-modal-overlay" id="mapModalOverlay" onclick="closeMapModal()">
        <div class="map-modal" onclick="event.stopPropagation()">
            <div class="map-modal-header">
                <h3 class="map-modal-title">
                    <i data-lucide="map" size="28"></i>
                    Mapa de Actividades
                </h3>
                <button class="map-modal-close" onclick="closeMapModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="map-modal-body">
                <div id="modalMap"></div>
                
                <!-- Activity Preview Popup -->
                <div class="activity-preview-popup" id="activityPreview">
                    <button class="preview-close" onclick="closePreview()">
                        <i data-lucide="x" size="14"></i>
                    </button>
                    <div class="preview-image-wrapper" id="previewImage">
                        <i data-lucide="map-pin" size="48"></i>
                    </div>
                    <div class="preview-content" id="previewContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Global variables
        const API_URL = './api/places';
        let map = null;
        let markers = [];
        let allPlaces = [];
        let filteredPlaces = [];
        let activeCategory = null;
        let categoryCounts = {};

        // Category configuration
        const categoryConfig = {
            restaurant: { label: 'Restaurantes', icon: 'utensils' },
            bar: { label: 'Bares', icon: 'beer' },
            nightlife: { label: 'Vida Nocturna', icon: 'music' },
            attraction: { label: 'Atracciones', icon: 'map-pin' },
            beach: { label: 'Playas', icon: 'waves' },
            hiking: { label: 'Trekking', icon: 'mountain' },
            shopping: { label: 'Compras', icon: 'shopping-bag' },
            service: { label: 'Servicios', icon: 'info' },
            transport: { label: 'Transporte', icon: 'bus' },
            other: { label: 'Otros', icon: 'map' }
        };

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPlaces();
        });

        // Load places from API
        async function loadPlaces() {
            try {
                const response = await fetch(API_URL);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error('Error al cargar lugares');
                }
                
                allPlaces = result.data;
                filteredPlaces = [...allPlaces];
                
                calculateCategoryCounts();
                renderCategories();
                renderActivities();
                
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error loading places:', error);
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.innerHTML = `
                        <div style="text-align: center; background: white; padding: 2rem; border-radius: 12px; max-width: 400px;">
                            <i data-lucide="wifi-off" size="48" style="color: #EF4444; margin-bottom: 1rem;"></i>
                            <h3 style="color: #1f2937; margin-bottom: 0.5rem;">Error de Conexión</h3>
                            <p style="color: #6b7280;">No se pudieron cargar las actividades</p>
                            <button onclick="location.reload()" style="margin-top: 1rem; background: #FF6B35; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-family: Poppins; font-weight: 600;">
                                Reintentar
                            </button>
                        </div>
                    `;
                    lucide.createIcons();
                }
            }
        }

        // Calculate category counts
        function calculateCategoryCounts() {
            categoryCounts = {};
            allPlaces.forEach(place => {
                categoryCounts[place.category] = (categoryCounts[place.category] || 0) + 1;
            });
        }

        // Render categories
        function renderCategories() {
            const filtersContainer = document.getElementById('categoryFilters');
            const selectElement = document.getElementById('categorySelect');
            
            if (!filtersContainer || !selectElement) return;
            
            // Render category filter chips
            let filtersHTML = '';
            Object.entries(categoryConfig).forEach(([key, config]) => {
                const count = categoryCounts[key] || 0;
                if (count > 0) {
                    filtersHTML += `
                        <button class="category-filter-chip" data-category="${key}" onclick="filterByCategory('${key}')">
                            <i data-lucide="${config.icon}" size="20"></i>
                            <span>${config.label}</span>
                            <span class="category-chip-count">(${count})</span>
                        </button>
                    `;
                }
            });
            filtersContainer.innerHTML = filtersHTML;
            
            // Populate category select
            let selectHTML = '<option value="">Todas las categorías</option>';
            Object.entries(categoryConfig).forEach(([key, config]) => {
                const count = categoryCounts[key] || 0;
                if (count > 0) {
                    selectHTML += `<option value="${key}">${config.label} (${count})</option>`;
                }
            });
            selectElement.innerHTML = selectHTML;
            
            // Also populate modal categories
            renderModalCategories();
            
            lucide.createIcons();
        }

        // Render modal categories
        function renderModalCategories() {
            const modalGrid = document.querySelector('.modal-category-grid');
            if (!modalGrid) return;
            
            let modalHTML = '';
            Object.entries(categoryConfig).forEach(([key, config]) => {
                const count = categoryCounts[key] || 0;
                if (count > 0) {
                    modalHTML += `
                        <div class="modal-category-card" onclick="selectCategoryAndClose('${key}')">
                            <div class="modal-category-icon">
                                <i data-lucide="${config.icon}" size="32"></i>
                            </div>
                            <div class="modal-category-info">
                                <h4 class="modal-category-title">${config.label}</h4>
                                <p class="modal-category-count">${count} lugar${count !== 1 ? 'es' : ''}</p>
                            </div>
                            <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                        </div>
                    `;
                }
            });
            modalGrid.innerHTML = modalHTML;
        }

        // Render activities
        function renderActivities() {
            const grid = document.getElementById('activitiesGrid');
            const count = document.getElementById('resultsCount');
            
            if (!grid || !count) return;
            
            count.textContent = filteredPlaces.length;

            if (filteredPlaces.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i data-lucide="compass" size="40"></i>
                        </div>
                        <h3 class="empty-title">No se encontraron actividades</h3>
                        <p class="empty-text">Intenta ajustar los filtros de búsqueda o explora otras categorías</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            grid.innerHTML = filteredPlaces.map(place => createActivityCard(place)).join('');
            lucide.createIcons();
            
            // Update map markers if map is open
            if (map) {
                updateMapMarkers();
            }
        }

        // Create activity card
        function createActivityCard(place) {
            const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
            const stars = place.rating > 0 ? '★'.repeat(Math.round(place.rating)) : '';
            const priceDisplay = getPriceDisplay(place.price_range);
            
            return `
                <article class="activity-card">
                    <div class="activity-image-wrapper" onclick="viewActivity('${place.slug}')">
                        <div class="activity-placeholder">
                            <i data-lucide="${place.icon || categoryInfo.icon}" size="64"></i>
                        </div>
                        ${place.is_featured ? `
                            <div class="activity-badge">
                                <i data-lucide="star" size="12"></i>
                                Destacado
                            </div>
                        ` : ''}
                    </div>
                    <div class="activity-content" onclick="viewActivity('${place.slug}')">
                        <div class="activity-header">
                            <span class="activity-type">${categoryInfo.label}</span>
                            ${place.rating > 0 ? `
                                <div class="activity-rating">
                                    <span class="rating-stars">${stars}</span>
                                    <span class="rating-value">${place.rating.toFixed(1)}</span>
                                </div>
                            ` : ''}
                        </div>
                        <h3 class="activity-title">${place.name}</h3>
                        <div class="activity-location">
                            <i data-lucide="map-pin" size="14"></i>
                            ${place.address || place.city || 'Villa Carlos Paz'}
                        </div>
                        <div class="activity-details">
                            ${place.phone ? `
                                <div class="activity-detail">
                                    <i data-lucide="phone" size="14"></i>
                                    ${place.phone}
                                </div>
                            ` : ''}
                            ${place.price_range ? `
                                <div class="activity-detail price-detail activity-price-container">
                                    ${priceDisplay}
                                </div>
                            ` : ''}
                            ${place.distance_from_center ? `
                                <div class="activity-detail">
                                    <i data-lucide="map-pin" size="14"></i>
                                    ${place.distance_from_center} km del centro
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    <div class="activity-footer">
                        <button class="activity-btn btn-view-map" onclick="event.stopPropagation(); viewOnMap(${place.id})">
                            <i data-lucide="map-pin" size="16"></i>
                            Ver en mapa
                        </button>
                        ${place.latitude && place.longitude ? `
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" 
                               target="_blank" 
                               class="activity-btn btn-directions" 
                               onclick="event.stopPropagation()">
                                <i data-lucide="navigation" size="16"></i>
                                Cómo llegar
                            </a>
                        ` : ''}
                    </div>
                </article>
            `;
        }

        // Get price display
        function getPriceDisplay(priceRange) {
            if (!priceRange || priceRange === 0) {
                return '<span style="color: var(--gray-600); font-weight: 600;">Gratis</span>';
            }
            
            let icons = '';
            for (let i = 0; i < 4; i++) {
                if (i < priceRange) {
                    icons += `<i data-lucide="dollar-sign" size="18" class="price-icon filled"></i>`;
                } else {
                    icons += `<i data-lucide="dollar-sign" size="18" class="price-icon empty"></i>`;
                }
            }
            return icons;
        }

        // Filter by category
        function filterByCategory(category) {
            const chips = document.querySelectorAll('.category-filter-chip');
            
            if (activeCategory === category) {
                // Deactivate
                chips.forEach(chip => chip.classList.remove('active'));
                activeCategory = null;
                const selectElement = document.getElementById('categorySelect');
                if (selectElement) selectElement.value = '';
            } else {
                // Activate
                chips.forEach(chip => {
                    if (chip.dataset.category === category) {
                        chip.classList.add('active');
                    } else {
                        chip.classList.remove('active');
                    }
                });
                activeCategory = category;
                const selectElement = document.getElementById('categorySelect');
                if (selectElement) selectElement.value = category;
            }
            
            lucide.createIcons();
            applyFilters();
        }

        // Open categories modal
        function openCategoriesModal() {
            const modal = document.getElementById('categoriesModalOverlay');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => lucide.createIcons(), 100);
            }
        }

        // Close categories modal
        function closeCategoriesModal() {
            const modal = document.getElementById('categoriesModalOverlay');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        // Select category and close modal
        function selectCategoryAndClose(category) {
            filterByCategory(category);
            closeCategoriesModal();
            
            // Scroll to results on mobile
            const resultsSection = document.querySelector('.activities-section');
            if (resultsSection && window.innerWidth <= 768) {
                setTimeout(() => {
                    resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }

        // Change view (grid/list)
        function changeView(view) {
            const grid = document.getElementById('activitiesGrid');
            const buttons = document.querySelectorAll('.view-btn');
            
            if (!grid) return;
            
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.view === view) {
                    btn.classList.add('active');
                }
            });
            
            if (view === 'list') {
                grid.classList.add('list-view');
            } else {
                grid.classList.remove('list-view');
            }
            
            lucide.createIcons();
        }

        // Perform search
        function performSearch() {
            applyFilters();
        }

        // Apply filters
        function applyFilters() {
            const searchInput = document.getElementById('searchInput');
            const categorySelect = document.getElementById('categorySelect');
            
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            const categoryFilter = categorySelect ? categorySelect.value || activeCategory : activeCategory;

            filteredPlaces = allPlaces.filter(place => {
                const matchesSearch = !searchTerm || 
                    place.name.toLowerCase().includes(searchTerm) ||
                    (place.description && place.description.toLowerCase().includes(searchTerm)) ||
                    (place.address && place.address.toLowerCase().includes(searchTerm));

                const matchesCategory = !categoryFilter || place.category === categoryFilter;

                return matchesSearch && matchesCategory;
            });

            renderActivities();
        }

        // Sort activities
        function sortActivities() {
            const sortSelect = document.getElementById('sortSelect');
            if (!sortSelect) return;
            
            const sortValue = sortSelect.value;

            switch (sortValue) {
                case 'rating':
                    filteredPlaces.sort((a, b) => (b.rating || 0) - (a.rating || 0));
                    break;
                case 'distance':
                    filteredPlaces.sort((a, b) => {
                        const distA = a.distance_from_center || 999;
                        const distB = b.distance_from_center || 999;
                        return distA - distB;
                    });
                    break;
                case 'popular':
                    filteredPlaces.sort((a, b) => (b.rating || 0) - (a.rating || 0));
                    break;
                case 'recommended':
                default:
                    filteredPlaces.sort((a, b) => {
                        if (a.is_featured !== b.is_featured) return b.is_featured - a.is_featured;
                        return (b.rating || 0) - (a.rating || 0);
                    });
            }

            renderActivities();
        }

        // Open map modal
        function openMapModal() {
            const modal = document.getElementById('mapModalOverlay');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                
                setTimeout(() => {
                    initMap();
                    lucide.createIcons();
                }, 100);
            }
        }

        // Close map modal
        function closeMapModal() {
            const modal = document.getElementById('mapModalOverlay');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
                closePreview();
            }
        }

        // Initialize map
        function initMap() {
            const mapContainer = document.getElementById('modalMap');
            if (!mapContainer) {
                console.error('Map container not found');
                return;
            }

            if (map) {
                map.remove();
                map = null;
            }

            // Small delay to ensure DOM is ready
            setTimeout(() => {
                try {
                    map = L.map('modalMap').setView([-31.4135, -64.4945], 14);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors',
                        maxZoom: 18
                    }).addTo(map);

                    // Force map to invalidate size after initialization
                    setTimeout(() => {
                        if (map) {
                            map.invalidateSize();
                            updateMapMarkers();
                        }
                    }, 200);
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }, 100);
        }

        // Update map markers
        function updateMapMarkers() {
            if (!map) return;

            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            filteredPlaces.forEach(place => {
                if (!place.latitude || !place.longitude) return;
                
                const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
                const icon = place.icon || categoryInfo.icon;

                const markerIcon = L.divIcon({
                    className: 'custom-activity-marker',
                    html: `<div class="activity-marker"><i data-lucide="${icon}" size="20"></i></div>`,
                    iconSize: [44, 44],
                    iconAnchor: [22, 44]
                });

                const marker = L.marker([place.latitude, place.longitude], { icon: markerIcon })
                    .addTo(map);

                marker.on('click', () => {
                    showActivityPreview(place);
                    map.flyTo([place.latitude, place.longitude], 16);
                });

                markers.push(marker);
            });

            setTimeout(() => lucide.createIcons(), 100);
        }

        // Show activity preview
        let previewState = {
            currentIndex: 0,
            images: [],
            intervalId: null
        };

        function showActivityPreview(place) {
            const preview = document.getElementById('activityPreview');
            const content = document.getElementById('previewContent');
            const imageWrapper = document.getElementById('previewImage');
            
            if (!preview || !content || !imageWrapper) return;
            
            // Clear any existing interval
            if (previewState.intervalId) {
                clearInterval(previewState.intervalId);
                previewState.intervalId = null;
            }
            
            const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
            const stars = place.rating > 0 ? '★'.repeat(Math.round(place.rating)) : '';
            const priceDisplay = getPriceDisplay(place.price_range);
            
            // Simple icon display
            imageWrapper.innerHTML = `
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="${place.icon || categoryInfo.icon}" size="48" style="color: rgba(255, 255, 255, 0.6);"></i>
                </div>
            `;
            
            content.innerHTML = `
                <h3 class="preview-title">${place.name}</h3>
                <div class="preview-location">
                    <i data-lucide="map-pin" size="12"></i>
                    ${place.address || place.city || 'Villa Carlos Paz'}
                </div>
                <div class="preview-details">
                    ${place.rating > 0 ? `
                        <div class="preview-detail">
                            <span style="color: #FFA500; font-size: 0.75rem;">${stars}</span>
                            <span style="font-weight: 700; font-size: 0.75rem; margin-left: 0.25rem;">${place.rating.toFixed(1)}</span>
                        </div>
                    ` : ''}
                    ${place.phone ? `
                        <div class="preview-detail">
                            <i data-lucide="phone" size="12"></i>
                            ${place.phone}
                        </div>
                    ` : ''}
                    ${place.price_range ? `
                        <div class="preview-detail activity-price-container">
                            ${priceDisplay}
                        </div>
                    ` : ''}
                </div>
                <div class="preview-actions">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${place.latitude},${place.longitude}" 
                       target="_blank" 
                       class="preview-btn preview-btn-directions"
                       onclick="event.stopPropagation()">
                        <i data-lucide="navigation" size="14"></i>
                        Cómo llegar
                    </a>
                </div>
            `;
            
            preview.classList.add('active');
            lucide.createIcons();
        }

        // Close preview
        function closePreview() {
            const preview = document.getElementById('activityPreview');
            if (preview) {
                preview.classList.remove('active');
            }
            if (previewState.intervalId) {
                clearInterval(previewState.intervalId);
                previewState.intervalId = null;
            }
        }

        // View on map
        function viewOnMap(id) {
            const place = allPlaces.find(a => a.id === id);
            if (place && place.latitude && place.longitude) {
                openMapModal();
                setTimeout(() => {
                    if (map) {
                        map.flyTo([place.latitude, place.longitude], 16);
                        showActivityPreview(place);
                    }
                }, 300);
            }
        }

        // View activity
        function viewActivity(slug) {
            window.location.href = `./actividad.php?slug=${slug}`;
        }

        // Search input listener
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(window.searchTimeout);
                window.searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 300);
            });
        }

        // Category select listener
        const categorySelect = document.getElementById('categorySelect');
        if (categorySelect) {
            categorySelect.addEventListener('change', (e) => {
                const category = e.target.value;
                
                const chips = document.querySelectorAll('.category-filter-chip');
                chips.forEach(chip => chip.classList.remove('active'));
                
                if (category) {
                    const chip = document.querySelector(`[data-category="${category}"]`);
                    if (chip) chip.classList.add('active');
                    activeCategory = category;
                } else {
                    activeCategory = null;
                }
                
                applyFilters();
            });
        }

        // Close modal on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMapModal();
                closeCategoriesModal();
            }
        });
    </script>
</body>
</html>