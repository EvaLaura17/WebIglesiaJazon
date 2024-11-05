<?php
// listadoNiños.php

// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia si tu usuario es diferente
$password = ""; // Cambia si tienes una contraseña configurada para MySQL
$database = "proyectosistemas"; // Cambia por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los grupos (en este caso, se usan los valores de grupo_id distintos)
$grupos = $conn->query("SELECT DISTINCT grupo_id FROM ninos");

// Verifica si se ha seleccionado un grupo
$grupo_seleccionado = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

// Consulta para obtener los niños del grupo seleccionado
$consulta_niños = "SELECT id, nombre, apellido_paterno, apellido_materno, edad FROM ninos WHERE grupo_id = '$grupo_seleccionado'";

if ($grupo_seleccionado) {
    $resultado = $conn->query($consulta_niños);
} else {
    $resultado = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iglesia Jazon - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: black; /* Fondo oscuro */
            color: white; /* Color de texto */
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
            width: 60px;
            height: 60px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #efb810;
        }

        .nav-link {
            color: #efb810;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff;
        }


        /* Secciones */
        .content-section {
            padding: 3rem 1rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #efb810;
            border-bottom: 2px solid #efb810;
            padding-bottom: 5px;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid gold;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: black; /* Color del encabezado */
            color: gold;
        }
        tr {
            background-color: black; /* Color uniforme para todas las filas */
        }
        tr:hover {
            /*background-color: #e2e2e2; Color al pasar el mouse */
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

        .btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: black; /* Color de los botones */
            color: white;
            border: 1px solid white;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            border: 1px solid gold;
            color: gold;
            background-color: black;
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
                    <li><a href="index.html" class="nav-link px-2">Inicio</a></li>
                    <li><a href="index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-light">Login</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container content-section">
        <h1 class="section-title">Lista de Niños por Grupo</h1>

        <!-- Formulario para seleccionar un grupo -->
        <form method="POST" action="listadoNinos.php">
            <label for="grupo_id">Selecciona un Grupo:</label>
            <select name="grupo_id" id="grupo_id" required class="form-select" style="background-color: #121212; color: #efb810; border: 1px solid #efb810;">
                <option value="" style="color: #efb810;">Seleccionar...</option>
                <?php
                // Mostrar los grupos disponibles en la caja de selección
                if ($grupos->num_rows > 0) {
                    while($row = $grupos->fetch_assoc()) {
                        echo "<option value='" . $row['grupo_id'] . "'>" . $row['grupo_id'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay grupos disponibles</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn" style="background-color: #efb810; color: #000;">Mostrar Niños</button>
        </form>


        <!-- Tabla con los niños del grupo seleccionado -->
        <?php
        if ($grupo_seleccionado && $resultado->num_rows > 0) {
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
            while($row = $resultado->fetch_assoc()) {
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

        <button class="btn" onclick="window.location.href='index2.html'">Volver</button>
    </div>

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
// Cierra la conexión
$conn->close();
?>
