function initMaterias() {
    // Manejo del modal de edición
    document.querySelectorAll('.editar-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const desc = this.getAttribute('data-desc');
            const maestro = this.getAttribute('data-maestro');
            
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-desc').value = desc;
            document.getElementById('edit-maestro').value = maestro;
            
            const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
            modal.show();
        });
    });

    // Manejo del modal de eliminación
    document.querySelectorAll('.eliminar-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            
            document.getElementById('eliminar-id').value = id;
            document.getElementById('eliminar-nombre').textContent = nombre;
            
            const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
            modal.show();
        });
    });

    // Validación del formulario de agregar
    const formAgregar = document.querySelector('#modalAgregar form');
    if (formAgregar) {
        formAgregar.addEventListener('submit', function(e) {
            const nombre = this.elements['nombre'].value.trim();
            if (nombre.length < 3) {
                e.preventDefault();
                alert('El nombre debe tener al menos 3 caracteres');
                this.elements['nombre'].focus();
            }
        });
    }

    // Validación del formulario de editar
    const formEditar = document.querySelector('#modalEditar form');
    if (formEditar) {
        formEditar.addEventListener('submit', function(e) {
            const nombre = this.elements['nombre'].value.trim();
            if (nombre.length < 3) {
                e.preventDefault();
                alert('El nombre debe tener al menos 3 caracteres');
                this.elements['nombre'].focus();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initMaterias();
});