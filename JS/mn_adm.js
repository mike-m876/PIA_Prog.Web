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

document.querySelectorAll('.boton-admin a').forEach(boton => {
  boton.addEventListener('click', function(e) {
      e.preventDefault();
      const accion = this.textContent.trim();
      
      switch(accion) {
          case 'Gestión de Usuarios':
              window.location.href = "gestion_usuarios.html";
              break;
          case 'Calificaciones':
              window.location.href = "calificaciones.html";
              break;
          case 'Materias':
              window.location.href = "materias.html";
              break;
          case 'Grupos':
              window.location.href = "grupos.html";
              break;
          case 'Turnos':
              window.location.href = "turnos.html";
              break;
          case 'Reporte Estadístico':
              window.location.href = "reporte_estadistico.html";
              break;
          default:
              console.log(`Acción no definida: ${accion}`);
      }
  });
});