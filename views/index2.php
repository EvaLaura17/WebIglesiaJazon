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


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/conIndex2.css">
</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                    <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="../index.php" class="nav-link px-2">Inicio</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-gold">Login</a>
                </div>
                <div>
                    <p id="usuario"><?php echo $nombreCompleto; ?></p>
                    <a href="../includes/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
                </div>
            </div>
    </header>
    <!--CONTENIDO-->
    <?php if ($tipo_usuario == 'desconocido'): ?>
        <center>
            <br>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><i class="bi bi-person-lines-fill"></i> INICIE SESION</div>
                    <div class="card-body">
                        <p>INICIE SESION</p>
                        <a href="login.html" class="btn btn-primary">iniciar sesion</a>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
        </center>
    <?php endif; ?>
    <?php if ($tipo_usuario === 'supervisor' or $tipo_usuario === 'maestro'): ?>

        <!-- SECCIONES CRUD -->
        <main class="content-section">
            <div class="container">
                <h2 class="section-title">Panel de Gestión</h2>
                <div class="row g-4">
                    <!-- Notificaciones -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Enviar Notificacion</div>
                            <div class="card-body">
                                <p>Enviar notificacion al tutor de un niño.</p>
                                <a href="enviar_notificacion.php" class="btn btn-primary">Enviar Notificacion</a>
                            </div>
                        </div>
                    </div>
                    <!-- Agregar Niños -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-person-plus-fill"></i> Agregar Niños</div>
                            <div class="card-body">
                                <p>Agrega un nuevo niño al sistema.</p>
                                <a href="agregar_nino.php" class="btn btn-primary">Agregar Niños</a>
                            </div>
                        </div>
                    </div>
                    <!-- Ver Niños -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-person-lines-fill"></i> Ver Niños</div>
                            <div class="card-body">
                                <p>Consulta y administra la lista de niños.</p>
                                <a href="listadoNinos.php" class="btn btn-primary">Ver Niños</a>
                            </div>
                        </div>
                    </div>
                    <!-- Agregar Enfermedades -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Agregar Enfermedades</div>
                            <div class="card-body">
                                <p>Registra enfermedades de los niños.</p>
                                <a href="agregar_enfermedad.php" class="btn btn-primary">Agregar Enfermedad</a>
                            </div>
                        </div>
                    </div>
                    <!-- Ver Enfermedades -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Ver Enfermedades</div>
                            <div class="card-body">
                                <p>Consulta y administra la lista de niños con enfermedades.</p>
                                <a href="ver_enfermedad.php" class="btn btn-primary">Ver Niños</a>
                            </div>
                        </div>
                    </div>
                    <!-- Control Asistencia -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-calendar-check-fill"></i> Control Asistencia</div>
                            <div class="card-body">
                                <p>Registra la asistencia de los niños.</p>
                                <a href="listado_Asistencia.php" class="btn btn-primary">Registrar Asistencia</a>
                            </div>
                        </div>
                    </div>
                    <!-- Control Salida -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-door-closed-fill"></i> Control Salida</div>
                            <div class="card-body">
                                <p>Gestiona la salida de los niños.</p>
                                <a href="salida.php" class="btn btn-primary">Registrar Salida</a>
                            </div>
                        </div>
                    </div>
                    <!-- Mostrar Asistencia -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-clock-history"></i> Mostrar Asistencia</div>
                            <div class="card-body">
                                <p>Consulta el historial de asistencia.</p>
                                <a href="lista_Asistencia.php" class="btn btn-primary">Ver Asistencia</a>
                            </div>
                        </div>
                    </div>
                    <!-- Mostrar Salida -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Mostrar Salida</div>
                            <div class="card-body">
                                <p>Consulta el historial de salidas.</p>
                                <a href="ver_salidas.php" class="btn btn-primary">Ver Salidas</a>
                            </div>
                        </div>
                    </div>

                    <!-- crear reportes -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i>Crear reportes</div>
                            <div class="card-body">
                                <p>Generar reportes sobre actividades, eventos y los niños.</p>
                                <a href="reportes.php" class="btn btn-primary">Generar reporte</a>
                            </div>
                        </div>
                    </div>
                    <!-- Agregar Cursos -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Agregar Curso</div>
                            <div class="card-body">
                                <p>Agregar un nuevo Curso al sistema.</p>
                                <a href="agregar_curso.php" class="btn btn-primary">Registrar Cursos</a>
                            </div>
                        </div>
                    </div>
                    <?php if ($tipo_usuario === 'supervisor'): ?>


                        <!-- Ver Cursos -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Mostrar Cursos</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de cursos.</p>
                                    <a href="ver_cursos.php" class="btn btn-primary">Ver Cursos</a>
                                </div>
                            </div>
                        </div>
                        <!-- Agregar Encargado -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-person-plus-fill"></i> Agregar Encargado</div>
                                <div class="card-body">
                                    <p>Agrega un Encargado para recoger al niño al sistema.</p>
                                    <a href="agregar_encargado.php" class="btn btn-primary">Agregar Encargado</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ver Encargados -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Ver Encargados</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de Encargados de recoger al niño.</p>
                                    <a href="ver_encargado.php" class="btn btn-primary">Ver Encargados</a>
                                </div>
                            </div>
                        </div>
                        <!-- Registrar Maestro -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Agregar Maestro</div>
                                <div class="card-body">
                                    <p>Agregar un nuevo maestro al sistema.</p>
                                    <a href="agregar_maestro.php" class="btn btn-primary">Registrar Maestro</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ver Maestros -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Mostrar Maestros</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de maestros.</p>
                                    <a href="ver_maestros.php" class="btn btn-primary">Ver Maestros</a>
                                </div>
                            </div>
                        </div>
                        <!-- Registrar Supervisor -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Agregar Supervisor</div>
                                <div class="card-body">
                                    <p>Agregar un nuevo Supervisor al sistema.</p>
                                    <a href="agregar_supervisor.php" class="btn btn-primary">Registrar Supervisor</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ver Supervisores -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Mostrar Supervisores</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de Supervisores.</p>
                                    <a href="ver_supervisores.php" class="btn btn-primary">Ver Supervisores</a>
                                </div>
                            </div>
                        </div>
                        <!-- Registrar Evento -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Agregar Evento</div>
                                <div class="card-body">
                                    <p>Agregar un nuevo Evento al sistema.</p>
                                    <a href="agregar_evento.php" class="btn btn-primary">Registrar Evento</a>
                                </div>
                            </div>
                        </div>
                        <!-- Ver Eventos -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Mostrar Eventos</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de Eventos.</p>
                                    <a href="ver_evento.php" class="btn btn-primary">Ver Eventos</a>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </main>
    <?php endif; ?>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024 </p>
        <h4>¡Apasiónate por tu fe!
            Estamos en todas las redes sociales

            para que puedas encontrar a Dios </h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>

            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/conIndex.js"></script>

</body>

</html>