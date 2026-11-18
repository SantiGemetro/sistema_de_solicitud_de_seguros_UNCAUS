<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Operador de Bienestar UNCAUS</title>
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body class="pagina-login">

<header>
    <h1>Gestión de solicitud de seguros</h1>
    <div class="logo-container">
        <img src="{{ asset('images/isologo-uncaus-blanco.png') }}" alt="Logo UNCAUS" class="logo-uncaus">
    </div>
</header>

<div class="barra-operador">
    Acceso para Operadores de Bienestar Estudiantil
</div>

<main class="login-main">
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
