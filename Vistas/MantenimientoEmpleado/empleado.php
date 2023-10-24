<?php

session_start();
require "../../Config/conexion.php";
require_once '../../Modelos/permisoUsuario.php';

$permisosEmpleado = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Empleado = "7";
$id_objeto_Cuentas = "28";
$id_objeto_Seguridad = "25";

$permisos1 = $permisosEmpleado->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosEmpleado->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos2 = $permisosEmpleado->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);

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
    <title>Mantenimiento Empleados</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-Empleados {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-Empleados th {
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
        #Lista-Empleados td {
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
                                echo '<a class="nav-link" href="../MantenimientoUsuario/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
                            }


                            echo '</nav>';
                            echo '</div>';
                        }
                        //------------------------MODULO DE EMPLEADO--------------------------------
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Modulo Empleado
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                echo '<a class="nav-link" href="cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                echo '<a class="nav-link" href="region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                echo '<a class="nav-link" href="sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
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
                            <h1 class="mt-4 mb-4">Mantenimiento Empleado</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success" data-toggle="modal" data-target="#crearModal"> Nuevo</button>';
                            }
                            ?>
                        </div>

                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-Empleados" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id Empleado</th>
                                    <th>DNI</th>
                                    <th>Primer Nombre</th>
                                    <th>Segundo Nombre</th>
                                    <th>Primer Apellido</th>
                                    <th>Segundo Apellido</th>
                                    <th>Email</th>
                                    <th>Salario</th>
                                    <th>Estado</th>
                                    <th>Telefono</th>
                                    <th>Direccion1</th>
                                    <th>Direccion2</th>
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
                                        <label for="dni">DNI </label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-dni" required oninput="this.value = this.value.replace(/\s/g, '').replace(/[^0-9]/g, '')" title="Solo se aceptan números">
                                        <div id="mensaje1"></div>



                                        <label for="Pnombre">Primer Nombre</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-Pnombre" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        <label for="Snombre">Segundo Nombre</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-Snombre" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje3"></div>

                                        <label for="Papellido">Primer Apellido</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-Papellido" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje4"></div>

                                        <label for="Sapellido">Segundo Apellido</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-Sapellido" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje5"></div>


                                        <label for="agregar-email">Email</label>
                                        <input type="email" maxlength="45" class="form-control" id="agregar-email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ingrese una dirección de correo electrónico válida">
                                        <div id="mensaje6"></div>

                                        <label for="salario">Salario</label>
                                        <input type="text" class="form-control" id="agregar-salario" pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un salario válido (hasta 8 dígitos enteros y 2 decimales)">

                                        <div id="mensaje7"></div>

                                        <label for="Estado">Estado</label>
                                        <select class="form-control" id="agregar-estado" maxlength="15" name="IdEstado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                            <option value="Nuevo">Nuevo</option>
                                        </select>
                                        <div id="mensaje8"></div>

                                        <label for="telefono">Teléfono</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-telefono" pattern="^[0-9-]+$" title="Ingrese un número de teléfono válido (solo números y -)">
                                        <div id="mensaje9"></div>


                                        <label for="direccion1">Dirección 1</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-direccion1" pattern="[A-Z\s.,-]+" title="Ingrese una dirección válida (mayúsculas y caracteres) ">
                                        <div id="mensaje10"></div>

                                        <label for="direccion2">Dirección 2</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-direccion2" pattern="[A-Z\s.,-]+" title="Ingrese una dirección válida (mayúsculas y caracteres) ">
                                        <div id="mensaje11"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-agregarCancelar" data-dismiss="modal">Cancelar</button>
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
                                        <label for="idEmpleado">Id Empleado</label>
                                        <input type="text" class="form-control" id="editar-id-empleado" disabled>

                                        <label for="dni">DNI </label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-dni" <!-- required oninput="this.value = this.value.replace(/\s/g, '').replace(/[^0-9]/g, '')" -->
                                        <div id="mensaje12"></div>


                                        <label for="Pnombre">Primer Nombre</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-Pnombre" <!-- required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()" -->
                                        <div id="mensaje13"></div>

                                        <label for="Snombre">Segundo Nombre</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-Snombre" <!-- required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()" -->
                                        <div id="mensaje14"></div>

                                        <label for="Papellido">Primer Apellido</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-Papellido" <!-- required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()" -->
                                        <div id="mensaje15"></div>

                                        <label for="Sapellido">Segundo Apellido</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-Sapellido" <!-- required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()" -->
                                        <div id="mensaje16"></div>


                                        <label for="agregar-email">Email</label>
                                        <input type="email" maxlength="45" class="form-control" id="editar-email" <!-- required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ingrese una dirección de correo electrónico válida -->">
                                        <div id="mensaje17"></div>

                                        <label for="salario">Salario</label>
                                        <input type="text" class="form-control" id="editar-salario" <!-- pattern="[0-9]+(\.[0-9][0-9])?" title="Ingrese un salario válido (por ejemplo, 1000.00) -->"> <!-- oninput="formatSalary(this)"" -->
                                        <div id="mensaje18"></div>

                                        <label for="Estado">Estado</label>
                                        <select class="form-control" id="editar-estado" maxlength="15" name="estado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                            <option value="Nuevo">Nuevo</option>
                                        </select>
                                        <div id="mensaje19"></div>

                                        <label for="telefono">Teléfono</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-telefono" <!-- pattern="^[0-9-]+$" title="Ingrese un número de teléfono válido (solo números y -) -->">
                                        <div id="mensaje20"></div>


                                        <label for="direccion1">Dirección 1</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-direccion1" <!-- pattern="[A-Z\s.,-]+" title="Ingrese una dirección válida (mayúsculas y caracteres) -->">
                                        <div id="mensaje21"></div>

                                        <label for="direccion2">Dirección 2</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-direccion2" <!-- pattern="[A-Z\s.,-]+" title="Ingrese una dirección válida (mayúsculas y caracteres) -->">
                                        <div id="mensaje22"></div>


                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-editarCancelar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateEmpleado()">Guardar </button>
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

        function Lista_Empleados() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=GetEmpleados', {
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
                    var tbody = document.querySelector('#Lista-Empleados tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(empleado) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + empleado.ID_EMPLEADO + '</td>' +
                            '<td>' + empleado.DNI + '</td>' +
                            '<td>' + empleado.PRIMER_NOMBRE + '</td>' +
                            '<td>' + empleado.SEGUNDO_NOMBRE + '</td>' +
                            '<td>' + empleado.PRIMER_APELLIDO + '</td>' +
                            '<td>' + empleado.SEGUNDO_APELLIDO + '</td>' +
                            '<td>' + empleado.EMAIL + '</td>' +
                            '<td>' + empleado.SALARIO + '</td>' +
                            '<td>' + empleado.ESTADO + '</td>' +
                            '<td>' + empleado.TELEFONO + '</td>' +
                            '<td>' + empleado.DIRECCION1 + '</td>' +
                            '<td>' + empleado.DIRECCION2 + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargaEmpleado(' + empleado.ID_EMPLEADO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-empleado" data-id="' + empleado.ID_EMPLEADO + '" onclick="eliminarEmpleado(' + empleado.ID_EMPLEADO + ')">Eliminar</button>';
                        }


                        row += '</td>' +
                            '</tr>';
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
            $('#Lista-Empleados').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Empleado() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var dni = $("#agregar-dni").val();
                var Pnombre = $("#agregar-Pnombre").val();
                var Snombre = $("#agregar-Snombre").val();
                var Papellido = $("#agregar-Papellido").val();
                var Sapellido = $("#agregar-Sapellido").val();
                var email = $("#agregar-email").val();
                var salario = $("#agregar-salario").val();
                var estado = document.getElementById("agregar-estado").value; // Obtener el valor del select
                var telefono = $("#agregar-telefono").val();
                var direccion1 = $("#agregar-direccion1").val();
                var direccion2 = $("#agregar-direccion2").val();

                if (dni == "" || Pnombre == "" || Snombre == "" || Papellido == "" || Sapellido == "" ||
                    email == "" || salario == "" || estado == "" || telefono == "" || direccion1 == "" || direccion2 == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        DNI: dni,
                        PRIMER_NOMBRE: Pnombre,
                        SEGUNDO_NOMBRE: Snombre,
                        PRIMER_APELLIDO: Papellido,
                        SEGUNDO_APELLIDO: Sapellido,
                        EMAIL: email,
                        SALARIO: salario,
                        ESTADO: estado,
                        TELEFONO: telefono,
                        DIRECCION1: direccion1,
                        DIRECCION2: direccion2
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=InsertEmpleado', {
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
                }
            });
        }


        function cargaEmpleado(id) {
            // Crear un objeto con el ID del usuario
            var data = {
                "ID_EMPLEADO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del usuario por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=GetEmpleado', {
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
                .then(function(empleado) {
                    // Llena los campos del modal con los datos del usuario
                    document.getElementById('editar-id-empleado').value = empleado.ID_EMPLEADO;
                    document.getElementById('editar-dni').value = empleado.DNI;
                    document.getElementById('editar-Pnombre').value = empleado.PRIMER_NOMBRE;
                    document.getElementById('editar-Snombre').value = empleado.SEGUNDO_NOMBRE;
                    document.getElementById('editar-Papellido').value = empleado.PRIMER_APELLIDO;
                    document.getElementById('editar-Sapellido').value = empleado.SEGUNDO_APELLIDO;
                    document.getElementById('editar-email').value = empleado.EMAIL;
                    document.getElementById('editar-salario').value = empleado.SALARIO;
                    document.getElementById('editar-estado').value = empleado.ESTADO;
                    document.getElementById('editar-telefono').value = empleado.TELEFONO;
                    document.getElementById('editar-direccion1').value = empleado.DIRECCION1;
                    document.getElementById('editar-direccion2').value = empleado.DIRECCION2;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del empleado: ' + error.message);
                });
        }

        function updateEmpleado() {
            // Obtén el ID del usuario 
            var idEmpleado = document.getElementById('editar-id-empleado').value;
            // Obtén los valores de los campos de edición
            var dni = document.getElementById('editar-dni').value;
            var Pnombre = document.getElementById('editar-Pnombre').value;
            var Snombre = document.getElementById('editar-Snombre').value;
            var Papellido = document.getElementById('editar-Papellido').value;
            var Sapellido = document.getElementById('editar-Sapellido').value;
            var email = document.getElementById('editar-email').value;
            var salario = document.getElementById('editar-salario').value;
            var estado = document.getElementById('editar-estado').value;
            var telefono = document.getElementById('editar-telefono').value;
            var direccion1 = document.getElementById('editar-direccion1').value;
            var direccion2 = document.getElementById('editar-direccion2').value;

            // Realiza una solicitud FETCH para actualizar los datos del usuario
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=updateEmpleado', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_EMPLEADO": idEmpleado,
                        "DNI": dni,
                        "PRIMER_NOMBRE": Pnombre,
                        "SEGUNDO_NOMBRE": Snombre,
                        "PRIMER_APELLIDO": Papellido,
                        "SEGUNDO_APELLIDO": Sapellido,
                        "EMAIL": email,
                        "SALARIO": salario,
                        "ESTADO": estado,
                        "TELEFONO": telefono,
                        "DIRECCION1": direccion1,
                        "DIRECCION2": direccion2
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
                        text: 'Error al actualizar los datos del empleado: ' + error.message
                    });
                });
        }


        //     //FUNCION CON EL SWEETALERT
        function eliminarEmpleado(idEmpleado) {
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
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=eliminarEmpleado', {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_EMPLEADO": idEmpleado
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
                                Swal.fire('El empleado no puede ser eliminado', '', 'info')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de usuarios después de eliminar

                                        // Si no se puede eliminar el estado se debe estado a  "Inactivo"

                                    });
                            } else {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Empleado eliminado', '', 'success')
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
                            Swal.fire('Error', 'Error al eliminar el empleado: ' + error.message, 'error');
                        });
                }
            });
        }

        function validarNombre() {
            console.log("entra a ValidarNombre");
            dni = document.getElementById("#agregar-dni");
            Pnombre = document.getElementById("agregar-Pnombre");
            Snombre = document.getElementById("agregar-Snombre");
            Papellido = document.getElementById("agregar-Papellido");
            Sapellido = document.getElementById("agregar-Sapellido");
            email = document.getElementById("agregar-email");
            salario = document.getElementById("agregar-salario");
            estado = document.getElementById("agregar-estado");
            telefono = document.getElementById("agregar-telefono");
            direccion1 = document.getElementById("agregar-direccion1");
            direccion2 = document.getElementById("agregar-direccion2");

            dniEditar = document.getElementById("#editar-dni");
            PnombreEditar = document.getElementById("editar-Pnombre");
            SnombreEditar = document.getElementById("editar-Snombre");
            PapellidoEditar = document.getElementById("editar-Papellido");
            SapellidoEditar = document.getElementById("editar-Sapellido");
            emailEditar = document.getElementById("editar-email");
            salarioEditar = document.getElementById("editar-salario");
            estadoEditar = document.getElementById("editar-estado");
            telefonoEditar = document.getElementById("editar-telefono");
            direccion1Editar = document.getElementById("editar-direccion1");
            direccion2Editar = document.getElementById("editar-direccion2");



            dni.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9]+$/;

                if (!expresionValidadora.test(e.key)) {
                    dni.style.borderColor = "red";
                    dni.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números";
                    document.getElementById("mensaje1").style.color = "red";
                    e.preventDefault();
                } else {
                    dni.style.borderColor = "green";
                    dni.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje1").style.color = "green";
                }
            });


            Pnombre.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    Pnombre.style.borderColor = "red";
                    Pnombre.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje2").style.color = "red";
                    e.preventDefault();
                } else {
                    Pnombre.style.borderColor = "green";
                    Pnombre.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje2").style.color = "green";
                }
            });

            Snombre.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    Snombre.style.borderColor = "red";
                    Snombre.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje3").style.color = "red";
                    e.preventDefault();
                } else {
                    Snombre.style.borderColor = "green";
                    Snombre.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje3").style.color = "green";
                }
            });


            Papellido.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    Papellido.style.borderColor = "red";
                    Papellido.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje4").style.color = "red";
                    e.preventDefault();
                } else {
                    Papellido.style.borderColor = "green";
                    Papellido.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje4").style.color = "green";
                }
            });

            Sapellido.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    Sapellido.style.borderColor = "red";
                    Sapellido.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje5").style.color = "red";
                    e.preventDefault();
                } else {
                    Sapellido.style.borderColor = "green";
                    Sapellido.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje5").style.color = "green";
                }
            });

            email.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Za-z0-9.!@#$%^&*]+$/;


                if (!expresionValidadora2.test(e.key)) {
                    email.style.borderColor = "red";
                    email.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje6").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite email valido";
                    document.getElementById("mensaje6").style.color = "red";
                    e.preventDefault();
                } else {
                    email.style.borderColor = "green";
                    email.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje6").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje6").style.color = "green";
                }
            });


            salario.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9.]+$/;

                if (!expresionValidadora.test(e.key)) {
                    salario.style.borderColor = "red";
                    salario.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números y un punto (ejemplo: 1000.00)";
                    document.getElementById("mensaje7").style.color = "red";
                    e.preventDefault();
                } else {
                    // Verifica que no haya más de un punto decimal
                    if (e.key === "." && salario.value.includes(".")) {
                        salario.style.borderColor = "red";
                        salario.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite un punto decimal";
                        document.getElementById("mensaje7").style.color = "red";
                        e.preventDefault();
                    } else {
                        salario.style.borderColor = "green";
                        salario.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje7").style.color = "green";
                    }
                }
            });


            estado.addEventListener("change", function() {
                if (estado.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    estado.style.borderColor = "red";
                    estado.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un estado.";
                    document.getElementById("mensaje8").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    estado.style.borderColor = "green";
                    estado.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-check-circle'></i> Estado seleccionado.";
                    document.getElementById("mensaje8").style.color = "green";
                }
            });


            telefono.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9]+$/;

                if (!expresionValidadora.test(e.key)) {
                    telefono.style.borderColor = "red";
                    telefono.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje9").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números";
                    document.getElementById("mensaje9").style.color = "red";
                    e.preventDefault();
                } else {
                    telefono.style.borderColor = "green";
                    telefono.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje9").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje9").style.color = "green";
                }
            });

            direccion1.addEventListener("keypress", function(e) {
                var expresionValidadora3 = /^[A-Za-z0-9!@#$%^&* ]+$/;

                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    direccion1.style.borderColor = "red";
                    direccion1.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje10").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        direccion1.style.borderColor = "red";
                        direccion1.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas, números y ciertos caracteres especiales.";
                        document.getElementById("mensaje10").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        direccion1.style.borderColor = "green";
                        direccion1.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                        document.getElementById("mensaje10").style.color = "green";
                    }
                }
            });

            direccion2.addEventListener("keypress", function(e) {
                var expresionValidadora3 = /^[A-Za-z0-9!@#$%^&* ]+$/;

                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    direccion2.style.borderColor = "red";
                    direccion2.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje10").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        direccion2.style.borderColor = "red";
                        direccion2.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas, números y ciertos caracteres especiales.";
                        document.getElementById("mensaje10").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        direccion2.style.borderColor = "green";
                        direccion2.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                        document.getElementById("mensaje10").style.color = "green";
                    }
                }
            });






            //         //-------------------------MODAL DE EDITAR---------------------------------------

            dniEditar.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9]+$/;

                if (!expresionValidadora.test(e.key)) {
                    dniEditar.style.borderColor = "red";
                    dniEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números";
                    document.getElementById("mensaje1").style.color = "red";
                    e.preventDefault();
                } else {
                    dniEditar.style.borderColor = "green";
                    dniEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje1").style.color = "green";
                }
            });


            PnombreEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    PnombreEditar.style.borderColor = "red";
                    PnombreEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje2").style.color = "red";
                    e.preventDefault();
                } else {
                    PnombreEditar.style.borderColor = "green";
                    PnombreEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje2").style.color = "green";
                }
            });

            SnombreEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    SnombreEditar.style.borderColor = "red";
                    SnombreEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje3").style.color = "red";
                    e.preventDefault();
                } else {
                    SnombreEditar.style.borderColor = "green";
                    SnombreEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje3").style.color = "green";
                }
            });


            PapellidoEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    PapellidoEditar.style.borderColor = "red";
                    PapellidoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje4").style.color = "red";
                    e.preventDefault();
                } else {
                    PapellidoEditar.style.borderColor = "green";
                    PapellidoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje4").style.color = "green";
                }
            });

            SapellidoEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z]+$/;

                if (!expresionValidadora2.test(e.key) || e.keyCode === 32) {
                    SapellidoEditar.style.borderColor = "red";
                    SapellidoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas sin espacios.";
                    document.getElementById("mensaje5").style.color = "red";
                    e.preventDefault();
                } else {
                    SapellidoEditar.style.borderColor = "green";
                    SapellidoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje5").style.color = "green";
                }
            });

            emailEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Za-z0-9.!@#$%^&*]+$/;


                if (!expresionValidadora2.test(e.key)) {
                    emailEditar.style.borderColor = "red";
                    emailEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje6").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite email valido";
                    document.getElementById("mensaje6").style.color = "red";
                    e.preventDefault();
                } else {
                    emailEditar.style.borderColor = "green";
                    emailEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje6").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje6").style.color = "green";
                }
            });


            salarioEditar.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9.]+$/;

                if (!expresionValidadora.test(e.key)) {
                    salarioEditar.style.borderColor = "red";
                    salarioEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números y un punto (ejemplo: 1000.00)";
                    document.getElementById("mensaje7").style.color = "red";
                    e.preventDefault();
                } else {
                    // Verifica que no haya más de un punto decimal
                    if (e.key === "." && salario.value.includes(".")) {
                        salarioEditar.style.borderColor = "red";
                        salarioEditar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite un punto decimal";
                        document.getElementById("mensaje7").style.color = "red";
                        e.preventDefault();
                    } else {
                        salarioEditar.style.borderColor = "green";
                        salarioEditar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje7").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje7").style.color = "green";
                    }
                }
            });


            estadoEditar.addEventListener("change", function() {
                if (estado.value === "") {
                    // Si no se ha seleccionado una opción (el valor es una cadena vacía), muestra un mensaje de error.
                    estadoEditar.style.borderColor = "red";
                    estadoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-times-circle'></i> Debes seleccionar un estado.";
                    document.getElementById("mensaje8").style.color = "red";
                } else {
                    // Si se ha seleccionado una opción, marca el campo como válido.
                    estadoEditar.style.borderColor = "green";
                    estadoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje8").innerHTML = "<i class='fas fa-check-circle'></i> Estado seleccionado.";
                    document.getElementById("mensaje8").style.color = "green";
                }
            });


            telefonoEditar.addEventListener("keypress", function(e) {
                var expresionValidadora = /^[0-9]+$/;

                if (!expresionValidadora.test(e.key)) {
                    telefonoEditar.style.borderColor = "red";
                    telefonoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje9").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten números";
                    document.getElementById("mensaje9").style.color = "red";
                    e.preventDefault();
                } else {
                    telefonoEditar.style.borderColor = "green";
                    telefonoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje9").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje9").style.color = "green";
                }
            });

            direccion1Editar.addEventListener("keypress", function(e) {
                var expresionValidadora3 = /^[A-Za-z0-9!@#$%^&* ]+$/;

                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    direccion1Editar.style.borderColor = "red";
                    direccion1Editar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje10").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        direccion1Editar.style.borderColor = "red";
                        direccion1Editar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas, números y ciertos caracteres especiales.";
                        document.getElementById("mensaje10").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        direccion1Editar.style.borderColor = "green";
                        direccion1Editar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                        document.getElementById("mensaje10").style.color = "green";
                    }
                }
            });

            direccion2Editar.addEventListener("keypress", function(e) {
                var expresionValidadora3 = /^[A-Za-z0-9!@#$%^&* ]+$/;

                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    direccion2Editar.style.borderColor = "red";
                    direccion2Editar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permite 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje10").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora3.test(e.key)) {
                        direccion2Editar.style.borderColor = "red";
                        direccion2Editar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten letras mayúsculas, números y ciertos caracteres especiales.";
                        document.getElementById("mensaje10").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        direccion2Editar.style.borderColor = "green";
                        direccion2Editar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje10").innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                        document.getElementById("mensaje10").style.color = "green";
                    }
                }
            });


        }

        $(document).ready(function() {
            Lista_Empleados();
            Insertar_Empleado();
            validarNombre();
        });
    </script>
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const dniInput = document.getElementById("agregar-dni");
        const PnombreInput = document.getElementById("agregar-Pnombre");
        const SnombreInput = document.getElementById("agregar-Snombre");
        const PapellidoInput = document.getElementById("agregar-Papellido");
        const SapellidoInput = document.getElementById("agregar-Sapellido");
        const emailInput = document.getElementById("agregar-email");
        const salarioInput = document.getElementById("agregar-salario");
        const estadoInput = document.getElementById("agregar-estado");
        const telefonoInput = document.getElementById("agregar-telefono");
        const direccion1Input = document.getElementById("agregar-direccion1");
        const direccion2Input = document.getElementById("agregar-direccion2");
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = dniInput.value.trim() !== '' && PnombreInput.value.trim() !== '' && SnombreInput.value !== '' &&
                PapellidoInput.value.trim() !== '' && SapellidoInput.value.trim() !== '' && emailInput.value !== '' &&
                salarioInput.value.trim() !== '' && estadoInput.value.trim() !== '' && telefonoInput.value.trim() !== '' && direccion1Input.value.trim() !== '' && direccion2Input.value.trim() !== '';

            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        dniInput.addEventListener('input', checkForm);
        PnombreInput.addEventListener('input', checkForm);
        SnombreInput.addEventListener('input', checkForm);
        PapellidoInput.addEventListener('input', checkForm);
        SapellidoInput.addEventListener('input', checkForm);
        emailInput.addEventListener('input', checkForm);
        salarioInput.addEventListener('input', checkForm);
        estadoInput.addEventListener('input', checkForm);
        telefonoInput.addEventListener('input', checkForm);
        direccion1Input.addEventListener('input', checkForm);
        direccion2Input.addEventListener('input', checkForm);
    </script>

<script>
        // Obtén los campos de entrada y el botón "Guardar para Editar"
        const dniInput1 = document.getElementById("editar-dni");
        const PnombreInput1 = document.getElementById("editar-Pnombre");
        const SnombreInput1 = document.getElementById("editar-Snombre");
        const PapellidoInput1 = document.getElementById("editar-Papellido");
        const SapellidoInput1 = document.getElementById("editar-Sapellido");
        const emailInput1 = document.getElementById("editar-email");
        const salarioInput1 = document.getElementById("editar-salario");
        const estadoInput1 = document.getElementById("editar-estado");
        const telefonoInput1 = document.getElementById("editar-telefono");
        const direccion1Input1 = document.getElementById("editar-direccion1");
        const direccion2Input1 = document.getElementById("editar-direccion2");
        const guardarButton1 = document.getElementById('btn-editar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = dniInput1.value.trim() !== '' && PnombreInput1.value.trim() !== '' && SnombreInput1.value !== '' &&
                PapellidoInput1.value.trim() !== '' && SapellidoInput1.value.trim() !== '' && emailInput1.value !== '' &&
                salarioInput1.value.trim() !== '' && estadoInput1.value.trim() !== '' && telefonoInput1.value.trim() !== '' && direccion1Input1.value.trim() !== '' && direccion2Input1.value.trim() !== '';

            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        dniInput1.addEventListener('input', checkForm);
        PnombreInput1.addEventListener('input', checkForm);
        SnombreInput1.addEventListener('input', checkForm);
        PapellidoInput1.addEventListener('input', checkForm);
        SapellidoInput1.addEventListener('input', checkForm);
        emailInput1.addEventListener('input', checkForm);
        salarioInput1.addEventListener('input', checkForm);
        estadoInput1.addEventListener('input', checkForm);
        telefonoInput1.addEventListener('input', checkForm);
        direccion1Input1.addEventListener('input', checkForm);
        direccion2Input1.addEventListener('input', checkForm);
    </script>
<script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-dni, #agregar-Pnombre, #agregar-Snombre,#agregar-Papellido,#agregar-Sapellido,#agregar-email,#agregar-salario,#agregar-estado,#agregar-telefono,#agregar-direccion1,#agregar-direccion2').on('input', function() {
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
         $('#editar-dni, #editar-Pnombre, #editar-Snombre,#editar-Papellido,#editar-Sapellido,#editar-email,#editar-salario,#editar-estado,#editar-telefono,#editar-direccion1,#editar-direccion2').on('input', function() {
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>

</html>