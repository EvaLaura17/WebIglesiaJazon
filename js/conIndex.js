document.getElementById('eventFilter').addEventListener('change', function () {
    window.location.href = '?eventFilter=' + this.value;
    });
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