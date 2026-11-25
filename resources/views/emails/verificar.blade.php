
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de correo</title>
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
                            <h1 style="margin:0; color:#ffffff; font-size:25px; font-weight:bold;">
                                Gestión de solicitud de seguros
                            </h1>
                            <p style="margin:8px 0 0; color:#cceaf6; font-size:14px;">
                                Universidad Nacional del Chaco Austral
                            </p>
                        </td>
                    </tr>

                    <!-- Contenido -->
                    <tr>
                        <td style="padding:35px 30px;">

                            <h2 style="margin:0 0 20px; color:#145b78; font-size:22px;">
                                Verifique su correo electrónico
                            </h2>

                            <p style="font-size:15px; line-height:1.7; color:#555555;">
                                Hemos recibido una solicitud de seguro a través del sistema.
                            </p>

                            <p style="font-size:15px; line-height:1.7; color:#555555;">
                                Para confirmar que esta dirección de correo te pertenece,
                                necesitás hacer clic en el siguiente botón:
                            </p>

                            <!-- Botón -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding:25px 0;">
                                        <a href="{{ $url }}"
                                           style="display:inline-block; background-color:#159ed0; color:#ffffff; text-decoration:none; padding:15px 30px; border-radius:10px; font-size:16px; font-weight:bold;">
                                            Verificar mi correo
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:14px; line-height:1.6; color:#777777;">
                                Este enlace tiene una validez de 24 horas.
                                Si no realizaste esta solicitud, podés ignorar este mensaje.
                            </p>

                            <p style="font-size:13px; line-height:1.6; color:#999999; margin-top:25px;">
                                Si el botón no funciona, copiá y pegá el siguiente enlace
                                en tu navegador:
                                <br>
                                <a href="{{ $url }}" style="color:#159ed0; word-break:break-all;">
                                    {{ $url }}
                                </a>
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
