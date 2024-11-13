<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los cursos, maestros y cantidad de niños
$cursosQuery = "SELECT c.id_curso, c.grupo, m.nombre AS nombre_maestro, m.ape_pat, m.ape_mat, 
                       (SELECT COUNT(*) FROM ninos n WHERE n.grupo_id = c.id_curso) AS cantidad_ninos
                FROM curso c
                LEFT JOIN maestro m ON m.id_curso = c.id_curso";
$stmt = $conn->prepare($cursosQuery);
$stmt->execute();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cursos</title>
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Cursos</h1>

        <!-- Tabla de Cursos -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Listado de Cursos</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Nombre del Maestro</th>
                            <th>Cantidad de Niños</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Verifica si hay cursos
                        if (count($cursos) > 0) {
                            // Muestra los datos de cada curso
                            foreach ($cursos as $curso) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($curso['grupo']) . "</td>";
                                echo "<td>" . htmlspecialchars($curso['nombre_maestro']) . " " . htmlspecialchars($curso['ape_pat']) . " " . htmlspecialchars($curso['ape_mat']) . "</td>";
                                echo "<td>" . htmlspecialchars($curso['cantidad_ninos']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No hay cursos disponibles.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="mt-4 text-center">
            <a href="index2.php" class="btn btn-primary">Volver</a>
        </div>
    </div>
</body>

</html>