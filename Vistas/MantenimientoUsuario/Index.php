<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con Bootstrap</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <header>
        <?php
            require_once('../../header.php');
        ?>
    </header>
</head>
<body>
    
    <div class="container mt-5">
        <h1>Lista De Usuarios</h1>
        <hr>

        <!-- Botón para abrir el formulario de creación -->
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Crear Nuevo</button>

        <!-- Tabla para mostrar los datos -->
        <table class="table table-bordered" id="Lista-Usuarios">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Correo Electronico</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>

    <!-- Modal para crear un nuevo registro -->
    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearModalLabel">Crear Nuevo Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de creación -->
                    <form>
                        <div class="form-group">
                            <label for="nombre">Usuario</label>
                            <input type="text" class="form-control" id="agregar-usuario">

                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="agregar-nombre">

                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="agregar-estado">

                            <label for="estado">Correo Electronico</label>
                            <input type="text" class="form-control" id="agregar-correo">

                            <label for="estado">Rol</label>
                            <input type="text" class="form-control" id="agregar-rol">

                            <label for="estado">Contraseña</label>
                            <input type="password" class="form-control" id="agregar-contrasena">

                            <label for="estado">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmar-contrasena">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn-agregar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar un registro -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Registro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición -->
                    <form>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="editar-nombre">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="editar-estado">
                            <label for="estado">Correo Electronico</label>
                            <input type="text" class="form-control" id="editar-correo">
                            <label for="estado">Rol</label>
                            <input type="text" class="form-control" id="editar-rol">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php
            require_once('../../footer.php');
        ?>
    </footer>

    <script src="Insertar_Usuario.js"></script>
    <script src="Lista_Usuarios.js"></script>

</body>
</html>


