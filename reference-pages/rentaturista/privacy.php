<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Política de Privacidad | RentaTurista</title>
    <meta name="description" content="Política de privacidad de RentaTurista - Cómo recopilamos, usamos y protegemos tu información personal">
    
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            --font-primary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
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
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--orange-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            border: 1px solid var(--gray-300);
        }

        .back-link:hover {
            color: var(--orange-primary);
            border-color: var(--orange-primary);
            background: rgba(255, 107, 53, 0.05);
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            padding: 4rem 0 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="1.5" fill="%23fff" opacity="0.1"/></svg>') repeat;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-description {
            font-size: 1.125rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }

        .hero-meta {
            display: flex;
            gap: 2rem;
            justify-content: center;
            align-items: center;
            font-size: 0.9375rem;
            opacity: 0.9;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .hero-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Quick Nav */
        .quick-nav {
            background: var(--gray-50);
            padding: 2rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .quick-nav h3 {
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .quick-nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .quick-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.25rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            transition: var(--transition);
        }

        .quick-nav-link:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .quick-nav-link i {
            color: var(--orange-primary);
        }

        /* Content */
        .content {
            padding: 4rem 0;
        }

        .intro-section {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.05) 0%, rgba(255, 107, 53, 0.02) 100%);
            padding: 2.5rem;
            border-radius: 16px;
            margin-bottom: 4rem;
            border-left: 4px solid var(--orange-primary);
        }

        .intro-section h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .intro-section p {
            font-size: 1.0625rem;
            line-height: 1.8;
            color: var(--gray-700);
            margin-bottom: 1rem;
        }

        .intro-section p:last-child {
            margin-bottom: 0;
        }

        .article {
            margin-bottom: 4rem;
            scroll-margin-top: 100px;
        }

        .article h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .article h2 i {
            color: var(--orange-primary);
        }

        .article h3 {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .article h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-700);
            margin: 1.5rem 0 0.75rem;
        }

        .article p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
            color: var(--gray-700);
        }

        .article ul, .article ol {
            margin: 1.25rem 0 1.5rem 1.5rem;
            line-height: 1.8;
        }

        .article li {
            margin-bottom: 0.875rem;
            color: var(--gray-700);
        }

        .article li::marker {
            color: var(--orange-primary);
        }

        .article strong {
            color: var(--gray-900);
            font-weight: 600;
        }

        /* Highlight Boxes */
        .highlight-box {
            background: rgba(255, 107, 53, 0.05);
            border-left: 4px solid var(--orange-primary);
            padding: 1.75rem;
            margin: 2rem 0;
            border-radius: 8px;
        }

        .highlight-box h4 {
            margin-top: 0;
            color: var(--orange-primary);
            font-size: 1.125rem;
            margin-bottom: 0.75rem;
        }

        .highlight-box p {
            margin-bottom: 0.75rem;
        }

        .highlight-box p:last-child {
            margin-bottom: 0;
        }

        .highlight-box ul {
            margin-top: 0.75rem;
        }

        /* Info Boxes */
        .info-box {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            padding: 1.75rem;
            margin: 2rem 0;
            border-radius: 12px;
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
        }

        .info-box i {
            color: var(--orange-primary);
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .info-box-content p {
            margin-bottom: 0.75rem;
        }

        .info-box-content p:last-child {
            margin-bottom: 0;
        }

        .info-box-content strong {
            color: var(--gray-900);
        }

        /* Warning Box */
        .warning-box {
            background: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 1.75rem;
            margin: 2rem 0;
            border-radius: 8px;
        }

        .warning-box h4 {
            color: #92400E;
            margin-top: 0;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .warning-box p {
            color: #78350F;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .data-table th {
            background: var(--gray-100);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-900);
            border-bottom: 2px solid var(--gray-200);
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-700);
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover {
            background: var(--gray-50);
        }

        /* Contact CTA */
        .contact-cta {
            background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-dark) 100%);
            color: var(--white);
            padding: 3rem;
            border-radius: 16px;
            text-align: center;
            margin: 4rem 0;
        }

        .contact-cta h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .contact-cta p {
            font-size: 1.0625rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        .contact-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .contact-btn-primary {
            background: var(--white);
            color: var(--orange-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .contact-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .contact-btn-secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .contact-btn-secondary:hover {
            background: var(--white);
            color: var(--orange-primary);
        }

        /* Footer */
        .footer {
            background: var(--gray-900);
            color: rgba(255, 255, 255, 0.8);
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9375rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--orange-primary);
        }

        .footer p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: var(--orange-primary);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0;
            pointer-events: none;
            box-shadow: var(--shadow-lg);
            z-index: 99;
        }

        .back-to-top.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .back-to-top:hover {
            background: var(--orange-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(255, 107, 53, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
                padding: 0 1.5rem;
            }

            .hero {
                padding: 3rem 0 2rem;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-meta {
                flex-direction: column;
                gap: 0.75rem;
            }

            .quick-nav-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 3rem 0;
            }

            .intro-section {
                padding: 1.75rem;
            }

            .article h2 {
                font-size: 1.5rem;
            }

            .article h3 {
                font-size: 1.25rem;
            }

            .contact-cta {
                padding: 2rem 1.5rem;
            }

            .contact-buttons {
                flex-direction: column;
            }

            .contact-btn {
                width: 100%;
                justify-content: center;
            }

            .data-table {
                font-size: 0.875rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }

            .back-to-top {
                bottom: 1.5rem;
                right: 1.5rem;
                width: 45px;
                height: 45px;
            }
        }

        @media print {
            .header,
            .quick-nav,
            .contact-cta,
            .footer,
            .back-to-top {
                display: none;
            }

            .hero {
                background: none;
                color: var(--gray-900);
            }

            body {
                font-size: 12pt;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">
                <i data-lucide="home" size="24"></i>
                RentaTurista
            </a>
            <a href="index.php" class="back-link">
                <i data-lucide="arrow-left" size="18"></i>
                Volver al inicio
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-icon">
                <i data-lucide="shield-check" size="40"></i>
            </div>
            <h1>Política de Privacidad</h1>
            <p class="hero-description">
                En RentaTurista valoramos y respetamos tu privacidad. Esta política explica cómo recopilamos, 
                usamos, almacenamos y protegemos tu información personal.
            </p>
            <div class="hero-meta">
                <div class="hero-meta-item">
                    <i data-lucide="calendar" size="18"></i>
                    <span>Última actualización: 30 de diciembre de 2024</span>
                </div>
                <div class="hero-meta-item">
                    <i data-lucide="file-check" size="18"></i>
                    <span>Conforme a Ley 25.326 (Argentina)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Navigation -->
    <section class="quick-nav">
        <div class="container">
            <h3>Acceso rápido</h3>
            <div class="quick-nav-grid">
                <a href="#informacion-recopilada" class="quick-nav-link">
                    <i data-lucide="database" size="20"></i>
                    <span>Información que Recopilamos</span>
                </a>
                <a href="#uso-informacion" class="quick-nav-link">
                    <i data-lucide="settings" size="20"></i>
                    <span>Cómo Usamos tu Información</span>
                </a>
                <a href="#compartir-informacion" class="quick-nav-link">
                    <i data-lucide="share-2" size="20"></i>
                    <span>Compartir Información</span>
                </a>
                <a href="#proteccion-datos" class="quick-nav-link">
                    <i data-lucide="lock" size="20"></i>
                    <span>Protección de Datos</span>
                </a>
                <a href="#tus-derechos" class="quick-nav-link">
                    <i data-lucide="user-check" size="20"></i>
                    <span>Tus Derechos</span>
                </a>
                <a href="#cookies" class="quick-nav-link">
                    <i data-lucide="cookie" size="20"></i>
                    <span>Cookies</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Content -->
    <main class="content">
        <div class="container">
            <!-- Introduction -->
            <div class="intro-section">
                <h2>
                    <i data-lucide="info" size="24"></i>
                    Introducción
                </h2>
                <p>
                    RentaTurista ("nosotros", "nuestro" o "la plataforma") es una plataforma intermediaria 
                    de alquileres vacacionales que opera en Villa Carlos Paz, Córdoba, Argentina. Esta 
                    Política de Privacidad describe cómo recopilamos, usamos, compartimos y protegemos 
                    tu información personal cuando utilizas nuestros servicios.
                </p>
                <p>
                    Al utilizar RentaTurista, aceptas las prácticas descritas en esta política. Si no 
                    estás de acuerdo con esta política, por favor no uses nuestros servicios.
                </p>
                <p>
                    <strong>Responsable del tratamiento de datos:</strong><br>
                    RentaTurista<br>
                    Villa Carlos Paz, Córdoba, Argentina<br>
                    Email: privacidad@rentaturista.com
                </p>
            </div>

            <!-- 1. Información que Recopilamos -->
            <article class="article" id="informacion-recopilada">
                <h2>
                    <i data-lucide="database" size="28"></i>
                    1. Información que Recopilamos
                </h2>
                
                <h3>1.1. Información Personal que nos Proporcionas</h3>
                <p>Recopilamos información cuando te registras, creas una cuenta, realizas una reserva o te comunicas con nosotros:</p>
                
                <h4>Datos de Identificación</h4>
                <ul>
                    <li><strong>Nombre completo</strong></li>
                    <li><strong>Documento de identidad:</strong> DNI, pasaporte u otro documento oficial</li>
                    <li><strong>Fecha de nacimiento</strong></li>
                    <li><strong>Nacionalidad</strong></li>
                    <li><strong>Fotografía de perfil</strong> (opcional)</li>
                </ul>

                <h4>Datos de Contacto</h4>
                <ul>
                    <li><strong>Dirección de correo electrónico</strong></li>
                    <li><strong>Número de teléfono</strong> (incluyendo código de país)</li>
                    <li><strong>Dirección postal</strong></li>
                    <li><strong>Cuenta de WhatsApp</strong></li>
                </ul>

                <h4>Información de Pago</h4>
                <ul>
                    <li><strong>Datos de tarjetas de crédito/débito:</strong> Los últimos 4 dígitos y fecha de vencimiento (los datos completos son procesados de forma segura por nuestros proveedores de pago certificados PCI-DSS)</li>
                    <li><strong>Información bancaria:</strong> CBU/CVU para transferencias</li>
                    <li><strong>Billetera de criptomonedas:</strong> Dirección pública (si aplica)</li>
                    <li><strong>Historial de transacciones</strong></li>
                </ul>

                <h4>Información de Reservas y Preferencias</h4>
                <ul>
                    <li><strong>Detalles de reservas:</strong> Fechas, destinos, número de huéspedes</li>
                    <li><strong>Preferencias de viaje:</strong> Tipo de alojamiento, amenidades preferidas</li>
                    <li><strong>Necesidades especiales:</strong> Accesibilidad, alergias, restricciones dietéticas</li>
                    <li><strong>Comunicaciones:</strong> Mensajes con propietarios y soporte</li>
                </ul>

                <h4>Información para Propietarios</h4>
                <p>Si publicas una propiedad, también recopilamos:</p>
                <ul>
                    <li><strong>Datos de la propiedad:</strong> Dirección completa, descripción, fotos</li>
                    <li><strong>Documentación legal:</strong> Título de propiedad, habilitaciones turísticas</li>
                    <li><strong>Información fiscal:</strong> CUIT/CUIL, condición ante IVA</li>
                    <li><strong>Datos bancarios:</strong> Cuenta para recibir pagos</li>
                    <li><strong>Calendario de disponibilidad</strong></li>
                </ul>

                <h3>1.2. Información Recopilada Automáticamente</h3>
                <p>Cuando usas RentaTurista, recopilamos automáticamente cierta información:</p>

                <h4>Datos de Uso de la Plataforma</h4>
                <ul>
                    <li><strong>Páginas visitadas</strong> y tiempo de permanencia</li>
                    <li><strong>Búsquedas realizadas:</strong> Términos, filtros, ubicaciones</li>
                    <li><strong>Propiedades vistas</strong> y guardadas en favoritos</li>
                    <li><strong>Clics y acciones</strong> realizadas en la plataforma</li>
                    <li><strong>Fecha y hora</strong> de cada visita</li>
                </ul>

                <h4>Información del Dispositivo</h4>
                <ul>
                    <li><strong>Tipo de dispositivo:</strong> Móvil, tablet, computadora</li>
                    <li><strong>Sistema operativo:</strong> iOS, Android, Windows, macOS</li>
                    <li><strong>Navegador web:</strong> Chrome, Safari, Firefox, etc.</li>
                    <li><strong>Dirección IP</strong></li>
                    <li><strong>Configuración regional:</strong> Zona horaria, idioma preferido</li>
                    <li><strong>Identificadores únicos:</strong> ID de dispositivo, ID de publicidad</li>
                </ul>

                <h4>Datos de Ubicación</h4>
                <p>Con tu consentimiento, podemos recopilar:</p>
                <ul>
                    <li><strong>Ubicación precisa:</strong> Mediante GPS, cuando usas la función de mapa</li>
                    <li><strong>Ubicación aproximada:</strong> Basada en dirección IP</li>
                    <li><strong>Ubicación proporcionada:</strong> Cuando buscas propiedades en un área específica</li>
                </ul>

                <div class="info-box">
                    <i data-lucide="info" size="24"></i>
                    <div class="info-box-content">
                        <p><strong>Nota sobre Ubicación:</strong> Puedes controlar el acceso a tu ubicación en la configuración de tu dispositivo. Deshabilitar la ubicación puede limitar algunas funcionalidades como búsqueda cercana y mapas interactivos.</p>
                    </div>
                </div>

                <h3>1.3. Información de Terceros</h3>
                <p>También recibimos información de fuentes externas:</p>

                <h4>Redes Sociales</h4>
                <p>Si eliges registrarte o iniciar sesión usando una red social (Facebook, Google):</p>
                <ul>
                    <li><strong>Información de perfil público:</strong> Nombre, foto, email</li>
                    <li><strong>Lista de amigos</strong> (si autorizas)</li>
                    <li><strong>Información demográfica</strong></li>
                </ul>

                <h4>Servicios de Verificación</h4>
                <ul>
                    <li><strong>Verificación de identidad:</strong> Confirmación de datos de documentos</li>
                    <li><strong>Prevención de fraude:</strong> Información de scoring crediticio</li>
                    <li><strong>Validación de direcciones</strong></li>
                </ul>

                <h4>Socios Comerciales</h4>
                <ul>
                    <li><strong>Agencias de viaje:</strong> Si reservas a través de un socio</li>
                    <li><strong>Programas de fidelización:</strong> Si vinculas programas de puntos</li>
                </ul>

                <h4>Información Pública</h4>
                <ul>
                    <li><strong>Registros públicos:</strong> Para verificar propiedad de inmuebles</li>
                    <li><strong>Directorios comerciales:</strong> Para negocios que publican propiedades</li>
                </ul>
            </article>

            <!-- 2. Cómo Usamos tu Información -->
            <article class="article" id="uso-informacion">
                <h2>
                    <i data-lucide="settings" size="28"></i>
                    2. Cómo Usamos tu Información
                </h2>

                <p>Utilizamos la información recopilada para proporcionar, mantener, mejorar y proteger nuestros servicios:</p>

                <h3>2.1. Prestación de Servicios Principales</h3>
                <ul>
                    <li><strong>Facilitar reservas:</strong> Procesar y gestionar reservas entre huéspedes y propietarios</li>
                    <li><strong>Comunicación:</strong> Conectar huéspedes con propietarios, enviar confirmaciones y actualizaciones</li>
                    <li><strong>Pagos:</strong> Procesar transacciones de forma segura</li>
                    <li><strong>Asistencia al cliente:</strong> Proporcionar soporte 24/7 por WhatsApp, email y otros canales</li>
                    <li><strong>Resolución de disputas:</strong> Mediar y resolver conflictos entre usuarios</li>
                    <li><strong>Cumplimiento de contratos:</strong> Ejecutar los términos acordados en reservas</li>
                </ul>

                <h3>2.2. Verificación y Seguridad</h3>
                <ul>
                    <li><strong>Verificación de identidad:</strong> Confirmar que eres quien dices ser</li>
                    <li><strong>Prevención de fraude:</strong> Detectar y prevenir actividades fraudulentas, abusos y uso no autorizado</li>
                    <li><strong>Seguridad de la plataforma:</strong> Proteger contra ataques cibernéticos, spam y malware</li>
                    <li><strong>Cumplimiento legal:</strong> Verificar que las propiedades cumplan regulaciones locales</li>
                    <li><strong>Revisión de antecedentes:</strong> Para garantizar la seguridad de nuestra comunidad</li>
                </ul>

                <h3>2.3. Personalización y Mejora del Servicio</h3>
                <ul>
                    <li><strong>Experiencia personalizada:</strong> Adaptar búsquedas, recomendaciones y contenido a tus preferencias</li>
                    <li><strong>IA turística:</strong> Entrenar nuestro asistente de IA con conocimiento local de Villa Carlos Paz</li>
                    <li><strong>Análisis de uso:</strong> Entender cómo los usuarios interactúan con la plataforma</li>
                    <li><strong>Mejora continua:</strong> Desarrollar nuevas características y funcionalidades</li>
                    <li><strong>Optimización:</strong> Mejorar velocidad, rendimiento y experiencia de usuario</li>
                    <li><strong>Pruebas A/B:</strong> Evaluar diferentes versiones de funcionalidades</li>
                </ul>

                <h3>2.4. Comunicación y Marketing</h3>
                <p>Con tu consentimiento, usamos tu información para:</p>
                <ul>
                    <li><strong>Comunicaciones transaccionales:</strong> Confirmaciones, recordatorios, actualizaciones de reservas (necesarias para el servicio)</li>
                    <li><strong>Notificaciones importantes:</strong> Cambios en políticas, términos de servicio, alertas de seguridad</li>
                    <li><strong>Newsletters:</strong> Consejos de viaje, guías de Villa Carlos Paz, novedades de la plataforma</li>
                    <li><strong>Promociones:</strong> Ofertas especiales, descuentos, recomendaciones de propiedades</li>
                    <li><strong>Encuestas:</strong> Solicitudes de feedback para mejorar el servicio</li>
                    <li><strong>Publicidad personalizada:</strong> Anuncios relevantes basados en tus intereses</li>
                </ul>

                <div class="highlight-box">
                    <h4>Control de Comunicaciones de Marketing</h4>
                    <p>Puedes darte de baja de comunicaciones de marketing en cualquier momento:</p>
                    <ul>
                        <li>Haciendo clic en "Cancelar suscripción" en cualquier email</li>
                        <li>Ajustando tus preferencias en "Configuración de cuenta"</li>
                        <li>Contactando a privacidad@rentaturista.com</li>
                    </ul>
                    <p><strong>Nota:</strong> Aunque canceles el marketing, seguirás recibiendo comunicaciones transaccionales esenciales relacionadas con tus reservas.</p>
                </div>

                <h3>2.5. Cumplimiento Legal y Protección de Derechos</h3>
                <ul>
                    <li><strong>Obligaciones legales:</strong> Cumplir con leyes argentinas (AFIP, regulaciones fiscales, protección de datos)</li>
                    <li><strong>Solicitudes gubernamentales:</strong> Responder a citaciones, órdenes judiciales y solicitudes de autoridades</li>
                    <li><strong>Protección de derechos:</strong> Defender nuestros derechos legales, propiedad y seguridad</li>
                    <li><strong>Prevención de delitos:</strong> Detectar y prevenir actividades ilegales</li>
                    <li><strong>Cumplimiento contractual:</strong> Hacer cumplir nuestros Términos y Condiciones</li>
                </ul>

                <h3>2.6. Análisis y Reporting</h3>
                <ul>
                    <li><strong>Análisis de negocio:</strong> Entender tendencias del mercado de alquileres en Villa Carlos Paz</li>
                    <li><strong>Reportes agregados:</strong> Crear estadísticas anónimas sobre uso de la plataforma</li>
                    <li><strong>Investigación:</strong> Estudiar patrones de viaje y preferencias de alojamiento</li>
                    <li><strong>Auditoría financiera:</strong> Registros de transacciones para cumplimiento contable</li>
                </ul>
            </article>

            <!-- 3. Compartir Información -->
            <article class="article" id="compartir-informacion">
                <h2>
                    <i data-lucide="share-2" size="28"></i>
                    3. Cómo Compartimos tu Información
                </h2>

                <div class="warning-box">
                    <h4>
                        <i data-lucide="alert-triangle" size="20"></i>
                        Principio Fundamental
                    </h4>
                    <p><strong>Nunca vendemos tu información personal a terceros con fines publicitarios o comerciales.</strong> Solo compartimos tu información en las circunstancias descritas a continuación y con las protecciones adecuadas.</p>
                </div>

                <h3>3.1. Entre Huéspedes y Propietarios</h3>
                <p>Para facilitar las reservas, compartimos información necesaria entre usuarios:</p>

                <h4>Información que recibe el Propietario:</h4>
                <ul>
                    <li>Nombre completo del huésped</li>
                    <li>Fotografía de perfil (si la tienes)</li>
                    <li>Número de teléfono y email</li>
                    <li>Número de huéspedes</li>
                    <li>Fechas de la reserva</li>
                    <li>Historial de reseñas (si tiene)</li>
                </ul>

                <h4>Información que recibe el Huésped:</h4>
                <ul>
                    <li>Nombre del propietario</li>
                    <li>Información de contacto</li>
                    <li>Dirección completa de la propiedad</li>
                    <li>Instrucciones de check-in/check-out</li>
                    <li>Reglas de la casa</li>
                    <li>Calificación y reseñas del propietario</li>
                </ul>

                <h3>3.2. Con Proveedores de Servicios</h3>
                <p>Compartimos información con empresas que nos ayudan a operar la plataforma:</p>

                <h4>Procesadores de Pago</h4>
                <ul>
                    <li><strong>HoodPay:</strong> Para pagos con criptomonedas</li>
                    <li><strong>Mercado Pago:</strong> Para pagos locales en Argentina</li>
                    <li><strong>Otros procesadores:</strong> Para tarjetas de crédito/débito</li>
                </ul>
                <p><em>Estos proveedores están certificados PCI-DSS y cumplen con los más altos estándares de seguridad de pagos.</em></p>

                <h4>Servicios de Hosting y Almacenamiento</h4>
                <ul>
                    <li><strong>Servidores en la nube:</strong> Para almacenar datos de forma segura</li>
                    <li><strong>CDN:</strong> Para entregar contenido de forma rápida</li>
                    <li><strong>Backups:</strong> Para proteger contra pérdida de datos</li>
                </ul>

                <h4>Comunicaciones</h4>
                <ul>
                    <li><strong>WhatsApp Business API:</strong> Para asistencia por chat</li>
                    <li><strong>Servicios de email:</strong> Para enviar notificaciones y confirmaciones</li>
                    <li><strong>SMS:</strong> Para códigos de verificación y alertas urgentes</li>
                </ul>

                <h4>Análisis y Mejora del Servicio</h4>
                <ul>
                    <li><strong>Google Analytics:</strong> Para entender el uso de la plataforma (datos anónimos)</li>
                    <li><strong>Herramientas de testing:</strong> Para optimizar la experiencia</li>
                    <li><strong>Mapas:</strong> Google Maps para funcionalidad de ubicación</li>
                </ul>

                <h4>Verificación y Seguridad</h4>
                <ul>
                    <li><strong>Servicios de verificación de identidad:</strong> Para validar documentos</li>
                    <li><strong>Prevención de fraude:</strong> Para detectar actividades sospechosas</li>
                    <li><strong>Seguridad cibernética:</strong> Para proteger contra ataques</li>
                </ul>

                <p><strong>Todos nuestros proveedores:</strong></p>
                <ul>
                    <li>Firman acuerdos de confidencialidad y protección de datos</li>
                    <li>Solo acceden a información necesaria para su función específica</li>
                    <li>No pueden usar tu información para sus propios fines</li>
                    <li>Deben cumplir con estándares de seguridad equivalentes</li>
                </ul>

                <h3>3.3. Por Requisitos Legales</h3>
                <p>Podemos divulgar tu información cuando sea legalmente requerido:</p>

                <ul>
                    <li><strong>Órdenes judiciales:</strong> Citaciones, mandatos judiciales</li>
                    <li><strong>Autoridades gubernamentales:</strong> AFIP, ARCA, municipalidad de Villa Carlos Paz</li>
                    <li><strong>Investigaciones criminales:</strong> Cuando la ley lo requiera</li>
                    <li><strong>Protección de derechos:</strong> Para defender nuestros derechos legales en litigios</li>
                    <li><strong>Emergencias:</strong> Para proteger la salud o seguridad de personas</li>
                </ul>

                <p>En estos casos, limitamos la divulgación al mínimo necesario y, cuando legalmente permitido, te notificamos sobre la solicitud.</p>

                <h3>3.4. Transferencias Empresariales</h3>
                <p>Si RentaTurista participa en una fusión, adquisición o venta de activos:</p>
                <ul>
                    <li>Tu información puede ser transferida como parte de los activos</li>
                    <li>Te notificaremos antes de que tu información esté sujeta a una política de privacidad diferente</li>
                    <li>Tienes derecho a objetar y solicitar la eliminación de tus datos</li>
                </ul>

                <h3>3.5. Con tu Consentimiento</h3>
                <p>Podemos compartir información en otras circunstancias con tu consentimiento explícito:</p>
                <ul>
                    <li><strong>Socios comerciales:</strong> Si autorizas integraciones con terceros</li>
                    <li><strong>Redes sociales:</strong> Si eliges compartir contenido públicamente</li>
                    <li><strong>Programas especiales:</strong> Promociones con socios que requieran compartir datos</li>
                </ul>

                <h3>3.6. Información Agregada y Anónima</h3>
                <p>Podemos compartir información agregada y anónima que no te identifica personalmente:</p>
                <ul>
                    <li>Estadísticas sobre tendencias de alquiler en Villa Carlos Paz</li>
                    <li>Reportes de industria sobre turismo</li>
                    <li>Información demográfica general de usuarios</li>
                    <li>Métricas de uso de la plataforma</li>
                </ul>
                <p><em>Esta información no puede ser utilizada para identificarte individualmente.</em></p>
            </article>

            <!-- 4. Protección de Datos -->
            <article class="article" id="proteccion-datos">
                <h2>
                    <i data-lucide="lock" size="28"></i>
                    4. Cómo Protegemos tu Información
                </h2>

                <p>La seguridad de tu información personal es extremadamente importante para nosotros. Implementamos múltiples capas de protección:</p>

                <h3>4.1. Medidas Técnicas de Seguridad</h3>

                <h4>Encriptación</h4>
                <ul>
                    <li><strong>Encriptación en tránsito:</strong> Todas las transmisiones de datos usan SSL/TLS (https://) con certificados de 256 bits</li>
                    <li><strong>Encriptación en reposo:</strong> Datos sensibles (contraseñas, información de pago, documentos) se almacenan encriptados en nuestras bases de datos</li>
                    <li><strong>Hashing de contraseñas:</strong> Las contraseñas nunca se almacenan en texto plano, usamos algoritmos bcrypt con salt</li>
                </ul>

                <h4>Infraestructura Segura</h4>
                <ul>
                    <li><strong>Firewalls:</strong> Múltiples capas de firewalls protegen nuestros servidores</li>
                    <li><strong>Detección de intrusos:</strong> Sistemas automatizados monitorean actividades sospechosas 24/7</li>
                    <li><strong>Actualizaciones de seguridad:</strong> Parches y actualizaciones regulares de software</li>
                    <li><strong>Segregación de redes:</strong> Datos sensibles en redes aisladas</li>
                    <li><strong>Backups encriptados:</strong> Copias de seguridad diarias con encriptación</li>
                </ul>

                <h4>Autenticación</h4>
                <ul>
                    <li><strong>Autenticación de dos factores (2FA):</strong> Disponible para todas las cuentas</li>
                    <li><strong>Requisitos de contraseña fuerte:</strong> Mínimo 8 caracteres con letras, números y símbolos</li>
                    <li><strong>Tokens de sesión seguros:</strong> Expiran automáticamente después de inactividad</li>
                    <li><strong>Verificación de dispositivos:</strong> Alertas cuando se accede desde nuevos dispositivos</li>
                </ul>

                <h4>Monitoreo y Respuesta</h4>
                <ul>
                    <li><strong>Monitoreo continuo:</strong> Análisis de logs y actividad en tiempo real</li>
                    <li><strong>Alertas automatizadas:</strong> Notificaciones inmediatas ante actividades anómalas</li>
                    <li><strong>Plan de respuesta a incidentes:</strong> Procedimientos documentados para brechas de seguridad</li>
                    <li><strong>Auditorías de seguridad:</strong> Revisiones trimestrales por expertos externos</li>
                </ul>

                <h3>4.2. Medidas Administrativas</h3>

                <h4>Acceso Limitado</h4>
                <ul>
                    <li><strong>Principio de mínimo privilegio:</strong> Empleados solo acceden a datos necesarios para su función</li>
                    <li><strong>Control de acceso basado en roles:</strong> Permisos granulares según responsabilidad</li>
                    <li><strong>Autenticación multi-factor:</strong> Requerida para todo el personal que accede a sistemas</li>
                    <li><strong>Logs de acceso:</strong> Registro completo de quién accede a qué y cuándo</li>
                </ul>

                <h4>Capacitación del Personal</h4>
                <ul>
                    <li><strong>Entrenamiento en privacidad:</strong> Capacitación obligatoria para todos los empleados</li>
                    <li><strong>Actualizaciones regulares:</strong> Sesiones trimestrales sobre nuevas amenazas</li>
                    <li><strong>Simulacros de phishing:</strong> Pruebas periódicas de conciencia de seguridad</li>
                    <li><strong>Certificaciones:</strong> Personal clave certificado en seguridad de información</li>
                </ul>

                <h4>Políticas y Procedimientos</h4>
                <ul>
                    <li><strong>Acuerdos de confidencialidad:</strong> Todos los empleados y contratistas firman NDAs</li>
                    <li><strong>Políticas de escritorio limpio:</strong> Prohibición de datos sensibles en papel</li>
                    <li><strong>Destrucción segura:</strong> Procedimientos para eliminación segura de datos</li>
                    <li><strong>Revisión de terceros:</strong> Auditoría de todos los proveedores de servicios</li>
                </ul>

                <h3>4.3. Medidas Físicas</h3>
                <ul>
                    <li><strong>Centros de datos certificados:</strong> Instalaciones con certificación ISO 27001</li>
                    <li><strong>Control de acceso físico:</strong> Biometría, tarjetas de acceso, cámaras de seguridad</li>
                    <li><strong>Protección ambiental:</strong> Sistemas de extinción de incendios, control de temperatura</li>
                    <li><strong>Energía redundante:</strong> Generadores y UPS para evitar pérdida de datos</li>
                </ul>

                <h3>4.4. Ubicación y Transferencia de Datos</h3>
                <p><strong>Almacenamiento de Datos:</strong></p>
                <ul>
                    <li>Datos almacenados principalmente en servidores ubicados en Argentina</li>
                    <li>Backups replicados en centros de datos en países con leyes adecuadas de protección de datos</li>
                    <li>Transferencias internacionales solo con garantías apropiadas (cláusulas contractuales estándar)</li>
                </ul>

                <div class="info-box">
                    <i data-lucide="alert-circle" size="24"></i>
                    <div class="info-box-content">
                        <p><strong>Importante:</strong> A pesar de nuestros mejores esfuerzos, ningún sistema de seguridad es 100% impenetrable. Si bien implementamos las mejores prácticas de la industria, no podemos garantizar seguridad absoluta contra todas las amenazas posibles.</p>
                        <p><strong>Tu responsabilidad:</strong> Protege tu contraseña, no la compartas con nadie, y notifícanos inmediatamente si sospechas acceso no autorizado a tu cuenta.</p>
                    </div>
                </div>

                <h3>4.5. Notificación de Brechas de Seguridad</h3>
                <p>Si ocurre una brecha de seguridad que afecta tu información personal:</p>
                <ul>
                    <li>Te notificaremos dentro de las <strong>72 horas</strong> de descubrir la brecha (conforme a regulaciones)</li>
                    <li>Explicaremos qué información fue comprometida</li>
                    <li>Describiremos las medidas que estamos tomando</li>
                    <li>Proporcionaremos recomendaciones sobre cómo protegerte</li>
                    <li>Ofreceremos asistencia (como monitoreo de crédito si aplica)</li>
                </ul>
            </article>

            <!-- 5. Tus Derechos -->
            <article class="article" id="tus-derechos">
                <h2>
                    <i data-lucide="user-check" size="28"></i>
                    5. Tus Derechos sobre tu Información Personal
                </h2>

                <p>De acuerdo con la <strong>Ley de Protección de Datos Personales N° 25.326 de Argentina</strong> y regulaciones complementarias, tienes los siguientes derechos sobre tu información personal:</p>

                <h3>5.1. Derecho de Acceso</h3>
                <p><strong>Qué es:</strong> Tienes derecho a obtener confirmación sobre si estamos procesando tu información personal y, en caso afirmativo, acceder a ella.</p>
                <p><strong>Cómo ejercerlo:</strong></p>
                <ul>
                    <li>Solicita una copia de tu información personal en formato electrónico</li>
                    <li>Puedes descargar tus datos directamente desde "Configuración → Privacidad → Descargar mis datos"</li>
                    <li>O envía un email a privacidad@rentaturista.com</li>
                </ul>
                <p><strong>Qué recibirás:</strong> Un archivo con toda tu información personal que tenemos, en formato JSON o PDF</p>
                <p><strong>Plazo:</strong> 10 días hábiles desde tu solicitud</p>

                <h3>5.2. Derecho de Rectificación</h3>
                <p><strong>Qué es:</strong> Puedes corregir información personal inexacta o incompleta.</p>
                <p><strong>Cómo ejercerlo:</strong></p>
                <ul>
                    <li>Actualiza tu información directamente en "Mi Cuenta → Editar Perfil"</li>
                    <li>Para cambios que requieren verificación (email, teléfono), sigue el proceso de verificación</li>
                    <li>Para correcciones de datos históricos, contacta a privacidad@rentaturista.com</li>
                </ul>
                <p><strong>Plazo:</strong> Cambios inmediatos para datos básicos; 5 días hábiles para cambios que requieren verificación</p>

                <h3>5.3. Derecho de Supresión ("Derecho al Olvido")</h3>
                <p><strong>Qué es:</strong> Puedes solicitar que eliminemos tu información personal en ciertas circunstancias.</p>
                <p><strong>Cuándo aplica:</strong></p>
                <ul>
                    <li>Los datos ya no son necesarios para los fines para los que fueron recopilados</li>
                    <li>Retiras tu consentimiento y no existe otra base legal</li>
                    <li>Te opones al procesamiento y no hay intereses legítimos superiores</li>
                    <li>Los datos fueron procesados ilegalmente</li>
                </ul>

                <p><strong>Excepciones (no podemos eliminar cuando):</strong></p>
                <ul>
                    <li>Tenemos obligación legal de retener los datos (ej. registros fiscales por 10 años)</li>
                    <li>Los datos son necesarios para cumplir contratos activos</li>
                    <li>Los datos son necesarios para defender derechos legales en disputas</li>
                    <li>Hay intereses públicos que justifican la retención</li>
                </ul>

                <p><strong>Cómo ejercerlo:</strong></p>
                <ul>
                    <li>Ve a "Configuración → Privacidad → Eliminar mi cuenta"</li>
                    <li>O envía un email a privacidad@rentaturista.com especificando qué datos deseas eliminar</li>
                </ul>

                <p><strong>Qué sucede:</strong></p>
                <ul>
                    <li>Eliminamos o anonimizamos tu información personal</li>
                    <li>Tu cuenta se desactiva permanentemente</li>
                    <li>Conservamos datos mínimos requeridos por ley (registros de transacciones fiscales)</li>
                </ul>

                <p><strong>Plazo:</strong> 10 días hábiles</p>

                <h3>5.4. Derecho de Oposición</h3>
                <p><strong>Qué es:</strong> Puedes oponerte al procesamiento de tu información personal en ciertas situaciones.</p>
                <p><strong>Casos típicos:</strong></p>
                <ul>
                    <li><strong>Marketing directo:</strong> Puedes oponerte en cualquier momento a recibir comunicaciones de marketing</li>
                    <li><strong>Decisiones automatizadas:</strong> Puedes solicitar revisión humana de decisiones automatizadas que te afecten significativamente</li>
                    <li><strong>Procesamiento por interés legítimo:</strong> Puedes oponerte si creemos que tu situación particular justifica la oposición</li>
                </ul>

                <p><strong>Cómo ejercerlo:</strong></p>
                <ul>
                    <li>Para marketing: Click en "Cancelar suscripción" en emails o ajusta "Configuración → Notificaciones"</li>
                    <li>Para otros casos: Email a privacidad@rentaturista.com explicando tu situación</li>
                </ul>

                <h3>5.5. Derecho de Portabilidad</h3>
                <p><strong>Qué es:</strong> Puedes recibir tu información personal en un formato estructurado, de uso común y lectura mecánica, y transmitirla a otro responsable.</p>
                <p><strong>Qué información incluye:</strong></p>
                <ul>
                    <li>Datos de perfil y cuenta</li>
                    <li>Historial de reservas</li>
                    <li>Preferencias y configuraciones</li>
                    <li>Comunicaciones y mensajes</li>
                </ul>

                <p><strong>Formato:</strong> JSON, CSV o XML</p>
                <p><strong>Cómo ejercerlo:</strong> "Configuración → Privacidad → Exportar mis datos"</p>
                <p><strong>Plazo:</strong> Descarga inmediata o 5 días hábiles para exportaciones grandes</p>

                <h3>5.6. Derecho a la Información</h3>
                <p><strong>Qué es:</strong> Tienes derecho a ser informado sobre:</p>
                <ul>
                    <li>Qué datos tenemos sobre ti</li>
                    <li>Cómo los usamos</li>
                    <li>Con quién los compartimos</li>
                    <li>Cuánto tiempo los conservamos</li>
                    <li>Tus derechos y cómo ejercerlos</li>
                </ul>
                <p><em>Esta Política de Privacidad cumple con este derecho. Actualízala periódicamente.</em></p>

                <h3>5.7. Derecho a Retirar el Consentimiento</h3>
                <p><strong>Qué es:</strong> Cuando el procesamiento se basa en tu consentimiento, puedes retirarlo en cualquier momento.</p>
                <p><strong>Importante:</strong> Retirar el consentimiento no afecta la legalidad del procesamiento previo</p>
                <p><strong>Dónde aplica:</strong></p>
                <ul>
                    <li>Marketing y comunicaciones promocionales</li>
                    <li>Uso de ubicación precisa</li>
                    <li>Compartir datos con terceros específicos</li>
                    <li>Cookies no esenciales</li>
                </ul>

                <h3>5.8. Derecho a Presentar una Queja</h3>
                <p><strong>Ante RentaTurista:</strong></p>
                <ul>
                    <li>Email: privacidad@rentaturista.com</li>
                    <li>WhatsApp: +54 9 3541 123456</li>
                    <li>Responderemos dentro de 10 días hábiles</li>
                </ul>

                <p><strong>Ante la Autoridad de Control:</strong></p>
                <p>Si no estás satisfecho con nuestra respuesta, puedes presentar una queja ante:</p>
                <ul>
                    <li><strong>Agencia de Acceso a la Información Pública (AAIP)</strong></li>
                    <li>Av. Pte. Gral. Julio A. Roca 710, Piso 3°, C1067ABP, Buenos Aires</li>
                    <li>Teléfono: 0800-222-DATOS (32867)</li>
                    <li>Email: datospersonales@aaip.gob.ar</li>
                    <li>Web: www.argentina.gob.ar/aaip</li>
                </ul>

                <div class="highlight-box">
                    <h4>Cómo Ejercer tus Derechos - Guía Paso a Paso</h4>
                    <ol>
                        <li><strong>Identifícate:</strong> Envía tu solicitud desde el email registrado en tu cuenta o proporciona documentación que acredite tu identidad</li>
                        <li><strong>Especifica tu solicitud:</strong> Indica claramente qué derecho deseas ejercer y qué información específica te concierne</li>
                        <li><strong>Envía tu solicitud:</strong>
                            <ul>
                                <li>Email: privacidad@rentaturista.com</li>
                                <li>Formulario web: "Configuración → Privacidad → Ejercer mis derechos"</li>
                                <li>WhatsApp: +54 9 3541 123456</li>
                            </ul>
                        </li>
                        <li><strong>Confirmación:</strong> Recibirás confirmación de recepción dentro de 24 horas</li>
                        <li><strong>Resolución:</strong> Procesaremos tu solicitud dentro de 10 días hábiles</li>
                        <li><strong>Seguimiento:</strong> Si necesitas más tiempo o información adicional, te contactaremos</li>
                    </ol>
                    <p><strong>Sin costo:</strong> Ejercer tus derechos es completamente gratuito. Solo podríamos cobrar una tarifa razonable si tus solicitudes son manifiestamente infundadas, repetitivas o excesivas.</p>
                </div>
            </article>

            <!-- 6. Cookies -->
            <article class="article" id="cookies">
                <h2>
                    <i data-lucide="cookie" size="28"></i>
                    6. Cookies y Tecnologías Similares
                </h2>

                <p>Utilizamos cookies y tecnologías similares para mejorar tu experiencia en RentaTurista. Aquí te explicamos qué son, cómo las usamos y cómo puedes controlarlas.</p>

                <h3>6.1. ¿Qué son las Cookies?</h3>
                <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Permiten que el sitio recuerde tus acciones y preferencias durante un período de tiempo.</p>

                <h3>6.2. Tipos de Cookies que Usamos</h3>

                <h4>Cookies Estrictamente Necesarias (No pueden desactivarse)</h4>
                <p>Esenciales para que la plataforma funcione correctamente:</p>
                <ul>
                    <li><strong>rt_session:</strong> Mantiene tu sesión activa cuando navegas</li>
                    <li><strong>rt_auth:</strong> Token de autenticación para verificar tu identidad</li>
                    <li><strong>rt_csrf:</strong> Protección contra ataques de falsificación de solicitudes</li>
                    <li><strong>rt_security:</strong> Prevención de fraudes y ataques</li>
                </ul>

                <h4>Cookies de Rendimiento y Análisis (Pueden desactivarse)</h4>
                <p>Nos ayudan a entender cómo usas la plataforma:</p>
                <ul>
                    <li><strong>Google Analytics (_ga, _gid, _gat):</strong> Análisis de tráfico, páginas vistas, tiempo de permanencia</li>
                    <li><strong>rt_analytics:</strong> Métricas internas de uso</li>
                    <li><strong>rt_performance:</strong> Monitoreo de velocidad y rendimiento</li>
                </ul>
                <p><em>Datos agregados y anónimos que no te identifican personalmente.</em></p>

                <h4>Cookies de Funcionalidad (Pueden desactivarse)</h4>
                <p>Mejoran tu experiencia recordando tus preferencias:</p>
                <ul>
                    <li><strong>rt_lang:</strong> Tu idioma preferido</li>
                    <li><strong>rt_currency:</strong> Tu moneda preferida (ARS, USD, EUR)</li>
                    <li><strong>rt_recent_searches:</strong> Tus búsquedas recientes</li>
                    <li><strong>rt_favorites:</strong> Propiedades guardadas en favoritos</li>
                    <li><strong>rt_map_view:</strong> Preferencias de visualización de mapas</li>
                </ul>

                <h4>Cookies de Marketing y Publicidad (Pueden desactivarse)</h4>
                <p>Para mostrarte anuncios relevantes:</p>
                <ul>
                    <li><strong>Facebook Pixel (_fbp, fr):</strong> Remarketing en Facebook e Instagram</li>
                    <li><strong>Google Ads (IDE, NID):</strong> Publicidad personalizada en Google</li>
                    <li><strong>rt_remarketing:</strong> Seguimiento de conversiones internas</li>
                </ul>

                <h3>6.3. Tecnologías Similares</h3>
                <p>También usamos:</p>
                <ul>
                    <li><strong>Píxeles de seguimiento:</strong> Pequeñas imágenes invisibles en emails para saber si los abriste</li>
                    <li><strong>Web beacons:</strong> Para medir efectividad de campañas</li>
                    <li><strong>Local Storage:</strong> Para almacenar preferencias localmente en tu navegador</li>
                    <li><strong>Session Storage:</strong> Para datos temporales durante tu sesión</li>
                </ul>

                <h3>6.4. Cómo Controlar las Cookies</h3>

                <h4>Panel de Preferencias de RentaTurista</h4>
                <p>Gestiona tus preferencias de cookies en:</p>
                <ul>
                    <li>El banner que aparece en tu primera visita</li>
                    <li>"Configuración → Privacidad → Preferencias de Cookies"</li>
                    <li>Enlace en el pie de página: "Configurar Cookies"</li>
                </ul>

                <h4>Configuración del Navegador</h4>
                <p>Puedes bloquear o eliminar cookies desde tu navegador:</p>
                <ul>
                    <li><strong>Chrome:</strong> Configuración → Privacidad y seguridad → Cookies y otros datos de sitios</li>
                    <li><strong>Firefox:</strong> Opciones → Privacidad y seguridad → Cookies y datos del sitio</li>
                    <li><strong>Safari:</strong> Preferencias → Privacidad → Gestionar datos de sitios web</li>
                    <li><strong>Edge:</strong> Configuración → Privacidad, búsqueda y servicios → Cookies</li>
                </ul>

                <div class="warning-box">
                    <h4>
                        <i data-lucide="alert-triangle" size="20"></i>
                        Advertencia
                    </h4>
                    <p>Bloquear todas las cookies puede afectar la funcionalidad de RentaTurista. Podrías no poder iniciar sesión, realizar reservas o usar ciertas características de la plataforma.</p>
                </div>

                <h4>Exclusión de Cookies de Terceros</h4>
                <ul>
                    <li><strong>Google Analytics:</strong> <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Plugin de exclusión</a></li>
                    <li><strong>Google Ads:</strong> <a href="https://adssettings.google.com" target="_blank" rel="noopener">Configuración de anuncios</a></li>
                    <li><strong>Facebook:</strong> <a href="https://www.facebook.com/ads/preferences" target="_blank" rel="noopener">Preferencias de anuncios</a></li>
                </ul>

                <h3>6.5. Tabla Completa de Cookies</h3>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Propósito</th>
                            <th>Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>rt_session</td>
                            <td>Necesaria</td>
                            <td>Mantener sesión activa</td>
                            <td>Sesión</td>
                        </tr>
                        <tr>
                            <td>rt_auth</td>
                            <td>Necesaria</td>
                            <td>Autenticación de usuario</td>
                            <td>30 días</td>
                        </tr>
                        <tr>
                            <td>rt_csrf</td>
                            <td>Necesaria</td>
                            <td>Protección CSRF</td>
                            <td>Sesión</td>
                        </tr>
                        <tr>
                            <td>rt_lang</td>
                            <td>Funcionalidad</td>
                            <td>Idioma preferido</td>
                            <td>1 año</td>
                        </tr>
                        <tr>
                            <td>rt_currency</td>
                            <td>Funcionalidad</td>
                            <td>Moneda preferida</td>
                            <td>1 año</td>
                        </tr>
                        <tr>
                            <td>_ga</td>
                            <td>Análisis</td>
                            <td>Google Analytics - ID único</td>
                            <td>2 años</td>
                        </tr>
                        <tr>
                            <td>_gid</td>
                            <td>Análisis</td>
                            <td>Google Analytics - ID de sesión</td>
                            <td>24 horas</td>
                        </tr>
                        <tr>
                            <td>_fbp</td>
                            <td>Marketing</td>
                            <td>Facebook Pixel - tracking</td>
                            <td>3 meses</td>
                        </tr>
                        <tr>
                            <td>IDE</td>
                            <td>Marketing</td>
                            <td>Google DoubleClick - publicidad</td>
                            <td>1 año</td>
                        </tr>
                    </tbody>
                </table>

                <p><strong>Nota:</strong> Para una lista completa y actualizada de todas las cookies, visita nuestra <a href="politicas.php#cookies">Política de Cookies detallada</a>.</p>
            </article>

            <!-- 7. Retención y Eliminación -->
            <article class="article" id="retencion">
                <h2>
                    <i data-lucide="clock" size="28"></i>
                    7. Retención y Eliminación de Datos
                </h2>

                <p>Conservamos tu información personal solo durante el tiempo necesario para cumplir con los propósitos descritos en esta política y cumplir con obligaciones legales.</p>

                <h3>7.1. Períodos de Retención</h3>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tipo de Datos</th>
                            <th>Período de Retención</th>
                            <th>Razón</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Datos de cuenta activa</td>
                            <td>Mientras la cuenta esté activa</td>
                            <td>Prestación del servicio</td>
                        </tr>
                        <tr>
                            <td>Historial de reservas</td>
                            <td>10 años desde última transacción</td>
                            <td>Requisito fiscal (AFIP)</td>
                        </tr>
                        <tr>
                            <td>Datos de verificación de identidad</td>
                            <td>5 años desde última transacción</td>
                            <td>Prevención de fraude y cumplimiento legal</td>
                        </tr>
                        <tr>
                            <td>Comunicaciones con soporte</td>
                            <td>2 años</td>
                            <td>Resolución de disputas</td>
                        </tr>
                        <tr>
                            <td>Datos de marketing</td>
                            <td>Hasta retiro de consentimiento</td>
                            <td>Comunicaciones promocionales</td>
                        </tr>
                        <tr>
                            <td>Logs de acceso y seguridad</td>
                            <td>1 año</td>
                            <td>Seguridad y detección de fraude</td>
                        </tr>
                        <tr>
                            <td>Datos de cookies de análisis</td>
                            <td>26 meses (Google Analytics)</td>
                            <td>Análisis de uso</td>
                        </tr>
                        <tr>
                            <td>Reseñas y calificaciones</td>
                            <td>Permanente (anonimizadas si eliminas cuenta)</td>
                            <td>Integridad de la plataforma</td>
                        </tr>
                    </tbody>
                </table>

                <h3>7.2. Criterios de Retención</h3>
                <p>Determinamos el período de retención basándonos en:</p>
                <ul>
                    <li><strong>Obligaciones legales:</strong> Leyes fiscales, contables y regulatorias argentinas</li>
                    <li><strong>Intereses legítimos:</strong> Prevención de fraude, resolución de disputas</li>
                    <li><strong>Consentimiento:</strong> Duración especificada cuando diste tu consentimiento</li>
                    <li><strong>Necesidad operativa:</strong> Tiempo necesario para proporcionar el servicio</li>
                </ul>

                <h3>7.3. Eliminación Segura</h3>
                <p>Cuando eliminamos datos:</p>
                <ul>
                    <li><strong>Eliminación permanente:</strong> Los datos se borran de forma irrecuperable de nuestros sistemas activos</li>
                    <li><strong>Eliminación de backups:</strong> Los datos se eliminan de backups en el siguiente ciclo de rotación (máximo 90 días)</li>
                    <li><strong>Anonimización:</strong> En algunos casos, anonimizamos datos en lugar de eliminarlos (por ejemplo, para estadísticas agregadas)</li>
                    <li><strong>Destrucción de medios físicos:</strong> Discos duros y medios físicos se destruyen según estándares DoD 5220.22-M</li>
                </ul>

                <h3>7.4. Cuenta Inactiva</h3>
                <p>Si tu cuenta permanece inactiva (sin inicio de sesión) por:</p>
                <ul>
                    <li><strong>3 años:</strong> Te enviamos un recordatorio por email</li>
                    <li><strong>3 años y 6 meses:</strong> Notificación final de que tu cuenta será eliminada</li>
                    <li><strong>4 años:</strong> Tu cuenta se elimina automáticamente (excepto datos que debemos retener por ley)</li>
                </ul>

                <div class="info-box">
                    <i data-lucide="info" size="24"></i>
                    <div class="info-box-content">
                        <p><strong>Excepción:</strong> Cuentas de propietarios con propiedades activas no se consideran inactivas mientras tengan calendarios disponibles o reservas futuras.</p>
                    </div>
                </div>
            </article>

            <!-- 8. Menores de Edad -->
            <article class="article" id="menores">
                <h2>
                    <i data-lucide="baby" size="28"></i>
                    8. Privacidad de Menores de Edad
                </h2>

                <p>RentaTurista está dirigido a personas mayores de 18 años. No recopilamos intencionalmente información personal de menores de edad sin el consentimiento de sus padres o tutores legales.</p>

                <h3>8.1. Política para Menores</h3>
                <ul>
                    <li><strong>Edad mínima:</strong> Debes tener al menos 18 años para crear una cuenta en RentaTurista</li>
                    <li><strong>Verificación:</strong> Podemos solicitar verificación de edad en cualquier momento</li>
                    <li><strong>Reservas para menores:</strong> Los menores pueden viajar, pero la reserva debe ser realizada por un adulto responsable</li>
                </ul>

                <h3>8.2. Si Eres Padre o Tutor</h3>
                <p>Si crees que tu hijo menor de 18 años nos ha proporcionado información personal sin tu consentimiento:</p>
                <ul>
                    <li>Contáctanos inmediatamente a privacidad@rentaturista.com</li>
                    <li>Proporciónanos detalles de la cuenta en cuestión</li>
                    <li>Eliminaremos la información dentro de las 48 horas</li>
                </ul>

                <h3>8.3. Menores Viajando</h3>
                <p>Cuando un menor viaja como huésped:</p>
                <ul>
                    <li>Un adulto (18+) debe realizar y ser responsable de la reserva</li>
                    <li>El adulto debe acompañar al menor o proporcionar autorización escrita</li>
                    <li>Recopilamos información mínima del menor (solo lo necesario para la estadía)</li>
                    <li>La información del menor se maneja con protecciones adicionales</li>
                </ul>
            </article>

            <!-- 9. Cambios a esta Política -->
            <article class="article" id="cambios">
                <h2>
                    <i data-lucide="refresh-cw" size="28"></i>
                    9. Cambios a esta Política de Privacidad
                </h2>

                <p>Podemos actualizar esta Política de Privacidad ocasionalmente para reflejar cambios en nuestras prácticas, nuevas funcionalidades, requisitos legales o por otras razones operativas.</p>

                <h3>9.1. Notificación de Cambios</h3>
                <p>Cuando realicemos cambios materiales, te notificaremos mediante:</p>
                <ul>
                    <li><strong>Email:</strong> A la dirección registrada en tu cuenta (al menos 30 días antes de que los cambios entren en vigor)</li>
                    <li><strong>Aviso destacado:</strong> En la plataforma y al iniciar sesión</li>
                    <li><strong>Mensaje de WhatsApp:</strong> Para cambios muy significativos</li>
                    <li><strong>Actualización de la fecha:</strong> La fecha de "Última actualización" al inicio de esta política</li>
                </ul>

                <h3>9.2. Tipos de Cambios</h3>

                <h4>Cambios Materiales (Requieren notificación previa):</h4>
                <ul>
                    <li>Nuevos usos de información personal no cubiertos previamente</li>
                    <li>Compartir información con nuevas categorías de terceros</li>
                    <li>Reducción de tus derechos de privacidad</li>
                    <li>Cambios en períodos de retención de datos</li>
                </ul>

                <h4>Cambios No Materiales (Pueden aplicarse inmediatamente):</h4>
                <ul>
                    <li>Clarificaciones de lenguaje sin cambio de significado</li>
                    <li>Actualización de información de contacto</li>
                    <li>Correcciones de errores tipográficos</li>
                    <li>Adición de ejemplos ilustrativos</li>
                </ul>

                <h3>9.3. Tu Opción</h3>
                <p>Si no aceptas los cambios materiales:</p>
                <ul>
                    <li>Puedes cerrar tu cuenta antes de que los cambios entren en vigor</li>
                    <li>Tu uso continuado de la plataforma después de la fecha efectiva constituye tu aceptación de los cambios</li>
                    <li>Tienes derecho a ejercer cualquiera de tus derechos de privacidad antes de cerrar tu cuenta</li>
                </ul>

                <h3>9.4. Historial de Versiones</h3>
                <p>Mantenemos un archivo de versiones anteriores de esta política. Puedes solicitar versiones históricas contactando a privacidad@rentaturista.com</p>

                <div class="highlight-box">
                    <h4>Recomendación</h4>
                    <p>Te recomendamos revisar esta Política de Privacidad periódicamente para estar informado sobre cómo protegemos tu información. Puedes suscribirte a notificaciones de cambios en "Configuración → Privacidad → Notificarme de cambios en políticas".</p>
                </div>
            </article>

            <!-- 10. Contacto -->
            <article class="article" id="contacto">
                <h2>
                    <i data-lucide="mail" size="28"></i>
                    10. Contacto y Preguntas
                </h2>

                <p>Si tienes preguntas, inquietudes o solicitudes relacionadas con esta Política de Privacidad o tus datos personales, estamos aquí para ayudarte.</p>

                <h3>10.1. Información de Contacto</h3>

                <h4>Responsable de Protección de Datos</h4>
                <p><strong>RentaTurista</strong><br>
                Departamento de Privacidad<br>
                Villa Carlos Paz, Córdoba, Argentina</p>

                <h4>Canales de Contacto</h4>
                <ul>
                    <li><strong>Email principal:</strong> privacidad@rentaturista.com</li>
                    <li><strong>Email general:</strong> ayuda@rentaturista.com</li>
                    <li><strong>WhatsApp:</strong> +54 9 3541 123456</li>
                    <li><strong>Formulario web:</strong> <a href="contacto.php">www.rentaturista.com/contacto</a></li>
                    <li><strong>Teléfono:</strong> +54 3541 123456 (Lun-Vie 9-18hs ARG)</li>
                </ul>

                <h3>10.2. Tiempo de Respuesta</h3>
                <ul>
                    <li><strong>Confirmación de recepción:</strong> 24 horas</li>
                    <li><strong>Respuesta completa:</strong> 10 días hábiles (plazo legal en Argentina)</li>
                    <li><strong>Solicitudes complejas:</strong> Hasta 20 días hábiles (te notificaremos si necesitamos más tiempo)</li>
                    <li><strong>Emergencias de seguridad:</strong> Respuesta inmediata 24/7</li>
                </ul>

                <h3>10.3. Información a Incluir en tu Consulta</h3>
                <p>Para ayudarnos a responder más rápidamente, incluye:</p>
                <ul>
                    <li>Tu nombre completo</li>
                    <li>Email asociado a tu cuenta</li>
                    <li>Descripción clara de tu consulta o solicitud</li>
                    <li>Cualquier documentación relevante</li>
                    <li>Si estás ejerciendo un derecho específico (acceso, rectificación, etc.)</li>
                </ul>

                <h3>10.4. Autoridad de Control</h3>
                <p>También puedes contactar directamente a la autoridad de protección de datos de Argentina:</p>
                <p><strong>Agencia de Acceso a la Información Pública (AAIP)</strong><br>
                Av. Pte. Gral. Julio A. Roca 710, Piso 3°<br>
                C1067ABP, Ciudad Autónoma de Buenos Aires<br>
                Teléfono: 0800-222-DATOS (32867)<br>
                Email: datospersonales@aaip.gob.ar<br>
                Web: <a href="https://www.argentina.gob.ar/aaip" target="_blank" rel="noopener">www.argentina.gob.ar/aaip</a></p>
            </article>

            <!-- Contact CTA -->
            <div class="contact-cta">
                <h3>¿Tienes Preguntas sobre tu Privacidad?</h3>
                <p>Nuestro equipo de privacidad está listo para ayudarte con cualquier consulta o inquietud</p>
                
                <div class="contact-buttons">
                    <a href="https://wa.me/5493541123456" class="contact-btn contact-btn-primary" target="_blank" rel="noopener">
                        <i data-lucide="message-circle" size="20"></i>
                        WhatsApp 24/7
                    </a>
                    <a href="mailto:privacidad@rentaturista.com" class="contact-btn contact-btn-secondary">
                        <i data-lucide="mail" size="20"></i>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="index.php">Inicio</a>
                <a href="politicas.php#terminos">Términos y Condiciones</a>
                <a href="politicas.php#cookies">Política de Cookies</a>
                <a href="politicas.php#cancelacion">Cancelación y Reembolsos</a>
                <a href="contacto.php">Contacto</a>
            </div>
            <p>&copy; 2024 RentaTurista. Todos los derechos reservados. | Hecho con ❤️ en Villa Carlos Paz</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Volver arriba">
        <i data-lucide="arrow-up" size="24"></i>
    </button>

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Back to Top functionality
            const backToTop = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });

            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;
                    
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offsetTop = target.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

           // Print functionality
            window.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    // Allow default print behavior
                }
            });

            // Highlight current section on scroll
            const sections = document.querySelectorAll('.article');
            const navLinks = document.querySelectorAll('.quick-nav-link');

            function highlightNavigation() {
                let scrollPosition = window.pageYOffset + 150;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        navLinks.forEach(link => {
                            link.style.borderColor = 'var(--gray-200)';
                            link.style.background = 'var(--white)';
                            if (link.getAttribute('href') === '#' + sectionId) {
                                link.style.borderColor = 'var(--orange-primary)';
                                link.style.background = 'rgba(255, 107, 53, 0.05)';
                            }
                        });
                    }
                });
            }

            window.addEventListener('scroll', highlightNavigation);
        });
    </script>
</body>
</html>