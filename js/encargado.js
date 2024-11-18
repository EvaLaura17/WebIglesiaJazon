// validacion.js

// Validación del formulario usando JavaScript
function validarFormulario() {
    var id_encargado = document.getElementById("id_encargado").value;
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var relacion = document.getElementById("relacion").value;
    var num_telefono = document.getElementById("num_telefono").value;
    var mensajeError = false;

    // Limpiar errores previos
    document.getElementById("error_id_encargado").textContent = "";
    document.getElementById("error_nombre").textContent = "";
    document.getElementById("error_apellido").textContent = "";
    document.getElementById("error_relacion").textContent = "";
    document.getElementById("error_num_telefono").textContent = "";

    // Validación ID Encargado (solo números)
    if (!/^[0-9]+$/.test(id_encargado)) {
        document.getElementById("error_id_encargado").textContent = "El ID Encargado debe contener solo números.";
        mensajeError = true;
    }

    // Validación Nombre, Apellido, Relación (solo letras y espacios)
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(nombre)) {
        document.getElementById("error_nombre").textContent = "El nombre debe contener solo letras y no debe tener caracteres especiales.";
        mensajeError = true;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(apellido)) {
        document.getElementById("error_apellido").textContent = "El apellido debe contener solo letras y no debe tener caracteres especiales.";
        mensajeError = true;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(relacion)) {
        document.getElementById("error_relacion").textContent = "La relación debe contener solo letras y no debe tener caracteres especiales.";
        mensajeError = true;
    }

    // Validación Número de Teléfono (solo números y exactamente 8 dígitos)
    if (!/^[0-9]{8}$/.test(num_telefono)) {
        document.getElementById("error_num_telefono").textContent = "El número de teléfono debe contener exactamente 8 dígitos y solo números.";
        mensajeError = true;
    }

    // Si hay errores, evitar el envío del formulario
    if (mensajeError) {
        return false;
    }

    return true; // Si todo es válido, permitir el envío del formulario
}
