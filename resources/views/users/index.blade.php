@extends('layouts.app')

@section('title', 'Usuarios')
@section('page_header', 'Gestión de Usuarios')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Personal y Clientes</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetUserForm()">
            <i class="bi bi-person-plus"></i> Nuevo Usuario
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Último Acceso</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Cargando usuarios...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Usuario -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Registrar Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="uName" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="uEmail" required placeholder="juan@ejemplo.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="uPassword" placeholder="Dejar en blanco para no cambiar">
                        <small class="text-muted d-none" id="uPasswordHelp">Solo ingresa si deseas cambiar la contraseña actual.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select" id="uRole" required>
                                <option value="Admin">Administrador</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Cliente">Cliente</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="uStatus" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">Guardar Usuario</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let users = [
        { id: 1, name: 'Admin User', email: 'admin@chirakama.com', role: 'Admin', status: 'Activo', last_login: 'Hace 5 min', avatar: 'https://ui-avatars.com/api/?name=Admin+User&background=d4af37&color=000' },
        { id: 2, name: 'Carlos Ventas', email: 'carlos@chirakama.com', role: 'Vendedor', status: 'Activo', last_login: 'Hace 2 horas', avatar: 'https://ui-avatars.com/api/?name=Carlos+Ventas&background=random' },
        { id: 3, name: 'María López', email: 'maria@cliente.com', role: 'Cliente', status: 'Activo', last_login: 'Ayer', avatar: 'https://ui-avatars.com/api/?name=Maria+Lopez&background=random' },
        { id: 4, name: 'Ex Empleado', email: 'ex@chirakama.com', role: 'Vendedor', status: 'Inactivo', last_login: 'Hace 2 meses', avatar: 'https://ui-avatars.com/api/?name=Ex+Empleado&background=random' },
    ];

    const userModal = new bootstrap.Modal(document.getElementById('userModal'));

    function renderUsers() {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        users.forEach(u => {
            const roleClass = u.role === 'Admin' ? 'text-gold' : (u.role === 'Vendedor' ? 'text-info' : 'text-muted');
            const statusBadge = u.status === 'Activo' ? 'badge-success' : 'badge-danger';
            
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <img src="${u.avatar}" class="rounded-circle me-3 border border-secondary" style="width:40px;height:40px" alt="user">
                        <span class="fw-bold">${u.name}</span>
                    </div>
                </td>
                <td class="text-muted">${u.email}</td>
                <td class="${roleClass} fw-bold">${u.role}</td>
                <td><span class="badge ${statusBadge}">${u.status}</span></td>
                <td class="text-muted small">${u.last_login}</td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="editUser(${u.id})"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteUser(${u.id})"><i class="bi bi-trash"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function resetUserForm() {
        document.getElementById('userForm').reset();
        document.getElementById('userId').value = '';
        document.getElementById('userModalTitle').textContent = 'Registrar Usuario';
        document.getElementById('uPasswordHelp').classList.add('d-none');
        document.getElementById('uPassword').required = true;
    }

    function editUser(id) {
        const u = users.find(item => item.id === id);
        if(!u) return;

        document.getElementById('userId').value = u.id;
        document.getElementById('uName').value = u.name;
        document.getElementById('uEmail').value = u.email;
        document.getElementById('uRole').value = u.role;
        document.getElementById('uStatus').value = u.status;
        
        document.getElementById('uPassword').required = false;
        document.getElementById('uPasswordHelp').classList.remove('d-none');
        document.getElementById('userModalTitle').textContent = 'Editar Usuario';
        
        userModal.show();
    }

    function saveUser() {
        const id = document.getElementById('userId').value;
        const uData = {
            name: document.getElementById('uName').value,
            email: document.getElementById('uEmail').value,
            role: document.getElementById('uRole').value,
            status: document.getElementById('uStatus').value,
        };

        if(!uData.name || !uData.email) {
            alert("Nombre y email son obligatorios.");
            return;
        }

        if (id) {
            const index = users.findIndex(item => item.id == id);
            users[index] = { ...users[index], ...uData };
        } else {
            uData.id = Date.now();
            uData.last_login = 'Nunca';
            uData.avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(uData.name)}&background=random`;
            users.push(uData);
        }

        userModal.hide();
        renderUsers();
    }

    function deleteUser(id) {
        if(confirm('¿Eliminar este usuario del sistema?')) {
            users = users.filter(u => u.id !== id);
            renderUsers();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(renderUsers, 200);
    });
</script>
@endpush
