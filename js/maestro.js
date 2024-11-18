// validacion.js

// Validación del formulario usando JavaScript
function validarFormulario() {
    var nombre = document.getElementById("nombre").value;
    var ape_pat = document.getElementById("ape_pat").value;
    var ape_mat = document.getElementById("ape_mat").value;
    var num_telefono = document.getElementById("num_telefono").value;
    var usuario = document.getElementById("usuario").value.trim();  // Eliminar espacios en blanco
    var contrasena = document.getElementById("contrasena").value;
    var mensajeError = false;

    // Limpiar errores previos
    document.getElementById("error_nombre").textContent = "";
    document.getElementById("error_ape_pat").textContent = "";
    document.getElementById("error_ape_mat").textContent = "";
    document.getElementById("error_num_telefono").textContent = "";
    document.getElementById("error_usuario").textContent = "";
    document.getElementById("error_contrasena").textContent = "";

    // Validación Nombre, Apellido Paterno, Apellido Materno (solo letras y espacios)
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(nombre)) {
        document.getElementById("error_nombre").textContent = "El nombre solo puede contener letras y espacios.";
        mensajeError = true;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(ape_pat)) {
        document.getElementById("error_ape_pat").textContent = "El apellido paterno solo puede contener letras y espacios.";
        mensajeError = true;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(ape_mat)) {
        document.getElementById("error_ape_mat").textContent = "El apellido materno solo puede contener letras y espacios.";
        mensajeError = true;
    }

    // Validación Número de Teléfono (solo números y exactamente 8 dígitos)
    if (!/^[0-9]{8}$/.test(num_telefono)) {
        document.getElementById("error_num_telefono").textContent = "El número de teléfono debe ser de 8 dígitos numéricos.";
        mensajeError = true;
    }

    // Validación Usuario (exactamente 4 letras seguidas de 4 números)
    if (!/^[a-zA-Z]{4}[0-9]{4}$/.test(usuario)) {
        document.getElementById("error_usuario").textContent = "El usuario debe tener 4 letras seguidas de 4 números.";
        mensajeError = true;
    }

    // Validación Contraseña (solo números y longitud de 8)
    if (!/^[0-9]{8}$/.test(contrasena)) {
        document.getElementById("error_contrasena").textContent = "La contraseña debe ser de 8 dígitos numéricos.";
        mensajeError = true;
    }

    // Si hay errores, evitar el envío del formulario
    if (mensajeError) {
        return false;
    }

    return true; // Si todo es válido, permitir el envío del formulario
}
