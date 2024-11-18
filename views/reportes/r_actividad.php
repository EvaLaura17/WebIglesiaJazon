<?php
// Incluye la clase Database
require_once '../../includes/bd.php';

$conn = Database::getInstance(); // Obtener la instancia de conexión

// Obtener el ID de la actividad desde el formulario
$actividad_id = isset($_POST['actividad_id']) ? $_POST['actividad_id'] : 0;

// Consulta SQL con JOIN para obtener la información de la actividad, curso y maestro
$query = "
    SELECT 
        a.actividad, a.descripcion, a.fecha_act, c.grupo, c.edad_min, c.edad_max, 
        m.nombre AS maestro_nombre, m.ape_pat, m.ape_mat, m.num_telefono, 
        GROUP_CONCAT(n.nombre ORDER BY n.nombre ASC) AS niños_presentes, 
        COUNT(n.id) AS cantidad_ninos_presentes
    FROM actividad a
    JOIN curso c ON a.id_curso = c.id_curso
    JOIN maestro m ON m.id_curso = c.id_curso
    LEFT JOIN asistencia asis ON asis.grupo_id = c.id_curso AND asis.fecha = a.fecha_act AND asis.estado = 'Presente'
    LEFT JOIN ninos n ON n.id = asis.nino_id
    WHERE a.id_actividad = :id_actividad
    GROUP BY a.id_actividad
";


$stmt = $conn->prepare($query);
$stmt->bindParam(':id_actividad', $actividad_id, PDO::PARAM_INT);
$stmt->execute();
$actividad = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se encontró la actividad
if ($actividad) {
    // Mostrar la información en HTML
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte de Actividad</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Reporte de Actividad</h1>

            <div class="card">
                <div class="card-header">
                    <h3>Información de la Actividad</h3>
                </div>
                <div class="card-body">
                    <p><strong>Actividad:</strong> <?php echo $actividad['actividad']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $actividad['descripcion']; ?></p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Niños Presentes</h3>
                </div>
                <div class="card-body">
                    <p><strong>Cantidad de niños presentes:</strong> <?php echo $actividad['cantidad_ninos_presentes']; ?>
                    </p>
                    <p><strong>Niños presentes:</strong> <?php echo $actividad['niños_presentes']; ?></p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Fecha de la Actividad</h3>
                </div>
                <div class="card-body">
                    <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($actividad['fecha_act'])); ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3>Información del Curso</h3>
                </div>
                <div class="card-body">
                    <p><strong>Grupo:</strong> <?php echo $actividad['grupo']; ?></p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3>Información del Maestro</h3>
                </div>
                <div class="card-body">
                    <p><strong>Maestro:</strong>
                        <?php echo $actividad['maestro_nombre'] . ' ' . $actividad['ape_pat'] . ' ' . $actividad['ape_mat']; ?>
                    </p>
                    <p><strong>Teléfono:</strong> <?php echo $actividad['num_telefono']; ?></p>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="../reportes.php" class="btn btn-primary">Volver a Reportes</a>
                <button class="btn btn-success" onclick="exportToPDF()">Exportar a PDF</button>
            </div>
        </div>

        <script>
            function exportToPDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Título del reporte
                doc.setFontSize(20);
                doc.text("Reporte de Actividad", 105, 20, null, null, 'center');

                // Sección de actividad
                doc.setFontSize(14);
                doc.setTextColor(40, 40, 40);
                doc.text("Actividad: <?php echo $actividad['actividad']; ?>", 20, 30);
                doc.text("Fecha: <?php echo date('d/m/Y', strtotime($actividad['fecha_act'])); ?>", 20, 40);

                // Agregar una línea separadora
                doc.setLineWidth(0.5);
                doc.line(20, 45, 190, 45);

                // Sección de grupo
                doc.text("Grupo: <?php echo $actividad['grupo']; ?>", 20, 55);

                // Sección de maestro
                doc.text("Maestro: <?php echo $actividad['maestro_nombre'] . ' ' . $actividad['ape_pat'] . ' ' . $actividad['ape_mat']; ?>", 20, 65);

                // Agregar una línea separadora
                doc.setLineWidth(0.5);
                doc.line(20, 80, 190, 80);

                // Información general en tabla
                doc.setFontSize(12);
                const startX = 20;
                const startY = 90;
                const rowHeight = 10;

                doc.text("INFORMACION GENERAL: ", startX, startY);

                // Crear la tabla con información
                doc.autoTable({
                    startY: startY + 10,
                    head: [['Campo', 'Valor']],
                    body: [
                        ['Actividad', '<?php echo $actividad['actividad']; ?>'],
                        ['Descripción', '<?php echo $actividad['descripcion']; ?>'],
                        ['Fecha', '<?php echo date('d/m/Y', strtotime($actividad['fecha_act'])); ?>'],
                        ['Grupo', '<?php echo $actividad['grupo']; ?>'],
                        ['Maestro', '<?php echo $actividad['maestro_nombre'] . ' ' . $actividad['ape_pat'] . ' ' . $actividad['ape_mat']; ?>'],
                        ['Teléfono', '<?php echo $actividad['num_telefono']; ?>'],
                        ['Cantidad de niños presentes', '<?php echo $actividad['cantidad_ninos_presentes']; ?>'],
                        ['Niños presentes', '<?php echo $actividad['niños_presentes']; ?>']
                    ],
                    theme: 'grid',
                    headStyles: {
                        fillColor: [0, 102, 204],
                        textColor: [255, 255, 255]
                    },
                    bodyStyles: {
                        fontSize: 10
                    },
                    margin: { top: 100, bottom: 20 }
                });

                // Descargar el archivo PDF
                doc.save('reporte_actividad.pdf');
            }
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
} else {
    echo "<p class='text-center'>No se encontró la actividad con ID: " . $actividad_id . "</p>";
}
?>