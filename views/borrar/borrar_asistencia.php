<?php
// Incluye la clase Database (asegúrate de que esté en el mismo directorio o ajusta la ruta)
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtén la instancia de conexión usando la clase Database
        $conn = Database::getInstance();

        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM asistencias WHERE id = :id";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registro eliminado exitosamente.');
                window.location.href = '../ver_asistencias.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Registro eliminado exitosamente.');
                window.location.href = '../ver_asistencias.php';
            </script>";
            echo "Error al eliminar el registro.";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '../ver_asistencias.php';
            </script>";
    }
} else {
    echo "<script>
                alert('ID no proporcionado.');
                window.location.href = '../ver_asistencias.php';
            </script>";
    exit();
}
