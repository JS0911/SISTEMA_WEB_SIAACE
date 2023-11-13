<?php

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";


$permisosPrestamo = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

if (isset($_GET['ID_PRESTAMO'])) {
    $ID_PRESTAMO = $_GET['ID_PRESTAMO'];
} else {
    echo "No se proporcionó la cuenta en la URL.";
}
$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Prestamo = "29";
$id_objeto_Seguridad = "25";
$id_objeto_Cuentas = "28";
$id_objeto_MantenimientoPlanPago = "32";

$permisos1 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_MantenimientoPlanPago);
$permisos2 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);


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
    <title>Mantenimiento Plan Pago</title>
    <link rel="shortcut icon" href="../../src/IconoIDH.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-planpago {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-planpago th {
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
        #Lista-planpago td {
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
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/tipoPrestamo.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Tipo Prestamo</a>';
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
                                echo '<a class="nav-link" href="forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                echo '<a class="nav-link" href="tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                echo '<a class="nav-link" href="plan_pago.php"><i class="fa fa-money-check-alt" aria-hidden="true"></i><span style="margin-left: 5px;"> Plan Pago</a>';
                                echo '<a class="nav-link" href="prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Prestamo</a>';
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
                            <h1 class="mt-4 mb-4">Mantenimiento Plan Pago</h1>
                        </center>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-planpago" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id Plan Pago</th>
                                    <th style="display: none;">Id Prestamo</th>
                                    <th>Numero Cuota</th>
                                    <th>Fecha Vencimiento/Cuota</th>
                                    <th>Fecha Pago</th>
                                    <th>Valor Cuota</th>
                                    <th>Monto Adeudado</th>
                                    <th>Monto Pagado</th>
                                    <th>Monto Adeudado Capital</th>
                                    <th>Monto Pagado Capital</th>
                                    <th>Monto Adeudado Interes</th>
                                    <th>Monto Pagado Interes</th>
                                    <th style="display: none;">Monto Adeudaro Mora</th>
                                    <th style="display: none;">Monto Pagado Mora</th>
                                    <th>Estado/Plan Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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

    <script>
        var permisos = <?php echo json_encode($permisos); ?>;
        var ID_PRESTAMO = <?php echo json_encode($ID_PRESTAMO); ?>;

        function Lista_PlanPago(ID_PRESTAMO) {


            // Crear un objeto con el ID del usuario
            var data = {
                "ID_PRESTAMO": ID_PRESTAMO
            };
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=GetPlanPago', {
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
                    var tbody = document.querySelector('#Lista-planpago tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior
                
                    data.forEach(function(plan) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + plan.ID_PLANP + '</td>' +
                            '<td style="display:none;">' + plan.ID_PRESTAMO + '</td>' +
                            '<td>' + plan.NUMERO_CUOTA + '</td>' +
                            '<td>' + plan.FECHA_VENC_C + '</td>' +
                            '<td>' + plan.FECHA_R_PAGO + '</td>' +
                            '<td>' + plan.VALOR_CUOTA + '</td>' +
                            '<td>' + plan.MONTO_ADEUDADO + '</td>' +
                            '<td>' + plan.MONTO_PAGADO + '</td>' +
                            '<td>' + plan.MONTO_ADEUDADO_CAP + '</td>' +
                            '<td>' + plan.MONTO_PAGADO_CAP + '</td>' +
                            '<td>' + plan.MONTO_ADEUDADO_ITS + '</td>' +
                            '<td>' + plan.MONTO_PAGADO_ITS + '</td>' +
                            '<td style="display:none;">' + plan.MONTO_ADEUDADO_MORA + '</td>' +
                            '<td style="display:none;">' + plan.MONTO_PAGADO_MORA + '</td>' +
                            '<td>' + plan.ESTADO + '</td>' +
                            '<td>';

                          // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botónes

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-secondary id="Pago_CapitalButton" onclick="PagoCapital(' + plan.ID_PLANP + ')">P Capital</button>';
                            row += '<button class="btn btn-primary" id="Pago_InteresButton" onclick="PagoInteres(' + plan.ID_PLANP + ')">P Interes</button>';
                            row += '<button class="btn btn-success" id="Pago_totalButton" onclick="PagoTotal(' + plan.ID_PLANP + ')">P Total</button>';
                        }

                            row += '</td>' +
                            '</tr>';
                            //Cambiar palabra null por vacio.
                            newrow = row.replaceAll("null", " ");
                            row = newrow;
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
            $('#Lista-planpago').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        $(document).ready(function() {
            Lista_PlanPago();
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>