<?php 

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosTipoprestamo = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Tipoprestamo = "29";
$id_objeto_Seguridad = "25";
$id_objeto_Cuentas = "28";


$permisos1 = $permisosTipoprestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosTipoprestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
$permisos2 = $permisosTipoprestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);


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
    <title>Mantenimiento Empleado</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-tipoprestamo {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-tipoprestamo th {
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
        #Lista-tipoprestamo td {
            border: 1px solid grey;
            /* Bordes negros para las celdas de datos */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
        }

        /* Estilo personalizado para el placeholder */
        #myInput {
            border: 1px solid #000;
            /* Borde más oscuro, en este caso, negro (#000) */
        }

        /*BOTON DE CREAR NUEVO */
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
                        //-------------------------------------MODULO DE EMPLEADO--------------------------------
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
                                echo '<a class="nav-link" href="tipoPrestamo.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Tipo Prestamo</a>';


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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE SUCURSAL -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Tipo Prestamo</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?> 
                        </div>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-tipoprestamo" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                <th style="display: none;">Id Tipo Prestamo</th>
                                    <th>Tipo Prestamo</th>
                                    <th>Descripcion</th>
                                    <th>Aplica Seguro</th>
                                    <th>Monto Máximo</th>
                                    <th>Monto Minimo</th>
                                    <th>Tasa Máxima</th>
                                    <th>Tasa Minima</th>
                                    <th>Plazo Máximo</th>
                                    <th>Plazo Minimo</th>
                                    <th>Estado </th>
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
                                        <label for="nombre">Tipo Prestamo</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-tipoprestamo" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje1"></div>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-descripcion" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        
                                        <label for="nombre">Aplica seguro</label>
                                        <input type="text" maxlength="1" class="form-control" id="agregar-aplicaseguro" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje3"></div>

                                        
                                        <label for="nombre"> Monto Maximo</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-montomaximo" required pattern="[0-9]+" title="Solo se permiten números (1, 0)">
                                        <div id="mensaje4"></div>
                                        
                                        <label for="nombre">Monto Minimo</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-montominimo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje5"></div>

                                        <label for="nombre"> Tasa Maxima</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-tasamaxima" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje6"></div>
                                        
                                        <label for="nombre">Tasa Minima</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-tasaminima" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje7"></div>

                                        <label for="nombre"> Plazo Maximo</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-plazomaximo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje8"></div>
                                        
                                        <label for="nombre">Plazo Minimo</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-plazominimo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje9"></div>

                                        
                                        <label for="nombre">Estado</label>
                                        <select class="form-control" id="agregar-estado" maxlength="15" name="estado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>
                                        </select>
                                        <div id="mensaje10"></div>


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
                                        <label for="nombre">Id Tipo Prestamo</label>
                                        <input type="text" class="form-control" id="editar-id-tipoprestamo" disabled>

                                        <label for="nombre">Tipo Prestamo</label>
                                        <input type="text" maxlength="100" class="form-control" id="editar-tipoprestamo" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje11"></div>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="100" class="form-control" id="editar-descripcion" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje12"></div>

                                        
                                        <label for="nombre">Aplica seguro</label>
                                        <input type="text" maxlength="1" class="form-control" id="editar-aplicaseguro" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje13"></div>

                                        
                                        <label for="nombre"> Monto Maximo</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-montomaximo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje14"></div>
                                        
                                        <label for="nombre">Monto Minimo</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-montominimo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje15"></div>

                                        <label for="nombre"> Tasa Maxima</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-tasamaxima" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje16"></div>
                                        
                                        <label for="nombre">Tasa Minima</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-tasaminima" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje17"></div>

                                        <label for="nombre"> Plazo Maximo</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-plazomaximo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje18"></div>
                                        
                                        <label for="nombre">Plazo Minimo</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-plazominimo" required pattern="[0-9]+" title="Solo se permiten números">
                                        <div id="mensaje19"></div>

                                        
                                        <label for="nombre">Estado</label>
                                        <select class="form-control" id="editar-estado" maxlength="15" name="estado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>
                                        </select>
                                        <div id="mensaje20"></div>


                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateTipoprestamo()" disabled>Guardar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE SUCURSAL -->

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


        function Lista_Tipoprestamo() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoPrestamo.php?op=GetTipoprestamos', {
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
                    var tbody = document.querySelector('#Lista-tipoprestamo tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(tipoprestamo) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + tipoprestamo.ID_TIPO_PRESTAMO + '</td>' +
                            '<td>' + tipoprestamo.TIPO_PRESTAMO + '</td>' +
                            '<td>' + tipoprestamo.DESCRIPCION + '</td>' +
                            '<td>' + tipoprestamo.APLICA_SEGUROS + '</td>' +
                            '<td>' + tipoprestamo.MONTO_MAXIMO + '</td>' +
                            '<td>' + tipoprestamo.MONTO_MINIMO + '</td>' +
                            '<td>' + tipoprestamo.TASA_MAXIMA + '</td>' +
                            '<td>' + tipoprestamo.TASA_MINIMA + '</td>' +
                            '<td>' + tipoprestamo.PLAZO_MAXIMO + '</td>' +
                            '<td>' + tipoprestamo.PLAZO_MINIMO + '</td>' +
                            '<td>' + tipoprestamo.ESTADO + '</td>' +

                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarTipoprestamo(' + tipoprestamo.ID_TIPO_PRESTAMO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-tipoprestamo" data-id="' + tipoprestamo.ID_TIPO_PRESTAMO  + '" onclick="eliminarTipoprestamo(' + tipoprestamo.ID_TIPO_PRESTAMO  + ')">Eliminar</button>';
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
            $('#Lista-tipoprestamo').DataTable({
                "paging": true, 
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }


        function Insertar_Tipoprestamo() {
           $("#btn-agregar").click(function() {
               // Obtener los valores de los campos del formulario
           
            var tipoprestamo =$("#agregar-tipoprestamo").val();
            var descripcion =$("#agregar-descripcion").val();
            var aplicaseguro =$("#agregar-aplicaseguro").val();
            var montomaximo =$("#agregar-montomaximo").val();
            var montominimo =$("#agregar-montominimo").val();
            var tasamaxima =$("#agregar-tasamaxima").val();
            var tasaminima =$("#agregar-tasaminima").val();
            var plazomaximo =$("#agregar-plazomaximo").val();
            var plazominimo =$("#agregar-plazominimo").val();
            var estado = $("#agregar-estado").val();

            

                if (tipoprestamo == "" || descripcion == "" || aplicaseguro == "" || montomaximo == ""|| montominimo == ""|| 
                 tasamaxima == "" || tasaminima == "" || plazomaximo == "" || plazominimo == ""|| estado == "" ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
            } else {
                    // Crear un region con los datos a enviar al servidor
        //            // Crear un objeto con los datos a enviar al servidor
                      var datos = {
                    
                        TIPO_PRESTAMO: tipoprestamo,
                        DESCRIPCION: descripcion,
                        APLICA_SEGUROS: aplicaseguro,
                        MONTO_MAXIMO: montomaximo,
                        MONTO_MINIMO: montominimo,
                        TASA_MAXIMA: tasamaxima,
                        TASA_MINIMA: tasaminima,
                        PLAZO_MAXIMO: plazomaximo,
                        PLAZO_MINIMO: plazominimo,
                        ESTADO: estado
                     };

                     fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoPrestamo.php?op=InsertTipoprestamo', {
                             method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(datos)
                        })
                        .then(function(response) {
                            if (response.ok) {
                                if (response.status === 200) {
                                    // Si la solicitud fue exitosa y el código de respuesta es 200 (OK), muestra mensaje de éxito
                                    return response.json().then(function(data) {
                                        console.log(data);
                                        // Cerrar la modal después de guardar
                                        $('#crearModal').modal('hide');
                                        // Mostrar SweetAlert de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado exitoso',
                                            text: data.message
                                        }).then(function() {
                                            // Recargar la página para mostrar los nuevos datos
                                            location.reload();
                                        });
                                    });
                                } else if (response.status === 409) {
                                    // Si el código de respuesta es 409 (Conflict), muestra mensaje de region existente
                                    return response.json().then(function(data) {
                                        console.log(data);
                                        // Mostrar SweetAlert de error
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.error // Acceder al mensaje de error
                                        });
                                    });
                                }
                            } else {
                                // Si hubo un error en la solicitud, maneja el error aquí
                                throw new Error('Error en la solicitud');
                            }
                        })
                        .catch(function(error) {
                            // Mostrar SweetAlert de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar los datos: ' + error.message
                            });
                            console.log(error.message);
                        });
                }
            });
        }



        function cargarTipoprestamo(id) {
            // Crear un objeto con el ID de la sucursal
            var data = {
                "ID_TIPO_PRESTAMO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del usuario por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoPrestamo.php?op=GetTipoprestamo', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte la sucursal en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(tipoprestamo) {
                    // Llena los campos del modal con los datos del sucursal
                    document.getElementById('editar-id-tipoprestamo').value = tipoprestamo.ID_TIPO_PRESTAMO;
                    document.getElementById('editar-tipoprestamo').value = tipoprestamo.TIPO_PRESTAMO;
                    document.getElementById('editar-descripcion').value = tipoprestamo.DESCRIPCION;
                    document.getElementById('editar-aplicaseguro').value = tipoprestamo.APLICA_SEGUROS;
                    document.getElementById('editar-montomaximo').value = tipoprestamo.MONTO_MAXIMO;
                    document.getElementById('editar-montominimo').value = tipoprestamo.MONTO_MINIMO;
                    document.getElementById('editar-tasamaxima').value = tipoprestamo.TASA_MAXIMA;
                    document.getElementById('editar-tasaminima').value = tipoprestamo.TASA_MINIMA;
                    document.getElementById('editar-plazomaximo').value = tipoprestamo.PLAZO_MAXIMO;
                    document.getElementById('editar-plazominimo').value = tipoprestamo.PLAZO_MINIMO;
                    document.getElementById('editar-estado').value = tipoprestamo.ESTADO;

                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos de Tipo Prestamo: ' + error.message);
                });
        }


         function updateTipoprestamo() {
            var id_tipoprestamo= document.getElementById('editar-id-tipoprestamo').value;
            var tipoprestamo = document.getElementById('editar-tipoprestamo').value;
            var descripcion = document.getElementById('editar-descripcion').value;
            var aplicaseguro = document.getElementById('editar-aplicaseguro').value;
           
            var montomaximo = document.getElementById('editar-montomaximo').value;
            var montominimo = document.getElementById('editar-montominimo').value;
            var tasamaxima = document.getElementById('editar-tasamaxima').value;
            var tasaminima = document.getElementById('editar-tasaminima').value;
            var plazomaximo = document.getElementById('editar-plazomaximo').value;
            var plazominimo = document.getElementById('editar-plazominimo').value;
            var estado = document.getElementById('editar-estado').value;
            

            if (tipoprestamo == "" || descripcion == "" || aplicaseguro == "" || montomaximo == ""|| montominimo == ""||  tasamaxima == "" || tasaminima == "" || plazomaximo == "" || plazominimo == ""|| estado == "" ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
            // Realiza una solicitud FETCH para actualizar los datos del objeto
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoPrestamo.php?op=updateTipoprestamo', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_TIPO_PRESTAMO": id_tipoprestamo,
                        "TIPO_PRESTAMO": tipoprestamo,
                        "DESCRIPCION": descripcion,
                        "APLICA_SEGUROS": aplicaseguro,
                        "MONTO_MAXIMO": montomaximo,
                        "MONTO_MINIMO": montominimo,
                        "TASA_MAXIMA": tasamaxima,
                        "TASA_MINIMA": tasaminima,
                        "PLAZO_MAXIMO": plazomaximo,
                        "PLAZO_MINIMO": plazominimo,
                        "ESTADO": estado

                    }) // Convierte los datos en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        // Cerrar la modal después de guardar
                        $('#editarModal').modal('hide');
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar los datos del Tipo Prestamo: ' + error.message
                    });
                });
            }    
        }
 
        //FUNCION CON EL SWEETALERT
        function eliminarTipoprestamo(id_tipoprestamo) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar' 
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoPrestamo.php?op=eliminarTipoprestamo', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_TIPO_PRESTAMO": id_tipoprestamo
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Tipo Prestamo eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de objetos después de eliminar
                                        
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el Tipo prestamo: ' + error.message, 'error');
                        });
                }
            });
        }

//         // VALIDACIONES FUNCIONES    
        function validarNombre() {
            tipoprestamo = document.getElementById("agregar-tipoprestamo");
            descripcion = document.getElementById("agregar-descripcion");
            aplicaseguro = document.getElementById("agregar-aplicaseguro");
            montomaximo = document.getElementById("agregar-montomaximo");
            montominimo = document.getElementById("agregar-montominimo");
            tasamaxima = document.getElementById("agregar-tasamaxima");
            tasaminima = document.getElementById("agregar-tasaminima");
            plazomaximo = document.getElementById("agregar-plazomaximo");
            plazominimo = document.getElementById("agregar-plazominimo");
            estado = document.getElementById("agregar-estado");
/////////////////////////////
            tipoprestamoEditar = document.getElementById("editar-tipoprestamo");
            descripcionEditar = document.getElementById("editar-descripcion");
            aplicaseguroEditar = document.getElementById("editar-aplicaseguro");
            montomaximoEditar = document.getElementById("editar-montomaximo");
            montominimoEditar = document.getElementById("editar-montominimo");
            tasamaximaEditar = document.getElementById("editar-tasamaxima");
            tasaminimaEditar = document.getElementById("editar-tasaminima");
            plazomaximoEditar = document.getElementById("editar-plazomaximo");
            plazominimoEditar = document.getElementById("editar-plazominimo");
            estadoEditar = document.getElementById("editar-estado");


            function clearMessage(messageElement, inputElement) {
                messageElement.innerHTML = ""; // Elimina el contenido del mensaje
                inputElement.style.borderColor = ""; // Restablece el borde
                inputElement.style.boxShadow = ""; // Restablece la sombra
            }

            function validateInput(inputElement, expression, messageElement, message) {
                if (inputElement.value === "") {
                    clearMessage(messageElement, inputElement);
                } else if (!expression.test(inputElement.value)) {
                    inputElement.style.borderColor = "red";
                    inputElement.style.boxShadow = "0 0 10px red";
                    messageElement.innerHTML = "<i class='fas fa-times-circle'></i> " + message;
                    messageElement.style.color = "red";
                } else {
                    clearMessage(messageElement, inputElement); // Restablece los estilos
                    messageElement.innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                    messageElement.style.color = "green";
                }
            }

            function handleInputAndBlurEvents(inputElement, expression, messageElement, message) {
                inputElement.addEventListener("input", function () {
                    validateInput(inputElement, expression, messageElement, message);
                });

                inputElement.addEventListener("blur", function () {
                    clearMessage(messageElement, inputElement);
                });
            }

            function handleDescriptionKeypressEvent(inputElement) {
                inputElement.addEventListener("keypress", function(e) {
                    var currentDescription = inputElement.value;
                    if (e.key === " " && currentDescription.endsWith(" ")) {
                        e.preventDefault();
                    }
                });
            }


            var expresionValidadora2 = /^[A-Z0-9\s]+$/;
            var mensaje1 = document.getElementById("mensaje1");
            handleInputAndBlurEvents(tipoprestamo, expresionValidadora2, mensaje1, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(tipoprestamo);

            var mensaje2 = document.getElementById("mensaje2");
            handleInputAndBlurEvents(descripcion, expresionValidadora2, mensaje2, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcion);   

            var expresionValidadora1 = /^[0-9]+$/;
            var mensaje3 = document.getElementById("mensaje3");
            handleInputAndBlurEvents(aplicaseguro, expresionValidadora1, mensaje3, "Solo se permiten números");     
   
            
            var mensaje4 = document.getElementById("mensaje4");
            handleInputAndBlurEvents(montomaximo, expresionValidadora1, mensaje4, "Solo se permiten números");

           
            var mensaje5 = document.getElementById("mensaje5");
            handleInputAndBlurEvents(montominimo, expresionValidadora1, mensaje5, "Solo se permiten números");

            var mensaje6 = document.getElementById("mensaje6");
            handleInputAndBlurEvents(tasamaxima, expresionValidadora1, mensaje6, "Solo se permiten números");

            var mensaje7 = document.getElementById("mensaje7");
            handleInputAndBlurEvents(tasaminima, expresionValidadora1, mensaje7, "Solo se permiten números");

            var mensaje8 = document.getElementById("mensaje8");
            handleInputAndBlurEvents(plazomaximo, expresionValidadora1, mensaje8, "Solo se permiten números");

            var mensaje9 = document.getElementById("mensaje9");
            handleInputAndBlurEvents(plazominimo, expresionValidadora1, mensaje9, "Solo se permiten números");

            var mensaje10 = document.getElementById("mensaje10");
            handleInputAndBlurEvents(estado, expresionValidadora2, mensaje10, "Solo se permiten Letras Mayúsculas");
            handleDescriptionKeypressEvent(estado);  

/////editar
            var mensaje11 = document.getElementById("mensaje11");
            handleInputAndBlurEvents(tipoprestamoEditar, expresionValidadora2, mensaje11, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(tipoprestamoEditar);

            var mensaje12 = document.getElementById("mensaje12");
            handleInputAndBlurEvents(descripcionEditar, expresionValidadora2, mensaje12, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcionEditar);      
            
            var mensaje13 = document.getElementById("mensaje13");
            handleInputAndBlurEvents(aplicaseguroEditar, expresionValidadora1, mensaje13, "Solo se permiten números ( 1 ó 0)");       
   
            var mensaje14 = document.getElementById("mensaje14");
            handleInputAndBlurEvents(montomaximoEditar, expresionValidadora1, mensaje14, "Solo se permiten números");

           
            var mensaje15 = document.getElementById("mensaje15");
            handleInputAndBlurEvents(montominimoEditar, expresionValidadora1, mensaje15, "Solo se permiten números");

            var mensaje16 = document.getElementById("mensaje16");
            handleInputAndBlurEvents(tasamaximaEditar, expresionValidadora1, mensaje16, "Solo se permiten números");

            var mensaje17 = document.getElementById("mensaje17");
            handleInputAndBlurEvents(tasaminimaEditar, expresionValidadora1, mensaje17, "Solo se permiten números");

            var mensaje18 = document.getElementById("mensaje18");
            handleInputAndBlurEvents(plazomaximoEditar, expresionValidadora1, mensaje18, "Solo se permiten números");

            var mensaje19 = document.getElementById("mensaje19");
            handleInputAndBlurEvents(plazominimoEditar, expresionValidadora1, mensaje19, "Solo se permiten números");

            var mensaje20 = document.getElementById("mensaje20");
            handleInputAndBlurEvents(estadoEditar, expresionValidadora2, mensaje20, "Solo se permiten Letras Mayúsculas");
            handleDescriptionKeypressEvent(estadoEditar);  


       }



        

        $(document).ready(function() {
            Lista_Tipoprestamo();
           Insertar_Tipoprestamo();
            validarNombre();
        });
    </script>



<script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const tipoprestamoInput = document.getElementById('agregar-tipoprestamo');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const aplicaseguroInput = document.getElementById('agregar-aplicaseguro');
        const montomaximoInput = document.getElementById('agregar-montomaximo');
        const montominimoInput = document.getElementById('agregar-montominimo');

        const tasamaximaInput = document.getElementById('agregar-tasamaxima');
        const tasaminimaInput = document.getElementById('agregar-tasaminima');
        const plazomaximoInput = document.getElementById('agregar-plazomaximo');
        const plazominimoInput = document.getElementById('agregar-plazominimo');
        const estadoInput = document.getElementById('agregar-estado');
        const guardarButton = document.getElementById('btn-agregar');


        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid =tipoprestamoInput.value.trim() !== '' && descripcionInput.value.trim() !== '' && 
            aplicaseguroInput.value.trim() !== '' &&montomaximoInput.value.trim() !== '' && montominimoInput.value.trim() !== ''
            &&tasamaximaInput.value.trim() !== '' && tasaminimaInput.value.trim() !== '' && plazomaximoInput.value.trim() !== '' 
            &&plazominimoInput.value.trim() !== '' && estadoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }
        // Agrega un evento input a cada campo de entrada
        tipoprestamoInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
        aplicaseguroInput.addEventListener('input', checkForm);
        montomaximoInput.addEventListener('input', checkForm);
        montominimoInput.addEventListener('input', checkForm);
        tasamaximaInput.addEventListener('input', checkForm);
        tasaminimaInput.addEventListener('input', checkForm);
        plazomaximoInput.addEventListener('input', checkForm);
        plazominimoInput.addEventListener('input', checkForm);
        estadoInput.addEventListener('input', checkForm);

        guardarButton.addEventListener('input', checkForm);
    </script>

<script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const tipoprestamoInput1 = document.getElementById('editar-tipoprestamo');
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const aplicaseguroInput1 = document.getElementById('editar-aplicaseguro');
        const montomaximoInput1 = document.getElementById('editar-montomaximo');
        const montominimoInput1 = document.getElementById('editar-montominimo');

        const tasamaximaInput1 = document.getElementById('editar-tasamaxima');
        const tasaminimaInput1 = document.getElementById('editar-tasaminima');
        const plazomaximoInput1 = document.getElementById('editar-plazomaximo');
        const plazominimoInput1 = document.getElementById('editar-plazominimo');
        const estadoInput1 = document.getElementById('editar-estado');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid =tipoprestamoInput1.value.trim() !== '' && descripcionInput1.value.trim() !== '' && aplicaseguroInput1.value.trim() !== '' &&montomaximoInput1.value.trim() !== '' && montominimoInput1.value.trim() !== ''&&tasamaximaInput1.value.trim() !== '' && tasaminimaInput1.value.trim() !== '' && plazomaximoInput1.value.trim() !== '' &&plazominimoInput1.value.trim() !== '' && estadoInput1.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        tipoprestamoInput1.addEventListener('input', checkForm);
        descripcionInput1.addEventListener('input', checkForm);
        aplicaseguroInput1.addEventListener('input', checkForm);
        montomaximoInput1.addEventListener('input', checkForm);
        montominimoInput1.addEventListener('input', checkForm);
        tasamaximaInput1.addEventListener('input', checkForm);
        tasaminimaInput1.addEventListener('input', checkForm);
        plazomaximoInput1.addEventListener('input', checkForm);
        plazominimoInput1.addEventListener('input', checkForm);
        estadoInput1.addEventListener('input', checkForm);

    </script>

<script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-tipoprestamo, #agregar-descripcion, #agregar-aplicaseguro, #agregar-montomaximo, #agregar-montominimo,  #agregar-tasamaxima, #agregar-tasaminima,  #agregar-plazomaximo, #agregar-plazominimo,  #agregar-estado').on('input', function() {
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

        // Escuchar eventos de cambio en los campos de entrada deshabilitados para eliminar espacios en blanco al principio y al final
        $('#editar-tipoprestamo, #editar-descripcion, #editar-aplicaseguro, #editar-montomaximo, #editar-montominimo,  #editar-tasamaxima, #editar-tasaminima,  #editar-plazomaximo, #editar-plazominimo,  #editar-estado').on('input', function() {
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
        document.getElementById('agregar-tipoprestamo').value = "";
        document.getElementById('agregar-descripcion').value = "";
        document.getElementById('agregar-aplicaseguro').value = "";
        document.getElementById('agregar-montomaximo').value = "";
        document.getElementById('agregar-montominimo').value = "";
        document.getElementById('agregar-tasamaxima').value = "";
        document.getElementById('agregar-tasaminima').value = "";
        document.getElementById('agregar-plazomaximo').value = "";
        document.getElementById('agregar-plazominimo').value = "";
        document.getElementById('agregar-estado').value = "";


        // Limpia los checkboxes
        document.getElementById('agregar-tipoprestamo').checked = false;
        document.getElementById('agregar-descripcion').checked = false;
        document.getElementById('agregar-aplicaseguro').checked = false;
        document.getElementById('agregar-montomaximo').checked = false;
        document.getElementById('agregar-montominimo').checked = false;
        document.getElementById('agregar-tasamaxima').checked = false;
        document.getElementById('agregar-tasaminima').checked = false;
        document.getElementById('agregar-plazomaximo').checked = false;
        document.getElementById('agregar-plazominimo').checked = false;
        document.getElementById('agregar-estado').checked = false;

        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {
       
        // Limpia los checkboxes

        document.getElementById('editar-tipoprestamo').checked = false;
        document.getElementById('editar-descripcion').checked = false;
        document.getElementById('editar-aplicaseguro').checked = false;
        document.getElementById('editar-montomaximo').checked = false;
        document.getElementById('editar-montominimo').checked = false;
        document.getElementById('editar-tasamaxima').checked = false;
        document.getElementById('editar-tasaminima').checked = false;
        document.getElementById('editar-plazomaximo').checked = false;
        document.getElementById('editar-plazominimo').checked = false;
        document.getElementById('editar-estado').checked = false;
        });
    </script>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>