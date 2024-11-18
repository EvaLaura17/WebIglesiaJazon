<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id_tutor'])) {
    $id_tutor = $_GET['id_tutor'];

    try {
        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM tutores WHERE id_tutor = :id_tutor";
        $stmt = $conn->prepare($delete_sql);

        // Enlazamos el parámetro
        $stmt->bindParam(':id_tutor', $id_tutor);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Redirige a la lista de tutores si la eliminación fue exitosa
            echo "<script>
                alert('Registro eliminado exitosamente.');
                window.location.href = '../ver_tutores.php';
            </script>";
            exit(); // Asegura que el script termine aquí
        } else {
            // Mostrar alerta de error y redirigir con JavaScript
            echo "<script>
                alert('Error al eliminar el registro.');
                window.location.href = '../ver_tutores.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_tutores.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Id no proporcionado');
        window.location.href = '../ver_tutores.php';
    </script>";
    exit();
}
