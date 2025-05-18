<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Gestión de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="p-4">

    <h2>GESTIÓN DE USUARIOS</h2>

    <div class="mb-3">
        <input type="text" id="matricula" placeholder="CURP" class="form-control" maxlength="5" />
    </div>
    <button id="btnBuscar" class="btn btn-primary mb-3">Buscar</button>

    <div id="infoAlumno" class="mb-3 d-none">
        <strong>Matrícula:</strong> <span id="infoMatricula"></span><br />
        <strong>Nombre:</strong> <span id="infoNombre"></span>
    </div>

    <table class="table table-bordered" id="tablaCalificaciones">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>CURP</th>
                <th>Nombre completo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Estado</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formEditar" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Calificaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="modalTablaMaterias">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/crud_cal.js"></script>

</body>

</html>