<?php
require_once '../bd.php'; // Incluye la clase de base de datos

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
            echo "Actividad actualizada exitosamente.";
            // Redirige a la página de lista de actividades
            header("Location: ../listados/lista_actividades.php");
            exit();
        } else {
            echo "Error al actualizar la actividad.";
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
    <title>Editar Actividad</title>
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
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../listados/lista_actividades.php'">Volver</button>
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
