<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Propiedad - RentaTurista Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Satoshi:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- Leaflet for maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    
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
            
            --font-display: 'Poppins', system-ui, sans-serif;
            --font-body: 'Satoshi', system-ui, sans-serif;
            
            --sidebar-width: 280px;
            --header-height: 70px;
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

        /* Sidebar - Same as properties page */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--white) 0%, var(--gray-50) 100%);
            border-right: 2px solid rgba(101, 67, 33, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
        }

        .sidebar-logo {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--orange-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-500);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 107, 53, 0.05);
            color: var(--orange-primary);
            border-left-color: var(--orange-primary);
        }

        .nav-item.active {
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            border-left-color: var(--orange-primary);
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Header */
        .header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 900;
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

        .header-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
        }

        /* Form Container */
        .form-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-title {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 2rem;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: var(--gray-600);
            font-size: 1.05rem;
        }

        /* Form Layout */
        .form-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        /* Form Sections */
        .form-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .section-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--gray-900);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label-required::after {
            content: '*';
            color: var(--danger);
            margin-left: 0.25rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
            font-family: var(--font-body);
        }

        .form-hint {
            display: block;
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-top: 0.375rem;
        }

        /* Grid Layouts */
        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .form-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        /* Checkbox/Switch */
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            cursor: pointer;
            accent-color: var(--orange-primary);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            transition: .4s;
            border-radius: 28px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--orange-primary);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        /* Amenities Grid */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .amenity-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .amenity-checkbox:hover {
            background: rgba(255, 107, 53, 0.05);
            border-color: var(--orange-primary);
        }

        .amenity-checkbox input:checked + label {
            color: var(--orange-primary);
            font-weight: 600;
        }

        /* Image Upload */
        .image-upload-zone {
            border: 2px dashed var(--gray-300);
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .image-upload-zone:hover {
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.02);
        }

        .upload-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--orange-primary);
        }

        .upload-text {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .upload-hint {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .images-preview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            background: var(--gray-200);
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-remove {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: var(--danger);
            color: var(--white);
            border: none;
            border-radius: 6px;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .preview-item:hover .preview-remove {
            opacity: 1;
        }

        /* Map */
        #locationMap {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Sidebar Card */
        .sidebar-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 16px;
            padding: 2rem;
            position: sticky;
            top: calc(var(--header-height) + 2rem);
        }

        .preview-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(101, 67, 33, 0.1);
        }

        .preview-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .preview-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-500);
            margin-bottom: 0.5rem;
        }

        .preview-value {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 1.1rem;
        }

        .preview-price {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 2rem;
            color: var(--orange-primary);
        }

        .preview-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .preview-status.draft {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .preview-status.active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
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
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .btn-full {
            width: 100%;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .form-layout {
                grid-template-columns: 1fr;
            }

            .sidebar-card {
                position: relative;
                top: 0;
            }

            .form-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .form-grid-2,
            .form-grid-3,
            .form-grid-4 {
                grid-template-columns: 1fr;
            }

            .images-preview {
                grid-template-columns: repeat(2, 1fr);
            }

            .amenities-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <i data-lucide="home" size="24"></i>
                </div>
                RentaTurista
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Principal</div>
                <a href="admin-properties.html" class="nav-item">
                    <i data-lucide="layout-dashboard" size="20"></i>
                    Dashboard
                </a>
                <a href="admin-properties.html" class="nav-item active">
                    <i data-lucide="building-2" size="20"></i>
                    Propiedades
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <a href="admin-properties.html" class="back-btn">
                    <i data-lucide="arrow-left" size="20"></i>
                </a>
                <h1 class="header-title">Nueva Propiedad</h1>
            </div>
        </header>

        <!-- Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">Agregar Propiedad</h2>
                <p class="form-subtitle">Completa todos los detalles de tu propiedad para comenzar a recibir reservas</p>
            </div>

            <form id="propertyForm">
                <div class="form-layout">
                    <!-- Main Form Column -->
                    <div class="form-main">
                        <!-- Basic Information -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="info" size="20"></i>
                                </div>
                                <h3 class="section-title">Información Básica</h3>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label-required" for="title">Título de la propiedad</label>
                                <input type="text" id="title" name="title" class="form-input" placeholder="ej: Casa Vista al Lago Premium" required>
                                <span class="form-hint">Este es el título principal que verán los huéspedes</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label-required" for="propertyType">Tipo de propiedad</label>
                                <select id="propertyType" name="property_type_id" class="form-select" required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="1">Casa</option>
                                    <option value="2">Departamento</option>
                                    <option value="3">Cabaña</option>
                                    <option value="4">Suite</option>
                                    <option value="5">Loft</option>
                                    <option value="6">Villa</option>
                                    <option value="7">Bungalow</option>
                                    <option value="8">Estudio</option>
                                    <option value="9">Chalet</option>
                                    <option value="10">Habitación</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label-required" for="description">Descripción</label>
                                <textarea id="description" name="description" class="form-textarea" placeholder="Describe tu propiedad en detalle..." required></textarea>
                                <span class="form-hint">Incluye detalles sobre la ubicación, comodidades y características especiales</span>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="surfaceM2">Superficie (m²)</label>
                                    <input type="number" id="surfaceM2" name="surface_m2" class="form-input" placeholder="85" min="0">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="yearBuilt">Año de construcción</label>
                                    <input type="number" id="yearBuilt" name="year_built" class="form-input" placeholder="2020" min="1900" max="2025">
                                </div>
                            </div>
                        </div>

                        <!-- Property Features -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="bed-double" size="20"></i>
                                </div>
                                <h3 class="section-title">Características de la Propiedad</h3>
                            </div>

                            <div class="form-grid-4">
                                <div class="form-group">
                                    <label class="form-label form-label-required" for="bedrooms">Dormitorios</label>
                                    <input type="number" id="bedrooms" name="bedrooms" class="form-input" placeholder="2" min="0" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label-required" for="bathrooms">Baños completos</label>
                                    <input type="number" id="bathrooms" name="bathrooms" class="form-input" placeholder="2" min="0" step="0.5" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="halfBathrooms">Baños medios</label>
                                    <input type="number" id="halfBathrooms" name="half_bathrooms" class="form-input" placeholder="0" min="0">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="garageSpaces">Cocheras</label>
                                    <input type="number" id="garageSpaces" name="garage_spaces" class="form-input" placeholder="1" min="0">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label form-label-required" for="maxGuests">Huéspedes máx.</label>
                                    <input type="number" id="maxGuests" name="max_guests" class="form-input" placeholder="6" min="1" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="floors">Cantidad de pisos</label>
                                    <input type="number" id="floors" name="floors" class="form-input" placeholder="1" min="1">
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="map-pin" size="20"></i>
                                </div>
                                <h3 class="section-title">Ubicación</h3>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label-required" for="address">Dirección</label>
                                <input type="text" id="address" name="address" class="form-input" placeholder="Av. San Martín 1245" required>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="neighborhood">Barrio/Zona</label>
                                    <input type="text" id="neighborhood" name="neighborhood" class="form-input" placeholder="Centro">
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label-required" for="city">Ciudad</label>
                                    <input type="text" id="city" name="city" class="form-input" placeholder="Villa Carlos Paz" required>
                                </div>
                            </div>

                            <div class="form-grid-3">
                                <div class="form-group">
                                    <label class="form-label form-label-required" for="state">Provincia</label>
                                    <input type="text" id="state" name="state" class="form-input" placeholder="Córdoba" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label-required" for="country">País</label>
                                    <input type="text" id="country" name="country" class="form-input" value="Argentina" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="postalCode">Código Postal</label>
                                    <input type="text" id="postalCode" name="postal_code" class="form-input" placeholder="5152">
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="latitude">Latitud</label>
                                    <input type="text" id="latitude" name="latitude" class="form-input" placeholder="-31.4135" step="any">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="longitude">Longitud</label>
                                    <input type="text" id="longitude" name="longitude" class="form-input" placeholder="-64.4945" step="any">
                                </div>
                            </div>

                            <div id="locationMap"></div>
                            <span class="form-hint">Haz clic en el mapa para establecer la ubicación exacta</span>
                        </div>

                        <!-- Pricing -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="dollar-sign" size="20"></i>
                                </div>
                                <h3 class="section-title">Precios y Tarifas</h3>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label form-label-required" for="pricePerNight">Precio por noche (ARS)</label>
                                    <input type="number" id="pricePerNight" name="price_per_night" class="form-input" placeholder="18500" min="0" step="0.01" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label-required" for="priceRange">Rango de precio</label>
                                    <select id="priceRange" name="price_range" class="form-select" required>
                                        <option value="">Seleccionar rango</option>
                                        <option value="budget">Económico ($)</option>
                                        <option value="moderate">Moderado ($$)</option>
                                        <option value="upscale">Alto ($$$)</option>
                                        <option value="luxury">Lujo ($$$$)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="cleaningFee">Tarifa de limpieza (ARS)</label>
                                    <input type="number" id="cleaningFee" name="cleaning_fee" class="form-input" placeholder="0" min="0" step="0.01">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="minimumNights">Noches mínimas</label>
                                    <input type="number" id="minimumNights" name="minimum_nights" class="form-input" placeholder="1" min="1" value="1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="maximumNights">Noches máximas (opcional)</label>
                                <input type="number" id="maximumNights" name="maximum_nights" class="form-input" placeholder="30" min="1">
                            </div>
                        </div>

                        <!-- Rules & Policies -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="shield-check" size="20"></i>
                                </div>
                                <h3 class="section-title">Reglas y Políticas</h3>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="checkInTime">Hora de check-in</label>
                                    <input type="time" id="checkInTime" name="check_in_time" class="form-input" value="15:00">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="checkOutTime">Hora de check-out</label>
                                    <input type="time" id="checkOutTime" name="check_out_time" class="form-input" value="10:00">
                                </div>
                            </div>

                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="petsAllowed" name="pets_allowed" class="checkbox-input">
                                    <label for="petsAllowed">Se permiten mascotas</label>
                                </div>

                                <div class="checkbox-item">
                                    <input type="checkbox" id="smokingAllowed" name="smoking_allowed" class="checkbox-input">
                                    <label for="smokingAllowed">Se permite fumar</label>
                                </div>

                                <div class="checkbox-item">
                                    <input type="checkbox" id="eventsAllowed" name="events_allowed" class="checkbox-input">
                                    <label for="eventsAllowed">Se permiten eventos</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cancellationPolicy">Política de cancelación</label>
                                <select id="cancellationPolicy" name="cancellation_policy" class="form-select">
                                    <option value="flexible">Flexible (reembolso hasta 24h antes)</option>
                                    <option value="moderate" selected>Moderada (reembolso hasta 5 días antes)</option>
                                    <option value="strict">Estricta (reembolso hasta 14 días antes)</option>
                                    <option value="non_refundable">No reembolsable</option>
                                </select>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="sparkles" size="20"></i>
                                </div>
                                <h3 class="section-title">Amenidades</h3>
                            </div>

                            <div class="amenities-grid" id="amenitiesGrid">
                                <!-- Amenities will be loaded here -->
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="image" size="20"></i>
                                </div>
                                <h3 class="section-title">Imágenes</h3>
                            </div>

                            <div class="image-upload-zone" id="imageUploadZone">
                                <div class="upload-icon">
                                    <i data-lucide="upload" size="32"></i>
                                </div>
                                <div class="upload-text">Arrastra imágenes aquí o haz clic para seleccionar</div>
                                <div class="upload-hint">Formatos: JPG, PNG, WebP • Tamaño máximo: 5MB por imagen</div>
                                <input type="file" id="imageInput" accept="image/*" multiple style="display: none;">
                            </div>

                            <div class="images-preview" id="imagesPreview">
                                <!-- Preview images will appear here -->
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i data-lucide="search" size="20"></i>
                                </div>
                                <h3 class="section-title">SEO (Opcional)</h3>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="metaTitle">Meta título</label>
                                <input type="text" id="metaTitle" name="meta_title" class="form-input" placeholder="Casa Vista al Lago Premium - RentaTurista | Alquiler Villa Carlos Paz">
                                <span class="form-hint">Título optimizado para motores de búsqueda (60 caracteres recomendado)</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="metaDescription">Meta descripción</label>
                                <textarea id="metaDescription" name="meta_description" class="form-textarea" rows="3" placeholder="Casa premium con vista al lago San Roque en Villa Carlos Paz..."></textarea>
                                <span class="form-hint">Descripción breve para motores de búsqueda (160 caracteres recomendado)</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="metaKeywords">Keywords</label>
                                <input type="text" id="metaKeywords" name="meta_keywords" class="form-input" placeholder="casa vista lago villa carlos paz, alquiler premium cordoba, hospedaje lago san roque">
                                <span class="form-hint">Palabras clave separadas por comas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="form-sidebar">
                        <div class="sidebar-card">
                            <div class="preview-section">
                                <div class="preview-label">Estado</div>
                                <div>
                                    <span class="preview-status draft">
                                        <i data-lucide="clock" size="16"></i>
                                        Borrador
                                    </span>
                                </div>
                            </div>

                            <div class="preview-section">
                                <div class="preview-label">Precio por noche</div>
                                <div class="preview-price" id="previewPrice">$0</div>
                            </div>

                            <div class="preview-section">
                                <div class="preview-label">Capacidad</div>
                                <div class="preview-value" id="previewCapacity">
                                    <i data-lucide="users" size="18"></i>
                                    -- huéspedes
                                </div>
                            </div>

                            <div class="preview-section">
                                <div class="preview-label">Ubicación</div>
                                <div class="preview-value" id="previewLocation">Sin especificar</div>
                            </div>

                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="featured" name="featured" class="checkbox-input">
                                    <label for="featured" style="font-weight: 600;">Destacar propiedad</label>
                                </div>

                                <div class="checkbox-item">
                                    <input type="checkbox" id="verified" name="verified" class="checkbox-input">
                                    <label for="verified" style="font-weight: 600;">Marcar como verificada</label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary btn-full">
                                    <i data-lucide="save" size="18"></i>
                                    Guardar Borrador
                                </button>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-full">
                                    <i data-lucide="check" size="18"></i>
                                    Publicar Propiedad
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sample amenities data (from database)
        const amenities = [
            { id: 1, name: 'WiFi', icon: 'wifi', category: 'basic' },
            { id: 2, name: 'Aire Acondicionado', icon: 'air-vent', category: 'basic' },
            { id: 3, name: 'Calefacción', icon: 'flame', category: 'basic' },
            { id: 4, name: 'TV', icon: 'tv', category: 'basic' },
            { id: 5, name: 'Cocina completa', icon: 'chef-hat', category: 'basic' },
            { id: 14, name: 'Vista al lago', icon: 'waves', category: 'comfort' },
            { id: 15, name: 'Vista a las sierras', icon: 'mountain', category: 'comfort' },
            { id: 21, name: 'Piscina', icon: 'waves', category: 'outdoor' },
            { id: 22, name: 'Piscina climatizada', icon: 'waves', category: 'outdoor' },
            { id: 23, name: 'Parrilla', icon: 'flame', category: 'outdoor' },
            { id: 24, name: 'Quincho', icon: 'home', category: 'outdoor' },
            { id: 27, name: 'Estacionamiento', icon: 'car', category: 'outdoor' },
            { id: 28, name: 'Cochera cubierta', icon: 'car', category: 'outdoor' }
        ];

        // Load amenities
        function loadAmenities() {
            const grid = document.getElementById('amenitiesGrid');
            grid.innerHTML = amenities.map(amenity => `
                <div class="amenity-checkbox">
                    <input type="checkbox" id="amenity_${amenity.id}" name="amenities[]" value="${amenity.id}" class="checkbox-input">
                    <i data-lucide="${amenity.icon}" size="16"></i>
                    <label for="amenity_${amenity.id}">${amenity.name}</label>
                </div>
            `).join('');
            lucide.createIcons();
        }

        loadAmenities();

        // Initialize map
        let map;
        let marker;

        function initMap() {
            map = L.map('locationMap').setView([-31.4135, -64.4945], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                
                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                
                document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
                document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
            });
        }

        setTimeout(initMap, 500);

        // Image upload
        const imageUploadZone = document.getElementById('imageUploadZone');
        const imageInput = document.getElementById('imageInput');
        const imagesPreview = document.getElementById('imagesPreview');
        let uploadedImages = [];

        imageUploadZone.addEventListener('click', () => imageInput.click());

        imageUploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            imageUploadZone.style.borderColor = 'var(--orange-primary)';
        });

        imageUploadZone.addEventListener('dragleave', () => {
            imageUploadZone.style.borderColor = 'var(--gray-300)';
        });

        imageUploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            imageUploadZone.style.borderColor = 'var(--gray-300)';
            handleFiles(e.dataTransfer.files);
        });

        imageInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        uploadedImages.push({
                            file: file,
                            url: e.target.result
                        });
                        renderImagePreviews();
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        function renderImagePreviews() {
            imagesPreview.innerHTML = uploadedImages.map((img, index) => `
                <div class="preview-item">
                    <img src="${img.url}" alt="Preview" class="preview-image">
                    <button type="button" class="preview-remove" onclick="removeImage(${index})">
                        <i data-lucide="x" size="16"></i>
                    </button>
                </div>
            `).join('');
            lucide.createIcons();
        }

        function removeImage(index) {
            uploadedImages.splice(index, 1);
            renderImagePreviews();
        }

        // Live preview updates
        const priceInput = document.getElementById('pricePerNight');
        const maxGuestsInput = document.getElementById('maxGuests');
        const cityInput = document.getElementById('city');
        const stateInput = document.getElementById('state');

        priceInput.addEventListener('input', (e) => {
            const price = parseFloat(e.target.value) || 0;
            document.getElementById('previewPrice').textContent = `$${price.toLocaleString('es-AR')}`;
        });

        maxGuestsInput.addEventListener('input', (e) => {
            const guests = parseInt(e.target.value) || 0;
            document.getElementById('previewCapacity').innerHTML = `
                <i data-lucide="users" size="18"></i>
                ${guests} huéspedes
            `;
            lucide.createIcons();
        });

        function updateLocationPreview() {
            const city = cityInput.value || '';
            const state = stateInput.value || '';
            const location = [city, state].filter(Boolean).join(', ') || 'Sin especificar';
            document.getElementById('previewLocation').textContent = location;
        }

        cityInput.addEventListener('input', updateLocationPreview);
        stateInput.addEventListener('input', updateLocationPreview);

        // Form submission - FUNCTIONAL VERSION
        document.getElementById('propertyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'customLoading';
            loadingDiv.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.9);display:flex;align-items:center;justify-content:center;z-index:9999;';
            loadingDiv.innerHTML = '<div style="text-align:center;"><div style="width:50px;height:50px;border:4px solid #f3f3f3;border-top:4px solid #FF6B35;border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 1rem;"></div><p style="color:#FF6B35;font-weight:600;">Guardando propiedad...</p></div><style>@keyframes spin{to{transform:rotate(360deg)}}</style>';
            document.body.appendChild(loadingDiv);
            
            try {
                const propertyData = {
                    property_type_id: parseInt(document.getElementById('propertyType').value),
                    title: document.getElementById('title').value,
                    description: document.getElementById('description').value,
                    address: document.getElementById('address').value || '',
                    neighborhood: document.getElementById('neighborhood').value || null,
                    city: document.getElementById('city').value,
                    state: document.getElementById('state').value,
                    country: document.getElementById('country').value,
                    latitude: parseFloat(document.getElementById('latitude').value) || null,
                    longitude: parseFloat(document.getElementById('longitude').value) || null,
                    bedrooms: parseInt(document.getElementById('bedrooms').value),
                    bathrooms: parseFloat(document.getElementById('bathrooms').value),
                    max_guests: parseInt(document.getElementById('maxGuests').value),
                    price_per_night: parseFloat(document.getElementById('pricePerNight').value),
                    cleaning_fee: parseFloat(document.getElementById('cleaningFee')?.value) || 0,
                    minimum_nights: parseInt(document.getElementById('minimumNights')?.value) || 1,
                    status: 'active',
                    amenities: []
                };
                
                document.querySelectorAll('input[name="amenities[]"]:checked').forEach(checkbox => {
                    propertyData.amenities.push({
                        name: checkbox.closest('label')?.textContent.trim() || checkbox.value,
                        value: null
                    });
                });
                
                console.log('📤 Sending:', propertyData);
                
                const response = await fetch('/rentaturista/api/properties', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(propertyData)
                });
                
                const result = await response.json();
                console.log('📥 Response:', result);
                
                if (!result.success) throw new Error(result.error || 'Error al crear');
                
                const propertyId = result.data.id;
                console.log('✅ ID:', propertyId);
                
                if (uploadedImages && uploadedImages.length > 0) {
                    for (let i = 0; i < uploadedImages.length; i++) {
                        const fd = new FormData();
                        fd.append('images', uploadedImages[i].file);
                        fd.append('is_primary', i === 0 ? '1' : '0');
                        fd.append('sort_order', i);
                        await fetch(`/rentaturista/api/properties/${propertyId}/images`, {
                            method: 'POST',
                            body: fd
                        });
                    }
                }
                
                document.body.removeChild(loadingDiv);
                alert('✅ ¡Propiedad creada!');
                window.location.href = 'admin-properties.php';
                
            } catch (error) {
                console.error('❌', error);
                const loading = document.getElementById('customLoading');
                if (loading) document.body.removeChild(loading);
                alert('❌ Error: ' + error.message);
            }
        });
    </script>
</body>
</html>