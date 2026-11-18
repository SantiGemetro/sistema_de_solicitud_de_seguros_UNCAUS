<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Operador - Gestión de solicitud de seguros</title>
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

        .acciones-barra {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-barra {
            background: #bd9810;
            color: white;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 15px;
            border: none;
            cursor: pointer;
        }

        .btn-barra:hover {
            background: #a3820b;
        }

        /* CONTENEDOR PRINCIPAL */

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

        /* LAYOUT DE 2 COLUMNAS DEL OPERADOR */

        .panel-grid {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 45px;
            align-items: start;
        }

        .titulo-seccion {
            font-size: 20px;
            font-weight: 500;
            margin: 0 0 20px 0;
        }

        /* TARJETAS DE SOLICITUDES */

        .tarjeta-solicitud {
            background: #dfdfdf;
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .tarjeta-datos p {
            margin: 4px 0;
            font-size: 14px;
            color: #666;
        }

        .tarjeta-datos .id-solicitud {
            font-size: 15px;
            font-weight: bold;
            color: #222;
            margin-bottom: 8px;
        }

        .tarjeta-acciones {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .estado-tag {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tag-pendiente {
            background: #e6969c;
            color: #6d1b22;
        }

        .tag-listo {
            background: #9bd6b4;
            color: #1b6339;
        }

        .btn-revisar {
            background: #c9931b;
            color: white;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-revisar:hover {
            background: #ad7d14;
        }

        /* PANEL DE HISTORIAL */

        .contenedor-historial {
            background: #dfdfdf;
            border-radius: 16px;
            padding: 20px;
            min-height: 470px;
        }

        .buscador-historial {
            position: relative;
            margin-bottom: 20px;
        }

        .buscador-historial input {
            border-radius: 20px;
            padding-right: 40px;
            border: none;
        }

        .buscador-historial button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
            color: #555;
        }

        .item-historial {
            background: #fff;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alerta-exito {
            background: #eaf6fc;
            border: 1px solid #189bd0;
            color: #0c5460;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
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

<main>
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
