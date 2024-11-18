document.querySelector('form').addEventListener('submit', function (event) {
    // Limpiar mensajes de error previos
    document.querySelectorAll('.error-msg').forEach(msg => msg.textContent = '');

    let isValid = true;

    // Obtener valores de los campos
    const nombreEvento = document.getElementById('evento').value.trim();
    const fechaEvento = document.getElementById('fecha').value;
    const descripcionEvento = document.getElementById('descripcion').value.trim();
    const imagenEvento = document.getElementById('imagen').value;

    // Validar el nombre del evento (solo letras)
    const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    if (!nombreRegex.test(nombreEvento)) {
        document.getElementById('error-evento').textContent = 'El nombre solo puede contener letras.';
        isValid = false;
    }

    // Validar la fecha del evento (solo años a partir de 2024)
    const fechaMinima = new Date('2024-01-01');
    const fechaIngresada = new Date(fechaEvento);
    if (!fechaEvento || fechaIngresada < fechaMinima) {
        document.getElementById('error-fecha').textContent = 'La fecha debe ser igual o posterior al 1 de enero de 2024.';
        isValid = false;
    }

    // Validar la descripción (letras, números y caracteres permitidos)
    const descripcionRegex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.,:;!?()@#$%&*-_]+$/;
    const palabrasDescripcion = descripcionEvento.split(/\s+/);
    if (!descripcionRegex.test(descripcionEvento)) {
        document.getElementById('error-descripcion').textContent =
            'La descripción solo puede contener letras, números y ciertos caracteres especiales.';
        isValid = false;
    } else if (palabrasDescripcion.length < 20 || palabrasDescripcion.length > 50) {
        document.getElementById('error-descripcion').textContent =
            'La descripción debe tener entre 20 y 50 palabras.';
        isValid = false;
    }

    // Validar el formato de la imagen (png, jpg, gif)
    const imagenRegex = /\.(png|jpg|jpeg|gif)$/i;
    if (imagenEvento && !imagenRegex.test(imagenEvento)) {
        document.getElementById('error-imagen').textContent = 'Solo se permiten imágenes en formato PNG, JPG o GIF.';
        isValid = false;
    }

    // Prevenir el envío del formulario si hay errores
    if (!isValid) {
        event.preventDefault();
    }
});
