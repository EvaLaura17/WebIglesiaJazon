<?php
require_once '../../includes/bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$actividad = $descripcion = $fecha_act = $id_curso = "";

// Obtener el ID de la actividad desde la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_actividad = $_GET['id'];

    // Consulta SQL para obtener los datos de la actividad por ID
    $sql = "SELECT * FROM actividades WHERE id_actividad = :id_actividad";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);
    $stmt->execute();
    $actividad_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($actividad_data) {
        // Asignar los datos obtenidos al formulario
        $actividad = $actividad_data['actividad'];
        $descripcion = $actividad_data['descripcion'];
        $fecha_act = $actividad_data['fecha_act'];
        $id_curso = $actividad_data['id_curso'];
    } else {
        echo "Actividad no encontrada.";
        exit();
    }
}

// Verificar si se envió el formulario para actualizar la actividad
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $actividad = $_POST['actividad'];
    $descripcion = $_POST['descripcion'];
    $fecha_act = $_POST['fecha_act'];
    $id_curso = $_POST['id_curso'];

    // Consulta SQL para actualizar los datos de la actividad
    $sql = "UPDATE actividades SET actividad = :actividad, descripcion = :descripcion, fecha_act = :fecha_act, id_curso = :id_curso 
            WHERE id_actividad = :id_actividad";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':actividad', $actividad);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':fecha_act', $fecha_act);
    $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
    $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_actividades.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Error al actualizar registro');
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
    <title>Editar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>


    <!-- Contenido - Formulario de Editar Actividad -->
    <div class="container form-container">
        <h1 class="text-center">Editar Actividad</h1>
        <form method="POST" action="editar_actividad.php?id=<?php echo $id_actividad; ?>">
            <div class="form-group mb-3">
                <label for="actividad">Actividad</label>
                <input type="text" id="actividad" name="actividad" class="form-control" value="<?php echo $actividad; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" value="<?php echo $descripcion; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="fecha_act">Fecha de Actividad</label>
                <input type="date" id="fecha_act" name="fecha_act" class="form-control" value="<?php echo $fecha_act; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="id_curso">ID Curso</label>
                <input type="number" id="id_curso" name="id_curso" class="form-control" value="<?php echo $id_curso; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Actualizar Actividad</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_actividades.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>