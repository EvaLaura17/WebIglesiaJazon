document.getElementById('form-curso').addEventListener('submit', function(event) {
    let valid = true; // Controlador de validación

    // Obtener elementos del formulario
    const grupoInput = document.getElementById('grupo');
    const edadMinInput = document.getElementById('edadMin');
    const edadMaxInput = document.getElementById('edadMax');
    const cantInput = document.getElementById('cant');

    // Obtener spans de error
    const grupoError = document.getElementById('error-grupo');
    const edadMinError = document.getElementById('error-edadMin');
    const edadMaxError = document.getElementById('error-edadMax');
    const cantError = document.getElementById('error-cant');

    // Limpiar errores previos
    [grupoError, edadMinError, edadMaxError, cantError].forEach(span => span.textContent = '');

    // Validar campo "Grupo" (Solo letras y números, sin caracteres especiales)
    const grupoValue = grupoInput.value.trim();
    if (!/^[a-zA-Z0-9]+$/.test(grupoValue)) {
        grupoError.textContent = 'El grupo solo debe contener letras y números.';
        valid = false;
    }

    // Validar campo "Edad mínima"
    const edadMinValue = edadMinInput.value.trim();
    if (!/^\d+$/.test(edadMinValue)) {
        edadMinError.textContent = 'La edad mínima debe ser un número válido.';
        valid = false;
    }

    // Validar campo "Edad máxima"
    const edadMaxValue = edadMaxInput.value.trim();
    if (!/^\d+$/.test(edadMaxValue)) {
        edadMaxError.textContent = 'La edad máxima debe ser un número válido.';
        valid = false;
    }

    // Validar que la edad máxima sea mayor que la edad mínima
    if (parseInt(edadMaxValue) <= parseInt(edadMinValue)) {
        edadMaxError.textContent = 'La edad máxima debe ser mayor que la edad mínima.';
        valid = false;
    } 
    // Validar que la edad máxima sea mayor que la edad mínima
    if (parseInt(edadMinValue) >= parseInt(edadMaxValue)) {
        edadMinError.textContent = 'La edad minima debe ser menor que la edad máxima.';
        valid = false
    } 
    else
    if (parseInt(edadMaxValue) > 16) {
        edadMaxError.textContent = 'La edad máxima no puede superar los 16 años.';}

    // Validar campo "Cantidad máxima de niños"
    const cantValue = cantInput.value.trim();
    if (!/^\d+$/.test(cantValue)) {
        cantError.textContent = 'La cantidad máxima debe ser un número válido.';
        valid = false;
    } else if (parseInt(cantValue) > 20) {
        cantError.textContent = 'La cantidad máxima no puede superar los 20 niños.';
        valid = false;
    }

    // Si hay errores, prevenir el envío del formulario
    if (!valid) {
        event.preventDefault();
    }
});
