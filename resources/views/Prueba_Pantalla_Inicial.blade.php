@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px auto; max-width: 1120px; border: 1px solid #c3e6cb; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestión de Solicitud de Seguros</title>
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
        <div class="contenedor-inicio">
            <h2>Bienvenido al Sistema de Seguros Estudiantiles</h2>
            <p class="ayuda">Seleccione una opción para comenzar:</p>

            <!-- Lleva al formulario de solicitud -->
            <a href="{{ route('Formulario.create') }}" class="btn-principal">Realizar solicitud</a>

            <!-- Botón único de inicio de sesión para Coordinadores y Operadores de BE -->
            <a href="{{ route('login') }}" class="btn-principal btn-secundario">Iniciar sesión</a>
        </div>
    </main>
</body>
</html>
