<?php
session_start();

if (isset($_SESSION['nombre']) && isset($_SESSION['ape_pat']) && isset($_SESSION['ape_mat']) && isset($_SESSION['tipo_usuario'])) {
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['ape_pat'] . ' ' . $_SESSION['ape_mat'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
} else {
    $nombre = 'Usuario no autenticado';
    $apellido = '';
    $tipo_usuario = 'desconocido';
}
$nombreCompleto = $nombre . ' ' . $apellido;

?>

<!-- CABECERA -->
<header class="p-3">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="title-container">
                <img src="../../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
            </div>
            <span class="title">Iglesia Jazon</span>
            <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../../index.php" class="nav-link px-1">Inicio</a></li>
            </ul>
            <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../index2.php" class="nav-link px-1">Dashboard</a></li>
            </ul>
            <div>
                <p id="usuario"><?php echo $nombreCompleto; ?></p>
                <a href="../../includes/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
            </div>
        </div>
</header>