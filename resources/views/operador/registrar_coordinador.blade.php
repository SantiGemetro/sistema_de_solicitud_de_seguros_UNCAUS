<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo coordinador - Gestión de solicitud de seguros</title>
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
            padding: 32px 20px 60px;
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
            max-width: 470px;
            padding: 24px 28px 30px;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        }

        .campo {
            margin-bottom: 16px;
        }

        .campo label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #ffffff;
            font-weight: normal;
        }

        .campo input,
        .campo select {
            width: 100%;
            height: 40px;
            padding: 8px 14px;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            background: #ededed;
            color: #222;
        }

        .campo input:focus,
        .campo select:focus {
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

        /* CAMPO NÚMERO TELEFÓNICO (+54 9 [ ] [ ] - [ ]) */

        .telefono-fila {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            color: #ffffff;
        }

        .prefijo-pais {
            white-space: nowrap;
            font-size: 14px;
        }

        .input-tel-corto {
            width: 68px !important;
            text-align: center;
        }

        .input-tel-largo {
            width: 105px !important;
            text-align: center;
        }

        /* RECUADRO DE FIRMA Y ACLARACIÓN */

        .firma-box {
            width: 100%;
            max-width: 350px;
            height: 175px;
            background: #d9d9d9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
            border: 2px dashed transparent;
            transition: background 0.15s, border-color 0.15s;
        }

        .firma-box:hover {
            background: #e2e2e2;
            border-color: #ffffff;
        }

        .firma-box span {
            margin-top: 6px;
            font-size: 14px;
            color: #666;
        }

        /* ALERTAS DE ERROR */

        .alerta-error {
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            color: #842029;
            padding: 10px 14px;
            border-radius: 7px;
            margin-bottom: 16px;
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
            margin-top: 24px;
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
    <h2 class="titulo-registro">Registrar nuevo coordinador</h2>

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

        <form action="{{ route('coordinador.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- NOMBRE -->
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

            <!-- ÁMBITO DE COORDINACIÓN (REEMPLAZA EL ENCABEZADO "TIPO" Y ENVÍA 'carrera' O 'area' AL ENUM DE LA BD) -->
            <div class="campo">
                <label for="tipo">Ámbito de coordinación</label>
                <select id="tipo" name="tipo" required>
                    <option value="carrera" {{ old('tipo', 'carrera') === 'carrera' ? 'selected' : '' }}>
                        Coordinador de Carrera
                    </option>
                    <option value="area" {{ old('tipo') === 'area' ? 'selected' : '' }}>
                        Coordinador de Área
                    </option>
                </select>
            </div>

            <!-- DESPLEGABLE DINÁMICO DE CARRERA O ÁREA CARGADO CON EL SCRIPT -->
            <div class="campo">
                <label id="label-carrera" for="carrera">Carrera</label>
                <select id="carrera" name="carrera" required>
                    <!-- Opciones cargadas dinámicamente por el script -->
                </select>
            </div>

            <!-- CORREO -->
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

            <!-- CONTRASEÑA -->
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

            <!-- NÚMERO (+54 9 [ ] [ ] - [ ]) -->
            <div class="campo">
                <label>Número</label>
                <div class="telefono-fila">
                    <span class="prefijo-pais">+54 9</span>
                    <input
                        type="text"
                        name="cod_area"
                        class="input-tel-corto"
                        value="{{ old('cod_area') }}"
                        placeholder="364"
                        maxlength="5"
                        required
                    >
                    <input
                        type="text"
                        name="prefijo"
                        class="input-tel-corto"
                        value="{{ old('prefijo') }}"
                        placeholder="400"
                        maxlength="5"
                        required
                    >
                    <span>-</span>
                    <input
                        type="text"
                        name="numero_final"
                        class="input-tel-largo"
                        value="{{ old('numero_final') }}"
                        placeholder="0000"
                        maxlength="6"
                        required
                    >
                </div>
            </div>

            <!-- FIRMA Y ACLARACIÓN -->
            <div class="campo">
                <label>Firma y aclaración</label>
                <label for="firma_aclaracion" class="firma-box">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <span id="texto-firma">Cargar</span>
                </label>
                <input
                    type="file"
                    id="firma_aclaracion"
                    name="firma_aclaracion"
                    accept="image/*,.pdf"
                    style="display: none;"
                >
            </div>

            <div class="acciones-card">
                <a href="{{ route('operador.index') }}" class="btn-cancelar">Cancelar</a>
                <button type="submit" class="btn-guardar">Registrar</button>
            </div>
        </form>
    </div>
</main>

<script>
// ==========================================
// 1. CARRERAS Y MATERIAS
// ==========================================

const materiasPorCarrera = {

    "Ingeniería en Sistemas": [
        "Programación I",
        "Programación II",
        "Sistemas Operativos",
        "Bases de Datos",
        "Ingeniería de Software"
    ],

    "Contador Público": [
        "Contabilidad I",
        "Contabilidad II",
        "Auditoría",
        "Matemática Financiera"
    ],

    "Abogacía": [
        "Derecho Civil",
        "Derecho Penal",
        "Derecho Constitucional"
    ],

    "Licenciatura en Administración": [
        "Administración General",
        "Economía",
        "Marketing",
        "Gestión de Recursos Humanos"
    ]

};

// ==========================================
// 2. ÁREAS INSTITUCIONALES (MISMO FORMATO)
// ==========================================

const actividadesPorArea = {

    "Deportes": [
        "Torneos Universitarios",
        "Entrenamiento Deportivo",
        "Competencias Regionales"
    ],

    "Cultura": [
        "Talleres Culturales",
        "Eventos Artísticos",
        "Coro y Música"
    ],

    "Bienestar Estudiantil": [
        "Jornadas Estudiantiles",
        "Campañas de Salud",
        "Becas y Comedor"
    ],

    "Extensión Universitaria": [
        "Proyectos Comunitarios",
        "Capacitaciones Externas",
        "Congresos y Jornadas"
    ],

    "Investigación": [
        "Trabajo de Campo",
        "Visitas a Laboratorios",
        "Encuentros Científicos"
    ]

};

const selectTipo = document.getElementById("tipo");
const selectCarreraOArea = document.getElementById("carrera");
const labelCarreraOArea = document.getElementById("label-carrera");
const valorPrevio = @json(old('carrera', ''));

function actualizarDesplegable() {
    const esArea = selectTipo.value === "area";
    labelCarreraOArea.textContent = esArea ? "Área" : "Carrera";

    const opciones = esArea
        ? Object.keys(actividadesPorArea)
        : Object.keys(materiasPorCarrera);

    selectCarreraOArea.innerHTML = "";

    const placeholder = document.createElement("option");
    placeholder.value = "";
    placeholder.textContent = esArea ? "Seleccione un área" : "Seleccione una carrera";
    selectCarreraOArea.appendChild(placeholder);

    opciones.forEach(nombre => {
        const option = document.createElement("option");
        option.value = nombre;
        option.textContent = nombre;
        if (valorPrevio === nombre) {
            option.selected = true;
        }
        selectCarreraOArea.appendChild(option);
    });
}

selectTipo.addEventListener("change", actualizarDesplegable);
actualizarDesplegable();

function togglePassword() {
    const input = document.getElementById("contraseña");
    input.type = input.type === "password" ? "text" : "password";
}

document.getElementById("firma_aclaracion").addEventListener("change", function() {
    const texto = document.getElementById("texto-firma");
    texto.textContent = this.files.length > 0 ? this.files[0].name : "Cargar";
});
</script>

</body>
</html>
