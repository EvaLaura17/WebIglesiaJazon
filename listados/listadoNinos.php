<?php
require_once '../bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Consulta para obtener los grupos (en este caso, se usan los valores de grupo_id distintos)
$grupos = $pdo->query("SELECT DISTINCT grupo_id FROM ninos");

// Verifica si se ha seleccionado un grupo
$grupo_seleccionado = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

// Consulta para obtener los niños del grupo seleccionado
$consulta_niños = "SELECT id, nombre, apellido_paterno, apellido_materno, edad FROM ninos WHERE grupo_id = :grupo_id";
$resultado = [];

if ($grupo_seleccionado) {
    $stmt = $pdo->prepare($consulta_niños);
    $stmt->bindParam(':grupo_id', $grupo_seleccionado, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listado de Niños</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conListadoNinos.css">

</head>
<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-gold">Login</a>
                </div>
            </div>
        </div>
    </header>
    <!--CONTENIDO-->
    
    <div class="container content-section">
        <h1 class="section-title">Lista de Niños por Grupo</h1>

        <!-- Formulario para seleccionar un grupo -->
        <form method="POST" action="listadoNinos.php">
            <label for="grupo_id">Selecciona un Grupo:</label>
            <select name="grupo_id" id="grupo_id" required class="form-select"
                style="background-color: #fffcd1f6; color: #efb810; border: 1px solid #efb810;">
                <option value="" style="color: #efb810;">Seleccionar...</option>
                <?php
                // Mostrar los grupos disponibles en la caja de selección
                foreach ($grupos as $row) {
                    echo "<option value='" . $row['grupo_id'] . "'>" . $row['grupo_id'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn2">Mostrar Niños</button>
        </form>

        <!-- Tabla con los niños del grupo seleccionado -->
        <?php
        if ($grupo_seleccionado && count($resultado) > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Edad</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($resultado as $row) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['apellido_paterno'] . "</td>
                        <td>" . $row['apellido_materno'] . "</td>
                        <td>" . $row['edad'] . "</td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
        } elseif ($grupo_seleccionado) {
            echo "<p>No se encontraron niños en este grupo.</p>";
        }
        ?>

        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../index2.html'">Volver</button>
    </div>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe!
            Estamos en todas las redes sociales

            para que puedas encontrar a Dios </h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>

            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 

</body>

</html>
