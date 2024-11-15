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
    $delete_sql = "DELETE FROM encargado_nino WHERE id_encargado = ?";
    $stmt = $conn->prepare($delete_sql);
    
    if ($stmt) {
        // Usamos "s" ya que id_encargado es varchar en la base de datos
        $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            // Redirige a la lista de encargados solo si se elimina correctamente
            header("Location: ../listados/lista_encargados.php");
            exit(); // Asegura que el script termine aquí y no siga ejecutándose
        } else {
            echo "Error al eliminar el registro: " . $stmt->error;
        }

        // Cierra el statement
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    // Cierra la conexión
    $conn->close();
} else {
    echo "ID no proporcionado.";
    exit();
}
?>
