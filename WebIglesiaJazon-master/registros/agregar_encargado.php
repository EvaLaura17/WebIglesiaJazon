<?php
require_once '../bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$id_encargado = $nombre = $apellido = $relacion = $num_telefono = "";

// Verificar si se envió el formulario para agregar un nuevo encargado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $id_encargado = $_POST['id_encargado'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $relacion = $_POST['relacion'];
    $num_telefono = $_POST['num_telefono'];

    // Consulta SQL para insertar los datos del encargado
    $sql = "INSERT INTO encargado_nino (id_encargado, nombre, apellido, relacion, num_telefono) 
            VALUES (:id_encargado, :nombre, :apellido, :relacion, :num_telefono)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_encargado', $id_encargado);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':relacion', $relacion);
    $stmt->bindParam(':num_telefono', $num_telefono, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si se agregó correctamente
    try {
        if ($stmt->execute()) {
            echo "Encargado agregado exitosamente.";
            // Redirige a la página de lista de encargados
            header("Location: ../listados/lista_encargados.php");
            exit();
        } else {
            echo "Error al agregar el encargado.";
        }
    } catch (PDOException $e) {
        echo "Error en la ejecución de la consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Encargado</title>
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
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-gold">Login</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido - Formulario de Agregar Encargado -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Encargado</h1>
        <form method="POST" action="agregar_encargado.php">
            <div class="form-group mb-3">
                <label for="id_encargado">ID Encargado</label>
                <input type="text" id="id_encargado" name="id_encargado" class="form-control" value="<?php echo $id_encargado; ?>" required>
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
                <button type="submit" class="btn btn-success w-100">Agregar Encargado</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../listados/lista_encargados.php'">Volver</button>
    </div>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe!</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
