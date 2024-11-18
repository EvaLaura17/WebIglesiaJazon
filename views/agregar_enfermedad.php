<?php
// Incluye la clase Database
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();
$enfermedad = "";
$mensaje = "";  // Inicializar la variable para el mensaje

// Verificar si se envió el formulario para agregar un nuevo curso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $enfermedad = $_POST['enfermedad'];

    // Consulta SQL para insertar los datos del curso
    $sql = "INSERT INTO enfermedades (enfermedad) 
            VALUES (:enfermedad)";

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':enfermedad', $enfermedad);

    // Ejecutar la consulta y verificar si se agregó correctamente
    try {
        if ($stmt->execute()) {
            $mensaje = "Enfermedad agregada exitosamente.";  // Mensaje de éxito
        } else {
            $mensaje = "Error al agregar la enfermedad.";  // Mensaje de error
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
    <title>Agregar Enfermedad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Enfermedad -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Enfermedad</h1>
        <form method="POST" action="agregar_enfermedad.php" id="form-enfermedad">
            <div class="form-group mb-3">
                <label for="enfermedad">Enfermedad</label>
                <!-- Corregido el name a "enfermedad" -->
                <input type="text" id="enfermedad" name="enfermedad" class="form-control" value="<?php echo $enfermedad; ?>" required>
                <span id="error-enfermedad" class="text-danger"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Agregar Enfermedad</button>
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
    <script src="../js/FormAgregar.js"></script>
    <!-- Mostrar mensaje con alert si hay algún mensaje -->
    <?php if ($mensaje): ?>
        <script>
            alert("<?php echo $mensaje; ?>");
        </script>
    <?php endif; ?>
</body>

</html>
