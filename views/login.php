<?php
header('Content-Type: application/json');

// Incluye la clase Database
require_once '../includes/bd.php';

try {
    // Obtén la instancia de conexión usando la clase Database
    $conn = Database::getInstance();

    // Verifica si los campos 'username' y 'password' están presentes en el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $conn->quote($_POST['username']);
        $contrasena = $conn->quote($_POST['password']);

        // Verificar si el usuario existe en la tabla 'supervisor'
        $sqlSupervisor = "SELECT * FROM supervisor WHERE usuario = $usuario AND contraseña = $contrasena";
        $stmtSupervisor = $conn->query($sqlSupervisor);

        // Verificar si el usuario existe en la tabla 'maestro'
        $sqlMaestro = "SELECT * FROM maestro WHERE usuario = $usuario AND contraseña = $contrasena";
        $stmtMaestro = $conn->query($sqlMaestro);

        if ($stmtSupervisor->rowCount() > 0) {
            // Usuario es un supervisor
            $user = $stmtSupervisor->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['usuario'] = $_POST['username'];
            $_SESSION['tipo_usuario'] = 'supervisor';
            $_SESSION['nombre'] = $user['nombre'];  // Guardar nombre
            $_SESSION['ape_pat'] = $user['ape_pat'];  // Guardar apellido
            $_SESSION['ape_mat'] = $user['ape_mat'];  // Guardar apellido

            // Registrar inicio de sesión
            $insertSQL = "INSERT INTO registro_login (usuario) VALUES ($usuario)";
            if (!$conn->exec($insertSQL)) {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar el inicio de sesión']);
                exit();
            }

            // Redirigir a la página de inicio con los datos necesarios
            echo json_encode([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso como supervisor',
                'redirect_url' => '../views/index2.php?nombre=' . urlencode($user['nombre']) . '&apellido=' . urlencode($user['ape_pat']). " " .urlencode($user['ape_mat']) . '&tipo_usuario=supervisor'
            ]);
        } elseif ($stmtMaestro->rowCount() > 0) {
            // Usuario es un maestro
            $user = $stmtMaestro->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['usuario'] = $_POST['username'];
            $_SESSION['tipo_usuario'] = 'maestro';
            $_SESSION['nombre'] = $user['nombre'];  // Guardar nombre
            $_SESSION['apellido'] = $user['apellido'];  // Guardar apellido

            // Registrar inicio de sesión
            $insertSQL = "INSERT INTO registro_login (usuario) VALUES ($usuario)";
            if (!$conn->exec($insertSQL)) {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar el inicio de sesión']);
                exit();
            }

            // Redirigir a la página de inicio con los datos necesarios
            echo json_encode([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso como maestro',
                'redirect_url' => '../views/index2.php?nombre=' . urlencode($user['nombre']) . '&apellido=' . urlencode($user['apellido']) . '&tipo_usuario=maestro'
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario o contraseña incorrectos']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Solicitud inválida']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
