<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Solicitud {{ $formulario->codigo }} - UNCAUS</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #222;
            background: #fff;
        }

        /* ENCABEZADO */

        header {
            height: 110px;
            background: #414d51;
            border-top: 28px solid #189bd0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            color: white;
        }

        header h1 {
            font-size: 32px;
            font-weight: 500;
            margin: 0;
        }

        .logo-placeholder {
            width: 170px;
            height: 65px;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ddd;
            font-size: 13px;
            text-align: center;
        }

        /* BARRA DE PERFIL OPERADOR */

        .barra-operador {
            background: #e1b81c;
            padding: 12px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }

        .operador-usuario {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
        }

        .icono-usuario {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #bd9810;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .btn-barra {
            background: #bd9810;
            color: white;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 15px;
        }

        /* FORMULARIO / DETALLE */

        main {
            max-width: 1120px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d4d4d4;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #189bd0;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        input:disabled, textarea:disabled, select:disabled {
            background: #eee;
            cursor: not-allowed;
            color: #222;
        }

        /* ENCABEZADO DEL DETALLE Y FILAS DE NÓMINAS */

        .cabecera-estado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 18px;
            margin-bottom: 25px;
            border-bottom: 1px solid #d4d4d4;
        }

        .estado-tag {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .PENDIENTE_AVAL { background: #e6969c; color: #6d1b22; }
        .AVALADO { background: #fff3cd; color: #856404; }
        .ACEPTADO { background: #9bd6b4; color: #1b6339; }
        .RECHAZADO { background: #f8d7da; color: #721c24; }

        .fila-multiple {
            display: grid;
            grid-template-columns: 2fr 1fr 2fr;
            gap: 12px;
            margin-bottom: 10px;
        }

        .fila-fechas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 10px;
            max-width: 650px;
        }

        .acciones-revision {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid #d4d4d4;
        }

        .btn {
            padding: 12px 26px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .btn-volver { background: #414d51; }
        .btn-rechazar { background: #c62828; }
        .btn-aceptar { background: #189bd0; }
        .btn-aval { background: #c9931b; }
    </style>
</head>
<body>

<header>
    <h1>Gestión de solicitud de seguros</h1>
    <div class="logo-placeholder">UNCAUS</div>
</header>

<div class="barra-operador">
    <div class="operador-usuario">
        <div class="icono-usuario">👤</div>
        <span>{{ $operador->nombre ?? 'Nombre operador' }} ▾</span>
    </div>
    <a href="{{ route('operador.index') }}" class="btn-barra">← Volver al panel</a>
</div>

<main>
    <div class="cabecera-estado">
        <div>
            <h2 style="margin: 0; font-weight: 500;">Solicitud {{ $formulario->codigo }}</h2>
            <small style="color: #666;">
                Confirmado por: {{ $formulario->operadorConfirma->nombre ?? 'Pendiente de confirmación' }}
            </small>
        </div>

        <div>
            <span class="estado-tag {{ $formulario->estado }}">
                @if($formulario->estado === 'PENDIENTE_AVAL') Pendiente de aval
                @elseif($formulario->estado === 'AVALADO') Listo (Avalado)
                @elseif($formulario->estado === 'ACEPTADO') Aceptado
                @else Rechazado
                @endif
            </span>
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
                    <label style="font-size: 13px; color: #555;">Inicio (Salida)</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($f->fecha_inicio)->format('d/m/Y H:i') }} hs" disabled>
                </div>
                <div>
                    <label style="font-size: 13px; color: #555;">Fin (Llegada)</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($f->fecha_fin)->format('d/m/Y H:i') }} hs" disabled>
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
        <input type="email" value="{{ $formulario->solicitante->correo ?? '' }}" disabled>
    </div>

    <div class="acciones-revision">
        <a href="{{ route('operador.index') }}" class="btn btn-volver">Volver</a>

        @if($formulario->estado === 'PENDIENTE_AVAL')
            <form action="{{ route('operador.estado', $formulario->id_formulario) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="estado" value="AVALADO">
                <button type="submit" class="btn btn-aval">Marcar como Listo (Avalado)</button>
            </form>
        @endif

        <form action="{{ route('operador.estado', $formulario->id_formulario) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado" value="RECHAZADO">
            <button type="submit" class="btn btn-rechazar">Rechazar</button>
        </form>

        <form action="{{ route('operador.estado', $formulario->id_formulario) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado" value="ACEPTADO">
            <button type="submit" class="btn btn-aceptar">Aceptar solicitud</button>
        </form>
    </div>
</main>

</body>
</html>