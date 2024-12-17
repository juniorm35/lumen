document.getElementById("registerForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const name = document.getElementById("registerName").value.trim();
    const email = document.getElementById("registerEmail").value.trim();
    const password = document.getElementById("registerPassword").value;
    const passwordConfirm = document.getElementById("registerPasswordConfirm").value;
    const messageElement = document.getElementById("registerMessage");

    messageElement.textContent = "";
    messageElement.className = "message"; // Limpiar cualquier clase anterior

    if (!name || !email || !password || !passwordConfirm) {
        showMessage("Todos los campos son obligatorios.", "error");
        return;
    }

    if (name.length < 3) {
        showMessage("El nombre debe tener al menos 3 caracteres.", "error");
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showMessage("El correo no tiene un formato válido.", "error");
        return;
    }

    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordRegex.test(password)) {
        showMessage("La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un carácter especial.", "error");
        return;
    }

    if (/\s/.test(password)) {
        showMessage("La contraseña no debe contener espacios en blanco.", "error");
        return;
    }

    if (password !== passwordConfirm) {
        showMessage("Las contraseñas no coinciden.", "error");
        return;
    }

    fetch("http://localhost/lumen/public/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ name, email, password }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showMessage("¡Registro exitoso! Redirigiendo al inicio de sesión...", "success");
                setTimeout(() => {
                    window.location.href = "login.html";
                }, 2000);
            } else {
                showMessage(data.message || "El usuario o correo ya existe.", "error");
            }
        })
        .catch(() => {
            showMessage("Ocurrió un error inesperado. Inténtalo más tarde.", "error");
        });
});

// Función para mostrar mensajes
function showMessage(message, type) {
    const messageElement = document.getElementById("registerMessage");

    // Limpia cualquier mensaje previo
    messageElement.textContent = message;

    // Asegúrate de que se eliminen las clases previas
    messageElement.classList.remove("show", "error", "success");

    // Añade las nuevas clases para el tipo de mensaje y hacer visible
    messageElement.classList.add(type, "show");
}

// Función para alternar visibilidad de contraseña
function togglePasswordVisibility(fieldId) {
    const inputField = document.getElementById(fieldId);
    const toggleIcon = inputField.nextElementSibling;

    if (inputField.type === "password") {
        inputField.type = "text";
        toggleIcon.textContent = "🙈"; // Cambia el icono
    } else {
        inputField.type = "password";
        toggleIcon.textContent = "👁️"; // Cambia el icono
    }
}
