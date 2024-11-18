<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Consulta para obtener el registro de asistencia y los datos del niño
        $sql = "SELECT a.id, a.nino_id, a.grupo_id, a.fecha, a.estado, 
                       n.nombre, n.apellido_paterno, n.apellido_materno 
                FROM asistencias a 
                JOIN ninos n ON a.nino_id = n.id 
                WHERE a.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $nino_id = $result['nino_id'];
            $nombre = $result['nombre'];
            $apellido_paterno = $result['apellido_paterno'];
            $apellido_materno = $result['apellido_materno'];
            $grupo_id = $result['grupo_id'];
            $fecha = $result['fecha'];
            $estado = $result['estado'];
        } else {
            echo "<script>
                alert('No se encontro el registro');
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
        alert('Id no proporcionado');
    </script>";
    exit();
}

// Procesa el formulario para actualizar el estado de la asistencia
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_estado = $_POST['estado'];

    try {
        // Consulta para actualizar el estado en la base de datos
        $update_sql = "UPDATE asistencias SET estado = :estado WHERE id = :id";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bindParam(':estado', $nuevo_estado, PDO::PARAM_STR);
        $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            // Redirige a la página de lista de asistencia después de actualizar
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_asistencias.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Error al actualizar el registro');
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
    <title>Editar Asistencia</title>
</head>

<body>
    <?php include '../../includes/header2.php'; ?>

    <div class="container">
        <h1>Editar Asistencia</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nino">Nombre del Niño</label>
                <input type="text" id="nino" value="<?php echo $nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="grupo_id">Grupo ID</label>
                <input type="text" id="grupo_id" value="<?php echo $grupo_id; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" id="fecha" value="<?php echo $fecha; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="estado">Estado de Asistencia</label>
                <select id="estado" name="estado">
                    <option value="Presente" <?php if ($estado == 'Presente') echo 'selected'; ?>>Presente</option>
                    <option value="Ausente" <?php if ($estado == 'Ausente') echo 'selected'; ?>>Ausente</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Asistencia</button>
            </div>
        </form>

        <button class="btn" onclick="window.location.href='../ver_asistencias.php'">Volver</button>
    </div>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>