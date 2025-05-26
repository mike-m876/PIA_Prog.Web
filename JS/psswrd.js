// Mostrar/Ocultar contraseña
function togglePassword() {
  const input = document.getElementById("psswd");
  const icon = document.getElementById("toggleIcon");
  
  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("bi-eye-fill");
    icon.classList.add("bi-eye-slash-fill");
  } else {
    input.type = "password";
    icon.classList.remove("bi-eye-slash-fill");
    icon.classList.add("bi-eye-fill");
  }
}

// Validación de cambio de contraseña (asegurar que se cargue el DOM)
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formCambiarContrasena');
  const nueva = document.getElementById('nueva');
  const confirmar = document.getElementById('confirmar');

  if (form) {
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
  }
});