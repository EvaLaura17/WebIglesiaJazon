<?php
require_once '../includes/bd.php'; // Incluir el archivo de la clase Database
$conn = Database::getInstance(); // Obtener la instancia de conexión

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nino = $_POST['id_nino'];
    $contenido = $_POST['contenido'];
    $tipo_notificacion = $_POST['tipo_notificacion'];

    // Consulta para obtener el id_tutor
    $consulta_tutor = "SELECT t.id_tutor, t.num_telefono FROM tutor t JOIN ninos n ON t.id_tutor = n.tutor_id WHERE n.id = :id_nino";
    $stmt_tutor = $conn->prepare($consulta_tutor);
    $stmt_tutor->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
    $stmt_tutor->execute();
    $tutor = $stmt_tutor->fetch(PDO::FETCH_ASSOC);

    if ($tutor) {
        try {
            // Insertar la notificación en la tabla
            $fecha = date("Y-m-d");
            $stmtNotificacion = $conn->prepare("INSERT INTO notificacion (notificacion, fecha, tipo, id_tutor) VALUES (:notificacion, :fecha, :tipo, :id_tutor)");
            $stmtNotificacion->bindParam(':notificacion', $contenido);
            $stmtNotificacion->bindParam(':fecha', $fecha);
            $stmtNotificacion->bindParam(':tipo', $tipo_notificacion);
            $stmtNotificacion->bindParam(':id_tutor', $tutor['id_tutor']);
            $stmtNotificacion->execute();

            echo "<script>alert('Notificación enviada exitosamente.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error al enviar la notificación: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('No se encontró un tutor para el niño seleccionado.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Notificación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        .container-min-height {
            height: 70vh;
        }
    </style>
</head>

<body>
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                </div>
                <span class="title">Iglesia Jazon</span>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container container-min-height">
        <h1>Enviar Notificación</h1>
        <form method="POST" action="">
            <!-- Selección de Niño -->
            <label for="id_nino">Selecciona al niño</label>
            <select name="id_nino" id="id_nino" required>
                <option value="">Seleccionar...</option>
                <?php
                $consulta_ninos = "SELECT id, nombre FROM ninos";
                $stmt_ninos = $conn->query($consulta_ninos);

                while ($nino = $stmt_ninos->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $nino['id'] . "'>" . $nino['nombre'] . "</option>";
                }
                ?>
            </select>

            <!-- Contenido de la Notificación -->
            <div class="form-group">
                <label for="contenido">Contenido</label><br>
                <textarea id="contenido" name="contenido" placeholder="Ingrese los detalles de la notificación"
                    required></textarea>
            </div>

            <!-- Tipo de Notificación -->
            <label for="tipo_notificacion">Selecciona el tipo de Notificación</label>
            <select name="tipo_notificacion" id="tipo_notificacion" required>
                <option value="">Seleccionar...</option>
                <option value="accidente">Accidente</option>
                <option value="retraso">Retraso</option>
                <option value="otro">Otro</option>
            </select>

            <br><br>
            <input type="submit" value="Enviar Notificación" class="btn btn-primary">
            <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='index2.php'">Volver</button>
        </form>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe!
            Estamos en todas las redes sociales

            para que puedas encontrar a Dios </h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>

            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>
</body>

</html>