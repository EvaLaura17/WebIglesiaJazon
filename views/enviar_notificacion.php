<?php
require_once '../includes/bd.php'; // Incluir el archivo de la clase Database
$conn = Database::getInstance(); // Obtener la instancia de conexión

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nino = $_POST['id_nino'];
    $contenido = $_POST['contenido'];
    $tipo_notificacion = $_POST['tipo_notificacion'];

    // Consulta para obtener el id_tutor
    $consulta_tutor = "SELECT t.id_tutor, t.num_telefono FROM tutores t JOIN ninos n ON t.id_tutor = n.tutor_id WHERE n.id = :id_nino";
    $stmt_tutor = $conn->prepare($consulta_tutor);
    $stmt_tutor->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
    $stmt_tutor->execute();
    $tutor = $stmt_tutor->fetch(PDO::FETCH_ASSOC);

    if ($tutor) {
        try {
            // Insertar la notificación en la tabla
            $fecha = date("Y-m-d");
            $stmtNotificacion = $conn->prepare("INSERT INTO notificaciones (notificacion, fecha, tipo, id_tutor) VALUES (:notificacion, :fecha, :tipo, :id_tutor)");
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
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../css/notificacion.css">
    <link rel="stylesheet" href="../css/index.css">

</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

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

        </form>
      

    </div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>
</body>

</html>