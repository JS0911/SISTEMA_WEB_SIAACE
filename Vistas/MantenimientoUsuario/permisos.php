<?php

session_start();
require "../../Config/conexion.php";
//require_once '../Modelos/permisoUsuario.php';

//$permisosUsuarios = new PermisosUsuarios();

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Usuario = "2";
?>
<style>
    .logo {
        width: 50px;
        /* Ancho deseado del logo */
        margin-right: 10px;
        /* Espacio a la derecha del logo para separarlo del texto */
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-Permiso {
            border-collapse: collapse; /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-Permiso th {
            border: 2px solid white; /* Bordes blancos para las celdas del encabezado */
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif; /* Cambia el tipo de letra */
            padding: 8px; /* Espaciado interno para las celdas */
            text-align: center; /* Alineación del texto al centro */
        }

        /* Estilo para las celdas de datos (td) */
        #Lista-Permiso td {
            border: 1px solid grey; /* Bordes negros para las celdas de datos */
            padding: 8px; /* Espaciado interno para las celdas */
            text-align: center; /* Alineación del texto al centro */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../../InicioSesion/cambiocontrasena.php">Cambiar Contraseña</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../InicioSesion/logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="../../InicioSesion/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Inicio
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="../charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a><a class="nav-link" href="usuarios.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Usuarios
                        </a>
                        <a class="nav-link" href="../../roles.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Roles
                        </a>
                        <a class="nav-link" href="../Vistas/MantenimientoUsuario/permisos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Permisos
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado a Sistema:</div>
                    SIAACE - IDH Microfinanciera
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE USUARIO -->
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Mantenimiento Permisos</h1>

                    <!-- Botón para abrir el formulario de creación -->
                    <?php
                    if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                        echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModalPermisos">Crear Nuevo</button>';
                    }
                    ?>

                    <!-- Tabla para mostrar los datos -->
                    <table class="table table-bordered" id="Lista-Permiso" style="background-color: lightblue;">
                        <thead>
                            <tr>
                                <th>Id Rol</th>
                                <th>Id Objeto</th>
                                <th>Permisos Inserción</th>
                                <th>Permisos Eliminación</th>
                                <th>Permisos Actualización</th>
                                <th>Permisos Consultar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- Modal para crear un nuevo registro -->
                <div class="modal fade" id="crearModalPermiso" tabindex="-1" role="dialog" aria-labelledby="crearModalPermisoLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalPermisoLabel">Crear Nuevo Permiso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Id Rol</label>
                                        <input type="text" class="form-control" id="agregar-idRol">

                                        <label for="nombre">Id Objeto</label>
                                        <input type="text" class="form-control" id="agregar-idObjeto">

                                        <label for="estado">Permisos Inserción</label>
                                        <input type="text" class="form-control" id="agregar-pInsercion">

                                        <label for="estado">Permisos Eliminación</label>
                                        <input type="text" class="form-control" id="agregar-pEliminacion">

                                        <label for="estado">Permisos Actualización</label>
                                        <input type="text" class="form-control" id="agregar-pActualizacion">

                                        <label for="estado">Permisos Consultar</label>
                                        <input type="password" class="form-control" id="agregar-pConsultar">

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="btn-agregarPermiso">Guardar</button>
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
                                        <label for="nombre">Id Usuario</label>
                                        <input type="text" class="form-control" id="editar-id-usuario">
                                        <label for="nombre">Usuario</label>
                                        <input type="text" class="form-control" id="editar-usuario">
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
                                <button type="button" class="btn btn-primary" onclick="updateUsuario()">Guardar
                                    Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE USUARIO -->

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </script>
   
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/datatables-demo.js"></script>
</body>

</html>