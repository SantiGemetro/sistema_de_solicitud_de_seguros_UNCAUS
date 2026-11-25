
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de solicitud</title>
</head>

<body style="margin:0; padding:0; background-color:#f2f5f6; font-family:Arial, Helvetica, sans-serif; color:#333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
           style="background-color:#f2f5f6; padding:30px 10px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                       style="max-width:600px; width:100%; background-color:#ffffff; border-radius:14px; overflow:hidden;">

                    <!-- Encabezado -->
                    <tr>
                        <td style="background-color:#414c50; padding:25px 30px; border-top:6px solid #159ed0;">
                            <h1 style="margin:0; color:#ffffff; font-size:25px;">
                                Gestión de solicitud de seguros
                            </h1>
                            <p style="margin:8px 0 0; color:#cceaf6; font-size:14px;">
                                Universidad Nacional del Chaco Austral
                            </p>
                        </td>
                    </tr>

                    <!-- Contenido -->
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin:0 0 15px; color:#145b78; font-size:22px;">
                                ¡Solicitud confirmada!
                            </h2>

                            <p style="font-size:15px; line-height:1.7; color:#555555;">
                                Tu dirección de correo fue verificada correctamente
                                y la solicitud de seguro quedó registrada en el sistema.
                            </p>

                            <!-- Estado -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background-color:#e5f3f9; border-radius:10px; margin:20px 0;">
                                <tr>
                                    <td style="padding:18px;">
                                        <p style="margin:0; color:#145b78; font-size:13px;">
                                            ESTADO DE LA SOLICITUD
                                        </p>
                                        <p style="margin:8px 0 0; color:#159ed0; font-size:19px; font-weight:bold;">
                                            {{ $formulario->estado }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Datos -->
                            <h3 style="color:#145b78; font-size:17px; margin-top:25px;">
                                Datos de la solicitud
                            </h3>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background-color:#eeeeee; border-radius:10px;">

                                <tr>
                                    <td style="padding:12px 16px; border-bottom:1px solid #d5d5d5;">
                                        <strong>Actividad:</strong><br>
                                        {{ $formulario->actividad }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; border-bottom:1px solid #d5d5d5;">
                                        <strong>Lugar:</strong><br>
                                        {{ $formulario->nom_lugar }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:12px 16px; border-bottom:1px solid #d5d5d5;">
                                        <strong>Dirección:</strong><br>
                                        {{ $formulario->dir_lugar }}
                                    </td>
                                </tr>

                                @if($formulario->materia)
                                    <tr>
                                        <td style="padding:12px 16px; border-bottom:1px solid #d5d5d5;">
                                            <strong>Materia:</strong><br>
                                            {{ $formulario->materia }}
                                        </td>
                                    </tr>
                                @endif

                                @if($formulario->carrera)
                                    <tr>
                                        <td style="padding:12px 16px;">
                                            <strong>Carrera:</strong><br>
                                            {{ $formulario->carrera }}
                                        </td>
                                    </tr>
                                @endif

                            </table>

                            <!-- Fechas -->
                            <h3 style="color:#145b78; font-size:17px; margin-top:25px;">
                                Fechas de la actividad
                            </h3>

                            @forelse($formulario->fechas as $fecha)
                                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                       style="background-color:#eeeeee; border-radius:8px; margin-bottom:10px;">
                                    <tr>
                                        <td style="padding:14px 16px;">
                                            <strong style="color:#145b78;">
                                                {{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}
                                            </strong>
                                            <p style="margin:7px 0 0; font-size:14px; color:#666666;">
                                                Horario:
                                                {{ substr($fecha->hora_inicio, 0, 5) }}
                                                a
                                                {{ substr($fecha->hora_fin, 0, 5) }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @empty
                                <p style="color:#777777; font-size:14px;">
                                    No hay fechas registradas.
                                </p>
                            @endforelse

                            <!-- Consulta -->
                            <p style="font-size:15px; line-height:1.7; color:#555555; margin-top:25px;">
                                Podés consultar el estado de tu solicitud, revisar
                                sus datos o cancelarla ingresando desde el siguiente botón:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding:20px 0;">
                                        <a href="{{ $urlConsulta }}"
                                           style="display:inline-block; background-color:#159ed0; color:#ffffff; text-decoration:none; padding:15px 30px; border-radius:10px; font-size:16px; font-weight:bold;">
                                            Consultar mi solicitud
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:13px; color:#888888; line-height:1.6;">
                                Guardá este correo: el enlace te permitirá acceder
                                a tu solicitud posteriormente.
                            </p>

                        </td>
                    </tr>

                    <!-- Pie -->
                    <tr>
                        <td style="background-color:#e5f3f9; padding:20px 30px; text-align:center;">
                            <p style="margin:0; color:#145b78; font-size:13px;">
                                Sistema de Gestión de Solicitudes de Seguros
                            </p>
                            <p style="margin:6px 0 0; color:#777777; font-size:12px;">
                                Universidad Nacional del Chaco Austral
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
