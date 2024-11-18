<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

if (isset($_GET['id_salida'])) {
    $id_salida = $_GET['id_salida'];

    $sql = "
        SELECT 
            salidas.*,
            CONCAT(ninos.nombre, ' ', ninos.apellido_paterno, ' ', ninos.apellido_materno) AS nombre_completo_nino,
            CONCAT(encargado_nino.nombre, ' ', encargado_nino.apellido) AS nombre_completo_encargado
        FROM salidas
        LEFT JOIN ninos ON salidas.id_nino = ninos.id
        LEFT JOIN encargado_nino ON salidas.id_encargado = encargado_nino.id_encargado
        WHERE salidas.id_salida = :id_salida
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_salida', $id_salida, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar si se encuentra la salida
    if ($stmt->rowCount() > 0) {
        $salida = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores obtenidos a las variables
        $fecha = $salida['fecha'];
        $hora = $salida['hora'];
        $nombre_completo_nino = $salida['nombre_completo_nino'];
        $nombre_completo_encargado = $salida['nombre_completo_encargado'];
        $id_nino = $salida['id_nino'];
        $id_encargado = $salida['id_encargado'];
    } else {
        echo "<script>
            alert('Registro de la salida no encontrado');
        </script>";
        exit();
    }
}

// Obtener la lista de niños
$sqlNinos = "SELECT id AS id_nino, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo_nino FROM ninos";
$stmtNinos = $pdo->query($sqlNinos);
$ninos = $stmtNinos->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de encargados
$sqlEncargados = "SELECT id_encargado, CONCAT(nombre, ' ', apellido) AS nombre_completo_encargado FROM encargado_nino";
$stmtEncargados = $pdo->query($sqlEncargados);
$encargados = $stmtEncargados->fetchAll(PDO::FETCH_ASSOC);

// Verificar si se envió el formulario para actualizar la salida
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $id_nino = $_POST['id_nino'];
    $id_encargado = $_POST['id_encargado'];

    // Consulta SQL para actualizar los datos de la salida
    $sql = "UPDATE salidas SET fecha = :fecha, hora = :hora, id_nino = :id_nino, id_encargado = :id_encargado WHERE id_salida = :id_salida";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':hora', $hora);
    $stmt->bindParam(':id_nino', $id_nino);
    $stmt->bindParam(':id_encargado', $id_encargado);
    $stmt->bindParam(':id_salida', $id_salida, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_salidas.php';
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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Salida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/index.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../../includes/header2.php'; ?>

    <!-- Contenido - Formulario de Edición de Salida -->
    <div class="container form-container">
        <h1 class="text-center">Editar Salida</h1>
        <form method="POST" action="editar_salida.php?id_salida=<?php echo $id_salida; ?>">
            <div class="form-group mb-3">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo $fecha; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora" class="form-control" value="<?php echo $hora; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="id_nino">Niño</label>
                <select id="id_nino" name="id_nino" class="form-control" required>
                    <option value="">Seleccione un niño</option>
                    <?php foreach ($ninos as $nino): ?>
                        <option value="<?php echo $nino['id_nino']; ?>" <?php echo ($nino['id_nino'] == $id_nino) ? 'selected' : ''; ?>>
                            <?php echo $nino['nombre_completo_nino']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="id_encargado">Encargado</label>
                <select id="id_encargado" name="id_encargado" class="form-control" required>
                    <option value="">Seleccione un encargado</option>
                    <?php foreach ($encargados as $encargado): ?>
                        <option value="<?php echo $encargado['id_encargado']; ?>" <?php echo ($encargado['id_encargado'] == $id_encargado) ? 'selected' : ''; ?>>
                            <?php echo $encargado['nombre_completo_encargado']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Actualizar Salida</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_salidas.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>