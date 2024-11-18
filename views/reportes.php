<?php
// Incluye la clase Database
require_once '../includes/bd.php';

$conn = Database::getInstance(); // Obtener la instancia de conexión

// Consultas SQL
$actividadesQuery = "SELECT * FROM actividades"; // Consulta para obtener todas las actividades
$eventosQuery = "SELECT * FROM eventos"; // Consulta para obtener todos los eventos
$cursosQuery = "SELECT * FROM cursos"; // Consulta para obtener todos los cursos
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
    <link rel="stylesheet" href="../css/index.css">

    <link rel="stylesheet" href="../css/reportes.css">
    <title>Generación de Reportes</title>
</head>

<body>
    <!-- CABECERA -->
    <?php include '../includes/header.php'; ?>
    
    <br>

    <!-- CONTENIDO -->
    <div class="container">
        <h1 >Generación de Reportes</h1>
        <!-- Reporte de Actividad -->
        <form action="reportes/r_actividad.php" method="POST">
            
                <div class=" form-group mb-3 ">
                    <label class="form-label " for="actividad">Reporte de Actividad</label>
              
                        <select name="actividad" id="actividad" 
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
                           class="btn btn-primary ms-2" >Generar Reporte</button>
                    
                </div>
            
        </form>

        <!-- Reporte de Evento -->
        <form action="reportes/r_evento.php" method="POST">
            <div class=" form-group mb-3 ">
                <label  class="form-label "  for="evento" >Reporte de Evento</label>
    
                    <select name="evento" id="evento" ¿>
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
                    <button type="submit" name="registro_evento" value="true" class="btn btn-primary ms-2">Generar Reporte</button>
                
            </div>
        </form>

        </form>

        <!-- Reporte de Curso -->
        <form action="reportes/r_curso.php" method="POST">
            <div class=" form-group mb-3 ">
                <label  class="form-label "  for="curso" class="form-label">Reporte de Curso</label>
                
                    <select name="curso" id="curso" >
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
        </form>

    </div>

    <br>
    <div class="text-center mt-4">
        <button class="btn btn-outline-dark" onclick="window.location.href='index2.php'">Volver</button>
    </div>
    <br>
    <!-- Pie de página -->
    <?php include '../includes/footer.php'; ?>

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