// Validaciones del formulario de agregar actividad
document.getElementById('form-actividad').addEventListener('submit', function (event) {
    let valid = true; // Controlador de validación

    // Obtener elementos del formulario
    const actividadInput = document.getElementById('actividad');
    const descripcionInput = document.getElementById('descripcion');
    const fechaInput = document.getElementById('fecha_act');
    const idCursoInput = document.getElementById('id_curso');

    // Obtener spans de error
    const actividadError = document.getElementById('error-actividad');
    const descripcionError = document.getElementById('error-descripcion');
    const fechaError = document.getElementById('error-fecha');
    const idCursoError = document.getElementById('error-id_curso');

    // Limpiar errores previos
    [actividadError, descripcionError, fechaError, idCursoError].forEach(span => span.textContent = '');

    // Validar campo "Actividad" (Solo letras)
    const actividadRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    if (!actividadRegex.test(actividadInput.value.trim())) {
        actividadError.textContent = 'Solo se permiten letras y espacios.';
        valid = false;
    }

    // Validar campo "Descripción"
    const descripcionRegex = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ,.!?]+$/;
    const descripcionTexto = descripcionInput.value.trim();
    const palabrasDescripcion = descripcionTexto.split(/\s+/).length; // Contar palabras
    if (!descripcionRegex.test(descripcionTexto)) {
        descripcionError.textContent = 'La descripción solo puede contener letras, números y signos básicos de puntuación.';
        valid = false;
    } else if (palabrasDescripcion < 25) {
        descripcionError.textContent = 'La descripción debe contener al menos 25 palabras.';
        valid = false;
    }

    // Validar campo "Fecha"
    const fechaSeleccionada = new Date(fechaInput.value);
    const fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0); // Normalizar a medianoche para comparar solo la fecha
    if (!fechaInput.value || fechaSeleccionada < fechaActual) {
        fechaError.textContent = 'La fecha debe ser actual o futura.';
        valid = false;
    }

    // Validar campo "ID Curso"
    const idCursoRegex = /^[0-9]+$/;
    if (!idCursoRegex.test(idCursoInput.value.trim())) {
        idCursoError.textContent = 'Solo se permiten números.';
        valid = false;
    }

    // Evitar el envío del formulario si hay errores
    if (!valid) {
        event.preventDefault();
    }
});
