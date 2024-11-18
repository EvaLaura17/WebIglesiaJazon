<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los maestros y los cursos a los que están asignados
$maestrosQuery = "SELECT m.id_maestro, m.nombre, m.ape_pat, m.ape_mat, m.num_telefono,c.grupo
                  FROM maestro m
                  LEFT JOIN curso c ON m.id_curso = c.id_curso";
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
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Maestros</h1>

        <!-- Tabla de Maestros -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Listado de Maestros y Cursos</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre del Maestro</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Numero de telefono</th>
                            <th>Curso Asignado</th>
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

        <!-- Botón de acción -->
        <div class="mt-4 text-center">
            <a href="index2.php" class="btn btn-primary">Volver a Reportes</a>
        </div>
    </div>
</body>

</html>