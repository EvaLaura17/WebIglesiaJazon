<?php
// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia si tu usuario es diferente
$password = ""; // Cambia si tienes una contraseña configurada para MySQL
$database = "proyectosistemas";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si los campos 'username' y 'password' están presentes en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Limpia las variables para prevenir inyecciones SQL
    $usuario = $conn->real_escape_string($usuario);
    $contrasena = $conn->real_escape_string($contrasena);

    // Verifica si el usuario y la contraseña existen en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si la consulta devuelve algún resultado, el usuario es válido
        session_start();
        $_SESSION['usuario'] = $usuario;

        $insertSQL = "INSERT INTO registro_login (usuario) VALUES ('$usuario')";
        if (!$conn->query($insertSQL)) {
            echo "Error al registrar el inicio de sesión: " . $conn->error;
        }

        // Redirige a index.html
        header("Location: index.html");
        exit();
    } else {
        // Si no se encuentran coincidencias, muestra un error
        echo "<script>alert('Usuario o contrasena incorrectos'); window.location.href='login.html';</script>";
    }
} else {
    // Si no es un método POST, redirige al formulario de login
    header("Location: login.html");
    exit();
}

$conn->close();
?>
