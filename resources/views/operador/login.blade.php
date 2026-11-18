<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Operador de Bienestar UNCAUS</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #222;
            background: #f5f6f8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ENCABEZADO UNCAUS */

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

        .barra-operador {
            background: #e1b81c;
            padding: 12px 5%;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        /* CONTENEDOR DE LOGIN */

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .login-card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            border-radius: 14px;
            padding: 32px 28px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e2e2;
        }

        .login-card h2 {
            margin: 0 0 8px 0;
            font-size: 24px;
            font-weight: 500;
            color: #222;
            text-align: center;
        }

        .login-card p.subtitulo {
            margin: 0 0 24px 0;
            font-size: 14px;
            color: #666;
            text-align: center;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d4d4d4;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }

        input:focus {
            outline: none;
            border-color: #189bd0;
        }

        .alerta-error {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .btn-ingresar {
            width: 100%;
            background: #189bd0;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 6px;
        }

        .btn-ingresar:hover {
            background: #1382af;
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
    Acceso para Operadores de Bienestar Estudiantil
</div>

<main>
    <div class="login-card">
        <h2>Iniciar sesión</h2>
        <p class="subtitulo">Ingrese sus credenciales de operador</p>

        @if ($errors->any())
            <div class="alerta-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('operador.login.post') }}" method="POST">
            @csrf

            <div class="campo">
                <label for="correo">Correo electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    placeholder="op1@gmail.com"
                    required
                    autofocus
                >
            </div>

            <div class="campo">
                <label for="contraseña">Contraseña</label>
                <input
                    type="password"
                    id="contraseña"
                    name="contraseña"
                    placeholder="Ingrese su contraseña"
                    required
                >
            </div>

            <button type="submit" class="btn-ingresar">Ingresar al panel</button>
        </form>
    </div>
</main>

</body>
</html>
