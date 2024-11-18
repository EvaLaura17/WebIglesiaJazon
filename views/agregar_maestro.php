<?php 
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar variables para almacenar los valores del formulario
$nombre = $ape_pat = $ape_mat = $num_telefono = $usuario = $contrasena = $id_curso = "";

// Consulta SQL para obtener los cursos disponibles
$sql_cursos = "SELECT id_curso, grupo FROM cursos";
$stmt_cursos = $pdo->prepare($sql_cursos);
$stmt_cursos->execute();
$cursos = $stmt_cursos->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $ape_pat = $_POST['ape_pat'];
    $ape_mat = $_POST['ape_mat'];
    $num_telefono = $_POST['num_telefono'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $id_curso = $_POST['id_curso'];

    // Generar el id_usuario: Primer nombre + inicial del apellido paterno + apellido materno + dos números aleatorios
    $id_usuario = strtolower($nombre) . strtoupper(substr($ape_pat, 0, 1)) . strtolower($ape_mat) . rand(10, 99);

    // Consulta SQL para insertar el nuevo maestro
    $sql = "INSERT INTO maestros (id_maestro, nombre, ape_pat, ape_mat, num_telefono, usuario, contrasena, id_curso) 
            VALUES (:id_maestro, :nombre, :ape_pat, :ape_mat, :num_telefono, :usuario, :contrasena, :id_curso)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_maestro', $id_usuario);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ape_pat', $ape_pat);
    $stmt->bindParam(':ape_mat', $ape_mat);
    $stmt->bindParam(':num_telefono', $num_telefono, PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $id_usuario);  // Usamos el id_usuario generado
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $mensaje = "Maestro agregado exitosamente.";
        $tipo_alerta = "success"; // Éxito
    } else {
        $mensaje = "Error al agregar el maestro.";
        $tipo_alerta = "danger"; // Error
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Maestro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Maestro -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Maestro</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_alerta; ?>" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="agregar_maestro.php" onsubmit="return validarFormulario()">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
                <span id="error_nombre" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="ape_pat">Apellido Paterno</label>
                <input type="text" id="ape_pat" name="ape_pat" class="form-control" required>
                <span id="error_ape_pat" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="ape_mat">Apellido Materno</label>
                <input type="text" id="ape_mat" name="ape_mat" class="form-control" required>
                <span id="error_ape_mat" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Número de Teléfono</label>
                <input type="text" id="num_telefono" name="num_telefono" class="form-control" required>
                <span id="error_num_telefono" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
                <span id="error_usuario" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                <span id="error_contrasena" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="id_curso">Curso</label>
                <select id="id_curso" name="id_curso" class="form-control" required>
                    <option value="">Seleccionar Curso</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo $curso['id_curso']; ?>"><?php echo $curso['grupo']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Agregar Maestro</button>
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
     <script src="../js/maestro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
