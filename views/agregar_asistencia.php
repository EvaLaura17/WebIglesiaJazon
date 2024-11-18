<?php
require_once '../includes/bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Si se selecciona un grupo
$grupo_id = isset($_POST['grupo_id']) ? $_POST['grupo_id'] : null;

// Consulta para obtener los niños del grupo seleccionado
$consulta_niños = $grupo_id ? "SELECT id, nombre, apellido_paterno, apellido_materno FROM ninos WHERE grupo_id = :grupo_id" : "SELECT id, nombre, apellido_paterno, apellido_materno FROM ninos";

// Preparar y ejecutar la consulta
if ($grupo_id) {
    $stmt = $pdo->prepare($consulta_niños);
    $stmt->bindParam(':grupo_id', $grupo_id, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->query($consulta_niños);
}

$resultado_niños = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/agreAsistencia.css">
    <link rel="stylesheet" href="../css/tablas.css">
   
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <!-- CONTENIDO -->
    <div class="container content-section">
        <h1 class="section-title">Lista de Asistencia</h1>
        
             <!-- Selección de Grupo -->
        <form method="POST" action="">
        <div class="flex-container">
            <label for="grupo_id">Selecciona un Grupo:</label>
            <select name="grupo_id" id="grupo_id" required class="form-select"
                style="background-color: #fffcd1f6; color: #efb810; border: 1px solid #efb810;">
                <option value="" style="color: #efb810;">Seleccionar...</option>
                <?php
                // Obtener los grupos
                $grupos = $pdo->query("SELECT DISTINCT grupo_id FROM ninos");
                foreach ($grupos as $grupo) {
                    echo "<option value='" . $grupo['grupo_id'] . "'>" . htmlspecialchars($grupo['grupo_id']) . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn2">Mostrar Niños</button>
            </div>
        </form>
    
       
    </div>
    <div class="container2">          
        <!-- Mostrar lista de niños del grupo seleccionado -->
        <?php if ($grupo_id && count($resultado_niños) > 0): ?>
            <form id="asistenciaForm" method="POST" action="guardar_asistencia.php">
                <input type="hidden" name="grupo_id" value="<?= htmlspecialchars($grupo_id) ?>">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_niños as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nombre']) ?></td>
                                <td><?= htmlspecialchars($row['apellido_paterno']) ?></td>
                                <td><?= htmlspecialchars($row['apellido_materno']) ?></td>
                                <td>
                                    <button type="button" class="btn1 btn-edit" id="presente-<?= $row['id'] ?>"
                                        onclick="marcarAsistencia(<?= $row['id'] ?>, 'Presente')">Presente</button>
                                    <button type="button" class="btn1 btn-delete" id="ausente-<?= $row['id'] ?>"
                                        onclick="marcarAsistencia(<?= $row['id'] ?>, 'Ausente')">Ausente</button>
                                    <input type="hidden" name="estado_<?= $row['id'] ?>" id="asistencia-<?= $row['id'] ?>"
                                        value="No marcada">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table><br>
                <button type="submit" class="btn2">Guardar Asistencia</button>
            </form>
          
        <?php endif; ?>
    </div>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <script>
        // Marca la asistencia (presente o ausente) y desactiva los botones
        function marcarAsistencia(id, estado) {
            // Cambia el valor del campo oculto
            document.getElementById('asistencia-' + id).value = estado;

            // Desactiva ambos botones
            document.getElementById('presente-' + id).disabled = true;
            document.getElementById('ausente-' + id).disabled = true;

            // Cambia el estilo del botón seleccionado para marcar el estado visualmente
            if (estado === "Presente") {
                document.getElementById('presente-' + id).classList.add('selected');
            } else if (estado === "Ausente") {
                document.getElementById('ausente-' + id).classList.add('selected');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>