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
                <input type="text" value="{{ $formulario->estado }}" disabled>
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

            <!-- BOTONES FINALES -->
            <div class="acciones">
                <a class="cancelar">
                    Cancelar Solicitud
                </a>
            </div>

        </form>
    </main>

</body>
</html>


