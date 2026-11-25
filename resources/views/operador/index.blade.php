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
    <div class="operador-dropdown" id="operadorDropdown">
        <button type="button" class="operador-trigger" id="btnOperadorMenu" aria-expanded="false">
            <span class="icono-usuario">👤</span>
            <span>{{ $operador->nombre ?? session('operador_nombre', 'Nombre operador') }}</span>
            <span class="flecha-menu">▾</span>
        </button>

        <div class="operador-menu" id="menuOperador">
            <form action="{{ route('operador.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="operador-menu-item">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="acciones-barra">
        <a href="{{ route('operador.registrar') }}" class="btn-barra">Registrar operador</a>
        <a href="{{ route('coordinador.registrar') }}" class="btn-barra">Registrar nuevo coordinador</a>
        <a href="{{ route('formulario.create') }}" class="btn-barra">Nueva solicitud</a>
    </div>
</div>

<main class="panel-operador">
    @if(session('success'))
        <div class="alerta-exito">{{ session('success') }}</div>
    @endif

    <div class="panel-grid">
        <!-- Columna Izquierda: Solicitudes pendientes (deslizable a partir de la 5ta solicitud) -->
        <section>
            <h2 class="titulo-seccion">Solicitudes pendientes ({{ $pendientes->count() }})</h2>

            <div class="lista-pendientes">
                @forelse($pendientes as $form)
                    <div class="tarjeta-solicitud">
                        <div class="tarjeta-datos">
                            <p class="id-solicitud">ID: #{{ str_pad($form->id_formulario, 4, '0', STR_PAD_LEFT) }}</p>
                            <p>Solicitante: {{ $form->solicitante->correo_solicitante ?? 'Sin correo' }}</p>
                            <p>Estudiantes: {{ $form->estudiantes_count }}</p>
                            <p>Profesores: {{ $form->profesores_count }}</p>
                        </div>

                        <div class="tarjeta-acciones">
                            @if($form->estado === 'pendiente' || $form->estado === 'PENDIENTE_AVAL')
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
            </div>
        </section>

        <!-- Columna Derecha: Historial de solicitudes admitidas (deslizable con buscador fijo arriba) -->
        <section>
            <h2 class="titulo-seccion">Historial de solicitudes admitidas ({{ $historial->count() }})</h2>
            <div class="contenedor-historial" style="display: flex; flex-direction: column; height: 700px; max-height: 700px; overflow: hidden;">
                <form action="{{ route('operador.index') }}" method="GET" class="buscador-historial" style="flex-shrink: 0;">
                    <input type="text" name="buscar" value="{{ $busqueda }}" placeholder="Carrera/Area/Solicitante/fecha">
                    <button type="submit">🔍</button>
                </form>

                <div class="lista-historial" style="flex: 1; overflow-y: auto; padding-right: 8px;">
                    @forelse($historial as $item)
                        <div class="item-historial">
                            <div>
                                <strong>#{{ str_pad($item->id_formulario, 4, '0', STR_PAD_LEFT) }}</strong>
                                <div style="font-size: 13px; color: #555; margin-top: 3px;">
                                    {{ $item->solicitante->correo_solicitante ?? 'Sin correo' }}
                                </div>
                                <div style="font-size: 12px; color: #888;">
                                    {{ $item->carrera ?? $item->actividad }}
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="estado-tag tag-listo">ENVIADO</span>
                                <a href="{{ route('operador.show', $item->id_formulario) }}" class="btn-revisar">Ver</a>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #666; font-size: 14px; margin-top: 40px;">
                            Sin registros en el historial.
                        </p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    const btnMenu = document.getElementById('btnOperadorMenu');
    const menuOperador = document.getElementById('menuOperador');
    const contenedorDropdown = document.getElementById('operadorDropdown');

    btnMenu.addEventListener('click', function () {
        const abierto = menuOperador.classList.toggle('activo');
        btnMenu.setAttribute('aria-expanded', abierto ? 'true' : 'false');
    });

    document.addEventListener('click', function (e) {
        if (!contenedorDropdown.contains(e.target)) {
            menuOperador.classList.remove('activo');
            btnMenu.setAttribute('aria-expanded', 'false');
        }
    });
</script>

</body>
</html>
