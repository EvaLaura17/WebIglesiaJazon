<?php
// Incluye la clase Database
require_once '../includes/bd.php';

$conn = Database::getInstance(); // Obtener la instancia de conexión

// Consulta para obtener el nombre completo, el curso y las enfermedades
$consulta = "
    SELECT n.id, n.nombre, n.apellido_paterno, n.apellido_materno, n.grupo_id, 
           GROUP_CONCAT(e.enfermedad SEPARATOR ', ') AS enfermedades
    FROM ninos n
    LEFT JOIN nino_enfermedad ne ON n.id = ne.id_nino
    LEFT JOIN enfermedades e ON ne.id_enfermedad = e.id_enfermedad
    GROUP BY n.id
";

$stmt = $conn->query($consulta);
$asistencia = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
    <title>Lista de Enfermedad</title>
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <br>
    <div class="container">
    <h1 class="section-title">Lista de Enfermedades</h1>
    </div>
    <div class="container2">
        

        <!-- Tabla para mostrar los resultados -->
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Curso</th>
                    <th>Enfermedades</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica si hay resultados
                if (!empty($asistencia)) {
                    // Imprime los resultados en la tabla
                    foreach ($asistencia as $row) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["nombre"]) . " " . htmlspecialchars($row["apellido_paterno"]) . " " . htmlspecialchars($row["apellido_materno"]) . "</td>
                                <td>" . htmlspecialchars($row["grupo_id"]) . "</td>
                                <td>" . htmlspecialchars($row["enfermedades"] ?: 'Ninguna') . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>
       
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>

    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>