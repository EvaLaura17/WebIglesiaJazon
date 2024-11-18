    <?php
    require_once '../includes/bd.php'; // Incluye la clase de base de datos

    // Obtener la conexión a la base de datos
    $pdo = Database::getInstance();

    // Inicializar las variables
    $actividad = $descripcion = $fecha_act = $id_curso = "";

    // Verificar si se envió el formulario para agregar una nueva actividad
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $actividad = $_POST['actividad'];
        $descripcion = $_POST['descripcion'];
        $fecha_act = $_POST['fecha_act'];
        $id_curso = $_POST['id_curso'];

        // Consulta SQL para insertar los datos de la actividad
        $sql = "INSERT INTO actividades (actividad, descripcion, fecha_act, id_curso) 
                VALUES (:actividad, :descripcion, :fecha_act, :id_curso)";

        // Preparar y ejecutar la consulta
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':actividad', $actividad);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_act', $fecha_act);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);

        // Ejecutar la consulta y verificar si se agregó correctamente
        try {
            if ($stmt->execute()) {
                echo "Actividad agregada exitosamente.";
                // Redirige a la página de lista de actividades
                header("Location: ver_actividades.php");
                exit();
            } else {
                echo "Error al agregar la actividad.";
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
    <title>Agregar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Actividad -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Actividad</h1>
        <form method="POST" action="agregar_actividad.php" id="form-actividad">
            <div class="form-group mb-3">
                <label for="actividad">Actividad</label>
                <input type="text" id="actividad" name="actividad" class="form-control"
                    value="<?php echo $actividad; ?>" required>
                <span id="error-actividad" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control"
                    value="<?php echo $descripcion; ?>" required>
                <span id="error-descripcion" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="fecha_act">Fecha de Actividad</label>
                <input type="date" id="fecha_act" name="fecha_act" class="form-control"
                    value="<?php echo $fecha_act; ?>" required>
                <span id="error-fecha" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="id_curso">ID Curso</label>
                <input type="number" id="id_curso" name="id_curso" class="form-control" value="<?php echo $id_curso; ?>"
                    required>
                <span id="error-id_curso" class="text-danger"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Agregar Actividad</button>
            </div>
        </form>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/actividad.js"></script>
</body>

</html>
