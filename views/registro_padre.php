<?php
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar variables para almacenar los valores del formulario
$nombre = $apellido_paterno = $apellido_materno = $numero_telefono = "";

// Si el formulario es enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $numero_telefono = $_POST['numero'];

    // Generar el ID del tutor basado en nombre, apellido y un número aleatorio de 3 dígitos
    $id_tutor = strtoupper(substr($nombre, 0, 3)) . strtoupper(substr($apellido_paterno, 0, 3)) . rand(100, 999);

    // Consulta SQL para insertar el nuevo tutor
    $sql = "INSERT INTO tutor (id_tutor, nombre, ap_pat, ap_mat, num_telefono) 
            VALUES (:id_tutor, :nombre, :apellido_paterno, :apellido_materno, :numero_telefono)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_tutor', $id_tutor);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido_paterno', $apellido_paterno);
    $stmt->bindParam(':apellido_materno', $apellido_materno);
    $stmt->bindParam(':numero_telefono', $numero_telefono);

    if ($stmt->execute()) {
        echo "Tutor agregado exitosamente.";
        // Redirige a la página de lista de tutores o al listado de niños
        header("Location: agregar_nino.php");  // Cambia esto a la página correspondiente
        exit();
    } else {
        echo "Error al agregar el tutor.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Tutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-gold">Login</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Contenido - Formulario de Registro de Tutor -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Tutor</h1>
        <form method="POST" action="registro_padre.php">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="numero">Número de Teléfono</label>
                <input type="number" id="numero" name="numero" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Agregar Tutor</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='index2.html'">Volver</button>
    </div>
    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252916</p>
    </footer>
</body>

</html>
