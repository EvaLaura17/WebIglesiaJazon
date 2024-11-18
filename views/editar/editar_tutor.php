<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$id_tutor = $nombre = $ape_pat = $ape_mat = $num_telefono = "";

// Verificar si se ha proporcionado un ID de tutor para editar
if (isset($_GET['id_tutor'])) {
    $id_tutor = $_GET['id_tutor'];

    // Consulta SQL para obtener los datos del tutor por su ID
    $sql = "SELECT * FROM tutores WHERE id_tutor = :id_tutor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_tutor', $id_tutor, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si se encuentra el tutor
    if ($stmt->rowCount() > 0) {
        $tutor = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores obtenidos a las variables
        $nombre = $tutor['nombre'];
        $ape_pat = $tutor['ap_pat'];
        $ape_mat = $tutor['ap_mat'];
        $num_telefono = $tutor['num_telefono'];
    } else {
        echo "<script>
            alert('Tutor no encontrado ');
        </script>";
        exit();
    }
}

// Verificar si se envió el formulario para actualizar el tutor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $ape_pat = $_POST['ape_pat'];
    $ape_mat = $_POST['ape_mat'];
    $num_telefono = $_POST['num_telefono'];

    // Consulta SQL para actualizar los datos del tutor
    $sql = "UPDATE tutores SET nombre = :nombre, ap_pat = :ap_pat, ap_mat = :ap_mat, 
            num_telefono = :num_telefono WHERE id_tutor = :id_tutor";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ap_pat', $ape_pat);
    $stmt->bindParam(':ap_mat', $ape_mat);
    $stmt->bindParam(':num_telefono', $num_telefono, PDO::PARAM_INT);
    $stmt->bindParam(':id_tutor', $id_tutor, PDO::PARAM_STR);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro actualizado');
                window.location.href = '../ver_tutores.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Error al actualizar al tutor');
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
    <title>Editar Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../../includes/header2.php'; ?>

    <!-- Contenido - Formulario de Edición de Tutor -->
    <div class="container form-container">
        <h1 class="text-center">Editar Tutor</h1>
        <form method="POST" action="editar_tutor.php?id=<?php echo $id_tutor; ?>">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="ape_pat">Apellido Paterno</label>
                <input type="text" id="ape_pat" name="ape_pat" class="form-control" value="<?php echo $ape_pat; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="ape_mat">Apellido Materno</label>
                <input type="text" id="ape_mat" name="ape_mat" class="form-control" value="<?php echo $ape_mat; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Número de Teléfono</label>
                <input type="number" id="num_telefono" name="num_telefono" class="form-control" value="<?php echo $num_telefono; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Actualizar Tutor</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_tutores.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>