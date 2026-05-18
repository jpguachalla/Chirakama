@extends('layouts.app')

@section('title', 'Categorías')
@section('page_header', 'Gestión de Categorías')

@section('content')
<div class="row">
    <!-- Listado de Categorías -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Categorías de Vehículos</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nombre de Categoría</th>
                                <th>Descripción</th>
                                <th>Total Vehículos</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Cargando categorías...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario Lateral -->
    <div class="col-md-4">
        <div class="card sticky-top" style="top: 100px;">
            <div class="card-header">
                <h5 class="card-title mb-0" id="formTitle">Nueva Categoría</h5>
            </div>
            <div class="card-body">
                <form id="categoryForm">
                    <input type="hidden" id="categoryId">
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="catName" required placeholder="Ej: SUV, Sedán, Pick-up">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="catDesc" rows="3" placeholder="Breve descripción..."></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" onclick="saveCategory()">
                            <i class="bi bi-save me-2"></i>Guardar Categoría
                        </button>
                        <button type="button" class="btn btn-outline-secondary d-none" id="btnCancelEdit" onclick="cancelEdit()">
                            Cancelar Edición
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Datos simulados
    let categories = [
        { id: 1, name: 'SUV', description: 'Vehículos Utilitarios Deportivos', total: 45 },
        { id: 2, name: 'Sedán', description: 'Autos familiares de 4 puertas', total: 32 },
        { id: 3, name: 'Pick-up', description: 'Camionetas de carga abierta', total: 28 },
        { id: 4, name: 'Deportivo', description: 'Vehículos de alto rendimiento', total: 12 },
    ];

    function renderCategories() {
        const tbody = document.getElementById('categoriesTableBody');
        tbody.innerHTML = '';

        if(categories.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No hay categorías registradas</td></tr>';
            return;
        }

        categories.forEach(c => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="ps-4 text-muted">#${c.id}</td>
                <td class="fw-bold text-white">${c.name}</td>
                <td class="text-muted small">${c.description}</td>
                <td><span class="badge bg-secondary">${c.total}</span></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editCategory(${c.id})" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${c.id})" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function editCategory(id) {
        const c = categories.find(item => item.id === id);
        if(!c) return;

        document.getElementById('categoryId').value = c.id;
        document.getElementById('catName').value = c.name;
        document.getElementById('catDesc').value = c.description;

        document.getElementById('formTitle').textContent = 'Editar Categoría';
        document.getElementById('btnCancelEdit').classList.remove('d-none');
    }

    function cancelEdit() {
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
        document.getElementById('formTitle').textContent = 'Nueva Categoría';
        document.getElementById('btnCancelEdit').classList.add('d-none');
    }

    function saveCategory() {
        const id = document.getElementById('categoryId').value;
        const cData = {
            name: document.getElementById('catName').value,
            description: document.getElementById('catDesc').value,
            total: 0 // Por defecto al crear
        };

        if(!cData.name) {
            alert("El nombre de la categoría es obligatorio.");
            return;
        }

        if (id) {
            const index = categories.findIndex(item => item.id == id);
            cData.total = categories[index].total; // Mantener el total real
            categories[index] = { ...categories[index], ...cData };
        } else {
            cData.id = Date.now();
            categories.push(cData);
        }

        cancelEdit();
        renderCategories();
    }

    function deleteCategory(id) {
        if(confirm('¿Estás seguro de eliminar esta categoría? Si tiene vehículos asociados podría causar errores.')) {
            categories = categories.filter(c => c.id !== id);
            renderCategories();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(renderCategories, 200);
    });
</script>
@endpush
