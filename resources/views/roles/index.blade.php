@extends('layouts.app')

@section('title', 'Roles y Permisos')
@section('page_header', 'Roles y Permisos')

@section('content')
<div class="row g-4">
    <!-- Rol Admin -->
    <div class="col-md-4">
        <div class="card h-100 border-gold">
            <div class="card-header bg-transparent border-bottom border-secondary text-center pt-4">
                <div class="mb-3">
                    <i class="bi bi-shield-lock-fill text-gold" style="font-size: 3rem;"></i>
                </div>
                <h4 class="text-white mb-1">Administrador</h4>
                <p class="text-muted small">Acceso total al sistema</p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Gestión de Vehículos</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Gestión de Categorías</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Gestión de Usuarios</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Reportes Financieros</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Configuración del Sistema</li>
                </ul>
            </div>
            <div class="card-footer bg-transparent border-top border-secondary text-center">
                <button class="btn btn-outline-primary btn-sm w-100" disabled>Rol de Sistema</button>
            </div>
        </div>
    </div>

    <!-- Rol Vendedor -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-transparent border-bottom border-secondary text-center pt-4">
                <div class="mb-3">
                    <i class="bi bi-person-badge-fill text-info" style="font-size: 3rem;"></i>
                </div>
                <h4 class="text-white mb-1">Vendedor</h4>
                <p class="text-muted small">Gestión de inventario y ventas</p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Gestión de Vehículos</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Gestión de Categorías</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Registro de Clientes</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Reportes Financieros</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Configuración del Sistema</li>
                </ul>
            </div>
            <div class="card-footer bg-transparent border-top border-secondary text-center">
                <button class="btn btn-outline-primary btn-sm w-100">Editar Permisos</button>
            </div>
        </div>
    </div>

    <!-- Rol Cliente -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-transparent border-bottom border-secondary text-center pt-4">
                <div class="mb-3">
                    <i class="bi bi-person-fill text-secondary" style="font-size: 3rem;"></i>
                </div>
                <h4 class="text-white mb-1">Cliente</h4>
                <p class="text-muted small">Visualización del catálogo</p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush bg-transparent">
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Ver Catálogo de Vehículos</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Gestión de Vehículos</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Ver Otros Usuarios</li>
                    <li class="list-group-item bg-transparent text-muted border-secondary border-opacity-25"><i class="bi bi-dash-circle me-2"></i> Ver Reportes</li>
                    <li class="list-group-item bg-transparent text-white border-secondary border-opacity-25"><i class="bi bi-check-circle-fill text-success me-2"></i> Editar Propio Perfil</li>
                </ul>
            </div>
            <div class="card-footer bg-transparent border-top border-secondary text-center">
                <button class="btn btn-outline-primary btn-sm w-100">Editar Permisos</button>
            </div>
        </div>
    </div>
</div>
@endsection
