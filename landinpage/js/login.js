// Login form submission
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const user = document.getElementById("username").value; // Cambié el id
    const password = document.getElementById("password").value; // Cambié el id

    fetch('http://localhost/lumen/public/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: user, password: password })
    })
    .then(response => response.json())
    .then(data => {
        const messageElement = document.getElementById("loginMessage");
        if (data.success) {
            messageElement.textContent = 'Login successful!';
            messageElement.className = 'message success';
            window.location.href = "/plantilla_reducidisima/plantilla/index.html"
        } else {
            messageElement.textContent = data.message || 'Usuario o Contraseña incorrectos.';
            messageElement.className = 'message error';
        }
    })
    .catch(error => {
        const messageElement = document.getElementById("loginMessage");
        messageElement.textContent = 'Credenciales ya usadas, intente con otro correo.';
        messageElement.className = 'message error';
    });
});

