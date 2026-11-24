<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Solicitud #{{ str_pad($formulario->id_formulario, 4, '0', STR_PAD_LEFT) }} - UNCAUS</title>
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

    <a href="{{ route('operador.index') }}" class="btn-barra">← Volver al panel</a>
</div>

<main class="operador-show">
    @if(session('pdf_listo') || session('success'))
        <div class="alerta-exito" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <span>{{ session('success') }}</span>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('operador.pdf', $formulario->id_formulario) }}" class="btn btn-aceptar" style="padding: 9px 18px; font-size: 14px;">
                    Descargar PDF para aseguradora
                </a>
                <a href="{{ route('operador.index') }}" class="btn btn-volver" style="padding: 9px 18px; font-size: 14px;">
                    Volver al panel
                </a>
            </div>
        </div>
    @endif

    <div class="cabecera-estado">
        <div>
            <h2 style="margin: 0; font-weight: 500;">Solicitud #{{ str_pad($formulario->id_formulario, 4, '0', STR_PAD_LEFT) }}</h2>
        </div>

        <div>
            @if($formulario->estado === 'pendiente' || $formulario->estado === 'PENDIENTE_AVAL')
                <span class="estado-tag tag-pendiente">Pendiente</span>
            @elseif($formulario->estado === 'avalado/listo' || $formulario->estado === 'AVALADO')
                <span class="estado-tag tag-avalado">Avalado / Listo</span>
            @else
                <span class="estado-tag tag-listo">Enviado</span>
            @endif
        </div>
    </div>

    <div class="campo" style="max-width: 550px;">
        <label>Carrera</label>
        <input type="text" value="{{ $formulario->carrera ?? 'No aplica (Solicitud de Área)' }}" disabled>
    </div>

    <div class="campo" style="max-width: 550px;">
        <label>Materia</label>
        <input type="text" value="{{ $formulario->materia ?? 'No aplica' }}" disabled>
    </div>

    <div class="campo">
        <label>Actividad a realizar</label>
        <textarea disabled>{{ $formulario->actividad }}</textarea>
    </div>

    <div class="campo">
        <label>Fechas y horarios de las actividades ({{ $formulario->fechas->count() }})</label>
        @forelse($formulario->fechas as $f)
            <div class="fila-fechas">
                <div>
                    <label style="font-size: 13px; color: #555;">Fecha</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($f->fecha)->format('d/m/Y') }}" disabled>
                </div>
                <div>
                    <label style="font-size: 13px; color: #555;">Horario</label>
                    <input type="text" value="{{ substr($f->hora_inicio, 0, 5) }} hs - {{ substr($f->hora_fin, 0, 5) }} hs" disabled>
                </div>
            </div>
        @empty
            <input type="text" value="Sin fechas registradas" disabled>
        @endforelse
    </div>

    <div class="campo">
        <label>Nombre del establecimiento/lugar al que asistirán</label>
        <input type="text" value="{{ $formulario->nom_lugar }}" disabled>
    </div>

    <div class="campo">
        <label>Dirección del establecimiento/lugar al que asistirán</label>
        <input type="text" value="{{ $formulario->dir_lugar }}" disabled>
    </div>

    <div class="campo">
        <label>Nómina de estudiantes ({{ $formulario->estudiantes->count() }})</label>
        @forelse($formulario->estudiantes as $est)
            <div class="fila-multiple">
                <input type="text" value="{{ $est->nombre }}" disabled placeholder="Nombre completo">
                <input type="text" value="{{ $est->dni_estudiante }}" disabled placeholder="DNI">
                <input type="text" value="{{ $est->domicilio }}" disabled placeholder="Domicilio">
            </div>
        @empty
            <input type="text" value="Sin estudiantes registrados" disabled>
        @endforelse
    </div>

    <div class="campo">
        <label>Nómina de profesores ({{ $formulario->profesores->count() }})</label>
        @forelse($formulario->profesores as $prof)
            <div class="fila-multiple">
                <input type="text" value="{{ $prof->nombre }}" disabled placeholder="Nombre completo">
                <input type="text" value="{{ $prof->dni_profesor }}" disabled placeholder="DNI">
                <input type="text" value="{{ $prof->domicilio }}" disabled placeholder="Domicilio">
            </div>
        @empty
            <input type="text" value="Sin profesores registrados" disabled>
        @endforelse
    </div>

    <div class="campo" style="max-width: 550px;">
        <label>Correo electrónico del solicitante</label>
        <input type="email" value="{{ $formulario->solicitante->correo_solicitante ?? 'Sin correo' }}" disabled>
    </div>

    <div class="acciones-revision">
        <a href="{{ route('operador.index') }}" class="btn btn-volver">Volver</a>

        @if($formulario->estado === 'enviado')
            <a href="{{ route('operador.pdf', $formulario->id_formulario) }}" class="btn btn-aceptar">
                Descargar PDF para aseguradora
            </a>
        @endif

        @if($formulario->estado === 'pendiente')
            <form action="{{ route('operador.estado', $formulario->id_formulario) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="estado" value="avalado/listo">
                <button type="submit" class="btn btn-aval">Marcar como Listo (Avalado)</button>
            </form>
        @endif

        @if($formulario->estado !== 'enviado')
            <form action="{{ route('operador.estado', $formulario->id_formulario) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="estado" value="enviado">
                <button type="submit" class="btn btn-aceptar">Aceptar y enviar solicitud</button>
            </form>
        @endif
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
