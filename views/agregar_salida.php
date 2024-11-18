<?php
// Incluye la clase Database
require_once '../includes/bd.php';

try {
    // Obtén la instancia de conexión usando la clase Database
    $conn = Database::getInstance();

    // Verifica si se envía el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_nino = $_POST['id_nino'];
        $id_encargado = $_POST['id_encargado'];
        $enviar_notificacion = isset($_POST['enviar_notificacion']) ? true : false; // Verifica si el checkbox está marcado
        $fecha = date("Y-m-d");
        $hora = date("H:i");  // Esto asegura que se muestre la hora y el minuto

        // Inserción de los datos de salida en la tabla 'salida'
        $insert_sql = "INSERT INTO salidas (fecha, hora, id_nino, id_encargado) VALUES (:fecha, :hora, :id_nino, :id_encargado)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
        $stmt->bindParam(':id_encargado', $id_encargado);

        if ($stmt->execute()) {
            echo "Datos de salida registrados correctamente.";

            // Si se selecciona enviar notificación
            if ($enviar_notificacion) {
                // Obtén el nombre del niño
                $consulta_nino = "SELECT nombre FROM ninos WHERE id = :id_nino";
                $stmt_nino = $conn->prepare($consulta_nino);
                $stmt_nino->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
                $stmt_nino->execute();
                $nino = $stmt_nino->fetch(PDO::FETCH_ASSOC);

                // Obtén el nombre del encargado y el número de teléfono
                $consulta_encargado = "SELECT nombre, apellido, num_telefono FROM encargado_nino WHERE id_encargado = :id_encargado";
                $stmt_encargado = $conn->prepare($consulta_encargado);
                $stmt_encargado->bindParam(':id_encargado', $id_encargado);
                $stmt_encargado->execute();
                $encargado = $stmt_encargado->fetch(PDO::FETCH_ASSOC);

                // Consulta para obtener el número de teléfono del tutor del niño
                $consulta_tutor = "SELECT t.id_tutor, t.num_telefono FROM tutores t JOIN ninos n ON t.id_tutor = n.tutor_id WHERE n.id = :id_nino";
                $stmt_tutor = $conn->prepare($consulta_tutor);
                $stmt_tutor->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);  // Usa el ID del niño
                $stmt_tutor->execute();
                $tutor = $stmt_tutor->fetch(PDO::FETCH_ASSOC);
                $tipo = "salida";
                if ($tutor && isset($tutor['id_tutor'])) {
                    // Si se encontró el tutor y el id_tutor no es NULL
                    $numero_tutor = $tutor['num_telefono'];
                    $mensaje = "El niño " . $nino['nombre'] . " fue recogido por " . $encargado['nombre'] . " " . $encargado['apellido'] . " a las " . $hora;

                    // Insertar la notificación en la base de datos
                    $insert_notif_sql = "INSERT INTO notificaciones (notificacion, fecha, tipo, id_tutor) VALUES (:notificacion, :fecha, :tipo, :id_tutor)";
                    $stmt_notif = $conn->prepare($insert_notif_sql);
                    $stmt_notif->bindParam(':notificacion', $mensaje);
                    $stmt_notif->bindParam(':fecha', $fecha);
                    $stmt_notif->bindParam(':tipo', $tipo);
                    $stmt_notif->bindParam(':id_tutor', $tutor['id_tutor']);
                    $stmt_notif->execute();
                    echo "Notificación enviada y almacenada.";
                } else {
                    echo "Error: No se encontró el tutor o el id_tutor es NULL.";
                }
            }
        } else {
            echo "Error al registrar los datos de salida: " . implode(" ", $stmt->errorInfo());
        }
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/salida.css">
    <title>Registro de Salida de Niño</title>
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h1>Registrar Salida de Niño</h1>
        <form method="POST" action="">
            <label for="id_nino">Selecciona al Niño</label>
            <select name="id_nino" id="id_nino" required>
                <option value="">Seleccionar...</option>
                <?php
                // Consulta para obtener los niños usando PDO
                $consulta_ninos = "SELECT id, nombre FROM ninos";
                $stmt_ninos = $conn->query($consulta_ninos);

                if ($stmt_ninos) {
                    while ($nino = $stmt_ninos->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $nino['id'] . "'>" . $nino['nombre'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="id_encargado">Selecciona al Encargado</label>
            <select name="id_encargado" id="id_encargado" required>
                <option value="">Seleccionar...</option>
                <?php
                // Consulta para obtener los encargados usando PDO
                $consulta_encargados = "SELECT id_encargado, nombre, apellido FROM encargado_nino";
                $stmt_encargados = $conn->query($consulta_encargados);

                if ($stmt_encargados) {
                    while ($encargado = $stmt_encargados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $encargado['id_encargado'] . "'>" . $encargado['nombre'] . " " . $encargado['apellido'] . "</option>";
                    }
                }
                ?>
            </select>
            <br>
            <input type="checkbox" name="enviar_notificacion"> Enviar Notificación de la salida
            <input type="submit" value="Registrar Salida">
        </form>
      

    </div>
    <br>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div> <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>
</body>

</html>