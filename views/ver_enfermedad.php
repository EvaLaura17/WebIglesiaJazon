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
    LEFT JOIN enfermedad e ON ne.id_enfermedad = e.id_enfermedad
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
    <link rel="stylesheet" href="../css/estilos.css">
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
                    <li><a href="index.html" class="nav-link px-2">Inicio</a></li>
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <div class="container2">
        <h1>Lista de Asistencia</h1>

        <!-- Tabla para mostrar los resultados -->
        <table class="table">
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
    <br>
    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024</p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
