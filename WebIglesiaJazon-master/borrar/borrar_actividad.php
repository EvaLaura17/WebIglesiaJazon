<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; // Cambia según tu configuración
$database = "proyectosistemas"; // Cambia por tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para eliminar el registro
    $delete_sql = "DELETE FROM actividades WHERE id_actividad = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Registro eliminado exitosamente.";
        header("Location: ../listados/lista_actividades.php"); // Redirige a la lista de asistencia
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
    
    $conn->close();
} else {
    echo "ID no proporcionado.";
    exit();
}
