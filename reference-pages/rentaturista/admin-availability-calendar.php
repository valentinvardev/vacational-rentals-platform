<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Disponibilidad - RentaTurista Admin</title>
    
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

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Property Selector */
        .property-selector {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .property-selector select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .property-selector select:focus {
            outline: none;
            border-color: var(--orange-primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        /* Calendar Grid */
        .calendar-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .calendar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .calendar-nav button {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid var(--orange-primary);
            color: var(--orange-primary);
            border-radius: 12px;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-nav button:hover {
            background: var(--orange-primary);
            color: var(--white);
        }

        .calendar-month {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 700;
            color: var(--gray-600);
            padding: 1rem 0;
            font-size: 0.9rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem;
        }

        .calendar-day:hover:not(.disabled) {
            border-color: var(--orange-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .calendar-day.today {
            border-color: var(--info);
            background: rgba(59, 130, 246, 0.05);
        }

        .calendar-day.available {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--success);
        }

        .calendar-day.booked {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
            cursor: not-allowed;
        }

        .calendar-day.blocked {
            background: rgba(158, 158, 158, 0.1);
            border-color: var(--gray-400);
        }

        .calendar-day.selected {
            background: var(--orange-bg);
            border-color: var(--orange-primary);
            border-width: 3px;
        }

        .calendar-day.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Special price indicator */
        .calendar-day.special-price::before {
            content: '★';
            position: absolute;
            top: 0.25rem;
            left: 0.25rem;
            font-size: 0.85rem;
            color: var(--warning);
            font-weight: bold;
        }

        .day-number {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .day-price {
            font-size: 0.75rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .day-price.special {
            color: var(--warning);
            font-weight: 700;
        }

        .day-status {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .day-status.available {
            background: var(--success);
        }

        .day-status.booked {
            background: var(--danger);
        }

        .day-status.blocked {
            background: var(--gray-500);
        }

        /* Legend */
        .calendar-legend {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid;
        }

        /* Actions Panel */
        .actions-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(101, 67, 33, 0.1);
            border-radius: 20px;
            padding: 2rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .action-btn {
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

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--orange-glow);
        }

        .action-btn.secondary {
            background: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
            border: 2px solid var(--orange-primary);
        }

        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
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
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gray-900);
        }

        .modal-close {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-600);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid var(--gray-300);
            border-radius: 12px;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--orange-primary);
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-container">
            <div class="header-left">
                <a href="admin-properties.php" class="back-btn">
                    <i data-lucide="arrow-left" size="20"></i>
                </a>
                <h1 class="page-title">Calendario de Disponibilidad</h1>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Property Selector -->
        <div class="property-selector">
            <select id="propertySelect">
                <option value="">Cargando propiedades...</option>
            </select>
        </div>

        <!-- Calendar -->
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button onclick="previousMonth()">
                        <i data-lucide="chevron-left" size="20"></i>
                    </button>
                    <h2 class="calendar-month" id="calendarMonth"></h2>
                    <button onclick="nextMonth()">
                        <i data-lucide="chevron-right" size="20"></i>
                    </button>
                </div>
                <button class="action-btn secondary" onclick="location.reload()">
                    <i data-lucide="refresh-cw" size="18"></i>
                    Actualizar
                </button>
            </div>

            <div class="calendar-grid" id="calendarGrid"></div>

            <div class="calendar-legend">
                <div class="legend-item">
                    <div class="legend-color available" style="background: rgba(16, 185, 129, 0.1); border-color: #10B981;"></div>
                    <span>Disponible</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color booked" style="background: rgba(239, 68, 68, 0.1); border-color: #EF4444;"></div>
                    <span>Reservado</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color blocked" style="background: rgba(158, 158, 158, 0.1); border-color: #9E9E9E;"></div>
                    <span>Bloqueado</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="border-color: #3B82F6;"></div>
                    <span>Hoy</span>
                </div>
                <div class="legend-item">
                    <span style="color: var(--warning); font-weight: bold;">★</span>
                    <span>Precio Especial</span>
                </div>
            </div>
        </div>

        <!-- Actions Panel -->
        <div class="actions-panel">
            <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Acciones Rápidas</h3>
            <div class="actions-grid">
                <button class="action-btn" onclick="openBlockModal()" id="blockBtn" disabled>
                    <i data-lucide="lock" size="18"></i>
                    Bloquear Seleccionados
                </button>
                <button class="action-btn secondary" onclick="openUnblockModal()" id="unblockBtn" disabled>
                    <i data-lucide="unlock" size="18"></i>
                    Liberar Seleccionados
                </button>
                <button class="action-btn" onclick="openPricingModal()" id="pricingBtn" disabled>
                    <i data-lucide="dollar-sign" size="18"></i>
                    Precio Especial
                </button>
                <button class="action-btn secondary" onclick="clearSelection()">
                    <i data-lucide="x" size="18"></i>
                    Limpiar Selección
                </button>
            </div>
        </div>
    </main>

    <!-- Block Modal -->
    <div class="modal" id="blockModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Bloquear Fechas</h3>
                <button class="modal-close" onclick="closeModal('blockModal')">
                    <i data-lucide="x" size="24"></i>
                </button>
            </div>
            <div class="form-group">
                <label class="form-label">Motivo (opcional)</label>
                <input type="text" class="form-input" id="blockNotes" placeholder="Ej: Mantenimiento, Personal">
            </div>
            <div class="modal-actions">
                <button class="action-btn" onclick="confirmBlock()">Confirmar</button>
                <button class="action-btn secondary" onclick="closeModal('blockModal')">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Pricing Modal -->
    <div class="modal" id="pricingModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Establecer Precio Especial</h3>
                <button class="modal-close" onclick="closeModal('pricingModal')">
                    <i data-lucide="x" size="24"></i>
                </button>
            </div>
            <div class="form-group">
                <label class="form-label">Precio por Noche ($)</label>
                <input type="number" class="form-input" id="specialPrice" placeholder="50000" step="1000">
            </div>
            <div class="form-group">
                <label class="form-label">Motivo (opcional)</label>
                <input type="text" class="form-input" id="pricingNotes" placeholder="Ej: Temporada alta, Fin de semana largo">
            </div>
            <div class="modal-actions">
                <button class="action-btn" onclick="confirmPricing()">Confirmar</button>
                <button class="action-btn secondary" onclick="closeModal('pricingModal')">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const API_URL = '/rentaturista/api';
        let currentPropertyId = null;
        let currentDate = new Date();
        let selectedDates = new Set();
        let availabilityData = {};

        // Load properties
        async function loadProperties() {
            try {
                const response = await fetch(`${API_URL}/properties`);
                const data = await response.json();
                
                const select = document.getElementById('propertySelect');
                select.innerHTML = '<option value="">Selecciona una propiedad</option>' +
                    data.data.map(p => `<option value="${p.id}">${p.title}</option>`).join('');
                
                select.addEventListener('change', (e) => {
                    currentPropertyId = e.target.value;
                    if (currentPropertyId) {
                        loadCalendar();
                    }
                });
            } catch (error) {
                console.error('Error loading properties:', error);
            }
        }

        // Load calendar
        async function loadCalendar() {
            if (!currentPropertyId) return;

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);

            const startDate = firstDay.toISOString().split('T')[0];
            const endDate = lastDay.toISOString().split('T')[0];

            try {
                const response = await fetch(
                    `${API_URL}/properties/${currentPropertyId}/availability?start_date=${startDate}&end_date=${endDate}`
                );
                const data = await response.json();
                
                availabilityData = {};
                data.data.forEach(day => {
                    availabilityData[day.date] = day;
                });

                renderCalendar();
            } catch (error) {
                console.error('Error loading calendar:', error);
            }
        }

        // Render calendar
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            document.getElementById('calendarMonth').textContent = 
                new Date(year, month).toLocaleDateString('es-AR', { month: 'long', year: 'numeric' });

            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = '';

            // Headers
            const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
            days.forEach(day => {
                const header = document.createElement('div');
                header.className = 'calendar-day-header';
                header.textContent = day;
                grid.appendChild(header);
            });

            // Days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startPadding = firstDay.getDay();

            // Empty cells
            for (let i = 0; i < startPadding; i++) {
                const empty = document.createElement('div');
                empty.className = 'calendar-day disabled';
                grid.appendChild(empty);
            }

            // Actual days
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const date = new Date(year, month, day);
                const dateStr = date.toISOString().split('T')[0];
                const dayData = availabilityData[dateStr] || { status: 'available', price: 0 };
                
                // Check if it has special pricing (notes contain 'special' or 'especial')
                const hasSpecialPrice = dayData.notes && 
                    (dayData.notes.toLowerCase().includes('special') || 
                     dayData.notes.toLowerCase().includes('especial') ||
                     dayData.notes.toLowerCase().includes('precio'));

                const dayEl = document.createElement('div');
                dayEl.className = `calendar-day ${dayData.status}`;
                if (hasSpecialPrice) {
                    dayEl.classList.add('special-price');
                }
                dayEl.dataset.date = dateStr;

                if (date.toDateString() === new Date().toDateString()) {
                    dayEl.classList.add('today');
                }

                if (selectedDates.has(dateStr)) {
                    dayEl.classList.add('selected');
                }

                const priceClass = hasSpecialPrice ? 'day-price special' : 'day-price';
                dayEl.innerHTML = `
                    <span class="day-status ${dayData.status}"></span>
                    <span class="day-number">${day}</span>
                    ${dayData.price ? `<span class="${priceClass}">$${dayData.price.toLocaleString('es-AR')}</span>` : ''}
                `;

                if (dayData.status !== 'booked') {
                    dayEl.addEventListener('click', () => toggleDateSelection(dateStr, dayEl));
                }

                grid.appendChild(dayEl);
            }

            lucide.createIcons();
        }

        // Toggle date selection
        function toggleDateSelection(date, element) {
            if (selectedDates.has(date)) {
                selectedDates.delete(date);
                element.classList.remove('selected');
            } else {
                selectedDates.add(date);
                element.classList.add('selected');
            }

            updateActionButtons();
        }

        // Update action buttons
        function updateActionButtons() {
            const hasSelection = selectedDates.size > 0;
            document.getElementById('blockBtn').disabled = !hasSelection;
            document.getElementById('unblockBtn').disabled = !hasSelection;
            document.getElementById('pricingBtn').disabled = !hasSelection;
        }

        // Modal functions
        function openBlockModal() {
            document.getElementById('blockModal').classList.add('active');
            lucide.createIcons();
        }

        function openPricingModal() {
            document.getElementById('pricingModal').classList.add('active');
            lucide.createIcons();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        async function confirmBlock() {
            const notes = document.getElementById('blockNotes').value;
            try {
                const response = await fetch(`${API_URL}/properties/${currentPropertyId}/availability/block`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        start_date: Array.from(selectedDates).sort()[0],
                        end_date: Array.from(selectedDates).sort()[selectedDates.size - 1],
                        status: 'blocked',
                        notes: notes
                    })
                });

                if (response.ok) {
                    closeModal('blockModal');
                    clearSelection();
                    loadCalendar();
                    alert('Fechas bloqueadas exitosamente');
                } else {
                    const error = await response.json();
                    alert('Error: ' + (error.error || 'No se pudo bloquear'));
                }
            } catch (error) {
                console.error('Error blocking dates:', error);
                alert('Error al bloquear fechas');
            }
        }

        async function confirmPricing() {
            const price = document.getElementById('specialPrice').value;
            const notes = document.getElementById('pricingNotes').value;

            if (!price) {
                alert('Por favor ingresa un precio');
                return;
            }

            try {
                const response = await fetch(`${API_URL}/properties/${currentPropertyId}/availability/pricing`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        dates: Array.from(selectedDates),
                        price: parseFloat(price),
                        notes: notes || 'Precio especial'
                    })
                });

                if (response.ok) {
                    closeModal('pricingModal');
                    clearSelection();
                    loadCalendar();
                    alert('Precios especiales establecidos exitosamente');
                } else {
                    const error = await response.json();
                    alert('Error: ' + (error.error || 'No se pudo establecer precio'));
                }
            } catch (error) {
                console.error('Error setting pricing:', error);
                alert('Error al establecer precios');
            }
        }

        function openUnblockModal() {
            if (confirm(`¿Desbloquear ${selectedDates.size} fecha(s) seleccionada(s)?`)) {
                unblockDates();
            }
        }

        async function unblockDates() {
            try {
                const response = await fetch(`${API_URL}/properties/${currentPropertyId}/availability/unblock`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        dates: Array.from(selectedDates)
                    })
                });

                if (response.ok) {
                    clearSelection();
                    loadCalendar();
                    alert('Fechas desbloqueadas exitosamente');
                } else {
                    const error = await response.json();
                    alert('Error: ' + (error.error || 'No se pudo desbloquear'));
                }
            } catch (error) {
                console.error('Error unblocking dates:', error);
                alert('Error al desbloquear fechas');
            }
        }

        function clearSelection() {
            selectedDates.clear();
            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                el.classList.remove('selected');
            });
            updateActionButtons();
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            loadCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            loadCalendar();
        }

        // Initialize
        loadProperties();
    </script>
</body>
</html>