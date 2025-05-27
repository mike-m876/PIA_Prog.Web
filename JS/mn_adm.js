// Cerrar sesión
document.getElementById('btnCerrarSesion').addEventListener('click', function () {
    // Limpia cualquier dato de sesión/localStorage
    localStorage.clear();
    sessionStorage.clear();

    // Redirige a la página de login
    window.location.href = "LOGIN.php";
});

document.querySelectorAll('.boton-admin a').forEach(boton => {
  boton.addEventListener('click', function(e) {
      e.preventDefault();
      const accion = this.textContent.trim();
      
      switch(accion) {
          case 'Gestión de Usuarios':
              window.location.href = "crud_usuarios.php";
              break;
          case 'Calificaciones':
              window.location.href = "crud_calificaciones.php";
              break;
          case 'Materias':
              window.location.href = "crud_materias.php";
              break;
          case 'Grupos':
              window.location.href = "crud_grupos.php";
              break;
          case 'Turnos':
              window.location.href = "crud_turnos.php";
              break;
          case 'Reporte Estadístico':
              window.location.href = "reportes_ciclos.php";
              break;
          default:
              console.log(`Acción no definida: ${accion}`);
      }
  });
});