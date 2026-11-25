<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Solicitud de Seguros</title>
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

    <header>
        <h1>Gestión de solicitud de seguros</h1>
        <div class="logo-container">
            <img src="{{ asset('images/isologo-uncaus-blanco.png') }}" alt="Logo UNCAUS" class="logo-uncaus">
        </div>
    </header>

    <main>
        <!-- Formulario de revisión (con los datos del formulario de prueba) -->
        <form action="{{ route('coordinador.confirmar', $formulario->id_formulario) }}" method="POST" enctype="multipart/form-data" id="formRevision">
            @csrf

            <!-- ESTADO -->
            <div class="campo">
                <label>Estado de la solicitud</label>
                @if($formulario->estado === 'cancelado')
                    <input type="text" value="{{ $formulario->estado }}" disabled style="background-color: darksalmon;">
                @elseif($formulario->estado === 'pendiente')
                    <input type="text" value="Pendiente de aval de director" disabled style="background-color: lightyellow;">
                @elseif($formulario->estado === 'avalado/listo')
                    <input type="text" value="Avalado por el director, en espera de envio a la aseguradora" disabled style="background-color: lightgreen;">
                @elseif($formulario->estado === 'enviado')
                    <input type="text" value="Enviado a la aseguradora!" disabled style="background-color: #68b368;">
                @endif
            </div>

            <!-- CARRERA -->
            <div class="campo">
                <label>Carrera</label>
                <input type="text" value="{{ $formulario->carrera }}" disabled>
            </div>

            <!-- MATERIA -->
            <div class="campo">
                <label>Materia</label>
                <input type="text" value="{{ $formulario->materia }}" disabled>
            </div>

            <!-- ACTIVIDAD -->
            <div class="campo">
                <label>Actividad a realizar (detallar brevemente)</label>
                <textarea disabled>{{ $formulario->actividad }}</textarea>
            </div>

            <!-- FECHAS (Recorriendo la relación de fechas de la BD) -->
            <div class="campo">
                <label>Fechas de las actividades a realizar</label>
                <div id="lista-fechas">
                    @foreach($formulario->fechas as $fechaItem)
                        <div class="fecha-card">
                            <strong>{{ $fechaItem->fecha }}</strong>
                            <div class="horarios">
                                <div>
                                    <label>Hora salida</label>
                                    <input type="text" value="{{ $fechaItem->hora_inicio }}" disabled>
                                </div>
                                <div>
                                    <label>Hora llegada</label>
                                    <input type="text" value="{{ $fechaItem->hora_fin }}" disabled>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- LUGAR -->
            <div class="campo">
                <label>Nombre del establecimiento/lugar al que asistirán</label>
                <input type="text" value="{{ $formulario->nom_lugar }}" disabled>
            </div>

            <!-- DIRECCION -->
            <div class="campo">
                <label>Dirección del establecimiento/lugar al que asistirán</label>
                <input type="text" value="{{ $formulario->dir_lugar }}" disabled>
            </div>

            <!-- ESTUDIANTES (Tabla dinámica con datos de la relación) -->
            <div class="campo">
                <label>Nómina de estudiantes</label>
                <div class="tabla-contenedor">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formulario->estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->nombre }}</td>
                                    <td>{{ $estudiante->dni_estudiante }}</td>
                                    <td>{{ $estudiante->domicilio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PROFESORES (Tabla dinámica con datos de la relación) -->
            <div class="campo">
                <label>Nómina de profesores</label>
                <div class="tabla-contenedor">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($formulario->profesores as $profesor)
                                <tr>
                                    <td>{{ $profesor->nombre }}</td>
                                    <td>{{ $profesor->dni_profesor }}</td>
                                    <td>{{ $profesor->domicilio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BOTON CANCELAR -->
            
    </main>
    <section class="tarjeta">

        <h2>Cancelar solicitud</h2>

            @if(session('success'))
                <div style="
                    background-color:#d4edda;
                    color:#246b38;
                    padding:15px;
                    border-radius:10px;
                    margin-bottom:18px;
                ">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="
                    background-color:#f8d7da;
                    color:#842029;
                    padding:15px;
                    border-radius:10px;
                    margin-bottom:18px;
                ">
                    {{ session('error') }}
                </div>
            @endif

            @if($formulario->estado === 'cancelado')

                <p style="color:#842029; font-weight:bold;">
                    Esta solicitud se encuentra cancelada.
                </p>

            @else

                <p class="label" style="color: gray;">
                    Si necesitás cancelar esta solicitud, podés hacerlo
                    siempre que quede al menos un día hábil completo
                    antes de la próxima fecha de la actividad.
                </p>

                <form
                    action="{{ route('solicitud.cancelar', ['token' => $token]) }}"
                    method="POST"
                    onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta solicitud?');"
                >
                    @csrf

                    <button type="submit", class="cancelar">
                        Cancelar Solicitud
                    </button>
                </form>

            @endif

    </section>
</body>
</html>


