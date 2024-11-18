document.addEventListener("DOMContentLoaded", function () {
    const maxAttempts = 3;
    let failedAttempts = 0;
    const blockTimeInSeconds = 15;
    let blockTime = 0;

    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById("error-message");
    const usernameField = document.getElementById("username");
    const passwordField = document.getElementById("password");

    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }

    usernameField.addEventListener('input', () => {
        if (usernameField.value.length > 30) {
            usernameField.value = usernameField.value.slice(0, 30);
        }
    });

    passwordField.addEventListener('input', () => {
        if (passwordField.value.length > 8) {
            passwordField.value = passwordField.value.slice(0, 8);
        }
    });

    function handleLogin(event) {
        event.preventDefault(); // Evitar el envío del formulario

        if (failedAttempts >= maxAttempts && blockTime > 0) {
            errorMessage.innerText = `Acceso bloqueado. Intenta nuevamente en ${blockTime} segundos.`;
            return;
        }

        const username = usernameField.value;
        const password = passwordField.value;

        if (!validateUsername(username)) {
            errorMessage.innerText = "El nombre de usuario debe ser un correo o contener solo letras y números, con al menos 7 caracteres.";
            return;
        }

        if (!validatePassword(password)) {
            errorMessage.innerText = "La contraseña debe contener solo números y tener 8 caracteres.";
            return;
        }

        // Enviar la solicitud al servidor mediante fetch
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = "index2.php"; // Redirigir a la página de inicio con los datos necesarios
            } else {
                failedAttempts++;
                errorMessage.innerText = data.message;

                if (failedAttempts >= maxAttempts) {
                    blockTime = blockTimeInSeconds;
                    usernameField.disabled = true;
                    passwordField.disabled = true;

                    let countdown = setInterval(() => {
                        if (blockTime > 0) {
                            blockTime--;
                            errorMessage.innerText = `Acceso bloqueado. Intenta nuevamente en ${blockTime} segundos.`;
                        } else {
                            clearInterval(countdown);
                            failedAttempts = 0;
                            blockTime = 0;
                            usernameField.disabled = false;
                            passwordField.disabled = false;
                            usernameField.value = '';
                            passwordField.value = '';
                            errorMessage.innerText = '';
                        }
                    }, 1000);
                }
            }
        })
        .catch(error => {
            errorMessage.innerText = "Error de conexión con el servidor.";
            console.error('Error:', error);
        });
    }

    function validateUsername(username) {
        const usernameRegex = /^[a-zA-Z0-9]{7,}$/;
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return emailRegex.test(username) || usernameRegex.test(username);
    }

    function validatePassword(password) {
        const passwordRegex = /^\d{8}$/;
        return passwordRegex.test(password);
    }
});
