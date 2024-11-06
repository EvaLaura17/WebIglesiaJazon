<?php
include_once "../bd.php"; // Asegúrate de que el archivo esté correcto

// Obtener la conexión de la clase Database
$conn = Database::getInstance();

// Consulta para obtener los registros de salida con nombres completos
$sql = "
SELECT 
    s.id_salida, 
    s.fecha, 
    s.hora, 
    n.nombre AS nombre_nino, 
    n.apellido_paterno AS apellido_paterno, 
    n.apellido_materno AS apellido_materno, 
    e.nombre AS nombre_encargado, 
    e.apellido AS apellido_encargado 
FROM salida s
JOIN ninos n ON s.id_nino = n.id
JOIN encargado_nino e ON s.id_encargado = e.id_encargado";
$stmt = $conn->prepare($sql); // Usamos prepared statement para mayor seguridad
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Ver Salidas</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: #121212;
            color: white;
        }

        /* Estilos para el contenedor principal */
        .container {
            background-color: black;
            color: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 80%;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Estilo del encabezado */
        h1 {
            color: #efb810;
            border-bottom: 2px solid #efb810;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: black;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #efb810;
            color: white;
        }

        th {
            background-color: #efb810;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #1e1e1e;
        }

        /* Estilos de los botones */
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        /* Estilos de la cabecera */
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
            width: 300px;
            height: 80px;
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

        /* Estilos del pie de página */
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
                    <img src="../img/logo/logoFinal.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index2.html" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>

    <!-- Contenedor principal -->
    <div class="container">
        <h1>Registro de Salidas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID Salida</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Nombre Niño</th>
                    <th>Nombre Encargado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica si hay registros
                if ($result) {
                    // Salida de los datos de cada fila
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id_salida'] . "</td>";
                        echo "<td>" . $row['fecha'] . "</td>";
                        echo "<td>" . $row['hora'] . "</td>";
                        echo "<td>" . $row['nombre_nino'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . "</td>";
                        echo "<td>" . $row['nombre_encargado'] . " " . $row['apellido_encargado'] . "</td>";
                        echo "<td>
                                <a href='editar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn btn-edit'>Cambiar</a> 
                                <a href='eliminar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn btn-delete'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay registros disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
// No es necesario cerrar la conexión explícitamente cuando usas PDO
?>
