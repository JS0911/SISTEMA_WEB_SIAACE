<?php

session_start();

require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";
require_once '../../Modelos/Usuarios.php';
require_once "../../Modelos/error.php";

$permisosObjetos = new PermisosUsuarios();
$usuario_obj = new Usuario();

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];

//---------------------PERMISOS DE LOS MANTENIMIENTOS----------------------
$id_objeto_Usuario = "2";
$id_objeto_Bitacora = "14";
$id_objeto_Estados = "6";
$id_objeto_Objetos = "5";
$id_objeto_Parametro = "4";
$id_objeto_Permisos = "3";
$id_objeto_Roles = "1";
//------OBJETOS DE MANT.EMPLEADOS---------------------
$id_objeto_Sucursal = "9";
$id_objeto_Region = "8";
$id_objeto_Empleado = "7";
$id_objeto_Cargos = "26";
//------OBJETOS DE MANT.PRESTAMO-----------------------
$id_objeto_Forma_Pago = "12";
$id_objeto_PrestamoMantenimiento = "30";
$id_objeto_Tipoprestamo = "13";
//------------OBJETOS DE MANT.CUENTAS------------------
$id_objeto_Transaccion = "11";
$id_objeto_Tipo_cuenta = "28";
$id_objeto_MantCuenta = "29";
//------------------PERMISOS DE LAS PESTAÑAS-------------------------------------
$id_objeto_Seguridad = "25";
$id_objeto_PestaniaEmpleado = "27";
$id_objeto_Cuentas = "36";
$id_objeto_Prestamos = "35";

//-------------------------------------------------------------------------------

$permisosUsuario = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisosBitacora = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosEstados = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosObjeto = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);
//---------------------------Mant.Empleado----------
$permisosSucursal = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//------------------------------------------------------------------------------

$permisos = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisos1 = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_PestaniaEmpleado);
$permisos3 = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);
$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../InicioSesion/login.php");
    exit();
}

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Reportes</title>
    <link rel="shortcut icon" href="../../src/IconoIDH.ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        .table-container {
            overflow-y: auto;
            max-height: 600px;
            /*  ajustar esta altura */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
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

        .icono {
            font-size: 18px;
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .icono:hover {
            color: #4CAF50;
        }

        .icon-lg {
            font-size: 24px;
            /* Ajusta el tamaño según tus necesidades */
            margin-right: 10px;
            /* Ajusta el margen derecho según tus necesidades */
            cursor: pointer;
        }

        .custom-large-icon {
            font-size: 2.5em;
            /* Ajusta e tamaño según tus necesidades */
        }

        .styled-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="../../InicioSesion/index.php">
            <img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <!-- Icono de Atras -->
        <a href="javascript:history.back()" class="icono"><i class="fas fa-chevron-circle-left"></i></a>
        <!-- Icono de Adelante -->
        <a href="javascript:history.forward()" class="icono"><i class="fas fa-chevron-circle-right"></i></a>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="perfil.php">Perfil</a>
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
                        //-----------------------MODULO DE SEGURIDAD----------------------------------------
                        if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosUsuario) && $permisosUsuario[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                }
                                if (!empty($permisosRoles) && $permisosRoles[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                }
                                if (!empty($permisosEstados) && $permisosEstados[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                }
                                if (!empty($permisosPermiso) && $permisosPermiso[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                }
                                if (!empty($permisosObjeto) && $permisosObjeto[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                }
                                if (!empty($permisosParametro) && $permisosParametro[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                }
                                if (!empty($permisosBitacora) && $permisosBitacora[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        //-------------------------MODULO DE EMPLEADO---------------------------------------------
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Empleados
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosEmpleado) && $permisosEmpleado[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                }
                                if (!empty($permisosCargo) && $permisosCargo[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                }
                                if (!empty($permisosRegion) && $permisosRegion[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                }
                                if (!empty($permisosSucursal) && $permisosSucursal[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE CUENTAS------------------------------------
                        if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoCuentas" aria-expanded="false" aria-controls="collapseMantenimientoCuentas">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Cuentas
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoCuentas" aria-labelledby="headingMantenimientoCuentas" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosTransaccion) && $permisosTransaccion[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoCuentas/tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                }
                                if (!empty($permisosTipoCuenta) && $permisosTipoCuenta[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoCuentas/tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Cuenta</a>';
                                }
                                if (!empty($permisosMantCuenta) && $permisosMantCuenta[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoCuentas/MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Cuentas</a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE PRESTAMOS------------------------------------
                        if (!empty($permisos4) && $permisos4[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoPrestamo" aria-expanded="false" aria-controls="collapseMantenimientoPrestamo">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>
                            Prestamos
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoPrestamo" aria-labelledby="headingMantenimientoPrestamo" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos4) && $permisos4[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosFormaPago) && $permisosFormaPago[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoPrestamos/forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                }
                                if (!empty($permisosTipoPrestamo) && $permisosTipoPrestamo[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoPrestamos/tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                }
                                if (!empty($permisosPresMantenimiento) && $permisosPresMantenimiento[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoPrestamos/prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Prestamos</a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        ?>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usuario: <?php echo $nombre_usuario; ?><div>
                            Sesión activa: Conectado(a).
                        </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="container">

                <form id="reporteForm" class="styled-form">
                    <h2>Generador de Reportes</h2>
                    <div class="form-group">
                        <label for="tipoReporte">Seleccione un tipo de reporte:</label>
                        <select class="form-control" id="tipoReporte">
                            <option value="ReporteAnulaciones">Reporte de Anulaciones</option>
                            <option value="ReporteDepositos">Reporte de Depositos</option>
                            <option value="ReporteRetiros">Reporte de Retiros</option>
                            <!-- Agrega aquí más opciones de reporte según tus necesidades -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaInicio">Fecha de inicio:</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                    </div>
                    <div class="form-group">
                        <label for="fechaFin">Fecha de fin:</label>
                        <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                    </div>
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </form>


                <!-- Contenedor para mostrar el resultado del reporte -->
                <div id="reporteContainer" class="table-container"></div>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-start justify-content-center small">
                            <div class="text-muted">Copyright &copy; IA-UNAH 2023</div>
                        </div>
                    </div>
                </footer>
            </div>

            <!-- EL CODIGO ESTA QUEMADO AQUI, NO FUNCIONA REFERENCIA A LOS ARCHIVOS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
            <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('reporteForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Evitar que se envíe el formulario normalmente

                        // Obtener el tipo de reporte y las fechas del formulario
                        var tipoReporte = document.getElementById('tipoReporte').value;
                        var fechaInicio = document.getElementById('fechaInicio').value;
                        var fechaFin = document.getElementById('fechaFin').value;

                        // Realizar la solicitud fetch al servidor
                        fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/reportes.php?op=' + tipoReporte, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    fechaInicio: fechaInicio,
                                    fechaFin: fechaFin
                                })
                            })
                            .then(response => response.json()) // Convertir la respuesta a JSON
                            .then(data => {
                                // Crear la tabla con los datos del reporte
                                var tableHTML = '<table class="table">';
                                tableHTML += '<thead><tr>';
                                tableHTML += '<th>ELABORADO POR</th>';
                                tableHTML += '<th>FECHA</th>';
                                tableHTML += '<th>MONTO</th>';
                                tableHTML += '<th>DESCRIPCIÓN</th>';
                                tableHTML += '</tr></thead>';
                                tableHTML += '<tbody>';
                                data.forEach(item => {
                                    tableHTML += '<tr>';
                                    tableHTML += `<td>${item.CREADO_POR}</td>`;
                                    tableHTML += `<td>${item.FECHA}</td>`;
                                    tableHTML += `<td>${item.MONTO}</td>`;
                                    // Verificar si la descripción es nula
                                    if (item.DESCRIPCION !== null) {
                                        tableHTML += `<td>${item.DESCRIPCION}</td>`;
                                    } else {
                                        tableHTML += '<td></td>'; // Si la descripción es nula, asignar una celda vacía
                                    }
                                    tableHTML += '</tr>';
                                });
                                tableHTML += '</tbody></table>';

                                tableHTML += '</tbody></table>';

                                // Mostrar la tabla en el contenedor
                                document.getElementById('reporteContainer').innerHTML = tableHTML;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });

                });
            </script>
</body>

</html>