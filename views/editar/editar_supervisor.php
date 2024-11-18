<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();


// Verificar si se ha proporcionado un ID de tutor para editar
if (isset($_GET['id_supervisor'])) {
    $id_supervisor = $_GET['id_supervisor'];

    // Consulta SQL para obtener los datos del tutor por su ID
    $sql = "SELECT * FROM supervisores WHERE id_supervisor = :id_supervisor";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_supervisor', $id_supervisor);
    $stmt->execute();

    // Verificar si se encuentra el tutor
    if ($stmt->rowCount() > 0) {
        $supervisor = $stmt->fetch(PDO::FETCH_ASSOC);

        // Asignar los valores obtenidos a las variables
        $nombre = $supervisor['nombre'];
        $ape_pat = $supervisor['ape_pat'];
        $ape_mat = $supervisor['ape_mat'];
        $usuario = $supervisor['usuario'];
        $contrasena = $supervisor['contrasena'];
        $correo = $supervisor['correo'];
    } else {
        echo "<script>
            alert('Supervisor no encontrado ');
        </script>";
        exit();
    }
}

// Verificar si se envió el formulario para actualizar el tutor
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $ape_pat = $_POST['ape_pat'];
    $ape_mat = $_POST['ape_mat'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];


    // Consulta SQL para actualizar los datos del tutor
    // Consulta SQL para actualizar los datos del supervisor
    $sql = "UPDATE supervisores SET nombre = :nombre, ape_pat = :ape_pat, ape_mat = :ape_mat, 
usuario = :usuario, contrasena = :contrasena, correo = :correo WHERE id_supervisor = :id_supervisor";

    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Vincular los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ape_pat', $ape_pat);
    $stmt->bindParam(':ape_mat', $ape_mat);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':correo', $correo);

    // Aquí se debe incluir el ID del supervisor para la actualización
    $stmt->bindParam(':id_supervisor', $id_supervisor);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "<script>
                alert('Registro del supervisor actualizado');
                window.location.href = '../ver_supervisores.php';
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

    <!-- Contenido - Formulario de Edición de supervisor -->
    <div class="container form-container">
        <h1 class="text-center">Editar supervisor</h1>
        <form method="POST" action="editar_supervisor.php?id_supervisor=<?php echo $id_supervisor; ?>">
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
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $usuario; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="contrasena">Contraseña</label>
                <input type="text" id="contrasena" name="contrasena" class="form-control" value="<?php echo $contrasena; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="correo">Correo</label>
                <input type="text" id="correo" name="correo" class="form-control" value="<?php echo $correo; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Actualizar supervisor</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_supervisores.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <?php include '../../includes/footer.php'; ?>


    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>