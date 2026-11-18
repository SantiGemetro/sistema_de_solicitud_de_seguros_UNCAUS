<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo coordinador - Gestión de solicitud de seguros</title>
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

            <!-- ÁMBITO DE COORDINACIÓN -->
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
