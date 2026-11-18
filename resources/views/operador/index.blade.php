<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Operador - Gestión de solicitud de seguros</title>
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

<header>
    <h1>Gestión de solicitud de seguros</h1>
    <div class="logo-container">
        <img src="{{ asset('images/isologo-uncaus-blanco.png') }}" alt="Logo UNCAUS" class="logo-uncaus">
    </div>
</header>

<div class="barra-operador">
    <div class="operador-usuario">
        <div class="icono-usuario">👤</div>
        <span>{{ $operador->nombre ?? session('operador_nombre', 'Nombre operador') }} ▾</span>
    </div>
    <div class="acciones-barra">
        <a href="{{ route('operador.registrar') }}" class="btn-barra">Registrar operador</a>
        <a href="{{ route('coordinador.registrar') }}" class="btn-barra">Registrar nuevo coordinador</a>
        <a href="{{ route('formulario.create') }}" class="btn-barra">Nueva solicitud</a>
        <form action="{{ route('operador.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-barra">Cerrar sesión</button>
        </form>
    </div>
</div>

<main class="panel-operador">
    @if(session('success'))
        <div class="alerta-exito">{{ session('success') }}</div>
    @endif

    <div class="panel-grid">
        <!-- Columna Izquierda: Solicitudes pendientes -->
        <section>
            <h2 class="titulo-seccion">Solicitudes pendientes ({{ $pendientes->count() }})</h2>

            @forelse($pendientes as $form)
                <div class="tarjeta-solicitud">
                    <div class="tarjeta-datos">
                        <p class="id-solicitud">ID: {{ $form->codigo }}</p>
                        <p>Solicitante: {{ $form->solicitante->correo_solicitante ?? $form->solicitante->correo ?? 'Sin correo' }}</p>
                        <p>Estudiantes: {{ $form->estudiantes_count }}</p>
                        <p>Profesores: {{ $form->profesores_count }}</p>
                    </div>

                    <div class="tarjeta-acciones">
                        @if($form->estado === 'PENDIENTE_AVAL' || $form->estado === 'pendiente')
                            <span class="estado-tag tag-pendiente">PENDIENTE</span>
                            <a href="{{ route('operador.show', $form->id_formulario) }}" class="btn-revisar">Revisar</a>
                        @else
                            <span class="estado-tag tag-listo">LISTO</span>
                            <a href="{{ route('operador.show', $form->id_formulario) }}" class="btn-revisar">Revisar</a>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color: #666;">No hay solicitudes pendientes.</p>
            @endforelse
        </section>

        <!-- Columna Derecha: Historial de solicitudes admitidas -->
        <section>
            <h2 class="titulo-seccion">Historial de solicitudes admitidas</h2>
            <div class="contenedor-historial">
                <form action="{{ route('operador.index') }}" method="GET" class="buscador-historial">
                    <input type="text" name="buscar" value="{{ $busqueda }}" placeholder="Carrera/Area/Solicitante/fecha">
                    <button type="submit">🔍</button>
                </form>

                @forelse($historial as $item)
                    <div class="item-historial">
                        <div>
                            <strong>{{ $item->codigo }}</strong>
                            <div style="font-size: 13px; color: #555; margin-top: 3px;">
                                {{ $item->solicitante->correo_solicitante ?? $item->solicitante->correo ?? '' }}
                            </div>
                            <div style="font-size: 12px; color: #888;">
                                {{ $item->carrera ?? $item->actividad }}
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            @if($item->estado === 'ACEPTADO' || $item->estado === 'enviado')
                                <span class="estado-tag tag-listo">ACEPTADO</span>
                            @else
                                <span class="estado-tag tag-pendiente">RECHAZADO</span>
                            @endif
                            <a href="{{ route('operador.show', $item->id_formulario) }}" class="btn-revisar">Ver</a>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #666; font-size: 14px; margin-top: 40px;">
                        Sin registros en el historial.
                    </p>
                @endforelse
            </div>
        </section>
    </div>
</main>

</body>
</html>
