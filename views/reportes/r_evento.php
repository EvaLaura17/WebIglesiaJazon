<?php
// Incluir la clase Database para obtener la conexión
require_once '../../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Verificar si se ha enviado el ID del evento
if (isset($_POST['evento'])) {
    $eventoId = $_POST['evento']; // Obtener el ID del evento seleccionado

    // Consulta para obtener los detalles del evento
    $eventoQuery = "SELECT * FROM evento WHERE id_evento = :eventoId";
    $stmt = $conn->prepare($eventoQuery);
    $stmt->bindParam(':eventoId', $eventoId, PDO::PARAM_INT);
    $stmt->execute();
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el número de niños que participaron en el evento
    $niñosQuery = "SELECT COUNT(*) AS cantidad FROM participa WHERE id_evento = :eventoId";
    $stmt = $conn->prepare($niñosQuery);
    $stmt->bindParam(':eventoId', $eventoId, PDO::PARAM_INT);
    $stmt->execute();
    $niños = $stmt->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener los nombres de los niños que participaron en el evento
    $niñosNombresQuery = "SELECT n.nombre, n.apellido_paterno, n.apellido_materno FROM ninos n
                          JOIN participa p ON n.id = p.id_nino
                          WHERE p.id_evento = :eventoId";
    $stmt = $conn->prepare($niñosNombresQuery);
    $stmt->bindParam(':eventoId', $eventoId, PDO::PARAM_INT);
    $stmt->execute();
    $niñosNombres = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Evento</title>
    <!-- Asegúrate de tener el enlace a Bootstrap o cualquier otro estilo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Evento</h1>

        <!-- Información del Evento -->
        <div class="card">
            <div class="card-header">
                <h3>Información del Evento</h3>
            </div>
            <div class="card-body">
                <p><strong>Evento:</strong> <?php echo htmlspecialchars($evento['evento']); ?></p>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcion']); ?></p>
                <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($evento['fecha'])); ?></p>
            </div>
        </div>

        <!-- Participación de Niños -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Niños Participantes</h3>
            </div>
            <div class="card-body">
                <p><strong>Cantidad de Niños Participantes:</strong> <?php echo $niños['cantidad']; ?></p>
                <ul>
                    <?php foreach ($niñosNombres as $niño): ?>
                        <li><?php echo htmlspecialchars($niño['nombre'] . ' ' . $niño['apellido_materno'] . ' ' . $niño['apellido_materno']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

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
