<?php
// Conexión a la base de datos usando la clase Database
include '../../includes/bd.php'; // Asegúrate de tener esta clase en la ubicación correcta

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener la conexión a la base de datos
    $conn = Database::getInstance();

    // Consulta para obtener el registro del niño y sus enfermedades
    $sql = "SELECT n.id, n.nombre, n.apellido_paterno, n.apellido_materno, n.fecha_nacimiento, 
    n.tutor_id, GROUP_CONCAT(ne.id_enfermedad) AS enfermedades,
    CONCAT(t.nombre, ' ', t.ap_pat, ' ', t.ap_mat) AS nombre_tutor
    FROM ninos n
    LEFT JOIN nino_enfermedad ne ON n.id = ne.id_nino
    LEFT JOIN tutores t ON n.tutor_id = t.id_tutor
    WHERE n.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre = $row['nombre'];
        $apellido_paterno = $row['apellido_paterno'];
        $apellido_materno = $row['apellido_materno'];
        $fecha_nacimiento = $row['fecha_nacimiento'];
        $tutor_id = $row['tutor_id'];
        $nombre_tutor = $row['nombre_tutor']; // Nombre completo del tutor

        // Obtener las enfermedades como un array
        $enfermedades_seleccionadas = explode(',', $row['enfermedades']);
    } else {
        echo "<script>
            alert('No se encontro el registro');
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('Id no proporcionado');
    </script>";
    exit();
}

// Función para calcular la edad a partir de la fecha de nacimiento
function calcularEdad($fecha_nacimiento)
{
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    return $hoy->diff($fecha_nacimiento_dt)->y;
}

// Procesa el formulario para actualizar los datos del niño
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores del formulario
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_apellido_paterno = $_POST['apellido_paterno'];
    $nuevo_apellido_materno = $_POST['apellido_materno'];
    $nueva_fecha_nacimiento = $_POST['fecha_nacimiento'];
    $nuevo_tutor_id = $_POST['tutor_id'];
    $nueva_edad = calcularEdad($nueva_fecha_nacimiento);

    // Obtener las enfermedades seleccionadas
    $enfermedades_seleccionadas = $_POST['enfermedades'] ?? [];

    // Obtener la conexión a la base de datos
    $conn = Database::getInstance();

    // Consulta para actualizar los datos en la base de datos
    $update_sql = "UPDATE ninos SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, fecha_nacimiento = ?, edad = ?, tutor_id = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bindParam(1, $nuevo_nombre);
    $stmt_update->bindParam(2, $nuevo_apellido_paterno);
    $stmt_update->bindParam(3, $nuevo_apellido_materno);
    $stmt_update->bindParam(4, $nueva_fecha_nacimiento);
    $stmt_update->bindParam(5, $nueva_edad, PDO::PARAM_INT);
    $stmt_update->bindParam(6, $nuevo_tutor_id);
    $stmt_update->bindParam(7, $id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        // Eliminar enfermedades existentes
        $delete_sql = "DELETE FROM nino_enfermedad WHERE id_nino = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bindParam(1, $id, PDO::PARAM_INT);
        $stmt_delete->execute();

        // Insertar nuevas enfermedades seleccionadas
        foreach ($enfermedades_seleccionadas as $id_enfermedad) {
            if (!empty($id_enfermedad)) {
                $sql_enfermedad = "INSERT INTO nino_enfermedad (id_nino, id_enfermedad) VALUES (?, ?)";
                $stmt_enfermedad = $conn->prepare($sql_enfermedad);
                $stmt_enfermedad->bindParam(1, $id, PDO::PARAM_INT);
                $stmt_enfermedad->bindParam(2, $id_enfermedad, PDO::PARAM_INT);
                $stmt_enfermedad->execute();
            }
        }

        echo "<script>
            alert('Registro actualizado');
            window.location.href = '../ver_ninos.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Error al actualizar el niño');
        </script>";
    }

    // Cierra la conexión
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Niño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css/conAgregar_nino.css">

</head>

<body>

    <?php include '../../includes/header2.php'; ?>

    <div class="container form-container">
        <h1 class="text-center">Editar Niño</h1>

        <form method="POST" action="editar_nino.php?id=<?php echo htmlspecialchars($id); ?>">
            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="<?php echo htmlspecialchars($apellido_paterno); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="<?php echo htmlspecialchars($apellido_materno); ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>" required onchange="calcularEdad()">
            </div>
            <div class="form-group mb-3">
                <label for="edad">Edad</label>
                <input type="text" id="edad" name="edad" class="form-control" value="<?php echo calcularEdad($fecha_nacimiento); ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="tutor_id">Nombre del Tutor</label>
                <input type="text" id="tutor_id" name="tutor_id" class="form-control" value="<?php echo htmlspecialchars($nombre_tutor); ?>" required>
            </div>

            <!-- Campo para seleccionar las enfermedades -->
            <div class="form-group mb-3">
                <label for="enfermedades">Selecciona las Enfermedades</label>
                <select id="enfermedades" name="enfermedades[]" class="form-control" multiple required>
                    <?php
                    // Obtener la lista de enfermedades desde la base de datos
                    include '../../includes/bd.php';
                    // Obtener todas las enfermedades disponibles
                    $enfermedades_sql = "SELECT id_enfermedad, enfermedad FROM enfermedades";
                    $stmt_enfermedades = Database::getInstance()->prepare($enfermedades_sql);
                    $stmt_enfermedades->execute();
                    while ($enfermedad_row = $stmt_enfermedades->fetch(PDO::FETCH_ASSOC)) {
                        // Verificar si esta enfermedad está seleccionada previamente
                        if (in_array($enfermedad_row['id_enfermedad'], $enfermedades_seleccionadas)) {
                            echo "<option value='" . htmlspecialchars($enfermedad_row['id_enfermedad']) . "' selected>" . htmlspecialchars($enfermedad_row['enfermedad']) . "</option>";
                        } else {
                            echo "<option value='" . htmlspecialchars($enfermedad_row['id_enfermedad']) . "'>" . htmlspecialchars($enfermedad_row['enfermedad']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Actualizar Información</button>
        </form>

        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../ver_ninos.php'">Volver</button>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function calcularEdad() {
            const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
            const hoy = new Date();
            const nacimiento = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const mes = hoy.getMonth() - nacimiento.getMonth();

            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            document.getElementById('edad').value = edad;
        }
    </script>

</body>

</html>