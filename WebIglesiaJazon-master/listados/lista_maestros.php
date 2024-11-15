<?php
require_once '../bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Consulta para obtener todos los maestros junto con su curso
$consulta_maestros = "
    SELECT m.id_maestro, m.nombre, m.ape_pat, m.ape_mat, m.num_telefono, m.usuario, c.grupo 
    FROM maestros m
    JOIN cursos c ON m.id_curso = c.id_curso"; // Asumimos que la tabla 'cursos' tiene un campo 'nombre_curso'
$resultado = [];

$stmt = $pdo->prepare($consulta_maestros);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Maestros</title>
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

    <!-- CONTENIDO -->
    <div class="container content-section">
        <h1 class="section-title">Lista de Maestros</h1>

        <!-- Tabla con todos los maestros -->
        <?php
        if (count($resultado) > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID Maestro</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Usuario</th>
                            <th>Curso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($resultado as $row) {
                echo "<tr>
                        <td>" . $row['id_maestro'] . "</td>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['ape_pat'] . "</td>
                        <td>" . $row['ape_mat'] . "</td>
                        <td>" . $row['num_telefono'] . "</td>
                        <td>" . $row['usuario'] . "</td>
                        <td>" . $row['grupo'] . "</td>
                        <td>
                            <a href='../editar/editar_maestro.php?id=" . $row['id_maestro'] . "' class='btn btn-success'>Editar</a>
                            <a href='../borrar/borrar_maestro.php?id=" . $row['id_maestro'] . "' class='btn btn-danger'>Borrar</a>
                        </td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
        } else {
            echo "<p>No se encontraron maestros.</p>";
        }
        ?>
        <button class="btn btn-outline-dark mt-3 w-100" onclick="window.location.href='../index2.html'">Volver</button>
    </div>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios </h4>
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
