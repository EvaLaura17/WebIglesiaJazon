<?php
include_once "../bd.php";  // Asegúrate de que la clase Database esté incluida correctamente

// Conexión a la base de datos usando la clase Database
$conn = Database::getInstance();  // Obtiene la instancia de PDO

// Obtener grupo_id
$grupo_id = $_POST['grupo_id'];

// Iterar sobre los niños y registrar su asistencia
foreach ($_POST as $key => $value) {
    if (strpos($key, 'estado_') === 0) {
        $nino_id = str_replace('estado_', '', $key);
        $estado = $value;
        $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual

        // Preparar la consulta para insertar o actualizar la asistencia
        $sql = "INSERT INTO asistencia (nino_id, estado, grupo_id, fecha) VALUES (:nino_id, :estado, :grupo_id, :fecha)";
        
        // Usar la conexión PDO para ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nino_id', $nino_id);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':grupo_id', $grupo_id);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
    }
}

// Redirigir al usuario a la lista de asistencia
header("Location: ../listados/lista_asistencia.php");
exit();
?>
