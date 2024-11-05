<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "proyectosistemas"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se selecciona un grupo
$grupo_id = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

// Consulta para obtener los niños del grupo seleccionado
$consulta_niños = $grupo_id ? "SELECT id, nombre, apellido_paterno, apellido_materno FROM ninos WHERE grupo_id = '$grupo_id'" : "SELECT id, nombre, apellido_paterno, apellido_materno FROM ninos";

// Ejecuta la consulta
$resultado_niños = $conn->query($consulta_niños);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia Jazon - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: #121212; /* Fondo oscuro */
            color: white; /* Texto blanco */
        }

        /* Cabecera */
        header {
            background-color: #000; /* Color negro para la cabecera */
            color: #efb810; /* Color dorado para el texto */
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .title-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #efb810; /* Color dorado */
        }

        .nav-link {
            color: #efb810; /* Color dorado para los enlaces */
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff; /* Cambio de color al pasar el ratón */
        }

        /* Secciones */
        .content-section {
            padding: 3rem 1rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #efb810; /* Color dorado */
            border-bottom: 2px solid #efb810; /* Línea dorada debajo del título */
            padding-bottom: 5px;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid gold;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #000; /* Color negro para el encabezado */
            color: #efb810; /* Texto dorado en el encabezado */
        }
        tr {
            background-color: black; /* Color uniforme para todas las filas */
        }
        /* Pie de página */
        footer {
            background-color: #0a0a0a; /* Color negro para el pie de página */
            color: #bdc3c7; /* Color claro para el texto del pie */
            padding: 1.5rem 0;
            text-align: center;
        }

        footer a {
            color: #efb810; /* Color dorado para enlaces del pie */
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffffff; /* Cambio de color al pasar el ratón */
        }
        /* Estilo de botones */
        .btn1 {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: black; /* Color de los botones */
            color: white;
            border: 1px solid white;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
        }

        .btn1:hover {
            border: 1px solid gold;
            color: gold;
            background-color: black;}

        .btn-asistencia {
            margin-right: 10px;
            padding: 5px 10px;
            background-color: #28a745; /* Color verde para presente */
            color: white; /* Texto blanco */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s; /* Transiciones suaves */
        }

        .btn-asistencia.ausente {
            background-color: #dc3545; /* Color rojo para ausente */
        }

        .btn-asistencia:hover {
            opacity: 0.9; /* Opacidad al pasar el ratón */
            transform: scale(1.05); /* Efecto de aumento al pasar el ratón */
        }

        .btn-asistencia.ausente:hover {
            opacity: 0.9; /* Opacidad al pasar el ratón */
            transform: scale(1.05); /* Efecto de aumento al pasar el ratón */
        }

        .selected {
            background-color: #6c757d !important; /* Color gris oscuro para seleccionado */
        }
    </style>
</head>
<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="logoFinal.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.html" class="nav-link px-2">Inicio</a></li>
                    <li><a href="index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-light">Login</a>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENIDO -->
    <div class="container content-section">
        <h1 class="section-title">Lista de Asistencia</h1>

        <!-- Selección de Grupo -->
        <form method="POST" action="">
            <label for="grupo_id">Selecciona un Grupo:</label>
            <select name="grupo_id" id="grupo_id" required class="form-select" style="background-color: #121212; color: #efb810; border: 1px solid #efb810;">
                <option value="" style="color: #efb810;">Seleccionar...</option>
                <?php
                // Obtener los grupos desde la base de datos (suponiendo que existe un campo 'grupo_id' en la tabla 'niños')
                $grupos = $conn->query("SELECT DISTINCT grupo_id FROM ninos");
                if ($grupos->num_rows > 0) {
                    while($grupo = $grupos->fetch_assoc()) {
                        echo "<option value='" . $grupo['grupo_id'] . "'>" . $grupo['grupo_id'] . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit" class="btn1" style="background-color: #efb810; color: #000;">Mostrar Niños</button>
        </form>

        <!-- Mostrar lista de niños del grupo seleccionado -->
        <?php
        if ($grupo_id && $resultado_niños->num_rows > 0) {
            echo "<form id='asistenciaForm' method='POST' action='guardar_asistencia.php'>";
            echo "<input type='hidden' name='grupo_id' value='$grupo_id'>";
            echo "<table class='table2'>";
            echo "<thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Asistencia</th>
                    </tr>
                  </thead>
                  <tbody>";
            while ($row = $resultado_niños->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['apellido_paterno'] . "</td>
                        <td>" . $row['apellido_materno'] . "</td>
                        <td>
                            <button type='button' class='btn-asistencia' id='presente-" . $row['id'] . "' onclick='marcarAsistencia(" . $row['id'] . ", \"Presente\")'>Presente</button>
                            <button type='button' class='btn-asistencia ausente' id='ausente-" . $row['id'] . "' onclick='marcarAsistencia(" . $row['id'] . ", \"Ausente\")'>Ausente</button>
                            <input type='hidden' name='estado_" . $row['id'] . "' id='asistencia-" . $row['id'] . "' value='No marcada'>
                        </td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
            echo "<button type='submit' class='btn1'>Guardar Asistencia</button>";
            echo "</form>";
        }
        ?>
        
        <button class="btn1" onclick="window.location.href='index2.html'">Volver</button>
    </div>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a> 
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a> 
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>
    <script>
        // Marca la asistencia (presente o ausente) y desactiva los botones
        function marcarAsistencia(id, estado) {
            // Cambia el valor del campo oculto
            document.getElementById('asistencia-' + id).value = estado;

            // Desactiva ambos botones
            document.getElementById('presente-' + id).disabled = true;
            document.getElementById('ausente-' + id).disabled = true;

            // Cambia el estilo del botón seleccionado para marcar el estado visualmente
            if (estado === "Presente") {
                document.getElementById('presente-' + id).classList.add('selected');
            } else if (estado === "Ausente") {
                document.getElementById('ausente-' + id).classList.add('selected');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<?php
// Cerrar la conexión
$conn->close();
