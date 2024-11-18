<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id_supervisor'])) {
    $id_supervisor = $_GET['id_supervisor'];

    try {
        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM supervisores WHERE id_supervisor = :id_supervisor";
        $stmt = $conn->prepare($delete_sql);

        // Enlazamos el parámetro
        $stmt->bindParam(':id_supervisor', $id_supervisor);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Mostrar alerta de éxito y redirigir con JavaScript
            echo "<script>
                alert('Registro eliminado exitosamente.');
                window.location.href = '../ver_supervisores.php';
            </script>";
        } else {
            // Mostrar alerta de error y redirigir con JavaScript
            echo "<script>
                alert('Error al eliminar el registro.');
                window.location.href = '../ver_supervisores.php';
            </script>";
        }
    } catch (PDOException $e) {
        // Mostrar alerta de error con el mensaje de la excepción
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_supervisores.php';
        </script>";
    }
} else {
    // Mostrar alerta si no se proporciona el ID
    echo "<script>
        alert('ID no proporcionado.');
        window.location.href = '../ver_supervisores.php';
    </script>";
    exit();
}
?>
