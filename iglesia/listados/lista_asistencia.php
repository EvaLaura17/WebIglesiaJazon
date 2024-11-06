<?php
require_once '../bd.php'; // Incluye la clase de base de datos

// Conexión a la base de datos utilizando la clase Database
$conn = Database::getInstance();

// Consulta para obtener las fechas únicas de la tabla asistencia
$sql_fechas = "SELECT DISTINCT fecha FROM asistencia";
$stmt_fechas = $conn->query($sql_fechas);

// Consulta para obtener los registros de la tabla asistencia y relacionar con la tabla ninos
$sql = "SELECT a.id, a.nino_id, a.grupo_id, a.fecha, a.estado, n.nombre, n.apellido_paterno
        FROM asistencia a
        INNER JOIN ninos n ON a.nino_id = n.id";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Lista de Asistencia</title>
    <style>
        /* Estilos generales de la página */
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: #121212;
            color: white;
        }

        /* Contenedor principal */
        .container {
            background-color: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 95%;
            max-width: 900px;
        }

        /* Estilos del título */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #efb810;
            /* Título dorado */
            border-bottom: 2px solid #efb810;
            /* Subrayado dorado */
            padding-bottom: 10px;
        }

        /* Estilos de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #efb810;
            /* Bordes dorados */
            color: #efb810;
        }

        th {
            background-color: #efb810;
            /* Fondo dorado */
            color: black;
            /* Letras negras */
        }

        tr:nth-child(even) {
            background-color: #1e1e1e;
            /* Fondo oscuro para filas pares */
        }

        /* Estilos de los botones */
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
        }


        /* Estilos del filtro de fecha */
        .filter-container select {
            padding: 10px;
            font-size: 16px;
            background-color: black;
            /* Fondo negro */
            color: #efb810;
            /* Texto dorado */
            border: 1px solid #efb810;
            /* Borde dorado */
            margin-top: 10px;
        }

        /* Estilos de la cabecera */
        header {
            background-color: #000;
            color: #efb810;
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
            width: 300px;
            height: 80px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #efb810;
        }

        .nav-link {
            color: #efb810;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        /* Estilos del pie de página */
        footer {
            background-color: #0a0a0a;
            color: #bdc3c7;
            padding: 1.5rem 0;
            text-align: center;
        }

        footer a {
            color: #efb810;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffffff;
        }
    </style>
</head>


<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta y enlaces de estilo -->
</head>

<body>
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <div class="container">
        <h1>Lista de Asistencia</h1>

        <!-- Menú desplegable para seleccionar la fecha -->
        <div class="filter-container">
            <form method="GET" action="">
                <label for="fecha">Selecciona una fecha:</label>
                <select name="fecha" id="fecha" onchange="this.form.submit()">
                    <option value="">-- Todas las fechas --</option>
                    <?php
                    // Verifica si hay fechas disponibles y crea el menú desplegable
                    if ($stmt_fechas->rowCount() > 0) {
                        while ($row_fecha = $stmt_fechas->fetch(PDO::FETCH_ASSOC)) {
                            $selected = isset($_GET['fecha']) && $_GET['fecha'] == $row_fecha['fecha'] ? 'selected' : '';
                            echo "<option value='" . $row_fecha['fecha'] . "' $selected>" . $row_fecha['fecha'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </form>
        </div>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Grupo ID</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica si una fecha ha sido seleccionada
                if (isset($_GET['fecha']) && $_GET['fecha'] != "") {
                    $fecha_seleccionada = $_GET['fecha'];
                    $sql .= " WHERE a.fecha = :fecha";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':fecha', $fecha_seleccionada);
                    $stmt->execute();
                } else {
                    $stmt = $conn->query($sql);
                }

                // Verifica si hay resultados
                if ($stmt->rowCount() > 0) {
                    // Imprime los resultados en la tabla
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["nombre"] . "</td>
                                <td>" . $row["apellido_paterno"] . "</td>
                                <td>" . $row["grupo_id"] . "</td>
                                <td>" . $row["fecha"] . "</td>
                                <td>" . $row["estado"] . "</td>
                                <td>
                                    <a href='editar_asistencia.php?id=" . $row["id"] . "' class='btn btn-edit'>Editar</a>
                                    <a href='borrar_asistencia.php?id=" . $row["id"] . "' class='btn btn-danger'>Borrar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br>
    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>