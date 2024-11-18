//#region AGREGARNIÑO VALIDACION
// Función para validar que los campos de texto solo contengan letras
function soloLetras(event) {
    const keyCode = event.keyCode || event.which;
    const key = String.fromCharCode(keyCode).toLowerCase();
    const letras = "abcdefghijklmnopqrstuvwxyzáéíóúü";
    if (letras.indexOf(key) === -1 && keyCode !== 32) { // 32 es el espacio
        event.preventDefault();
    }
}

// Función para validar la fecha de nacimiento
function validarFechaNacimiento() {
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    const hoy = new Date();
    const fechaNac = new Date(fechaNacimiento);
    const edad = hoy.getFullYear() - fechaNac.getFullYear();
    const mes = hoy.getMonth() - fechaNac.getMonth();
    const dia = hoy.getDate() - fechaNac.getDate();

    // Si el mes o el día actual aún no han pasado en el año, no sumamos el año
    if (mes < 0 || (mes === 0 && dia < 0)) {
        edad--;
    }

    // Validación para asegurarse de que la edad esté entre 5 y 16 años
    if (edad < 5 || edad > 16) {
        document.getElementById('error_fecha').textContent = "La edad debe estar entre 5 y 16 años.";
        return false;
    } else {
        document.getElementById('error_fecha').textContent = ""; // Limpiar mensaje de error
        return true;
    }
}

// Función para validar el formulario
function validarFormulario(event) {
    let valid = true;

    // Validar nombre, apellido paterno y materno (solo letras)
    const camposTexto = ['nombre', 'apellido_paterno', 'apellido_materno'];
    camposTexto.forEach(campo => {
        const valor = document.getElementById(campo).value;
        const regex = /^[a-zA-ZáéíóúüÁÉÍÓÚÜ]+$/;
        if (!regex.test(valor)) {
            document.getElementById('error_' + campo).textContent = "Este campo solo debe contener letras.";
            valid = false;
        } else {
            document.getElementById('error_' + campo).textContent = ""; // Limpiar mensaje de error
        }
    });

    // Validar fecha de nacimiento
    if (!validarFechaNacimiento()) {
        valid = false;
    }

    return valid;
}

document.addEventListener('DOMContentLoaded', () => {
    // Asignar la validación de solo letras en los campos de texto
    document.getElementById('nombre').addEventListener('keypress', soloLetras);
    document.getElementById('apellido_paterno').addEventListener('keypress', soloLetras);
    document.getElementById('apellido_materno').addEventListener('keypress', soloLetras);

    // Asignar la validación de fecha de nacimiento al evento de submit del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        if (!validarFormulario(event)) {
            event.preventDefault(); // Evitar que el formulario se envíe si hay errores
        }
    });
});
//#endregion 
//#region AGREGAR ENFERMEDAD VALIDACION

 // Validación de solo letras para el campo "enfermedad"
 document.getElementById('form-enfermedad').addEventListener('submit', function (event) {
    const enfermedadInput = document.getElementById('enfermedad');
    const errorSpan = document.getElementById('error-enfermedad');

    // Expresión regular para validar solo letras
    const soloLetras = /^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/;

    // Validar el valor del input
    if (!soloLetras.test(enfermedadInput.value.trim())) {
        event.preventDefault(); // Detener el envío del formulario
        errorSpan.textContent = "Por favor, ingrese solo letras."; // Mostrar el error
    } else {
        errorSpan.textContent = ""; // Limpiar el error si es válido
    }
});
//#endregion
//#region AGREGAr CURSO VALIDACION
