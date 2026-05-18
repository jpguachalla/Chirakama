@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header', 'Panel de Control')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Card 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase mb-2">Total Vehículos</h6>
                <h2 class="text-white mb-0" id="stat-total-vehicles">...</h2>
                <div class="mt-2 small text-success">
                    <i class="bi bi-arrow-up-short"></i> <span class="fw-bold">12%</span> desde el mes pasado
                </div>
                <i class="bi bi-car-front stat-icon"></i>
            </div>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase mb-2">Ingresos Mes</h6>
                <h2 class="text-white mb-0" id="stat-revenue">...</h2>
                <div class="mt-2 small text-success">
                    <i class="bi bi-arrow-up-short"></i> <span class="fw-bold">8.5%</span> desde el mes pasado
                </div>
                <i class="bi bi-currency-dollar stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase mb-2">Vehículos en Tránsito</h6>
                <h2 class="text-white mb-0" id="stat-transit">...</h2>
                <div class="mt-2 small text-warning">
                    <i class="bi bi-dash"></i> <span class="fw-bold">Estable</span>
                </div>
                <i class="bi bi-ship stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <h6 class="text-muted text-uppercase mb-2">Nuevos Clientes</h6>
                <h2 class="text-white mb-0" id="stat-clients">...</h2>
                <div class="mt-2 small text-danger">
                    <i class="bi bi-arrow-down-short"></i> <span class="fw-bold">2.4%</span> desde el mes pasado
                </div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Gráfica -->
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Resumen de Importaciones (2024)</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Este Año
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#">Este Año</a></li>
                        <li><a class="dropdown-item" href="#">Año Pasado</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="importsChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Vehículos Recientes -->
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title">Ingresos Recientes</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" id="recent-vehicles-list">
                    <!-- Loading state -->
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        Cargando...
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top border-secondary text-center">
                <a href="{{ route('vehicles.index') }}" class="text-gold text-decoration-none small">Ver todo el inventario <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Cargar Estadísticas Simuladas (Aquí usarías Fetch API real)
        const loadStats = () => {
            document.getElementById('stat-total-vehicles').textContent = '245';
            document.getElementById('stat-revenue').textContent = '$1.2M';
            document.getElementById('stat-transit').textContent = '38';
            document.getElementById('stat-clients').textContent = '1,024';
        };

        // 2. Cargar Lista de Recientes
        const loadRecentVehicles = () => {
            const list = document.getElementById('recent-vehicles-list');
            const vehicles = [
                { brand: 'Toyota', model: 'Hilux', year: '2024', price: '$45,000', img: 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fd?w=100&h=100&fit=crop' },
                { brand: 'BMW', model: 'X5', year: '2023', price: '$85,000', img: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=100&h=100&fit=crop' },
                { brand: 'Audi', model: 'Q8', year: '2024', price: '$92,000', img: 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=100&h=100&fit=crop' },
                { brand: 'Ford', model: 'Raptor', year: '2023', price: '$78,000', img: 'https://images.unsplash.com/photo-1559416523-140ddc3d238c?w=100&h=100&fit=crop' },
            ];

            let html = '';
            vehicles.forEach(v => {
                html += `
                    <div class="list-group-item bg-transparent border-secondary d-flex align-items-center py-3">
                        <img src="${v.img}" alt="${v.model}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-white">${v.brand} ${v.model}</h6>
                            <small class="text-muted">${v.year}</small>
                        </div>
                        <span class="text-gold fw-bold">${v.price}</span>
                    </div>
                `;
            });
            list.innerHTML = html;
        };

        // 3. Inicializar Gráfica con Chart.js
        const initChart = () => {
            const ctx = document.getElementById('importsChart').getContext('2d');
            
            // Gradiente para el área
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(212, 175, 55, 0.5)'); // Gold
            gradient.addColorStop(1, 'rgba(212, 175, 55, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Vehículos Importados',
                        data: [12, 19, 15, 25, 22, 30, 28, 35, 40, 38, 45, 50],
                        borderColor: '#d4af37',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#0f1115',
                        pointBorderColor: '#d4af37',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4 // Curvas suaves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a1d24',
                            titleColor: '#f0f2f5',
                            bodyColor: '#d4af37',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                drawBorder: false,
                            },
                            ticks: { color: '#8b92a5' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#8b92a5' }
                        }
                    }
                }
            });
        };

        // Ejecutar funciones
        setTimeout(() => {
            loadStats();
            loadRecentVehicles();
            initChart();
        }, 500); // Pequeño delay simulando red
    });
</script>
@endpush
