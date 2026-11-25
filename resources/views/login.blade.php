<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Seguros UNCAUS</title>
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
    <span>Acceso para Coordinadores y Operadores de Bienestar Estudiantil</span>
    <a href="{{ route('inicio') }}" class="btn-barra">← Volver al inicio</a>
</div>

<main class="login-main">
    <div class="login-card">
        <h2>Iniciar sesión</h2>
        <p class="subtitulo">Ingrese su nombre de usuario y contraseña</p>

        @if ($errors->any())
            <div class="alerta-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="campo">
                <label for="nombre">Nombre de usuario</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Ej: op1 o cordi1"
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

            <button type="submit" class="btn-ingresar">Iniciar sesión</button>
        </form>
    </div>
</main>

</body>
</html>
