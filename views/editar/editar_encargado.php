<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$id_encargado = $nombre = $apellido = $relacion = $num_telefono = "";

// Verificar si se envió el ID del encargado para editar
if (isset($_GET['id'])) {
    $id_encargado = $_GET['id'];

    // Consulta para obtener los datos del encargado a editar
    $sql = "SELECT * FROM encargado_nino WHERE id_encargado = :id_encargado";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_encargado', $id_encargado);
    $stmt->execute();
    $encargado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si existe el encargado
    if ($encargado) {
        // Asignar los datos a las variables
        $nombre = $encargado['nombre'];
        $apellido = $encargado['apellido'];
        $relacion = $encargado['relacion'];
        $num_telefono = $encargado['num_telefono'];
    } else {
        echo "<script>
            alert('No se encontro al encargado');
        </script>";
        exit();
    }
}

// Verificar si se envió el formulario para editar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $relacion = $_POST['relacion'];
    $num_telefono = $_POST['num_telefono'];

    // Consulta SQL para actualizar los datos del encargado
    $sql = "UPDATE encargado_nino SET nombre = :nombre, apellido = :apellido, relacion = :relacion, num_telefono = :num_telefono WHERE id_encargado = :id_encargado";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':relacion', $relacion);
    $stmt->bindParam(':num_telefono', $num_telefono, PDO::PARAM_INT);
    $stmt->bindParam(':id_encargado', $id_encargado);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_encargados.php';
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
    <title>Editar Encargado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../../includes/header2.php'; ?>


    <!-- Contenido - Formulario de Editar Encargado -->
    <div class="container form-container">
        <h1 class="text-center">Editar Encargado</h1>
        <form method="POST" action="editar_encargado.php?id=<?php echo $id_encargado; ?>">
            <div class="form-group mb-3">
                <label for="id_encargado">ID Encargado</label>
                <input type="text" id="id_encargado" name="id_encargado" class="form-control" value="<?php echo $id_encargado; ?>" readonly required>
            </div>
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $apellido; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="relacion">Relación</label>
                <input type="text" id="relacion" name="relacion" class="form-control" value="<?php echo $relacion; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Número de Teléfono</label>
                <input type="number" id="num_telefono" name="num_telefono" class="form-control" value="<?php echo $num_telefono; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Actualizar Encargado</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_encargados.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>