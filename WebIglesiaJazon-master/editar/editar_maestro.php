<?php
require_once '../bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$id_maestro = $nombre = $ape_pat = $ape_mat = $num_telefono = $usuario = $contrasena = $id_curso = "";

// Verificar si se ha proporcionado un ID de maestro para editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_maestro = $_GET['id'];

    // Consulta SQL para obtener los datos del maestro por su ID
    $sql = "SELECT * FROM maestros WHERE id_maestro = :id_maestro";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_maestro', $id_maestro, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar si se encuentra el maestro
    if ($stmt->rowCount() > 0) {
        $maestro = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Asignar los valores obtenidos a las variables
        $nombre = $maestro['nombre'];
        $ape_pat = $maestro['ape_pat'];
        $ape_mat = $maestro['ape_mat'];
        $num_telefono = $maestro['num_telefono'];
        $usuario = $maestro['usuario'];
        $contrasena = $maestro['contrasena'];
        $id_curso = $maestro['id_curso'];
    } else {
        echo "Maestro no encontrado.";
        exit();
    }
}
// Verificar si se envió el formulario para actualizar el maestro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $ape_pat = $_POST['ape_pat'];
    $ape_mat = $_POST['ape_mat'];
    $num_telefono = $_POST['num_telefono'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $id_curso = $_POST['id_curso'];

    // Consulta SQL para actualizar los datos del maestro
    $sql = "UPDATE maestros SET nombre = :nombre, ape_pat = :ape_pat, ape_mat = :ape_mat, 
    num_telefono = :num_telefono, usuario = :usuario, contrasena = :contrasena, 
    id_curso = :id_curso WHERE id_maestro = :id_maestro";

    // Depuración adicional: verificar que la consulta tiene el número correcto de parámetros
    echo "Consulta SQL: $sql<br>";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    
    // Verificar que los parámetros estén vinculados correctamente
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ape_pat', $ape_pat);
    $stmt->bindParam(':ape_mat', $ape_mat);
    $stmt->bindParam(':num_telefono', $num_telefono, PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
    $stmt->bindParam(':id_maestro', $id_maestro, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si se actualizó correctamente
    try {
        if ($stmt->execute()) {
            echo "Maestro actualizado exitosamente.";
            // Redirige a la página de lista de maestros
            header("Location: ../listados/lista_maestros.php");
            exit();
        } else {
            echo "Error al actualizar el maestro.";
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
    <title>Editar Maestro</title>
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

    <!-- Contenido - Formulario de Edición de Maestro -->
    <div class="container form-container">
        <h1 class="text-center">Editar Maestro</h1>
        <form method="POST" action="editar_maestro.php?id=<?php echo $id_maestro; ?>">
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
            <div class="form-group mb-3">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $usuario; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" value="<?php echo $contrasena; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="id_curso">ID del Curso</label>
                <input type="number" id="id_curso" name="id_curso" class="form-control" value="<?php echo $id_curso; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Actualizar Maestro</button>
            </div>
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../listados/lista_maestros.php'">Volver</button>
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
