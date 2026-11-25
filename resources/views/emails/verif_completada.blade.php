
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo verificado</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7f8;
            color: #333333;
        }

        .encabezado {
            background-color: #414c50;
            border-top: 5px solid #159ed0;
            padding: 25px 6%;
            color: white;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 28px;
        }

        .contenedor {
            width: 90%;
            max-width: 650px;
            margin: 65px auto;
        }

        .tarjeta {
            background-color: white;
            border-radius: 18px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        }

        .icono {
            width: 75px;
            height: 75px;
            line-height: 75px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background-color: #b8e2c0;
            color: #278b43;
            font-size: 42px;
            font-weight: bold;
        }

        h2 {
            color: #145b78;
            font-size: 25px;
            margin-bottom: 18px;
        }

        p {
            color: #666666;
            font-size: 16px;
            line-height: 1.7;
        }

        .mensaje {
            background-color: #e5f3f9;
            border-radius: 12px;
            padding: 16px;
            margin: 25px 0;
            color: #145b78;
            font-size: 14px;
        }

        .boton {
            display: inline-block;
            margin-top: 15px;
            padding: 13px 25px;
            background-color: #159ed0;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 16px;
        }

        .boton:hover {
            background-color: #087eae;
        }

        .pie {
            padding: 20px;
            text-align: center;
            background-color: #e5f3f9;
            color: #145b78;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <header class="encabezado">
        <h1>Gestión de solicitud de seguros</h1>
    </header>

    <main class="contenedor">

        <section class="tarjeta">

            <div class="icono">✓</div>

            <h2>¡Correo verificado correctamente!</h2>

            <p>
                Tu dirección de correo electrónico fue confirmada
                y tu solicitud de seguro quedó registrada.
            </p>

            <div class="mensaje">
                Recibirás un correo electrónico con el comprobante
                y un enlace privado para consultar el estado de tu solicitud.
            </div>

            <p>
                Ya podés cerrar esta página.
            </p>

        </section>

    </main>

    <footer class="pie">
        Sistema de Gestión de Solicitudes de Seguros
        <br>
        Universidad Nacional del Chaco Austral
    </footer>

</body>
</html>
