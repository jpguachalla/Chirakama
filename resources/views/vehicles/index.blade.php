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

    let vehicles = [];

    async function loadVehicles() {

        try {

            const response = await fetch('/api/vehicles');

            const data = await response.json();

            console.log(data);

            vehicles = data.vehicles;

            renderTable();

        } catch(error) {

            console.error('Error cargando vehículos:', error);

        }

    }

    function getBadgeClass(stock) {

        if(stock > 10) return 'badge-success';

        if(stock > 0) return 'badge-warning';

        return 'badge-danger';

    }

    function renderTable() {

        const tbody = document.getElementById('vehiclesTableBody');

        tbody.innerHTML = '';

        if(vehicles.length === 0) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        No hay vehículos registrados
                    </td>
                </tr>
            `;

            return;

        }

        vehicles.forEach(v => {

            const tr = document.createElement('tr');

            tr.innerHTML = `

                <td class="ps-4">

                    <div class="d-flex align-items-center">

                        <img 
                            src="https://via.placeholder.com/60x40?text=Auto"
                            class="vehicle-img-thumb me-3"
                        >

                        <div>

                            <div class="fw-bold">
                                ${v.brand}
                            </div>

                            <div class="small text-muted">
                                ${v.model}
                            </div>

                        </div>

                    </div>

                </td>

                <td>
                    ${v.category?.name ?? 'Sin categoría'}
                </td>

                <td>
                    ${v.year}
                </td>

                <td class="text-gold fw-bold">
                    $${v.price}
                </td>

                <td>
                    <span class="badge ${getBadgeClass(v.stock)}">
                        Stock: ${v.stock}
                    </span>
                </td>

                <td class="text-end pe-4">

                    <button 
    class="btn btn-sm btn-outline-primary me-1"
    onclick="editVehicle(${v.id})"
>
    <i class="bi bi-pencil"></i>
</button>
                        <i class="bi bi-pencil"></i>
                    </button>

                    <button 
    class="btn btn-sm btn-outline-danger"
    onclick="deleteVehicle(${v.id})"
>
    <i class="bi bi-trash"></i>
</button>
                        <i class="bi bi-trash"></i>
                    </button>

                </td>

            `;

            tbody.appendChild(tr);

        });

    }
    const token = localStorage.getItem('token');
    function editVehicle(id) {

    const vehicle = vehicles.find(v => v.id === id);

    if(!vehicle) return;

    document.getElementById('vehicleId').value = vehicle.id;

    document.getElementById('vBrand').value = vehicle.brand;

    document.getElementById('vModel').value = vehicle.model;

    document.getElementById('vYear').value = vehicle.year;

    document.getElementById('vPrice').value = vehicle.price;

    const modal = new bootstrap.Modal(
        document.getElementById('vehicleModal')
    );

    modal.show();

}
async function saveVehicle() {

    const vehicleId = document.getElementById('vehicleId').value;

    const vehicleData = {

        brand: document.getElementById('vBrand').value,
        model: document.getElementById('vModel').value,
        year: document.getElementById('vYear').value,
        price: document.getElementById('vPrice').value,
        stock: 10,
        category_id: 1

    };

    try {

        const response = await fetch(

            vehicleId
                ? `/api/vehicles/${vehicleId}`
                : '/api/vehicles',

            {

                method: vehicleId ? 'PUT' : 'POST',

             headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`
},

                body: JSON.stringify(vehicleData)

            }

        );

        const data = await response.json();

        console.log(data);

        alert(
            vehicleId
                ? 'Vehículo actualizado correctamente'
                : 'Vehículo registrado correctamente'
        );

        const modal = bootstrap.Modal.getInstance(
            document.getElementById('vehicleModal')
        );

        modal.hide();

        document.getElementById('vehicleForm').reset();

        document.getElementById('vehicleId').value = '';

        loadVehicles();

    } catch(error) {

        console.error(error);

        alert('Error al guardar vehículo');

    }

}
async function deleteVehicle(id) {

    const confirmDelete = confirm(
        '¿Deseas eliminar este vehículo?'
    );

    if(!confirmDelete) return;

    try {

        const response = await fetch(`/api/vehicles/${id}`, {

            method: 'DELETE',

          headers: {
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`
}

        });

        const data = await response.json();

        console.log(data);

        alert('Vehículo eliminado correctamente');

        loadVehicles();

    } catch(error) {

        console.error(error);

        alert('Error al eliminar vehículo');

    }

}   
    document.addEventListener('DOMContentLoaded', () => {

        loadVehicles();

    });

</script>
@endpush
