<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "iglesiajazon"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesa el formulario para registrar un nuevo evento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evento = $_POST['evento'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Manejo de la imagen (si se ha subido una)
    if (isset($_FILES['imagen']['tmp_name']) && $_FILES['imagen']['tmp_name'] != "") {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $insert_sql = "INSERT INTO eventos (evento, imagen, fecha, descripcion) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $evento, $imagen, $fecha, $descripcion);
    } else {
        $insert_sql = "INSERT INTO eventos (evento, fecha, descripcion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $evento, $fecha, $descripcion);
    }

    if ($stmt->execute()) {
        header("Location: ver_evento.php"); // Redirige a la lista de eventos después de registrar
        exit();
    } else {
        echo "Error al registrar el evento: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/FormEvento.css">
    <title>Registrar Evento</title>

</head>

<body>
    <!-- Incluir el encabezado -->
    <?php include '../includes/header.php'; ?>
    
    <div class="container form-container">
        <h1 class="text-center">Registrar Evento</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="evento">Nombre del Evento</label>
                <input type="text" id="evento" name="evento" required>
                <span class="error-msg" id="error-evento"></span>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Evento</label>
                <input type="date" id="fecha" name="fecha" required min="2022-01-01">
                <span class="error-msg" id="error-fecha"></span>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                <span class="error-msg" id="error-descripcion"></span>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Evento</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <span class="error-msg" id="error-imagen"></span>
            </div>
            <div class="form-group">
                <button type="submit">Registrar Evento</button>
            </div>
        </form>

        
    </div>
    <div class="text-center ">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
        <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>
<script src="../js/evento.js"></script>
</body>

</html>