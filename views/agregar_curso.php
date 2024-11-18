<?php
// Incluye la clase Database
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar las variables
$grupo = $edadMin = $edadMax = $cant = "";
$mensaje = "";  // Variable para almacenar el mensaje de éxito o error

// Verificar si se envió el formulario para agregar un nuevo curso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $grupo = $_POST['grupo'];
    $edadMin = $_POST['edadMin'];
    $edadMax = $_POST['edadMax'];
    $cant = $_POST['cant'];

    // Consulta SQL para insertar los datos del curso
    $sql = "INSERT INTO cursos (grupo, edad_min, edad_max, cant_max) 
            VALUES (:grupo, :edadMin, :edadMax, :cant)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':grupo', $grupo);
    $stmt->bindParam(':edadMin', $edadMin, PDO::PARAM_INT);
    $stmt->bindParam(':edadMax', $edadMax, PDO::PARAM_INT);
    $stmt->bindParam(':cant', $cant, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si se agregó correctamente
    try {
        if ($stmt->execute()) {
            $mensaje = "Curso agregado exitosamente.";  // Mensaje de éxito
        } else {
            $mensaje = "Error al agregar el curso.";  // Mensaje de error
        }
    } catch (PDOException $e) {
        $mensaje = "Error en la ejecución de la consulta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>
<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Curso -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Curso</h1>
        <form method="POST" action="agregar_curso.php" id="form-curso">
            <div class="form-group mb-3">
                <label for="grupo">Grupo</label>
                <input type="text" id="grupo" name="grupo" class="form-control" value="<?php echo $grupo; ?>" required>
                <span id="error-grupo" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="edadMin">Edad mínima</label>
                <input type="number" id="edadMin" name="edadMin" class="form-control" value="<?php echo $edadMin; ?>" required>
                <span id="error-edadMin" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="edadMax">Edad máxima</label>
                <input type="number" id="edadMax" name="edadMax" class="form-control" value="<?php echo $edadMax; ?>" required>
                <span id="error-edadMax" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="cant">Cantidad máxima de niños</label>
                <input type="number" id="cant" name="cant" class="form-control" value="<?php echo $cant; ?>" required>
                <span id="error-cant" class="text-danger"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Agregar Curso</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/curso.js"></script>
    <!-- Mostrar mensaje con alert si hay algún mensaje -->
    <?php if ($mensaje): ?>
        <script>
            alert("<?php echo $mensaje; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
