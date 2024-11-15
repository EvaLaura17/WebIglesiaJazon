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

// Verifica si se ha enviado el ID del evento
if (isset($_GET['id_evento'])) {
    $id_evento = $_GET['id_evento'];
    
    // Consulta para obtener el registro del evento
    $sql = "SELECT id_evento, evento, imagen, fecha, descripcion FROM eventos WHERE id_evento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_evento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $evento = $row['evento'];
        $fecha = $row['fecha'];
        $descripcion = $row['descripcion'];
        $imagen = $row['imagen']; // Asume que la imagen es opcional y se mostrará si está presente
    } else {
        echo "No se encontró el registro.";
        exit();
    }
} else {
    echo "ID del evento no proporcionado.";
    exit();
}

// Procesa el formulario para actualizar los datos del evento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_evento = $_POST['evento'];
    $nueva_fecha = $_POST['fecha'];
    $nueva_descripcion = $_POST['descripcion'];

    // Si se ha subido una nueva imagen
    if (isset($_FILES['imagen']['tmp_name']) && $_FILES['imagen']['tmp_name'] != "") {
        $nueva_imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        // Actualiza el evento con la nueva imagen
        $update_sql = "UPDATE eventos SET evento = ?, fecha = ?, descripcion = ?, imagen = ? WHERE id_evento = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("ssssi", $nuevo_evento, $nueva_fecha, $nueva_descripcion, $nueva_imagen, $id_evento);
    } else {
        // No se actualiza la imagen, solo los otros datos
        $update_sql = "UPDATE eventos SET evento = ?, fecha = ?, descripcion = ? WHERE id_evento = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("sssi", $nuevo_evento, $nueva_fecha, $nueva_descripcion, $id_evento);
    }
    
    if ($stmt_update->execute()) {
        header("Location: ../listados/listado_eventos.php"); // Redirige a la lista de eventos después de actualizar
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
    <title>Editar Evento</title>
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

        .form-group input,
        .form-group textarea {
            background-color: white;
            color: #efb810;
            border: 1px solid #efb810;
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
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
</head>
<body>

    <div class="form-container">
        <h1>Editar Evento</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="evento">Nombre del Evento</label>
                <input type="text" id="evento" name="evento" value="<?php echo htmlspecialchars($evento); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Evento</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen (deja en blanco si no deseas cambiarla)</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <?php if ($imagen): ?>
                    <p>Imagen actual:</p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen); ?>" width="150" height="150">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <button type="submit">Actualizar Información</button>
            </div>
        </form>
        
        <a class="btn" href="../listados/listado_eventos.php">Volver</a>
    </div>

</body>
</html>
