<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo operador - Gestión de solicitud de seguros</title>
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
</head>
<body>

<header>
    <h1>Gestión de solicitud de seguros</h1>
    <div class="logo-container">
        <img src="{{ asset('images/isologo-uncaus-blanco.png') }}" alt="Logo UNCAUS" class="logo-uncaus">
    </div>
</header>

<main class="registro-main">
    <h2 class="titulo-registro">Registrar nuevo operador de BE</h2>

    <div class="card-azul">
        @if ($errors->any())
            <div class="alerta-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('operador.store') }}" method="POST">
            @csrf

            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    maxlength="155"
                    required
                    autofocus
                >
            </div>

            <div class="campo">
                <label for="correo">Correo</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    value="{{ old('correo') }}"
                    maxlength="155"
                    required
                >
            </div>

            <div class="campo">
                <label for="contraseña">Contraseña</label>
                <div class="password-wrapper">
                    <input
                        type="password"
                        id="contraseña"
                        name="contraseña"
                        maxlength="255"
                        required
                    >
                    <button
                        type="button"
                        class="btn-ojo"
                        onclick="togglePassword()"
                        aria-label="Mostrar u ocultar contraseña"
                    >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="acciones-card">
                <a href="{{ route('operador.index') }}" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-guardar">Registrar</button>
            </div>
        </form>
    </div>
</main>

<script>
    function togglePassword() {
        const input = document.getElementById('contraseña');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>
