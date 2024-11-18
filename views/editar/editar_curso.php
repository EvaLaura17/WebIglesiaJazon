<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Verificar si se envió el ID del encargado para editar
if (isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];

    // Consulta para obtener los datos del encargado a editar
    $sql = "SELECT * FROM cursos WHERE id_curso = :id_curso";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_curso', $id_curso);
    $stmt->execute();
    $curso = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si existe el encargado
    if ($curso) {
        // Asignar los datos a las variables
        $grupo = $curso['grupo'];
        $edadMin = $curso['edad_min'];
        $edadMax = $curso['edad_max'];
        $cantMax = $curso['cant_max'];
    } else {
        echo "<script>
            alert('No se encontro al curso');
        </script>";
        exit();
    }
}

// Verificar si se envió el formulario para editar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $grupo = $curso['nombre'];
    $edadMin = $curso['edad_min'];
    $edadMax = $curso['edad_max'];
    $cantMax = $curso['cant_max'];

    // Consulta SQL para actualizar los datos del encargado
    $sql = "UPDATE cursos SET grupo = :grupo, edad_min = :edad_min, edad_max = :edad_max, cant_max = :cant_max WHERE id_curso = :id_curso";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_curso', $nombre);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':edad_min', $edadMin, PDO::PARAM_INT);
    $stmt->bindParam(':edad_max', $edadMax, PDO::PARAM_INT);
    $stmt->bindParam(':cant_max', $cantMax, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_cursos.php';
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
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../../includes/header2.php'; ?>


    <!-- Contenido - Formulario de Editar Encargado -->
    <div class="container form-container">
        <h1 class="text-center">Editar Grupo</h1>
        <form method="POST" action="editar_encargado.php?id=<?php echo $id_curso; ?>">
            <div class="form-group mb-3">
                <label for="grupo">Grupo</label>
                <input type="text" id="grupo" name="grupo" class="form-control" value="<?php echo $grupo; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="edad_min">Edad Minima</label>
                <input type="number" id="edad_min" name="edad_min" class="form-control" value="<?php echo $edadMin; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="edad_max">Edad Maxima</label>
                <input type="number" id="edad_max" name="edad_max" class="form-control" value="<?php echo $edadMax; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Cantidad Maxima de niños</label>
                <input type="number" id="num_telefono" name="num_telefono" class="form-control" value="<?php echo $cantMax; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Actualizar Curso</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_cursos.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>