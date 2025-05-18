<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPOS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="script.js" defer></script>
</head>

<body class="container mt-4">
    <h1 class="text-center">GESTIÓN DE GRUPOS</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar Grupo</button>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Grupo</th>
                <th>Nivel</th>
                <th>Aula</th>
                <th>Ciclo Escolar</th>
                <th>Turno</th>
                <th>Maestro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaGrupos"></tbody>
    </table>

    <!-- Modal para Agregar Grupo -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" id="id_nivel" placeholder="ID Nivel">
                    <input type="text" class="form-control mb-2" id="id_aula" placeholder="ID Aula">
                    <input type="text" class="form-control mb-2" id="id_ciclo" placeholder="ID Ciclo Escolar">
                    <input type="text" class="form-control mb-2" id="id_turno" placeholder="ID Turno">
                    <input type="text" class="form-control mb-2" id="id_maestro" placeholder="ID Maestro">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="guardarGrupo()" data-bs-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>