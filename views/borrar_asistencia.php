<?php
// Incluye la clase Database (asegúrate de que esté en el mismo directorio o ajusta la ruta)
require_once '../includes/bd.php';

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtén la instancia de conexión usando la clase Database
        $conn = Database::getInstance();

        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM asistencia WHERE id = :id";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Registro eliminado exitosamente.";
            header("Location: lista_asistencia.php"); // Redirige a la lista de asistencia
            exit();
        } else {
            echo "Error al eliminar el registro.";
        }

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "ID no proporcionado.";
    exit();
}
?>
