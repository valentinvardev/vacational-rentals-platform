<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    <title>Mapa de Propiedades - RentaTurista | Villa Carlos Paz</title>
    
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

 /* ==================== LAYOUT ==================== */

.map-page {
    display: grid;
    grid-template-columns: 25% 75%;
    height: calc(100vh - 80px);
    margin-top: 80px;
    transition: grid-template-columns 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.map-page.map-expanded {
    grid-template-columns: 0% 100%;
}

.sidebar {
    background: var(--white);
    border-right: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: opacity 0.4s ease, transform 0.4s ease;
}

        .map-page.map-expanded .sidebar {
            opacity: 0;
            transform: translateX(-100%);
            pointer-events: none;
        }

        .map-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* Fix Leaflet zoom controls - lower z-index */
        .leaflet-control-zoom {
            margin-right: 20px !important;
            margin-top: 20px !important;
            z-index: 400 !important;
        }

        .leaflet-top {
            z-index: 400 !important;
        }

        /* Show Listings Toggle Button */
        .show-listings-toggle {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .map-page.map-expanded .show-listings-toggle {
            opacity: 1;
            visibility: visible;
        }

        .show-listings-btn {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            border-left: none;
            border-radius: 0 50px 50px 0;
            padding: 1.5rem 1rem 1.5rem 0.5rem;
            cursor: pointer;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: var(--orange-primary);
            font-weight: 700;
            font-size: 0.8125rem;
            transition: var(--transition);
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }

        .show-listings-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
            padding-right: 1.25rem;
        }

        .show-listings-btn i {
            writing-mode: horizontal-tb;
            transform: rotate(180deg);
        }

        /* ==================== SEARCH BAR ==================== */
        
        .search-section {
            padding: 1.5rem 1.75rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--white);
        }

        .search-box {
            position: relative;
            margin-bottom: 1rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.125rem 1rem 3.25rem;
            border: 2px solid var(--gray-300);
            border-radius: 14px;
            font-family: var(--font-primary);
            font-size: 0.9375rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1.125rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            pointer-events: none;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.875rem;
        }

        .search-group {
            position: relative;
        }

        .search-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .search-input-field {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--white);
        }

        .search-input-field:focus {
            outline: none;
            border-color: var(--orange-primary);
        }

        .search-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23525252' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        /* ==================== CUSTOM CALENDAR ==================== */
        
        .calendar-wrapper {
            position: relative;
        }

        .calendar-trigger {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-size: 0.875rem;
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

        /* ==================== CALENDAR MODAL FOR MOBILE ==================== */
        
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

        /* ==================== GUESTS PICKER MODAL ==================== */
        
        .guests-modal-overlay {
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

        .guests-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .guests-modal {
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
        }

        .guests-modal-overlay.active .guests-modal {
            transform: translateY(0);
        }

        .guests-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .guests-modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .guests-modal-close {
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

        .guests-counter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .guests-counter:last-of-type {
            border-bottom: none;
        }

        .guests-counter-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .guests-counter-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .guests-counter-btn {
            background: var(--white);
            border: 2px solid var(--gray-300);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
        }

        .guests-counter-btn:hover:not(:disabled) {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .guests-counter-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .guests-counter-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
            min-width: 30px;
            text-align: center;
        }

        .guests-modal-footer {
            margin-top: 1.5rem;
        }

        .btn-apply-guests {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border: none;
            border-radius: 12px;
            color: var(--white);
            font-family: var(--font-primary);
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-apply-guests:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        /* ==================== PROPERTY PREVIEW POPUP ==================== */
        
        .property-preview-popup {
            position: fixed;
            top: 100px;
            right: 20px;
            width: 230px;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateX(20px) scale(0.9);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 900;
            border: 2px solid var(--orange-primary);
        }

        .property-preview-popup.active {
            opacity: 1;
            visibility: visible;
            transform: translateX(0) scale(1);
        }

        .property-preview-popup.auto-cycling {
            animation: previewPulse 4s ease-in-out;
        }

        @keyframes previewPulse {
            0%, 100% { 
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            95% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateX(20px) scale(0.9);
            }
        }

        .preview-carousel {
            position: relative;
            width: 100%;
            height: 140px;
            background: var(--gray-200);
            overflow: hidden;
        }

        .preview-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .preview-image.active {
            opacity: 1;
        }

        .preview-carousel-controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 0.375rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .property-preview-popup:hover .preview-carousel-controls,
        .property-preview-popup.paused .preview-carousel-controls {
            opacity: 1;
        }

        .preview-nav-btn {
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
            transition: var(--transition);
        }

        .preview-nav-btn:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .preview-carousel-dots {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 4px;
            z-index: 10;
        }

        .preview-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            cursor: pointer;
        }

        .preview-dot.active {
            background: var(--white);
            width: 18px;
            border-radius: 3px;
        }

        .preview-content {
            padding: 0.875rem;
        }

        .preview-title {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.375rem;
            line-height: 1.3;
        }

        .preview-location {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-600);
            font-size: 0.6875rem;
            margin-bottom: 0.5rem;
        }

        .preview-stats {
            display: flex;
            gap: 0.625rem;
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .preview-stat {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: var(--gray-700);
            font-size: 0.6875rem;
        }

        .preview-price {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .preview-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border: none;
            width: 26px;
            height: 26px;
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

        .preview-progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            background: var(--orange-primary);
            width: 0%;
            transition: width 1s linear;
            z-index: 11;
        }

        .property-preview-popup.auto-cycling .preview-progress-bar {
            animation: progressBar 4s linear;
        }

        @keyframes progressBar {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        /* Mobile preview positioning */
        @media (max-width: 1024px) {
            .property-preview-popup {
                top: 100px;
                right: 1rem;
                left: auto;
                width: 230px;
                max-width: none;
            }
        }

        /* ==================== FILTERS BUTTON & MODAL ==================== */
        
        .filters-trigger {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--white);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            border-radius: 14px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.15);
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
            grid-column: 1 / -1;
        }

        .filters-trigger::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 107, 53, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .filters-trigger:hover::before {
            width: 300px;
            height: 300px;
        }

        .filters-trigger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.25);
            background: var(--orange-primary);
            color: var(--white);
        }

        .filters-trigger-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-icon {
            animation: wiggle 2s ease-in-out infinite;
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }

        .active-filters-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #EF4444;
            color: var(--white);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            border: 3px solid var(--white);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

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

/* ==================== LISTINGS ==================== */

.listings-section {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 1.75rem;
    display: flex;
    align-items: center;
    flex-direction: column;
 
}

.listings-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    gap: 1rem;
    width: 100%;
    max-width: 400px;
}




        .listings-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .map-toggle-btn {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
            padding: 0.625rem 1.125rem;
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .map-toggle-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: translateY(-1px);
        }

        .results-count {
            font-size: 0.9375rem;
            color: var(--gray-600);
        }

        .results-count strong {
            color: var(--gray-900);
            font-weight: 700;
        }

        .sort-select {
            padding: 0.625rem 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            font-family: var(--font-primary);
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            background: var(--white);
            max-width: 180px;
        }

      .listings-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    width: 100%;
}

        .property-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .property-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .property-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .property-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
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
            padding: 1rem;
        }

        .property-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .property-location {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.8125rem;
            margin-bottom: 0.75rem;
        }

        .property-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.875rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .property-stat {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-700);
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .property-stat i {
            color: var(--orange-primary);
        }

        .property-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .property-price {
            display: flex;
            flex-direction: column;
        }

        .price-symbols-display {
            display: flex;
            align-items: center;
            gap: 0.125rem;
            margin-bottom: 0.125rem;
        }

        .price-icon {
            color: var(--orange-primary);
            width: 16px;
            height: 16px;
        }

        .price-icon.filled {
            opacity: 1;
        }

        .price-icon.empty {
            opacity: 0.25;
        }

        .price-range-text {
            font-size: 0.6875rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .property-rating {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .rating-stars {
            color: #FFA500;
            font-size: 0.875rem;
        }

        .rating-value {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .rating-count {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .property-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-view-on-map {
            flex: 1;
            padding: 0.5rem;
            background: var(--white);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
            border-radius: 8px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.8125rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
        }

        .btn-view-on-map:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        /* ==================== MAP ELEMENTS ==================== */
        
        /* Price Markers */
        .price-marker {
            background: var(--white);
            border: 2px solid var(--orange-primary);
            border-radius: 10px;
            padding: 0.625rem 0.875rem;
            font-weight: 700;
            font-size: 1rem;
            color: var(--orange-primary);
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.35);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            font-family: var(--font-primary);
            line-height: 1.2;
        }

        .price-marker:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: scale(1.15);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
        }

        .price-marker.active {
            background: var(--orange-primary);
            color: var(--white);
            border-color: var(--orange-dark);
            transform: scale(1.1);
        }

        /* POI Icons */
        .poi-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: var(--transition);
        }

        .poi-icon:hover {
            transform: scale(1.15);
        }

        .poi-restaurant {
            background: linear-gradient(135deg, #FF6B35 0%, #E55527 100%);
        }

        .poi-hospital {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        .poi-nightlife {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        }

        .poi-attraction {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }

        /* ==================== MOBILE SEARCH BAR (Inside Listings Panel) ==================== */
        
        .mobile-listing-search {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .mobile-search-row {
            display: flex;
            gap: 0.5rem;
            align-items: stretch;
        }

        .mobile-search-input-wrapper {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .mobile-search-input-wrapper i,
        .mobile-search-input-wrapper svg {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            pointer-events: none;
            z-index: 2;
        }

        .mobile-search-input-wrapper input {
            width: 100%;
            height: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            font-family: var(--font-primary);
            font-size: 0.875rem;
            background: var(--white);
        }

        .mobile-search-input-wrapper input:focus {
            outline: none;
            border-color: var(--orange-primary);
        }

        .mobile-quick-btn {
            padding: 0.75rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.8125rem;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            min-width: 44px;
        }

        .mobile-quick-btn:hover,
        .mobile-quick-btn.active {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
        }

        .mobile-quick-btn i {
            width: 18px;
            height: 18px;
        }

        /* ==================== MOBILE CONTROLS ==================== */
        
        .mobile-controls {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 0.625rem 0.875rem;
            z-index: 1000;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.08);
        }

        .mobile-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .mobile-btn {
            padding: 0.75rem 0.5rem;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 0.8125rem;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
        }

        .mobile-btn:hover,
        .mobile-btn.active {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
        }

        .mobile-btn i {
            width: 20px;
            height: 20px;
        }

        /* Mobile Panels */
        .mobile-panel {
            display: none;
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 60px;
            background: var(--white);
            z-index: 999;
            overflow-y: auto;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            touch-action: pan-y;
        }

        .mobile-panel.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .panel-header {
            position: sticky;
            top: 0;
            background: var(--white);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .panel-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .panel-close {
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

        /* ==================== RESPONSIVE ==================== */
        
        @media (max-width: 1024px) {
            .map-page {
                grid-template-columns: 1fr;
                margin-top: 80px;
                height: calc(100vh - 80px - 60px);
            }

            .sidebar {
                display: none;
            }

            .mobile-controls {
                display: block;
            }

            .map-container {
                height: calc(100vh - 80px - 60px);
            }

            .show-listings-toggle {
                display: none;
            }

            .leaflet-control-zoom {
                margin-right: 10px !important;
                margin-top: 10px !important;
                margin-bottom: 70px !important;
            }

            .listings-grid {
                width: 100%;
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

        @media (max-width: 640px) {
            .price-range-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ==================== SCROLLBAR ==================== */
        
        .listings-section::-webkit-scrollbar,
        .mobile-panel::-webkit-scrollbar,
        .filters-modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .listings-section::-webkit-scrollbar-track,
        .mobile-panel::-webkit-scrollbar-track,
        .filters-modal-body::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        .listings-section::-webkit-scrollbar-thumb,
        .mobile-panel::-webkit-scrollbar-thumb,
        .filters-modal-body::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 4px;
        }

        .listings-section::-webkit-scrollbar-thumb:hover,
        .mobile-panel::-webkit-scrollbar-thumb:hover,
        .filters-modal-body::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }

        /* ==================== EMPTY STATE ==================== */
        
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            font-size: 0.9375rem;
            color: var(--gray-600);
        }

        /* ==================== LEAFLET CUSTOMIZATION ==================== */
        
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            font-family: var(--font-primary);
        }

        .leaflet-popup-content {
            margin: 0.75rem;
        }

        .popup-title {
            font-weight: 700;
            font-size: 0.9375rem;
            color: var(--gray-900);
            margin-bottom: 0.375rem;
        }

        .popup-subtitle {
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .popup-link {
            display: inline-block;
            color: var(--orange-primary);
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            margin-top: 0.5rem;
        }

        .popup-link:hover {
            color: var(--orange-dark);
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <!-- Desktop Layout -->
    <div class="map-page" id="mapPage">
        <!-- Show Listings Toggle (appears when map is expanded) -->
        <div class="show-listings-toggle">
            <button class="show-listings-btn" onclick="toggleMapExpansion()">
                <i data-lucide="chevron-right" size="20"></i>
                <span>MOSTRAR LISTADO</span>
            </button>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Search Section -->
            <section class="search-section">
                <div class="search-box">
                    <i data-lucide="search" size="20" class="search-icon"></i>
                    <input type="text" class="search-input" placeholder="Buscar por ubicación..." id="searchInput">
                </div>
                
                <div class="search-grid">
                    <div class="search-group calendar-wrapper" style="grid-column: 1 / -1;">
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
                                <button class="calendar-nav" onclick="changeMonth(-1)">
                                    <i data-lucide="chevron-left" size="16"></i>
                                </button>
                                <div class="calendar-month-year" id="calendarMonthYear"></div>
                                <button class="calendar-nav" onclick="changeMonth(1)">
                                    <i data-lucide="chevron-right" size="16"></i>
                                </button>
                            </div>
                            <div class="calendar-grid" id="calendarGrid"></div>
                            <div class="calendar-footer">
                                <button class="btn-calendar-clear" onclick="clearDates()">Limpiar</button>
                                <button class="btn-calendar-apply" onclick="applyDates()">Aplicar</button>
                            </div>
                        </div>
                    </div>
                    <div class="search-group">
                        <label class="search-label">Huéspedes</label>
                        <select class="search-input-field search-select" id="guests">
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
                    </div>
                    <div class="search-group">
                        <label class="search-label">Habitaciones</label>
                        <select class="search-input-field search-select" id="bedrooms">
                            <option value="">Cualquiera</option>
                            <option value="1">1 habitación</option>
                            <option value="2">2 habitaciones</option>
                            <option value="3">3 habitaciones</option>
                            <option value="4">4 habitaciones</option>
                            <option value="5">5+ habitaciones</option>
                        </select>
                    </div>
                </div>

                <button class="filters-trigger" onclick="openFiltersModal()">
                    <div class="filters-trigger-content">
                        <i data-lucide="sliders-horizontal" size="20" class="filter-icon"></i>
                        <span>Más filtros</span>
                    </div>
                    <span class="active-filters-badge" id="filtersBadge" style="display: none;">0</span>
                </button>
            </section>

            <!-- Listings Section -->
            <section class="listings-section">
                <div class="listings-header">
                    <div class="listings-header-left">
                        <div class="results-count">
                            <strong id="resultsCount">0</strong> propiedades
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <button class="map-toggle-btn" onclick="toggleMapExpansion()">
                            <i data-lucide="maximize-2" size="16" id="mapToggleIcon"></i>
                            <span id="mapToggleText">Expandir mapa</span>
                        </button>
                        <select class="sort-select" id="sortSelect" onchange="sortProperties()">
                            <option value="recommended">Recomendadas</option>
                            <option value="price-low">Precio: menor a mayor</option>
                            <option value="price-high">Precio: mayor a menor</option>
                            <option value="rating">Mejor calificadas</option>
                        </select>
                    </div>
                </div>

                <div class="listings-grid" id="listingsGrid">
                    <!-- Properties will be loaded here -->
                </div>
            </section>
        </aside>

        <!-- Map Container -->
        <div class="map-container">
            <div id="map"></div>
            
            <!-- Property Preview Popup -->
            <div class="property-preview-popup" id="propertyPreview">
                <button class="preview-close" onclick="closePreview()">
                    <i data-lucide="x" size="14"></i>
                </button>
                <div class="preview-carousel" id="previewCarousel">
                    <div class="preview-carousel-controls">
                        <button class="preview-nav-btn" onclick="prevPreviewImage()">
                            <i data-lucide="chevron-left" size="16"></i>
                        </button>
                        <button class="preview-nav-btn" onclick="nextPreviewImage()">
                            <i data-lucide="chevron-right" size="16"></i>
                        </button>
                    </div>
                    <div class="preview-carousel-dots" id="previewDots"></div>
                    <div class="preview-progress-bar"></div>
                </div>
                <div class="preview-content" id="previewContent">
                    <!-- Content will be loaded here -->
                </div>
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
                <button class="btn-clear-filters" onclick="clearFilters()">
                    Limpiar filtros
                </button>
                <button class="btn-apply-filters" onclick="applyFiltersAndClose()">
                    Aplicar filtros
                </button>
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

    <!-- Guests Picker Modal -->
    <div class="guests-modal-overlay" id="guestsModalOverlay" onclick="closeGuestsModal()">
        <div class="guests-modal" onclick="event.stopPropagation()">
            <div class="guests-modal-header">
                <h3 class="guests-modal-title">Huéspedes</h3>
                <button class="guests-modal-close" onclick="closeGuestsModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            
            <div class="guests-counter">
                <div class="guests-counter-label">Adultos</div>
                <div class="guests-counter-controls">
                    <button class="guests-counter-btn" onclick="changeGuestsCount('adults', -1)" id="adultsMinusBtn">
                        <i data-lucide="minus" size="16"></i>
                    </button>
                    <div class="guests-counter-value" id="adultsCount">0</div>
                    <button class="guests-counter-btn" onclick="changeGuestsCount('adults', 1)">
                        <i data-lucide="plus" size="16"></i>
                    </button>
                </div>
            </div>

            <div class="guests-counter">
                <div class="guests-counter-label">Niños</div>
                <div class="guests-counter-controls">
                    <button class="guests-counter-btn" onclick="changeGuestsCount('children', -1)" id="childrenMinusBtn">
                        <i data-lucide="minus" size="16"></i>
                    </button>
                    <div class="guests-counter-value" id="childrenCount">0</div>
                    <button class="guests-counter-btn" onclick="changeGuestsCount('children', 1)">
                        <i data-lucide="plus" size="16"></i>
                    </button>
                </div>
            </div>

            <div class="guests-modal-footer">
                <button class="btn-apply-guests" onclick="applyGuests()">
                    Aplicar
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Controls -->
    <div class="mobile-controls">
        <div class="mobile-buttons">
            <button class="mobile-btn" id="mobileListingsBtn" onclick="toggleMobilePanel('listings')">
                <i data-lucide="list" size="20"></i>
                <span>Listado</span>
            </button>
            <button class="mobile-btn active" id="mobileMapBtn" onclick="toggleMobilePanel('map')">
                <i data-lucide="map" size="20"></i>
                <span>Mapa</span>
            </button>
        </div>
    </div>

    <!-- Mobile Panels -->
    <div class="mobile-panel" id="listingsPanel">
        <div class="panel-header">
            <h3 class="panel-title">Propiedades disponibles</h3>
            <button class="panel-close" onclick="closeMobilePanel('listings')">
                <i data-lucide="x" size="20"></i>
            </button>
        </div>
        
        <!-- Mobile Search Bar (inside listings panel) -->
        <div class="mobile-listing-search">
            <div class="mobile-search-row">
                <div class="mobile-search-input-wrapper">
                    <i data-lucide="search" size="16"></i>
                    <input type="text" placeholder="Buscar ubicación..." id="mobileSearchInput">
                </div>
                <button class="mobile-quick-btn" onclick="openMobileDatePicker()">
                    <i data-lucide="calendar" size="18"></i>
                </button>
                <button class="mobile-quick-btn" onclick="openMobileGuestsPicker()" id="mobileGuestsBtn">
                    <i data-lucide="users" size="18"></i>
                </button>
                <button class="mobile-quick-btn" onclick="openFiltersModal()">
                    <i data-lucide="sliders-horizontal" size="18"></i>
                </button>
            </div>
        </div>
        
        <div style="padding: 1.5rem;">
            <div class="listings-header" style="margin-bottom: 1rem;">
                <div class="results-count">
                    <strong id="mobileResultsCount">0</strong> propiedades
                </div>
                <select class="sort-select" id="mobileSortSelect" onchange="sortProperties()">
                    <option value="recommended">Recomendadas</option>
                    <option value="price-low">Precio: menor a mayor</option>
                    <option value="price-high">Precio: mayor a menor</option>
                    <option value="rating">Mejor calificadas</option>
                </select>
            </div>
            <div class="listings-grid" id="mobileListingsGrid">
                <!-- Properties will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Global variables
        let map;
        let markers = [];
        let properties = [];
        let filteredProperties = [];
        let mapExpanded = false;
        let activeFilters = {
            price: [],
            type: [],
            amenities: [],
            search: '',
            checkIn: null,
            checkOut: null,
            guests: null,
            bedrooms: null
        };

        // Preview state
        let previewState = {
            isOpen: false,
            currentProperty: null,
            currentImageIndex: 0,
            autoCycleInterval: null,
            autoCycleTimeout: null,
            isPaused: false,
            images: []
        };

        // Mobile panel state
        let mobileState = {
            currentPanel: 'map',
            lastPanel: null
        };

        // Guests picker state
        let guestsState = {
            adults: 0,
            children: 0
        };

        // ==================== CALENDAR LOGIC (DESKTOP) ====================
        
        let calendarState = {
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            selectingCheckIn: true,
            tempCheckIn: null,
            tempCheckOut: null,
            isOpen: false
        };

        // ==================== CALENDAR LOGIC (MOBILE MODAL) ====================
        
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

        // Desktop calendar functions
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
            if (calendarState.selectingCheckIn) {
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
            activeFilters.checkIn = null;
            activeFilters.checkOut = null;
            
            document.getElementById('datesDisplay').textContent = 'Seleccionar fechas';
            document.getElementById('datesTrigger').classList.remove('has-value');
            
            renderCalendar();
            applyFilters();
        }

        function applyDates() {
            if (calendarState.tempCheckIn && calendarState.tempCheckOut) {
                activeFilters.checkIn = calendarState.tempCheckIn;
                activeFilters.checkOut = calendarState.tempCheckOut;
                
                const checkInStr = formatDate(calendarState.tempCheckIn);
                const checkOutStr = formatDate(calendarState.tempCheckOut);
                const displayText = `${checkInStr} - ${checkOutStr}`;
                
                document.getElementById('datesDisplay').textContent = displayText;
                document.getElementById('datesTrigger').classList.add('has-value');
                
                closeCalendar();
                applyFilters();
            }
        }

        // Mobile calendar modal functions
        function openMobileDatePicker() {
            document.getElementById('calendarModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Sync with current dates if any
            calendarModalState.tempCheckIn = activeFilters.checkIn;
            calendarModalState.tempCheckOut = activeFilters.checkOut;
            calendarModalState.selectingCheckIn = !activeFilters.checkIn;
            
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
            if (calendarModalState.selectingCheckIn) {
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
            activeFilters.checkIn = null;
            activeFilters.checkOut = null;
            
            document.getElementById('datesDisplay').textContent = 'Seleccionar fechas';
            document.getElementById('datesTrigger').classList.remove('has-value');
            
            renderModalCalendar();
            applyFilters();
        }

        function applyModalDates() {
            if (calendarModalState.tempCheckIn && calendarModalState.tempCheckOut) {
                activeFilters.checkIn = calendarModalState.tempCheckIn;
                activeFilters.checkOut = calendarModalState.tempCheckOut;
                
                // Also sync desktop calendar
                calendarState.tempCheckIn = calendarModalState.tempCheckIn;
                calendarState.tempCheckOut = calendarModalState.tempCheckOut;
                
                const checkInStr = formatDate(calendarModalState.tempCheckIn);
                const checkOutStr = formatDate(calendarModalState.tempCheckOut);
                const displayText = `${checkInStr} - ${checkOutStr}`;
                
                document.getElementById('datesDisplay').textContent = displayText;
                document.getElementById('datesTrigger').classList.add('has-value');
                
                closeCalendarModal();
                applyFilters();
            }
        }

        function formatDate(date) {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            return `${day}/${month}`;
        }

        // Close calendar when clicking outside (desktop only)
        document.addEventListener('click', (e) => {
            const calendarWrapper = e.target.closest('.calendar-wrapper');
            const calendarPopup = e.target.closest('.calendar-popup');
            
            if (!calendarWrapper && !calendarPopup && calendarState.isOpen) {
                closeCalendar();
            }
        });

       // ==================== GUESTS PICKER ====================

        function openMobileGuestsPicker() {
            document.getElementById('guestsModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            updateGuestsButtons();
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeGuestsModal() {
            document.getElementById('guestsModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function changeGuestsCount(type, delta) {
            if (type === 'adults') {
                guestsState.adults = Math.max(0, guestsState.adults + delta);
                document.getElementById('adultsCount').textContent = guestsState.adults;
            } else if (type === 'children') {
                guestsState.children = Math.max(0, guestsState.children + delta);
                document.getElementById('childrenCount').textContent = guestsState.children;
            }
            
            updateGuestsButtons();
        }

        function updateGuestsButtons() {
            const adultsMinusBtn = document.getElementById('adultsMinusBtn');
            const childrenMinusBtn = document.getElementById('childrenMinusBtn');
            
            adultsMinusBtn.disabled = guestsState.adults === 0;
            childrenMinusBtn.disabled = guestsState.children === 0;
        }

        function applyGuests() {
            const total = guestsState.adults + guestsState.children;
            activeFilters.guests = total > 0 ? total.toString() : null;
            
            // Update desktop select
            const guestsSelect = document.getElementById('guests');
            if (total > 0 && total <= 8) {
                guestsSelect.value = total.toString();
            }
            
            closeGuestsModal();
            applyFilters();
        }

        // ==================== PROPERTY PREVIEW ====================

        function showPropertyPreview(property, autoClose = true) {
            const preview = document.getElementById('propertyPreview');
            const carousel = document.getElementById('previewCarousel');
            const content = document.getElementById('previewContent');
            const dots = document.getElementById('previewDots');
            
            clearPreviewTimers();
            
            previewState.images = [
                { type: 'placeholder', icon: 'home' },
                { type: 'placeholder', icon: 'bed-double' },
                { type: 'placeholder', icon: 'bath' },
                { type: 'placeholder', icon: 'utensils' }
            ];
            
            previewState.currentProperty = property;
            previewState.currentImageIndex = 0;
            previewState.isPaused = false;
            
            let imagesHTML = '';
            previewState.images.forEach((img, index) => {
                imagesHTML += `
                    <div class="preview-image ${index === 0 ? 'active' : ''}" 
                         style="background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%); 
                                display: flex; align-items: center; justify-content: center; color: white;">
                        <i data-lucide="${img.icon}" size="48"></i>
                    </div>
                `;
            });
            carousel.innerHTML = `
                ${imagesHTML}
                <div class="preview-carousel-controls">
                    <button class="preview-nav-btn" onclick="prevPreviewImage()">
                        <i data-lucide="chevron-left" size="16"></i>
                    </button>
                    <button class="preview-nav-btn" onclick="nextPreviewImage()">
                        <i data-lucide="chevron-right" size="16"></i>
                    </button>
                </div>
                <div class="preview-carousel-dots" id="previewDots"></div>
                <div class="preview-progress-bar"></div>
            `;
            
            const dotsContainer = carousel.querySelector('#previewDots');
            previewState.images.forEach((img, index) => {
                const dot = document.createElement('div');
                dot.className = `preview-dot ${index === 0 ? 'active' : ''}`;
                dot.onclick = () => goToPreviewImage(index);
                dotsContainer.appendChild(dot);
            });
            
            const priceSymbols = '$'.repeat(property.priceRange);
            const priceText = getPriceRangeText(property.priceRange);
            const stars = '★'.repeat(Math.round(property.rating));
            
            content.innerHTML = `
                <h3 class="preview-title">${property.title}</h3>
                <div class="preview-location">
                    <i data-lucide="map-pin" size="12"></i>
                    ${property.location.neighborhood}
                </div>
                <div class="preview-stats">
                    <div class="preview-stat">
                        <i data-lucide="bed-double" size="14" style="color: var(--orange-primary);"></i>
                        ${property.bedrooms}
                    </div>
                    <div class="preview-stat">
                        <i data-lucide="bath" size="14" style="color: var(--orange-primary);"></i>
                        ${property.bathrooms}
                    </div>
                    <div class="preview-stat">
                        <i data-lucide="users" size="14" style="color: var(--orange-primary);"></i>
                        ${property.maxGuests}
                    </div>
                </div>
                <div class="preview-price">
                    <div>
                        <div style="font-size: 0.875rem; font-weight: 700; color: var(--orange-primary);">
                            ${priceSymbols}
                        </div>
                        <div style="font-size: 0.625rem; color: var(--gray-600);">${priceText}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.25rem;">
                        <span style="color: #FFA500; font-size: 0.75rem;">${stars}</span>
                        <span style="font-weight: 700; font-size: 0.75rem;">${property.rating}</span>
                    </div>
                </div>
            `;
            
            preview.classList.add('active');
            previewState.isOpen = true;
            
            lucide.createIcons();
            
            if (autoClose) {
                preview.classList.add('auto-cycling');
                startAutoCycle();
            }
        }

        function startAutoCycle() {
            previewState.autoCycleInterval = setInterval(() => {
                if (!previewState.isPaused) {
                    nextPreviewImage();
                }
            }, 1000);
            
            previewState.autoCycleTimeout = setTimeout(() => {
                closePreview();
            }, 4000);
        }

        function clearPreviewTimers() {
            if (previewState.autoCycleInterval) {
                clearInterval(previewState.autoCycleInterval);
                previewState.autoCycleInterval = null;
            }
            if (previewState.autoCycleTimeout) {
                clearTimeout(previewState.autoCycleTimeout);
                previewState.autoCycleTimeout = null;
            }
        }

        function pauseAutoCycle() {
            previewState.isPaused = true;
            clearPreviewTimers();
            const preview = document.getElementById('propertyPreview');
            preview.classList.remove('auto-cycling');
            preview.classList.add('paused');
        }

        function nextPreviewImage() {
            previewState.currentImageIndex = (previewState.currentImageIndex + 1) % previewState.images.length;
            updatePreviewImage();
        }

        function prevPreviewImage() {
            pauseAutoCycle();
            previewState.currentImageIndex = (previewState.currentImageIndex - 1 + previewState.images.length) % previewState.images.length;
            updatePreviewImage();
        }

        function goToPreviewImage(index) {
            pauseAutoCycle();
            previewState.currentImageIndex = index;
            updatePreviewImage();
        }

        function updatePreviewImage() {
            const images = document.querySelectorAll('.preview-image');
            const dots = document.querySelectorAll('.preview-dot');
            
            images.forEach((img, index) => {
                img.classList.toggle('active', index === previewState.currentImageIndex);
            });
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === previewState.currentImageIndex);
            });
        }

        function closePreview() {
            const preview = document.getElementById('propertyPreview');
            preview.classList.remove('active', 'auto-cycling', 'paused');
            previewState.isOpen = false;
            clearPreviewTimers();
            
            document.querySelectorAll('.property-card').forEach(card => {
                card.style.boxShadow = '';
            });
        }

        // Sample properties data
        const sampleProperties = [
            {
                id: 1,
                title: 'Casa Vista al Lago Premium',
                location: { neighborhood: 'Centro', city: 'Villa Carlos Paz', lat: -31.4115, lng: -64.4925 },
                type: 'house',
                price: 120000,
                priceRange: 3,
                bedrooms: 3,
                bathrooms: 2,
                maxGuests: 6,
                rating: 4.8,
                reviewsCount: 24,
                amenities: ['wifi', 'pool', 'parking', 'ac'],
                image: null,
                featured: true
            },
            {
                id: 2,
                title: 'Departamento Céntrico Moderno',
                location: { neighborhood: 'Centro', city: 'Villa Carlos Paz', lat: -31.4145, lng: -64.4965 },
                type: 'apartment',
                price: 75000,
                priceRange: 2,
                bedrooms: 2,
                bathrooms: 1,
                maxGuests: 4,
                rating: 4.5,
                reviewsCount: 18,
                amenities: ['wifi', 'ac'],
                image: null,
                featured: false
            },
            {
                id: 3,
                title: 'Cabaña en las Sierras',
                location: { neighborhood: 'Villa del Dique', city: 'Villa Carlos Paz', lat: -31.4095, lng: -64.4885 },
                type: 'cabin',
                price: 180000,
                priceRange: 4,
                bedrooms: 4,
                bathrooms: 3,
                maxGuests: 8,
                rating: 4.9,
                reviewsCount: 35,
                amenities: ['wifi', 'pool', 'parking'],
                image: null,
                featured: true
            },
            {
                id: 4,
                title: 'Loft Frente al Dique',
                location: { neighborhood: 'Costanera', city: 'Villa Carlos Paz', lat: -31.4125, lng: -64.4905 },
                type: 'loft',
                price: 95000,
                priceRange: 2,
                bedrooms: 2,
                bathrooms: 2,
                maxGuests: 4,
                rating: 4.6,
                reviewsCount: 21,
                amenities: ['wifi', 'parking', 'ac'],
                image: null,
                featured: false
            }
        ];

        const pois = [
            { name: 'Restaurante La Parrilla', type: 'restaurant', lat: -31.4130, lng: -64.4940 },
            { name: 'Hospital Municipal', type: 'hospital', lat: -31.4155, lng: -64.4935 },
            { name: 'Bar Nocturno', type: 'nightlife', lat: -31.4120, lng: -64.4955 },
            { name: 'Parque del Lago', type: 'attraction', lat: -31.4100, lng: -64.4900 }
        ];

        function initMap() {
            map = L.map('map').setView([-31.4135, -64.4945], 14);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(map);

            addPOIMarkers();
            properties = sampleProperties;
            filteredProperties = [...properties];
            updateListings();
            updateMapMarkers();
        }

        function addPOIMarkers() {
            pois.forEach(poi => {
                const iconClass = `poi-${poi.type}`;
                const iconName = poi.type === 'restaurant' ? 'utensils' :
                                poi.type === 'hospital' ? 'heart-pulse' :
                                poi.type === 'nightlife' ? 'music' : 'map-pin';

                const icon = L.divIcon({
                    className: 'custom-poi-icon',
                    html: `<div class="poi-icon ${iconClass}"><i data-lucide="${iconName}" size="16"></i></div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });

                L.marker([poi.lat, poi.lng], { icon })
                    .addTo(map)
                    .bindPopup(`
                        <div class="popup-title">${poi.name}</div>
                        <div class="popup-subtitle">${getPoiTypeLabel(poi.type)}</div>
                    `);
            });

            setTimeout(() => lucide.createIcons(), 100);
        }

        function getPoiTypeLabel(type) {
            const labels = {
                restaurant: 'Restaurante',
                hospital: 'Centro de Salud',
                nightlife: 'Vida Nocturna',
                attraction: 'Atracción Turística'
            };
            return labels[type] || type;
        }

        function updateMapMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            filteredProperties.forEach(property => {
                const priceSymbols = '$'.repeat(property.priceRange);
                const priceText = getPriceRangeText(property.priceRange);

                const icon = L.divIcon({
                    className: 'custom-price-marker',
                    html: `<div class="price-marker">${priceSymbols}<br><small style="font-size: 0.8125rem; font-weight: 600; opacity: 0.9;">${priceText}</small></div>`,
                    iconSize: [85, 50],
                    iconAnchor: [42, 50]
                });

                const marker = L.marker([property.location.lat, property.location.lng], { icon })
                    .addTo(map);

                marker.on('click', () => {
                    showPropertyPreview(property);
                    highlightProperty(property.id);
                    map.flyTo([property.location.lat, property.location.lng], 16);
                });

                marker.on('mouseover', () => {
                    if (!previewState.isOpen) {
                        showPropertyPreview(property);
                    }
                });

                markers.push(marker);
            });
        }

        function getPriceRangeText(range) {
            const ranges = {
                1: '$0-45K',
                2: '$45-100K',
                3: '$100-150K',
                4: '$150K+'
            };
            return ranges[range] || '';
        }

        function updateListings() {
            const grid = document.getElementById('listingsGrid');
            const mobileGrid = document.getElementById('mobileListingsGrid');
            
            document.getElementById('resultsCount').textContent = filteredProperties.length;
            document.getElementById('mobileResultsCount').textContent = filteredProperties.length;

            if (filteredProperties.length === 0) {
                const emptyState = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i data-lucide="home" size="40"></i>
                        </div>
                        <h3 class="empty-title">No se encontraron propiedades</h3>
                        <p class="empty-text">Intenta ajustar los filtros de búsqueda</p>
                    </div>
                `;
                grid.innerHTML = emptyState;
                mobileGrid.innerHTML = emptyState;
                lucide.createIcons();
                return;
            }

            const html = filteredProperties.map(property => createPropertyCard(property)).join('');
            grid.innerHTML = html;
            mobileGrid.innerHTML = html;
            
            lucide.createIcons();
        }

        function createPropertyCard(property) {
            const priceSymbols = '$'.repeat(property.priceRange);
            const priceText = getPriceRangeText(property.priceRange);
            const stars = '★'.repeat(Math.round(property.rating));

            return `
                <article class="property-card" data-property-id="${property.id}" 
                         onmouseenter="handlePropertyHover(${property.id})"
                         onmouseleave="handlePropertyLeave()">
                    <div class="property-image">
                        ${property.image ? 
                            `<img src="${property.image}" alt="${property.title}">` :
                            `<i data-lucide="home" size="48"></i>`
                        }
                        ${property.featured ? '<div class="property-badge">Destacada</div>' : ''}
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">${property.title}</h3>
                        <div class="property-location">
                            <i data-lucide="map-pin" size="14"></i>
                            ${property.location.neighborhood}, ${property.location.city}
                        </div>
                        <div class="property-stats">
                            <div class="property-stat">
                                <i data-lucide="bed-double" size="16"></i>
                                ${property.bedrooms}
                            </div>
                            <div class="property-stat">
                                <i data-lucide="bath" size="16"></i>
                                ${property.bathrooms}
                            </div>
                            <div class="property-stat">
                                <i data-lucide="users" size="16"></i>
                                ${property.maxGuests}
                            </div>
                        </div>
                        <div class="property-footer">
                            <div class="property-price">
                                <div class="price-symbols-display">
                                    ${Array(4).fill(0).map((_, i) => `
                                        <i data-lucide="dollar-sign" size="16" class="price-icon ${i < property.priceRange ? 'filled' : 'empty'}"></i>
                                    `).join('')}
                                </div>
                                <div class="price-range-text">${priceText}</div>
                            </div>
                            <div class="property-rating">
                                <span class="rating-stars">${stars}</span>
                                <span class="rating-value">${property.rating}</span>
                                <span class="rating-count">(${property.reviewsCount})</span>
                            </div>
                        </div>
                        <div class="property-actions">
                            <button class="btn-view-on-map" onclick="event.stopPropagation(); viewPropertyOnMap(${property.id})">
                                <i data-lucide="map-pin" size="14"></i>
                                Mirar en el mapa
                            </button>
                        </div>
                    </div>
                </article>
            `;
        }

        function handlePropertyHover(id) {
            if (window.innerWidth > 1024) {
                const property = properties.find(p => p.id === id);
                if (property) {
                    showPropertyPreview(property);
                }
            }
        }

        function handlePropertyLeave() {
            // Don't auto-close on leave
        }

        function viewPropertyOnMap(id) {
            const property = properties.find(p => p.id === id);
            if (!property) return;

            map.flyTo([property.location.lat, property.location.lng], 16);
            showPropertyPreview(property, false);
            highlightProperty(id);

            if (window.innerWidth <= 1024) {
                closeMobilePanel('listings');
                mobileState.currentPanel = 'map';
                document.getElementById('mobileMapBtn').classList.add('active');
                document.getElementById('mobileListingsBtn').classList.remove('active');
            }
        }

        function togglePriceFilter(range) {
            const chips = document.querySelectorAll(`[data-price="${range}"]`);
            
            if (activeFilters.price.includes(range)) {
                chips.forEach(chip => chip.classList.remove('active'));
                activeFilters.price = activeFilters.price.filter(p => p !== range);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                activeFilters.price.push(range);
            }
            
            updateFiltersBadge();
            applyFilters();
        }

        function toggleTypeFilter(type) {
            const chips = document.querySelectorAll(`[data-type="${type}"]`);
            
            if (activeFilters.type.includes(type)) {
                chips.forEach(chip => chip.classList.remove('active'));
                activeFilters.type = activeFilters.type.filter(t => t !== type);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                activeFilters.type.push(type);
            }
            
            updateFiltersBadge();
            applyFilters();
        }

        function toggleAmenityFilter(amenity) {
            const chips = document.querySelectorAll(`[data-amenity="${amenity}"]`);
            
            if (activeFilters.amenities.includes(amenity)) {
                chips.forEach(chip => chip.classList.remove('active'));
                activeFilters.amenities = activeFilters.amenities.filter(a => a !== amenity);
            } else {
                chips.forEach(chip => chip.classList.add('active'));
                activeFilters.amenities.push(amenity);
            }
            
            updateFiltersBadge();
            applyFilters();
        }

        function clearFilters() {
            activeFilters = {
                price: [],
                type: [],
                amenities: [],
                search: '',
                checkIn: null,
                checkOut: null,
                guests: null,
                bedrooms: null
            };

            calendarState.tempCheckIn = null;
            calendarState.tempCheckOut = null;
            calendarState.selectingCheckIn = true;
            
            calendarModalState.tempCheckIn = null;
            calendarModalState.tempCheckOut = null;
            calendarModalState.selectingCheckIn = true;
            
            guestsState.adults = 0;
            guestsState.children = 0;
            document.getElementById('adultsCount').textContent = '0';
            document.getElementById('childrenCount').textContent = '0';

            document.querySelectorAll('.filter-chip, .price-chip').forEach(chip => {
                chip.classList.remove('active');
            });

            document.getElementById('searchInput').value = '';
            if (document.getElementById('mobileSearchInput')) {
                document.getElementById('mobileSearchInput').value = '';
            }
            document.getElementById('datesDisplay').textContent = 'Seleccionar fechas';
            document.getElementById('datesTrigger').classList.remove('has-value');
            document.getElementById('guests').value = '';
            document.getElementById('bedrooms').value = '';

            updateFiltersBadge();
            applyFilters();
        }

        function updateFiltersBadge() {
            const count = activeFilters.price.length + 
                         activeFilters.type.length + 
                         activeFilters.amenities.length;
            
            const badge = document.getElementById('filtersBadge');
            
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
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

        function applyFiltersAndClose() {
            applyFilters();
            closeFiltersModal();
        }

        function toggleMapExpansion() {
            const mapPage = document.getElementById('mapPage');
            const icon = document.getElementById('mapToggleIcon');
            const text = document.getElementById('mapToggleText');
            
            mapExpanded = !mapExpanded;
            
            if (mapExpanded) {
                mapPage.classList.add('map-expanded');
                icon.setAttribute('data-lucide', 'minimize-2');
                text.textContent = 'Reducir mapa';
            } else {
                mapPage.classList.remove('map-expanded');
                icon.setAttribute('data-lucide', 'maximize-2');
                text.textContent = 'Expandir mapa';
            }
            
            lucide.createIcons();
            
            setTimeout(() => {
                map.invalidateSize();
            }, 400);
        }

        function applyFilters() {
            filteredProperties = properties.filter(property => {
                if (activeFilters.price.length > 0 && !activeFilters.price.includes(property.priceRange)) {
                    return false;
                }

                if (activeFilters.type.length > 0 && !activeFilters.type.includes(property.type)) {
                    return false;
                }

                if (activeFilters.amenities.length > 0) {
                    const hasAllAmenities = activeFilters.amenities.every(amenity => 
                        property.amenities.includes(amenity)
                    );
                    if (!hasAllAmenities) return false;
                }

                if (activeFilters.search) {
                    const searchLower = activeFilters.search.toLowerCase();
                    const matchesSearch = 
                        property.title.toLowerCase().includes(searchLower) ||
                        property.location.neighborhood.toLowerCase().includes(searchLower) ||
                        property.location.city.toLowerCase().includes(searchLower);
                    if (!matchesSearch) return false;
                }

                if (activeFilters.guests) {
                    const guestsNeeded = parseInt(activeFilters.guests);
                    if (property.maxGuests < guestsNeeded) return false;
                }

                if (activeFilters.bedrooms) {
                    const bedroomsNeeded = parseInt(activeFilters.bedrooms);
                    if (property.bedrooms < bedroomsNeeded) return false;
                }

                return true;
            });

            updateListings();
            updateMapMarkers();
        }

        function sortProperties() {
            const sortValue = document.getElementById('sortSelect').value;
            const mobileSortSelect = document.getElementById('mobileSortSelect');
            const mobileSortValue = mobileSortSelect ? mobileSortSelect.value : sortValue;

            const finalSortValue = sortValue || mobileSortValue;

            switch (finalSortValue) {
                case 'price-low':
                    filteredProperties.sort((a, b) => a.price - b.price);
                    break;
                case 'price-high':
                    filteredProperties.sort((a, b) => b.price - a.price);
                    break;
                case 'rating':
                    filteredProperties.sort((a, b) => b.rating - a.rating);
                    break;
                case 'recommended':
                default:
                    filteredProperties.sort((a, b) => {
                        if (a.featured !== b.featured) return b.featured - a.featured;
                        return b.rating - a.rating;
                    });
            }

            updateListings();
        }

        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                activeFilters.search = e.target.value;
                const mobileInput = document.getElementById('mobileSearchInput');
                if (mobileInput) {
                    mobileInput.value = e.target.value;
                }
                applyFilters();
            }, 300);
        });

        document.getElementById('guests').addEventListener('change', (e) => {
            activeFilters.guests = e.target.value;
            applyFilters();
        });

        document.getElementById('bedrooms').addEventListener('change', (e) => {
            activeFilters.bedrooms = e.target.value;
            applyFilters();
        });

        function toggleMobilePanel(panel) {
            const listingsPanel = document.getElementById('listingsPanel');
            const listingsBtn = document.getElementById('mobileListingsBtn');
            const mapBtn = document.getElementById('mobileMapBtn');

            if (panel === 'listings') {
                if (mobileState.currentPanel === 'listings') {
                    closeMobilePanel('listings');
                    mobileState.currentPanel = 'map';
                    mapBtn.classList.add('active');
                    listingsBtn.classList.remove('active');
                } else {
                    listingsPanel.classList.add('active');
                    mobileState.currentPanel = 'listings';
                    listingsBtn.classList.add('active');
                    mapBtn.classList.remove('active');
                    
                    setTimeout(() => {
                        const mobileSearchInput = document.getElementById('mobileSearchInput');
                        if (mobileSearchInput) {
                            mobileSearchInput.addEventListener('input', (e) => {
                                clearTimeout(searchTimeout);
                                searchTimeout = setTimeout(() => {
                                    activeFilters.search = e.target.value;
                                    document.getElementById('searchInput').value = e.target.value;
                                    applyFilters();
                                }, 300);
                            });
                        }
                    }, 100);
                }
            } else if (panel === 'map') {
                if (mobileState.currentPanel === 'map') {
                    return;
                } else {
                    closeMobilePanel('listings');
                    mobileState.currentPanel = 'map';
                    mapBtn.classList.add('active');
                    listingsBtn.classList.remove('active');
                }
            }
        }

        function closeMobilePanel(panel) {
            document.getElementById(`${panel}Panel`).classList.remove('active');
        }

        function highlightProperty(id) {
            document.querySelectorAll('.property-card').forEach(card => {
                card.style.boxShadow = '';
            });

            const card = document.querySelector(`[data-property-id="${id}"]`);
            if (card) {
                card.style.boxShadow = '0 0 0 3px var(--orange-primary)';
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeFiltersModal();
                closeGuestsModal();
                closeCalendarModal();
                if (calendarState.isOpen) {
                    closeCalendar();
                }
                if (previewState.isOpen) {
                    closePreview();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            initMap();
            lucide.createIcons();
        });
    </script>
</body>
</html>