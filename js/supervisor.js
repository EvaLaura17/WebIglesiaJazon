function validarFormulario() {
    let isValid = true;

    // Obtener los valores de los campos
    const nombre = document.getElementById("nombre").value.trim();
    const apePat = document.getElementById("ape_pat").value.trim();
    const apeMat = document.getElementById("ape_mat").value.trim();
    const numTelefono = document.getElementById("num_telefono").value.trim();
    const usuario = document.getElementById("usuario").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();
    const correo = document.getElementById("correo").value.trim();

    // Limpiar errores previos
    limpiarErrores();

    // Validar Nombre y Apellidos (solo letras y espacios)
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(nombre) || nombre === "") {
        document.getElementById("errorNombre").textContent = "El nombre solo puede contener letras y espacios.";
        isValid = false;
    }

    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(apePat) || apePat === "") {
        document.getElementById("errorApePat").textContent = "El apellido paterno solo puede contener letras y espacios.";
        isValid = false;
    }

    if (!/^[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/.test(apeMat) || apeMat === "") {
        document.getElementById("errorApeMat").textContent = "El apellido materno solo puede contener letras y espacios.";
        isValid = false;
    }

    // Validar Teléfono (solo 8 dígitos)
    if (!/^[0-9]{8}$/.test(numTelefono)) {
        document.getElementById("errorTelefono").textContent = "El número de teléfono debe ser de 8 dígitos numéricos.";
        isValid = false;
    }

    // Validar Usuario (4 letras seguidas de 4 números)
    if (!/^[a-zA-Z]{4}[0-9]{4}$/.test(usuario)) {
        document.getElementById("errorUsuario").textContent = "El usuario debe tener 4 letras seguidas de 4 números.";
        isValid = false;
    }

    // Validar Contraseña (solo 8 dígitos numéricos)
    if (!/^[0-9]{8}$/.test(contrasena)) {
        document.getElementById("errorContrasena").textContent = "La contraseña debe ser de 8 dígitos numéricos.";
        isValid = false;
    }

    // Validar Correo (formato de correo válido)
    if (!/\S+@\S+\.\S+/.test(correo)) {
        document.getElementById("errorCorreo").textContent = "El correo debe ser válido.";
        isValid = false;
    }

    return isValid;
}

function limpiarErrores() {
    document.getElementById("errorNombre").textContent = "";
    document.getElementById("errorApePat").textContent = "";
    document.getElementById("errorApeMat").textContent = "";
    document.getElementById("errorTelefono").textContent = "";
    document.getElementById("errorUsuario").textContent = "";
    document.getElementById("errorContrasena").textContent = "";
    document.getElementById("errorCorreo").textContent = "";
}
