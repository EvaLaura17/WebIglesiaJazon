<?php
// Incluye la clase Database
require_once '../includes/bd.php';

try {
    // Obtén la instancia de conexión usando la clase Database
    $conn = Database::getInstance();

    // Verifica si se envía el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_nino = $_POST['id_nino'];
        $id_encargado = $_POST['id_encargado'];
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        // Inserción de los datos de salida en la tabla 'salida'
        $insert_sql = "INSERT INTO salida (fecha, hora, id_nino, id_encargado) VALUES (:fecha, :hora, :id_nino, :id_encargado)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':id_nino', $id_nino, PDO::PARAM_INT);
        $stmt->bindParam(':id_encargado', $id_encargado);

        if ($stmt->execute()) {
            echo "Datos de salida registrados correctamente.";
        } else {
            echo "Error: " . implode(" ", $stmt->errorInfo());
        }
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Registro de Salida de Niño</title>
</head>
<body>
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                </div>
                <span class="title">Iglesia Jazon</span>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.html" class="nav-link px-2">Inicio</a></li>
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
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
                // Consulta para obtener los niños usando PDO
                $consulta_ninos = "SELECT id, nombre FROM ninos";
                $stmt_ninos = $conn->query($consulta_ninos);

                if ($stmt_ninos) {
                    while ($nino = $stmt_ninos->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $nino['id'] . "'>" . $nino['nombre'] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="id_encargado">Selecciona al Encargado</label>
            <select name="id_encargado" id="id_encargado" required>
                <option value="">Seleccionar...</option>
                <?php
                // Consulta para obtener los encargados usando PDO
                $consulta_encargados = "SELECT id_encargado, nombre, apellido FROM encargado_nino";
                $stmt_encargados = $conn->query($consulta_encargados);

                if ($stmt_encargados) {
                    while ($encargado = $stmt_encargados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $encargado['id_encargado'] . "'>" . $encargado['nombre'] . " " . $encargado['apellido'] . "</option>";
                    }
                }
                ?>
            </select>
            <br>

            <input type="submit" value="Registrar Salida">
        </form>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
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
// No necesitas cerrar la conexión manualmente al usar PDO.
?>
