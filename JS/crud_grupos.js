document.addEventListener("DOMContentLoaded", cargarGrupos);

function cargarGrupos() {
    fetch("grupos.php?action=read")
        .then(response => response.json())
        .then(data => {
            const tabla = document.getElementById("tablaGrupos");
            tabla.innerHTML = "";
            data.forEach(grupo => {
                const row = `<tr>
                <td>${grupo.id_grupo}</td>
                <td>${grupo.id_nivel}</td>
                <td>${grupo.id_aula}</td>
                <td>${grupo.id_ciclo}</td>
                <td>${grupo.id_turno}</td>
                <td>${grupo.id_maestro}</td>
                <td>
                    <button class="btn btn-danger" onclick="eliminarGrupo(${grupo.id_grupo})">Eliminar</button>
                </td>
            </tr>`;
                tabla.innerHTML += row;
            });
        });
}

function guardarGrupo() {
    const datos = {
        id_nivel: document.getElementById("id_nivel").value,
        id_aula: document.getElementById("id_aula").value,
        id_ciclo: document.getElementById("id_ciclo").value,
        id_turno: document.getElementById("id_turno").value,
        id_maestro: document.getElementById("id_maestro").value
    };

    fetch("grupos.php?action=create", {
        method: "POST",
        body: JSON.stringify(datos),
        headers: {
            "Content-Type": "application/json"
        }
    }).then(() => cargarGrupos());
}
