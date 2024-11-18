//#region VALIDACION  DE RECUPECION DE CONTRASEÑA 
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.getElementById("email");
    const mensaje = document.querySelector(".mensaje p");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        const email = emailInput.value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            mensaje.textContent = "Por favor, ingrese un correo electrónico válido.";
            mensaje.style.color = "red";
        } else {
            mensaje.textContent = "Procesando...";
            mensaje.style.color = "black";
            // Aquí puedes continuar con el envío del formulario o hacer la solicitud fetch si es necesario.
            form.submit(); // Solo envía el formulario si el correo es válido
        }
    });
});
//#endregion

//#region VALIDACION DE  LOGIN_RECUPERACION2
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const codigoInput = document.getElementById("codigo");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const passwordMessage = document.getElementById("password-message");

    // Limitar la longitud máxima de caracteres en el campo de código a 5 y en las contraseñas a 8
    codigoInput.addEventListener("input", function () {
        if (codigoInput.value.length > 5) {
            codigoInput.value = codigoInput.value.slice(0, 5);
        }
    });

    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.length > 8) {
            passwordInput.value = passwordInput.value.slice(0, 8);
        }
    });

    confirmPasswordInput.addEventListener("input", function () {
        if (confirmPasswordInput.value.length > 8) {
            confirmPasswordInput.value = confirmPasswordInput.value.slice(0, 8);
        }
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Previene el envío por defecto

        const codigo = codigoInput.value;
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Validación del código: Solo números y máximo 5 dígitos
        if (!/^\d{5}$/.test(codigo)) {
            alert("El código debe contener exactamente 5 dígitos numéricos.");
            return;
        }

        // Validación de las contraseñas: Solo números y máximo 8 caracteres
        if (!/^\d{8}$/.test(password)) {
            alert("La contraseña debe contener solo números y tener exactamente 8 caracteres.");
            return;
        }

        // Comparación de contraseñas
        if (password !== confirmPassword) {
            passwordMessage.style.color = "red";
            passwordMessage.textContent = "Las contraseñas no coinciden.";
            return;
        } else {
            passwordMessage.style.color = "green";
            passwordMessage.textContent = "Las contraseñas coinciden.";
        }

        // Si todas las validaciones son correctas, enviar el formulario
        form.submit();
    });
});


//#endregion

//#region VALIDACION DE REGISTRO DE PERSONAL
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("personalForm");

    // Obtener la fecha de hoy
    const today = new Date();
    const currentYear = today.getFullYear();
    const minYear = currentYear - 45; // Año mínimo para 45 años
    const maxYear = currentYear - 20; // Año máximo para 20 años

    const fechaNacimiento = document.getElementById("fecha_nacimiento");
    fechaNacimiento.setAttribute("max", `${maxYear}-${today.getMonth() + 1}-${today.getDate()}`);
    fechaNacimiento.setAttribute("min", `${minYear}-${today.getMonth() + 1}-${today.getDate()}`);

    // Expresión regular para validar solo letras y espacios
    const letrasConEspaciosPattern = /^[A-Za-záéíóúÁÉÍÓÚüÜ\s]+$/;

    // Función de validación
    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Validar nombre
        const nombre = document.getElementById("nombre");
        const nombreError = document.getElementById("nombreError");
        if (nombre.value.trim() === "") {
            nombreError.textContent = "El nombre es obligatorio.";
            isValid = false;
        } else if (!letrasConEspaciosPattern.test(nombre.value.trim())) {
            nombreError.textContent = "El nombre solo debe contener letras y espacios.";
            isValid = false;
        } else {
            nombreError.textContent = "";
        }

        // Validar apellido paterno
        const apellidoPaterno = document.getElementById("apellido_paterno");
        const apellidoPaternoError = document.getElementById("apellidoPaternoError");
        if (apellidoPaterno.value.trim() === "") {
            apellidoPaternoError.textContent = "El apellido paterno es obligatorio.";
            isValid = false;
        } else if (!letrasConEspaciosPattern.test(apellidoPaterno.value.trim())) {
            apellidoPaternoError.textContent = "El apellido paterno solo debe contener letras y espacios.";
            isValid = false;
        } else {
            apellidoPaternoError.textContent = "";
        }

        // Validar apellido materno
        const apellidoMaterno = document.getElementById("apellido_materno");
        const apellidoMaternoError = document.getElementById("apellidoMaternoError");
        if (apellidoMaterno.value.trim() === "") {
            apellidoMaternoError.textContent = "El apellido materno es obligatorio.";
            isValid = false;
        } else if (!letrasConEspaciosPattern.test(apellidoMaterno.value.trim())) {
            apellidoMaternoError.textContent = "El apellido materno solo debe contener letras y espacios.";
            isValid = false;
        } else {
            apellidoMaternoError.textContent = "";
        }

        // Validar fecha de nacimiento
        const fechaNacimiento = document.getElementById("fecha_nacimiento");
        const fechaNacimientoError = document.getElementById("fechaNacimientoError");
        if (fechaNacimiento.value === "") {
            fechaNacimientoError.textContent = "La fecha de nacimiento es obligatoria.";
            isValid = false;
        } else {
            fechaNacimientoError.textContent = "";
        }

        // Validar correo
        const correo = document.getElementById("correo");
        const correoError = document.getElementById("correoError");
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(correo.value)) {
            correoError.textContent = "Por favor ingrese un correo electrónico válido.";
            isValid = false;
        } else {
            correoError.textContent = "";
        }

        // Validar teléfono
        const telefono = document.getElementById("telefono");
        const telefonoError = document.getElementById("telefonoError");
        if (telefono.value.length !== 8) {
            telefonoError.textContent = "El teléfono debe tener exactamente 8 dígitos.";
            isValid = false;
        } else {
            telefonoError.textContent = "";
        }

        // Validar dirección
        const direccion = document.getElementById("direccion");
        const direccionError = document.getElementById("direccionError");
        if (direccion.value.trim() === "") {
            direccionError.textContent = "La dirección es obligatoria.";
            isValid = false;
        } else {
            direccionError.textContent = "";
        }

        // Si alguna validación falla, no enviamos el formulario
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Limitar caracteres en los campos de texto (nombre, apellido paterno y apellido materno) a 20 caracteres
    const limitInputLength = (inputId) => {
        const input = document.getElementById(inputId);
        input.addEventListener("input", function () {
            if (input.value.length > 20) {
                input.value = input.value.slice(0, 20); // Limitar a 20 caracteres
            }
        });
    };

    // Aplicar la limitación a los campos correspondientes
    limitInputLength("nombre");
    limitInputLength("apellido_paterno");
    limitInputLength("apellido_materno");

    // Limitar caracteres en el campo teléfono
    const telefonoInput = document.getElementById("telefono");
    telefonoInput.addEventListener("input", function () {
        if (telefonoInput.value.length > 8) {
            telefonoInput.value = telefonoInput.value.slice(0, 8); // Limitar a 8 caracteres
        }
    });
});
//#endregion