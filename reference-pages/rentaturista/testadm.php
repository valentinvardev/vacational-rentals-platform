<?php
// Cargar configuración y modelos
require_once __DIR__ . './config/config.php';
require_once __DIR__ . './config/Database.php';
require_once __DIR__ . './models/Property.php';

// Inicializar modelo de propiedades
$propertyModel = new Property();

// Obtener estadísticas para el dashboard
try {
    $db = Database::getInstance()->getConnection();
    
    // Total de propiedades
    $stmt = $db->query("SELECT COUNT(*) as total FROM properties");
    $totalProperties = $stmt->fetch()['total'];
    
    // Propiedades activas
    $stmt = $db->query("SELECT COUNT(*) as total FROM properties WHERE status = 'active'");
    $activeProperties = $stmt->fetch()['total'];
    
    // Total de reservas (si existe la tabla)
    $stmt = $db->query("SELECT COUNT(*) as total FROM bookings");
    $totalBookings = $stmt->fetch()['total'];
    
    // Ingresos totales (suma de reservas pagadas)
    $stmt = $db->query("SELECT SUM(total_amount) as total FROM bookings WHERE payment_status = 'paid'");
    $totalRevenue = $stmt->fetch()['total'] ?? 0;
    
} catch (Exception $e) {
    $totalProperties = 0;
    $activeProperties = 0;
    $totalBookings = 0;
    $totalRevenue = 0;
}
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            
            --header-height: 60px;
            --bottom-nav-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-body);
            -webkit-tap-highlight-color: transparent;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
        }

        body {
            background: linear-gradient(135deg, #FAFAFA 0%, #F8F8F8 100%);
            color: var(--gray-800);
            overflow-x: hidden;
            padding-bottom: var(--bottom-nav-height);
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: calc(var(--header-height) + 1rem);
            right: 1rem;
            background: var(--white);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 3000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            border-left: 4px solid var(--success);
        }

        .toast.error {
            border-left: 4px solid var(--danger);
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast.success .toast-icon {
            color: var(--success);
        }

        .toast.error .toast-icon {
            color: var(--danger);
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--orange-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .header-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--gray-700);
            position: relative;
        }

        .header-btn:active {
            transform: scale(0.95);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger);
            color: var(--white);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content */
        .main-content {
            padding-top: var(--header-height);
            min-height: 100vh;
        }

        .content-padding {
            padding: 1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 16px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .stat-value {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.75rem;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Search & Filter */
        .search-filter-bar {
            margin-bottom: 1rem;
        }

        .search-box {
            position: relative;
            margin-bottom: 0.75rem;
        }

        .search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
        }

        .filter-chips {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .filter-chips::-webkit-scrollbar {
            display: none;
        }

        .filter-chip {
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-700);
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .filter-chip:active {
            transform: scale(0.95);
        }

        .filter-chip.active {
            background: rgba(255, 107, 53, 0.1);
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        /* Property Cards */
        .properties-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .property-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .property-image-container {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--orange-light) 0%, var(--orange-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .property-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .property-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            color: var(--white);
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .property-status {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .property-status.active {
            background: rgba(16, 185, 129, 0.9);
            color: var(--white);
        }

        .property-status.draft {
            background: rgba(245, 158, 11, 0.9);
            color: var(--white);
        }

        .property-status.inactive {
            background: rgba(107, 114, 128, 0.9);
            color: var(--white);
        }

        .property-content {
            padding: 1rem;
        }

        .property-header {
            margin-bottom: 0.75rem;
        }

        .property-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--gray-900);
            margin-bottom: 0.375rem;
            line-height: 1.3;
        }

        .property-location {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .property-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .property-stat {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .property-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .property-price {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--orange-primary);
        }

        .property-price-label {
            font-size: 0.7rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .property-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--gray-700);
        }

        .action-btn:active {
            transform: scale(0.9);
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

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: var(--bottom-nav-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-top: 2px solid rgba(101, 67, 33, 0.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 1rem;
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem;
            color: var(--gray-600);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            flex: 1;
        }

        .nav-item.active {
            color: var(--orange-primary);
        }

        .nav-item-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item-label {
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* FAB Button */
        .fab {
            position: fixed;
            bottom: calc(var(--bottom-nav-height) + 1rem);
            right: 1rem;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
            border: none;
        }

        .fab:active {
            transform: scale(0.9);
        }

        /* Modal */
        .modal-overlay {
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
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 24px 24px 0 0;
            max-height: 90vh;
            overflow: hidden;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2001;
            display: flex;
            flex-direction: column;
        }

        .modal.active {
            transform: translateY(0);
        }

        .modal-handle {
            width: 40px;
            height: 4px;
            background: var(--gray-300);
            border-radius: 2px;
            margin: 0.75rem auto 0;
        }

        .modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
        }

        .modal-close {
            background: rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-700);
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-content {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 2px solid rgba(101, 67, 33, 0.1);
            flex-shrink: 0;
            background: var(--gray-50);
        }

        /* Detail sections */
        .detail-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .detail-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-900);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .detail-item {
            background: var(--gray-50);
            padding: 0.875rem;
            border-radius: 10px;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--gray-600);
            margin-bottom: 0.25rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .detail-value {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 1rem;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .amenity-chip {
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            padding: 0.625rem 0.875rem;
            border-radius: 10px;
            font-size: 0.85rem;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.875rem 1rem;
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
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
        }

        .btn-danger {
            background: var(--danger);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        /* Confirmation Dialog */
        .confirm-dialog {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            margin: auto;
            max-width: 90%;
            width: 400px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 2002;
        }

        .confirm-dialog.active {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .confirm-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--danger);
        }

        .confirm-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .confirm-text {
            color: var(--gray-600);
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* Loading */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-200);
            border-top-color: var(--orange-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (min-width: 768px) {
            .bottom-nav { display: none; }
            body { padding-bottom: 0; }
            .fab { bottom: 2rem; right: 2rem; }
            .properties-list {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }

        @media (min-width: 1024px) {
            .properties-list { grid-template-columns: repeat(3, 1fr); }
            .content-padding {
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <a href="index.php" class="header-logo">
                <div class="header-logo-icon">
                    <i data-lucide="home" size="20"></i>
                </div>
                <span>RentaTurista</span>
            </a>
        </div>
        <div class="header-right">
            <button class="header-btn">
                <i data-lucide="bell" size="20"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-padding">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="building-2" size="20"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $totalProperties; ?></div>
                    <div class="stat-label">Propiedades</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="check-circle" size="20"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $activeProperties; ?></div>
                    <div class="stat-label">Activas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="calendar-check" size="20"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $totalBookings; ?></div>
                    <div class="stat-label">Reservas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i data-lucide="dollar-sign" size="20"></i>
                        </div>
                    </div>
                    <div class="stat-value">$<?php echo number_format($totalRevenue, 0, ',', '.'); ?></div>
                    <div class="stat-label">Ingresos</div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="search-filter-bar">
                <div class="search-box">
                    <i data-lucide="search" size="18" class="search-icon"></i>
                    <input type="text" placeholder="Buscar propiedades..." id="searchInput">
                </div>

                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="">
                        <i data-lucide="list" size="14"></i>
                        Todas
                    </div>
                    <div class="filter-chip" data-filter="active">
                        <i data-lucide="check-circle" size="14"></i>
                        Activas
                    </div>
                    <div class="filter-chip" data-filter="draft">
                        <i data-lucide="clock" size="14"></i>
                        Borradores
                    </div>
                    <div class="filter-chip" data-filter="inactive">
                        <i data-lucide="x-circle" size="14"></i>
                        Inactivas
                    </div>
                </div>
            </div>

            <!-- Properties List -->
            <div class="properties-list" id="propertiesList">
                <div class="loading">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
            <div class="nav-item-icon">
                <i data-lucide="home" size="24"></i>
            </div>
            <span class="nav-item-label">Inicio</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-item-icon">
                <i data-lucide="calendar-check" size="24"></i>
            </div>
            <span class="nav-item-label">Reservas</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-item-icon">
                <i data-lucide="message-square" size="24"></i>
            </div>
            <span class="nav-item-label">Mensajes</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-item-icon">
                <i data-lucide="user" size="24"></i>
            </div>
            <span class="nav-item-label">Perfil</span>
        </a>
    </nav>

    <!-- FAB Button -->
    <button class="fab" id="addPropertyBtn">
        <i data-lucide="plus" size="28"></i>
    </button>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay"></div>

    <!-- View Details Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <h2 class="modal-title">Detalles de la Propiedad</h2>
            <button class="modal-close" onclick="closeModal('viewModal')">
                <i data-lucide="x" size="20"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-content" id="viewModalContent">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-handle"></div>
        <div class="modal-header">
            <h2 class="modal-title">Editar Propiedad</h2>
            <button class="modal-close" onclick="closeModal('editModal')">
                <i data-lucide="x" size="20"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-content" id="editModalContent">
                <!-- Edit form loaded dynamically -->
            </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-secondary" onclick="closeModal('editModal')">Cancelar</button>
                <button class="btn btn-primary" onclick="savePropertyChanges()">
                    <i data-lucide="save" size="18"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Confirmation Dialog -->
    <div class="confirm-dialog" id="confirmDialog">
        <div class="confirm-icon">
            <i data-lucide="alert-triangle" size="28"></i>
        </div>
        <h3 class="confirm-title">¿Estás seguro?</h3>
        <p class="confirm-text" id="confirmText"></p>
        <div class="btn-group">
            <button class="btn btn-secondary" onclick="closeConfirm()">Cancelar</button>
            <button class="btn btn-danger" id="confirmActionBtn">Eliminar</button>
        </div>
    </div>

    <!-- Cliente API -->
    <script src="examples/api-client.js"></script>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Inicializar API
        const api = new RentaTuristaAPI('/api');
        
        let currentProperty = null;
        let confirmCallback = null;
        let currentFilter = '';
        let currentSearch = '';

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div class="toast-icon">
                    <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" size="20"></i>
                </div>
                <div>${message}</div>
            `;
            document.body.appendChild(toast);
            lucide.createIcons();
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Cargar propiedades desde la API
        async function loadProperties() {
            try {
                const filters = {};
                
                if (currentFilter) {
                    filters.status = currentFilter;
                }
                
                if (currentSearch) {
                    filters.search = currentSearch;
                }
                
                const result = await api.getProperties(filters);
                renderProperties(result.data.data);
                
            } catch (error) {
                console.error('Error cargando propiedades:', error);
                showToast('Error al cargar las propiedades', 'error');
                document.getElementById('propertiesList').innerHTML = `
                    <div style="text-align: center; padding: 3rem; color: var(--gray-600);">
                        <i data-lucide="alert-circle" size="48" style="margin-bottom: 1rem;"></i>
                        <p>Error al cargar las propiedades</p>
                    </div>
                `;
                lucide.createIcons();
            }
        }

        // Renderizar propiedades
        function renderProperties(properties) {
            const container = document.getElementById('propertiesList');
            
            if (!properties || properties.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 3rem; color: var(--gray-600);">
                        <i data-lucide="inbox" size="48" style="margin-bottom: 1rem;"></i>
                        <p>No hay propiedades para mostrar</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }
            
            container.innerHTML = properties.map(property => {
                const firstImage = property.images && property.images.length > 0 
                    ? property.images[0].image_url 
                    : null;
                
                const statusLabel = {
                    'active': 'Activa',
                    'draft': 'Borrador',
                    'inactive': 'Inactiva',
                    'archived': 'Archivada'
                }[property.status] || property.status;
                
                return `
                    <div class="property-card">
                        <div class="property-image-container">
                            ${firstImage 
                                ? `<img src="${firstImage}" alt="${property.title}">`
                                : `<i data-lucide="${property.property_type_icon || 'home'}" size="48" style="color: white;"></i>`
                            }
                            ${property.featured ? `
                                <div class="property-badge">
                                    <i data-lucide="star" size="12"></i>
                                    Destacada
                                </div>
                            ` : ''}
                            <div class="property-status ${property.status}">
                                <i data-lucide="${property.status === 'active' ? 'check-circle' : 'clock'}" size="12"></i>
                                ${statusLabel}
                            </div>
                        </div>
                        <div class="property-content">
                            <div class="property-header">
                                <h3 class="property-title">${property.title}</h3>
                                <div class="property-location">
                                    <i data-lucide="map-pin" size="14"></i>
                                    ${property.city}, ${property.state}
                                </div>
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
                                    ${property.max_guests}
                                </div>
                            </div>
                            <div class="property-footer">
                                <div>
                                    <div class="property-price">$${Number(property.price_per_night).toLocaleString('es-AR')}</div>
                                    <div class="property-price-label">por noche</div>
                                </div>
                                <div class="property-actions">
                                    <button class="action-btn primary" onclick="viewProperty(${property.id})" title="Ver detalles">
                                        <i data-lucide="eye" size="18"></i>
                                    </button>
                                    <button class="action-btn" onclick="editProperty(${property.id})" title="Editar">
                                        <i data-lucide="edit" size="18"></i>
                                    </button>
                                    <button class="action-btn danger" onclick="confirmDelete(${property.id}, '${property.title.replace(/'/g, "\\'")})" title="Eliminar">
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

        // Ver detalles de propiedad
        async function viewProperty(id) {
            try {
                const result = await api.getProperty(id);
                const property = result.data;
                currentProperty = property;
                
                const content = `
                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="info" size="20"></i>
                            Información General
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Tipo</div>
                                <div class="detail-value">${property.property_type_name}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Estado</div>
                                <div class="detail-value">${property.status}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Superficie</div>
                                <div class="detail-value">${property.surface_m2 || '-'} m²</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Calificación</div>
                                <div class="detail-value">⭐ ${property.average_rating || '0'} (${property.reviews_count || 0})</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="bed-double" size="20"></i>
                            Características
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Dormitorios</div>
                                <div class="detail-value">${property.bedrooms}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Baños</div>
                                <div class="detail-value">${property.bathrooms}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Huéspedes</div>
                                <div class="detail-value">${property.max_guests}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Cocheras</div>
                                <div class="detail-value">${property.garage_spaces || 0}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="dollar-sign" size="20"></i>
                            Precios
                        </h3>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Por noche</div>
                                <div class="detail-value">$${Number(property.price_per_night).toLocaleString('es-AR')}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Limpieza</div>
                                <div class="detail-value">$${Number(property.cleaning_fee || 0).toLocaleString('es-AR')}</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="align-left" size="20"></i>
                            Descripción
                        </h3>
                        <p style="color: var(--gray-700); line-height: 1.6;">${property.description}</p>
                    </div>

                    ${property.amenities && property.amenities.length > 0 ? `
                        <div class="detail-section">
                            <h3 class="section-title">
                                <i data-lucide="sparkles" size="20"></i>
                                Amenidades
                            </h3>
                            <div class="amenities-grid">
                                ${property.amenities.map(amenity => `
                                    <div class="amenity-chip">
                                        <i data-lucide="${amenity.icon || 'check'}" size="14"></i>
                                        ${amenity.name}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}

                    ${property.images && property.images.length > 0 ? `
                        <div class="detail-section">
                            <h3 class="section-title">
                                <i data-lucide="image" size="20"></i>
                                Imágenes (${property.images.length})
                            </h3>
                            <div class="images-grid">
                                ${property.images.map(img => `
                                    <div class="image-item">
                                        <img src="${img.image_url}" alt="${img.caption || 'Imagen'}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}
                `;
                
                document.getElementById('viewModalContent').innerHTML = content;
                openModal('viewModal');
                
            } catch (error) {
                console.error('Error cargando propiedad:', error);
                showToast('Error al cargar los detalles', 'error');
            }
        }

        // Editar propiedad
        async function editProperty(id) {
            try {
                const result = await api.getProperty(id);
                const property = result.data;
                currentProperty = property;
                
                const content = `
                    <div class="detail-section">
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
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="bed-double" size="20"></i>
                            Características
                        </h3>
                        <div class="detail-grid">
                            <div class="form-group">
                                <label class="form-label">Dormitorios</label>
                                <input type="number" class="form-input" value="${property.bedrooms}" id="editBedrooms">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Baños</label>
                                <input type="number" class="form-input" value="${property.bathrooms}" step="0.5" id="editBathrooms">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Huéspedes</label>
                                <input type="number" class="form-input" value="${property.max_guests}" id="editMaxGuests">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Superficie (m²)</label>
                                <input type="number" class="form-input" value="${property.surface_m2 || ''}" id="editSurface">
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title">
                            <i data-lucide="dollar-sign" size="20"></i>
                            Precios
                        </h3>
                        <div class="detail-grid">
                            <div class="form-group">
                                <label class="form-label">Precio por noche</label>
                                <input type="number" class="form-input" value="${property.price_per_night}" id="editPrice">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tarifa de limpieza</label>
                                <input type="number" class="form-input" value="${property.cleaning_fee || 0}" id="editCleaningFee">
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('editModalContent').innerHTML = content;
                openModal('editModal');
                
            } catch (error) {
                console.error('Error cargando propiedad:', error);
                showToast('Error al cargar la propiedad', 'error');
            }
        }

        // Guardar cambios
        async function savePropertyChanges() {
            if (!currentProperty) return;
            
            try {
                const updates = {
                    title: document.getElementById('editTitle').value,
                    description: document.getElementById('editDescription').value,
                    bedrooms: parseInt(document.getElementById('editBedrooms').value),
                    bathrooms: parseFloat(document.getElementById('editBathrooms').value),
                    max_guests: parseInt(document.getElementById('editMaxGuests').value),
                    surface_m2: parseInt(document.getElementById('editSurface').value) || null,
                    price_per_night: parseFloat(document.getElementById('editPrice').value),
                    cleaning_fee: parseFloat(document.getElementById('editCleaningFee').value) || 0
                };
                
                await api.updateProperty(currentProperty.id, updates);
                
                showToast('Propiedad actualizada exitosamente');
                closeModal('editModal');
                loadProperties();
                
            } catch (error) {
                console.error('Error actualizando propiedad:', error);
                showToast('Error al actualizar la propiedad', 'error');
            }
        }

        // Confirmar eliminación
        function confirmDelete(id, title) {
            currentProperty = { id, title };
            document.getElementById('confirmText').textContent = 
                `Esta acción eliminará permanentemente "${title}" y no se puede deshacer.`;
            
            confirmCallback = () => deleteProperty(id);
            openConfirm();
        }

        // Eliminar propiedad
        async function deleteProperty(id) {
            try {
                await api.deleteProperty(id);
                
                showToast('Propiedad eliminada exitosamente');
                closeConfirm();
                loadProperties();
                
            } catch (error) {
                console.error('Error eliminando propiedad:', error);
                showToast('Error al eliminar la propiedad', 'error');
            }
        }

        // Modal functions
        function openModal(modalId) {
            document.getElementById('modalOverlay').classList.add('active');
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => lucide.createIcons(), 100);
        }

        function closeModal(modalId) {
            document.getElementById('modalOverlay').classList.remove('active');
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = '';
        }

        function openConfirm() {
            document.getElementById('modalOverlay').classList.add('active');
            document.getElementById('confirmDialog').classList.add('active');
            lucide.createIcons();
        }

        function closeConfirm() {
            document.getElementById('modalOverlay').classList.remove('active');
            document.getElementById('confirmDialog').classList.remove('active');
            confirmCallback = null;
        }

        // Event listeners
        document.getElementById('modalOverlay').addEventListener('click', function() {
            closeModal('viewModal');
            closeModal('editModal');
            closeConfirm();
        });

        document.getElementById('confirmActionBtn').addEventListener('click', function() {
            if (confirmCallback) confirmCallback();
        });

        // Filtros
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                
                currentFilter = this.dataset.filter;
                loadProperties();
            });
        });

        // Búsqueda
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            currentSearch = e.target.value;
            searchTimeout = setTimeout(() => {
                loadProperties();
            }, 500);
        });

        // FAB button
        document.getElementById('addPropertyBtn').addEventListener('click', function() {
            window.location.href = 'admin-property-form.php';
        });

        // Inicializar
        loadProperties();
    </script>
</body>
</html>