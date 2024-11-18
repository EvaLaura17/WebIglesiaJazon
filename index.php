<?php
require_once 'includes/bd.php'; // Incluye la clase de base de datos

// Capturar el filtro
$eventFilter = isset($_GET['eventFilter']) ? $_GET['eventFilter'] : 'all';

// Construir la consulta SQL
$query = "SELECT * FROM evento";
$currentDate = date('Y-m-d H:i:s');

if ($eventFilter == 'past') {
    $query .= " WHERE fecha < :currentDate";
} elseif ($eventFilter == 'current') {
    $query .= " WHERE fecha = :currentDate";
} elseif ($eventFilter == 'future') {
    $query .= " WHERE fecha > :currentDate";
}

// Obtener la conexión a la base de datos
$pdo = Database::getInstance();

$stmt = $pdo->prepare($query);

// Vincular parámetro solo si no es 'all'
if ($eventFilter !== 'all') {
    $stmt->bindParam(':currentDate', $currentDate);
}

$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/conIndex.css"> 

</head>

<body style="background: url('img/fondo3.png') ; background-size:contain;">
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                <img src="img/logo/logoFinal2.png" class="logo" alt="Logo de la Iglesia">
                <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2">Inicio</a></li>
                </ul>
                <div class="text-end">
                    <a href="views/login.html" class="btn btn-outline-gold">Login</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Bienvenida -->
    <div class="Bienven">
        <p>Bienvenido a Jazon</p>
        <p>¡Una iglesia de cristianos con propósito!</p>
    </div>
    <!-- Filtro de eventos -->
    <div class="filter-container">
        <label for="eventFilter" class="form-label">Ver eventos:</label>
        <select id="eventFilter" class="form-select w-auto d-inline">
            <option value="all">Todos</option>
            <option value="past">Eventos Pasados</option>
            <option value="current">Eventos Actuales</option>
            <option value="future">Eventos Futuros</option>
        </select>
    </div>

    <!-- Carrusel de eventos -->
    <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true">
        <div class="carousel-inner">
            <?php
            $active = true; // Para establecer el primer elemento como activo
            foreach ($eventos as $evento) {
                $imagenUrl = 'data:image/jpeg;base64,' . base64_encode($evento['imagen']); // Ajusta según el tipo de imagen
                $descripcion = htmlspecialchars($evento['descripcion'], ENT_QUOTES, 'UTF-8');
                $ev = htmlspecialchars($evento['evento'], ENT_QUOTES, 'UTF-8');

                echo '<div class="carousel-item ' . ($active ? 'active' : '') . '" data-category="all">';
                echo "<center><p>$ev</p></center>";
                echo "<img src=\"$imagenUrl\" alt=\"$descripcion\" class=\"d-block w-100\">";
                echo '<div class="carousel-caption d-none d-md-block">';
                echo '</div>';
                echo "<center><p>$descripcion</p></center>";

                echo '</div>';
                $active = false; // Solo el primero debe ser activo
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Cuadrados de información -->
<!-- Cuadrados de información -->
<div class="container my-5">
    <div class="row g-4">
        
        <!-- Tarjeta 1 -->
        <div class="col-12">
            <div class="card d-flex flex-row align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Quiénes Somos?</h3>
                    <p class="card-text">Somos una comunidad de creyentes dedicados a seguir a Cristo y compartir su amor.</p>
                </div>
                <div class="card-image w-50">
                    <img src="https://jazon.info/cms/wp-content/uploads/2021/10/sin-ti%CC%81tulo-6-480x269.jpg">
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 (imagen a la izquierda) -->
        <div class="col-12">
            <div class="card d-flex flex-row-reverse align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Qué significa Jazôn?</h3>
                    <p class="card-text">Es un vocablo hebreo que significa “Visión”, “Sueño”, “Profecía” o “Dirección de Dios”.</p>
                </div>
                <div class="card-image w-50">
                    <img src="img/logo/logoFinal2.png">
               </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-12">
            <div class="card d-flex flex-row align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Por qué hacemos lo que hacemos?</h3>
                    <p class="card-text">Porque todo el que encuentra a Dios, encuentra vida.</p>
                </div>
                <div class="card-image w-50">
                    <img src="https://jazon.info/cms/wp-content/uploads/2022/05/CONG012-scaled-480x320.jpg">
                </div>
            </div>
        </div>

        <!-- Tarjeta 4 (imagen a la izquierda) -->
        <div class="col-12">
            <div class="card d-flex flex-row-reverse align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Cuál es la misión de Jazôn?</h3>
                    <p class="card-text">Ayudarte a desarrollar una relación personal con Jesús.</p>
                </div>
                <div class="card-image w-50">
                    <img src="https://jazon.info/cms/wp-content/uploads/2022/05/CONG012-scaled-480x320.jpg">
                </div>
            </div>
        </div>

        <!-- Tarjeta 5 -->
        <div class="col-12">
            <div class="card d-flex flex-row align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Cuál es la visión de Jazôn?</h3>
                    <p class="card-text">Somos una iglesia contemporánea con una propuesta fresca e innovadora.</p>
                </div>
                <div class="card-image w-50">
                    <img src="https://jazon.info/cms/wp-content/uploads/2021/10/sin-ti%CC%81tulo-15-1-480x270.jpg">
                </div>
            </div>
        </div>

        <!-- Tarjeta 6 (imagen a la izquierda) -->
        <div class="col-12">
            <div class="card d-flex flex-row-reverse align-items-center h-100">
                <div class="card-body text-center w-50">
                    <h3 class="card-title">¿Cómo se pronuncia la palabra Jazôn?</h3>
                    <p class="card-text">Se pronuncia como se lee, con acentuación en la “o”: ja – zón.</p>
                </div>
                <div class="card-image w-50">
                    <img src="img/logoAzul.jpg">
                </div>
            </div>
        </div>

    </div>
</div>

    <!-- Divs con imágenes -->
    <div class="container-fluid d-flex flex-wrap justify-content-around mt-4">
        <div class="content-div"
            style="background-image:url('https://jazon.info/cms/wp-content/uploads/2021/08/5.-YouTube-480x339.jpg');">
            <div class="content-text">
                <h3>Youtube</h3>
                <p>Nuestro canal con todo el contenido predicas y más!</p>
            </div>
        </div>
        <div class="content-div"
            style="background-image:url('https://jazon.info/cms/wp-content/uploads/2021/08/1.-Laiglesiatv-480x339.jpg');">
            <div class="content-text">
                <h3>Series de predica</h3>
                <p>Todas nuestras predicas están en Laiglesia.tv</p>
            </div>
        </div>
        <div class="content-div"
            style="background-image:url('https://jazon.info/cms/wp-content/uploads/2021/08/16.-Noticias4-480x679.jpg');">
            <div class="content-text">
                <h3>Noticias</h3>
                <p>Leer nuestras noticias recientes y enterarte de lo último que sucede en Jazon.</p>
            </div>
        </div>
    </div>

    <!-- Mapa de ubicación -->
    <div class="map-container">
        <h3>Ubicación de la Iglesia</h3>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15300.324719968556!2d-68.10876220464706!3d-16.521998797877156!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f214a79ccb259%3A0x9ec288407b902214!2zSmF6w7Ru!5e0!3m2!1ses-419!2sbo!4v1730764297266!5m2!1ses-419!2sbo"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade' allowfullscreen="" loading=" lazy"></iframe>
        <div class="text-center p-3">
            <p>Bolognia, calle 11 #323, La Paz – Bolivia </p>
            <p>Servicios presenciales en dos horarios de domingo: 9AM y 11AM</p>
        </div>
    </div>

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
    <script src="js/conIndex.js"></script>

</body>

</html>