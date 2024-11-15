<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "proyectosistemas"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para obtener el registro del niño
    $sql = "SELECT id, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, tutor_id FROM ninos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $apellido_paterno = $row['apellido_paterno'];
        $apellido_materno = $row['apellido_materno'];
        $fecha_nacimiento = $row['fecha_nacimiento'];
        $tutor_id = $row['tutor_id'];
    } else {
        echo "No se encontró el registro.";
        exit();
    }
} else {
    echo "ID no proporcionado.";
    exit();
}

// Función para calcular la edad a partir de la fecha de nacimiento
function calcularEdad($fecha_nacimiento) {
    $fecha_nacimiento_dt = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento_dt)->y;
    return $edad;
}

// Procesa el formulario para actualizar los datos del niño
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_apellido_paterno = $_POST['apellido_paterno'];
    $nuevo_apellido_materno = $_POST['apellido_materno'];
    $nueva_fecha_nacimiento = $_POST['fecha_nacimiento'];
    $nuevo_tutor_id = $_POST['tutor_id'];
    $nueva_edad = calcularEdad($nueva_fecha_nacimiento);

    // Consulta para actualizar los datos en la base de datos
    $update_sql = "UPDATE ninos SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, fecha_nacimiento = ?, edad = ?, tutor_id = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ssssisi", $nuevo_nombre, $nuevo_apellido_paterno, $nuevo_apellido_materno, $nueva_fecha_nacimiento, $nueva_edad, $nuevo_tutor_id, $id);
    
    if ($stmt_update->execute()) {
        header("Location: ../listados/listadoNinos.php"); // Redirige a la lista de niños después de actualizar
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Niño</title>
    <style>
        /* Formulario */
        .form-container {
            background-color: #fffcd1f6;
            color: #efb810;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 251, 6, 0.4);
            max-width: 600px;
            margin: 3rem auto;
        }

        .form-group label {
            color: #efb810;
        }

        .form-group input {
            background-color: white;
            color: #efb810;
            border: 1px solid #efb810;
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .form-group input:focus {
            background-color: #fffcd1f6;
            border-color: #c5a352;
            outline: none;
            color: #efb810;
        }

        .form-group button {
            background-color: #efb810;
            color: white;
            padding: 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #ffffff;
            color: #efb810;
        }
        .btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ffffff; /* Fondo blanco */
            color: #000000; /* Texto negro */
            border: 2px solid #000000; /* Borde negro */
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn:hover {
            background-color: #000000; /* Fondo negro al pasar el cursor */
            color: #ffffff; /* Texto blanco al pasar el cursor */
        }
    </style>
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
</head>
<body>

    <div class="form-container">
        <h1>Editar Niño</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo $apellido_paterno; ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo $apellido_materno; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required onchange="calcularEdad()">
            </div>
            <div class="form-group">
                <label for="edad">Edad</label>
                <input type="text" id="edad" name="edad" value="<?php echo calcularEdad($fecha_nacimiento); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tutor_id">ID del Tutor</label>
                <input type="text" id="tutor_id" name="tutor_id" value="<?php echo $tutor_id; ?>">
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Información</button>
            </div>
        </form>
        
        <a class="btn" href="../listados/listadoNinos.php">Volver</a>
    </div>

</body>
</html>
