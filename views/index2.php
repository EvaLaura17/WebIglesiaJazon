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
    <?php include '../includes/header.php'; ?>

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
                                <p>Enviar notificacion al tutor del niño.</p>
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
                                <p> Administra la lista de niños.</p>
                                <a href="ver_ninos.php" class="btn btn-primary">Ver Niños</a>
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
                                <p>Lista de niños con enfermedades.</p>
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
                                <a href="agregar_asistencia.php" class="btn btn-primary">Registrar Asistencia</a>
                            </div>
                        </div>
                    </div>
                    <!-- Control Salida -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-door-closed-fill"></i> Control Salida</div>
                            <div class="card-body">
                                <p>Gestiona la salida de los niños.</p>
                                <a href="agregar_salida.php" class="btn btn-primary">Registrar Salida</a>
                            </div>
                        </div>
                    </div>
                    <!-- Mostrar Asistencia -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-clock-history"></i> Mostrar Asistencia</div>
                            <div class="card-body">
                                <p>Consulta el historial de asistencia.</p>
                                <a href="ver_asistencias.php" class="btn btn-primary">Ver Asistencia</a>
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
                                <p>Reportes sobre actividades, eventos y los niños.</p>
                                <a href="reportes.php" class="btn btn-primary">Generar reporte</a>
                            </div>
                        </div>
                    </div>
                    <!-- Agregar actividad -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header"><i class="bi bi-journal-text"></i> Agregar actividad</div>
                            <div class="card-body">
                                <p>Agregar una nueva actividad con los niños.</p>
                                <a href="agregar_actividad.php" class="btn btn-primary">Agregar actividad</a>
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
                    <?php if ($tipo_usuario === 'supervisor'): ?>
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
                        <!-- Ver Encargados -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header"><i class="bi bi-journal-text"></i> Ver Tutores</div>
                                <div class="card-body">
                                    <p>Consulta y administra la lista de los Tutores.</p>
                                    <a href="ver_tutores.php" class="btn btn-primary">Ver Tutores</a>
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


                    <?php endif; ?>
                </div>
            </div>
        </main>
    <?php endif; ?>

    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/conIndex.js"></script>

</body>

</html>