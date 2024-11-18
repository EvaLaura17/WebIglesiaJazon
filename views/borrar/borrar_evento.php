<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id_evento'])) {
    $id = $_GET['id_evento'];

    try {
        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM eventos WHERE id_evento = :id_evento";
        $stmt = $conn->prepare($delete_sql);

        // Enlazamos el parámetro
        $stmt->bindParam(':id_evento', $id, PDO::PARAM_INT);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Redirige a la lista de eventos si la eliminación fue exitosa
            echo "<script>
                alert('Registro Eliminado');
                window.location.href = '../ver_evento.php';
            </script>";
            exit(); // Asegura que el script termine aquí
        } else {
            echo "<script>
                alert('Error al eliminar el registro');
                window.location.href = '../ver_evento.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_evento.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Id no proporcionado');
        window.location.href = '../ver_evento.php';
    </script>";
    exit();
}
