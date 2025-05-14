// Validación de cambio de contraseña
const form = document.getElementById('formCambiarContrasena');
const nueva = document.getElementById('nueva');
const confirmar = document.getElementById('confirmar');

form.addEventListener('submit', function (e) {
  confirmar.classList.remove('is-invalid');

  if (nueva.value !== confirmar.value) {
    e.preventDefault();
    confirmar.classList.add('is-invalid');
  } else {
    alert('Contraseña actualizada correctamente.');
    // ENVIAR BACKEND
  }
});

// Cerrar sesión
document.getElementById('btnCerrarSesion').addEventListener('click', function () {
    // Limpia cualquier dato de sesión/localStorage
    localStorage.clear();
    sessionStorage.clear();

    // Redirige a la página de login
    window.location.href = "LOGIN.html";
});