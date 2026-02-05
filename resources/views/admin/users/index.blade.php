@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold">Gestión de Usuarios</h1>
        <a href="{{ route('vacacion.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver al Inicio
        </a>
    </div>

    @if(session('mensajeTexto'))
        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('mensajeTexto') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Usuario</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Fecha Registro</th>
                            <th class="py-3">Rol Actual</th>
                            <th class="pe-4 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="ps-4 fw-bold">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 
                                        {{ $user->rol === 'admin' ? 'bg-danger' : ($user->rol === 'advanced' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ ucfirst($user->rol === 'user' ? 'Normal' : $user->rol) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="{{ route('users.update', $user) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="rol" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol }}" {{ $user->rol === $rol ? 'selected' : '' }}>
                                                    {{ ucfirst($rol === 'user' ? 'Normal' : $rol) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
