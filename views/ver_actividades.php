<?php
require_once '../includes/bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Consulta para obtener todas las actividades
$consulta_actividades = "
    SELECT a.id_actividad, a.actividad, a.descripcion, a.fecha_act, a.id_curso
    FROM actividades a"; // Se asume que la tabla 'actividades' contiene los campos mencionados
$resultado = [];

$stmt = $pdo->prepare($consulta_actividades);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Actividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
    <link rel="stylesheet" href="../css/conListadoNinos.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- CONTENIDO -->
     <div class="container">
     <h1 class="section-title">Lista de Actividades</h1>
     </div>
    <div class="container2">
        <!-- Tabla con todas las actividades -->
        <?php
        if (count($resultado) > 0) {
            echo "<table >
                    <thead>
                        <tr>
                            <th>ID Actividad</th>
                            <th>Actividad</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>ID Curso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($resultado as $row) {
                echo "<tr>
                        <td>" . $row['id_actividad'] . "</td>
                        <td>" . $row['actividad'] . "</td>
                        <td>" . $row['descripcion'] . "</td>
                        <td>" . $row['fecha_act'] . "</td>
                        <td>" . $row['id_curso'] . "</td>
                        <td>
                            <a href='editar/editar_actividad.php?id=" . $row['id_actividad'] . "' class='btn1 btn-edit'>Editar</a>
                            <a href='borrar/borrar_actividad.php?id=" . $row['id_actividad'] . "' class='btn1 btn-delete'>Borrar</a>
                        </td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
        } else {
            echo "<p>No se encontraron actividades.</p>";
        }
        ?>
    </div>
    <div class="text-center ">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>