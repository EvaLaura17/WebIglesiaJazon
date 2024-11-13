<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los eventos
$eventosQuery = "SELECT id_evento, evento, imagen, fecha, descripcion
                 FROM evento";
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
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Eventos</h1>

        <!-- Tabla de Eventos -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Listado de Eventos</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
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
                                        <a href='editar_evento.php?id_evento=" . $evento['id_evento'] . "' class='btn btn-warning'>Cambiar</a>
                                        <a href='eliminar_evento.php?id_evento=" . $evento['id_evento'] . "' class='btn btn-danger'>Eliminar</a>
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

        <!-- Botón de acción -->
        <div class="mt-4 text-center">
            <a href="index2.php" class="btn btn-primary">Volver</a>
        </div>
    </div>
</body>

</html>