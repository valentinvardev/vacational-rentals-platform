<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#FF6B35">
    <title>Gestión de Propiedades - RentaTurista Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Satoshi:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <style>
        :root {
            --orange-primary: #FF6B35;
            --orange-light: #FF8F64;
            --orange-dark: #E55527;
            --orange-glow: rgba(255, 107, 53, 0.4);
            --orange-bg: rgba(255, 245, 242, 0.6);
            
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-400: #BDBDBD;
            --gray-500: #9E9E9E;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
            --white: #FFFFFF;
            
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --info: #3B82F6;
            
            --font-display: 'Poppins', system-ui, sans-serif;
            --font-body: 'Satoshi', system-ui, sans-serif;
            
            --space-xs: 0.5rem;
            --space-sm: 0.75rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-body);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
        }

        body {
            background: linear-gradient(135deg, #FAFAFA 0%, #F8F8F8 100%);
            color: var(--gray-800);
            overflow-x: hidden;
        }

        /* Header */
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            padding: var(--space-md) 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 clamp(1rem, 3vw, 2rem);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }

        .logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--orange-primary);
        }

        .page-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            color: var(--gray-900);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .header-btn {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
            padding: var(--space-sm) var(--space-md);
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-xs);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .header-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
            transform: translateY(-1px);
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: var(--space-xl) clamp(1rem, 3vw, 2rem);
        }

        /* Stats Grid */
        .stats-section {
            margin-bottom: var(--space-2xl);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-lg);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: var(--space-lg);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 107, 53, 0.3);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--space-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-value {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 2rem;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Search & Filters */
        .controls-section {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: var(--space-lg);
            margin-bottom: var(--space-xl);
        }

        .search-box {
            position: relative;
            margin-bottom: var(--space-md);
        }

        .search-input {
            width: 100%;
            padding: var(--space-md) var(--space-md) var(--space-md) 3rem;
            border: 2px solid var(--gray-300);
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }

        .search-icon {
            position: absolute;
            left: var(--space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .filter-chips {
            display: flex;
            gap: var(--space-sm);
            flex-wrap: wrap;
        }

        .filter-chip {
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 30px;
            padding: var(--space-sm) var(--space-md);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--space-xs);
        }

        .filter-chip:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
        }

        .filter-chip.active {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        /* Properties Grid */
        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-xl);
        }

        .property-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .property-card:hover {
            transform: translateY(-6px);
            border-color: rgba(255, 107, 53, 0.3);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        .property-image {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .property-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-badge {
            position: absolute;
            top: var(--space-md);
            left: var(--space-md);
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            color: var(--white);
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .property-status {
            position: absolute;
            top: var(--space-md);
            right: var(--space-md);
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .property-status.active {
            background: rgba(16, 185, 129, 0.9);
            color: var(--white);
        }

        .property-status.pending {
            background: rgba(245, 158, 11, 0.9);
            color: var(--white);
        }

        .property-status.inactive,
        .property-status.draft {
            background: rgba(107, 114, 128, 0.9);
            color: var(--white);
        }

        .property-content {
            padding: var(--space-lg);
        }

        .property-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
            margin-bottom: var(--space-sm);
            line-height: 1.3;
        }

        .property-location {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: var(--space-md);
        }

        .property-stats {
            display: flex;
            gap: var(--space-md);
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-md);
            border-bottom: 1px solid var(--gray-200);
        }

        .property-stat {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .property-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .property-price {
            display: flex;
            align-items: center;
            gap: 0.125rem;
        }

        .price-icon {
            color: var(--orange-primary);
        }

        .price-icon.filled {
            opacity: 1;
        }

        .price-icon.empty {
            opacity: 0.2;
        }

        .property-actions {
            display: flex;
            gap: var(--space-sm);
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--gray-700);
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .action-btn.primary {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .action-btn.danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
            color: var(--danger);
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-lg);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Modal */
        .modal {
            background: var(--white);
            border-radius: 24px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow: hidden;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .modal-overlay.active .modal {
            transform: scale(1);
        }

        .modal-header {
            padding: var(--space-xl);
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
        }

        .modal-close {
            background: rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-700);
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(0, 0, 0, 0.1);
            transform: scale(1.1);
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: var(--space-xl);
        }

        .modal-section {
            margin-bottom: var(--space-xl);
            padding-bottom: var(--space-xl);
            border-bottom: 1px solid var(--gray-200);
        }

        .modal-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--gray-900);
            margin-bottom: var(--space-md);
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-md);
        }

        .detail-item {
            background: var(--gray-50);
            padding: var(--space-md);
            border-radius: 12px;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            margin-bottom: 0.25rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: var(--space-md);
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-sm);
            font-size: 0.9rem;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: var(--space-md);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Videos Section */
        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--space-lg);
        }

        .video-card {
            border: 2px solid var(--gray-300);
            border-radius: 16px;
            overflow: hidden;
            background: var(--white);
            transition: all 0.3s ease;
        }

        .video-card:hover {
            border-color: var(--orange-primary);
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.15);
        }

        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            background: var(--gray-900);
        }

        .video-embed iframe,
        .video-embed video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-info {
            padding: var(--space-md);
        }

        .video-info h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .video-actions {
            padding: 0 var(--space-md) var(--space-md);
            display: flex;
            gap: var(--space-sm);
        }

        .video-actions button {
            flex: 1;
            padding: 0.5rem 1rem;
            border: 2px solid var(--gray-300);
            background: var(--white);
            color: var(--gray-700);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .video-actions button:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .video-actions button.btn-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .video-actions button.btn-danger:hover {
            background: var(--danger);
            color: var(--white);
        }

        .badge-primary {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-youtube {
            background: #FF0000;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-vimeo {
            background: #1AB7EA;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-direct {
            background: var(--gray-600);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Reviews Section */
        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-md);
        }

        .review-card {
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: var(--space-md);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: var(--space-sm);
        }

        .review-author {
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .review-rating {
            color: var(--warning);
            display: flex;
            gap: 0.125rem;
            font-size: 1rem;
        }

        .review-date {
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .review-comment {
            color: var(--gray-700);
            line-height: 1.5;
            margin-bottom: var(--space-sm);
        }

        .review-actions {
            display: flex;
            gap: var(--space-sm);
        }

        .review-actions button {
            padding: 0.5rem 1rem;
            border: 2px solid var(--gray-300);
            background: var(--white);
            color: var(--gray-700);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Amenities */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: var(--space-md);
        }

        .amenity-toggle {
            background: var(--gray-50);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            padding: var(--space-md);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .amenity-toggle.active {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--orange-primary);
        }

        .amenity-info {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .amenity-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .amenity-toggle.inactive .amenity-icon {
            background: var(--gray-400);
        }

        .amenity-label {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.9rem;
        }

        .amenity-edit-btn {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .amenity-edit-btn:hover:not(:disabled) {
            background: var(--orange-primary);
            color: var(--white);
        }

        .amenity-edit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--gray-100);
            border-color: var(--gray-300);
            color: var(--gray-400);
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 48px;
            height: 26px;
            background: var(--gray-300);
            border-radius: 13px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .toggle-switch.active {
            background: var(--orange-primary);
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: var(--white);
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(22px);
        }

        /* Images */
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: var(--space-md);
        }

        .image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 12px;
            background: var(--gray-200);
            overflow: hidden;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Buttons */
        .btn {
            padding: var(--space-md) var(--space-xl);
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
        }

        .btn-secondary:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .modal-footer {
            padding: var(--space-xl);
            border-top: 2px solid rgba(101, 67, 33, 0.1);
            display: flex;
            gap: var(--space-md);
        }

        .modal-footer .btn {
            flex: 1;
        }

        /* Loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 3000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .spinner {
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

        /* Toast */
        .toast {
            position: fixed;
            bottom: var(--space-xl);
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--gray-900);
            color: var(--white);
            padding: var(--space-md) var(--space-xl);
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 3001;
            opacity: 0;
            transition: all 0.3s ease;
            max-width: 90%;
            text-align: center;
        }

        .toast.active {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.success {
            background: var(--success);
        }

        .toast.error {
            background: var(--danger);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: var(--space-2xl) var(--space-md);
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto var(--space-lg);
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .empty-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
            margin-bottom: var(--space-sm);
        }

        .empty-text {
            color: var(--gray-600);
            font-size: 1.05rem;
        }

        /* Price Range Selector */
        .price-range-selector {
            display: flex;
            gap: var(--space-sm);
            margin-top: var(--space-sm);
        }

        .price-range-option {
            flex: 1;
            padding: var(--space-md);
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .price-range-option:hover {
            border-color: var(--orange-primary);
        }

        .price-range-option.active {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--orange-primary);
        }

        .price-range-label {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-bottom: 0.25rem;
        }

        .price-range-icons {
            font-size: 1.25rem;
            color: var(--orange-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .properties-grid {
                grid-template-columns: 1fr;
            }
            .modal {
                margin: var(--space-md);
                max-height: calc(100vh - 2rem);
            }
            .detail-grid {
                grid-template-columns: 1fr;
            }
            .videos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-container">
            <div class="header-left">
                <div class="logo">RentaTurista</div>
                <h1 class="page-title">Gestión de Propiedades</h1>
            </div>
            <div class="header-right">
                <a href="index.php" class="header-btn">
                    <i data-lucide="home" size="18"></i>
                    <span class="btn-text">Ver sitio</span>
                </a>
                <a href="admin-property-form.php" class="header-btn">
                    <i data-lucide="plus" size="18"></i>
                    <span class="btn-text">Nueva</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="building-2" size="20"></i>
                        </div>
                        <div class="stat-trend">
                            <i data-lucide="trending-up" size="12"></i>
                            <span id="propGrowth">0%</span>
                        </div>
                    </div>
                    <div class="stat-value" id="totalProperties">0</div>
                    <div class="stat-label">Propiedades</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="check-circle" size="20"></i>
                        </div>
                        <div class="stat-trend">
                            <i data-lucide="trending-up" size="12"></i>
                            <span id="activeGrowth">0%</span>
                        </div>
                    </div>
                    <div class="stat-value" id="activeProperties">0</div>
                    <div class="stat-label">Activas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="calendar-check" size="20"></i>
                        </div>
                        <div class="stat-trend">
                            <i data-lucide="trending-up" size="12"></i>
                            <span id="bookingsGrowth">0%</span>
                        </div>
                    </div>
                    <div class="stat-value" id="totalBookings">0</div>
                    <div class="stat-label">Reservas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="dollar-sign" size="20"></i>
                        </div>
                        <div class="stat-trend">
                            <i data-lucide="trending-up" size="12"></i>
                            <span id="revenueGrowth">0%</span>
                        </div>
                    </div>
                    <div class="stat-value" id="totalRevenue">$0</div>
                    <div class="stat-label">Ingresos</div>
                </div>
            </div>
        </section>

        <!-- Search & Filter -->
        <section class="controls-section">
            <div class="search-box">
                <i data-lucide="search" size="20" class="search-icon"></i>
                <input type="text" class="search-input" placeholder="Buscar propiedades..." id="searchInput">
            </div>

            <div class="filter-chips">
                <div class="filter-chip active" data-filter="">
                    <i data-lucide="list" size="16"></i>
                    Todas
                </div>
                <div class="filter-chip" data-filter="active">
                    <i data-lucide="check-circle" size="16"></i>
                    Activas
                </div>
                <div class="filter-chip" data-filter="pending">
                    <i data-lucide="clock" size="16"></i>
                    Pendientes
                </div>
                <div class="filter-chip" data-filter="draft">
                    <i data-lucide="file-text" size="16"></i>
                    Borradores
                </div>
                <div class="filter-chip" data-filter="inactive">
                    <i data-lucide="x-circle" size="16"></i>
                    Inactivas
                </div>
            </div>
        </section>

        <!-- Properties Grid -->
        <div class="properties-grid" id="propertiesList">
            <!-- Properties will be loaded here -->
        </div>
    </main>

    <!-- View Modal -->
    <div class="modal-overlay" id="viewModalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Detalles de la Propiedad</h2>
                <button class="modal-close" onclick="closeViewModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            <div class="modal-body" id="viewModalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Editar Propiedad</h2>
                <button class="modal-close" onclick="closeEditModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            <div class="modal-body" id="editModalContent">
                <!-- Edit form will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeEditModal()">Cancelar</button>
                <button class="btn btn-primary" onclick="savePropertyChanges()">
                    <i data-lucide="save" size="18"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>

    <!-- Amenity Value Modal -->
    <div class="modal-overlay" id="amenityValueModalOverlay">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <h2 class="modal-title" id="amenityValueModalTitle">Editar Amenidad</h2>
                <button class="modal-close" onclick="closeAmenityValueModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" id="amenityValueLabel">Descripción</label>
                    <input type="text" 
                           class="form-input" 
                           id="amenityValueInput" 
                           placeholder="Ingresa los detalles">
                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-top: 0.5rem;">
                        Describe las características específicas de esta amenidad.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeAmenityValueModal()">Cancelar</button>
                <button class="btn btn-primary" onclick="saveAmenityValue()">
                    <i data-lucide="check" size="18"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="modal-overlay" id="videoModalOverlay">
        <div class="modal" style="max-width: 600px;">
            <div class="modal-header">
                <h2 class="modal-title" id="videoModalTitle">Agregar Video</h2>
                <button class="modal-close" onclick="closeVideoModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">URL del Video *</label>
                    <input type="text" id="videoUrl" class="form-input" 
                           placeholder="https://youtube.com/watch?v=... o https://vimeo.com/..." />
                    <span style="color: var(--gray-600); font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        Soporta: YouTube, Vimeo, o link directo a MP4/WebM
                    </span>
                </div>
                <div class="form-group">
                    <label class="form-label">Título (opcional)</label>
                    <input type="text" id="videoTitle" class="form-input" 
                           placeholder="Tour virtual de la propiedad" />
                </div>
                <div class="form-group">
                    <label class="form-label">Descripción (opcional)</label>
                    <textarea id="videoDescription" class="form-textarea" rows="3" 
                              placeholder="Descripción del video..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeVideoModal()">Cancelar</button>
                <button class="btn btn-primary" onclick="saveVideo()">
                    <i data-lucide="check" size="18"></i>
                    <span id="videoModalBtnText">Agregar Video</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal-overlay" id="reviewModalOverlay">
        <div class="modal" style="max-width: 600px;">
            <div class="modal-header">
                <h2 class="modal-title" id="reviewModalTitle">Agregar Reseña</h2>
                <button class="modal-close" onclick="closeReviewModal()">
                    <i data-lucide="x" size="20"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre del huésped *</label>
                    <input type="text" id="reviewGuestName" class="form-input" 
                           placeholder="Juan Pérez" />
                </div>
                <div class="form-group">
                    <label class="form-label">Calificación *</label>
                    <div class="price-range-selector">
                        <div class="price-range-option" data-rating="1" onclick="selectRating(1)">
                            <div class="review-rating">⭐</div>
                        </div>
                        <div class="price-range-option" data-rating="2" onclick="selectRating(2)">
                            <div class="review-rating">⭐⭐</div>
                        </div>
                        <div class="price-range-option" data-rating="3" onclick="selectRating(3)">
                            <div class="review-rating">⭐⭐⭐</div>
                        </div>
                        <div class="price-range-option" data-rating="4" onclick="selectRating(4)">
                            <div class="review-rating">⭐⭐⭐⭐</div>
                        </div>
                        <div class="price-range-option active" data-rating="5" onclick="selectRating(5)">
                            <div class="review-rating">⭐⭐⭐⭐⭐</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Comentario *</label>
                    <textarea id="reviewComment" class="form-textarea" rows="4" 
                              placeholder="Excelente lugar, muy limpio y cómodo..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeReviewModal()">Cancelar</button>
                <button class="btn btn-primary" onclick="saveReview()">
                    <i data-lucide="check" size="18"></i>
                    <span id="reviewModalBtnText">Agregar Reseña</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Global variables
        let currentProperty = null;
        let currentFilter = '';
        let searchTimeout = null;
        let currentEditingAmenityId = null;
        let currentEditingVideoId = null;
        let currentEditingReviewId = null;
        let selectedRating = 5;

        // ==================== API CLIENT ====================
        
        const API_BASE = '/rentaturista/api';
        
        const api = {
            async request(endpoint, options = {}) {
                try {
                    const url = endpoint === '' ? API_BASE : `${API_BASE}${endpoint}`;
                    
                    console.log('API Request:', url, options);
                    
                    const response = await fetch(url, options);
                    
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        console.error('Non-JSON response:', text.substring(0, 500));
                        throw new Error('La respuesta del servidor no es JSON.');
                    }
                    
                    const data = await response.json();
                    console.log('API Response:', data);
                    
                    if (!data.success) {
                        const errorMsg = data.error || 'Error en la petición';
                        const errorDetails = data.details ? JSON.stringify(data.details) : '';
                        console.error('API Error Details:', data);
                        throw new Error(errorMsg + (errorDetails ? ': ' + errorDetails : ''));
                    }
                    
                    return data;
                } catch (error) {
                    console.error('API Error:', error);
                    throw error;
                }
            },
            
            async getProperties(filters = {}) {
                const params = new URLSearchParams();
                for (const [key, value] of Object.entries(filters)) {
                    if (value !== '' && value !== null && value !== undefined) {
                        params.append(key, value);
                    }
                }
                
                const queryString = params.toString();
                const endpoint = queryString ? `/properties?${queryString}` : '/properties';
                return this.request(endpoint);
            },
            
            async getProperty(id) {
                return this.request(`/properties/${id}`);
            },
            
            async updateProperty(id, data) {
                return this.request(`/properties/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            },
            
            async deleteProperty(id) {
                return this.request(`/properties/${id}`, {
                    method: 'DELETE'
                });
            },
            
            async getStats() {
                return this.request('/stats/dashboard');
            },

            // Videos API
            async getVideos(propertyId) {
                return this.request(`/properties/${propertyId}/videos`);
            },

            async addVideo(propertyId, data) {
                return this.request(`/properties/${propertyId}/videos`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            },

            async updateVideo(videoId, data) {
                return this.request(`/videos/${videoId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            },

            async deleteVideo(videoId) {
                return this.request(`/videos/${videoId}`, {
                    method: 'DELETE'
                });
            },

            async setPrimaryVideo(videoId) {
                return this.request(`/videos/${videoId}/primary`, {
                    method: 'PUT'
                });
            },

            // Reviews API
            async getReviews(propertyId) {
                return this.request(`/properties/${propertyId}/reviews`);
            },

            async addReview(propertyId, data) {
                return this.request(`/properties/${propertyId}/reviews`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            },

            async updateReview(reviewId, data) {
                return this.request(`/reviews/${reviewId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
            },

            async deleteReview(reviewId) {
                return this.request(`/reviews/${reviewId}`, {
                    method: 'DELETE'
                });
            },

            async approveReview(reviewId) {
                return this.request(`/reviews/${reviewId}/approve`, {
                    method: 'PUT'
                });
            }
        };

        // ==================== UI FUNCTIONS ====================
        
        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('active');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.add('active');
            
            setTimeout(() => {
                toast.classList.remove('active');
            }, 3000);
        }

        function openViewModal() {
            document.getElementById('viewModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeViewModal() {
            document.getElementById('viewModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function openEditModal() {
            document.getElementById('editModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeEditModal() {
            document.getElementById('editModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // ==================== PRICE RANGE HELPER ====================
        
        function getPriceRangeValue(pricePerNight) {
            if (pricePerNight < 50000) return 1;   // $
            if (pricePerNight < 100000) return 2;  // $$
            if (pricePerNight < 150000) return 3;  // $$$
            return 4;                               // $$$$




        }

        function getPriceRangeName(value) {
            const ranges = ['', 'budget', 'moderate', 'upscale', 'luxury'];
            return ranges[value] || 'moderate';
        }

        // ==================== STATS FUNCTIONS ====================
        
        async function loadDashboardStats() {
            try {
                const response = await api.getStats();
                const stats = response.data.overview;
                const growth = response.data.growth.properties;
                
                document.getElementById('totalProperties').textContent = stats.total_properties;
                document.getElementById('activeProperties').textContent = stats.active_properties;
                document.getElementById('totalBookings').textContent = stats.total_bookings;
                
                const revenue = stats.estimated_revenue;
                const revenueK = Math.round(revenue / 1000);
                document.getElementById('totalRevenue').textContent = `$${revenueK}K`;
                
                const growthPercent = growth.percentage >= 0 ? `+${growth.percentage}%` : `${growth.percentage}%`;
                document.getElementById('propGrowth').textContent = growthPercent;
                
                lucide.createIcons();
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // ==================== PROPERTIES FUNCTIONS ====================
        
      async function loadProperties(filters = {}) {
    try {
        showLoading();
        
        const response = await api.getProperties(filters);
        
        console.log('API Response:', response); // Debug
        
        // ✅ CORRECCIÓN: Extraer el array de properties correctamente
        let properties = [];
        
        if (response.data) {
            // Si response.data tiene una propiedad 'properties', usarla
            if (response.data.properties && Array.isArray(response.data.properties)) {
                properties = response.data.properties;
            }
            // Si response.data es directamente un array
            else if (Array.isArray(response.data)) {
                properties = response.data;
            }
            // Si no es ni un array ni tiene properties, mostrar error
            else {
                console.error('Unexpected data structure:', response.data);
                throw new Error('La estructura de datos de la API es incorrecta');
            }
        }
        
        console.log('Properties array:', properties); // Debug
        
        renderProperties(properties);
        
        hideLoading();
    } catch (error) {
        hideLoading();
        console.error('Error loading properties:', error);
        
        const container = document.getElementById('propertiesList');
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="alert-circle" size="48"></i>
                </div>
                <h3 class="empty-title">Error al cargar las propiedades</h3>
                <p class="empty-text">${error.message}</p>
                <button class="btn btn-primary" onclick="loadProperties()">
                    <i data-lucide="refresh-cw" size="18"></i>
                    Reintentar
                </button>
            </div>
        `;
        lucide.createIcons();
    }
}

    function renderProperties(properties) {
    const container = document.getElementById('propertiesList');
    
    // ✅ Verificación adicional por seguridad
    if (!Array.isArray(properties)) {
        console.error('renderProperties received non-array:', properties);
        properties = [];
    }
    
    if (properties.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="home" size="48"></i>
                </div>
                <h3 class="empty-title">No se encontraron propiedades</h3>
                <p class="empty-text">Intenta ajustar los filtros o agrega una nueva propiedad</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

            
            container.innerHTML = properties.map(property => {
                const statusLabels = { active: 'Activa', pending: 'Pendiente', inactive: 'Inactiva', draft: 'Borrador' };
                const statusIcons = { active: 'check-circle', pending: 'clock', inactive: 'x-circle', draft: 'file-text' };
                
                // Calculate price range from price_per_night
                const priceRange = getPriceRangeValue(property.pricing.price_per_night);
                
                return `
                    <div class="property-card">
                        <div class="property-image">
                            ${property.primary_image ? 
                                `<img src="${property.primary_image}" alt="${property.title}">` :
                                `<i data-lucide="${property.type.icon}" size="56"></i>`
                            }
                            ${property.featured ? `
                                <div class="property-badge">
                                    <i data-lucide="star" size="12"></i>
                                    Destacada
                                </div>
                            ` : ''}
                            <div class="property-status ${property.status}">
                                <i data-lucide="${statusIcons[property.status]}" size="12"></i>
                                ${statusLabels[property.status]}
                            </div>
                        </div>
                        <div class="property-content">
                            <h3 class="property-title">${property.title}</h3>
                            <div class="property-location">
                                <i data-lucide="map-pin" size="14"></i>
                                ${property.location.city}${property.location.neighborhood ? ', ' + property.location.neighborhood : ''}
                            </div>
                            <div class="property-stats">
                                <div class="property-stat">
                                    <i data-lucide="bed-double" size="16"></i>
                                    ${property.features.bedrooms}
                                </div>
                                <div class="property-stat">
                                    <i data-lucide="bath" size="16"></i>
                                    ${property.features.bathrooms}
                                </div>
                                <div class="property-stat">
                                    <i data-lucide="users" size="16"></i>
                                    ${property.features.max_guests}
                                </div>
                            </div>
                            <div class="property-footer">
                                <div class="property-price">
                                    ${Array.from({length: 4}, (_, i) => `
                                        <i data-lucide="dollar-sign" size="18" class="price-icon ${i < priceRange ? 'filled' : 'empty'}"></i>
                                    `).join('')}
                                </div>
                                <div class="property-actions">
                                    <button class="action-btn primary" onclick="viewProperty(${property.id})" title="Ver detalles">
                                        <i data-lucide="eye" size="18"></i>
                                    </button>
                                    <button class="action-btn" onclick="editProperty(${property.id})" title="Editar">
                                        <i data-lucide="edit" size="18"></i>
                                    </button>
                                    <button class="action-btn danger" onclick="confirmDelete(${property.id}, '${property.title.replace(/'/g, "\\'")}')") title="Eliminar">
                                        <i data-lucide="trash-2" size="18"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
            
            lucide.createIcons();
        }

        // ==================== VIEW PROPERTY ====================
        
        async function viewProperty(id) {
            try {
                showLoading();
                
                const response = await api.getProperty(id);
                const property = response.data;
                currentProperty = property;
                
                // Load videos and reviews
                let videos = [];
                let reviews = [];
                
                try {
                    const videosResponse = await api.getVideos(id);
                    videos = videosResponse.data || [];
                } catch (e) {
                    console.error('Error loading videos:', e);
                }
                
                try {
                    const reviewsResponse = await api.getReviews(id);
                    reviews = reviewsResponse.data || [];
                } catch (e) {
                    console.error('Error loading reviews:', e);
                }
                
                const statusLabels = { active: 'Activa', pending: 'Pendiente', inactive: 'Inactiva', draft: 'Borrador' };
                
                const content = `
                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="info" size="20"></i>
                            Información General
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Tipo</div>
                                <div class="detail-value">${property.type.name}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Estado</div>
                                <div class="detail-value">${statusLabels[property.status]}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Superficie</div>
                                <div class="detail-value">${property.features.surface_m2 || 'N/A'} m²</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Calificación</div>
                                <div class="detail-value">⭐ ${property.stats.average_rating} (${property.stats.reviews_count})</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="bed-double" size="20"></i>
                            Características
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Dormitorios</div>
                                <div class="detail-value">${property.features.bedrooms}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Baños</div>
                                <div class="detail-value">${property.features.bathrooms}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Huéspedes</div>
                                <div class="detail-value">${property.features.max_guests}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Cocheras</div>
                                <div class="detail-value">${property.features.garage_spaces}</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="dollar-sign" size="20"></i>
                            Precios
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Por noche</div>
                                <div class="detail-value">$${property.pricing.price_per_night.toLocaleString('es-AR')}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Limpieza</div>
                                <div class="detail-value">$${property.pricing.cleaning_fee.toLocaleString('es-AR')}</div>
                            </div>
                        </div>
                    </div>

                    ${property.amenities && property.amenities.length > 0 ? `
                        <div class="modal-section">
                            <h3 class="section-title">
                                <i data-lucide="sparkles" size="20"></i>
                                Amenidades (${property.amenities.length})
                            </h3>
                            <div class="amenities-grid">
                                ${property.amenities.slice(0, 8).map(amenity => `
                                    <div class="amenity-toggle active">
                                        <div class="amenity-info">
                                            <div class="amenity-icon">
                                                <i data-lucide="check" size="16"></i>
                                            </div>
                                            <div>
                                                <div class="amenity-label">${amenity.name}</div>
                                                ${amenity.value ? `<small style="color: var(--gray-600);">${amenity.value}</small>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            ${property.amenities.length > 8 ? `<p style="margin-top: var(--space-md); color: var(--gray-600);">+ ${property.amenities.length - 8} más...</p>` : ''}
                        </div>
                    ` : ''}

                    ${property.images && property.images.length > 0 ? `
                        <div class="modal-section">
                            <h3 class="section-title">
                                <i data-lucide="image" size="20"></i>
                                Imágenes (${property.images.length})
                            </h3>
                            <div class="images-grid">
                                ${property.images.map(image => `
                                    <div class="image-item">
                                        <img src="${image.url}" alt="${image.alt_text || property.title}">
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="video" size="20"></i>
                            Videos (${videos.length})
                            <button class="btn btn-secondary" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.875rem;" 
                                    onclick="openVideoModal()">
                                <i data-lucide="plus" size="16"></i>
                                Agregar
                            </button>
                        </h3>
                        <div class="videos-grid" id="viewVideosGrid">
                            ${videos.length > 0 ? videos.map(video => `
                                <div class="video-card">
                                    <div class="video-embed">
                                        ${video.type === 'youtube' ? 
                                            `<iframe src="${video.url}" frameborder="0" allowfullscreen></iframe>` :
                                            video.type === 'vimeo' ?
                                            `<iframe src="${video.url}" frameborder="0" allowfullscreen></iframe>` :
                                            `<video src="${video.url}" controls></video>`
                                        }
                                    </div>
                                    <div class="video-info">
                                        <h4>
                                            ${video.title || 'Video sin título'}
                                            ${video.is_primary ? '<span class="badge-primary"><i data-lucide="star" size="12"></i> Principal</span>' : ''}
                                        </h4>
                                        ${video.description ? `<p style="color: var(--gray-600); font-size: 0.875rem;">${video.description}</p>` : ''}
                                        <div style="margin-top: 0.5rem;">
                                            <span class="badge-${video.type}">${video.type.toUpperCase()}</span>
                                        </div>
                                    </div>
                                    <div class="video-actions">
                                        ${!video.is_primary ? 
                                            `<button onclick="setPrimaryVideo(${video.id})">
                                                <i data-lucide="star" size="16"></i>
                                                Principal
                                            </button>` : 
                                            '<button disabled style="opacity: 0.5;"><i data-lucide="star" size="16"></i> Es principal</button>'
                                        }
                                        <button class="btn-danger" onclick="deleteVideo(${video.id})">
                                            <i data-lucide="trash-2" size="16"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            `).join('') : '<p style="color: var(--gray-600);">No hay videos agregados</p>'}
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="message-square" size="20"></i>
                            Reseñas (${reviews.length})
                            <button class="btn btn-secondary" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.875rem;" 
                                    onclick="openReviewModal()">
                                <i data-lucide="plus" size="16"></i>
                                Agregar
                            </button>
                        </h3>
                        <div class="reviews-list" id="viewReviewsList">
                            ${reviews.length > 0 ? reviews.map(review => `
                                <div class="review-card">
                                    <div class="review-header">
                                        <div>
                                            <div class="review-author">${review.reviewer_name}</div>
                                            <div class="review-rating">${'⭐'.repeat(review.rating)}</div>
                                        </div>
                                        <div class="review-date">${new Date(review.created_at).toLocaleDateString('es-AR')}</div>
                                    </div>
                                    <p class="review-comment">${review.comment}</p>
                                    <div class="review-actions">
                                        ${!review.is_approved ? 
                                            `<button onclick="approveReview(${review.id})">
                                                <i data-lucide="check-circle" size="16"></i>
                                                Aprobar
                                            </button>` : 
                                            '<span style="color: var(--success); font-size: 0.875rem; font-weight: 600;">✓ Aprobada</span>'
                                        }
                                        <button class="btn-danger" onclick="deleteReview(${review.id})">
                                            <i data-lucide="trash-2" size="16"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            `).join('') : '<p style="color: var(--gray-600);">No hay reseñas</p>'}
                        </div>
                    </div>
                `;
                
                document.getElementById('viewModalContent').innerHTML = content;
                openViewModal();
                
                hideLoading();
            } catch (error) {
                hideLoading();
                showToast('Error al cargar los detalles', 'error');
                console.error(error);
            }
        }

        // ==================== EDIT PROPERTY ====================
        
        async function editProperty(id) {
            try {
                showLoading();
                
                const response = await api.getProperty(id);
                const property = response.data;
                currentProperty = property;
                
                // Calcular rango de precio actual
                const currentPriceRange = getPriceRangeValue(property.pricing.price_per_night);
                
                const commonAmenities = [
                    { id: 'wifi', name: 'WiFi', icon: 'wifi', hasValue: true, valuePlaceholder: 'Ej: 100 Mbps' },
                    { id: 'pool', name: 'Piscina', icon: 'waves', hasValue: true, valuePlaceholder: 'Ej: Climatizada' },
                    { id: 'ac', name: 'Aire Acondicionado', icon: 'air-vent', hasValue: false },
                    { id: 'heating', name: 'Calefacción', icon: 'flame', hasValue: false },
                    { id: 'parking', name: 'Estacionamiento', icon: 'car', hasValue: false },
                    { id: 'kitchen', name: 'Cocina Completa', icon: 'chef-hat', hasValue: false },
                    { id: 'tv', name: 'TV', icon: 'tv', hasValue: true, valuePlaceholder: 'Ej: Smart TV 55"' },
                    { id: 'washer', name: 'Lavarropas', icon: 'washing-machine', hasValue: false },
                    { id: 'grill', name: 'Parrilla', icon: 'flame', hasValue: true, valuePlaceholder: 'Ej: Quincho cubierto' },
                    { id: 'garden', name: 'Jardín', icon: 'trees', hasValue: false },
                ];
                
                const amenitiesHTML = commonAmenities.map(amenity => {
                    const existing = property.amenities?.find(a => 
                        a.name.toLowerCase().includes(amenity.name.toLowerCase())
                    );
                    const isActive = !!existing;
                    const value = existing?.value || '';
                    
                    return `
                        <div class="amenity-toggle ${isActive ? 'active' : 'inactive'}" data-amenity="${amenity.id}">
                            <div class="amenity-info">
                                <div class="amenity-icon">
                                    <i data-lucide="${amenity.icon}" size="16"></i>
                                </div>
                                <div>
                                    <div class="amenity-label">${amenity.name}</div>
                                    ${amenity.hasValue && value ? `
                                        <small style="color: var(--gray-600); font-size: 0.8rem; display: block; margin-top: 0.25rem;" 
                                               data-amenity-value-display="${amenity.id}">${value}</small>
                                    ` : ''}
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                ${amenity.hasValue ? `
                                    <button type="button"
                                            class="amenity-edit-btn" 
                                            data-amenity-edit="${amenity.id}"
                                            onclick="openAmenityValueModal('${amenity.id}', '${amenity.name}', '${amenity.valuePlaceholder}', '${value.replace(/'/g, "\\'")}')"
                                            ${!isActive ? 'disabled' : ''}
                                            title="Editar detalles">
                                        <i data-lucide="type" size="16"></i>
                                    </button>
                                    <input type="hidden" 
                                           data-amenity-value="${amenity.id}"
                                           value="${value}">
                                ` : ''}
                                <div class="toggle-switch ${isActive ? 'active' : ''}" onclick="toggleAmenity('${amenity.id}')">
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                const content = `
                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="info" size="20"></i>
                            Información Básica
                        </h3>
                        <div class="form-group">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-input" value="${property.title}" id="editTitle">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-textarea" id="editDescription">${property.description || ''}</textarea>
                        </div>
                        <div class="detail-grid">
                            <div class="form-group">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-input" value="${property.location.city}" id="editCity">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Barrio/Zona</label>
                                <input type="text" class="form-input" value="${property.location.neighborhood || ''}" id="editNeighborhood">
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="bed-double" size="20"></i>
                            Características
                        </h3>
                        <div class="detail-grid">
                            <div class="form-group">
                                <label class="form-label">Dormitorios</label>
                                <input type="number" class="form-input" value="${property.features.bedrooms}" id="editBedrooms" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Baños</label>
                                <input type="number" class="form-input" value="${property.features.bathrooms}" step="0.5" id="editBathrooms" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Huéspedes</label>
                                <input type="number" class="form-input" value="${property.features.max_guests}" id="editMaxGuests" min="1">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Superficie (m²)</label>
                                <input type="number" class="form-input" value="${property.features.surface_m2 || ''}" id="editSurface" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="dollar-sign" size="20"></i>
                            Precios
                        </h3>
                        <div class="form-group">
                            <label class="form-label">Precio por noche (ARS)</label>
                            <input type="number" class="form-input" value="${property.pricing.price_per_night}" id="editPrice" min="0" oninput="updatePriceRange()">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rango de precio</label>
                            <div class="price-range-selector">
                                <div class="price-range-option ${currentPriceRange === 1 ? 'active' : ''}" data-range="1" onclick="selectPriceRange(1)">
                                    <div class="price-range-label">Económico</div>
                                    <div class="price-range-icons">$</div>
                                    <small style="color: var(--gray-600); font-size: 0.75rem;">&lt; $50K</small>
                                </div>
                                <div class="price-range-option ${currentPriceRange === 2 ? 'active' : ''}" data-range="2" onclick="selectPriceRange(2)">
                                    <div class="price-range-label">Moderado</div>
                                    <div class="price-range-icons">$$</div>
                                    <small style="color: var(--gray-600); font-size: 0.75rem;">$50K - $100K</small>
                                </div>
                                <div class="price-range-option ${currentPriceRange === 3 ? 'active' : ''}" data-range="3" onclick="selectPriceRange(3)">
                                    <div class="price-range-label">Alto</div>
                                    <div class="price-range-icons">$$$</div>
                                    <small style="color: var(--gray-600); font-size: 0.75rem;">$100K - $150K</small>
                                </div>
                                <div class="price-range-option ${currentPriceRange === 4 ? 'active' : ''}" data-range="4" onclick="selectPriceRange(4)">
                                    <div class="price-range-label">Lujo</div>
                                    <div class="price-range-icons">$$$$</div>
                                    <small style="color: var(--gray-600); font-size: 0.75rem;">&gt; $150K</small>
                                </div>
                            </div>
                        </div>
                        <div class="detail-grid">
                            <div class="form-group">
                                <label class="form-label">Tarifa de limpieza</label>
                                <input type="number" class="form-input" value="${property.pricing.cleaning_fee}" id="editCleaningFee" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="modal-section">
                        <h3 class="section-title">
                            <i data-lucide="sparkles" size="20"></i>
                            Amenidades
                        </h3>
                        <div class="amenities-grid">
                            ${amenitiesHTML}
                        </div>
                    </div>
                `;
                
                document.getElementById('editModalContent').innerHTML = content;
                openEditModal();
                
                hideLoading();
            } catch (error) {
                hideLoading();
                showToast('Error al cargar el formulario', 'error');
                console.error(error);
            }
        }

        function selectPriceRange(range) {
            document.querySelectorAll('.price-range-option').forEach(opt => opt.classList.remove('active'));
            document.querySelector(`[data-range="${range}"]`).classList.add('active');
            
            // Sugerir precio según rango
            const prices = [0, 40000, 75000, 125000, 180000];
            document.getElementById('editPrice').value = prices[range];
        }

        function updatePriceRange() {
            const price = parseFloat(document.getElementById('editPrice').value) || 0;
            const range = getPriceRangeValue(price);
            
            document.querySelectorAll('.price-range-option').forEach(opt => opt.classList.remove('active'));
            document.querySelector(`[data-range="${range}"]`)?.classList.add('active');
        }

        function toggleAmenity(amenityId) {
            const toggle = document.querySelector(`[data-amenity="${amenityId}"]`);
            const switchEl = toggle.querySelector('.toggle-switch');
            const editBtn = toggle.querySelector('.amenity-edit-btn');
            
            const isActive = switchEl.classList.contains('active');
            
            if (isActive) {
                switchEl.classList.remove('active');
                toggle.classList.remove('active');
                toggle.classList.add('inactive');
                if (editBtn) editBtn.disabled = true;
            } else {
                switchEl.classList.add('active');
                toggle.classList.add('active');
                toggle.classList.remove('inactive');
                if (editBtn) editBtn.disabled = false;
            }
            
            lucide.createIcons();
        }

        function openAmenityValueModal(amenityId, amenityName, placeholder, currentValue) {
            currentEditingAmenityId = amenityId;
            
            document.getElementById('amenityValueModalTitle').textContent = `Editar ${amenityName}`;
            document.getElementById('amenityValueLabel').textContent = `Detalles de ${amenityName}`;
            document.getElementById('amenityValueInput').placeholder = placeholder;
            document.getElementById('amenityValueInput').value = currentValue || '';
            
            document.getElementById('amenityValueModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                document.getElementById('amenityValueInput').focus();
            }, 100);
            
            lucide.createIcons();
        }

        function closeAmenityValueModal() {
            document.getElementById('amenityValueModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            currentEditingAmenityId = null;
        }

        function saveAmenityValue() {
            if (!currentEditingAmenityId) return;
            
            const value = document.getElementById('amenityValueInput').value.trim();
            
            const hiddenInput = document.querySelector(`[data-amenity-value="${currentEditingAmenityId}"]`);
            if (hiddenInput) {
                hiddenInput.value = value;
            }
            
            const displayElement = document.querySelector(`[data-amenity-value-display="${currentEditingAmenityId}"]`);
            if (displayElement) {
                if (value) {
                    displayElement.textContent = value;
                    displayElement.style.display = 'block';
                } else {
                    displayElement.style.display = 'none';
                }
            } else if (value) {
                const toggle = document.querySelector(`[data-amenity="${currentEditingAmenityId}"]`);
                const amenityInfo = toggle.querySelector('.amenity-info > div');
                if (amenityInfo) {
                    const small = document.createElement('small');
                    small.style.cssText = 'color: var(--gray-600); font-size: 0.8rem; display: block; margin-top: 0.25rem;';
                    small.setAttribute('data-amenity-value-display', currentEditingAmenityId);
                    small.textContent = value;
                    amenityInfo.appendChild(small);
                }
            }
            
            closeAmenityValueModal();
        }

        async function savePropertyChanges() {
            if (!currentProperty) return;
            
            try {
                showLoading();
                
                const amenities = [];
                document.querySelectorAll('.amenity-toggle.active').forEach(toggle => {
                    const amenityId = toggle.dataset.amenity;
                    const amenityLabel = toggle.querySelector('.amenity-label').textContent;
                    const valueInput = toggle.querySelector(`[data-amenity-value="${amenityId}"]`);
                    
                    amenities.push({
                        name: amenityLabel,
                        value: valueInput ? valueInput.value.trim() : null
                    });
                });
                
                const pricePerNight = parseFloat(document.getElementById('editPrice').value);
                const priceRange = getPriceRangeName(getPriceRangeValue(pricePerNight));
                
                const updates = {
                    title: document.getElementById('editTitle').value,
                    description: document.getElementById('editDescription').value,
                    city: document.getElementById('editCity').value,
                    neighborhood: document.getElementById('editNeighborhood').value,
                    bedrooms: parseInt(document.getElementById('editBedrooms').value),
                    bathrooms: parseFloat(document.getElementById('editBathrooms').value),
                    max_guests: parseInt(document.getElementById('editMaxGuests').value),
                    surface_m2: parseFloat(document.getElementById('editSurface').value) || null,
                    price_per_night: pricePerNight,
                    price_range: priceRange,
                    cleaning_fee: parseFloat(document.getElementById('editCleaningFee').value),
                    amenities: amenities
                };
                
                await api.updateProperty(currentProperty.id, updates);
                
                closeEditModal();
                hideLoading();
                showToast('✅ Propiedad actualizada exitosamente');
                
                const filters = {};
                if (currentFilter) {
                    filters.status = currentFilter;
                }
                await loadProperties(filters);
            } catch (error) {
                hideLoading();
                showToast('Error al actualizar la propiedad', 'error');
                console.error(error);
            }
        }

        // ==================== VIDEO MANAGEMENT ====================
        
        function openVideoModal(videoId = null) {
            currentEditingVideoId = videoId;
            
            if (videoId) {
                document.getElementById('videoModalTitle').textContent = 'Editar Video';
                document.getElementById('videoModalBtnText').textContent = 'Guardar Cambios';
                // TODO: Cargar datos del video
            } else {
                document.getElementById('videoModalTitle').textContent = 'Agregar Video';
                document.getElementById('videoModalBtnText').textContent = 'Agregar Video';
                document.getElementById('videoUrl').value = '';
                document.getElementById('videoTitle').value = '';
                document.getElementById('videoDescription').value = '';
            }
            
            document.getElementById('videoModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeVideoModal() {
            document.getElementById('videoModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            currentEditingVideoId = null;
        }

        async function saveVideo() {
            if (!currentProperty) return;
            
            const url = document.getElementById('videoUrl').value.trim();
            const title = document.getElementById('videoTitle').value.trim();
            const description = document.getElementById('videoDescription').value.trim();
            
            if (!url) {
                showToast('Por favor ingresa la URL del video', 'error');
                return;
            }
            
            try {
                showLoading();
                
                if (currentEditingVideoId) {
                    await api.updateVideo(currentEditingVideoId, { title, description });
                } else {
                    await api.addVideo(currentProperty.id, { url, title, description });
                }
                
                closeVideoModal();
                hideLoading();
                showToast('✅ Video guardado exitosamente');
                
                // Reload view modal
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al guardar video', 'error');
                console.error(error);
            }
        }

        async function setPrimaryVideo(videoId) {
            try {
                showLoading();
                await api.setPrimaryVideo(videoId);
                hideLoading();
                showToast('✅ Video marcado como principal');
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al marcar video como principal', 'error');
                console.error(error);
            }
        }

        async function deleteVideo(videoId) {
            if (!confirm('¿Eliminar este video? Esta acción no se puede deshacer.')) return;
            
            try {
                showLoading();
                await api.deleteVideo(videoId);
                hideLoading();
                showToast('🗑️ Video eliminado');
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al eliminar video', 'error');
                console.error(error);
            }
        }

        // ==================== REVIEW MANAGEMENT ====================
        
        function openReviewModal(reviewId = null) {
            currentEditingReviewId = reviewId;
            
            if (reviewId) {
                document.getElementById('reviewModalTitle').textContent = 'Editar Reseña';
                document.getElementById('reviewModalBtnText').textContent = 'Guardar Cambios';
                // TODO: Cargar datos de la reseña
            } else {
                document.getElementById('reviewModalTitle').textContent = 'Agregar Reseña';
                document.getElementById('reviewModalBtnText').textContent = 'Agregar Reseña';
                document.getElementById('reviewGuestName').value = '';
                document.getElementById('reviewComment').value = '';
                selectedRating = 5;
                selectRating(5);
            }
            
            document.getElementById('reviewModalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeReviewModal() {
            document.getElementById('reviewModalOverlay').classList.remove('active');
            document.body.style.overflow = '';
            currentEditingReviewId = null;
        }

        function selectRating(rating) {
            selectedRating = rating;
            document.querySelectorAll('[data-rating]').forEach(opt => opt.classList.remove('active'));
            document.querySelector(`[data-rating="${rating}"]`).classList.add('active');
        }

        async function saveReview() {
            if (!currentProperty) return;
            
            const guestName = document.getElementById('reviewGuestName').value.trim();
            const comment = document.getElementById('reviewComment').value.trim();
            
            if (!guestName || !comment) {
                showToast('Por favor completa todos los campos', 'error');
                return;
            }
            
            try {
                showLoading();
                
                if (currentEditingReviewId) {
                    await api.updateReview(currentEditingReviewId, { 
                        reviewer_name: guestName, 
                        rating: selectedRating, 
                        comment 
                    });
                } else {
                    await api.addReview(currentProperty.id, { 
                        reviewer_name: guestName, 
                        rating: selectedRating, 
                        comment 
                    });
                }
                
                closeReviewModal();
                hideLoading();
                showToast('✅ Reseña guardada exitosamente');
                
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al guardar reseña', 'error');
                console.error(error);
            }
        }

        async function approveReview(reviewId) {
            try {
                showLoading();
                await api.approveReview(reviewId);
                hideLoading();
                showToast('✅ Reseña aprobada');
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al aprobar reseña', 'error');
                console.error(error);
            }
        }

        async function deleteReview(reviewId) {
            if (!confirm('¿Eliminar esta reseña? Esta acción no se puede deshacer.')) return;
            
            try {
                showLoading();
                await api.deleteReview(reviewId);
                hideLoading();
                showToast('🗑️ Reseña eliminada');
                await viewProperty(currentProperty.id);
            } catch (error) {
                hideLoading();
                showToast('Error al eliminar reseña', 'error');
                console.error(error);
            }
        }

        // ==================== DELETE PROPERTY ====================
        
        function confirmDelete(id, title) {
            if (confirm(`¿Eliminar "${title}"? Esta acción no se puede deshacer.`)) {
                deleteProperty(id);
            }
        }

        async function deleteProperty(id) {
            try {
                showLoading();
                
                await api.deleteProperty(id);
                
                hideLoading();
                showToast('🗑️ Propiedad eliminada');
                
                await loadProperties({ status: currentFilter });
                await loadDashboardStats();
            } catch (error) {
                hideLoading();
                showToast('Error al eliminar la propiedad', 'error');
                console.error(error);
            }
        }

        // ==================== EVENT LISTENERS ====================
        
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                
                currentFilter = this.dataset.filter;
                const filters = currentFilter ? { status: currentFilter } : {};
                loadProperties(filters);
            });
        });

        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const search = e.target.value.trim();
                const filters = { search };
                if (currentFilter) filters.status = currentFilter;
                loadProperties(filters);
            }, 500);
        });

        document.getElementById('viewModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeViewModal();
        });

        document.getElementById('editModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        document.getElementById('amenityValueModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeAmenityValueModal();
        });

        document.getElementById('videoModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeVideoModal();
        });

        document.getElementById('reviewModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeReviewModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (document.getElementById('amenityValueModalOverlay').classList.contains('active')) {
                    closeAmenityValueModal();
                } else if (document.getElementById('videoModalOverlay').classList.contains('active')) {
                    closeVideoModal();
                } else if (document.getElementById('reviewModalOverlay').classList.contains('active')) {
                    closeReviewModal();
                }
            }
        });

        // ==================== INITIALIZATION ====================
        
        document.addEventListener('DOMContentLoaded', async function() {
            await loadDashboardStats();
            await loadProperties();
        });
    </script>
</body>
</html>
