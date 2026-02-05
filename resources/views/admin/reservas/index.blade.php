@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold">Gestión de Reservas</h1>
        <a href="{{ route('vacacion.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver al Inicio
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th class="py-3">Usuario</th>
                            <th class="py-3">Paquete Vacacional</th>
                            <th class="py-3">Precio</th>
                            <th class="py-3">Fecha Reserva</th>
                            <th class="pe-4 py-3 text-end">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="ps-4 text-muted">#{{ $reserva->id }}</td>
                                <td class="fw-bold">{{ $reserva->user->name ?? 'Usuario Eliminado' }}</td>
                                <td>
                                    @if($reserva->vacacion)
                                        <a href="{{ route('vacacion.show', $reserva->vacacion) }}" class="text-decoration-none fw-bold">
                                            {{ $reserva->vacacion->titulo }}
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic">Paquete Eliminado</span>
                                    @endif
                                </td>
                                <td class="text-success fw-bold">
                                    {{ $reserva->vacacion ? number_format($reserva->vacacion->precio, 0, ',', '.') . ' €' : '-' }}
                                </td>
                                <td class="text-secondary">
                                    {{ $reserva->created_at ? $reserva->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="pe-4 text-end">
                                    <span class="badge bg-success rounded-pill px-3">Confirmada</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    No hay reservas registradas en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $reservas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
