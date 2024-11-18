<?php
// Incluir la clase Database para obtener la conexión
require_once '../includes/bd.php';

// Obtener la conexión a la base de datos
$conn = Database::getInstance();

// Consulta para obtener los supervisores
$supervisoresQuery = "SELECT id_supervisor, nombre, ape_pat, ape_mat, usuario, correo
                      FROM supervisores";
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
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
     <!-- CABECERA -->
     <?php include '../includes/header.php'; ?>
     
    <br>
    <div class=" container">
        <h1 class="section-title">Lista de Supervisores</h1>
    </div>
    <div class="container2"> 
        <!-- Tabla de Supervisores -->
        <div class="table-responsive">
            <table>
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
                                        <a href='editar/editar_supervisor.php?id_supervisor=" . $supervisor['id_supervisor'] . "' class='btn1 btn-edit'>Cambiar</a> 
                                        <a href='borrar/borrar_supervisor.php?id_supervisor=" . $supervisor['id_supervisor'] . "' class='btn1 btn-delete'>Eliminar</a>
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
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>