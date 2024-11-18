<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los maestros y los cursos a los que están asignados
$maestrosQuery = "SELECT m.id_maestro, m.nombre, m.ape_pat, m.ape_mat, m.num_telefono,c.grupo
                  FROM maestros m
                  LEFT JOIN cursos c ON m.id_curso = c.id_curso";
$stmt = $conn->prepare($maestrosQuery);
$stmt->execute();
$maestros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Maestros</title>
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1 class="section-title">Lista de Maestros</h1>
    </div>
    <div class="container2 ">
        <!-- Tabla de Maestros -->
        <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>Nombre del Maestro</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Numero de telefono</th>
                        <th>Curso Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verifica si hay maestros
                    if (count($maestros) > 0) {
                        // Muestra los datos de cada maestro
                        foreach ($maestros as $maestro) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($maestro['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($maestro['ape_pat']) . "</td>";
                            echo "<td>" . htmlspecialchars($maestro['ape_mat']) . "</td>";
                            echo "<td>" . htmlspecialchars($maestro['num_telefono']) . "</td>";
                            echo "<td>" . htmlspecialchars($maestro['grupo'] ? $maestro['grupo'] : 'No asignado') . "</td>";
                            echo "<td>
                                    <a href='editar/editar_maestro.php?id_salida=" . $maestro['id_maestro'] . "' class='btn1 btn-edit'>Cambiar</a> 
                                    <a href='borrar/borrar_maestro.php?id_salida=" . $maestro['id_maestro'] . "' class='btn1 btn-delete'>Eliminar</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay maestros disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center ">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
<br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>
</body>

</html>