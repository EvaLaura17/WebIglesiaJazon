<?php
require_once '../includes/bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Consulta para obtener los grupos (en este caso, se usan los valores de grupo_id distintos)
$grupos = $pdo->query("SELECT DISTINCT grupo_id FROM ninos");

// Verifica si se ha seleccionado un grupo
$grupo_seleccionado = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

// Consulta para obtener los niños del grupo seleccionado
$consulta_niños = "SELECT id, nombre, apellido_paterno, apellido_materno, edad FROM ninos WHERE grupo_id = :grupo_id";
$resultado = [];

if ($grupo_seleccionado) {
    $stmt = $pdo->prepare($consulta_niños);
    $stmt->bindParam(':grupo_id', $grupo_seleccionado, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listado de Niños</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conListadoNinos.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!--CONTENIDO-->
    
<div class="container content-section">
        <br>
    <h1 class="section-title">Lista de Niños por Grupo</h1>

    <!-- Formulario para seleccionar un grupo -->
    <form method="POST" action="ver_ninos.php">
        <div class="flex-container">
            <label for="grupo_id">Selecciona un Grupo:</label>
            <select name="grupo_id" id="grupo_id" required class="form-select">
                <option value="" style="color: #efb810;">Seleccionar...</option>
                <?php
                // Mostrar los grupos disponibles en la caja de selección
                foreach ($grupos as $row) {
                    echo "<option value='" . $row['grupo_id'] . "'>" . $row['grupo_id'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn2">Mostrar Niños</button>
        </div>
    </form>
</div>

<div class="container2">
    <!-- Tabla con los niños del grupo seleccionado -->
    <?php
        if ($grupo_seleccionado && count($resultado) > 0) {
            echo "<table >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($resultado as $row) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['apellido_paterno'] . "</td>
                        <td>" . $row['apellido_materno'] . "</td>
                        <td>" . $row['edad'] . "</td>
                        <td>
                            <a href='editar/editar_nino.php?id=" . $row['id'] . "' class='btn1 btn-edit'>Editar</a>
                            <a href='borrar/borrar_nino.php?id=" . $row['id'] . "' class='btn1 btn-delete'>Borrar</a>
                        </td>
                      </tr>";
            }
            echo "</tbody>
                  </table>";
        } elseif ($grupo_seleccionado) {
            echo "<p>No se encontraron niños en este grupo.</p>";
        }
        ?>

</div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>