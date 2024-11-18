<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los cursos, maestros y cantidad de niños
$cursosQuery = "SELECT c.id_curso, c.grupo, m.nombre AS nombre_maestro, m.ape_pat, m.ape_mat, 
                       (SELECT COUNT(*) FROM ninos n WHERE n.grupo_id = c.id_curso) AS cantidad_ninos
                FROM cursos c
                LEFT JOIN maestros m ON m.id_curso = c.id_curso";
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
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1 class="section-title">Lista de Cursos</h1>
    </div>
    <div class="container2 ">
        <!-- Tabla de Cursos -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Nombre del Maestro</th>
                        <th>Cantidad de Niños</th>
                        <th>Acciones</th>
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
                            echo "<td>
                                <a href='editar/editar_curso.php?id_curso=" . $curso['id_curso'] . "' class='btn1 btn-edit'>Editar</a>
                                <a href='borrar/borrar_curso.php?id_curso=" . $curso['id_curso'] . "' class='btn1 btn-delete'>Borrar</a>
                                </td>";
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
    <div class="text-center">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>