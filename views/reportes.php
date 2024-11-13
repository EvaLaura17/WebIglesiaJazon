<?php
// Incluye la clase Database
require_once '../includes/bd.php';

$conn = Database::getInstance(); // Obtener la instancia de conexión

// Consultas SQL
$actividadesQuery = "SELECT * FROM actividad"; // Consulta para obtener todas las actividades
$eventosQuery = "SELECT * FROM evento"; // Consulta para obtener todos los eventos
$cursosQuery = "SELECT * FROM curso"; // Consulta para obtener todos los cursos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!--CSS LINK -->
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Generación de Reportes</title>
</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                    <img src="../img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                </div>
                <span class="title">Iglesia Jazon</span>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index2.php" class="nav-link px-2">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </header>
    <br>
    <div class="container">
        <h1 class="mb-4">Generación de Reportes</h1>

        <!-- Formulario para generar el reporte -->

        <!-- Reporte de Actividad -->
        <form action="reportes/r_actividad.php" method="POST">
            <div class="mb-4">
                <div class="mb-3 d-flex justify-content-between">
                    <label for="actividad" class="form-label">Reporte de Actividad</label>
                    <div class="d-flex">
                        <select name="actividad" id="actividad" class="form-select w-75"
                            onchange="setActividadId(this)">
                            <option value="">Seleccione...</option>
                            <?php
                            // Ejecutar consulta para obtener actividades
                            $actividadesResult = $conn->query($actividadesQuery);
                            while ($actividad = $actividadesResult->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$actividad['id_actividad']}'>{$actividad['actividad']}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" name="actividad_id" id="actividad_id">
                        <button type="submit" name="registro_actividad" value="true"
                            class="btn btn-primary ms-2">Generar Reporte</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Reporte de Evento -->
        <form action="reportes/r_evento.php" method="POST">
            <div class="mb-3 d-flex justify-content-between">
                <label for="evento" class="form-label">Reporte de Evento</label>
                <div class="d-flex">
                    <select name="evento" id="evento" class="form-select w-75">
                        <option value="">Seleccione...</option>
                        <?php
                        // Ejecutar consulta para obtener eventos
                        $eventosResult = $conn->query($eventosQuery);
                        while ($evento = $eventosResult->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$evento['id_evento']}'>{$evento['evento']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="evento_id" id="evento_id">
                    <button type="submit" name="registro_evento" value="true" class="btn btn-primary ms-2">Generar
                        Reporte</button>
                </div>
            </div>
        </form>

        </form>

        <!-- Reporte de Curso -->
        <form action="reportes/r_curso.php" method="POST">
            <div class="mb-3 d-flex justify-content-between">
                <label for="curso" class="form-label">Reporte de Curso</label>
                <div class="d-flex">
                    <select name="curso" id="curso" class="form-select w-75">
                        <option value="">Seleccione...</option>
                        <option value="todos">Todos los Cursos</option>
                        <?php
                        // Ejecutar consulta para obtener cursos
                        $cursosResult = $conn->query($cursosQuery);
                        while ($curso = $cursosResult->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$curso['id_curso']}'>{$curso['id_curso']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="curso_id" id="curso_id">
                    <button type="submit" name="registro_curso" value="true" class="btn btn-primary ms-2">Generar
                        Reporte </button>
                </div>
            </div>
        </form>

    </div>

    <br>

    <!-- Pie de página -->
    <footer class="text-center p-4">
        <p>Jazon &copy; 2024</p>
        <h4>¡Apasiónate por tu fe! Estamos en todas las redes sociales para que puedas encontrar a Dios</h4>
        <p><a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-whatsapp"></i></a> (+591) 77252989</p>
        <p>
            <a href="https://www.facebook.com/jazon.info" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/jazon.info/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://x.com/jazon_info" target="_blank"><i class="bi bi-twitter"></i></a>
            <a href="https://www.tiktok.com/@jazonchurch" target="_blank"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/jazon" target="_blank"><i class="bi bi-youtube"></i></a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setActividadId(selectElement) {
            // Establecer el valor de actividad_id según la opción seleccionada
            var actividadId = selectElement.value;
            document.getElementById('actividad_id').value = actividadId;
        }
    </script>

</body>

</html>