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
    
    // Consulta para obtener el registro de asistencia y los datos del niño
    $sql = "SELECT a.id, a.nino_id, a.grupo_id, a.fecha, a.estado, 
                   n.nombre, n.apellido_paterno, n.apellido_materno 
            FROM asistencia a 
            JOIN ninos n ON a.nino_id = n.id 
            WHERE a.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nino_id = $row['nino_id'];
        $nombre = $row['nombre'];
        $apellido_paterno = $row['apellido_paterno'];
        $apellido_materno = $row['apellido_materno'];
        $grupo_id = $row['grupo_id'];
        $fecha = $row['fecha'];
        $estado = $row['estado'];
    } else {
        echo "No se encontró el registro.";
        exit();
    }
} else {
    echo "ID no proporcionado.";
    exit();
}

// Procesa el formulario para actualizar el estado de la asistencia
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_estado = $_POST['estado'];
    
    // Consulta para actualizar el estado en la base de datos
    $update_sql = "UPDATE asistencia SET estado = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("si", $nuevo_estado, $id);
    
    if ($stmt_update->execute()) {
        // Redirige a la página de lista de asistencia después de actualizar
        header("Location: lista_asistencia.php");
        exit();
    } else {
        echo "Error al actualizar la asistencia: " . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select, .form-group button {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Editar Asistencia</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nino">Nombre del Niño</label>
                <input type="text" id="nino" value="<?php echo $nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="grupo_id">Grupo ID</label>
                <input type="text" id="grupo_id" value="<?php echo $grupo_id; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="text" id="fecha" value="<?php echo $fecha; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="estado">Estado de Asistencia</label>
                <select id="estado" name="estado">
                    <option value="Presente" <?php if ($estado == 'Presente') echo 'selected'; ?>>Presente</option>
                    <option value="Ausente" <?php if ($estado == 'Ausente') echo 'selected'; ?>>Ausente</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Asistencia</button>
            </div>
        </form>
        
        <button class="btn" onclick="window.location.href='lista_asistencia.php'">Volver</button>
    </div>

</body>
</html>
