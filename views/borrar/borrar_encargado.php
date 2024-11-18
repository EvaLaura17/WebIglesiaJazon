<?php
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Obtén la conexión a la base de datos
$conn = Database::getInstance();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM encargado_nino WHERE id_encargado = :id_encargado";
        $stmt = $conn->prepare($delete_sql);

        // Enlazamos el parámetro
        $stmt->bindParam(':id_encargado', $id, PDO::PARAM_STR);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Redirige a la lista de encargados si la eliminación fue exitosa
            echo "<script>
                alert('Registro Eliminado');
                window.location.href = '../ver_encargados.php';
            </script>";
            exit(); // Asegura que el script termine aquí
        } else {
            echo "<script>
                alert('Error al eliminar registro');
                window.location.href = '../ver_encargados.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_encargados.php';
        </script>";
    }
} else {
    echo "<script>
    alert('Id no proporcionado');
    window.location.href = '../ver_encargados.php';
    </script>";
    exit();
}
