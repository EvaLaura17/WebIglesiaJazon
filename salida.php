<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "proyectosistemas"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nino = $_POST['id_nino'];
    $id_encargado = $_POST['id_encargado'];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    // Inserción de los datos de salida en la tabla 'salida'
    $insert_sql = "INSERT INTO salida (fecha, hora, id_nino, id_encargado) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssis", $fecha, $hora, $id_nino, $id_encargado);
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }


    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Registro de Salida de Niño</title>
    <style>
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: #121212;
            color: black;
        }

        .container {
            background-color: black;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #efb810;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            margin-top: 20px; /* Separación del header */
            text-align: left; /* Centrar contenido */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #efb810;
        }

        form label {
        text-align: left;
            margin: 10px 0 5px;
            color: white;
        }

        form select,
        form input[type="submit"],
        form button {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: black;
            color: #efb810;
            border: 2px solid #efb810;
            width: 100%; /* Tamaño uniforme */
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #efb810;
            color: black;
        }

        .nav-link {
            color: #efb810;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        /* Cabecera */
        header {
            background-color: #000;
            color: #efb810;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .title-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 250px;
            height: 80px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #efb810;
        }
           /* Pie de página */
        footer {
            background-color: #0a0a0a;
            color: #bdc3c7;
            padding: 1.5rem 0;
            text-align: center;
        }

        footer a {
            color: #efb810;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffffff;
        }
    </style>
</head>

<body>
  <!-- CABECERA -->
  <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="logoFinal.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.html" class="nav-link px-2">Inico</a></li>
                    <li><a href="index2.html" class="nav-link px-2">Deshboard</a></li>
                </ul>
            
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Registrar Salida de Niño</h1>

        <form method="POST" action="">
            <label for="id_nino">Selecciona al Niño</label>
            <select name="id_nino" id="id_nino" required>
                <option value="">Seleccionar...</option>
                <?php
                // Consulta para obtener los niños
                $consulta_ninos = "SELECT id, nombre FROM ninos";
                $resultado_ninos = $conn->query($consulta_ninos);

                if ($resultado_ninos->num_rows > 0) {
                    while ($nino = $resultado_ninos->fetch_assoc()) {
                        echo "<option value='" . $nino['id'] . "'>" . $nino['nombre'] . "</option>";
                    }
                }
                ?>
            </select>
            <br>

            <label for="id_encargado">Selecciona al Encargado</label>
            <select name="id_encargado" id="id_encargado" required>
                <option value="">Seleccionar...</option>
                <?php
                // Consulta para obtener los encargados
                $consulta_encargados = "SELECT id_encargado, nombre, apellido FROM encargado_nino";
                $resultado_encargados = $conn->query($consulta_encargados);

                if ($resultado_encargados->num_rows > 0) {
                    while ($encargado = $resultado_encargados->fetch_assoc()) {
                        echo "<option value='" . $encargado['id_encargado'] . "'>" . $encargado['nombre'] . " " . $encargado['apellido'] . "</option>";
                    }
                }
                ?>
            </select>
            <br>    

            <input type="submit" value="Registrar Salida">
        </form>
       
    </div>
    <br>
 <!-- Pie de página -->
 <footer class="text-center p-4">
        <p>Jazon &copy; 2024</p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a> 
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a> 
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


<?php
// Cerrar la conexión
$conn->close();
?>