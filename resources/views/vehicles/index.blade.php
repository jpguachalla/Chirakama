@extends('layouts.app')

@section('title', 'Vehículos')
@section('page_header', 'Gestión de Vehículos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Catálogo de Vehículos</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal" onclick="resetForm()">
            <i class="bi bi-plus-lg"></i> Nuevo Vehículo
        </button>
    </div>
    <div class="card-body p-0">
        <!-- Search and Filter Bar -->
        <div class="p-3 border-bottom border-secondary d-flex gap-3 flex-wrap">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-transparent border-secondary text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Buscar vehículo..." id="searchInput">
            </div>
            <select class="form-select" style="max-width: 200px;" id="filterStatus">
                <option value="">Todos los Estados</option>
                <option value="Disponible">Disponible</option>
                <option value="Reservado">Reservado</option>
                <option value="Vendido">Vendido</option>
            </select>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Vehículo</th>
                        <th>Categoría</th>
                        <th>Año</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody id="vehiclesTableBody">
                    <!-- Filas generadas por JS -->
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Cargando vehículos...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear/Editar Vehículo -->
<div class="modal fade" id="vehicleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleModalTitle">Registrar Nuevo Vehículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="vehicleForm">
                    <input type="hidden" id="vehicleId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" id="vBrand" required placeholder="Ej: Toyota">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="vModel" required placeholder="Ej: Land Cruiser">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Año</label>
                            <input type="number" class="form-control" id="vYear" required min="1990" max="2025" placeholder="2024">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Precio ($)</label>
                            <input type="number" class="form-control" id="vPrice" required placeholder="0.00" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="vStatus" required>
                                <option value="Disponible">Disponible</option>
                                <option value="Reservado">Reservado</option>
                                <option value="Vendido">Vendido</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">URL Imagen</label>
                            <input type="url" class="form-control" id="vImage" placeholder="https://...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveVehicleBtn" onclick="saveVehicle()">Guardar Vehículo</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Datos simulados (Reemplazar con Fetch API a /api/vehicles)
    let vehicles = [
        { id: 1, brand: 'Toyota', model: 'Hilux SRV', category: 'Camioneta', year: 2024, price: 45000, status: 'Disponible', img: 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fd?w=100&h=100&fit=crop' },
        { id: 2, brand: 'BMW', model: 'X5 M-Sport', category: 'SUV', year: 2023, price: 85000, status: 'Reservado', img: 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=100&h=100&fit=crop' },
        { id: 3, brand: 'Audi', model: 'Q8 S-Line', category: 'SUV', year: 2024, price: 92000, status: 'Disponible', img: 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=100&h=100&fit=crop' },
        { id: 4, brand: 'Porsche', model: '911 Carrera', category: 'Deportivo', year: 2023, price: 150000, status: 'Vendido', img: 'https://images.unsplash.com/photo-1503376712341-ea40212002dd?w=100&h=100&fit=crop' }
    ];

    const vehicleModal = new bootstrap.Modal(document.getElementById('vehicleModal'));

    function getBadgeClass(status) {
        if(status === 'Disponible') return 'badge-success';
        if(status === 'Reservado') return 'badge-warning';
        return 'badge-danger'; // Vendido
    }

    function renderTable() {
        const tbody = document.getElementById('vehiclesTableBody');
        tbody.innerHTML = '';

        if(vehicles.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No hay vehículos registrados</td></tr>';
            return;
        }

        vehicles.forEach(v => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <img src="${v.img || 'https://via.placeholder.com/60x40?text=Auto'}" class="vehicle-img-thumb me-3" alt="auto">
                        <div>
                            <div class="fw-bold">${v.brand}</div>
                            <div class="small text-muted">${v.model}</div>
                        </div>
                    </div>
                </td>
                <td>${v.category}</td>
                <td>${v.year}</td>
                <td class="text-gold fw-bold">$${v.price.toLocaleString()}</td>
                <td><span class="badge ${getBadgeClass(v.status)}">${v.status}</span></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editVehicle(${v.id})" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteVehicle(${v.id})" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function resetForm() {
        document.getElementById('vehicleForm').reset();
        document.getElementById('vehicleId').value = '';
        document.getElementById('vehicleModalTitle').textContent = 'Registrar Nuevo Vehículo';
    }

    function editVehicle(id) {
        const v = vehicles.find(item => item.id === id);
        if(!v) return;

        document.getElementById('vehicleId').value = v.id;
        document.getElementById('vBrand').value = v.brand;
        document.getElementById('vModel').value = v.model;
        document.getElementById('vYear').value = v.year;
        document.getElementById('vPrice').value = v.price;
        document.getElementById('vStatus').value = v.status;
        document.getElementById('vImage').value = v.img || '';

        document.getElementById('vehicleModalTitle').textContent = 'Editar Vehículo';
        vehicleModal.show();
    }

    function saveVehicle() {
        const id = document.getElementById('vehicleId').value;
        const vData = {
            brand: document.getElementById('vBrand').value,
            model: document.getElementById('vModel').value,
            category: 'SUV', // Simplificado para la demo
            year: parseInt(document.getElementById('vYear').value),
            price: parseFloat(document.getElementById('vPrice').value),
            status: document.getElementById('vStatus').value,
            img: document.getElementById('vImage').value || 'https://via.placeholder.com/60x40?text=Auto'
        };

        // Lógica de validación básica
        if(!vData.brand || !vData.model || !vData.year || !vData.price) {
            alert("Por favor complete los campos obligatorios.");
            return;
        }

        // AQUÍ IRÍA LA LLAMADA FETCH: ApiService.post('/vehicles', vData)

        // Simulación
        if (id) {
            const index = vehicles.findIndex(item => item.id == id);
            vehicles[index] = { ...vehicles[index], ...vData };
        } else {
            vData.id = Date.now();
            vehicles.unshift(vData);
        }

        vehicleModal.hide();
        renderTable();
        
        // Simular Toast
        // showToast('Vehículo guardado exitosamente');
    }

    function deleteVehicle(id) {
        if(confirm('¿Estás seguro de que deseas eliminar este vehículo?')) {
            // AQUÍ IRÍA LA LLAMADA FETCH: ApiService.delete(`/vehicles/${id}`)
            
            vehicles = vehicles.filter(v => v.id !== id);
            renderTable();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Carga inicial
        setTimeout(() => {
            renderTable();
        }, 300);
    });
</script>
@endpush
