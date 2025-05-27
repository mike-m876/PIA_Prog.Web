// CAMBIO DE CONTRASEÑA
const form = document.getElementById('formCambiarContrasena');
const nueva = document.getElementById('nueva');
const confirmar = document.getElementById('confirmar');
const submitBtn = form.querySelector('button[type="submit"]');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    confirmar.classList.remove('is-invalid');
    submitBtn.disabled = true;

    if (nueva.value !== confirmar.value) {
        confirmar.classList.add('is-invalid');
        submitBtn.disabled = false;
        return;
    }

    if (nueva.value.length < 12) {
        alert('La nueva contraseña debe tener al menos 12 caracteres.');
        submitBtn.disabled = false;
        return;
    }
    const actual = document.getElementById('actual').value;

    fetch('usuarios/cambiar_contrasena.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            actual: actual,
            nueva: nueva.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Contraseña actualizada correctamente.');
            form.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modal_psswd'));
            modal.hide();
        } else {
            alert(data.message || 'No se pudo cambiar la contraseña.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error del servidor.');
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
});

// Mostrar/Ocultar contraseña
function togglePassword() {
  const input = document.getElementById("psw");
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
