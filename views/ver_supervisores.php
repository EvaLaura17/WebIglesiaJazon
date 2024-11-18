<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los supervisores
$supervisoresQuery = "SELECT id_supervisor, nombre, ape_pat, ape_mat, usuario, correo
                      FROM supervisor";
$stmt = $conn->prepare($supervisoresQuery);
$stmt->execute();
$supervisores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Supervisores</title>
    <!-- ESTILOS CSS BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS LINK -->
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Supervisores</h1>

        <!-- Tabla de Supervisores -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Listado de Supervisores</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Verifica si hay supervisores
                        if (count($supervisores) > 0) {
                            // Muestra los datos de cada supervisor
                            foreach ($supervisores as $supervisor) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($supervisor['nombre']) . "</td>";
                                echo "<td>" . htmlspecialchars($supervisor['ape_pat']) . "</td>";
                                echo "<td>" . htmlspecialchars($supervisor['ape_mat']) . "</td>";
                                echo "<td>" . htmlspecialchars($supervisor['usuario']) . "</td>";
                                echo "<td>" . htmlspecialchars($supervisor['correo']) . "</td>";
                                echo "<td>
                                        <a href='editar_supervisor.php?id_supervisor=" . $supervisor['id_supervisor'] . "' class='btn btn-warning'>Cambiar</a>
                                        <a href='eliminar_supervisor.php?id_supervisor=" . $supervisor['id_supervisor'] . "' class='btn btn-danger'>Eliminar</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No hay supervisores registrados.</td></tr>";
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