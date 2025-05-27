// Cerrar sesión
document.getElementById('btnCerrarSesion').addEventListener('click', function () {
    localStorage.clear();
    sessionStorage.clear();

    window.location.href = "LOGIN.php";
});
