// Cerrar sesión
document.getElementById('btnCerrarSesion').addEventListener('click', function () {
    // Limpia cualquier dato de sesión/localStorage
    localStorage.clear();
    sessionStorage.clear();

    // Redirige a la página de login
    window.location.href = "LOGIN.php";
});