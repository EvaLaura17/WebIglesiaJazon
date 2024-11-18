<?php
// Incluye la clase Database (asegúrate de que esté en el mismo directorio o ajusta la ruta)
require_once '../../includes/bd.php'; // Asegúrate de que la ruta sea correcta

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id_curso'])) {
    $id = $_GET['id_curso'];

    try {
        // Obtén la instancia de conexión usando la clase Database
        $conn = Database::getInstance();

        // Consulta para eliminar el registro
        $delete_sql = "DELETE FROM cursos WHERE id_curso = :id_curso";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bindParam(':id_curso', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registro Eliminado');
                window.location.href = '../ver_cursos.php';
            </script>";
            exit();
        } else {
            echo "Error al eliminar el registro.";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_cursos.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Id no proporcionado');
        window.location.href = '../ver_cursos.php';
    </script>";
    exit();
}
