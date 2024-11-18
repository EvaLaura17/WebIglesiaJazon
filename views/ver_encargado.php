<?php 
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los encargados con el nombre de la relación en vez de la id
$encargados = "SELECT 
                    en.id_encargado, 
                    en.nombre, 
                    en.apellido, 
                    r.relacion, 
                    en.num_telefono
               FROM encargado_nino en
               JOIN relacion r ON en.relacion = r.id_relacion";

$stmt = $conn->prepare($encargados);
$stmt->execute();
$encargados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Maestros</title>
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h1 class="section-title">Encargado que recogen a los niños</h1>
    </div>
    <div class="container2">
        <!-- Tabla de Maestros -->
        <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>Nombre del Encargado del niño</th>
                        <th>Apellido Completo</th>
                        <th>Numero de telefono</th>
                        <th>Relacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verifica si hay encargados
                    if (count($encargados) > 0) {
                        // Muestra los datos de cada encargado
                        foreach ($encargados as $encargado) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($encargado['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($encargado['apellido']) . "</td>";
                            echo "<td>" . htmlspecialchars($encargado['num_telefono']) . "</td>";
                            echo "<td>" . htmlspecialchars($encargado['relacion']) . "</td>";
                            echo "<td>
                                    <a href='editar/editar_encargado_nino.php?id_encargado=" . $encargado['id_encargado'] . "' class='btn1 btn-edit'>Cambiar</a> 
                                    <a href='borrar/borrar_encargado_nino.php?id_encargado=" . $encargado['id_encargado'] . "' class='btn1 btn-delete'>Eliminar</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay encargados disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <<div class="text-center ">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>
</body>

</html>
