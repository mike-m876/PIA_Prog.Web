const btnBuscar = document.getElementById('btnBuscar');
const tabla = document.querySelector('#tablaCalificaciones tbody');
const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
const formEditar = document.getElementById('formEditar');
const modalTablaMaterias = document.querySelector('#modalTablaMaterias tbody');
const infoAlumno = document.getElementById('infoAlumno');
const infoMatricula = document.getElementById('infoMatricula');
const infoNombre = document.getElementById('infoNombre');

let materiasAlumno = [];
let idAlumnoGlobal = null;

btnBuscar.addEventListener('click', () => {
    const matricula = document.getElementById('matricula').value.trim();

    if (!/^\d{5}$/.test(matricula)) {
        alert('La matrícula debe tener 5 dígitos numéricos (ejemplo: 00001)');
        return;
    }

    fetch('crud_cal.php?action=leer&id_alumno=' + parseInt(matricula))
        .then(res => res.json())
        .then(data => {
            tabla.innerHTML = '';

            if (!data.length) {
                infoAlumno.classList.add('d-none');
                tabla.innerHTML = '<tr><td colspan="5" class="text-center">Sin resultados</td></tr>';
                return;
            }

            infoAlumno.classList.remove('d-none');
            infoMatricula.textContent = data[0].id_alumno.toString().padStart(5, '0');
            infoNombre.textContent = data[0].nombre_completo ? ? 'Nombre no disponible';

            idAlumnoGlobal = data[0].id_alumno;
            materiasAlumno = data;

            data.forEach(item => {
                tabla.innerHTML += `
          <tr>
            <td>${item.nombre_materia}</td>
            <td>${item.periodo1 ?? '-'}</td>
            <td>${item.periodo2 ?? '-'}</td>
            <td>${item.prom_final ?? '-'}</td>
            <td><button class="btn btn-sm btn-warning btnEditar">Editar</button></td>
          </tr>
        `;
            });
            
            document.querySelectorAll('.btnEditar').forEach((btn, i) => {
                btn.addEventListener('click', () => abrirModalEditar(i));
            });
        })
        .catch(() => {
            alert('Error al conectar con el servidor');
        });
});

function abrirModalEditar(index) {
    modalTablaMaterias.innerHTML = '';

    if (!idAlumnoGlobal) {
        alert('Primero busca la matrícula del alumno');
        return;
    }

    materiasAlumno.forEach(mat => {
        modalTablaMaterias.innerHTML += `
      <tr>
        <td>${mat.nombre_materia}</td>
        <td>
          <input type="number" min="0" max="100" step="1" class="form-control input-parcial1"
            data-id_grupo="${mat.id_grupo}" data-id_materia="${mat.id_materia}"
            value="${mat.periodo1 ?? ''}" />
        </td>
        <td>
          <input type="number" min="0" max="100" step="1" class="form-control input-parcial2"
            data-id_grupo="${mat.id_grupo}" data-id_materia="${mat.id_materia}"
            value="${mat.periodo2 ?? ''}" />
        </td>
        <td class="promedio">${mat.prom_final ?? '-'}</td>
      </tr>
    `;
    });

    // Función para actualizar promedio en vivo
    const inputsP1 = modalTablaMaterias.querySelectorAll('.input-parcial1');
    const inputsP2 = modalTablaMaterias.querySelectorAll('.input-parcial2');

    function actualizarPromedio() {
        for (let i = 0; i < inputsP1.length; i++) {
            const p1 = parseInt(inputsP1[i].value);
            const p2 = parseInt(inputsP2[i].value);
            const celdaProm = inputsP1[i].closest('tr').querySelector('.promedio');

            if (!isNaN(p1) && !isNaN(p2)) {
                celdaProm.textContent = Math.round((p1 + p2) / 2);
            } else {
                celdaProm.textContent = '-';
            }
        }
    }

    inputsP1.forEach(i => i.addEventListener('input', actualizarPromedio));
    inputsP2.forEach(i => i.addEventListener('input', actualizarPromedio));
    actualizarPromedio();

    modalEditar.show();
}

formEditar.addEventListener('submit', (e) => {
    e.preventDefault();

    const inputsP1 = modalTablaMaterias.querySelectorAll('.input-parcial1');
    const inputsP2 = modalTablaMaterias.querySelectorAll('.input-parcial2');

    const calificacionesActualizar = [];

    for (let i = 0; i < inputsP1.length; i++) {
        const id_grupo = inputsP1[i].dataset.id_grupo;
        const id_materia = inputsP1[i].dataset.id_materia;
        const periodo1 = parseInt(inputsP1[i].value);
        const periodo2 = parseInt(inputsP2[i].value);
        let prom_final = null;

        if (!isNaN(periodo1) && !isNaN(periodo2)) {
            prom_final = Math.round((periodo1 + periodo2) / 2);
        }

        calificacionesActualizar.push({
            id_alumno: idAlumnoGlobal,
            id_grupo: parseInt(id_grupo),
            id_materia: parseInt(id_materia),
            periodo1: isNaN(periodo1) ? null : periodo1,
            periodo2: isNaN(periodo2) ? null : periodo2,
            prom_final
        });
    }

    fetch('crud_cal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'actualizar-multiples',
                calificaciones: calificacionesActualizar
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Calificaciones actualizadas correctamente.');
                modalEditar.hide();
                btnBuscar.click();
            } else {
                alert('Error al actualizar: ' + data.message);
            }
        })
        .catch(err => {
            alert('Error en la comunicación con el servidor.');
            console.error(err);
        });
});
