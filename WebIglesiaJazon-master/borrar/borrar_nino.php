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
    
    // Consulta para actualizar el estado del registro a 0
    $update_sql = "UPDATE ninos SET estado = 0 WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Estado del registro actualizado a inactivo.";
        header("Location: ../listados/listadoNinos.php"); 
        exit();
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "ID no proporcionado.";
    exit();
}
?>
