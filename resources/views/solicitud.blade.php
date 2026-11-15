
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Solicitud de seguros estudiantiles</title>

    <!--estilo-->
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    
</head>

<body>

    <header>
        <h1>Gestión de solicitud de seguros</h1>

        <!-- Reemplazar por el logo real -->
        <div class="logo-placeholder">
            LOGO UNCAUS
        </div>
    </header>

    <main>

    <form id="formularioSeguro"
        action="{{ route('Formulario.store') }}"
        method="POST">

        @csrf

        <!-- CARRERA -->

        <div class="campo">
            <label for="carrera">Carrera</label>

            <select name="carrera" id="carrera" required>
                <option value="">Seleccione una carrera</option>
                <option value="Ingeniería en Sistemas">
                    Ingeniería en Sistemas
                </option>
                <option value="Contador Público">
                    Contador Público
                </option>
                <option value="Abogacía">
                    Abogacía
                </option>
                <option value="Licenciatura en Administración">
                    Licenciatura en Administración
                </option>
            </select>
        </div>

        <!-- MATERIA -->

        <div class="campo">
            <label for="materia">Materia</label>

            <div class="materia-container">
                <input type="text"
                    id="materia"
                    name="materia"
                    placeholder="Primero seleccione una carrera"
                    disabled
                    autocomplete="off"
                    required>

                <div id="resultados-materia"></div>
            </div>
        </div>

        <!-- ACTIVIDAD -->

        <div class="campo">
            <label for="actividad">
                Actividad a realizar (detallar brevemente)
            </label>

            <textarea name="actividad"
                    id="actividad"
                    maxlength="255"
                    required></textarea>
        </div>

        <!-- FECHAS -->

        <div class="campo">

            <label>Fechas de las actividades a realizar</label>

            <p class="ayuda">
                Seleccione días individuales haciendo clic sobre ellos,
                o arrastre el cursor para seleccionar un rango de fechas.
            </p>

            <div class="calendario-contenedor">

                <div id="calendario"></div>

                <div>
                    <h3>Fechas seleccionadas</h3>

                    <p class="ayuda">
                        Puede modificar el horario de cada día
                        individualmente.
                    </p>

                    <div id="lista-fechas"></div>
                </div>

            </div>

            <!-- Los datos se enviarán como JSON -->
            <input type="hidden"
                name="fechas"
                id="fechas">

        </div>

        <!-- LUGAR -->

        <div class="campo">
            <label for="nom_lugar">
                Nombre del establecimiento/lugar al que asistirán
            </label>

            <input type="text"
                name="nom_lugar"
                id="nom_lugar"
                maxlength="155"
                required>
        </div>

        <!-- DIRECCION -->

        <div class="campo">
            <label for="dir_lugar">
                Dirección del establecimiento/lugar al que asistirán
            </label>

            <input type="text"
                name="dir_lugar"
                id="dir_lugar"
                maxlength="155"
                required>
        </div>

        <!-- ESTUDIANTES -->

        <div class="campo">

            <label>Nómina de estudiantes</label>

            <p class="ayuda">
                Puede escribir directamente en las celdas o pegar
                datos copiados desde una tabla.
            </p>

            <div class="tabla-fila">

                <div class="tabla-contenedor" style="flex:1">

                    <table id="tabla-estudiantes">

                        <thead>
                            <tr>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <button type="button"
                        class="boton-agrqut"
                        onclick="agregarFila('tabla-estudiantes')">
                    +
                </button>

                <button type="button"
                        class="boton-agrqut"
                        onclick="quitarFila('tabla-estudiantes')">
                    -
                </button>

            </div>

            <input type="hidden"
                name="estudiantes"
                id="estudiantes">

        </div>

        <!-- PROFESORES -->

        <div class="campo">

            <label>Nómina de profesores</label>

            <div class="tabla-fila">

                <div class="tabla-contenedor" style="flex:1">

                    <table id="tabla-profesores">

                        <thead>
                            <tr>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                                <td contenteditable="true"></td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <button type="button"
                        class="boton-agrqut"
                        onclick="agregarFila('tabla-profesores')">
                    +
                </button>

                <button type="button"
                        class="boton-agrqut"
                        onclick="quitarFila('tabla-profesores')">
                    -
                </button>

            </div>

            <input type="hidden"
                name="profesores"
                id="profesores">

        </div>

        <!-- CORREO -->

        <div class="campo">
            <label for="email">
                Indíquenos su correo electrónico para mantenerlo informado
            </label>

            <input type="email"
                name="email"
                id="email"
                required>
        </div>

        <!-- BOTONES -->

        <div class="acciones">

            <button type="reset" class="cancelar">
                Cancelar
            </button>

            <button type="submit" class="enviar">
                Enviar
            </button>

        </div>

    </form>

    </main>

    <script>

    // ........................................
    // CARRERAS Y MATERIAS (cambiable)
    // ........................................

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

    const carrera = document.getElementById("carrera");
    const materia = document.getElementById("materia");
    const resultados = document.getElementById("resultados-materia");

    let materiaSeleccionada = false;

    carrera.addEventListener("change", function() {

        materia.value = "";
        materiaSeleccionada = false;
        resultados.innerHTML = "";

        materia.disabled = !this.value;

        materia.placeholder = this.value
            ? "Buscar materia..."
            : "Primero seleccione una carrera";

    });

    materia.addEventListener("input", function() {

        materiaSeleccionada = false;
        mostrarMaterias(this.value);

    });

    function mostrarMaterias(texto) {

        resultados.innerHTML = "";

        const materias = materiasPorCarrera[carrera.value] || [];

        const coincidencias = materias.filter(m =>
            m.toLowerCase().includes(texto.toLowerCase())
        );

        coincidencias.forEach(nombre => {

            const opcion = document.createElement("div");

            opcion.className = "opcion-materia";
            opcion.textContent = nombre;

            opcion.addEventListener("click", function() {

                materia.value = nombre;
                materiaSeleccionada = true;
                resultados.innerHTML = "";

            });

            resultados.appendChild(opcion);

        });

    }

    document.addEventListener("click", function(e) {

        if (!materia.contains(e.target) &&
            !resultados.contains(e.target)) {

            resultados.innerHTML = "";

        }

    });


    // ........................................
    //  CALENDARIO Y HORARIOS
    // ........................................

    const fechasSeleccionadas = new Map();
    const listaFechas = document.getElementById("lista-fechas");

    //convierte fecha a formato d/m/a
    function fechaLocal(fecha) {
        const año = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, "0");
        const dia = String(fecha.getDate()).padStart(2, "0");

        return `${año}-${mes}-${dia}`;
    }

    //agregar fecha individual al map
    function agregarFecha(fecha) {
        console.log("AGREGANDO FECHA:", fecha);
        if (fechasSeleccionadas.has(fecha)) return; //si la fecha seleccionada ya estaba seleccionada, parar la funcion
        fechasSeleccionadas.set(fecha, {
            inicio: "08:00",
            fin: "12:00"
        });
        console.log("MAP DESPUÉS DE AGREGAR:", [...fechasSeleccionadas]);
        //actualizarFechas(); //actualiza interfaz despues de modificar datos
    }

    //al seleccionar o deseleccionar fechas
    function alternarFecha(fecha) {
        console.log("ALTERNAR FECHA:", fecha);
        console.log("¿YA EXISTE?", fechasSeleccionadas.has(fecha));
        if (fechasSeleccionadas.has(fecha)) { //si la fecha ya esta selecionada
            console.log("ELIMINANDO:", fecha);
            fechasSeleccionadas.delete(fecha); //eliminarla del mapa
        } else { //sino
            console.log("NO EXISTE. AGREGANDO:", fecha);
            agregarFecha(fecha); //agregarla al mapa
        }
        actualizarFechas(); //<<aca esta el error
    }

    //para seleccionar un rango de fechas
    function agregarRango(inicio, fin) {

        const actual = new Date(inicio + "T12:00:00");
        const limite = new Date(fin + "T12:00:00");

        while (actual < limite) {
            agregarFecha(fechaLocal(actual)); //convertir formato para agregar
            actual.setDate(actual.getDate() + 1); //avanzar el bucle
        }
        actualizarFechas(); //n
    }

    //crea el sector de las tarjetas 
    function actualizarFechas() {
        listaFechas.innerHTML = ""; //limpiar html
        const fechas = Array.from(fechasSeleccionadas.keys()).sort(); //convierte las llaves del map a un arreglo y las ordena cronologicamente
        fechas.forEach(fecha => {
            //obtiene horas y escribe todo en formato legible
            const horario = fechasSeleccionadas.get(fecha);
            const fechaBonita = new Date(fecha + "T12:00:00").toLocaleDateString("es-AR", {
                weekday: "long",
                day: "2-digit",
                month: "2-digit",
                year: "numeric"
            });

            //crear las tarjeta
            const tarjeta = document.createElement("div");
            tarjeta.className = "fecha-card";

            tarjeta.innerHTML = `
                <button type="button"
                        class="eliminar-fecha"
                        aria-label="Eliminar fecha">
                    ×
                </button>

                <strong>${fechaBonita}</strong>

                <div class="horarios">

                    <div>
                        <label>Hora de salida</label>
                        <input type="time"
                            class="hora-inicio"
                            value="${horario.inicio}">
                    </div>

                    <div>
                        <label>Hora de llegada</label>
                        <input type="time"
                            class="hora-fin"
                            value="${horario.fin}">
                    </div>

                </div>
            `;

            //opciones de la tarjeta
            tarjeta.querySelector(".eliminar-fecha")
                .addEventListener("click", () => {
                    fechasSeleccionadas.delete(fecha);
                    actualizarFechas();
                });

            tarjeta.querySelector(".hora-inicio")
                .addEventListener("change", function() {
                    horario.inicio = this.value;
                });

            tarjeta.querySelector(".hora-fin")
                .addEventListener("change", function() {
                    horario.fin = this.value;
                });

            listaFechas.appendChild(tarjeta);
        });
        // Mantener sincronizado el calendario
        calendario.render();
    }

    // Inicializar calendario
    console.count("Inicialización del calendario"); //debug
    const calendario = new FullCalendar.Calendar(
        document.getElementById("calendario"),
        {
            initialView: "dayGridMonth",
            locale: "es",

            selectable: true,
            unselectAuto: true,

            height: "auto",

            buttonText: {
                today: "Hoy",
                month: "Mes"
            },

            /* dateClick: function(info) {
                alternarFecha(info.dateStr);
            }, */

            dateClick: function(info) {
                console.count("dateClick ejecutado");
                console.log("Fecha clickeada:", info.dateStr);
                console.log(
                    "Map antes:",
                    [...fechasSeleccionadas]
                );
                alternarFecha(info.dateStr);
                console.log(
                    "Map después:",
                    [...fechasSeleccionadas]
                );
            },
            select: function(info) {
                console.log("EVENTO SELECT EJECUTADO");

                console.log("INICIO:", info.startStr);
                console.log("FIN:", info.endStr);
                // Calcular la cantidad de días seleccionados
                const dias = (
                    Date.parse(info.endStr) -
                    Date.parse(info.startStr)
                ) / (1000 * 60 * 60 * 24);

                // Si solamente es un día, ignorar este evento
                if (dias <= 1) return;

                // Si son varios días, agregar el rango
                agregarRango(info.startStr, info.endStr);
            },

            dayCellClassNames: function(info) {
                const fecha = fechaLocal(info.date);
                return fechasSeleccionadas.has(fecha)? ["selected-date"] : [];
            }
        }
    );
    calendario.render();

    // ........................................
    // DINAMISMO DE TABLAS
    // ........................................

    function agregarFila(idTabla) {

        const tbody = document.querySelector(`#${idTabla} tbody`);
        //crear fila tr
        const fila = document.createElement("tr");

        //crear celdas para la fila td
        for (let i = 0; i < 3; i++) {
            const celda = document.createElement("td");
            celda.contentEditable = "true";
            fila.appendChild(celda);
        }

        tbody.appendChild(fila);
    }

    let filaSeleccionada = null;
    document.addEventListener("click", function(e) {
        if (e.target.closest("td[contenteditable='true']")) { //si el elemento seleccionado pertenece a una celda
            filaSeleccionada = e.target.closest("tr"); //la variable es la fila a la que pertenece esa celda
        }
    });

    function quitarFila (idTabla){
        const tabla = document.getElementById(idTabla);

        if (filaSeleccionada && tabla.contains(filaSeleccionada)) {
            filaSeleccionada.remove();
            filaSeleccionada = null;
        }
    }

    // Pegar tabla desde Excel o Word

    document.querySelectorAll("table").forEach(tabla => {

        tabla.addEventListener("paste", function(e) {

            const celda = e.target.closest(
                'td[contenteditable="true"]'
            );

            if (!celda) return;

            e.preventDefault();

            let filas = [];

            // Intentar obtener tabla HTML copiada
            const html = e.clipboardData.getData("text/html");

            if (html && html.includes("<table")) {

                const doc = new DOMParser().parseFromString(
                    html, "text/html"
                );

                filas = Array.from(
                    doc.querySelectorAll("tr")
                ).map(tr =>
                    Array.from(tr.querySelectorAll("th, td"))
                        .map(td => td.innerText)
                );

            } else {

                const texto = e.clipboardData.getData("text/plain");

                filas = texto.trimEnd().split(/\r?\n/).map(f =>
                    f.split("\t")
                );

            }

            const tbody = tabla.querySelector("tbody");

            let filaActual = celda.parentElement;
            let columnaInicial = Array.from(
                filaActual.children
            ).indexOf(celda);

            filas.forEach((datos, indice) => {

                let filaDestino = filaActual;

                if (indice > 0) {

                    filaDestino = filaActual.nextElementSibling;

                    if (!filaDestino) {
                        filaDestino = document.createElement("tr");
                        for (let i = 0; i < 3; i++) {

                            const td = document.createElement("td");
                            td.contentEditable = "true";
                            filaDestino.appendChild(td);
                        }
                        tbody.appendChild(filaDestino);
                    }
                    filaActual = filaDestino;
                }

                datos.forEach((valor, col) => {

                    const destino = filaDestino.children[
                        columnaInicial + col
                    ];

                    if (destino) {
                        destino.textContent = valor;
                    }

                });

            });

        });

    });


    // ...................................
    //  PREPARAR DATOS PARA ENVIAR
    // ...................................

    document.getElementById("formularioSeguro")
        .addEventListener("submit", function(e) {

            // Validar materia
            if (!materiaSeleccionada) {
                e.preventDefault();
                alert("Debe seleccionar una materia de la lista.");
                return;
            }

            // Validar fechas
            if (fechasSeleccionadas.size === 0) {
                e.preventDefault();
                alert("Debe seleccionar al menos una fecha.");
                return;
            }

            const fechas = Array.from(fechasSeleccionadas).map(([fecha, horario]) => ({
                fecha: fecha,
                hora_inicio: horario.inicio,
                hora_fin: horario.fin
            }));

            for (const fecha of fechas) {
                if (!fecha.hora_inicio || !fecha.hora_fin || fecha.hora_inicio >= fecha.hora_fin) {
                    e.preventDefault();
                    alert("Revise los horarios de las fechas seleccionadas.");
                    return;
                }
            }

            // Guardar fechas
            document.getElementById("fechas").value = JSON.stringify(fechas);

            // Obtener contenido de las tablas
            function obtenerFilas(id) {
                return Array.from(
                    document.querySelectorAll(`#${id} tbody tr`)
                ).map(fila =>
                    Array.from(fila.cells).map(celda =>
                        celda.innerText.trim()
                    )
                ).filter(fila => fila.some(valor => valor !== ""));
            }
            document.getElementById("estudiantes").value = JSON.stringify(obtenerFilas("tabla-estudiantes"));
            document.getElementById("profesores").value = JSON.stringify(obtenerFilas("tabla-profesores"));

        });

    </script>

</body>
</html>
