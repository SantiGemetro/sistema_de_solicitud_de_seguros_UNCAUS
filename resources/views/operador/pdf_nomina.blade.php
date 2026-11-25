<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nómina de Estudiantes a Asegurar - {{ $referencia }}</title>
    <style>
        @page {
            margin: 35px 40px 40px 40px;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            margin: 0;
            padding: 0;
        }

        /* Solo el isologo limpio sobre la hoja blanca, sin barra gris */
        .logo-encabezado {
            margin-bottom: 10px;
        }

        .logo-encabezado img {
            height: 48px;
            width: auto;
            display: block;
        }

        .encabezado-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .encabezado-tabla td {
            border: none;
            padding: 0;
            font-size: 12px;
        }

        .ref-derecha {
            text-align: right;
        }

        .titulo-principal {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0 20px 0;
        }

        .meta-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .meta-tabla td {
            border: none;
            padding: 3px 4px 3px 0;
            font-size: 11px;
            vertical-align: top;
        }

        .meta-label {
            width: 155px;
            font-weight: bold;
        }

        /* Pila de fechas con horarios */
        .fecha-item {
            margin-bottom: 3px;
            line-height: 1.35;
        }

        .nomina-tabla {
            width: 85%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 14px;
        }

        .nomina-tabla th,
        .nomina-tabla td {
            border: 1px solid #000000;
            padding: 4px 6px;
            font-size: 11px;
        }

        .nomina-tabla th {
            font-weight: bold;
            text-align: left;
            background-color: #ffffff;
        }

        .col-num {
            width: 28px;
            text-align: right;
        }

        .col-nombre {
            width: 185px;
            text-align: left;
        }

        .col-dni {
            width: 95px;
            text-align: right;
        }

        .col-domicilio {
            width: 165px;
            text-align: left;
        }

        .total-tabla {
            width: 85%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .total-tabla td {
            border: none;
            padding: 4px 2px;
            font-size: 11px;
        }

        .total-valor {
            text-align: right;
        }

        .subtitulo-seccion {
            font-size: 11px;
            font-weight: bold;
            margin: 18px 0 6px 0;
            text-transform: uppercase;
        }

        .pie-documento {
            margin-top: 22px;
            font-size: 9px;
            color: #222222;
        }
    </style>
</head>
<body>

    @php
        $rutaLogo = public_path('images/isologo-uncaus-blanco.png');
        $logoBase64 = null;

        if (file_exists($rutaLogo)) {
            if (function_exists('imagecreatefrompng') && function_exists('imagejpeg')) {
                // Convierte el texto blanco del isologo a gris oscuro (#2b3438) sobre fondo blanco limpio,
                // conservando intactos los colores azul y verde del triángulo izquierdo.
                $src = @imagecreatefrompng($rutaLogo);
                if ($src) {
                    $w = imagesx($src);
                    $h = imagesy($src);
                    $canvas = imagecreatetruecolor($w, $h);
                    $blanco = imagecolorallocate($canvas, 255, 255, 255);
                    imagefill($canvas, 0, 0, $blanco);

                    $limiteTriangulo = (int) ($w * 0.34);

                    for ($y = 0; $y < $h; $y++) {
                        for ($x = 0; $x < $w; $x++) {
                            $rgba = imagecolorat($src, $x, $y);
                            $a = ($rgba >> 24) & 0x7F; // 0 = opaco, 127 = transparente
                            if ($a === 127) {
                                continue;
                            }

                            $r = ($rgba >> 16) & 0xFF;
                            $g = ($rgba >> 8) & 0xFF;
                            $b = $rgba & 0xFF;

                            $opacidad = 1 - ($a / 127);

                            // En la zona de letras (derecha del triángulo), oscurecemos el texto blanco
                            if ($x > $limiteTriangulo) {
                                $r = 43;
                                $g = 52;
                                $b = 56;
                            }

                            $outR = (int) round($r * $opacidad + 255 * (1 - $opacidad));
                            $outG = (int) round($g * $opacidad + 255 * (1 - $opacidad));
                            $outB = (int) round($b * $opacidad + 255 * (1 - $opacidad));

                            $color = imagecolorallocate($canvas, $outR, $outG, $outB);
                            imagesetpixel($canvas, $x, $y, $color);
                        }
                    }

                    ob_start();
                    imagejpeg($canvas, null, 95);
                    $jpegData = ob_get_clean();

                    imagedestroy($src);
                    imagedestroy($canvas);

                    $logoBase64 = 'data:image/jpeg;base64,' . base64_encode($jpegData);
                }
            }

            if (!$logoBase64) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($rutaLogo));
            }
        }

        $fechasOrdenadas = $formulario->fechas->sortBy('fecha')->values();
        $estudiantesOrdenados = $formulario->estudiantes->sortBy('nombre')->values();
        $profesoresOrdenados = $formulario->profesores->sortBy('nombre')->values();
    @endphp

    <!-- Solo el isologo y letras de UNCAUS sobre fondo blanco -->
    @if($logoBase64)
        <div class="logo-encabezado">
            <img src="{{ $logoBase64 }}" alt="Logo UNCAUS">
        </div>
    @endif

    <!-- Encabezado superior: Universidad a la izquierda, REF a la derecha -->
    <table class="encabezado-tabla">
        <tr>
            <td>Universidad Nacional del Chaco Austral</td>
            <td class="ref-derecha">REF: {{ $referencia }}</td>
        </tr>
    </table>

    <div class="titulo-principal">
        NÓMINA DE ESTUDIANTES A ASEGURAR - SALIDA ESTUDIANTIL
    </div>

    <!-- Datos de cobertura: Fecha de cobertura, Carrera arriba de Materia -->
    <table class="meta-tabla">
        <tr>
            <td class="meta-label">Carrera:</td>
            <td>{{ $formulario->carrera ?? 'No aplica' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Materia:</td>
            <td>{{ $formulario->materia ?? 'No aplica' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Fecha de cobertura:</td>
            <td>
                @forelse($fechasOrdenadas as $f)
                    @php
                        $fechaTexto = ucfirst(\Carbon\Carbon::parse($f->fecha)->locale('es')->translatedFormat('l j \d\e F \d\e Y'));
                        $horaInicio = substr((string) $f->hora_inicio, 0, 5);
                        $horaFin = substr((string) $f->hora_fin, 0, 5);
                    @endphp
                    <div class="fecha-item">
                        {{ $fechaTexto }} — Inicio: {{ $horaInicio }} | Fin: {{ $horaFin }}
                    </div>
                @empty
                    Sin fecha registrada
                @endforelse
            </td>
        </tr>
    </table>

    <!-- Tabla principal de estudiantes -->
    <table class="nomina-tabla">
        <thead>
            <tr>
                <th class="col-num" style="text-align: left;">N°</th>
                <th class="col-nombre">Apellido y nombre</th>
                <th class="col-dni" style="text-align: left;">DNI</th>
                <th class="col-domicilio">Domicilio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($estudiantesOrdenados as $index => $est)
                <tr>
                    <td class="col-num">{{ $index + 1 }}</td>
                    <td class="col-nombre">{{ $est->nombre }}</td>
                    <td class="col-dni">{{ $est->dni_estudiante }}</td>
                    <td class="col-domicilio">{{ $est->domicilio ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Sin estudiantes registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="total-tabla">
        <tr>
            <td>Total de estudiantes a asegurar</td>
            <td class="total-valor">{{ $estudiantesOrdenados->count() }}</td>
        </tr>
    </table>

    <!-- Tabla de profesores acompañantes (si existen) -->
    @if($profesoresOrdenados->count() > 0)
        <div class="subtitulo-seccion">Nómina de profesores acompañantes</div>
        <table class="nomina-tabla">
            <thead>
                <tr>
                    <th class="col-num" style="text-align: left;">N°</th>
                    <th class="col-nombre">Apellido y nombre</th>
                    <th class="col-dni" style="text-align: left;">DNI</th>
                    <th class="col-domicilio">Domicilio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profesoresOrdenados as $index => $prof)
                    <tr>
                        <td class="col-num">{{ $index + 1 }}</td>
                        <td class="col-nombre">{{ $prof->nombre }}</td>
                        <td class="col-dni">{{ $prof->dni_profesor }}</td>
                        <td class="col-domicilio">{{ $prof->domicilio ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total-tabla">
            <tr>
                <td>Total de profesores a asegurar</td>
                <td class="total-valor">{{ $profesoresOrdenados->count() }}</td>
            </tr>
        </table>
    @endif

    <div class="pie-documento">
        Documento generado automáticamente por el Sistema de Gestión de Seguros
    </div>

</body>
</html>
