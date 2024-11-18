<?php
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Inicializar variables para almacenar los valores del formulario
$nombre = $apellido_paterno = $apellido_materno = $fecha_nacimiento = $grupo_id = $tutor_id = "";

// Obtener la lista de tutores
$tutores_sql = "SELECT id_tutor, nombre, ap_pat, ap_mat FROM tutores";
$stmt_tutores = $pdo->prepare($tutores_sql);
$stmt_tutores->execute();
$tutores = $stmt_tutores->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de enfermedades
$enfermedades_sql = "SELECT id_enfermedad, enfermedad FROM enfermedades";
$stmt_enfermedades = $pdo->prepare($enfermedades_sql);
$stmt_enfermedades->execute();
$enfermedades = $stmt_enfermedades->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $tutor_id = $_POST['tutor_id'];
    $enfermedades_seleccionadas = $_POST['enfermedades'] ?? [];  // Enfermedades seleccionadas

    // Calcular la edad a partir de la fecha de nacimiento
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento_dt)->y; // Calcula la edad

    // Buscar el grupo_id adecuado según la edad en la tabla `curso`
    $grupo_sql = "SELECT id_curso FROM cursos WHERE edad_min <= :edad AND edad_max >= :edad LIMIT 1";
    $stmt_grupo = $pdo->prepare($grupo_sql);
    $stmt_grupo->bindParam(':edad', $edad, PDO::PARAM_INT);
    $stmt_grupo->execute();
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
    $stmt->bindParam(':tutor_id', $tutor_id);

    if ($stmt->execute()) {
        $id_nino = $pdo->lastInsertId(); // Obtener el ID del niño insertado

        // Insertar las enfermedades seleccionadas en la tabla nino_enfermedad
        foreach ($enfermedades_seleccionadas as $id_enfermedad) {
            $sql_enfermedad = "INSERT INTO nino_enfermedad (id_nino, id_enfermedad) VALUES (:id_nino, :id_enfermedad)";
            $stmt_enfermedad = $pdo->prepare($sql_enfermedad);
            $stmt_enfermedad->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
            $stmt_enfermedad->bindParam(':id_enfermedad', $id_enfermedad, PDO::PARAM_INT);
            $stmt_enfermedad->execute();
        }

        echo "Niño agregado exitosamente.";
        // Redirige a la página de lista de niños
        header("Location: ver_ninos.php");
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
    <title>Registro de Niños</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conAgregar_nino.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- Contenido - Formulario de Agregar Niño -->
    <div class="container form-container">
        <h1 class="text-center">Agregar Niño</h1>
        <form method="POST" action="agregar_nino.php">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
                <span id="error_nombre" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" required>
                <span id="error_apellido_paterno" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" required>
                <span id="error_apellido_materno" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" min="2011-01-01"
                    required>
                    <span id="error_fecha" class="text-danger"></span>
            </div>
            <div class="form-group mb-3">
                <label for="tutor_id">Selecciona el Tutor</label>
                <select id="tutor_id" name="tutor_id" class="form-control" required>
                    <option value="">Selecciona un tutor</option>
                    <?php foreach ($tutores as $tutor): ?>
                        <option value="<?php echo $tutor['id_tutor']; ?>">
                            <?php echo $tutor['nombre'] . ' ' . $tutor['ap_pat'] . ' ' . $tutor['ap_mat']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="enfermedades">Selecciona las Enfermedades</label>
                <select id="enfermedades" name="enfermedades[]" class="form-control" multiple required>
                    <?php foreach ($enfermedades as $enfermedad): ?>
                        <option value="<?php echo $enfermedad['id_enfermedad']; ?>">
                            <?php echo $enfermedad['enfermedad']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <center>
            <button type="submit" class="btn btn-primary">Agregar Niño</button>
            </center>
           
        </form>
      

    </div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Establecer la fecha máxima en el campo input a 4 años atrás de la fecha actual
        const today = new Date();
        const maxDate = new Date(today);
        maxDate.setFullYear(today.getFullYear() - 4); // Restar 4 años

        const formattedMaxDate = maxDate.toISOString().split('T')[0]; // Formato YYYY-MM-DD
        document.getElementById('fecha_nacimiento').setAttribute('max', formattedMaxDate);
    </script>
    <script src="../js/FormAgregar.js"></script>
</body>

</html>