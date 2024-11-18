<?php
// Incluye la clase Database (asegúrate de que esté en el mismo directorio o ajusta la ruta)
require_once '../includes/bd.php';

try {
    // Obtén la instancia de conexión usando la clase Database
    $conn = Database::getInstance();

    // Consulta para obtener las fechas únicas de la tabla asistencia
    $sql_fechas = "SELECT DISTINCT fecha FROM asistencia";
    $stmt_fechas = $conn->query($sql_fechas);
    $fechas = $stmt_fechas->fetchAll(PDO::FETCH_ASSOC);

    // Consulta base para obtener los registros de asistencia
    $sql = "SELECT a.id, a.nino_id, a.grupo_id, a.fecha, a.estado, n.nombre, n.apellido_paterno
            FROM asistencia a
            INNER JOIN ninos n ON a.nino_id = n.id";

    // Verifica si una fecha ha sido seleccionada y agrega la cláusula WHERE
    if (isset($_GET['fecha']) && $_GET['fecha'] != "") {
        $fecha_seleccionada = $_GET['fecha'];
        $sql .= " WHERE a.fecha = :fecha";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha_seleccionada);
    } else {
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $asistencia = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Estilos de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!--CSS LINK -->
    <link rel="stylesheet" href="../css/tablas.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Lista de Asistencia</title>

</head>
<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                </div>
                <span class="title">Iglesia Jazon</span>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <div class="container2">
        <h1>Lista de Asistencia</h1>
        
        <!-- Menú desplegable para seleccionar la fecha -->
        <div class="filter-container">
            <form method="GET" action="">
                <label for="fecha" class="label-f"> Selecciona una fecha  </label>
                <select name="fecha" id="fecha" onchange="this.form.submit()">
                    <option value=""> --- Todas las fechas --- </option>
                    <?php
                    // Verifica si hay fechas disponibles y crea el menú desplegable
                    foreach ($fechas as $row_fecha) {
                        $selected = isset($_GET['fecha']) && $_GET['fecha'] == $row_fecha['fecha'] ? 'selected' : '';
                        echo "<option value='" . $row_fecha['fecha'] . "' $selected>" . $row_fecha['fecha'] . "</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
        <div class="table-responsive">

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
                // Verifica si hay resultados
                if (!empty($asistencia)) {
                    // Imprime los resultados en la tabla
                    foreach ($asistencia as $row) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["id"]) . "</td>
                                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                <td>" . htmlspecialchars($row["apellido_paterno"]) . "</td>
                                <td>" . htmlspecialchars($row["grupo_id"]) . "</td>
                                <td>" . htmlspecialchars($row["fecha"]) . "</td>
                                <td>" . htmlspecialchars($row["estado"]) . "</td>
                                <td>
                                    <a href='editar_asistencia.php?id=" . htmlspecialchars($row["id"]) . "' class='btn1 btn-edit'>Editar</a>
                                    <a href='borrar_asistencia.php?id=" . htmlspecialchars($row["id"]) . "' class='btn1 btn-delete'>Borrar</a>
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
    </div> <br>
 <!-- Pie de página -->
 <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>