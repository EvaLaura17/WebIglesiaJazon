<?php
require_once '../includes/bd.php'; // Incluye la clase de base de datos

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

// Consulta para obtener tutores y sus niños asociados
$consulta_tutor = "
    SELECT 
        t.id_tutor, 
        t.nombre AS nombre_tutor, 
        t.ap_pat AS apellido_paterno_tutor, 
        t.ap_mat AS apellido_materno_tutor, 
        t.num_telefono, 
        n.id AS id_nino, 
        n.nombre AS nombre_nino, 
        n.apellido_paterno AS apellido_paterno_nino, 
        n.apellido_materno AS apellido_materno_nino 
    FROM tutores t
    JOIN ninos n ON t.id_tutor = n.tutor_id";

try {
    $stmt = $pdo->prepare($consulta_tutor);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los tutores: " . $e->getMessage();
    $resultado = [];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tutores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>

    <div class="container">
    <h1 class="section-title">Tutores y Niños Asociados</h1>
    </div>
    <div class="container2 ">
        

        <?php if (count($resultado) > 0): ?>
            <div class="table-responsive">
                <table >
                    <thead >
                        <tr>
                            <th>Nombre del Tutor</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Nombre del Niño</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nombre_tutor']) ?></td>
                                <td><?= htmlspecialchars($row['apellido_paterno_tutor']) ?></td>
                                <td><?= htmlspecialchars($row['apellido_materno_tutor']) ?></td>
                                <td><?= htmlspecialchars($row['num_telefono']) ?></td>
                                <td><?= htmlspecialchars($row['nombre_nino'] . ' ' . $row['apellido_paterno_nino'] . ' ' . $row['apellido_materno_nino']) ?></td>
                                <td>
                                    <a href="editar/editar_tutor.php?id_tutor=<?= $row['id_tutor'] ?>" class="btn1 btn-edit btn-sm">Editar </a>
                                    <a href="borrar/borrar_tutor.php?id_tutor=<?= $row['id_tutor'] ?>" class="btn1 btn-delete btn-sm">Borrar </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No se encontraron tutores ni niños registrados.</p>
        <?php endif; ?>
    </div>

    <div class="text-center ">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
<br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>