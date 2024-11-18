<?php
// Incluir la clase Database para obtener la conexión
require_once '../../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Verificar si se ha enviado el ID del curso
if (isset($_POST['curso'])) {
    $cursoId = $_POST['curso']; // Obtener el ID del curso seleccionado

    // Consulta para obtener el grupo del curso y el nombre del maestro
    if ($cursoId == 'todos') {
        // Si se selecciona 'todos', contar todos los niños y los cursos
        $cursosQuery = "SELECT * FROM curso";
        $cursosResult = $conn->query($cursosQuery);
        $totalNiñosQuery = "SELECT COUNT(*) AS totalNiños FROM ninos";
        $stmt = $conn->prepare($totalNiñosQuery);
        $stmt->execute();
        $totalNiños = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Si se selecciona un curso específico, obtener la cantidad de niños y el maestro
        $cursoQuery = "SELECT c.grupo, m.nombre, m.ape_pat, m.ape_mat 
                        FROM curso c
                        JOIN maestro m ON m.id_curso = c.id_curso
                        WHERE c.id_curso = :cursoId";
        $stmt = $conn->prepare($cursoQuery);
        $stmt->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $stmt->execute();
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        // Consulta para obtener la cantidad de niños en el curso (con JOIN)
        $niñosCursoQuery = "SELECT COUNT(*) AS cantidad 
                            FROM ninos n
                            JOIN curso c ON n.grupo_id = c.id_curso
                            WHERE c.id_curso = :cursoId";
        $stmt = $conn->prepare($niñosCursoQuery);
        $stmt->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $stmt->execute();
        $niñosCurso = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si se selecciona un curso específico, obtener los nombres de los niños
        $ninosQuery = "SELECT n.nombre, n.apellido_paterno, n.apellido_materno 
                       FROM ninos n 
                       JOIN curso c ON n.grupo_id = c.id_curso 
                       WHERE c.id_curso = :cursoId";
        $stmt = $conn->prepare($ninosQuery);
        $stmt->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        $stmt->execute();
        $ninos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los niños en el curso
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Curso</h1>

        <!-- Reporte de Curso -->
        <?php if (isset($cursoId)): ?>
            <?php if ($cursoId == 'todos'): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Reporte de Todos los Cursos</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Total de Niños en la Iglesia:</strong> <?php echo $totalNiños['totalNiños']; ?></p>
                        <p><strong>Total de Cursos:</strong> <?php echo $cursosResult->rowCount(); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Reporte del Curso: <?php echo htmlspecialchars($curso['grupo']); ?></h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Cantidad de Niños en este Curso:</strong> <?php echo $niñosCurso['cantidad']; ?></p>
                        <p><strong>Nombre del Maestro:</strong>
                            <?php echo htmlspecialchars($curso['nombre']) . ' ' . htmlspecialchars($curso['ape_pat']) . ' ' . htmlspecialchars($curso['ape_mat']); ?>
                        </p>

                        <!-- Lista de Niños -->
                        <h5 class="mt-4">Niños en este Curso:</h5>
                        <ul>
                            <?php foreach ($ninos as $nino): ?>
                                <li><?php echo htmlspecialchars($nino['nombre']) . ' ' . htmlspecialchars($nino['apellido_paterno']) . ' ' . htmlspecialchars($nino['apellido_materno']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Botones de acción -->
        <div class="mt-4 text-center">
            <a href="../reportes.php" class="btn btn-primary">Volver a Reportes</a>
            <button class="btn btn-success" onclick="exportToPDF()">Exportar a PDF</button>
        </div>
    </div>

    <!-- Script para Exportar a PDF -->
    <script>
        function exportToPDF() {
            window.print(); // Esta función puede ser modificada para generar un PDF usando una librería como jsPDF
        }
    </script>
</body>

</html>