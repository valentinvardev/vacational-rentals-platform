<?php
/**
 * RentaTurista - Admin Places Management
 * Admin panel for managing places of interest and activities
 */

// Check if user is authenticated (add your auth logic here)
// session_start();
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: /admin/login.php');
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Lugares - RentaTurista Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Satoshi:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Leaflet for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
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
        }

        /* Header */
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            border-radius: 12px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-btn:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        .page-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--gray-900);
        }

        .header-right button {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-right button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--orange-glow);
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Filter Bar */
        .filter-bar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-chips {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            flex: 1;
        }

        .filter-chip {
            padding: 0.625rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 20px;
            background: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-chip:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }

        .filter-chip.active {
            background: var(--orange-primary);
            color: var(--white);
            border-color: var(--orange-primary);
        }

        /* Places Grid */
        .places-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .place-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .place-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            border-color: var(--orange-primary);
        }

        .place-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .place-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .place-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .place-badge.restaurant { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .place-badge.bar { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
        .place-badge.nightlife { background: rgba(139, 92, 246, 0.1); color: #8B5CF6; }
        .place-badge.attraction { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .place-badge.beach { background: rgba(6, 182, 212, 0.1); color: #06B6D4; }
        .place-badge.hiking { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .place-badge.shopping { background: rgba(236, 72, 153, 0.1); color: #EC4899; }
        .place-badge.service { background: rgba(168, 85, 247, 0.1); color: #A855F7; }
        .place-badge.transport { background: rgba(20, 184, 166, 0.1); color: #14B8A6; }
        .place-badge.other { background: rgba(107, 114, 128, 0.1); color: #6B7280; }

        .place-name {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .place-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .place-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .place-meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .place-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .place-actions button {
            flex: 1;
            padding: 0.5rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            font-size: 0.85rem;
        }

        .btn-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .btn-edit:hover {
            background: rgba(59, 130, 246, 0.2);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            margin: 2rem 0;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--gray-900);
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-600);
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            color: var(--gray-900);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: var(--font-body);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        #placeMap {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            margin-top: 0.5rem;
            border: 2px solid var(--gray-300);
        }

        .map-help-text {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary {
            flex: 1;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--orange-glow);
        }

        .btn-secondary {
            flex: 1;
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 53, 0.2);
        }

        .price-selector {
            display: flex;
            gap: 0.5rem;
        }

        .price-option {
            flex: 1;
            text-align: center;
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            background: var(--white);
        }

        .price-option:hover {
            border-color: var(--orange-primary);
        }

        .price-option.active {
            background: var(--orange-primary);
            color: var(--white);
            border-color: var(--orange-primary);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-state i {
            margin-bottom: 1rem;
            color: var(--gray-400);
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--gray-600);
        }

        /* Loading State */
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem;
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

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--gray-900);
            color: var(--white);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 9999;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast.success {
            background: var(--success);
        }

        .toast.error {
            background: var(--danger);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-container">
            <div class="header-left">
                <a href="/admin" class="back-btn">
                    <i data-lucide="arrow-left" size="20"></i>
                </a>
                <h1 class="page-title">Gestión de Lugares de Interés</h1>
            </div>
            <div class="header-right">
                <button onclick="openAddModal()">
                    <i data-lucide="plus" size="18"></i>
                    Agregar Lugar
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="filter-chips">
                <div class="filter-chip active" data-category="all" onclick="filterPlaces('all')">
                    <i data-lucide="map" size="16"></i>
                    Todos
                </div>
                <div class="filter-chip" data-category="restaurant" onclick="filterPlaces('restaurant')">
                    <i data-lucide="utensils" size="16"></i>
                    Restaurantes
                </div>
                <div class="filter-chip" data-category="bar" onclick="filterPlaces('bar')">
                    <i data-lucide="beer" size="16"></i>
                    Bares
                </div>
                <div class="filter-chip" data-category="nightlife" onclick="filterPlaces('nightlife')">
                    <i data-lucide="music" size="16"></i>
                    Vida Nocturna
                </div>
                <div class="filter-chip" data-category="attraction" onclick="filterPlaces('attraction')">
                    <i data-lucide="map-pin" size="16"></i>
                    Atracciones
                </div>
                <div class="filter-chip" data-category="beach" onclick="filterPlaces('beach')">
                    <i data-lucide="waves" size="16"></i>
                    Playas
                </div>
                <div class="filter-chip" data-category="hiking" onclick="filterPlaces('hiking')">
                    <i data-lucide="mountain" size="16"></i>
                    Trekking
                </div>
                <div class="filter-chip" data-category="shopping" onclick="filterPlaces('shopping')">
                    <i data-lucide="shopping-bag" size="16"></i>
                    Compras
                </div>
            </div>
        </div>

        <!-- Places Grid -->
        <div class="places-grid" id="placesGrid">
            <div class="loading">
                <div class="spinner"></div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Modal -->
    <div class="modal" id="placeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Agregar Lugar</h3>
                <button class="modal-close" onclick="closeModal()">
                    <i data-lucide="x" size="24"></i>
                </button>
            </div>

            <form id="placeForm" onsubmit="savePlace(event)">
                <input type="hidden" id="placeId">
                
                <div class="form-group">
                    <label class="form-label">Nombre del Lugar *</label>
                    <input type="text" class="form-input" id="placeName" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Categoría *</label>
                        <select class="form-select" id="placeCategory" required>
                            <option value="restaurant">Restaurante</option>
                            <option value="bar">Bar</option>
                            <option value="nightlife">Vida Nocturna</option>
                            <option value="attraction">Atracción</option>
                            <option value="beach">Playa</option>
                            <option value="hiking">Trekking</option>
                            <option value="shopping">Compras</option>
                            <option value="service">Servicio</option>
                            <option value="transport">Transporte</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Icono (Lucide)</label>
                        <input type="text" class="form-input" id="placeIcon" placeholder="map-pin" value="map-pin">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-textarea" id="placeDescription"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-input" id="placeAddress">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-input" id="placePhone" placeholder="3541-123456">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sitio Web</label>
                        <input type="url" class="form-input" id="placeWebsite" placeholder="https://...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Rango de Precio</label>
                    <div class="price-selector">
                        <div class="price-option" data-price="1" onclick="selectPrice(1)">$</div>
                        <div class="price-option" data-price="2" onclick="selectPrice(2)">$$</div>
                        <div class="price-option" data-price="3" onclick="selectPrice(3)">$$$</div>
                        <div class="price-option" data-price="4" onclick="selectPrice(4)">$$$$</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ubicación en el Mapa</label>
                    <p class="map-help-text">
                        <i data-lucide="info" size="14"></i>
                        Haz clic en el mapa para marcar la ubicación
                    </p>
                    <div id="placeMap"></div>
                    <input type="hidden" id="placeLatitude">
                    <input type="hidden" id="placeLongitude">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" id="placeFeatured" style="width: auto;">
                        <span class="form-label" style="margin: 0;">Destacar este lugar</span>
                    </label>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="check" size="18"></i>
                        <span>Guardar</span>
                    </button>
                    <button type="button" class="btn-secondary" onclick="closeModal()">
                        <i data-lucide="x" size="18"></i>
                        <span>Cancelar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i data-lucide="check-circle" size="20"></i>
        <span id="toastMessage">Operación exitosa</span>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        const API_URL = './api/places';
        let map;
        let marker;
        let currentPlaceId = null;
        let selectedPrice = null;
        let currentCategory = 'all';

        // Category configuration
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

        // Load places on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPlaces();
        });

        // Load places from API
        async function loadPlaces(category = 'all') {
            currentCategory = category;
            
            try {
                const url = category === 'all' 
                    ? `${API_URL}` 
                    : `${API_URL}?category=${category}`;
                
                const response = await fetch(url);
                const data = await response.json();
                
                const grid = document.getElementById('placesGrid');
                
                if (!data.success || data.data.length === 0) {
                    grid.innerHTML = `
                        <div class="empty-state">
                            <i data-lucide="map-pin" size="64"></i>
                            <h3>No hay lugares registrados</h3>
                            <p>Agrega tu primer lugar de interés</p>
                        </div>
                    `;
                    lucide.createIcons();
                    return;
                }
                
                grid.innerHTML = data.data.map(place => {
                    const categoryInfo = categoryConfig[place.category] || categoryConfig.other;
                    return `
                        <div class="place-card">
                            <div class="place-header">
                                <div class="place-icon">
                                    <i data-lucide="${place.icon || categoryInfo.icon}" size="24"></i>
                                </div>
                                <div class="place-badge ${place.category}">${categoryInfo.label}</div>
                            </div>
                            <h3 class="place-name">${place.name}</h3>
                            ${place.description ? `<p class="place-description">${place.description}</p>` : ''}
                            <div class="place-meta">
                                ${place.address ? `
                                    <div class="place-meta-item">
                                        <i data-lucide="map-pin" size="14"></i>
                                        ${truncate(place.address, 30)}
                                    </div>
                                ` : ''}
                                ${place.price_range ? `
                                    <div class="place-meta-item">
                                        <i data-lucide="dollar-sign" size="14"></i>
                                        ${'$'.repeat(place.price_range)}
                                    </div>
                                ` : ''}
                                ${place.phone ? `
                                    <div class="place-meta-item">
                                        <i data-lucide="phone" size="14"></i>
                                        ${place.phone}
                                    </div>
                                ` : ''}
                            </div>
                            <div class="place-actions">
                                <button class="btn-edit" onclick="editPlace(${place.id})">
                                    <i data-lucide="edit" size="16"></i>
                                    Editar
                                </button>
                                <button class="btn-delete" onclick="deletePlace(${place.id}, '${escapeHtml(place.name)}')">
                                    <i data-lucide="trash-2" size="16"></i>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');
                
                lucide.createIcons();
            } catch (error) {
                console.error('Error loading places:', error);
                showToast('Error al cargar los lugares', 'error');
            }
        }

        // Filter places by category
        function filterPlaces(category) {
            // Update active chip
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.classList.toggle('active', chip.dataset.category === category);
            });
            
            loadPlaces(category);
        }

        // Utility functions
        function truncate(text, length) {
            if (!text || text.length <= length) return text;
            return text.substring(0, length) + '...';
        }

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

        // Initialize map
        function initMap() {
            map = L.map('placeMap').setView([-31.4135, -64.4945], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                
                document.getElementById('placeLatitude').value = e.latlng.lat.toFixed(8);
                document.getElementById('placeLongitude').value = e.latlng.lng.toFixed(8);
            });
        }

        // Modal functions
        function openAddModal() {
            currentPlaceId = null;
            document.getElementById('modalTitle').textContent = 'Agregar Lugar';
            document.getElementById('placeForm').reset();
            document.getElementById('placeId').value = '';
            document.getElementById('placeIcon').value = 'map-pin';
            selectedPrice = null;
            document.querySelectorAll('.price-option').forEach(opt => opt.classList.remove('active'));
            
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            
            document.getElementById('placeModal').classList.add('active');
            
            setTimeout(() => {
                if (!map) {
                    initMap();
                } else {
                    map.invalidateSize();
                }
                lucide.createIcons();
            }, 100);
        }

        async function editPlace(id) {
            try {
                const response = await fetch(`${API_URL}/${id}`);
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error('Error al cargar el lugar');
                }
                
                const place = result.data;
                
                currentPlaceId = id;
                document.getElementById('modalTitle').textContent = 'Editar Lugar';
                document.getElementById('placeId').value = id;
                
                document.getElementById('placeName').value = place.name;
                document.getElementById('placeCategory').value = place.category;
                document.getElementById('placeIcon').value = place.icon || 'map-pin';
                document.getElementById('placeDescription').value = place.description || '';
                document.getElementById('placeAddress').value = place.address || '';
                document.getElementById('placePhone').value = place.phone || '';
                document.getElementById('placeWebsite').value = place.website || '';
                document.getElementById('placeFeatured').checked = place.is_featured == 1;
                
                if (place.price_range) {
                    selectPrice(place.price_range);
                }
                
                document.getElementById('placeModal').classList.add('active');
                
                setTimeout(() => {
                    if (!map) {
                        initMap();
                    } else {
                        map.invalidateSize();
                    }
                    
                    if (place.latitude && place.longitude) {
                        const lat = parseFloat(place.latitude);
                        const lng = parseFloat(place.longitude);
                        
                        map.setView([lat, lng], 15);
                        
                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker([lat, lng]).addTo(map);
                        
                        document.getElementById('placeLatitude').value = lat;
                        document.getElementById('placeLongitude').value = lng;
                    }
                    
                    lucide.createIcons();
                }, 100);
            } catch (error) {
                console.error('Error loading place:', error);
                showToast('Error al cargar el lugar', 'error');
            }
        }

        function closeModal() {
            document.getElementById('placeModal').classList.remove('active');
        }

        function selectPrice(price) {
            selectedPrice = price;
            document.querySelectorAll('.price-option').forEach(opt => {
                opt.classList.toggle('active', parseInt(opt.dataset.price) === price);
            });
        }

        // Form submission
        async function savePlace(event) {
            event.preventDefault();
            
            const placeData = {
                name: document.getElementById('placeName').value,
                category: document.getElementById('placeCategory').value,
                icon: document.getElementById('placeIcon').value || 'map-pin',
                description: document.getElementById('placeDescription').value,
                address: document.getElementById('placeAddress').value,
                phone: document.getElementById('placePhone').value,
                website: document.getElementById('placeWebsite').value,
                latitude: document.getElementById('placeLatitude').value,
                longitude: document.getElementById('placeLongitude').value,
                price_range: selectedPrice,
                is_featured: document.getElementById('placeFeatured').checked ? 1 : 0
            };
            
            try {
                const placeId = document.getElementById('placeId').value;
                let response;
                
                if (placeId) {
                    // Update existing place
                    response = await fetch(`${API_URL}/${placeId}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(placeData)
                    });
                } else {
                    // Create new place
                    response = await fetch(`${API_URL}`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(placeData)
                    });
                }
                
                const result = await response.json();
                
                if (result.success) {
                    closeModal();
                    loadPlaces(currentCategory);
                    showToast(placeId ? 'Lugar actualizado exitosamente' : 'Lugar agregado exitosamente', 'success');
                } else {
                    throw new Error(result.error || 'Error al guardar');
                }
            } catch (error) {
                console.error('Error saving place:', error);
                showToast('Error al guardar el lugar', 'error');
            }
        }

        async function deletePlace(id, name) {
            if (!confirm(`¿Eliminar "${name}"? Esta acción no se puede deshacer.`)) {
                return;
            }
            
            try {
                const response = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE'
                });
                
                const result = await response.json();
                
                if (result.success) {
                    loadPlaces(currentCategory);
                    showToast('Lugar eliminado exitosamente', 'success');
                } else {
                    throw new Error(result.error || 'Error al eliminar');
                }
            } catch (error) {
                console.error('Error deleting place:', error);
                showToast('Error al eliminar el lugar', 'error');
            }
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const icon = toast.querySelector('i');
            
            toastMessage.textContent = message;
            toast.className = `toast ${type}`;
            
            // Change icon based on type
            if (type === 'error') {
                icon.setAttribute('data-lucide', 'x-circle');
            } else {
                icon.setAttribute('data-lucide', 'check-circle');
            }
            
            lucide.createIcons();
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>