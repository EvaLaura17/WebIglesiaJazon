<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

// Eliminar los registros con el estado 'No marcada'
$delete_sql = "DELETE FROM `asistencias` WHERE `estado` = 'No marcada'";

try {
    // Prepara y ejecuta la consulta para eliminar registros
    $stmt = $conn->prepare($delete_sql);
    $stmt->execute();

    echo "Registros 'No marcada' eliminados exitosamente.<br>";

    // Reasignar los IDs de forma secuencial
    $update_sql = "SET @id := 0; UPDATE `asistencias` SET `id` = (@id := @id + 1)";

    // Prepara y ejecuta la consulta para actualizar los IDs
    $stmt = $conn->prepare($update_sql);
    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Redirige a la lista de encargados si la eliminación fue exitosa
        echo "<script>
                alert('Registro eliminado exitosamente.');
                window.location.href = '../ver_activdades.php';
            </script>";
        exit(); // Asegura que el script termine aquí
    } else {
        echo "<script>
                alert('Error al eliminar el registro.');
                window.location.href = '../ver_activdades.php';
            </script>";
    }

} catch (PDOException $e) {
    echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '../ver_activdades.php';
            </script>";
}
