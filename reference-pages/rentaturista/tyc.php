<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Políticas de Privacidad y Términos y Condiciones | RentaTurista</title>
    
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
            max-width: 1200px;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }

        .hero h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.125rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-date {
            margin-top: 1.5rem;
            font-size: 0.9375rem;
            opacity: 0.85;
            font-weight: 500;
        }

        /* Navigation Tabs */
        .nav-tabs {
            background: var(--white);
            border-bottom: 2px solid var(--gray-200);
            position: sticky;
            top: 73px;
            z-index: 99;
        }

        .tabs-container {
            display: flex;
            gap: 2rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tab {
            padding: 1.25rem 0.5rem;
            font-weight: 600;
            color: var(--gray-600);
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: var(--transition);
            white-space: nowrap;
            cursor: pointer;
        }

        .tab:hover {
            color: var(--orange-primary);
        }

        .tab.active {
            color: var(--orange-primary);
            border-bottom-color: var(--orange-primary);
        }

        /* Content */
        .content {
            padding: 4rem 0;
        }

        .section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-intro {
            background: var(--gray-50);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 3rem;
            border-left: 4px solid var(--orange-primary);
        }

        .section-intro p {
            font-size: 1.0625rem;
            line-height: 1.7;
            color: var(--gray-700);
        }

        .article {
            margin-bottom: 3rem;
        }

        .article h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .article h3 {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 2rem 0 1rem;
        }

        .article h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-700);
            margin: 1.5rem 0 0.75rem;
        }

        .article p {
            margin-bottom: 1rem;
            line-height: 1.8;
            color: var(--gray-700);
        }

        .article ul, .article ol {
            margin: 1rem 0 1.5rem 1.5rem;
            line-height: 1.8;
        }

        .article li {
            margin-bottom: 0.75rem;
            color: var(--gray-700);
        }

        .article strong {
            color: var(--gray-900);
            font-weight: 600;
        }

        .highlight-box {
            background: rgba(255, 107, 53, 0.05);
            border-left: 4px solid var(--orange-primary);
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 8px;
        }

        .highlight-box h4 {
            margin-top: 0;
            color: var(--orange-primary);
        }

        .info-box {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 12px;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .info-box i {
            color: var(--orange-primary);
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .info-box-content p:last-child {
            margin-bottom: 0;
        }

        /* Contact Section */
        .contact-section {
            background: var(--gray-50);
            padding: 3rem;
            border-radius: 16px;
            margin-top: 4rem;
            text-align: center;
        }

        .contact-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }

        .contact-section p {
            color: var(--gray-600);
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
            background: var(--orange-primary);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .contact-btn-primary:hover {
            background: var(--orange-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
        }

        .contact-btn-secondary {
            background: var(--white);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
        }

        .contact-btn-secondary:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        /* Footer */
        .footer {
            background: var(--gray-900);
            color: rgba(255, 255, 255, 0.8);
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        .footer p {
            font-size: 0.875rem;
        }

        .footer a {
            color: var(--orange-primary);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
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
            }

            .nav-tabs {
                top: 113px;
            }

            .hero {
                padding: 3rem 0 2rem;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .tabs-container {
                gap: 1.5rem;
            }

            .tab {
                padding: 1rem 0.25rem;
                font-size: 0.9375rem;
            }

            .content {
                padding: 3rem 0;
            }

            .section-intro {
                padding: 1.5rem;
            }

            .article h2 {
                font-size: 1.5rem;
            }

            .article h3 {
                font-size: 1.25rem;
            }

            .contact-section {
                padding: 2rem 1.5rem;
            }

            .contact-buttons {
                flex-direction: column;
            }

            .contact-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
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
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <h1>Políticas y Términos Legales</h1>
            <p>Información importante sobre el uso de RentaTurista, privacidad y condiciones del servicio</p>
            <div class="hero-date">Última actualización: 30 de diciembre de 2024</div>
        </div>
    </section>

    <!-- Navigation Tabs -->
    <nav class="nav-tabs">
        <div class="container">
            <div class="tabs-container">
                <a href="#" class="tab active" data-section="privacidad">Políticas de Privacidad</a>
                <a href="#" class="tab" data-section="terminos">Términos y Condiciones</a>
                <a href="#" class="tab" data-section="cookies">Política de Cookies</a>
                <a href="#" class="tab" data-section="cancelacion">Cancelación y Reembolsos</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="content">
        <div class="container">
            <!-- POLÍTICAS DE PRIVACIDAD -->
            <section id="privacidad" class="section active">
                <div class="section-intro">
                    <p>En RentaTurista valoramos y respetamos tu privacidad. Esta Política de Privacidad describe cómo recopilamos, usamos, almacenamos y protegemos tu información personal cuando utilizas nuestra plataforma intermediaria de alquileres vacacionales en Villa Carlos Paz, Argentina.</p>
                </div>

                <article class="article">
                    <h2>
                        <i data-lucide="shield-check" size="28"></i>
                        1. Información que Recopilamos
                    </h2>
                    
                    <h3>1.1. Información Personal Proporcionada por Ti</h3>
                    <p>Recopilamos la siguiente información cuando te registras, realizas una reserva o utilizas nuestros servicios:</p>
                    <ul>
                        <li><strong>Datos de identificación:</strong> Nombre completo, documento de identidad (DNI/pasaporte), fecha de nacimiento</li>
                        <li><strong>Datos de contacto:</strong> Dirección de correo electrónico, número de teléfono, dirección postal</li>
                        <li><strong>Información de pago:</strong> Datos de tarjetas de crédito/débito, información de cuenta bancaria (procesados de forma segura por proveedores de pago certificados)</li>
                        <li><strong>Información de perfil:</strong> Fotografía de perfil, preferencias de viaje, idioma</li>
                        <li><strong>Verificación de identidad:</strong> Documentos de identificación para verificación de seguridad</li>
                    </ul>

                    <h3>1.2. Información Recopilada Automáticamente</h3>
                    <ul>
                        <li><strong>Datos de uso:</strong> Páginas visitadas, propiedades vistas, búsquedas realizadas, tiempo de navegación</li>
                        <li><strong>Información del dispositivo:</strong> Tipo de dispositivo, sistema operativo, navegador web, dirección IP</li>
                        <li><strong>Datos de ubicación:</strong> Ubicación geográfica aproximada (con tu consentimiento)</li>
                        <li><strong>Cookies y tecnologías similares:</strong> Ver nuestra Política de Cookies para más detalles</li>
                    </ul>

                    <h3>1.3. Información de Terceros</h3>
                    <ul>
                        <li>Información de redes sociales si decides conectar tu cuenta (Facebook, Google)</li>
                        <li>Verificaciones de antecedentes y validación de identidad de servicios autorizados</li>
                        <li>Información pública disponible sobre propiedades y ubicaciones</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="database" size="28"></i>
                        2. Cómo Utilizamos tu Información
                    </h2>
                    
                    <p>Utilizamos la información recopilada para los siguientes propósitos:</p>

                    <h3>2.1. Prestación de Servicios</h3>
                    <ul>
                        <li>Procesar y gestionar reservas entre huéspedes y propietarios</li>
                        <li>Facilitar la comunicación entre huéspedes y propietarios</li>
                        <li>Procesar pagos y transacciones financieras de forma segura</li>
                        <li>Proporcionar asistencia al cliente 24/7 por WhatsApp y otros canales</li>
                        <li>Verificar la identidad de usuarios para seguridad de la plataforma</li>
                    </ul>

                    <h3>2.2. Mejora de la Plataforma</h3>
                    <ul>
                        <li>Personalizar tu experiencia de usuario</li>
                        <li>Analizar tendencias y patrones de uso para mejorar nuestros servicios</li>
                        <li>Desarrollar nuevas funcionalidades y características</li>
                        <li>Entrenar y mejorar nuestra IA turística local</li>
                    </ul>

                    <h3>2.3. Comunicación y Marketing</h3>
                    <ul>
                        <li>Enviar confirmaciones de reserva y actualizaciones importantes</li>
                        <li>Notificar sobre cambios en políticas o términos de servicio</li>
                        <li>Enviar recomendaciones personalizadas de propiedades (con tu consentimiento)</li>
                        <li>Compartir ofertas especiales y promociones (puedes darte de baja en cualquier momento)</li>
                    </ul>

                    <h3>2.4. Seguridad y Cumplimiento Legal</h3>
                    <ul>
                        <li>Detectar y prevenir fraudes, abusos y actividades ilegales</li>
                        <li>Cumplir con obligaciones legales y regulatorias en Argentina</li>
                        <li>Resolver disputas entre huéspedes y propietarios</li>
                        <li>Proteger los derechos, seguridad y propiedad de RentaTurista y sus usuarios</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="share-2" size="28"></i>
                        3. Compartir Información
                    </h2>
                    
                    <h3>3.1. Con Propietarios y Huéspedes</h3>
                    <p>Compartimos información necesaria entre huéspedes y propietarios para facilitar las reservas:</p>
                    <ul>
                        <li>Los propietarios reciben: nombre, foto de perfil, número de teléfono y detalles de la reserva</li>
                        <li>Los huéspedes reciben: información de contacto del propietario, dirección de la propiedad, instrucciones de check-in</li>
                    </ul>

                    <h3>3.2. Con Proveedores de Servicios</h3>
                    <p>Compartimos información con proveedores de confianza que nos ayudan a operar la plataforma:</p>
                    <ul>
                        <li><strong>Procesadores de pago:</strong> Para gestionar transacciones (ej. HoodPay, Mercado Pago)</li>
                        <li><strong>Servicios de hosting:</strong> Para almacenar datos de forma segura</li>
                        <li><strong>Servicios de comunicación:</strong> WhatsApp Business API, servicios de email</li>
                        <li><strong>Herramientas de análisis:</strong> Para entender el uso de la plataforma (Google Analytics)</li>
                        <li><strong>Servicios de verificación:</strong> Para validar identidades y prevenir fraudes</li>
                    </ul>

                    <h3>3.3. Requisitos Legales</h3>
                    <p>Podemos divulgar tu información cuando sea legalmente requerido:</p>
                    <ul>
                        <li>En respuesta a citaciones, órdenes judiciales u otros procesos legales</li>
                        <li>Para cumplir con leyes, regulaciones o solicitudes gubernamentales</li>
                        <li>Para proteger los derechos, seguridad o propiedad de RentaTurista o terceros</li>
                        <li>En caso de fusión, adquisición o venta de activos de la empresa</li>
                    </ul>

                    <div class="highlight-box">
                        <h4>Importante</h4>
                        <p>Nunca vendemos tu información personal a terceros con fines publicitarios o comerciales.</p>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="lock" size="28"></i>
                        4. Protección de Datos
                    </h2>
                    
                    <p>Implementamos medidas de seguridad técnicas, administrativas y físicas para proteger tu información:</p>

                    <h3>4.1. Medidas Técnicas</h3>
                    <ul>
                        <li>Encriptación SSL/TLS para todas las transmisiones de datos</li>
                        <li>Encriptación de datos sensibles en reposo (información de pago, documentos)</li>
                        <li>Firewalls y sistemas de detección de intrusos</li>
                        <li>Autenticación de dos factores (2FA) disponible para usuarios</li>
                        <li>Monitoreo continuo de actividades sospechosas</li>
                    </ul>

                    <h3>4.2. Medidas Administrativas</h3>
                    <ul>
                        <li>Acceso limitado a información personal solo a empleados autorizados</li>
                        <li>Capacitación regular del personal en privacidad y seguridad de datos</li>
                        <li>Políticas estrictas de confidencialidad para todo el personal</li>
                        <li>Auditorías de seguridad periódicas</li>
                    </ul>

                    <h3>4.3. Almacenamiento de Datos</h3>
                    <ul>
                        <li>Los datos se almacenan en servidores seguros ubicados en Argentina y países con leyes de protección de datos adecuadas</li>
                        <li>Backups regulares con encriptación</li>
                        <li>Retención de datos solo durante el tiempo necesario para los fines descritos</li>
                    </ul>

                    <div class="info-box">
                        <i data-lucide="alert-circle" size="24"></i>
                        <div class="info-box-content">
                            <p><strong>Nota de Seguridad:</strong> Ningún sistema de seguridad es 100% infalible. Si bien implementamos las mejores prácticas de la industria, no podemos garantizar la seguridad absoluta de tu información. Te recomendamos usar contraseñas seguras y únicas, y nunca compartir tus credenciales de acceso.</p>
                        </div>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="user-check" size="28"></i>
                        5. Tus Derechos
                    </h2>
                    
                    <p>De acuerdo con la Ley de Protección de Datos Personales N° 25.326 de Argentina, tienes los siguientes derechos:</p>

                    <h3>5.1. Derecho de Acceso</h3>
                    <p>Puedes solicitar una copia de la información personal que tenemos sobre ti en cualquier momento.</p>

                    <h3>5.2. Derecho de Rectificación</h3>
                    <p>Puedes actualizar o corregir tu información personal si es inexacta o está desactualizada.</p>

                    <h3>5.3. Derecho de Supresión</h3>
                    <p>Puedes solicitar que eliminemos tu información personal, sujeto a ciertas excepciones legales (como registros de transacciones requeridos por ley).</p>

                    <h3>5.4. Derecho de Oposición</h3>
                    <p>Puedes oponerte al procesamiento de tu información personal para fines de marketing directo.</p>

                    <h3>5.5. Derecho de Portabilidad</h3>
                    <p>Puedes solicitar recibir tu información personal en un formato estructurado y de uso común.</p>

                    <h3>5.6. Derecho de Retiro de Consentimiento</h3>
                    <p>Puedes retirar tu consentimiento en cualquier momento para usos específicos de tu información.</p>

                    <h3>Cómo Ejercer tus Derechos</h3>
                    <p>Para ejercer cualquiera de estos derechos, contáctanos a través de:</p>
                    <ul>
                        <li><strong>Email:</strong> privacidad@rentaturista.com</li>
                        <li><strong>WhatsApp:</strong> +54 9 3541 123456</li>
                        <li><strong>Formulario web:</strong> Disponible en tu panel de usuario</li>
                    </ul>
                    <p>Responderemos a tu solicitud dentro de los 10 días hábiles establecidos por la legislación argentina.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="clock" size="28"></i>
                        6. Retención de Datos
                    </h2>
                    
                    <p>Conservamos tu información personal durante diferentes períodos según el tipo de datos:</p>
                    <ul>
                        <li><strong>Datos de cuenta activa:</strong> Mientras tu cuenta permanezca activa</li>
                        <li><strong>Historial de reservas:</strong> 10 años (requerimiento legal tributario en Argentina)</li>
                        <li><strong>Datos de verificación:</strong> 5 años después de la última transacción</li>
                        <li><strong>Datos de comunicación:</strong> 2 años para resolver disputas potenciales</li>
                        <li><strong>Datos de marketing:</strong> Hasta que retires tu consentimiento</li>
                    </ul>
                    <p>Después de estos períodos, eliminamos o anonimizamos tu información personal de forma segura.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="baby" size="28"></i>
                        7. Menores de Edad
                    </h2>
                    
                    <p>RentaTurista no está dirigido a menores de 18 años. No recopilamos intencionalmente información personal de menores sin el consentimiento de sus padres o tutores legales.</p>
                    <p>Si tienes conocimiento de que un menor ha proporcionado información personal sin consentimiento, contáctanos inmediatamente para que podamos eliminar dicha información.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="refresh-cw" size="28"></i>
                        8. Cambios a esta Política
                    </h2>
                    
                    <p>Podemos actualizar esta Política de Privacidad ocasionalmente para reflejar cambios en nuestras prácticas o por razones legales. Te notificaremos sobre cambios materiales a través de:</p>
                    <ul>
                        <li>Notificación por email a tu dirección registrada</li>
                        <li>Aviso destacado en la plataforma</li>
                        <li>Mensaje de WhatsApp (para cambios significativos)</li>
                    </ul>
                    <p>La fecha de "Última actualización" al inicio de este documento indica cuándo se realizó la última modificación.</p>
                </article>
            </section>

            <!-- TÉRMINOS Y CONDICIONES -->
            <section id="terminos" class="section">
                <div class="section-intro">
                    <p>Estos Términos y Condiciones rigen el uso de la plataforma RentaTurista y establecen los derechos y obligaciones entre RentaTurista (intermediario), los propietarios de propiedades y los huéspedes. Al usar nuestros servicios, aceptas estos términos en su totalidad.</p>
                </div>

                <article class="article">
                    <h2>
                        <i data-lucide="file-text" size="28"></i>
                        1. Definiciones
                    </h2>
                    
                    <ul>
                        <li><strong>"RentaTurista" o "Plataforma":</strong> Se refiere al servicio intermediario de alquileres vacacionales operado por [Razón Social], con domicilio en Villa Carlos Paz, Córdoba, Argentina.</li>
                        <li><strong>"Usuario":</strong> Cualquier persona que accede o utiliza la plataforma.</li>
                        <li><strong>"Propietario" o "Anfitrión":</strong> Usuario que publica propiedades para alquiler vacacional.</li>
                        <li><strong>"Huésped":</strong> Usuario que reserva alojamiento a través de la plataforma.</li>
                        <li><strong>"Propiedad":</strong> Inmueble ofrecido para alquiler vacacional temporal.</li>
                        <li><strong>"Reserva":</strong> Acuerdo de alojamiento entre propietario y huésped facilitado por la plataforma.</li>
                        <li><strong>"Servicios":</strong> Todas las funcionalidades proporcionadas por RentaTurista.</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="check-circle" size="28"></i>
                        2. Aceptación de Términos
                    </h2>
                    
                    <p>Al acceder y usar RentaTurista, declaras que:</p>
                    <ul>
                        <li>Tienes al menos 18 años de edad y capacidad legal para celebrar contratos vinculantes</li>
                        <li>Has leído, comprendido y aceptado estos Términos y Condiciones</li>
                        <li>Has leído y aceptado nuestra Política de Privacidad</li>
                        <li>Proporcionarás información veraz, exacta y actualizada</li>
                        <li>Usarás la plataforma de manera legal y conforme a estos términos</li>
                    </ul>

                    <div class="highlight-box">
                        <h4>Importante</h4>
                        <p>Si no aceptas estos términos, no debes usar la plataforma. El uso continuado de RentaTurista constituye tu aceptación de estos términos y cualquier modificación futura.</p>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="briefcase" size="28"></i>
                        3. Naturaleza del Servicio
                    </h2>
                    
                    <h3>3.1. Rol de RentaTurista como Intermediario</h3>
                    <p>RentaTurista actúa exclusivamente como intermediario/plataforma tecnológica que conecta propietarios con huéspedes. <strong>No somos propietarios de las propiedades ni somos parte del contrato de alquiler entre propietarios y huéspedes.</strong></p>

                    <h3>3.2. Responsabilidades de la Plataforma</h3>
                    <p>RentaTurista se compromete a:</p>
                    <ul>
                        <li>Proporcionar una plataforma segura y funcional para conectar usuarios</li>
                        <li>Verificar propiedades publicadas mediante inspecciones físicas</li>
                        <li>Facilitar el procesamiento de pagos de forma segura</li>
                        <li>Ofrecer asistencia al cliente 24/7 por WhatsApp y otros canales</li>
                        <li>Implementar medidas razonables de seguridad y prevención de fraudes</li>
                        <li>Proporcionar herramientas de comunicación entre usuarios</li>
                    </ul>

                    <h3>3.3. Limitaciones de Responsabilidad</h3>
                    <p>RentaTurista NO es responsable de:</p>
                    <ul>
                        <li>La exactitud de las descripciones de propiedades (responsabilidad del propietario)</li>
                        <li>La calidad, estado o condición de las propiedades</li>
                        <li>El cumplimiento de contratos de alquiler entre propietarios y huéspedes</li>
                        <li>Daños a propiedades o lesiones a personas durante la estadía</li>
                        <li>Pérdida de objetos personales en las propiedades</li>
                        <li>Disputas entre propietarios y huéspedes (aunque facilitamos la resolución)</li>
                        <li>Cumplimiento de regulaciones locales por parte de los propietarios</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="user-plus" size="28"></i>
                        4. Registro y Cuenta de Usuario
                    </h2>
                    
                    <h3>4.1. Creación de Cuenta</h3>
                    <p>Para usar ciertos servicios, debes crear una cuenta proporcionando:</p>
                    <ul>
                        <li>Nombre completo y fecha de nacimiento</li>
                        <li>Dirección de correo electrónico válida</li>
                        <li>Número de teléfono verificable</li>
                        <li>Documento de identidad (DNI o pasaporte)</li>
                        <li>Contraseña segura</li>
                    </ul>

                    <h3>4.2. Verificación de Identidad</h3>
                    <p>Podemos requerir verificación adicional de identidad antes de permitir reservas, incluyendo:</p>
                    <ul>
                        <li>Foto de documento de identidad</li>
                        <li>Selfie de verificación</li>
                        <li>Información adicional para prevenir fraudes</li>
                    </ul>

                    <h3>4.3. Seguridad de la Cuenta</h3>
                    <p>Eres responsable de:</p>
                    <ul>
                        <li>Mantener la confidencialidad de tus credenciales de acceso</li>
                        <li>Todas las actividades realizadas desde tu cuenta</li>
                        <li>Notificarnos inmediatamente sobre uso no autorizado</li>
                        <li>Actualizar tu información de contacto cuando cambie</li>
                    </ul>

                    <h3>4.4. Suspensión y Cancelación</h3>
                    <p>Podemos suspender o cancelar tu cuenta si:</p>
                    <ul>
                        <li>Violas estos Términos y Condiciones</li>
                        <li>Proporcionas información falsa o fraudulenta</li>
                        <li>Tienes comportamiento abusivo hacia otros usuarios o el personal</li>
                        <li>Usas la plataforma para actividades ilegales</li>
                        <li>Tienes múltiples cancelaciones o incumplimientos</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="home" size="28"></i>
                        5. Para Propietarios/Anfitriones
                    </h2>
                    
                    <h3>5.1. Publicación de Propiedades</h3>
                    <p>Los propietarios declaran y garantizan que:</p>
                    <ul>
                        <li>Tienen derecho legal para alquilar la propiedad (propietario o autorización del propietario)</li>
                        <li>La propiedad cumple con todas las regulaciones locales y códigos de construcción</li>
                        <li>Tienen todos los permisos necesarios para alquiler vacacional/turístico</li>
                        <li>La propiedad tiene seguros adecuados</li>
                        <li>Las descripciones, fotos y amenidades son exactas y actuales</li>
                    </ul>

                    <h3>5.2. Obligaciones del Propietario</h3>
                    <ul>
                        <li><strong>Descripción honesta:</strong> Proporcionar información veraz sobre la propiedad, ubicación, amenidades y reglas</li>
                        <li><strong>Disponibilidad precisa:</strong> Mantener actualizado el calendario de disponibilidad</li>
                        <li><strong>Respuesta oportuna:</strong> Responder solicitudes de reserva dentro de 24 horas</li>
                        <li><strong>Check-in puntual:</strong> Estar disponible para el check-in según lo acordado</li>
                        <li><strong>Mantenimiento:</strong> Mantener la propiedad en condiciones seguras y habitables</li>
                        <li><strong>Limpieza:</strong> Asegurar que la propiedad esté limpia antes de cada huésped</li>
                        <li><strong>Comunicación:</strong> Informar problemas o cambios a RentaTurista y al huésped</li>
                    </ul>

                    <h3>5.3. Precios y Tarifas</h3>
                    <ul>
                        <li>Los propietarios establecen sus propios precios de alquiler</li>
                        <li>Los precios deben incluir todos los impuestos aplicables</li>
                        <li>Pueden aplicarse tarifas adicionales (limpieza, mascotas, etc.) que deben estar claramente especificadas</li>
                        <li>RentaTurista cobra una comisión del [X]% sobre cada reserva confirmada</li>
                        <li>Los pagos se transfieren a los propietarios dentro de las 24-48 horas posteriores al check-in del huésped</li>
                    </ul>

                    <h3>5.4. Cancelaciones por Propietario</h3>
                    <p>Si un propietario cancela una reserva confirmada:</p>
                    <ul>
                        <li>Se reembolsará el 100% al huésped inmediatamente</li>
                        <li>RentaTurista intentará encontrar alojamiento alternativo similar</li>
                        <li>El propietario puede enfrentar penalizaciones o suspensión según las circunstancias</li>
                        <li>Cancelaciones frecuentes pueden resultar en eliminación de la plataforma</li>
                    </ul>

                    <h3>5.5. Inspecciones y Verificación</h3>
                    <p>RentaTurista se reserva el derecho de:</p>
                    <ul>
                        <li>Inspeccionar propiedades antes de aprobar publicaciones</li>
                        <li>Realizar inspecciones aleatorias de propiedades activas</li>
                        <li>Suspender publicaciones que no cumplan estándares de calidad</li>
                        <li>Requerir mejoras o actualizaciones para mantener la publicación activa</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="users" size="28"></i>
                        6. Para Huéspedes
                    </h2>
                    
                    <h3>6.1. Proceso de Reserva</h3>
                    <ul>
                        <li>Las reservas están sujetas a disponibilidad y confirmación del propietario</li>
                        <li>Al solicitar una reserva, aceptas las reglas específicas de la propiedad</li>
                        <li>El pago se procesa de forma segura a través de RentaTurista</li>
                        <li>Recibirás confirmación por email y WhatsApp una vez confirmada la reserva</li>
                    </ul>

                    <h3>6.2. Obligaciones del Huésped</h3>
                    <ul>
                        <li><strong>Número de ocupantes:</strong> No exceder el número máximo de personas permitido</li>
                        <li><strong>Cumplir reglas:</strong> Respetar las reglas de la casa establecidas por el propietario</li>
                        <li><strong>Cuidado de la propiedad:</strong> Tratar la propiedad con respeto y cuidado razonable</li>
                        <li><strong>Uso apropiado:</strong> Usar la propiedad solo para fines vacacionales/residenciales</li>
                        <li><strong>No subarrendar:</strong> No subarrendar ni transferir la reserva sin consentimiento</li>
                        <li><strong>Comunicación:</strong> Informar problemas al propietario y a RentaTurista</li>
                        <li><strong>Check-out:</strong> Dejar la propiedad en condiciones razonables según las instrucciones</li>
                    </ul>

                    <h3>6.3. Comportamiento Prohibido</h3>
                    <p>Los huéspedes NO pueden:</p>
                    <ul>
                        <li>Organizar fiestas o eventos no autorizados</li>
                        <li>Fumar en propiedades designadas como "No fumadores"</li>
                        <li>Traer mascotas a propiedades que no las permiten</li>
                        <li>Causar disturbios o molestias a vecinos</li>
                        <li>Dañar intencionalmente la propiedad o sus contenidos</li>
                        <li>Usar la propiedad para actividades ilegales</li>
                    </ul>

                    <h3>6.4. Daños y Responsabilidad</h3>
                    <ul>
                        <li>Los huéspedes son responsables de cualquier daño causado durante su estadía</li>
                        <li>Debes reportar daños accidentales inmediatamente</li>
                        <li>El propietario puede requerir un depósito de seguridad reembolsable</li>
                        <li>RentaTurista puede cobrar costos de reparación documentados</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="credit-card" size="28"></i>
                        7. Pagos y Facturación
                    </h2>
                    
                    <h3>7.1. Métodos de Pago Aceptados</h3>
                    <ul>
                        <li>Tarjetas de crédito/débito (Visa, Mastercard, American Express)</li>
                        <li>Transferencia bancaria</li>
                        <li>Efectivo (pesos argentinos o dólares blue, según acuerdo)</li>
                        <li>Criptomonedas (a través de HoodPay u otros procesadores autorizados)</li>
                        <li>Mercado Pago y otros métodos locales</li>
                    </ul>

                    <h3>7.2. Estructura de Costos</h3>
                    <p>El costo total de una reserva incluye:</p>
                    <ul>
                        <li><strong>Tarifa de alojamiento:</strong> Precio establecido por el propietario</li>
                        <li><strong>Tarifa de servicio:</strong> Comisión de RentaTurista (típicamente 10-15%)</li>
                        <li><strong>Tarifa de limpieza:</strong> Si aplica (establecida por propietario)</li>
                        <li><strong>Tarifas adicionales:</strong> Mascotas, huéspedes extra, etc.</li>
                        <li><strong>Impuestos:</strong> IVA y otros impuestos aplicables según legislación argentina</li>
                    </ul>

                    <h3>7.3. Procesamiento de Pagos</h3>
                    <ul>
                        <li>Los pagos se procesan de forma segura mediante proveedores certificados</li>
                        <li>RentaTurista retiene el pago hasta 24 horas después del check-in exitoso</li>
                        <li>Los propietarios reciben el pago (menos comisión) dentro de 24-48 horas post check-in</li>
                        <li>Los pagos están sujetos a verificación anti-fraude</li>
                    </ul>

                    <h3>7.4. Facturación</h3>
                    <ul>
                        <li>Se emiten facturas electrónicas conforme a regulaciones de AFIP</li>
                        <li>Los huéspedes reciben factura del total pagado</li>
                        <li>Los propietarios reciben factura de la comisión cobrada</li>
                        <li>Las facturas están disponibles en el panel de usuario</li>
                    </ul>

                    <h3>7.5. Reembolsos</h3>
                    <p>Los reembolsos se procesan según la política de cancelación aplicable y pueden tomar:</p>
                    <ul>
                        <li>Tarjetas de crédito/débito: 5-10 días hábiles</li>
                        <li>Transferencia bancaria: 3-5 días hábiles</li>
                        <li>Otros métodos: según términos del proveedor</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="shield-alert" size="28"></i>
                        8. Limitación de Responsabilidad
                    </h2>
                    
                    <h3>8.1. Exención de Garantías</h3>
                    <p>RentaTurista proporciona la plataforma "tal cual" y "según disponibilidad" sin garantías de ningún tipo, expresas o implícitas, incluyendo pero no limitado a:</p>
                    <ul>
                        <li>Garantías de comerciabilidad</li>
                        <li>Idoneidad para un propósito particular</li>
                        <li>No infracción</li>
                        <li>Funcionamiento ininterrumpido o libre de errores</li>
                    </ul>

                    <h3>8.2. Limitaciones Específicas</h3>
                    <p>En la máxima medida permitida por la ley argentina, RentaTurista NO será responsable por:</p>
                    <ul>
                        <li>Daños directos, indirectos, incidentales, especiales o consecuentes</li>
                        <li>Pérdida de beneficios, ingresos o datos</li>
                        <li>Interrupción del negocio</li>
                        <li>Daños personales o a la propiedad durante las estadías</li>
                        <li>Acciones u omisiones de propietarios, huéspedes u otros terceros</li>
                        <li>Contenido generado por usuarios</li>
                        <li>Fallas técnicas, errores o interrupciones del servicio</li>
                    </ul>

                    <h3>8.3. Límite Máximo de Responsabilidad</h3>
                    <p>En caso de que RentaTurista sea considerada responsable, nuestra responsabilidad total no excederá el monto de las tarifas de servicio pagadas en la transacción específica en cuestión, o AR$ 50,000 (pesos argentinos), lo que sea menor.</p>

                    <h3>8.4. Indemnización</h3>
                    <p>Aceptas indemnizar y eximir de responsabilidad a RentaTurista, sus directores, empleados y agentes de cualquier reclamo, daño, pérdida, responsabilidad o gasto (incluyendo honorarios legales) que surja de:</p>
                    <ul>
                        <li>Tu uso de la plataforma</li>
                        <li>Tu violación de estos Términos y Condiciones</li>
                        <li>Tu violación de derechos de terceros</li>
                        <li>Tu contenido o información proporcionada</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="scale" size="28"></i>
                        9. Resolución de Disputas
                    </h2>
                    
                    <h3>9.1. Proceso de Mediación</h3>
                    <p>En caso de disputa entre huésped y propietario:</p>
                    <ol>
                        <li>Contacta primero a la otra parte directamente para resolver el problema</li>
                        <li>Si no se resuelve, contacta a RentaTurista dentro de 24 horas</li>
                        <li>Nuestro equipo de mediación revisará evidencia de ambas partes</li>
                        <li>Proporcionaremos una recomendación o decisión dentro de 48-72 horas</li>
                        <li>La decisión de RentaTurista será vinculante para ambas partes</li>
                    </ol>

                    <h3>9.2. Evidencia Requerida</h3>
                    <p>Para disputas, proporciona:</p>
                    <ul>
                        <li>Fotografías o videos con timestamp</li>
                        <li>Capturas de pantalla de comunicaciones</li>
                        <li>Presupuestos de reparación (para daños)</li>
                        <li>Testimonios de testigos si aplica</li>
                        <li>Cualquier otra documentación relevante</li>
                    </ul>

                    <h3>9.3. Jurisdicción y Ley Aplicable</h3>
                    <ul>
                        <li>Estos términos se rigen por las leyes de la República Argentina</li>
                        <li>Cualquier disputa legal se someterá a los tribunales de Villa Carlos Paz, Córdoba, Argentina</li>
                        <li>Si alguna disposición es considerada inválida, las demás permanecen en vigor</li>
                    </ul>

                    <h3>9.4. Arbitraje (Opcional)</h3>
                    <p>Las partes pueden acordar someter disputas a arbitraje vinculante bajo las reglas del Tribunal de Arbitraje General de la Bolsa de Comercio de Córdoba, renunciando al derecho de acción judicial.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="shield-check" size="28"></i>
                        10. Propiedad Intelectual
                    </h2>
                    
                    <h3>10.1. Propiedad de RentaTurista</h3>
                    <p>Todo el contenido de la plataforma, incluyendo pero no limitado a:</p>
                    <ul>
                        <li>Diseño, código fuente y software</li>
                        <li>Logotipos, marcas registradas y marca RentaTurista</li>
                        <li>Textos, gráficos e imágenes de marketing</li>
                        <li>IA turística y algoritmos</li>
                    </ul>
                    <p>...son propiedad exclusiva de RentaTurista y están protegidos por leyes de propiedad intelectual argentinas e internacionales.</p>

                    <h3>10.2. Contenido de Usuarios</h3>
                    <p>Los usuarios retienen la propiedad de su contenido (fotos, descripciones, reseñas), pero otorgan a RentaTurista una licencia mundial, no exclusiva, libre de regalías para:</p>
                    <ul>
                        <li>Mostrar el contenido en la plataforma</li>
                        <li>Usar el contenido en materiales de marketing</li>
                        <li>Modificar o adaptar el contenido según sea necesario</li>
                        <li>Sublicenciar el contenido a socios comerciales</li>
                    </ul>

                    <h3>10.3. Restricciones de Uso</h3>
                    <p>No puedes:</p>
                    <ul>
                        <li>Copiar, reproducir o distribuir contenido de la plataforma</li>
                        <li>Usar scraping, bots o herramientas automatizadas</li>
                        <li>Modificar, adaptar o crear obras derivadas</li>
                        <li>Realizar ingeniería inversa del software</li>
                        <li>Usar la plataforma para crear un servicio competidor</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="file-check" size="28"></i>
                        11. Cumplimiento Legal
                    </h2>
                    
                    <h3>11.1. Obligaciones Fiscales</h3>
                    <p>Los propietarios son responsables de:</p>
                    <ul>
                        <li>Declarar ingresos por alquileres ante AFIP</li>
                        <li>Pagar impuestos correspondientes (Ganancias, Bienes Personales, etc.)</li>
                        <li>Emitir comprobantes fiscales cuando corresponda</li>
                        <li>Mantener registros contables apropiados</li>
                    </ul>

                    <h3>11.2. Regulaciones Locales</h3>
                    <p>Los propietarios deben:</p>
                    <ul>
                        <li>Cumplir con ordenanzas municipales de Villa Carlos Paz sobre alquileres turísticos</li>
                        <li>Obtener permisos/habilitaciones requeridas</li>
                        <li>Cumplir normas de seguridad contra incendios y construcción</li>
                        <li>Respetar reglamentos de consorcios/edificios</li>
                    </ul>

                    <h3>11.3. Protección al Consumidor</h3>
                    <p>RentaTurista cumple con la Ley de Defensa del Consumidor (N° 24.240) y facilita:</p>
                    <ul>
                        <li>Información clara sobre servicios y costos</li>
                        <li>Procesos de reclamo accesibles</li>
                        <li>Resolución justa de disputas</li>
                        <li>Reembolsos según corresponda</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="edit" size="28"></i>
                        12. Modificaciones de Términos
                    </h2>
                    
                    <p>RentaTurista se reserva el derecho de modificar estos Términos y Condiciones en cualquier momento. En caso de cambios:</p>
                    <ul>
                        <li>Notificaremos a usuarios registrados por email con 30 días de anticipación</li>
                        <li>Cambios materiales se destacarán en la plataforma</li>
                        <li>El uso continuado después de la fecha efectiva constituye aceptación</li>
                        <li>Si no aceptas los cambios, debes dejar de usar la plataforma</li>
                    </ul>
                    <p>Recomendamos revisar estos términos periódicamente para estar informado de cualquier actualización.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="x-circle" size="28"></i>
                        13. Terminación
                    </h2>
                    
                    <h3>13.1. Terminación por el Usuario</h3>
                    <p>Puedes cancelar tu cuenta en cualquier momento desde tu panel de usuario. Al hacerlo:</p>
                    <ul>
                        <li>Reservas futuras serán canceladas (sujeto a políticas de cancelación)</li>
                        <li>Propiedades publicadas serán removidas</li>
                        <li>Conservaremos datos según nuestra Política de Retención</li>
                        <li>No se reembolsarán tarifas de servicio ya pagadas</li>
                    </ul>

                    <h3>13.2. Terminación por RentaTurista</h3>
                    <p>Podemos suspender o terminar tu cuenta inmediatamente si:</p>
                    <ul>
                        <li>Violas estos Términos y Condiciones</li>
                        <li>Incurres en actividad fraudulenta</li>
                        <li>Recibes múltiples reportes negativos verificados</li>
                        <li>Representas un riesgo para otros usuarios</li>
                        <li>No pagas montos adeudados</li>
                    </ul>

                    <h3>13.3. Efectos de la Terminación</h3>
                    <ul>
                        <li>Pierdes acceso inmediato a la plataforma</li>
                        <li>Reservas activas pueden ser canceladas</li>
                        <li>Obligaciones financieras pendientes permanecen vigentes</li>
                        <li>Disposiciones sobre limitación de responsabilidad e indemnización sobreviven</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="info" size="28"></i>
                        14. Disposiciones Generales
                    </h2>
                    
                    <h3>14.1. Acuerdo Completo</h3>
                    <p>Estos Términos y Condiciones, junto con la Política de Privacidad y Política de Cancelación, constituyen el acuerdo completo entre tú y RentaTurista.</p>

                    <h3>14.2. Divisibilidad</h3>
                    <p>Si alguna disposición es considerada inválida o inaplicable, las demás disposiciones permanecerán en pleno vigor.</p>

                    <h3>14.3. Renuncia</h3>
                    <p>La falta de ejercicio de cualquier derecho no constituye una renuncia a ese derecho.</p>

                    <h3>14.4. Cesión</h3>
                    <p>No puedes ceder estos términos sin nuestro consentimiento escrito. RentaTurista puede ceder estos términos en caso de fusión, adquisición o venta de activos.</p>

                    <h3>14.5. Fuerza Mayor</h3>
                    <p>RentaTurista no será responsable por incumplimientos causados por circunstancias fuera de nuestro control razonable (desastres naturales, guerra, pandemias, huelgas, fallas de infraestructura, etc.).</p>

                    <h3>14.6. Notificaciones</h3>
                    <p>Todas las notificaciones se enviarán a la dirección de email o teléfono registrado. Es tu responsabilidad mantener esta información actualizada.</p>
                </article>
            </section>

            <!-- POLÍTICA DE COOKIES -->
            <section id="cookies" class="section">
                <div class="section-intro">
                    <p>Esta Política de Cookies explica qué son las cookies, cómo las usamos en RentaTurista, y cómo puedes controlar su uso. Al usar nuestra plataforma, aceptas el uso de cookies según se describe aquí.</p>
                </div>

                <article class="article">
                    <h2>
                        <i data-lucide="cookie" size="28"></i>
                        1. ¿Qué son las Cookies?
                    </h2>
                    
                    <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo (computadora, smartphone, tablet) cuando visitas un sitio web. Permiten que el sitio recuerde tus acciones y preferencias durante un período de tiempo.</p>

                    <h3>Tipos de Cookies según Duración</h3>
                    <ul>
                        <li><strong>Cookies de sesión:</strong> Se eliminan cuando cierras el navegador</li>
                        <li><strong>Cookies persistentes:</strong> Permanecen en tu dispositivo por un período determinado o hasta que las elimines manualmente</li>
                    </ul>

                    <h3>Tipos de Cookies según Origen</h3>
                    <ul>
                        <li><strong>Cookies propias:</strong> Establecidas directamente por RentaTurista</li>
                        <li><strong>Cookies de terceros:</strong> Establecidas por servicios externos que usamos (Google Analytics, redes sociales, etc.)</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="list-checks" size="28"></i>
                        2. Cookies que Utilizamos
                    </h2>
                    
                    <h3>2.1. Cookies Estrictamente Necesarias</h3>
                    <p>Estas cookies son esenciales para el funcionamiento de la plataforma y no pueden desactivarse:</p>
                    <ul>
                        <li><strong>Autenticación:</strong> Para mantener tu sesión activa cuando inicias sesión</li>
                        <li><strong>Seguridad:</strong> Para prevenir fraudes y ataques cibernéticos</li>
                        <li><strong>Carrito de compras:</strong> Para recordar las reservas en proceso</li>
                        <li><strong>Preferencias de usuario:</strong> Idioma, moneda, configuraciones básicas</li>
                    </ul>

                    <h3>2.2. Cookies de Rendimiento y Análisis</h3>
                    <p>Estas cookies nos ayudan a entender cómo los usuarios interactúan con la plataforma:</p>
                    <ul>
                        <li><strong>Google Analytics:</strong> Análisis de tráfico, páginas visitadas, tiempo de permanencia</li>
                        <li><strong>Métricas de rendimiento:</strong> Velocidad de carga, errores técnicos</li>
                        <li><strong>Pruebas A/B:</strong> Para mejorar la experiencia de usuario</li>
                    </ul>
                    <p><em>Puedes desactivar estas cookies sin afectar la funcionalidad básica.</em></p>

                    <h3>2.3. Cookies de Funcionalidad</h3>
                    <p>Estas cookies permiten funciones mejoradas y personalización:</p>
                    <ul>
                        <li><strong>Personalización:</strong> Recordar tus búsquedas recientes y preferencias</li>
                        <li><strong>Localización:</strong> Mostrar propiedades relevantes según tu ubicación</li>
                        <li><strong>Videos:</strong> Funcionalidad de reproductores de video incrustados</li>
                        <li><strong>Chat en vivo:</strong> Historial de conversaciones con asistencia</li>
                    </ul>

                    <h3>2.4. Cookies de Marketing y Publicidad</h3>
                    <p>Estas cookies se usan para mostrarte anuncios relevantes:</p>
                    <ul>
                        <li><strong>Remarketing:</strong> Facebook Pixel, Google Ads para mostrar anuncios personalizados</li>
                        <li><strong>Redes sociales:</strong> Botones de compartir, widgets de redes sociales</li>
                        <li><strong>Seguimiento de conversiones:</strong> Medir efectividad de campañas publicitarias</li>
                    </ul>
                    <p><em>Puedes desactivar estas cookies en tus preferencias.</em></p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="settings" size="28"></i>
                        3. Cómo Controlar las Cookies
                    </h2>
                    
                    <h3>3.1. Panel de Preferencias de RentaTurista</h3>
                    <p>Puedes gestionar tus preferencias de cookies en cualquier momento desde:</p>
                    <ul>
                        <li>El banner de cookies que aparece en tu primera visita</li>
                        <li>Configuración de cuenta → Privacidad y Cookies</li>
                        <li>El enlace en el pie de página de cualquier página</li>
                    </ul>

                    <h3>3.2. Configuración del Navegador</h3>
                    <p>Todos los navegadores permiten bloquear cookies. Consulta la ayuda de tu navegador:</p>
                    <ul>
                        <li><strong>Google Chrome:</strong> Configuración → Privacidad y seguridad → Cookies</li>
                        <li><strong>Firefox:</strong> Opciones → Privacidad y seguridad → Cookies</li>
                        <li><strong>Safari:</strong> Preferencias → Privacidad → Cookies</li>
                        <li><strong>Edge:</strong> Configuración → Privacidad → Cookies</li>
                    </ul>

                    <div class="info-box">
                        <i data-lucide="alert-triangle" size="24"></i>
                        <div class="info-box-content">
                            <p><strong>Advertencia:</strong> Bloquear todas las cookies puede afectar la funcionalidad de la plataforma, impidiendo que puedas iniciar sesión, realizar reservas o usar ciertas características.</p>
                        </div>
                    </div>

                    <h3>3.3. Herramientas de Exclusión de Terceros</h3>
                    <ul>
                        <li><strong>Google Analytics:</strong> <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">Plugin de exclusión</a></li>
                        <li><strong>Network Advertising Initiative:</strong> <a href="http://optout.networkadvertising.org/" target="_blank">Herramienta de exclusión</a></li>
                        <li><strong>Your Online Choices:</strong> <a href="http://www.youronlinechoices.com/" target="_blank">Portal europeo</a></li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="table" size="28"></i>
                        4. Lista Detallada de Cookies
                    </h2>
                    
                    <div class="info-box">
                        <i data-lucide="info" size="24"></i>
                        <div class="info-box-content">
                            <p>A continuación se presenta una lista de las principales cookies utilizadas en RentaTurista:</p>
                        </div>
                    </div>

                    <h3>Cookies Propias</h3>
                    <ul>
                        <li><strong>rt_session:</strong> Cookie de sesión (necesaria) - Expira al cerrar navegador</li>
                        <li><strong>rt_auth:</strong> Token de autenticación (necesaria) - 30 días</li>
                        <li><strong>rt_preferences:</strong> Preferencias de usuario (funcionalidad) - 1 año</li>
                        <li><strong>rt_lang:</strong> Idioma seleccionado (funcionalidad) - 1 año</li>
                        <li><strong>rt_currency:</strong> Moneda preferida (funcionalidad) - 1 año</li>
                        <li><strong>rt_recent_searches:</strong> Búsquedas recientes (funcionalidad) - 30 días</li>
                    </ul>

                    <h3>Cookies de Terceros - Análisis</h3>
                    <ul>
                        <li><strong>_ga, _gid:</strong> Google Analytics (rendimiento) - 2 años / 24 horas</li>
                        <li><strong>_gat:</strong> Google Analytics (rendimiento) - 1 minuto</li>
                    </ul>

                    <h3>Cookies de Terceros - Marketing</h3>
                    <ul>
                        <li><strong>_fbp:</strong> Facebook Pixel (marketing) - 3 meses</li>
                        <li><strong>fr:</strong> Facebook (marketing) - 3 meses</li>
                        <li><strong>IDE:</strong> Google DoubleClick (marketing) - 1 año</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="refresh-cw" size="28"></i>
                        5. Actualizaciones
                    </h2>
                    
                    <p>Podemos actualizar esta Política de Cookies ocasionalmente para reflejar cambios en las cookies que usamos o por razones operativas, legales o regulatorias.</p>
                    <p>Revisa esta política periódicamente para estar informado sobre cómo usamos las cookies. La fecha de "Última actualización" indica cuándo se modificó por última vez.</p>
                </article>
            </section>

            <!-- CANCELACIÓN Y REEMBOLSOS -->
            <section id="cancelacion" class="section">
                <div class="section-intro">
                    <p>Esta política describe las condiciones de cancelación y reembolso para reservas realizadas a través de RentaTurista. Lee cuidadosamente antes de realizar una reserva, ya que las políticas varían según la propiedad y circunstancias.</p>
                </div>

                <article class="article">
                    <h2>
                        <i data-lucide="calendar-x" size="28"></i>
                        1. Políticas de Cancelación por Huéspedes
                    </h2>
                    
                    <p>Los propietarios pueden elegir entre tres tipos de políticas de cancelación. La política aplicable a cada propiedad se muestra claramente antes de confirmar la reserva.</p>

                    <h3>1.1. Política Flexible</h3>
                    <div class="highlight-box">
                        <h4>Reembolso Completo (100%)</h4>
                        <ul>
                            <li>Cancelación hasta 24 horas antes del check-in</li>
                            <li>Se reembolsa el total del alojamiento</li>
                            <li>La tarifa de servicio de RentaTurista NO es reembolsable</li>
                        </ul>
                    </div>
                    <ul>
                        <li><strong>Menos de 24 horas antes:</strong> No hay reembolso</li>
                        <li><strong>No presentación (No-show):</strong> No hay reembolso</li>
                        <li><strong>Procesamiento:</strong> Reembolso en 5-10 días hábiles</li>
                    </ul>

                    <h3>1.2. Política Moderada</h3>
                    <div class="highlight-box">
                        <h4>Reembolso según Anticipación</h4>
                        <ul>
                            <li><strong>5+ días antes:</strong> Reembolso del 100% del alojamiento</li>
                            <li><strong>2-4 días antes:</strong> Reembolso del 50% del alojamiento</li>
                            <li><strong>Menos de 48 horas:</strong> No hay reembolso</li>
                        </ul>
                    </div>
                    <ul>
                        <li>La tarifa de servicio NO es reembolsable en ningún caso</li>
                        <li>Tarifas de limpieza se reembolsan si se cancela con 5+ días</li>
                        <li><strong>Procesamiento:</strong> Reembolso en 7-14 días hábiles</li>
                    </ul>

                    <h3>1.3. Política Estricta</h3>
                    <div class="highlight-box">
                        <h4>Reembolso Limitado</h4>
                        <ul>
                            <li><strong>7+ días antes:</strong> Reembolso del 50% del alojamiento</li>
                            <li><strong>Menos de 7 días:</strong> No hay reembolso</li>
                        </ul>
                    </div>
                    <ul>
                        <li>Esta política se usa típicamente en temporada alta o propiedades premium</li>
                        <li>La tarifa de servicio NUNCA es reembolsable</li>
                        <li>Sin excepciones por circunstancias personales</li>
                        <li><strong>Procesamiento:</strong> Reembolso en 7-14 días hábiles</li>
                    </ul>

                    <div class="info-box">
                        <i data-lucide="calendar" size="24"></i>
                        <div class="info-box-content">
                            <p><strong>Cómo se Calculan los Plazos:</strong> Los plazos de cancelación se calculan en base a la hora local de check-in en Villa Carlos Paz. El "día" comienza a las 00:00 y termina a las 23:59 hora argentina.</p>
                        </div>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="rotate-ccw" size="28"></i>
                        2. Proceso de Cancelación
                    </h2>
                    
                    <h3>2.1. Cómo Cancelar tu Reserva</h3>
                    <ol>
                        <li>Inicia sesión en tu cuenta de RentaTurista</li>
                        <li>Ve a "Mis Reservas" o "Viajes"</li>
                        <li>Selecciona la reserva que deseas cancelar</li>
                        <li>Haz clic en "Cancelar Reserva"</li>
                        <li>Revisa el monto del reembolso según la política aplicable</li>
                        <li>Confirma la cancelación</li>
                        <li>Recibirás un email de confirmación de cancelación</li>
                    </ol>

                    <h3>2.2. Notificación al Propietario</h3>
                    <ul>
                        <li>El propietario es notificado automáticamente de tu cancelación</li>
                        <li>La propiedad vuelve a estar disponible en el calendario</li>
                        <li>El propietario NO recibe información sobre el motivo de la cancelación</li>
                    </ul>

                    <h3>2.3. Confirmación y Documentación</h3>
                    <ul>
                        <li>Recibes email de confirmación de cancelación inmediatamente</li>
                        <li>El email incluye detalles del reembolso (si aplica)</li>
                        <li>Puedes descargar un comprobante de cancelación desde tu cuenta</li>
                        <li>La factura original se marca como "CANCELADA"</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="dollar-sign" size="28"></i>
                        3. Reembolsos
                    </h2>
                    
                    <h3>3.1. Qué se Reembolsa</h3>
                    <p>Según la política de cancelación aplicable, pueden reembolsarse:</p>
                    <ul>
                        <li><strong>Tarifa de alojamiento:</strong> Parcial o totalmente según política</li>
                        <li><strong>Tarifa de limpieza:</strong> Solo si se cancela con suficiente anticipación</li>
                        <li><strong>Tarifas adicionales:</strong> (mascotas, huéspedes extra) según corresponda</li>
                    </ul>

                    <h3>3.2. Qué NO se Reembolsa</h3>
                    <ul>
                        <li><strong>Tarifa de servicio de RentaTurista:</strong> NUNCA es reembolsable (cubre costos administrativos)</li>
                        <li><strong>Impuestos retenidos:</strong> Según legislación fiscal argentina</li>
                    </ul>

                    <h3>3.3. Métodos de Reembolso</h3>
                    <p>Los reembolsos se procesan mediante el mismo método de pago original:</p>
                    <ul>
                        <li><strong>Tarjeta de crédito/débito:</strong> 5-10 días hábiles (según banco)</li>
                        <li><strong>Transferencia bancaria:</strong> 3-5 días hábiles</li>
                        <li><strong>Mercado Pago:</strong> 5-7 días hábiles</li>
                        <li><strong>Efectivo/Criptomonedas:</strong> Se coordinará transferencia bancaria</li>
                    </ul>

                    <h3>3.4. Cupones de Crédito (Opcional)</h3>
                    <p>En algunos casos, puedes optar por recibir un cupón de crédito en lugar de reembolso:</p>
                    <ul>
                        <li><strong>Ventaja:</strong> Recibes un 10% adicional del monto reembolsable</li>
                        <li><strong>Validez:</strong> 12 meses desde la emisión</li>
                        <li><strong>Uso:</strong> Aplicable a cualquier propiedad en RentaTurista</li>
                        <li><strong>Transferible:</strong> Puedes compartirlo con amigos/familia</li>
                    </ul>

                    <div class="highlight-box">
                        <h4>Ejemplo de Reembolso</h4>
                        <p><strong>Reserva original:</strong></p>
                        <ul>
                            <li>Alojamiento: AR$ 80,000</li>
                            <li>Limpieza: AR$ 5,000</li>
                            <li>Tarifa de servicio: AR$ 12,000</li>
                            <li><strong>Total pagado: AR$ 97,000</strong></li>
                        </ul>
                        <p><strong>Cancelación con política Moderada, 3 días antes:</strong></p>
                        <ul>
                            <li>Reembolso de alojamiento (50%): AR$ 40,000</li>
                            <li>Reembolso de limpieza: AR$ 0 (solo con 5+ días)</li>
                            <li>Tarifa de servicio: No reembolsable</li>
                            <li><strong>Total reembolsado: AR$ 40,000</strong></li>
                        </ul>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="home-minus" size="28"></i>
                        4. Cancelaciones por Propietarios
                    </h2>
                    
                    <h3>4.1. Política de Cancelación del Propietario</h3>
                    <p>Si un propietario cancela una reserva confirmada:</p>
                    <ul>
                        <li><strong>Reembolso inmediato:</strong> 100% del monto pagado (incluyendo tarifa de servicio)</li>
                        <li><strong>Asistencia prioritaria:</strong> Nuestro equipo te ayudará a encontrar alojamiento alternativo similar</li>
                        <li><strong>Compensación:</strong> Cupón de AR$ 10,000 para tu próxima reserva</li>
                        <li><strong>Crédito adicional:</strong> Si no podemos encontrar alternativa comparable, AR$ 20,000 adicionales</li>
                    </ul>

                    <h3>4.2. Penalizaciones al Propietario</h3>
                    <p>Los propietarios que cancelen enfrentan:</p>
                    <ul>
                        <li>Pérdida de la comisión que hubieran recibido</li>
                        <li>Bloqueo del calendario por 7 días (periodo cancelado)</li>
                        <li>Reducción en visibilidad de búsquedas</li>
                        <li>Marca de "Ha cancelado reservas" en su perfil</li>
                        <li>Suspensión temporal o permanente en caso de cancelaciones frecuentes</li>
                    </ul>

                    <h3>4.3. Excepciones Justificadas</h3>
                    <p>No se aplican penalizaciones si la cancelación se debe a:</p>
                    <ul>
                        <li>Emergencias familiares graves (con documentación)</li>
                        <li>Daños severos a la propiedad por causas de fuerza mayor</li>
                        <li>Problemas de seguridad documentados</li>
                        <li>Orden judicial o gubernamental</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="cloud-lightning" size="28"></i>
                        5. Circunstancias Especiales
                    </h2>
                    
                    <h3>5.1. Circunstancias Extenuantes</h3>
                    <p>RentaTurista puede permitir cancelaciones con reembolso completo en casos excepcionales:</p>
                    
                    <h4>Eventos Cubiertos:</h4>
                    <ul>
                        <li><strong>Emergencias médicas:</strong> Hospitalización del huésped o familiar directo (requiere documentación médica)</li>
                        <li><strong>Desastres naturales:</strong> Que afecten Villa Carlos Paz o la ciudad de origen del huésped</li>
                        <li><strong>Pandemias:</strong> Restricciones gubernamentales de viaje</li>
                        <li><strong>Fallecimiento:</strong> Del huésped o familiar inmediato (requiere certificado de defunción)</li>
                        <li><strong>Orden judicial:</strong> Citaciones obligatorias que impidan el viaje</li>
                        <li><strong>Emergencias gubernamentales:</strong> Estados de emergencia oficiales</li>
                    </ul>

                    <h4>Documentación Requerida:</h4>
                    <ul>
                        <li>Contacta a RentaTurista dentro de 24 horas de la circunstancia</li>
                        <li>Proporciona documentación oficial (certificados médicos, órdenes judiciales, etc.)</li>
                        <li>Nuestro equipo revisará el caso en 24-48 horas</li>
                        <li>Si se aprueba, recibirás reembolso completo en 5-7 días hábiles</li>
                    </ul>

                    <h3>5.2. Modificaciones de Reserva</h3>
                    <p>En lugar de cancelar, puedes solicitar modificar tu reserva:</p>
                    
                    <h4>Cambios de Fecha:</h4>
                    <ul>
                        <li>Sujeto a disponibilidad del calendario del propietario</li>
                        <li>Sin costo si se solicita con 7+ días de anticipación</li>
                        <li>Puede aplicar diferencia de tarifa si las nuevas fechas son más caras</li>
                        <li>Las fechas nuevas deben ser dentro de los próximos 12 meses</li>
                    </ul>

                    <h4>Cambio de Número de Huéspedes:</h4>
                    <ul>
                        <li>Reducir número: Generalmente permitido sin costo</li>
                        <li>Aumentar número: Requiere aprobación del propietario y puede tener costo adicional</li>
                        <li>No puede exceder la capacidad máxima de la propiedad</li>
                    </ul>

                    <h3>5.3. Acortamiento de Estadía</h3>
                    <p>Si decides salir antes de la fecha de check-out programada:</p>
                    <ul>
                        <li>No hay reembolso por las noches no utilizadas</li>
                        <li>Debes notificar al propietario de tu salida anticipada</li>
                        <li>Excepción: Problemas graves con la propiedad (ver sección 6)</li>
                    </ul>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="shield-alert" size="28"></i>
                        6. Problemas Durante la Estadía
                    </h2>
                    
                    <h3>6.1. Propiedad No Cumple lo Anunciado</h3>
                    <p>Si la propiedad tiene problemas significativos que no fueron divulgados:</p>
                    
                    <h4>Paso 1 - Documentar y Reportar:</h4>
                    <ul>
                        <li>Documenta el problema con fotos/videos con timestamp</li>
                        <li>Contacta al propietario inmediatamente</li>
                        <li>Reporta a RentaTurista dentro de 24 horas del check-in</li>
                    </ul>

                    <h4>Paso 2 - Resolución:</h4>
                    <ul>
                        <li>Damos al propietario 4 horas para resolver problemas menores</li>
                        <li>Problemas graves (sin agua, sin electricidad, peligro de seguridad): resolución inmediata</li>
                    </ul>

                    <h4>Paso 3 - Reubicación o Reembolso:</h4>
                    <p>Si el problema no se resuelve:</p>
                    <ul>
                        <li>RentaTurista te reubica en propiedad alternativa de igual o mayor categoría</li>
                        <li>Si prefieres cancelar: reembolso completo + compensación de AR$ 15,000</li>
                        <li>Cubrimos costos de alojamiento alternativo por esa noche si no podemos encontrar opción inmediata</li>
                    </ul>

                    <h3>6.2. Problemas Cubiertos</h3>
                    <ul>
                        <li><strong>Salud y seguridad:</strong> Peligros, plagas, toxinas, falta de cerraduras funcionales</li>
                        <li><strong>Limpieza:</strong> Propiedad sucia, infestaciones, malos olores persistentes</li>
                        <li><strong>Amenidades esenciales:</strong> Sin agua, electricidad, calefacción/AC (según temporada)</li>
                        <li><strong>Acceso:</strong> Imposibilidad de ingresar, códigos/llaves incorrectos</li>
                        <li><strong>Descripción falsa:</strong> Discrepancias significativas con el anuncio (habitaciones, camas, baños)</li>
                    </ul>

                    <h3>6.3. Qué NO Está Cubierto</h3>
                    <ul>
                        <li>Preferencias personales o expectativas no razonables</li>
                        <li>Problemas menores de mantenimiento que no afectan uso básico</li>
                        <li>Ruido normal del vecindario o tráfico</li>
                        <li>Clima o condiciones naturales</li>
                        <li>Problemas que el propietario está activamente resolviendo</li>
                    </ul>

                    <div class="info-box">
                        <i data-lucide="phone" size="24"></i>
                        <div class="info-box-content">
                            <p><strong>Soporte de Emergencia 24/7:</strong> En caso de problemas graves durante tu estadía, contacta nuestro WhatsApp de emergencias al +54 9 3541 123456. Respondemos en menos de 15 minutos.</p>
                        </div>
                    </div>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="umbrella" size="28"></i>
                        7. Seguro de Viaje (Recomendado)
                    </h2>
                    
               <p>Aunque RentaTurista ofrece políticas de cancelación flexibles, te recomendamos encarecidamente contratar un seguro de viaje que cubra:</p>
                    
                    <ul>
                        <li><strong>Cancelación de viaje:</strong> Por razones médicas u otras emergencias</li>
                        <li><strong>Interrupción de viaje:</strong> Si debes regresar antes</li>
                        <li><strong>Emergencias médicas:</strong> Durante tu estadía</li>
                        <li><strong>Pérdida de equipaje:</strong> O pertenencias personales</li>
                        <li><strong>Responsabilidad civil:</strong> Por daños a terceros</li>
                    </ul>

                    <p><strong>Nota:</strong> RentaTurista no ofrece seguros de viaje pero podemos recomendar proveedores confiables. Contacta a nuestro equipo de asistencia para más información.</p>
                </article>

                <article class="article">
                    <h2>
                        <i data-lucide="message-square-question" size="28"></i>
                        8. Preguntas Frecuentes
                    </h2>
                    
                    <h3>¿Puedo cancelar una reserva instantánea?</h3>
                    <p>Sí, las reservas instantáneas siguen la misma política de cancelación que la propiedad tiene establecida. Verifica la política antes de confirmar.</p>

                    <h3>¿Qué pasa si el propietario no responde?</h3>
                    <p>Si el propietario no responde dentro de 24 horas de tu mensaje, contacta a RentaTurista. Intervendremos para facilitar la comunicación o ayudarte a encontrar una alternativa.</p>

                    <h3>¿Puedo obtener reembolso parcial si salgo antes?</h3>
                    <p>No, excepto en casos de problemas graves con la propiedad documentados y verificados por RentaTurista.</p>

                    <h3>¿Se reembolsa la tarifa de servicio en algún caso?</h3>
                    <p>Solo si el propietario cancela la reserva o en circunstancias extenuantes aprobadas por RentaTurista (desastres naturales, pandemias, etc.).</p>

                    <h3>¿Cómo se calculan los reembolsos en dólares?</h3>
                    <p>Si pagaste en dólares, el reembolso se procesa en dólares usando el tipo de cambio original de la transacción.</p>

                    <h3>¿Puedo transferir mi reserva a otra persona?</h3>
                    <p>Sí, pero requiere aprobación del propietario. Contacta a RentaTurista para coordinar la transferencia.</p>

                    <h3>¿Qué pasa con las reservas de largo plazo (28+ días)?</h3>
                    <p>Las reservas de 28 noches o más pueden tener términos de cancelación especiales. Consulta con el propietario antes de reservar.</p>
                </article>
            </section>

            <!-- Contact Section -->
            <div class="contact-section">
                <h3>¿Tienes Preguntas?</h3>
                <p>Nuestro equipo está disponible para ayudarte con cualquier consulta sobre nuestras políticas</p>
                
                <div class="contact-buttons">
                    <a href="https://wa.me/5493541123456" class="contact-btn contact-btn-primary" target="_blank" rel="noopener">
                        <i data-lucide="message-circle" size="20"></i>
                        WhatsApp 24/7
                    </a>
                    <a href="mailto:ayuda@rentaturista.com" class="contact-btn contact-btn-secondary">
                        <i data-lucide="mail" size="20"></i>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 RentaTurista. Todos los derechos reservados.</p>
            <p>
                <a href="index.php">Volver al inicio</a> | 
                <a href="#privacidad">Privacidad</a> | 
                <a href="#terminos">Términos</a> | 
                <a href="#cookies">Cookies</a>
            </p>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Tab navigation
            const tabs = document.querySelectorAll('.tab');
            const sections = document.querySelectorAll('.section');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs and sections
                    tabs.forEach(t => t.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const sectionId = this.dataset.section;
                    const targetSection = document.getElementById(sectionId);
                    if (targetSection) {
                        targetSection.classList.add('active');
                        
                        // Scroll to top of content
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Handle hash navigation on page load
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const tab = document.querySelector(`[data-section="${hash}"]`);
                if (tab) {
                    tab.click();
                }
            }

            // Update URL hash when tab is clicked
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const sectionId = this.dataset.section;
                    history.pushState(null, null, `#${sectionId}`);
                });
            });
        });

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>