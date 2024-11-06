<?php
require_once 'bd.php'; // Incluye la clase de base de datos

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

    <style>
        /* Estilos generales */
        body {
            font-family: 'Georgia', Cambria, serif;
            background-color: #000000;
            color: #efb810;
        }

        /* Cabecera */
        header {
            background-color: #000;
            color: #efb810;
            position: sticky;
            top: 0;
            z-index: 1020;
            border-bottom: 1px solid #efb810;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }

        .title-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
        }

        .title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #efb810;
        }

        .nav-link {
            color: #efb810;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff;
        }

        /* Estilo de bienvenida */
        .Bienven {
            padding: 50px;
            text-align: right;
            margin-right: 30px;
            font-size: 1.2rem;
            color: #bdc3c7;
        }

        /* Estilos de las tarjetas de información */
        .card {
            background-color: #1c1c1c;
            border: 1px solid #efb810;
            color: #bdc3c7;
            transition: transform 0.3s ease, background-image 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card-title {
            color: #efb810;
            font-weight: bold;
            z-index: 2;
            position: relative;
        }

        .card-body p {
            z-index: 2;
            position: relative;
        }

        .card:hover {
            transform: scale(1.15);
            background-image: url('https://st2.depositphotos.com/1031174/6383/i/450/depositphotos_63837275-stock-photo-prayer.jpg');
            /* Cambia esta URL a la imagen que prefieras */
            background-size: contain;
            background-position: center;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Sombreado para mejorar la legibilidad del texto */
            z-index: 1;
            transition: opacity 0.3s ease;
        }

        /* Estilos de los divs con imagen de fondo */
        .content-div {
            width: 30%;
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
            margin: 10px;
            border-radius: 8px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            overflow: hidden;
        }

        .content-div:hover {
            transform: scale(1.05);
            opacity: 0.85;
        }

        .content-text {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
            color: #ffffff;
        }

        /* Estilos del mapa */
        .map-container {
            margin-top: 40px;
            margin-bottom: 40px;
            text-align: center;
        }

        .map-container h3 {
            color: #efb810;
        }

        iframe {
            width: 100%;
            height: 300px;
            border: 2px solid #efb810;
            border-radius: 8px;
        }

        /* Estilos del pie de página */
        footer {
            background-color: #000;
            color: #bdc3c7;
            border-top: 1px solid #efb810;
        }

        footer a {
            color: #efb810;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffffff;
        }

        /* Contenedor de filtro */
        .filter-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        /* Estilos de filtro */
        .form-label {
            font-weight: bold;
            color: #FFD700;
            /* Color dorado */
        }

        .form-select {
            border: 1px solid #FFD700;
            /* Borde dorado */
            background-color: black;
            color: #FFFFFF;
            /* Texto blanco */
        }

        .form-select:focus {
            border-color: #FFD700;
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
            /* Sombra dorada */
        }

        /* Estilos del carrusel */
        #eventCarousel {
            background-color: #000000;
            /* Fondo negro */
            border-radius: 8px;
            padding: 10px;
        }

        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: contain;
        }

        /* Controles del carrusel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #FFD700;
            /* Iconos dorados */
            border-radius: 50%;
        }

        /* Botones de control al pasar el cursor */
        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: #d17d00;
            /* Cambio a blanco en hover */
        }

        /* Texto de navegación oculto (para accesibilidad) */
        .visually-hidden {
            display: none;
        }

        .nav-link {
            color: gold;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: white;
        }
    </style>

</head>

<body>
    <!-- CABECERA -->
    <header class="p-3">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="title-container">
                <img src="img/logo/logoFinal.png" class="logo" alt="Logo de la Iglesia">
                <span class="title">Iglesia Jazon</span>
                </div>
                <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="index.php" class="nav-link px-2">Inicio</a></li>
                </ul>
                <div class="text-end">
                    <a href="login.html" class="btn btn-outline-light">Login</a>
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
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Quiénes Somos?</h3>
                        <p class="card-text">Somos una comunidad de creyentes dedicados a seguir a Cristo y compartir su
                            amor.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Qué significa Jazôn?</h3>
                        <p class="card-text">Es un vocablo hebreo que significa “Visión”, “Sueño”, “Profecía” o
                            “Dirección de Dios”.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Por qué hacemos lo que hacemos?</h3>
                        <p class="card-text">Porque todo el que encuentra a Dios, encuentra vida.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Cuál es la misión de Jazôn?</h3>
                        <p class="card-text">Ayudarte a desarrollar una relación personal con Jesús.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Cuál es la visión de Jazôn?</h3>
                        <p class="card-text">Somos una iglesia contemporánea con una propuesta fresca e innovadora.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">¿Cómo se pronuncia la palabra Jazôn?</h3>
                        <p class="card-text">Se pronuncia como se lee, con acentuación en la “o”: ja – zón.</p>
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
    <script>
    document.getElementById('eventFilter').addEventListener('change', function () {
        window.location.href = '?eventFilter=' + this.value;
    });
</script>

    <script>
        document.getElementById('eventFilter').addEventListener('change', function () {
            const selectedCategory = this.value;
            const items = document.querySelectorAll('#eventCarousel .carousel-item');

            // Filtra las diapositivas según la categoría seleccionada
            let firstItem = true;

            items.forEach(item => {
                const category = item.getAttribute('data-category');
                if (category.includes(selectedCategory) || selectedCategory === 'all') {
                    item.classList.remove('d-none');
                    if (firstItem) {
                        item.classList.add('active');
                        firstItem = false;
                    } else {
                        item.classList.remove('active');
                    }
                } else {
                    item.classList.add('d-none');
                    item.classList.remove('active');
                }
            });

            // Reiniciar el carrusel al primer elemento activo después del filtro
            const carousel = document.getElementById('eventCarousel');
            const bsCarousel = bootstrap.Carousel.getInstance(carousel); // Obtener instancia de Bootstrap
            bsCarousel.to(0);
        });
    </script>

</body>

</html>