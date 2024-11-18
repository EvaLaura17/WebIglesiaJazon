<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los eventos
$eventosQuery = "SELECT id_evento, evento, imagen, fecha, descripcion
                 FROM eventos";
$stmt = $conn->prepare($eventosQuery);
$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Eventos</title>
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/tablas.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

<div class="container">
    <h1 class="section-title">Lista de Eventos</h1>
</div>
    <div class="container2">
        <!-- Tabla de Eventos -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verifica si hay eventos
                    if (count($eventos) > 0) {
                        // Muestra los datos de cada evento
                        foreach ($eventos as $evento) {
                            // Verifica si la imagen existe para mostrarla de manera adecuada
                            $imagen = $evento['imagen'] ? '<img src="data:image/jpeg;base64,' . base64_encode($evento['imagen']) . '" alt="Imagen del Evento" width="100" height="100">' : 'No disponible';
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($evento['evento']) . "</td>";
                            echo "<td>" . $imagen . "</td>";
                            echo "<td>" . htmlspecialchars($evento['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['descripcion']) . "</td>";
                            echo "<td>
                                        <a href='editar/editar_evento.php?id_evento=" . $evento['id_evento'] . "' class='btn1 btn-edit'>Cambiar</a>
                                        <a href='eliminar/eliminar_evento.php?id_evento=" . $evento['id_evento'] . "' class='btn1 btn-delete'>Eliminar</a>
                                      </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay eventos registrados.</td></tr>";
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
</body>

</html>