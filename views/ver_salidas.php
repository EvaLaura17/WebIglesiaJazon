<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Conexión a la base de datos usando la clase Database
$conn = Database::getInstance();

try {
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
    
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Ver Salidas</title>
</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                </div>
                <span class="title">Iglesia Jazon</span>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index.php" class="nav-link px-2">Inicio</a></li>
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>

    <!-- Contenedor principal -->
    <div class="container3">
        <h1>Registro de Salidas</h1>
        <table class="table">
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
                if (count($result) > 0) {
                    // Salida de los datos de cada fila
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id_salida'] . "</td>";
                        echo "<td>" . $row['fecha'] . "</td>";
                        echo "<td>" . $row['hora'] . "</td>";
                        echo "<td>" . $row['nombre_nino'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . "</td>";
                        echo "<td>" . $row['nombre_encargado'] . " " . $row['apellido_encargado'] . "</td>";
                        echo "<td>
                                <a href='editar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn btn-warning'>Cambiar</a> 
                                <a href='eliminar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn btn-danger'>Eliminar</a>
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
