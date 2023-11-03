<?php

session_start();
require "../../Config/conexion.php";
require_once '../../Modelos/permisoUsuario.php';

$permisosUsuarios = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Usuario = "2";
$id_objeto_Seguridad = "25";
$id_objeto_Cuentas = "28";

$permisos1 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisos2 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);

//---------CONEXION A LA TABLA ROLES --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();
// Consultar la contraseña actual del usuario desde la base de datos
$sql = "SELECT id_rol ,rol FROM tbl_ms_roles";
$sql1 = "SELECT ID_ESTADO_USUARIO, NOMBRE FROM tbl_ms_estadousuario";
$stmt = $conn->prepare($sql);
$stmt1 = $conn->prepare($sql1);

$stmt->execute();
$stmt1->execute();

// Obtener los resultados en un array asociativo
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$Estados = $stmt1->fetchAll(PDO::FETCH_ASSOC);



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
    <title>Mantenimiento Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-Usuarios {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-Usuarios th {
            border: 2px solid white;
            /* Bordes negros para las celdas del encabezado */
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
            /* Cambia el tipo de letra */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
        }

        /* Estilo para las celdas de datos (td) */
        #Lista-Usuarios td {
            border: 1px solid grey;
            /* Bordes negros para las celdas de datos */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
        }

        /* Estilo personalizado para el placeholder */
        #myInput {
            border: 2px solid #000;
            /* Borde más oscuro, en este caso, negro (#000) */

        }

        /* BOTON DE CREAR NUEVO */
        .custom-button {
            background-color: #4CAF50;
            /* Verde */
            color: #fff;
            /* Texto en blanco */
            border: 2px solid #4CAF50;
            /* Borde verde */
            margin-top: 1px;

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
                        <div class="sb-sidenav-menu-heading">Pestañas</div>
                        <?php
                        if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Modulo seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                echo '<a class="nav-link" href="roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                echo '<a class="nav-link" href="permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                echo '<a class="nav-link" href="bitacora.php"><i class="fa fa-book" aria-hidden="true"></i></i><span style="margin-left: 5px;"> Bitacora </a>';
                            }


                            echo '</nav>';
                            echo '</div>';
                        }

                        //-------------------------MODULO DE EMPLEADO---------------------------------------------
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Modulo Empleado
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE CUENTAS------------------------------------
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoCuentas" aria-expanded="false" aria-controls="collapseMantenimientoCuentas">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Modulo Cuenta
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoCuentas" aria-labelledby="headingMantenimientoCuentas" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoCuentas/tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                echo '<a class="nav-link" href="../MantenimientoCuentas/tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de cuenta</a>';
                                echo '<a class="nav-link" href="../MantenimientoCuentas/MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de cuenta</a>';
                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE PRESTAMOS------------------------------------
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoPrestamo" aria-expanded="false" aria-controls="collapseMantenimientoPrestamo">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>
                            Modulo Prestamo
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoPrestamo" aria-labelledby="headingMantenimientoPrestamo" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Prestamo</a>';
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        ?>
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


                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Usuario</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success" data-toggle="modal" data-target="#crearModal"> Nuevo</button>';
                            }
                            ?>
                        </div>

                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-Usuarios" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id Usuario</th>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th style="display: none;">Id Estado Usuario</th>
                                    <th>Correo Electrónico</th>
                                    <th style="display: none;">Id Rol</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

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
                                        <input type="text" maxlength="15" class="form-control" id="agregar-usuario" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje1"></div>

                                        <label for="nombre">Nombre</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-nombre" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        <label for="id-estado">Estado</label>
                                        <select class="form-control" id="agregar-estado" name="IdEstado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <?php foreach ($Estados as $Estado) : ?>
                                                <option value="<?php echo $Estado['ID_ESTADO_USUARIO']; ?>"><?php echo $Estado['NOMBRE']; ?></option>
                                            <?php endforeach; ?>
                                            <div id="mensaje3"></div>
                                        </select>

                                        <label for="agregar-correo">Correo Electrónico</label>
                                        <input type="email" maxlength="50" class="form-control" id="agregar-correo" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ingrese una dirección de correo electrónico válida" />
                                        <div id="mensaje4"></div>

                                        <label for="id-rol">Rol</label>
                                        <select class="form-control" id="agregar-rol" name="IdRol" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <?php foreach ($roles as $rol) : ?>
                                                <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['rol']; ?></option>
                                            <?php endforeach; ?>
                                            <div id="mensaje5"></div>
                                        </select>



                                        <label for="estado">Contraseña</label>
                                        <input type="password" maxlength="100" class="form-control" id="agregar-contrasena" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" />
                                        <div id="mensaje6"></div>

                                        <label for="estado">Confirmar Contraseña</label>
                                        <input type="password" maxlength="100" class="form-control" id="confirmar-contrasena" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" />
                                        <div id="mensaje7"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-agregar" disabled>Guardar</button>
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
                                        <input type="text" class="form-control" id="editar-id-usuario" disabled>
                                        <label for="nombre">Usuario</label>

                                        <input type="text" maxlength="15" class="form-control" id="editar-usuario" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje8"></div>

                                        <label for="nombre">Nombre</label>
                                        <input type="text" maxlength="100" class="form-control" id="editar-nombre" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje9"></div>

                                        <label for="estado">Estado</label>
                                        <select class="form-control" id="editar-estado" name="IdEstado" required>
                                            <option value="">Selecciona una opción</option>
                                            <?php foreach ($Estados as $Estado) : ?>
                                                <option value="<?php echo $Estado['ID_ESTADO_USUARIO']; ?>"><?php echo $Estado['NOMBRE']; ?></option>
                                            <?php endforeach; ?>
                                            <div id="mensaje10"></div>
                                        </select>
                                        <label for="estado">Correo Electronico</label>
                                        <input type="text" maxlength="50" class="form-control" id="editar-correo" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ingrese una dirección de correo electrónico válida" />
                                        <div id="mensaje11"></div>
                                        <?php
                                        //---------TRAER ROLES Y ESTADOS --------
                                        // Crear una instancia de la clase Conectar
                                        $conexion = new Conectar();
                                        $conn = $conexion->Conexion();

                                        // Consultar la contraseña actual del usuario desde la base de datos
                                        $sql = "SELECT id_rol ,rol FROM tbl_ms_roles";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Obtener los resultados en un array asociativo
                                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>

                                        <!------- SELECT DE ROLES -------------->
                                        <label for="id-rol">Rol</label>
                                        <select class="form-control" id="editar-rol" name="IdRol" required>
                                            <option value="">Selecciona una opción</option>
                                            <?php foreach ($roles as $rol) : ?>
                                                <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['rol']; ?></option>
                                            <?php endforeach; ?>
                                            <div id="mensaje12"></div>
                                        </select>



                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateUsuario()" disabled>Guardar </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE USUARIO -->

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-start justify-content-center small">
                        <div class="text-muted">Copyright &copy; IA-UNAH 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- EL CODIGO ESTA QUEMADO AQUI, NO FUNCIONA REFERENCIA A LOS ARCHIVOS -->
    <script>
        var permisos = <?php echo json_encode($permisos); ?>;

        function Lista_Usuarios() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=GetUsuarios', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    if (response.ok) {
                        // Si la solicitud fue exitosa, puedes manejar la respuesta aquí
                        return response.json();
                    } else {
                        // Si hubo un error en la solicitud, maneja el error aquí
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(data) {
                    // Recorre los datos JSON y agrega filas a la tabla
                    var tbody = document.querySelector('#Lista-Usuarios tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(usuario) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + usuario.ID_USUARIO + '</td>' +
                            '<td>' + usuario.USUARIO + '</td>' +
                            '<td>' + usuario.NOMBRE_USUARIO + '</td>' +
                            '<td style="display:none;">' + usuario.ID_ESTADO_USUARIO + '</td>' +
                            '<td>' + usuario.CORREO_ELECTRONICO + '</td>' +
                            '<td style="display:none;">' + usuario.ID_ROL + '</td>' +
                            '<td>' + usuario.ROL + '</td>' +
                            '<td>' + usuario.NOMBRE + '</td>' + //AQUI DEBERIA DE SER ESTADO 
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarUsuario(' + usuario.ID_USUARIO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-usuario" data-id="' + usuario.ID_USUARIO + '" onclick="eliminarUsuario(' + usuario.ID_USUARIO + ')">Eliminar</button>';
                        }


                        row += '</td>' +
                            '</tr>';
                        //Cambiar palabra null por vacio.
                        newrow = row.replaceAll("null", " ");
                        tbody.innerHTML += row;
                    });
                    habilitarPaginacion();

                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }

        function habilitarPaginacion() {
            $('#Lista-Usuarios').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Usuario() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var usuario = $("#agregar-usuario").val();
                var nombre = $("#agregar-nombre").val();
                var estado = $("#agregar-estado").val();
                var correo = $("#agregar-correo").val();
                var rol = $("#agregar-rol").val();
                var contrasena = $("#agregar-contrasena").val();
                var confirmarContrasena = $("#confirmar-contrasena").val();

                if (usuario == "" || nombre == "" || correo == "" || contrasena == "" || confirmarContrasena == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    })
                }
                // Verificar que las contraseñas coincidan
                if (contrasena !== confirmarContrasena) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.'
                    });
                    return;
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        USUARIO: usuario,
                        NOMBRE_USUARIO: nombre,
                        ID_ESTADO_USUARIO: estado,
                        CORREO_ELECTRONICO: correo,
                        ID_ROL: rol,
                        CONTRASENA: contrasena
                    }
                };

                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=InsertUsuarios', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(datos)
                    })
                    .then(function(response) {
                        if (response.ok) {
                            // Si la solicitud fue exitosa, puedes manejar la respuesta aquí
                            return response.json();
                        } else {
                            // Si hubo un error en la solicitud, maneja el error aquí
                            throw new Error('Error en la solicitud');
                        }
                    })
                    .then(function(data) {
                        console.log(data);

                        // Cerrar la modal después de guardar
                        $('#crearModal').modal('hide');

                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado exitoso',
                            text: 'Los datos se han guardado correctamente.'
                        }).then(function() {
                            // Recargar la página para mostrar los nuevos datos
                            location.reload();
                        });

                    })
                    .catch(function(error) {
                        console.log(error.message);

                        // Mostrar SweetAlert de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al guardar los datos: ' + error.message
                        });
                    });
            });
        }

        function cargarUsuario(id) {
            // Crear un objeto con el ID del usuario
            var data = {
                "ID_USUARIO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del usuario por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=GetUsuario', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el objeto en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(usuario) {
                    // Llena los campos del modal con los datos del usuario
                    document.getElementById('editar-id-usuario').value = usuario.ID_USUARIO;
                    document.getElementById('editar-usuario').value = usuario.USUARIO;
                    document.getElementById('editar-nombre').value = usuario.NOMBRE_USUARIO;
                    document.getElementById('editar-estado').value = usuario.ID_ESTADO_USUARIO;
                    document.getElementById('editar-correo').value = usuario.CORREO_ELECTRONICO;
                    document.getElementById('editar-rol').value = usuario.ID_ROL;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del usuario: ' + error.message);
                });
        }

        function updateUsuario() {
            // Obtén el ID del usuario 
            var idUsuario = document.getElementById('editar-id-usuario').value;
            // Obtén los valores de los campos de edición
            var usuario = document.getElementById('editar-usuario').value;
            var nombre = document.getElementById('editar-nombre').value;
            var estado = document.getElementById('editar-estado').value;
            var correo = document.getElementById('editar-correo').value;
            var rol = document.getElementById('editar-rol').value;

            // Realiza una solicitud FETCH para actualizar los datos del usuario
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=updateUsuario', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_USUARIO": idUsuario,
                        "USUARIO": usuario,
                        "NOMBRE_USUARIO": nombre,
                        "ID_ESTADO_USUARIO": estado,
                        "CORREO_ELECTRONICO": correo,
                        "ID_ROL": rol
                    }) // Convierte los datos en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        // Cerrar la modal después de guardar
                        $('#editarModal').modal('hide');

                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualización exitosa',
                            text: 'Los datos se han actualizado correctamente.'
                        }).then(function() {
                            // Recargar la página para mostrar los nuevos datos
                            location.reload();
                        });

                    } else {
                        throw new Error('Error en la solicitud de actualización');
                    }
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    console.log(error.message);

                    // Mostrar SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar los datos del usuario: ' + error.message
                    });
                });
        }


        //FUNCION CON EL SWEETALERT
        function eliminarUsuario(idUsuario) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://localhost:90/SISTEMA1/Controladores/usuarios.php?op=eliminarUsuario', {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_USUARIO": idUsuario
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Error en la solicitud de verificación');
                            }
                        })
                        .then(function(data) {
                            if (data == "23000") {
                                Swal.fire('El usuario no puede ser eliminado', '', 'info')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de usuarios después de eliminar

                                        // Si no se puede eliminar el estado se debe estado a  "Inactivo"

                                    });
                            } else {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Usuario eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de usuarios después de eliminar
                                        //Lista_Usuarios();
                                    });
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el usuario: ' + error.message, 'error');
                        });
                }
            });
        }

        function validarNombre() {
            // console.log("entra a ValidarNombre");
            usuario = document.getElementById("agregar-usuario");
            nombre = document.getElementById("agregar-nombre");
            estado = document.getElementById("agregar-estado");
            correo = document.getElementById("agregar-correo");
            rol = document.getElementById("agregar-rol");
            contrasena = document.getElementById("agregar-contrasena");
            confirmarContrasena = document.getElementById("confirmar-contrasena");

            usuarioEditar = document.getElementById('editar-usuario');
            nombreEditar = document.getElementById('editar-nombre');
            estadoEditar = document.getElementById('editar-estado');
            correoEditar = document.getElementById('editar-correo');
            rolEditar = document.getElementById('editar-rol');



            usuario.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    usuario.style.borderColor = "red";
                    usuario.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje1").style.color = "red";
                    e.preventDefault();
                } else {
                    usuario.style.borderColor = "green";
                    usuario.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje1").style.color = "green";
                }
            });

            nombre.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    nombre.style.borderColor = "red";
                    nombre.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje2").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        nombre.style.borderColor = "red";
                        nombre.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje2").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        nombre.style.borderColor = "green";
                        nombre.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje2").style.color = "green";
                    }
                }
            });

            estado.addEventListener("change", function() {
                if (estado.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    estado.style.borderColor = "red";
                    estado.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un estado.";
                    document.getElementById("mensaje3").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    estado.style.borderColor = "green";
                    estado.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-check-circle'></i> Estado seleccionado.";
                    document.getElementById("mensaje3").style.color = "green";
                }
            });

            correo.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Za-z0-9.!@#$%^&*]+$/;


                if (!expresionValidadora2.test(e.key)) {
                    correo.style.borderColor = "red";
                    correo.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite email valido";
                    document.getElementById("mensaje4").style.color = "red";
                    e.preventDefault();
                } else {
                    correo.style.borderColor = "green";
                    correo.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje4").style.color = "green";
                }
            });



            rol.addEventListener("change", function() {
                if (rol.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    rol.style.borderColor = "red";
                    rol.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un rol.";
                    document.getElementById("mensaje5").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    rol.style.borderColor = "green";
                    rol.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-check-circle'></i> Rol seleccionado.";
                    document.getElementById("mensaje5").style.color = "green";
                }
            });

            contrasena.addEventListener("keypress", function(e) {
                expresionValidadora3 = /^[A-Za-z0-9!@#$%^&*]+$/;


                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    contrasena.style.borderColor = "red";
                    contrasena.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje6").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje6").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        contrasena.style.borderColor = "red";
                        contrasena.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje6").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje6").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        descripcion.style.borderColor = "green";
                        descripcion.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje6").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje6").style.color = "green";
                    }
                }
            });

            confirmarContrasena.addEventListener("keypress", function(e) {
                expresionValidadora3 = /^[A-Za-z0-9!@#$%^&*]+$/;

                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    confirmarContrasena.style.borderColor = "red";
                    confirmarContrasena.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje7").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        confirmarContrasena.style.borderColor = "red";
                        confirmarContrasena.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayúsculas, números y ciertos caracteres especiales.";
                        document.getElementById("mensaje7").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        confirmarContrasena.style.borderColor = "green";
                        confirmarContrasena.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                        document.getElementById("mensaje7").style.color = "green";
                    }
                }
            });

            //-------------------------MODAL DE EDITAR---------------------------------------

            usuarioEditar.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    usuarioEditar.style.borderColor = "red";
                    usuarioEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje8").style.color = "red";
                    e.preventDefault();
                } else {
                    usuarioEditar.style.borderColor = "green";
                    usuarioEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje8").style.color = "green";
                }
            });

            nombreEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    nombreEditar.style.borderColor = "red";
                    nombreEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje9").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje9").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        nombreEditar.style.borderColor = "red";
                        nombreEditar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje9").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje9").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        nombreEditar.style.borderColor = "green";
                        nombreEditar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje9").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje9").style.color = "green";
                    }
                }
            });

            estadoEditar.addEventListener("change", function() {
                if (estadoEditar.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    estadoEditar.style.borderColor = "red";
                    estadoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un estado.";
                    document.getElementById("mensaje10").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    estadoEditar.style.borderColor = "green";
                    estadoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-check-circle'></i> Estado seleccionado.";
                    document.getElementById("mensaje10").style.color = "green";
                }
            });

            correoEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Za-z0-9.!@#$%^&*]+$/;


                if (!expresionValidadora2.test(e.key)) {
                    correoEditar.style.borderColor = "red";
                    correoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje11").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite email valido";
                    document.getElementById("mensaje11").style.color = "red";
                    e.preventDefault();
                } else {
                    correoEditar.style.borderColor = "green";
                    correoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje11").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje11").style.color = "green";
                }
            });



            rolEditar.addEventListener("change", function() {
                if (rolEditar.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    rolEditar.style.borderColor = "red";
                    rolEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje12").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un rol.";
                    document.getElementById("mensaje12").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    rolEditar.style.borderColor = "green";
                    rolEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje12").innerHTML = "<i class='fas fa-check-circle'></i> Rol seleccionado.";
                    document.getElementById("mensaje12").style.color = "green";
                }
            });

        }

        $(document).ready(function() {
            Lista_Usuarios();
            Insertar_Usuario();
            validarNombre();
        });
    </script>
    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const usuarioInput = document.getElementById("agregar-usuario");
        const nombreInput = document.getElementById("agregar-nombre");
        const estadoInput = document.getElementById("agregar-estado");
        const correoInput = document.getElementById("agregar-correo");
        const rolInput = document.getElementById("agregar-rol");
        const contrasenaInput = document.getElementById("agregar-contrasena");
        const confirmarContrasenaInput = document.getElementById("confirmar-contrasena");
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = usuarioInput.value.trim() !== '' && nombreInput.value.trim() !== '' && estadoInput.value !== '' &&
                estadoInput.value.trim() !== '' && correoInput.value.trim() !== '' && rolInput.value !== '' &&
                contrasenaInput.value.trim() !== '' && confirmarContrasenaInput.value.trim() !== '';

            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        usuarioInput.addEventListener('input', checkForm);
        nombreInput.addEventListener('input', checkForm);
        estadoInput.addEventListener('input', checkForm);
        correoInput.addEventListener('input', checkForm);
        rolInput.addEventListener('input', checkForm);
        contrasenaInput.addEventListener('input', checkForm);
        confirmarContrasenaInput.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar de Editar"
        const usuarioInput1 = document.getElementById("editar-usuario");
        const nombreInput1 = document.getElementById("editar-nombre");
        const estadoInput1 = document.getElementById("editar-estado");
        const correoInput1 = document.getElementById("editar-correo");
        const rolInput1 = document.getElementById("editar-rol");
        const guardarButton1 = document.getElementById('btn-editar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = usuarioInput1.value.trim() !== '' && nombreInput1.value.trim() !== '' && estadoInput1.value !== '' &&
                estadoInput1.value.trim() !== '' && correoInput1.value.trim() !== '' && rolInput1.value !== '';

            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        usuarioInput1.addEventListener('input', checkForm);
        nombreInput1.addEventListener('input', checkForm);
        estadoInput1.addEventListener('input', checkForm);
        correoInput1.addEventListener('input', checkForm);
        rolInput1.addEventListener('input', checkForm);
    </script>
    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-usuario, #agregar-correo, #agregar-contrasena,#agregar-contrasena').on('input', function() {
            var input = $(this);
            var trimmedValue = input.val().trim();
            input.val(trimmedValue);

            if (trimmedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'El campo no puede estar vacío',
                    icon: 'warning',
                });
            }
        });

        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#editar-usuario, #editar-correo').on('input', function() {
            var input = $(this);
            var trimmedValue = input.val().trim();
            input.val(trimmedValue);

            if (trimmedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'El campo no puede estar vacío',
                    icon: 'warning',
                });
            }
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL AGREGAR--------------------
        document.getElementById('btn-cancelarAgregar').addEventListener('click', function() {
            document.getElementById("agregar-usuario").value = "";
            document.getElementById("agregar-nombre").value = "";
            document.getElementById("agregar-estado").value = "";
            document.getElementById("agregar-correo").value = "";
            document.getElementById("agregar-rol").value = "";
            document.getElementById("agregar-contrasena").value = "";
            document.getElementById("confirmar-contrasena").value = "";

            // Recargar la página para mostrar los nuevos datos PARA QUITAR LOS MENSAJES
            location.reload();


        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {


            document.getElementById("editar-usuario").value = "";
            document.getElementById("editar-nombre").value = "";
            document.getElementById("editar-estado").value = "";
            document.getElementById("editar-correo").value = "";
            document.getElementById("editar-rol").value = "";

            // Recargar la página para mostrar los nuevos datos PARA QUITAR LOS MENSAJES
            location.reload();


        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>

</html>