<?php 
require_once '../bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar variables para almacenar los valores del formulario
$nombre = $apellido_paterno = $apellido_materno = $fecha_nacimiento = $grupo_id = $tutor_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $tutor_id = $_POST['tutor_id'];

    // Calcular la edad a partir de la fecha de nacimiento
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento_dt)->y; // Calcula la edad

    // Buscar el grupo_id adecuado según la edad en la tabla `curso`
    $grupo_sql = "SELECT id_curso FROM curso WHERE edad_min <= :edad AND edad_max >= :edad LIMIT 1";
    $stmt_grupo = $pdo->prepare($grupo_sql);
    
    // Vincular el valor de $edad a la consulta
    $stmt_grupo->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt_grupo->execute();
    
    // Obtener el resultado de la consulta
    $grupo_id = $stmt_grupo->fetchColumn();
    
    // Si no se encuentra un grupo, asigna null o un valor predeterminado
    if (!$grupo_id) {
        $grupo_id = null;
    }

    // Consulta SQL para insertar el nuevo niño
    $sql = "INSERT INTO ninos (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, edad, grupo_id, tutor_id) 
            VALUES (:nombre, :apellido_paterno, :apellido_materno, :fecha_nacimiento, :edad, :grupo_id, :tutor_id)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido_paterno', $apellido_paterno);
    $stmt->bindParam(':apellido_materno', $apellido_materno);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt->bindParam(':grupo_id', $grupo_id, PDO::PARAM_INT);
    $stmt->bindParam(':tutor_id', $tutor_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Niño agregado exitosamente.";
        // Redirige a la página de lista de niños
        header("Location: listadoNinos.php");
        exit();
    } else {
        echo "Error al agregar el niño.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia Jazon - Agregar Niño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    /* Estilos generales */
    body {
        font-family: 'Georgia', Cambria, serif;
        background-color: #121212;
        color: #efb810;
    }

    /* Cabecera */
    header {
        background-color: #000;
        color: #efb810;
        position: sticky;
        top: 0;
        z-index: 1020;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
    }

    .title-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        width: 60px;
        height: 60px;
    }

    .title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #efb810;
    }

    .nav-link {
        color: #efb810;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: #ffffff;
    }

    /* Secciones */
    .content-section {
        padding: 3rem 1rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #efb810;
        border-bottom: 2px solid #efb810;
        padding-bottom: 5px;
        text-align: center;
        margin-bottom: 2rem;
    }

    /* Formulario */
    .form-container {
        background-color: #000;
        color: #efb810;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
        max-width: 600px;
        margin: 3rem auto;
    }

    .form-group label {
        color: #efb810;
    }

    .form-group input {
        background-color: #2e2e2e;
        color: #efb810;
        border: 1px solid #efb810;
    }

    .form-group input:focus {
        background-color: #3e3e3e;
        border-color: #c5a352; /* Borde dorado suave */
        outline: none; /* Elimina el borde azul predeterminado */
        color: #efb810;
    }

    .form-group button {
        background-color: #efb810;
        color: #000;
        transition: background-color 0.3s ease;
    }

    .form-group button:hover {
        background-color: #ffffff;
        color: #000;
    }

    /* Pie de página */
    footer {
        background-color: #0a0a0a;
        color: #bdc3c7;
        padding: 1.5rem 0;
        text-align: center;
    }

    footer a {
        color: #efb810;
        transition: color 0.3s;
    }

    footer a:hover {
        color: #ffffff;
    }
</style>

</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-light">Login</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido - Formulario de Agregar Niño -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Niño</h1>
        <form method="POST" action="agregar_nino.php">
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
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="tutor_id">ID del Tutor</label>
                <input type="number" id="tutor_id" name="tutor_id" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Agregar Niño</button>
            </div>
        </form>
        <button class="btn btn-outline-light mt-3 w-100" onclick="window.location.href='../index2.html'">Volver</button>
    </div>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024</p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a> 
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a> 
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
