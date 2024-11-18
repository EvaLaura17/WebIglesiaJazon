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
    FROM salidas s
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
    <link rel="stylesheet" href="../css/tablas.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Ver Salidas</title>
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <br>
    <div class="container">
    <h1 class="section-title">Registro de Salidas</h1>
    </div>
    <!-- Contenedor principal -->
    <div class="container2">
        
        <div class="table-responsive">
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
                                <a href='editar/editar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn1 btn-edit'>Cambiar</a> 
                                <a href='borrar/borrar_salida.php?id_salida=" . $row['id_salida'] . "' class='btn1 btn-delete'>Eliminar</a>
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
    </div>
    
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>