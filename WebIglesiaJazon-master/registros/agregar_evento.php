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

// Procesa el formulario para registrar un nuevo evento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evento = $_POST['evento'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];

    // Manejo de la imagen (si se ha subido una)
    if (isset($_FILES['imagen']['tmp_name']) && $_FILES['imagen']['tmp_name'] != "") {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
        $insert_sql = "INSERT INTO eventos (evento, fecha, descripcion, imagen) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $evento, $fecha, $descripcion, $imagen);
    } else {
        $insert_sql = "INSERT INTO eventos (evento, fecha, descripcion) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $evento, $fecha, $descripcion);
    }

    if ($stmt->execute()) {
        header("Location: ../listados/listado_eventos.php"); // Redirige a la lista de eventos después de registrar
        exit();
    } else {
        echo "Error al registrar el evento: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Evento</title>
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
        <h1>Registrar Evento</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="evento">Nombre del Evento</label>
                <input type="text" id="evento" name="evento" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Evento</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Evento</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit">Registrar Evento</button>
            </div>
        </form>
        
        <a class="btn" href="../listados/listado_eventos.php">Volver</a>
    </div>

</body>
</html>
