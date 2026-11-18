<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Coordinador - Gestión de Seguros</title>
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Gestión de solicitud de seguros</h1>
        <div class="logo-placeholder">LOGO UNCAUS</div>
    </header>

    <div class="coord-header-bar">
        <div class="coord-user">
            <!-- Mostramos el nombre real del coordinador autenticado y su carrera o área -->
            <span>👤 {{ $coordinador->nombre }} ({{ $coordinador->carrera }}) ▾</span>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('Formulario.create') }}" class="btn-solicitar-seguro">Solicitar un seguro</a>
            <form action="{{ route('coordinador.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-solicitar-seguro" style="border: none; cursor: pointer;">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <main>
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 12px 16px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <h3 style="margin-top: 30px; color: #444;">
            Solicitudes pendientes ({{ $solicitudesPendientes->count() }})
        </h3>

        @if($solicitudesPendientes->isEmpty())
            <p style="color: #666;">No hay solicitudes pendientes para tu carrera o área en este momento.</p>
        @else
            <!-- Recorremos dinámicamente las solicitudes de la base de datos -->
            @foreach($solicitudesPendientes as $solicitud)
                <div class="tarjeta-solicitud">
                    <strong>ID: #000{{ $solicitud->id_formulario }}_DEP</strong>
                    <span class="badge-estado badge-pendiente">PENDIENTE</span>
                    <p>Solicitante: {{ $solicitud->solicitante->correo_solicitante ?? 'Sin correo' }}</p>
                    <p>Estudiantes: {{ $solicitud->estudiantes()->count() }}</p>
                    <p>Profesores: {{ $solicitud->profesores()->count() }}</p>

                    <!-- Botón revisar apuntando al ID real de cada formulario -->
                    <a href="{{ route('coordinador.revisar', $solicitud->id_formulario) }}" class="btn-revisar">Revisar</a>
                </div>
            @endforeach
        @endif
    </main>
</body>
</html>
