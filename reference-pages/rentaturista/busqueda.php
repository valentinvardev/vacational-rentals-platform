<?php
// Incluir configuración de la API
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/config/config.php';

// Obtener parámetros de búsqueda desde URL
$searchParams = [
    'location' => $_GET['location'] ?? '',
    'check_in' => $_GET['check_in'] ?? '',
    'check_out' => $_GET['check_out'] ?? '',
    'guests' => $_GET['guests'] ?? '',
    'category' => $_GET['category'] ?? '',
    'price_range' => $_GET['price_range'] ?? '',
    'property_type' => $_GET['property_type'] ?? '',
    'amenities' => isset($_GET['amenities']) ? explode(',', $_GET['amenities']) : [],
    'sort' => $_GET['sort'] ?? 'recommended',
    'page' => max(1, (int)($_GET['page'] ?? 1)),
    'limit' => 12
];
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    <title>Buscar Alojamientos - RentaTurista | Villa Carlos Paz</title>
    
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

        /* Main Container */
        .search-page {
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

        .view-map-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.15);
        }

        .view-map-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.25);
        }

        .page-subtitle {
            font-size: 1.0625rem;
            color: var(--gray-600);
            line-height: 1.6;
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
            grid-template-columns: 1.5fr 1.5fr 1fr auto auto;
            gap: 1rem;
            align-items: end;
        }

        .search-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .search-field.location-field {
            position: relative;
        }

        .search-field.guests-field {
            position: relative;
        }

        .search-field.calendar-field {
            grid-column: span 2;
        }

        /* Compact buttons for mobile */
        .compact-btn {
            display: none;
        }

        @media (max-width: 768px) {
            .search-bar {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .search-field:nth-child(1),
            .search-field:nth-child(2) {
                grid-column: 1;
            }

            .search-field.location-field {
                display: flex;
                flex-direction: column;
            }

            .search-field.calendar-field {
                grid-column: 1;
            }

            .search-field.guests-field {
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 0.5rem;
                align-items: end;
            }

            .search-field.guests-field .search-label {
                grid-column: 1 / -1;
            }

            .compact-btn.filters-compact {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0 1.25rem;
                height: 48px;
                border-radius: 12px;
                background: var(--white);
                border: 2px solid var(--gray-300);
                color: var(--gray-700);
                font-weight: 500;
                white-space: nowrap;
                gap: 0.5rem;
            }

            .compact-btn.filters-compact span {
                font-size: 0.9375rem;
            }

            .compact-btn.filters-compact:hover {
                border-color: var(--orange-primary);
                color: var(--orange-primary);
            }

            .compact-btn.map-compact {
                display: none;
            }

            .search-btn.search-action-btn,
            .search-btn.filters-trigger-btn {
                display: none;
            }

            .search-btn.mobile-search-btn {
                display: flex;
                width: 100%;
                max-width: none;
                padding: 1rem;
                font-size: 1.0625rem;
                grid-column: 1;
                margin-top: 0.5rem;
                background: var(--orange-primary);
                border-color: var(--orange-primary);
                color: var(--white);
            }

            .search-btn.mobile-search-btn:hover {
                background: var(--orange-dark);
                border-color: var(--orange-dark);
                color: var(--white);
            }
        }

        @media (min-width: 769px) {
            .compact-btn {
                display: none !important;
            }

            .search-btn.mobile-search-btn {
                display: none !important;
            }
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

        .search-select option {
            font-family: var(--font-primary);
            font-weight: 600;
            color: var(--gray-900);
            background: var(--white);
            padding: 0.5rem;
        }

        .location-trigger {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-size: 0.9375rem;
            transition: var(--transition);
            background: var(--white);
            cursor: pointer;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--gray-700);
            font-weight: 500;
        }

        .location-trigger:hover,
        .location-trigger.active {
            border-color: var(--orange-primary);
        }

        .location-trigger.has-value {
            color: var(--gray-900);
            font-weight: 600;
        }

        .location-trigger i {
            color: var(--orange-primary);
        }

        .search-btn {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
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
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.15);
            max-width: 140px;
            width: 100%;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.25);
            background: var(--orange-primary);
            color: var(--white);
        }

        .search-action-btn {
            background: var(--white);
            border-color: var(--gray-300);
            color: var(--gray-700);
        }

        .search-action-btn:hover {
            border-color: var(--gray-700);
            color: var(--gray-900);
            background: var(--white);
        }

        .filters-trigger-btn {
            font-weight: 500;
            border-color: var(--gray-300);
            color: var(--gray-700);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .filters-trigger-btn:hover {
            border-color: var(--gray-700);
            color: var(--gray-900);
            background: var(--white);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        /* CUSTOM CALENDAR */
        
        .calendar-wrapper {
            position: relative;
        }

        .calendar-trigger {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-size: 0.9375rem;
            transition: var(--transition);
            background: var(--white);
            cursor: pointer;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--gray-700);
        }

        .calendar-trigger:hover,
        .calendar-trigger.active {
            border-color: var(--orange-primary);
        }

        .calendar-trigger.has-value {
            color: var(--gray-900);
            font-weight: 600;
        }

        .calendar-popup {
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            padding: 1.25rem;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            min-width: 320px;
        }

        .calendar-popup.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .calendar-nav {
            background: var(--gray-100);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
        }

        .calendar-nav:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        .calendar-month-year {
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-900);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.25rem;
        }

        .calendar-day-name {
            text-align: center;
            font-size: 0.6875rem;
            font-weight: 700;
            color: var(--gray-600);
            padding: 0.5rem;
            text-transform: uppercase;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
            position: relative;
        }

        .calendar-day:hover:not(.disabled):not(.other-month) {
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
        }

        .calendar-day.other-month {
            color: var(--gray-400);
            cursor: default;
        }

        .calendar-day.disabled {
            color: var(--gray-300);
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .calendar-day.today {
            border: 2px solid var(--orange-primary);
        }

        .calendar-day.selected-start,
        .calendar-day.selected-end {
            background: var(--orange-primary);
            color: var(--white);
        }

        .calendar-day.in-range {
            background: rgba(255, 107, 53, 0.15);
            color: var(--orange-dark);
        }

        .calendar-day.selected-start {
            border-radius: 8px 0 0 8px;
        }

        .calendar-day.selected-end {
            border-radius: 0 8px 8px 0;
        }

        .calendar-day.selected-start.selected-end {
            border-radius: 8px;
        }

        .calendar-footer {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid var(--gray-200);
        }

        .calendar-footer button {
            flex: 1;
            padding: 0.625rem;
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-calendar-clear {
            background: var(--white);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-calendar-clear:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .btn-calendar-apply {
            background: var(--orange-primary);
            border: none;
            color: var(--white);
        }

        .btn-calendar-apply:hover {
            background: var(--orange-dark);
        }

        .calendar-instruction {
            text-align: center;
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .calendar-instruction.active {
            color: var(--orange-primary);
            font-weight: 700;
        }

        /* CALENDAR MODAL FOR MOBILE */
        
        .calendar-modal-overlay {
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

        .calendar-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .calendar-modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 24px 24px 0 0;
            padding: 1.5rem;
            z-index: 2001;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-height: 85vh;
            overflow-y: auto;
        }

        .calendar-modal-overlay.active .calendar-modal {
            transform: translateY(0);
        }

        .calendar-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .calendar-modal-close {
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
        }

        .calendar-modal-body {
            padding: 0;
        }

        .calendar-modal-body .calendar-instruction {
            margin-bottom: 1rem;
        }

        .calendar-modal-body .calendar-header {
            margin-bottom: 1rem;
        }

        .calendar-modal-body .calendar-grid {
            margin-bottom: 1rem;
        }

        .calendar-modal-body .calendar-footer {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }

        /* Categories Section */
        .categories-section {
            margin-bottom: 4rem;
        }

        /* Mobile Quick Access Cards */
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

            .categories-section {
                display: none;
            }

            .page-header .view-map-btn {
                display: none;
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

        .quick-access-card:active {
            transform: scale(0.98);
        }

        .quick-access-card.map-card,
        .quick-access-card.categories-card {
            background: var(--white);
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

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 0 clamp(1rem, 3vw, 2rem);
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

        .view-all-link {
            color: var(--orange-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            transition: var(--transition);
        }

        .view-all-link:hover {
            gap: 0.625rem;
        }

        /* Category Slider */
        .category-slider-wrapper {
            position: relative;
            overflow: hidden;
        }

        .category-slider {
            display: flex;
            gap: 1rem;
            padding: 0.5rem 0;
            padding-left: clamp(1rem, 3vw, 2rem);
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .category-slider::-webkit-scrollbar {
            display: none;
        }

        .category-card {
            min-width: 220px;
            max-width: 220px;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            flex-shrink: 0;
            border: 2px solid transparent;
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--orange-primary);
        }

        .category-card.active {
            border-color: var(--orange-primary);
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.2);
        }

        .category-image {
            width: 100%;
            height: 140px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .category-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="1.5" fill="%23fff" opacity="0.1"/></svg>') repeat;
        }

        .category-icon {
            position: relative;
            z-index: 1;
        }

        .category-content {
            padding: 1rem;
        }

        .category-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.375rem;
        }

        .category-count {
            font-size: 0.8125rem;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Slider Navigation */
        .slider-nav-wrapper {
            display: none;
            position: relative;
            margin-top: 1.5rem;
        }

        @media (min-width: 1025px) {
            .slider-nav-wrapper {
                display: block;
            }
        }

        .slider-nav-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
        }

        .slider-nav-btn {
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

        .slider-nav-btn:hover:not(:disabled) {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            transform: scale(1.05);
        }

        .slider-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Properties Section */
        .properties-section {
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

        .active-filters {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.875rem;
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .filter-tag button {
            background: none;
            border: none;
            color: var(--orange-primary);
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .filter-tag button:hover {
            transform: scale(1.1);
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

        /* Properties Grid */
        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .properties-grid.list-view {
            grid-template-columns: 1fr;
        }

        /* Property Card */
        .property-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
            cursor: pointer;
            border: 2px solid transparent;
        }

        .property-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: var(--orange-primary);
        }

        .property-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            overflow: hidden;
        }

        .property-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
        }

        .favorite-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
            z-index: 10;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background: var(--white);
        }

        .favorite-btn.active {
            color: #EF4444;
        }

        .property-badge {
            position: absolute;
            bottom: 1rem;
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
        }

        .property-content {
            padding: 1.25rem;
        }

        .property-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
        }

        .property-type {
            font-size: 0.8125rem;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .property-rating {
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

        .property-title {
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

        .property-location {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .property-features {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-700);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .feature i {
            color: var(--orange-primary);
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

        .price-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 600;
        }

        .view-details-btn {
            background: var(--orange-primary);
            color: var(--white);
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .view-details-btn:hover {
            background: var(--orange-dark);
            transform: translateX(2px);
            gap: 0.5rem;
        }

        /* List View Styles */
        .properties-grid.list-view .property-card {
            display: grid;
            grid-template-columns: 300px 1fr;
        }

        .properties-grid.list-view .property-image-wrapper {
            height: 100%;
            min-height: 250px;
        }

        .properties-grid.list-view .property-content {
            padding: 1.5rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
        }

        .pagination-btn {
            min-width: 44px;
            height: 44px;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.9375rem;
            padding: 0 0.75rem;
        }

        .pagination-btn:hover:not(:disabled):not(.active) {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .pagination-btn.active {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: var(--white);
        }

        .pagination-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
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

        .empty-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--orange-primary);
            color: var(--white);
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-family: var(--font-primary);
            font-size: 1rem;
        }

        .empty-action:hover {
            background: var(--orange-dark);
            transform: translateY(-2px);
        }

        /* MAP MODAL */
        
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
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: var(--white);
            border-radius: 24px;
            width: 90%;
            max-width: 500px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            z-index: 2001;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .map-modal-overlay.active .map-modal {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .map-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
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
            padding: 2rem;
            text-align: center;
        }

        .map-preview-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1) 0%, rgba(255, 107, 53, 0.05) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            border: 2px dashed var(--gray-300);
        }

        .map-preview-image i {
            color: var(--orange-primary);
            opacity: 0.4;
        }

        .map-modal-description {
            font-size: 1rem;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .map-modal-footer {
            padding: 1.5rem 2rem;
            border-top: 2px solid var(--gray-200);
            display: flex;
            gap: 1rem;
            background: var(--gray-50);
        }

        .map-modal-footer button,
        .map-modal-footer a {
            flex: 1;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-map-cancel {
            background: var(--white);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-map-cancel:hover {
            border-color: var(--gray-700);
            color: var(--gray-900);
        }

        .btn-map-confirm {
            background: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .btn-map-confirm:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        /* CATEGORIES MODAL */
        
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

        /* LOCATION MODAL */
        
        .location-modal-overlay {
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

        .location-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .location-modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 24px 24px 0 0;
            padding: 0;
            z-index: 2001;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .location-modal-overlay.active .location-modal {
            transform: translateY(0);
        }

        .location-modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            flex-shrink: 0;
        }

        .location-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .location-modal-title i {
            color: var(--orange-primary);
        }

        .location-modal-close {
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

        .location-modal-close:hover {
            background: var(--gray-200);
        }

        .location-modal-body {
            padding: 1rem 0;
            overflow-y: auto;
            flex: 1;
        }

        .location-group {
            margin-bottom: 1.5rem;
        }

        .location-group-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1.5rem;
            margin-bottom: 0.5rem;
        }

        .location-list {
            display: flex;
            flex-direction: column;
        }

        .location-item {
            background: var(--white);
            border: none;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-primary);
            text-align: left;
            border-bottom: 1px solid var(--gray-100);
        }

        .location-item:hover {
            background: var(--gray-50);
        }

        .location-item:active {
            background: rgba(255, 107, 53, 0.05);
        }

        .location-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .location-name {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .location-distance {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .location-item i {
            color: var(--gray-400);
        }

        /* Active filters for mobile */
        .filters-overflow-btn {
            display: none;
            padding: 0.5rem 0.875rem;
            background: var(--orange-primary);
            color: var(--white);
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .filters-overflow-btn:active {
            transform: scale(0.95);
        }

        @media (max-width: 768px) {
            .active-filters {
                position: relative;
            }

            .active-filters .filter-tag:nth-child(n+4) {
                display: none;
            }

            .active-filters.has-overflow .filters-overflow-btn {
                display: inline-block;
            }
        }

        /* FILTERS MODAL */
        
        .filters-modal-overlay {
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

        .filters-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .filters-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: var(--white);
            border-radius: 24px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            z-index: 2001;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
        }

        .filters-modal-overlay.active .filters-modal {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .filters-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            flex-shrink: 0;
        }

        .filters-modal-title {
            font-size: 1.375rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--black);
        }

        .filters-modal-close {
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--black);
            transition: var(--transition);
        }

        .filters-modal-close:hover {
            background: var(--gray-100);
        }

        .filters-modal-body {
            padding: 2rem;
            overflow-y: auto;
            flex: 1;
        }

        .filters-modal-footer {
            padding: 1.25rem 2rem;
            border-top: 2px solid var(--gray-200);
            display: flex;
            gap: 1rem;
            background: var(--gray-50);
            flex-shrink: 0;
        }

        .filters-modal-footer button {
            flex: 1;
            padding: 0.875rem;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 700;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-clear-filters {
            background: var(--white);
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-clear-filters:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .btn-apply-filters {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border: none;
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .btn-apply-filters:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-group-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.625rem;
        }

        .filter-chip {
            padding: 0.625rem 1rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 24px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .filter-chip:hover {
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
            transform: translateY(-1px);
        }

        .filter-chip.active {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: var(--white);
        }

        .filter-chip.active:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
        }

        .price-range-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .price-chip {
            padding: 1rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 14px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .price-chip:hover {
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
            transform: translateY(-2px);
        }

        .price-chip.active {
            background: var(--orange-primary);
            border-color: var(--orange-primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .price-symbols {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
            color: var(--orange-primary);
        }

        .price-chip.active .price-symbols {
            color: var(--white);
        }

        .price-range {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
        }

        .price-chip.active .price-range {
            color: rgba(255, 255, 255, 0.95);
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .properties-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .properties-grid.list-view .property-card {
                grid-template-columns: 1fr;
            }

            .properties-grid.list-view .property-image-wrapper {
                height: 200px;
            }

            .category-card {
                min-width: 200px;
                max-width: 200px;
            }

            .filters-modal {
                width: 100%;
                max-width: 100%;
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
                top: 0;
                left: 0;
                transform: scale(0.9);
            }

            .filters-modal-overlay.active .filters-modal {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .search-page {
                padding: 1.5rem 0;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .page-header {
                margin-bottom: 1.5rem;
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

            .properties-grid {
                grid-template-columns: 1fr;
            }

            .category-card {
                min-width: 180px;
                max-width: 180px;
            }

            .category-image {
                height: 120px;
            }
        }

        /* Desktop location modal becomes centered */
        @media (min-width: 769px) {
            .location-modal {
                position: fixed;
                top: 50%;
                left: 50%;
                bottom: auto;
                transform: translate(-50%, -50%) scale(0.9);
                border-radius: 24px;
                max-width: 500px;
                width: 90%;
                max-height: 70vh;
            }

            .location-modal-overlay.active .location-modal {
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <main class="search-page">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i data-lucide="search" size="32"></i>
                    Encuentra tu hospedaje
                </h1>
                <button type="button" class="view-map-btn" onclick="openMapModal()">
                    <i data-lucide="map" size="20"></i>
                    Ver mapa
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar-wrapper">
                <form class="search-bar" id="searchForm">
                    <div class="search-field location-field">
                        <label class="search-label">Ubicación</label>
                        <button type="button" class="location-trigger" id="locationTrigger" onclick="openLocationModal()">
                            <span id="locationDisplay">¿Dónde querés hospedarte?</span>
                            <i data-lucide="map-pin" size="16"></i>
                        </button>
                        <a href="mapa.php" class="search-btn compact-btn map-compact">
                            <i data-lucide="map" size="20"></i>
                            <span>Mapa</span>
                        </a>
                    </div>
                    <div class="search-field calendar-wrapper calendar-field">
                        <label class="search-label">Fechas de estadía</label>
                        <button type="button" class="calendar-trigger" id="datesTrigger" onclick="toggleCalendar(event)">
                            <span id="datesDisplay">Seleccionar fechas</span>
                            <i data-lucide="calendar" size="16"></i>
                        </button>
                        <div class="calendar-popup" id="calendarPopup">
                            <div class="calendar-instruction" id="calendarInstruction">
                                Selecciona la fecha de llegada
                            </div>
                            <div class="calendar-header">
                                <button type="button" class="calendar-nav" onclick="changeMonth(-1)">
                                    <i data-lucide="chevron-left" size="16"></i>
                                </button>
                                <div class="calendar-month-year" id="calendarMonthYear"></div>
                                <button type="button" class="calendar-nav" onclick="changeMonth(1)">
                                    <i data-lucide="chevron-right" size="16"></i>
                                </button>
                            </div>
                            <div class="calendar-grid" id="calendarGrid"></div>
                            <div class="calendar-footer">
                                <button type="button" class="btn-calendar-clear" onclick="clearDates()">Limpiar</button>
                                <button type="button" class="btn-calendar-apply" onclick="applyDates()">Aplicar</button>
                            </div>
                        </div>
                    </div>
                    <div class="search-field guests-field">
                        <label class="search-label">Huéspedes</label>
                        <select class="search-input search-select" id="guestsSelect">
                            <option value="">Cualquiera</option>
                            <option value="1">1 huésped</option>
                            <option value="2">2 huéspedes</option>
                            <option value="3">3 huéspedes</option>
                            <option value="4">4 huéspedes</option>
                            <option value="5">5 huéspedes</option>
                            <option value="6">6 huéspedes</option>
                            <option value="7">7 huéspedes</option>
                            <option value="8">8+ huéspedes</option>
                        </select>
                        <button type="button" class="search-btn compact-btn filters-compact" onclick="openFiltersModal()">
                            <i data-lucide="sliders-horizontal" size="20"></i>
                            <span>Filtros</span>
                        </button>
                    </div>
                    <button type="button" class="search-btn search-action-btn" onclick="performSearch()">
                        <i data-lucide="search" size="20"></i>
                        Buscar
                    </button>
                    <button type="button" class="search-btn filters-trigger-btn" onclick="openFiltersModal()">
                        <i data-lucide="sliders-horizontal" size="20"></i>
                        Filtros
                    </button>
                    <button type="button" class="search-btn mobile-search-btn" onclick="performSearch()">
                        <i data-lucide="search" size="20"></i>
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Mobile Quick Access Cards -->
            <div class="mobile-quick-access">
                <div class="quick-access-card map-card" onclick="openMapModal()">
                    <div class="quick-access-icon">
                        <i data-lucide="map" size="24"></i>
                    </div>
                    <h3 class="quick-access-title">Mapa</h3>
                </div>
                <div class="quick-access-card categories-card" onclick="openCategoriesModal()">
                    <div class="quick-access-icon">
                        <i data-lucide="grid-3x3" size="24"></i>
                    </div>
                    <h3 class="quick-access-title">Categorías</h3>
                </div>
            </div>

            <!-- Categories Section -->
            <section class="categories-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i data-lucide="search" size="28"></i>
                        Explorar por categoría
                    </h2>
                    <a href="#" class="view-all-link">
                        Ver todas
                        <i data-lucide="arrow-right" size="16"></i>
                    </a>
                </div>

                <div class="category-slider-wrapper">
                    <div class="category-slider" id="categorySlider">
                        <div class="category-card" data-category="apartment" onclick="filterByCategory('apartment')">
                            <div class="category-image">
                                <i data-lucide="building-2" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Departamentos</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    32 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="house" onclick="filterByCategory('house')">
                            <div class="category-image">
                                <i data-lucide="home" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Casas</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    45 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="pool" onclick="filterByCategory('pool')">
                            <div class="category-image">
                                <i data-lucide="waves" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Con Piscina</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    28 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="grill" onclick="filterByCategory('grill')">
                            <div class="category-image">
                                <i data-lucide="flame" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Con Parrilla</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    38 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="family" onclick="filterByCategory('family')">
                            <div class="category-image">
                                <i data-lucide="users" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Para Familias</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    52 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="pets" onclick="filterByCategory('pets')">
                            <div class="category-image">
                                <i data-lucide="dog" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Pet Friendly</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    24 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="cabin" onclick="filterByCategory('cabin')">
                            <div class="category-image">
                                <i data-lucide="mountain" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Cabañas</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    18 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="lake-view" onclick="filterByCategory('lake-view')">
                            <div class="category-image">
                                <i data-lucide="eye" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Vista al Lago</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    16 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="downtown" onclick="filterByCategory('downtown')">
                            <div class="category-image">
                                <i data-lucide="map-pin" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Céntrico</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    41 propiedades
                                </p>
                            </div>
                        </div>

                        <div class="category-card" data-category="parking" onclick="filterByCategory('parking')">
                            <div class="category-image">
                                <i data-lucide="car" size="56" class="category-icon"></i>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title">Con Cochera</h3>
                                <p class="category-count">
                                    <i data-lucide="home" size="14"></i>
                                    48 propiedades
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="slider-nav-wrapper">
                    <div class="slider-nav-buttons">
                        <button class="slider-nav-btn" id="categoryPrevBtn" onclick="slideCategoriesLeft()">
                            <i data-lucide="chevron-left" size="20"></i>
                        </button>
                        <button class="slider-nav-btn" id="categoryNextBtn" onclick="slideCategoriesRight()">
                            <i data-lucide="chevron-right" size="20"></i>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Properties Section -->
            <section class="properties-section">
                <div class="results-bar">
                    <div class="results-info">
                        <p class="results-count">
                            <strong id="resultsCount">0</strong> propiedades disponibles
                        </p>
                        <div class="active-filters" id="activeFilters">
                            <!-- Active filter tags will appear here -->
                        </div>
                    </div>
                    <div class="sort-controls">
                        <label class="sort-label">Ordenar por:</label>
                        <select class="sort-select" id="sortSelect" onchange="sortProperties()">
                            <option value="recommended">Recomendadas</option>
                            <option value="price-low">Precio: menor a mayor</option>
                            <option value="price-high">Precio: mayor a menor</option>
                            <option value="rating">Mejor calificadas</option>
                            <option value="newest">Más recientes</option>
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

                <!-- Properties Grid -->
                <div class="properties-grid" id="propertiesGrid">
                    <!-- Properties will be loaded here dynamically -->
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <!-- Pagination will be rendered here -->
                </div>
            </section>
        </div>
    </main>

    <?php include './includes/footer.php'; ?>

    <!-- Modals -->
    <!-- Map Modal -->
    <div class="map-modal-overlay" id="mapModalOverlay" onclick="closeMapModal()">
        <div class="map-modal" onclick="event.stopPropagation()">
            <div class="map-modal-header">
                <h3 class="map-modal-title">
                    <i data-lucide="map" size="28"></i>
                    Explorar mapa
                </h3>
                <button class="map-modal-close" onclick="closeMapModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="map-modal-body">
                <div class="map-preview-image">
                    <i data-lucide="map-pin" size="80"></i>
                </div>
                <p class="map-modal-description">
                    Explora propiedades en un mapa interactivo de Villa Carlos Paz. Visualiza ubicaciones, precios y filtra por zona.
                </p>
            </div>

            <div class="map-modal-footer">
                <button class="btn-map-cancel" onclick="closeMapModal()">
                    No, gracias
                </button>
                <a href="mapa.php" class="btn-map-confirm">
                    <i data-lucide="map" size="20"></i>
                    Probar
                </a>
            </div>
        </div>
    </div>

    <!-- Filters Modal -->
    <div class="filters-modal-overlay" id="filtersModalOverlay" onclick="closeFiltersModal()">
        <div class="filters-modal" onclick="event.stopPropagation()">
            <div class="filters-modal-header">
                <h3 class="filters-modal-title">
                    <i data-lucide="sliders-horizontal" size="24"></i>
                    Filtrar búsqueda
                </h3>
                <button class="filters-modal-close" onclick="closeFiltersModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="filters-modal-body">
                <!-- Price Range -->
                <div class="filter-group">
                    <h4 class="filter-group-title">
                        <i data-lucide="dollar-sign" size="16"></i>
                        Rango de Precio
                    </h4>
                    <div class="price-range-grid">
                        <div class="price-chip" data-price="1" onclick="togglePriceFilter(1)">
                            <div class="price-symbols">$</div>
                            <div class="price-range">$0 - $45K</div>
                        </div>
                        <div class="price-chip" data-price="2" onclick="togglePriceFilter(2)">
                            <div class="price-symbols">$$</div>
                            <div class="price-range">$45K - $100K</div>
                        </div>
                        <div class="price-chip" data-price="3" onclick="togglePriceFilter(3)">
                            <div class="price-symbols">$$$</div>
                            <div class="price-range">$100K - $150K</div>
                        </div>
                        <div class="price-chip" data-price="4" onclick="togglePriceFilter(4)">
                            <div class="price-symbols">$$$$</div>
                            <div class="price-range">$150K+</div>
                        </div>
                    </div>
                </div>

                <!-- Property Type -->
                <div class="filter-group">
                    <h4 class="filter-group-title">
                        <i data-lucide="home" size="16"></i>
                        Tipo de Propiedad
                    </h4>
                    <div class="filter-chips">
                        <button class="filter-chip" data-type="house" onclick="toggleTypeFilter('house')">
                            <i data-lucide="home" size="14"></i>
                            Casa
                        </button>
                        <button class="filter-chip" data-type="apartment" onclick="toggleTypeFilter('apartment')">
                            <i data-lucide="building-2" size="14"></i>
                            Departamento
                        </button>
                        <button class="filter-chip" data-type="cabin" onclick="toggleTypeFilter('cabin')">
                            <i data-lucide="mountain" size="14"></i>
                            Cabaña
                        </button>
                        <button class="filter-chip" data-type="loft" onclick="toggleTypeFilter('loft')">
                            <i data-lucide="hotel" size="14"></i>
                            Loft
                        </button>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="filter-group">
                    <h4 class="filter-group-title">
                        <i data-lucide="sparkles" size="16"></i>
                        Comodidades
                    </h4>
                    <div class="filter-chips">
                        <button class="filter-chip" data-amenity="wifi" onclick="toggleAmenityFilter('wifi')">
                            <i data-lucide="wifi" size="14"></i>
                            WiFi
                        </button>
                        <button class="filter-chip" data-amenity="pool" onclick="toggleAmenityFilter('pool')">
                            <i data-lucide="waves" size="14"></i>
                            Piscina
                        </button>
                        <button class="filter-chip" data-amenity="parking" onclick="toggleAmenityFilter('parking')">
                            <i data-lucide="car" size="14"></i>
                            Cochera
                        </button>
                        <button class="filter-chip" data-amenity="ac" onclick="toggleAmenityFilter('ac')">
                            <i data-lucide="air-vent" size="14"></i>
                            A/C
                        </button>
                        <button class="filter-chip" data-amenity="heating" onclick="toggleAmenityFilter('heating')">
                            <i data-lucide="flame" size="14"></i>
                            Calefacción
                        </button>
                        <button class="filter-chip" data-amenity="kitchen" onclick="toggleAmenityFilter('kitchen')">
                            <i data-lucide="chef-hat" size="14"></i>
                            Cocina
                        </button>
                    </div>
                </div>
            </div>

            <div class="filters-modal-footer">
                <button class="btn-clear-filters" onclick="clearAllFilters()">
                    Limpiar filtros
                </button>
                <button class="btn-apply-filters" onclick="applyFiltersAndClose()">
                    Aplicar filtros
                </button>
            </div>
        </div>
    </div>

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
                    <div class="modal-category-card" onclick="selectCategoryAndClose('apartment')">
                        <div class="modal-category-icon">
                            <i data-lucide="building-2" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Departamentos</h4>
                            <p class="modal-category-count">32 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('house')">
                        <div class="modal-category-icon">
                            <i data-lucide="home" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Casas</h4>
                            <p class="modal-category-count">45 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card"
<div class="modal-category-card" onclick="selectCategoryAndClose('pool')">
                        <div class="modal-category-icon">
                            <i data-lucide="waves" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Con Piscina</h4>
                            <p class="modal-category-count">28 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('grill')">
                        <div class="modal-category-icon">
                            <i data-lucide="flame" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Con Parrilla</h4>
                            <p class="modal-category-count">38 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('family')">
                        <div class="modal-category-icon">
                            <i data-lucide="users" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Para Familias</h4>
                            <p class="modal-category-count">52 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('pets')">
                        <div class="modal-category-icon">
                            <i data-lucide="dog" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Pet Friendly</h4>
                            <p class="modal-category-count">24 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('cabin')">
                        <div class="modal-category-icon">
                            <i data-lucide="mountain" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Cabañas</h4>
                            <p class="modal-category-count">18 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('lake-view')">
                        <div class="modal-category-icon">
                            <i data-lucide="eye" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Vista al Lago</h4>
                            <p class="modal-category-count">16 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('downtown')">
                        <div class="modal-category-icon">
                            <i data-lucide="map-pin" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Céntrico</h4>
                            <p class="modal-category-count">41 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>

                    <div class="modal-category-card" onclick="selectCategoryAndClose('parking')">
                        <div class="modal-category-icon">
                            <i data-lucide="car" size="32"></i>
                        </div>
                        <div class="modal-category-info">
                            <h4 class="modal-category-title">Con Cochera</h4>
                            <p class="modal-category-count">48 propiedades</p>
                        </div>
                        <i data-lucide="chevron-right" size="20" class="modal-category-arrow"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Modal -->
    <div class="location-modal-overlay" id="locationModalOverlay" onclick="closeLocationModal()">
        <div class="location-modal" onclick="event.stopPropagation()">
            <div class="location-modal-header">
                <h3 class="location-modal-title">
                    <i data-lucide="map-pin" size="24"></i>
                    Seleccionar ubicación
                </h3>
                <button class="location-modal-close" onclick="closeLocationModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="location-modal-body">
                <div class="location-group">
                    <h4 class="location-group-title">Villa Carlos Paz</h4>
                    <div class="location-list">
                        <button class="location-item" onclick="selectLocation('Centro', 0)">
                            <div class="location-info">
                                <span class="location-name">Centro</span>
                                <span class="location-distance">Centro de VCP</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('San Antonio', 2)">
                            <div class="location-info">
                                <span class="location-name">San Antonio</span>
                                <span class="location-distance">2 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Mayu Sumaj', 5)">
                            <div class="location-info">
                                <span class="location-name">Mayu Sumaj</span>
                                <span class="location-distance">5 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Villa del Lago', 8)">
                            <div class="location-info">
                                <span class="location-name">Villa del Lago</span>
                                <span class="location-distance">8 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Villa del Lago Azul', 10)">
                            <div class="location-info">
                                <span class="location-name">Villa del Lago Azul</span>
                                <span class="location-distance">10 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                    </div>
                </div>

                <div class="location-group">
                    <h4 class="location-group-title">Ubicaciones Cercanas</h4>
                    <div class="location-list">
                        <button class="location-item" onclick="selectLocation('Bialet Massé', 12)">
                            <div class="location-info">
                                <span class="location-name">Bialet Massé</span>
                                <span class="location-distance">12 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Santa María de Punilla', 15)">
                            <div class="location-info">
                                <span class="location-name">Santa María de Punilla</span>
                                <span class="location-distance">15 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Estancia Vieja', 18)">
                            <div class="location-info">
                                <span class="location-name">Estancia Vieja</span>
                                <span class="location-distance">18 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Icho Cruz', 22)">
                            <div class="location-info">
                                <span class="location-name">Icho Cruz</span>
                                <span class="location-distance">22 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                        <button class="location-item" onclick="selectLocation('Tanti', 25)">
                            <div class="location-info">
                                <span class="location-name">Tanti</span>
                                <span class="location-distance">25 km del centro</span>
                            </div>
                            <i data-lucide="chevron-right" size="18"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal for Mobile -->
    <div class="calendar-modal-overlay" id="calendarModalOverlay" onclick="closeCalendarModal()">
        <div class="calendar-modal" onclick="event.stopPropagation()">
            <div class="calendar-modal-header">
                <h3 class="calendar-modal-title">Seleccionar fechas</h3>
                <button class="calendar-modal-close" onclick="closeCalendarModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="calendar-modal-body">
                <div class="calendar-instruction" id="calendarModalInstruction">
                    Selecciona la fecha de llegada
                </div>
                <div class="calendar-header">
                    <button class="calendar-nav" onclick="changeModalMonth(-1)">
                        <i data-lucide="chevron-left" size="16"></i>
                    </button>
                    <div class="calendar-month-year" id="calendarModalMonthYear"></div>
                    <button class="calendar-nav" onclick="changeModalMonth(1)">
                        <i data-lucide="chevron-right" size="16"></i>
                    </button>
                </div>
                <div class="calendar-grid" id="calendarModalGrid"></div>
                <div class="calendar-footer">
                    <button class="btn-calendar-clear" onclick="clearModalDates()">Limpiar</button>
                    <button class="btn-calendar-apply" onclick="applyModalDates()">Aplicar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Configuration
        const API_BASE_URL = '/rentaturista/api';
        
        // API Helper Functions
        const API = {
            async get(endpoint, params = {}) {
                const url = new URL(`${API_BASE_URL}${endpoint}`, window.location.origin);
                Object.keys(params).forEach(key => {
                    if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                        url.searchParams.append(key, params[key]);
                    }
                });
                
                try {
                    const response = await fetch(url);
                    const data = await response.json();
                    
                    if (!data.success) {
                        throw new Error(data.message || 'Error en la API');
                    }
                    
                    return data.data;
                } catch (error) {
                    console.error('API Error:', error);
                    throw error;
                }
            }
        };

        // Search state from PHP
        const INITIAL_SEARCH_PARAMS = <?php echo json_encode($searchParams); ?>;
// ==================== STATE MANAGEMENT ====================
        
    let searchState = {
    ...INITIAL_SEARCH_PARAMS,
    properties: [],
    totalResults: 0,
    loading: false,
    search: '',  // ✅ AGREGAR ESTO
    guests: '',   // ✅ AGREGAR ESTO
    propertyTypes: [],
    activeFilters: {
        price: INITIAL_SEARCH_PARAMS.price_range ? [parseInt(INITIAL_SEARCH_PARAMS.price_range)] : [],
        type: INITIAL_SEARCH_PARAMS.property_type ? [INITIAL_SEARCH_PARAMS.property_type] : [],
        amenities: INITIAL_SEARCH_PARAMS.amenities || []
    }
};

        // ==================== INITIALIZATION ====================
        
        document.addEventListener('DOMContentLoaded', async function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Load initial data
            await Promise.all([
                loadProperties(),
                loadPropertyTypes()
            ]);
            
            // Restore search form values
            restoreSearchForm();
            
            // Update active filters display
            updateActiveFiltersDisplay();
        });

        // ==================== DATA LOADING ====================
        
async function loadProperties() {
    searchState.loading = true;
    showLoadingState();
    
    try {
        // Construir parámetros
        const params = {
            status: 'active',
            limit: 100
        };
        
        // Agregar búsqueda por texto
        if (searchState.search && searchState.search.trim()) {
            params.search = searchState.search.trim();
        }
        
        console.log('Loading properties with params:', params);
        
       const response = await fetch(`${API_BASE_URL}/properties?` + new URLSearchParams(params));
        const data = await response.json();
        
        console.log('Properties API response:', data);
        
        if (data.success && data.data) {
            let properties = data.data.properties || [];
            
            // ✅ FILTRAR DEL LADO DEL CLIENTE
            
            // Filtro de huéspedes
            if (searchState.guests) {
                const guestsNum = parseInt(searchState.guests);
                properties = properties.filter(p => 
                    (p.features?.max_guests || 0) >= guestsNum
                );
            }
            
            // Filtro de precio
            if (searchState.activeFilters.price.length > 0) {
                properties = properties.filter(p => 
                    searchState.activeFilters.price.includes(p.pricing?.price_range || 0)
                );
            }
            
            // Filtro de tipo de propiedad
            if (searchState.activeFilters.type.length > 0) {
                properties = properties.filter(p => 
                    searchState.activeFilters.type.includes(p.type?.id || 0)
                );
            }
            
            // Filtro de amenidades (placeholder - requiere backend)
            // Por ahora solo visual
            if (searchState.activeFilters.amenities.length > 0) {
                console.log('Amenity filters active:', searchState.activeFilters.amenities);
                // TODO: Implementar cuando el backend soporte amenities
            }
            
            searchState.properties = properties;
            searchState.totalResults = properties.length;
            
            renderProperties(properties);
            updateResultsCount();
            
        } else {
            console.error('Error loading properties:', data);
            renderPropertiesError();
        }
    } catch (error) {
        console.error('Error fetching properties:', error);
        renderPropertiesError();
    } finally {
        searchState.loading = false;
    }
}


     async function loadPropertyTypes() {
    try {
     const response = await fetch(`${API_BASE_URL}/property-types`);

        const data = await response.json();
        
        if (data.success) {
            searchState.propertyTypes = data.data || [];
            renderPropertyTypesInFilter();
        }
    } catch (error) {
        console.error('Error loading property types:', error);
    }
}
        
        
        
        // Search
function performSearch() {
    searchState.search = document.getElementById('searchInput')?.value || '';
    searchState.guests = document.getElementById('guestsSelect')?.value || '';
    loadProperties();
}
        
        

        // ==================== RENDERING ====================
        
        function renderProperties() {
            const grid = document.getElementById('propertiesGrid');
            
            if (searchState.properties.length === 0) {
                showEmptyState();
                return;
            }
            
            grid.innerHTML = searchState.properties.map(property => createPropertyCard(property)).join('');
            lucide.createIcons();
        }



        function renderPropertyTypesInFilter() {
 // Buscar el contenedor de tipos de propiedad directamente
const filterGroups = document.querySelectorAll('.filter-group');
let typeChipsContainer = null;

filterGroups.forEach(group => {
    const title = group.querySelector('.filter-group-title');
    if (title && title.textContent.includes('Tipo de Propiedad')) {
        typeChipsContainer = group.querySelector('.filter-chips');
    }
});
    if (!typeChipsContainer || !searchState.propertyTypes.length) return;
    
    // Limpiar chips estáticos y agregar dinámicos
    typeChipsContainer.innerHTML = searchState.propertyTypes.map(type => `
        <button class="filter-chip" data-type="${type.id}" onclick="toggleTypeFilter(${type.id})">
            <i data-lucide="${type.icon || 'home'}" size="14"></i>
            ${type.name}
        </button>
    `).join('');
    
    lucide.createIcons();
}


function createPropertyCard(property) {
    // ✅ Extraer datos de la nueva estructura anidada
    const typeName = property.type?.name || property.type_name || 'Propiedad';
    const typeIcon = property.type?.icon || property.type_icon || 'home';
    const bedrooms = property.features?.bedrooms || property.bedrooms || 0;
    const bathrooms = property.features?.bathrooms || property.bathrooms || 0;
    const maxGuests = property.features?.max_guests || property.max_guests || 0;
    const priceRange = property.pricing?.price_range || property.price_range || 2;
    const rating = property.stats?.average_rating || property.average_rating || 0;
    const isFeatured = property.featured || property.is_featured || false;
    const address = property.location?.address || property.address || 'Villa Carlos Paz';
    
  // Manejar imágenes - usar primary_image directamente
const primaryImageUrl = property.primary_image || null;
    
    const priceIcons = getPriceIcons(priceRange);
    const priceLabel = getPriceRangeLabel(priceRange);
    
    return `
        <article class="property-card" onclick="viewProperty(${property.id})">
            <div class="property-image-wrapper">
               ${primaryImageUrl ? `
    <img src="${primaryImageUrl}" alt="${escapeHtml(property.title)}" class="property-image" loading="lazy">
` : `
                    <div class="property-placeholder">
                        <i data-lucide="${typeIcon}" size="64"></i>
                    </div>
                `}
                <button class="favorite-btn" onclick="toggleFavorite(this, event)">
                    <i data-lucide="heart" size="20"></i>
                </button>
                ${isFeatured ? '<span class="property-badge">Destacada</span>' : ''}
            </div>
            <div class="property-content">
                <div class="property-header">
                    <span class="property-type">${typeName}</span>
                    ${rating > 0 ? `
                        <div class="property-rating">
                            <span class="rating-stars">★</span>
                            <span class="rating-value">${rating.toFixed(1)}</span>
                        </div>
                    ` : ''}
                </div>
                <h3 class="property-title">${escapeHtml(property.title)}</h3>
                <p class="property-location">
                    <i data-lucide="map-pin" size="14"></i>
                    ${escapeHtml(address)}
                </p>
                <div class="property-features">
                    ${bedrooms ? `
                        <div class="feature">
                            <i data-lucide="bed-double" size="16"></i>
                            <span>${bedrooms}</span>
                        </div>
                    ` : ''}
                    ${bathrooms ? `
                        <div class="feature">
                            <i data-lucide="bath" size="16"></i>
                            <span>${bathrooms}</span>
                        </div>
                    ` : ''}
                    ${maxGuests ? `
                        <div class="feature">
                            <i data-lucide="users" size="16"></i>
                            <span>${maxGuests}</span>
                        </div>
                    ` : ''}
                </div>
                <div class="property-footer">
                    <div class="property-price-container">
                        <div class="price-icons">
                            ${priceIcons}
                        </div>
                        <span class="price-label">${priceLabel}</span>
                    </div>
                    <button class="view-details-btn" onclick="viewProperty(${property.id}); event.stopPropagation();">
                        Ver detalles
                        <i data-lucide="arrow-right" size="16"></i>
                    </button>
                </div>
            </div>
        </article>
    `;
}


        function getPriceIcons(priceRange) {
            const icons = [];
            for (let i = 1; i <= 4; i++) {
                const filled = i <= priceRange;
                icons.push(`<i data-lucide="dollar-sign" size="18" class="price-icon ${filled ? 'filled' : 'empty'}"></i>`);
            }
            return icons.join('');
        }

        function getPriceRangeLabel(range) {
            const labels = {
                1: '$0 - $45K',
                2: '$45K - $100K',
                3: '$100K - $150K',
                4: 'Más de $150K'
            };
            return labels[range] || 'Consultar';
        }

        function renderPagination(pagination) {
            if (!pagination) return;
            
            const paginationContainer = document.querySelector('.pagination');
            if (!paginationContainer) return;
            
            const { current_page, total_pages } = pagination;
            
            let html = `
                <button class="pagination-btn" onclick="changePage(${current_page - 1})" ${current_page === 1 ? 'disabled' : ''}>
                    <i data-lucide="chevron-left" size="18"></i>
                </button>
            `;
            
            const startPage = Math.max(1, current_page - 2);
            const endPage = Math.min(total_pages, startPage + 4);
            
            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <button class="pagination-btn ${i === current_page ? 'active' : ''}" 
                            onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }
            
            html += `
                <button class="pagination-btn" onclick="changePage(${current_page + 1})" ${current_page === total_pages ? 'disabled' : ''}>
                    <i data-lucide="chevron-right" size="18"></i>
                </button>
            `;
            
            paginationContainer.innerHTML = html;
            lucide.createIcons();
        }

        // ==================== UI STATES ====================
        
      function showLoadingState() {
    const track = document.getElementById('sliderTrack') || document.getElementById('propertiesGrid');
    if (track) {
        track.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem;">
                <div style="width: 80px; height: 80px; margin: 0 auto 1.5rem; border: 4px solid var(--gray-200); border-top-color: var(--orange-primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <p style="color: var(--gray-600); font-size: 1rem;">Cargando propiedades...</p>
            </div>
            <style>
                @keyframes spin { to { transform: rotate(360deg); } }
            </style>
        `;
    }
}
        
        function showEmptyState() {
            const grid = document.getElementById('propertiesGrid');
            grid.innerHTML = `
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="empty-icon">
                        <i data-lucide="search-x" size="64"></i>
                    </div>
                    <h3 class="empty-title">No se encontraron propiedades</h3>
                    <p class="empty-text">
                        No hay propiedades que coincidan con tu búsqueda.<br>
                        Intenta ajustar los filtros o buscar en otra ubicación.
                    </p>
                    <a href="busqueda.php" class="empty-action">
                        <i data-lucide="rotate-ccw" size="20"></i>
                        Limpiar búsqueda
                    </a>
                </div>
            `;
            lucide.createIcons();
        }
        
        function showErrorState() {
            const grid = document.getElementById('propertiesGrid');
            grid.innerHTML = `
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="empty-icon">
                        <i data-lucide="alert-circle" size="64"></i>
                    </div>
                    <h3 class="empty-title">Error al cargar propiedades</h3>
                    <p class="empty-text">
                        Hubo un problema al cargar las propiedades.<br>
                        Por favor, intenta nuevamente.
                    </p>
                    <button class="empty-action" onclick="loadProperties()">
                        <i data-lucide="refresh-cw" size="20"></i>
                        Reintentar
                    </button>
                </div>
            `;
            lucide.createIcons();
        }
        
        function updateResultsCount() {
            const countElement = document.getElementById('resultsCount');
            if (countElement) {
                countElement.textContent = searchState.totalResults;
            }
        }

        // ==================== SEARCH FORM ====================
        
        function restoreSearchForm() {
            // Location
            if (searchState.location) {
                document.getElementById('locationDisplay').textContent = searchState.location;
                document.getElementById('locationTrigger').classList.add('has-value');
            }
            
            // Dates
            if (searchState.check_in && searchState.check_out) {
                const checkIn = new Date(searchState.check_in);
                const checkOut = new Date(searchState.check_out);
                
                calendarState.tempCheckIn = checkIn;
                calendarState.tempCheckOut = checkOut;
                
                const displayText = `${formatDate(checkIn)} - ${formatDate(checkOut)}`;
                document.getElementById('datesDisplay').textContent = displayText;
                document.getElementById('datesTrigger').classList.add('has-value');
            }
            
            // Guests
            if (searchState.guests) {
                const guestsSelect = document.getElementById('guestsSelect');
                if (guestsSelect) {
                    guestsSelect.value = searchState.guests;
                }
            }
            
            // Sort
            if (searchState.sort) {
                const sortSelect = document.getElementById('sortSelect');
                if (sortSelect) {
                    sortSelect.value = searchState.sort;
                }
            }
        }
        
        function performSearch() {
            const location = document.getElementById('locationDisplay').textContent;
            const guests = document.getElementById('guestsSelect').value;
            
            if (location !== '¿Dónde querés hospedarte?') {
                searchState.location = location;
            }
            
            searchState.guests = guests;
            
            if (calendarState.tempCheckIn && calendarState.tempCheckOut) {
                searchState.check_in = formatDateForAPI(calendarState.tempCheckIn);
                searchState.check_out = formatDateForAPI(calendarState.tempCheckOut);
            }
            
            searchState.page = 1;
            updateURL();
            loadProperties();
            
            const resultsSection = document.querySelector('.properties-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // ==================== FILTERS ====================
        
        function togglePriceFilter(range) {
            const chips = document.querySelectorAll(`[data-price="${range}"]`);
            
            if (searchState.activeFilters.price.includes(range)) {
                chips.forEach(chip => chip.classList.remove('active'));
                searchState.activeFilters.price = searchState.activeFilters.price.filter(p => p !== range);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                searchState.activeFilters.price.push(range);
            }
            
            updateActiveFiltersDisplay();
        }

        function toggleTypeFilter(type) {
            const chips = document.querySelectorAll(`[data-type="${type}"]`);
            
            if (searchState.activeFilters.type.includes(type)) {
                chips.forEach(chip => chip.classList.remove('active'));
                searchState.activeFilters.type = searchState.activeFilters.type.filter(t => t !== type);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                searchState.activeFilters.type.push(type);
            }
            
            updateActiveFiltersDisplay();
        }

        function toggleAmenityFilter(amenity) {
            const chips = document.querySelectorAll(`[data-amenity="${amenity}"]`);
            
            if (searchState.activeFilters.amenities.includes(amenity)) {
                chips.forEach(chip => chip.classList.remove('active'));
                searchState.activeFilters.amenities = searchState.activeFilters.amenities.filter(a => a !== amenity);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                searchState.activeFilters.amenities.push(amenity);
            }
            
            updateActiveFiltersDisplay();
        }

        function clearAllFilters() {
            searchState.activeFilters = {
                price: [],
                type: [],
                amenities: []
            };

            document.querySelectorAll('.filter-chip, .price-chip').forEach(chip => {
                chip.classList.remove('active');
            });

            updateActiveFiltersDisplay();
        }

    function applyFiltersAndClose() {
    closeFiltersModal();
    updateActiveFiltersDisplay();  // ✅ AGREGAR ESTO
    loadProperties();  // Esto recargará con los filtros aplicados
}

        function updateActiveFiltersDisplay() {
            const container = document.getElementById('activeFilters');
            container.innerHTML = '';
            
            const allFilters = [
                ...searchState.activeFilters.price.map(p => ({ type: 'price', value: p, label: getPriceLabel(p) })),
                ...searchState.activeFilters.type.map(t => ({ type: 'type', value: t, label: getTypeLabel(t) })),
                ...searchState.activeFilters.amenities.map(a => ({ type: 'amenity', value: a, label: getAmenityLabel(a) }))
            ];
            
            allFilters.forEach(filter => {
                const tag = document.createElement('div');
                tag.className = 'filter-tag';
                tag.innerHTML = `
                    <span>${filter.label}</span>
                    <button onclick="removeFilter('${filter.type}', '${filter.value}')">
                        <i data-lucide="x" size="14"></i>
                    </button>
                `;
                container.appendChild(tag);
            });
            
            if (allFilters.length > 3 && window.innerWidth <= 768) {
                const overflowCount = allFilters.length - 3;
                const overflowBtn = document.createElement('button');
                overflowBtn.className = 'filters-overflow-btn';
                overflowBtn.textContent = `+${overflowCount} filtros`;
                overflowBtn.onclick = openFiltersModal;
                container.appendChild(overflowBtn);
                container.classList.add('has-overflow');
            } else {
                container.classList.remove('has-overflow');
            }
            
            lucide.createIcons();
        }

        function removeFilter(type, value) {
            if (type === 'price') {
                togglePriceFilter(parseInt(value));
            } else if (type === 'type') {
                toggleTypeFilter(value);
            } else if (type === 'amenity') {
                toggleAmenityFilter(value);
            }
            
            applyFiltersAndClose();
        }

        function getPriceLabel(range) {
            const labels = {
                1: '$0 - $45K',
                2: '$45K - $100K',
                3: '$100K - $150K',
                4: '$150K+'
            };
            return labels[range] || '';
        }

        function getTypeLabel(type) {
            const labels = {
                house: 'Casa',
                apartment: 'Departamento',
                cabin: 'Cabaña',
                loft: 'Loft'
            };
            return labels[type] || type;
        }

        function getAmenityLabel(amenity) {
            const labels = {
                wifi: 'WiFi',
                pool: 'Piscina',
                parking: 'Cochera',
                ac: 'A/C',
                heating: 'Calefacción',
                kitchen: 'Cocina'
            };
            return labels[amenity] || amenity;
        }

        // ==================== CATEGORY FILTERING ====================
        
        let activeCategory = null;

        function filterByCategory(category) {
            const cards = document.querySelectorAll('.category-card');
            
            cards.forEach(card => {
                if (card.dataset.category === category) {
                    if (activeCategory === category) {
                        card.classList.remove('active');
                        activeCategory = null;
                        searchState.category = '';
                    } else {
                        cards.forEach(c => c.classList.remove('active'));
                        card.classList.add('active');
                        activeCategory = category;
                        searchState.category = category;
                    }
                }
            });
            
            searchState.page = 1;
            updateURL();
            loadProperties();
            
            const resultsSection = document.querySelector('.properties-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function selectCategoryAndClose(category) {
            filterByCategory(category);
            closeCategoriesModal();
        }

        // ==================== PAGINATION ====================
        
        function changePage(page) {
            if (page < 1) return;
            
            searchState.page = page;
            updateURL();
            loadProperties();
            
            const resultsSection = document.querySelector('.properties-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // ==================== SORTING ====================
        
        function sortProperties() {
            const sortValue = document.getElementById('sortSelect').value;
            searchState.sort = sortValue;
            searchState.page = 1;
            updateURL();
            loadProperties();
        }

        // ==================== VIEW TOGGLE ====================
        
        function changeView(view) {
            const grid = document.getElementById('propertiesGrid');
            const buttons = document.querySelectorAll('.view-btn');
            
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
        }

        // ==================== NAVIGATION ====================
        
        function viewProperty(id) {
            window.location.href = `propiedad.php?id=${id}`;
        }

        function toggleFavorite(btn, event) {
            event.stopPropagation();
            btn.classList.toggle('active');
            
            const isActive = btn.classList.contains('active');
            
            if (isActive) {
                btn.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                `;
            } else {
                btn.innerHTML = '<i data-lucide="heart" size="20"></i>';
                lucide.createIcons();
            }
        }

        // ==================== URL MANAGEMENT ====================
        
        function updateURL() {
            const params = new URLSearchParams();
            
            if (searchState.location) params.set('location', searchState.location);
            if (searchState.check_in) params.set('check_in', searchState.check_in);
            if (searchState.check_out) params.set('check_out', searchState.check_out);
            if (searchState.guests) params.set('guests', searchState.guests);
            if (searchState.category) params.set('category', searchState.category);
            if (searchState.price_range) params.set('price_range', searchState.price_range);
            if (searchState.property_type) params.set('property_type', searchState.property_type);
            if (searchState.activeFilters.amenities.length > 0) {
                params.set('amenities', searchState.activeFilters.amenities.join(','));
            }
            if (searchState.sort !== 'recommended') params.set('sort', searchState.sort);
            if (searchState.page > 1) params.set('page', searchState.page);
            
            const newURL = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({}, '', newURL);
        }

        // ==================== UTILITY FUNCTIONS ====================
        
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
        
        function formatDateForAPI(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // ==================== CALENDAR LOGIC (DESKTOP) ====================
        
        let calendarState = {
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            selectingCheckIn: true,
            tempCheckIn: null,
            tempCheckOut: null,
            isOpen: false
        };

        let calendarModalState = {
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            selectingCheckIn: true,
            tempCheckIn: null,
            tempCheckOut: null,
            isOpen: false
        };

        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

        function toggleCalendar(event) {
            if (event) event.stopPropagation();
            
            const popup = document.getElementById('calendarPopup');
            const trigger = document.getElementById('datesTrigger');
            
            calendarState.isOpen = !calendarState.isOpen;
            
            if (calendarState.isOpen) {
                popup.classList.add('active');
                trigger.classList.add('active');
                
                if (!calendarState.tempCheckIn) {
                    calendarState.selectingCheckIn = true;
                }
                
                renderCalendar();
                
                if (window.innerWidth <= 768) {
                    closeCalendar();
                    openMobileDatePicker();
                }
            } else {
                popup.classList.remove('active');
                trigger.classList.remove('active');
            }
        }

        function closeCalendar() {
            document.getElementById('calendarPopup').classList.remove('active');
            document.getElementById('datesTrigger').classList.remove('active');
            calendarState.isOpen = false;
        }

        function changeMonth(delta) {
            calendarState.currentMonth += delta;
            
            if (calendarState.currentMonth > 11) {
                calendarState.currentMonth = 0;
                calendarState.currentYear++;
            } else if (calendarState.currentMonth < 0) {
                calendarState.currentMonth = 11;
                calendarState.currentYear--;
            }
            
            renderCalendar();
        }

        function renderCalendar() {
            const grid = document.getElementById('calendarGrid');
            const monthYear = document.getElementById('calendarMonthYear');
            const instruction = document.getElementById('calendarInstruction');
            
            monthYear.textContent = `${monthNames[calendarState.currentMonth]} ${calendarState.currentYear}`;
            
            if (calendarState.selectingCheckIn) {
                instruction.textContent = 'Selecciona la fecha de llegada';
                instruction.classList.add('active');
            } else {
                instruction.textContent = 'Selecciona la fecha de salida';
                instruction.classList.add('active');
            }
            
            grid.innerHTML = '';
            
            dayNames.forEach(day => {
                const dayName = document.createElement('div');
                dayName.className = 'calendar-day-name';
                dayName.textContent = day;
                grid.appendChild(dayName);
            });
            
            const firstDay = new Date(calendarState.currentYear, calendarState.currentMonth, 1);
            const lastDay = new Date(calendarState.currentYear, calendarState.currentMonth + 1, 0);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                grid.appendChild(emptyDay);
            }
            
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(calendarState.currentYear, calendarState.currentMonth, day);
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day';
                dayEl.textContent = day;
                
                if (date < today) {
                    dayEl.classList.add('disabled');
                }
                
                if (date.getTime() === today.getTime()) {
                    dayEl.classList.add('today');
                }
                
                const dateTime = date.getTime();
                
                if (calendarState.tempCheckIn && dateTime === calendarState.tempCheckIn.getTime()) {
                    dayEl.classList.add('selected-start');
                }
                
                if (calendarState.tempCheckOut && dateTime === calendarState.tempCheckOut.getTime()) {
                    dayEl.classList.add('selected-end');
                }
                
                if (calendarState.tempCheckIn && calendarState.tempCheckOut) {
                    if (dateTime > calendarState.tempCheckIn.getTime() && 
                        dateTime < calendarState.tempCheckOut.getTime()) {
                        dayEl.classList.add('in-range');
                    }
                }
                
                if (date >= today) {
                    dayEl.onclick = (e) => {
                        e.stopPropagation();
                        selectDate(date);
                    };
                }
                
                grid.appendChild(dayEl);
            }
            
            lucide.createIcons();
        }

        function selectDate(date) {
            if (calendarState.tempCheckIn && calendarState.tempCheckOut) {
                calendarState.tempCheckIn = date;
                calendarState.tempCheckOut = null;
                calendarState.selectingCheckIn = false;
            } else if (calendarState.selectingCheckIn) {
                calendarState.tempCheckIn = date;
                calendarState.tempCheckOut = null;
                calendarState.selectingCheckIn = false;
            } else {
                if (date <= calendarState.tempCheckIn) {
                    calendarState.tempCheckIn = date;
                    calendarState.tempCheckOut = null;
                } else {
                    calendarState.tempCheckOut = date;
                }
            }
            renderCalendar();
        }

        function clearDates() {
            calendarState.tempCheckIn = null;
            calendarState.tempCheckOut = null;
            calendarState.selectingCheckIn = true;
            
            searchState.check_in = '';
            searchState.check_out = '';
            
            document.getElementById('datesDisplay').textContent = 'Seleccionar fechas';
            document.getElementById('datesTrigger').classList.remove('has-value');
            
            renderCalendar();
        }

        function applyDates() {
            if (calendarState.tempCheckIn && calendarState.tempCheckOut) {
                const checkInStr = formatDate(calendarState.tempCheckIn);
                const checkOutStr = formatDate(calendarState.tempCheckOut);
                const displayText = `${checkInStr} - ${checkOutStr}`;
                
                document.getElementById('datesDisplay').textContent = displayText;
                document.getElementById('datesTrigger').classList.add('has-value');
                
                closeCalendar();
            }
        }

        function formatDate(date) {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            return `${day}/${month}`;
        }

        document.addEventListener('click', (e) => {
            const calendarWrapper = e.target.closest('.calendar-wrapper');
            const calendarPopup = e.target.closest('.calendar-popup');
            
            if (!calendarWrapper && !calendarPopup && calendarState.isOpen) {
                closeCalendar();
            }
        });

        // ==================== MOBILE CALENDAR MODAL ====================

        function openMobileDatePicker() {
            document.getElementById('calendarModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            calendarModalState.tempCheckIn = calendarState.tempCheckIn;
            calendarModalState.tempCheckOut = calendarState.tempCheckOut;
            calendarModalState.selectingCheckIn = !calendarState.tempCheckIn;
            
            renderModalCalendar();
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeCalendarModal() {
            document.getElementById('calendarModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            calendarModalState.isOpen = false;
        }

        function changeModalMonth(delta) {
            calendarModalState.currentMonth += delta;
            
            if (calendarModalState.currentMonth > 11) {
                calendarModalState.currentMonth = 0;
                calendarModalState.currentYear++;
            } else if (calendarModalState.currentMonth < 0) {
                calendarModalState.currentMonth = 11;
                calendarModalState.currentYear--;
            }
            
            renderModalCalendar();
        }

        function renderModalCalendar() {
            const grid = document.getElementById('calendarModalGrid');
            const monthYear = document.getElementById('calendarModalMonthYear');
            const instruction = document.getElementById('calendarModalInstruction');
            
            monthYear.textContent = `${monthNames[calendarModalState.currentMonth]} ${calendarModalState.currentYear}`;
            
            if (calendarModalState.selectingCheckIn) {
                instruction.textContent = 'Selecciona la fecha de llegada';
                instruction.classList.add('active');
            } else {
                instruction.textContent = 'Selecciona la fecha de salida';
                instruction.classList.add('active');
            }
            
            grid.innerHTML = '';
            
            dayNames.forEach(day => {
                const dayName = document.createElement('div');
                dayName.className = 'calendar-day-name';
                dayName.textContent = day;
                grid.appendChild(dayName);
            });
            
            const firstDay = new Date(calendarModalState.currentYear, calendarModalState.currentMonth, 1);
            const lastDay = new Date(calendarModalState.currentYear, calendarModalState.currentMonth + 1, 0);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            for (let i = 0; i < firstDay.getDay(); i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                grid.appendChild(emptyDay);
            }
            
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(calendarModalState.currentYear, calendarModalState.currentMonth, day);
                const dayEl = document.createElement('div');
                dayEl.className = 'calendar-day';
                dayEl.textContent = day;
                
                if (date < today) {
                    dayEl.classList.add('disabled');
                }
                
                if (date.getTime() === today.getTime()) {
                    dayEl.classList.add('today');
                }
                
                const dateTime = date.getTime();
                
                if (calendarModalState.tempCheckIn && dateTime === calendarModalState.tempCheckIn.getTime()) {
                    dayEl.classList.add('selected-start');
                }
                
                if (calendarModalState.tempCheckOut && dateTime === calendarModalState.tempCheckOut.getTime()) {
                    dayEl.classList.add('selected-end');
                }
                
                if (calendarModalState.tempCheckIn && calendarModalState.tempCheckOut) {
                    if (dateTime > calendarModalState.tempCheckIn.getTime() && 
                        dateTime < calendarModalState.tempCheckOut.getTime()) {
                        dayEl.classList.add('in-range');
                    }
                }
                
                if (date >= today) {
                    dayEl.onclick = (e) => {
                        e.stopPropagation();
                        selectModalDate(date);
                    };
                }
                
                grid.appendChild(dayEl);
            }
            
            lucide.createIcons();
        }

        function selectModalDate(date) {
            if (calendarModalState.tempCheckIn && calendarModalState.tempCheckOut) {
                calendarModalState.tempCheckIn = date;
                calendarModalState.tempCheckOut = null;
                calendarModalState.selectingCheckIn = false;
            } else if (calendarModalState.selectingCheckIn) {
                calendarModalState.tempCheckIn = date;
                calendarModalState.tempCheckOut = null;
                calendarModalState.selectingCheckIn = false;
            } else {
                if (date <= calendarModalState.tempCheckIn) {
                    calendarModalState.tempCheckIn = date;
                    calendarModalState.tempCheckOut = null;
                } else {
                    calendarModalState.tempCheckOut = date;
                }
            }
            renderModalCalendar();
        }

        function clearModalDates() {
            calendarModalState.tempCheckIn = null;
            calendarModalState.tempCheckOut = null;
            calendarModalState.selectingCheckIn = true;
            
            calendarState.tempCheckIn = null;
            calendarState.tempCheckOut = null;
            
            document.getElementById('datesDisplay').textContent = 'Seleccionar fechas';
            document.getElementById('datesTrigger').classList.remove('has-value');
            
            renderModalCalendar();
        }

        function applyModalDates() {
            if (calendarModalState.tempCheckIn && calendarModalState.tempCheckOut) {
                calendarState.tempCheckIn = calendarModalState.tempCheckIn;
                calendarState.tempCheckOut = calendarModalState.tempCheckOut;
                
                const checkInStr = formatDate(calendarModalState.tempCheckIn);
                const checkOutStr = formatDate(calendarModalState.tempCheckOut);
                const displayText = `${checkInStr} - ${checkOutStr}`;
                
                document.getElementById('datesDisplay').textContent = displayText;
                document.getElementById('datesTrigger').classList.add('has-value');
                
                closeCalendarModal();
            }
        }

        // ==================== MODALS ====================

        function openMapModal() {
            document.getElementById('mapModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeMapModal() {
            document.getElementById('mapModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function openCategoriesModal() {
            document.getElementById('categoriesModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeCategoriesModal() {
            document.getElementById('categoriesModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function openLocationModal() {
            document.getElementById('locationModalOverlay').classList.add('active');
            document.getElementById('locationTrigger').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeLocationModal() {
            document.getElementById('locationModalOverlay').classList.remove('active');
            document.getElementById('locationTrigger').classList.remove('active');
            document.body.style.overflow = '';
        }

        function selectLocation(name, distance) {
            const displayText = distance === 0 ? name : `${name} (${distance} km)`;
            document.getElementById('locationDisplay').textContent = displayText;
            document.getElementById('locationTrigger').classList.add('has-value');
            closeLocationModal();
        }

        function openFiltersModal() {
            document.getElementById('filtersModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeFiltersModal() {
            document.getElementById('filtersModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // ==================== CATEGORY SLIDER ====================

        let currentCategorySlide = 0;
        const categoryCardWidth = 220 + 16;

        function updateCategoryNavButtons() {
            const slider = document.getElementById('categorySlider');
            const visibleCards = Math.floor(slider.offsetWidth / categoryCardWidth);
            const maxSlide = Math.max(0, slider.children.length - visibleCards);
            
            const prevBtn = document.getElementById('categoryPrevBtn');
            const nextBtn = document.getElementById('categoryNextBtn');
            
            if (prevBtn && nextBtn) {
                prevBtn.disabled = currentCategorySlide === 0;
                nextBtn.disabled = currentCategorySlide >= maxSlide;
            }
        }

        function slideCategoriesLeft() {
            if (currentCategorySlide > 0) {
                currentCategorySlide--;
                const slider = document.getElementById('categorySlider');
                slider.scrollLeft = currentCategorySlide * categoryCardWidth;
                updateCategoryNavButtons();
            }
        }

        function slideCategoriesRight() {
            const slider = document.getElementById('categorySlider');
            const visibleCards = Math.floor(slider.offsetWidth / categoryCardWidth);
            const maxSlide = Math.max(0, slider.children.length - visibleCards);
            
            if (currentCategorySlide < maxSlide) {
                currentCategorySlide++;
                slider.scrollLeft = currentCategorySlide * categoryCardWidth;
                updateCategoryNavButtons();
            }
        }

        if (window.innerWidth > 1024) {
            updateCategoryNavButtons();
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                updateCategoryNavButtons();
            }
        });

        // ==================== ESCAPE KEY HANDLER ====================

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeFiltersModal();
                closeCalendarModal();
                closeLocationModal();
                closeMapModal();
                closeCategoriesModal();
                if (calendarState.isOpen) {
                    closeCalendar();
                }
            }
        });
    </script>
</body>
</html>
