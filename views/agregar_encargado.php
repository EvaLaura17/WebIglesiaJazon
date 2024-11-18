<?php
require_once '../includes/bd.php'; // Incluye la clase de base de datos

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
    <?php include '../includes/header.php'; ?>


    <!-- Contenido - Formulario de Agregar Encargado -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Encargado</h1>
        <form method="POST" action="agregar_encargado.php"  onsubmit="return validarFormulario()">
            <div class="form-group mb-3">
                <label for="id_encargado">ID Encargado</label>
                <input type="text" id="id_encargado" name="id_encargado" class="form-control" value="<?php echo $id_encargado; ?>" required>
                <span id="error_id_encargado" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" required>
                <span id="error_nombre" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $apellido; ?>" required>
                <span id="error_apellido" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="relacion">Relación</label>
                <input type="text" id="relacion" name="relacion" class="form-control" value="<?php echo $relacion; ?>" required>
                <span id="error_relacion" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="num_telefono">Número de Teléfono</label>
                <input type="number" id="num_telefono" name="num_telefono" class="form-control" value="<?php echo $num_telefono; ?>" required>
                <span id="error_num_telefono" class="text-danger"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success w-100">Agregar Encargado</button>
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
     <script src="../js/encargado.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
