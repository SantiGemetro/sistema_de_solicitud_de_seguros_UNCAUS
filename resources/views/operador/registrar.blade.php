<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo operador - Gestión de solicitud de seguros</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #222;
            background: #ffffff;
            min-height: 100vh;
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

        /* CONTENEDOR PRINCIPAL ESTILO REFERENCIA */

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 35px 20px 60px;
        }

        .titulo-registro {
            color: #189bd0;
            font-size: 22px;
            font-weight: 500;
            margin: 0 0 14px 0;
            text-align: center;
        }

        .card-azul {
            background: #1496cf;
            width: 100%;
            max-width: 460px;
            padding: 26px 28px 30px;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #ffffff;
            font-weight: normal;
        }

        .campo input {
            width: 100%;
            height: 40px;
            padding: 8px 14px;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            background: #ededed;
            color: #222;
        }

        .campo input:focus {
            outline: 2px solid #ffffff;
            background: #ffffff;
        }

        /* CAMPO CONTRASEÑA CON ÍCONO DE OJO */

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            padding-right: 44px;
        }

        .btn-ojo {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .btn-ojo:hover {
            color: #222;
        }

        /* ALERTAS DE ERROR */

        .alerta-error {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            padding: 10px 14px;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .alerta-error ul {
            margin: 0;
            padding-left: 18px;
        }

        /* BOTONES */

        .acciones-card {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 26px;
        }

        .btn-cancelar {
            background: #414d51;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 7px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-cancelar:hover {
            background: #313a3d;
        }

        .btn-guardar {
            background: #e1b81c;
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 7px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-guardar:hover {
            background: #c9a314;
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

<main>
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
