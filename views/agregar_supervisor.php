<?php
// Incluye la clase Database
require_once '../includes/bd.php';

?>
<?php
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar variables para almacenar los valores del formulario
$nombre = $ape_pat = $ape_mat = $num_telefono = $usuario = $contrasena = $correo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $ape_pat = $_POST['ape_pat'];
    $ape_mat = $_POST['ape_mat'];
    $num_telefono = $_POST['num_telefono'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];

    // Generar el id_usuario: Primer nombre + inicial del apellido paterno + apellido materno + dos números aleatorios
    $id_usuario = strtolower($nombre) . strtoupper(substr($ape_pat, 0, 1)) . strtolower($ape_mat) . rand(10, 99);

    // Consulta SQL para insertar el nuevo supervisor
    $sql = "INSERT INTO supervisores (id_supervisor, nombre, ape_pat, ape_mat, usuario, contrasena, correo) 
            VALUES (:id_supervisor, :nombre, :ape_pat, :ape_mat, :usuario, :contrasena, :correo)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_supervisor', $id_usuario); // Utilizamos el id_usuario generado para el supervisor
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ape_pat', $ape_pat);
    $stmt->bindParam(':ape_mat', $ape_mat);
    $stmt->bindParam(':usuario', $id_usuario);  // Usamos el id_usuario generado
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':correo', $correo);

    if ($stmt->execute()) {
        $mensaje = "Supervisor agregado exitosamente.";
        $tipo_alerta = "success"; // Éxito
    } else {
        $mensaje = "Error al agregar el supervisor.";
        $tipo_alerta = "danger"; // Error
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Supervisor -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Supervisor</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="agregar_supervisor.php" onsubmit="return validarFormulario()">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
                <span id="errorNombre" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="ape_pat">Apellido Paterno</label>
                <input type="text" id="ape_pat" name="ape_pat" class="form-control" required>
                <span id="errorApePat" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="ape_mat">Apellido Materno</label>
                <input type="text" id="ape_mat" name="ape_mat" class="form-control" required>
                <span id="errorApeMat" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Número de Teléfono</label>
                <input type="text" id="num_telefono" name="num_telefono" class="form-control" required>
                <span id="errorTelefono" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
                <span id="errorUsuario" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                <span id="errorContrasena" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="correo">Correo</label>
                <input type="text" id="correo" name="correo" class="form-control" required>
                <span id="errorCorreo" class="text-danger"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Agregar Supervisor</button>
            </div>
        </form>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
<br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="../js/supervisor.js">
        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>