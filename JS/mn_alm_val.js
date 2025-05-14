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
            }
        });