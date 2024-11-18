<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];

    try {
        // Consulta para obtener el registro del evento
        $sql = "SELECT id_evento, evento, imagen, fecha, descripcion FROM eventos WHERE id_evento = :id_evento";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $evento = $result['evento'];
            $fecha = $result['fecha'];
            $descripcion = $result['descripcion'];
            $imagen = $result['imagen']; // Asume que la imagen es opcional y se mostrará si está presente
        } else {
            echo "<script>
                alert('No se encontro el evento');
            </script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error en la base de datos: " . $e->getMessage() . "');
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('No se encontro el evento');
    </script>";
    exit();
}

// Procesa el formulario para actualizar los datos del evento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_evento = $_POST['evento'];
    $nueva_fecha = $_POST['fecha'];
    $nueva_descripcion = $_POST['descripcion'];

    try {
        // Si se ha subido una nueva imagen
        if (isset($_FILES['imagen']['tmp_name']) && $_FILES['imagen']['tmp_name'] != "") {
            $nueva_imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            // Actualiza el evento con la nueva imagen
            $update_sql = "UPDATE eventos SET evento = :evento, fecha = :fecha, descripcion = :descripcion, imagen = :imagen WHERE id_evento = :id_evento";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bindParam(':evento', $nuevo_evento, PDO::PARAM_STR);
            $stmt_update->bindParam(':fecha', $nueva_fecha, PDO::PARAM_STR);
            $stmt_update->bindParam(':descripcion', $nueva_descripcion, PDO::PARAM_STR);
            $stmt_update->bindParam(':imagen', $nueva_imagen, PDO::PARAM_LOB);
            $stmt_update->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
        } else {
            // No se actualiza la imagen, solo los otros datos
            $update_sql = "UPDATE eventos SET evento = :evento, fecha = :fecha, descripcion = :descripcion WHERE id_evento = :id_evento";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bindParam(':evento', $nuevo_evento, PDO::PARAM_STR);
            $stmt_update->bindParam(':fecha', $nueva_fecha, PDO::PARAM_STR);
            $stmt_update->bindParam(':descripcion', $nueva_descripcion, PDO::PARAM_STR);
            $stmt_update->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);
        }

        if ($stmt_update->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_evento.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Error al actualizar el evento');
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error en la base de datos: " . $e->getMessage() . "');
        </script>";
    }
}

$conn = null; // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <?php include '../../includes/header2.php'; ?>

    <div class="form-container">
        <h1>Editar Evento</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="evento">Nombre del Evento</label>
                <input type="text" id="evento" name="evento" value="<?php echo htmlspecialchars($evento); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Evento</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen (deja en blanco si no deseas cambiarla)</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <?php if ($imagen): ?>
                    <p>Imagen actual:</p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen); ?>" width="150" height="150">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Información</button>
            </div>
        </form>

        <a class="btn" href="../ver_evento.php">Volver</a>
    </div>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>