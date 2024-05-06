<!-- -----------------------------------------------------------------------
	Universidad Nacional Autonoma de Honduras (UNAH)
		Facultad de Ciencias Economicas
	Departamento de Informatica administrativa
         Analisis, Programacion y Evaluacion de Sistemas
                    Tercer Periodo 2023


Equipo:
Sahory Garcia          sahori.garcia@unah.hn
Jairo Garcia           jairo.lagos@unah.hn
Ashley Matamoros       Ashley.matamoros@unah.hn
Lester Padilla         Lester.padilla@unah.hn
Khaterine Ordoñez      khaterine.ordonez@unah.hn
Yeniffer Velasquez     yeniffer.velasquez@unah.hn
Kevin Zuniga           kgzuniga@unah.hn

Catedratico analisis y diseño: Lic. Giancarlos Martini Scalici Aguilar
Catedratico programacion e implementacion: Lic. Karla Melisa Garcia Pineda 
Catedratico evaluacion de sistemas: ???


---------------------------------------------------------------------

Programa:         Pantalla de Ingresar Prestamo
Fecha:            
Programador:     
descripcion:      Pantalla que registra los prestamos para un empleado en especifico

-----------------------------------------------------------------------

                Historial de Cambio

-----------------------------------------------------------------------

Programador               Fecha                      Descripcion
Kevin Zuniga              25-nov-2023                 Se agrego reporteria y rutas hacia otras nuevas vistas, ademas de algunos detalles esteticos
Sahori Garcia             29-11-2023                   Se agrego separador de miles y decimales, alineacion a la derecha valores monetarios
Sahori Garcia             29-11-2023                   Agregar boton atra y adelante 
Sahori Garcia             30-11-2023                   Cambio de permisos y objetos
------------------------------------------------------------------------->

<?php

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";
require_once '../../Modelos/Usuarios.php';

$permisosPrestamo = new PermisosUsuarios();
$usuario_obj = new Usuario();

if (isset($_GET['ID_PRESTAMO'])) {
    $ID_PRESTAMO = $_GET['ID_PRESTAMO'];
} else {
    echo "No se proporcionó la cuenta en la URL.";
}

// if (isset($_GET['ID_EMPLEADO'])) {
//     $ID_EMPLEADO = $_GET['ID_EMPLEADO'];
// } else {
//     echo "No se proporcionó el ID_EMPLEADO en la URL.";
// }

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_empleado = $_SESSION['id_empleado'];
$id_objeto_MantenimientoPlanPago = "32";
//VALIDAR CUOTAS , HISTORIAL CONTRASEÑA , BOTON MOVIMIENTO DE LOS MANTEMINIENTOS, VISTA COMPARTIDA DE CUENTAAS Y PRESTAMOS
//---------------------PERMISOS DE LOS MANTENIMIENTOS----------------------
$id_objeto_Usuario = "2";
$id_objeto_Bitacora = "14";
$id_objeto_Estados = "6";
$id_objeto_Objetos = "5";
$id_objeto_Parametro = "4";
$id_objeto_Permisos = "3";
$id_objeto_Roles = "1";
//------OBJETOS DE MANT.EMPLEADOS-------------
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
$id_objeto_Empleado = "27";
$id_objeto_Cuentas = "36";
$id_objeto_Prestamos = "35";
//------------------------------------------------------------------------------
$permisosUsuario = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisosBitacora = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosEstados = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosObjetos = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);

//-------------------------Mant.Empleado----------
$permisosSucursal = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);


$permisos = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_MantenimientoPlanPago);
$permisos1 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos3 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosPrestamo->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);

$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../InicioSesion/login.php");
    exit();
}

// //---------CONEXION A LA TABLA EMPLEADOS --------
// // Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT PRIMER_NOMBRE, PRIMER_APELLIDO FROM tbl_me_empleados WHERE ID_EMPLEADO= $id_empleado";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$nombre_empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unir el primer nombre y apellido
$nombre_empleado_unido = implode(" ", $nombre_empleado[0]);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../InicioSesion/login.php");
    exit();
}

//-----------------------------------------------------------------------------
?>
<style>
    .logo {
        width: 50px;
        /* Ancho deseado del logo */
        margin-right: 10px;
        /* Espacio a la derecha del logo para separarlo del texto */

        /* Define a custom CSS class for success messages */
    }

    .success-message {
        color: green;
        /* Change the color to your preferred color */
        font-weight: bold;
        /* Optionally make the text bold */
    }

    #Lista-Cuota td.texto-derecha {
        text-align: right;
    }



    .texto-derecha {
        text-align: right;
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

    .bel-typography {
        font-family: Arial;
    }

    .btn.btn-link.collapsed {
        font-family: 'Open Sans', sans-serif;
        font-weight: 800;
        /* Grosor de fuente deseado */
        font-size: 20px;
        /* Tamaño de fuente deseado */
        color: blue;
        /* Color del texto */
    }
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Cuota Actual</title>
    <link rel="shortcut icon" href="../../src/IconoIDH.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="../../InicioSesion/index.php">
            <img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <!-- Icono de Atrás -->
        <a href="javascript:history.back()" class="icono"><i class="fas fa-chevron-circle-left"></i></a>
        <!-- Icono de Adelante -->
        <a href="javascript:history.forward()" class="icono"><i class="fas fa-chevron-circle-right"></i></a>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../MantenimientoUsuario/perfil.php">Perfil</a>
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
                        //----------------------MODULO DE SEGURIDAD---------------------------------------------
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
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                }
                                if (!empty($permisosRoles) && $permisosRoles[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                }
                                if (!empty($permisosEstados) && $permisosEstados[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                }
                                if (!empty($permisosPermiso) && $permisosPermiso[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                }
                                if (!empty($permisosObjetos) && $permisosObjetos[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                }
                                if (!empty($permisosParametro) && $permisosParametro[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                }
                                if (!empty($permisosBitacora) && $permisosBitacora[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
                                }
                            }

                            echo '</nav>';
                            echo '</div>';
                        }
                        //-------------------------------------MODULO DE EMPLEADO--------------------------------
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
                                    echo '<a class="nav-link" href="../MantenimientoCuentas/MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista Cuentas</a>';
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
                                    echo '<a class="nav-link" href="forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                }
                                if (!empty($permisosTipoPrestamo) && $permisosTipoPrestamo[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                }
                                if (!empty($permisosPresMantenimiento) && $permisosPresMantenimiento[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista Prestamos</a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usuario: <?php echo $usuario; ?></div>
                    Sesión activa: Conectado(a).
                </div>
            </nav>
        </div>
    </div>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body">
                                    <div class="grid-row align-items-center">
                                        <div class="col-9 bel-padding-reset">
                                            <div class="display-flex flex-direction-column">
                                                <h2 class="bel-typography bel-typography-h2" style="font-family: sans-serif;">Cuota</h2>
                                                <span class="bel-typography bel-typography-h5"><?php echo $nombre_empleado_unido; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 bel-padding-reset">
                                            <div class="display-flex justify-content-end">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="accordion col-lg-12" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Cuota A Pagar
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                        </div>
                                        <table class="table table-bordered mx-auto" id="Lista-Cuota" style="margin-top: 20px; margin-bottom: 20px">
                                            <thead>
                                                <tr>

                                                    <th scope="col" style="display: none;">Id Plan Pago</th>
                                                    <th scope="col" style="display: none;">Id Prestamo</th>
                                                    <th scope="col">N.Cuota</th>
                                                    <th scope="col">Fecha Vencimiento</th>
                                                    <th scope="col" style="display: none;">Fecha Pago</th>
                                                    <th scope="col">Cuota</th>
                                                    <th scope="col" style="display: none;">Monto Adeudado</th>
                                                    <th scope="col" style="display: none;">Monto Pagado</th>
                                                    <th scope="col">Capital Adeudado</th>
                                                    <th scope="col">Capital Pagado</th>
                                                    <th scope="col">Interes Adeudado</th>
                                                    <th scope="col">Interes Pagado</th>
                                                    <th scope="col" style="display: none;">Monto Adeudaro Mora</th>
                                                    <th scope="col" style="display: none;">Monto Pagado Mora</th>
                                                    <th scope="col">Estado Pago</th>
                                                    <th scope="col">Accion</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Cuotas Totales
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="ml-3 card" style="max-height: 400px; overflow-y: auto;">
                                                <table class="table table-bordered mx-auto" id="Lista-Cuotas" style="margin-top: 20px; margin-bottom: 20px">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" style="display: none;">Id Plan Pago</th>
                                                            <th scope="col" style="display: none;">Id Prestamo</th>
                                                            <th scope="col">N.Cuota</th>
                                                            <th scope="col">Fecha Vencimiento</th>
                                                            <th scope="col">Fecha Pago</th>
                                                            <th scope="col">Cuota</th>
                                                            <th scope="col" style="display: none;">Monto Adeudado</th>
                                                            <th scope="col" style="display: none;">Monto Pagado</th>
                                                            <th scope="col">Capital Adeudado</th>
                                                            <th scope="col">Capital Pagado</th>
                                                            <th scope="col">Interes Adeudado</th>
                                                            <th scope="col">Interes Pagado</th>
                                                            <th scope="col" style="display: none;">Monto Adeudaro Mora</th>
                                                            <th scope="col" style="display: none;">Monto Pagado Mora</th>
                                                            <th scope="col">Estado Pago</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pagoModalLabel">Pago</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Formulario de Edición -->
                                            <form>
                                                <div class="form-group">

                                                    <label>Pago de Cuota</label>

                                                    <!-- Checkbox para Pago Total -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pagoTotal" name="pago_total" value="1">
                                                        <label class="form-check-label" for="pagoTotal">Pago Total</label>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" id="btn-cancelar" data-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="btn-Aceptar" disabled>Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </main>
        </div>
    </div>

    <script>
        var permisos = <?php echo json_encode($permisos); ?>;
        var usuarioP = <?php echo json_encode($usuario); ?>;

        //FUNCION DE CUOTA ACTUAL                                       
        function Lista_CuotaActual() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            console.log("entra");
            var data = {
                "ID_PPAGO": <?php echo json_encode($ID_PRESTAMO); ?>,
            };

            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=cuotaActual', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte la forma de pago en formato JSON
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
                    var tbody = document.querySelector('#Lista-Cuota tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior
                    //console.log(data);

                    // Validar si hay datos para mostrar
                    if (data && data.ID_PLANP !== 0) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + data.ID_PLANP + '</td>' +
                            '<td style="display:none;">' + data.ID_PRESTAMO + '</td>' +
                            '<td>' + data.NUMERO_CUOTA + '</td>' +
                            '<td>' + data.FECHA_VENC_C + '</td>' +
                            '<td style="display: none;">' + data.FECHA_R_PAGO + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(data.VALOR_CUOTA)) + '</td>' +
                            '<td style="display: none;">' + data.MONTO_ADEUDADO + '</td>' +
                            '<td style="display: none;">' + data.MONTO_PAGADO + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(data.MONTO_ADEUDADO_CAP)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(data.MONTO_PAGADO_CAP)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(data.MONTO_ADEUDADO_ITS)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(data.MONTO_PAGADO_ITS)) + '</td>' +
                            '<td style="display:none;">' + data.MONTO_ADEUDADO_MORA + '</td>' +
                            '<td style="display:none;">' + data.MONTO_PAGADO_MORA + '</td>' +
                            '<td>' + data.ESTADO + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar los botones
                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-outline-primary" data-toggle="modal" data-target="#pagoModal" onclick="idplanp = ' + data.ID_PLANP + '">Pago</button>';
                        }
                        row += '</td>' +
                            '</tr>';
                        //Cambiar palabra null por vacio.
                        newrow = row.replaceAll("null", " ");
                        row = newrow;
                        tbody.innerHTML += row;
                    } else {

                        // Mostrar SweetAlert indicando que no hay datos disponibles o el préstamo no ha sido aprobado
                        Swal.fire({
                            icon: 'info',
                            title: 'Información',
                            text: 'No hay datos disponibles o el préstamo no ha sido aprobado.',
                            confirmButtonText: 'OK'
                        });
                    }

                    // Deshabilitar el botón
                    document.getElementById('botonPago').disabled = true;

                })
                .catch(function(error) {
                    // Manejar el error aquí
                    console.log('Error al cargar los datos: ' + error.message);
                });
        }

        function Lista_Cuotas() {
            // Crear un objeto con el ID del usuario
            var data = {
                "ID_PRESTAMO": <?php echo json_encode($ID_PRESTAMO); ?>,
            };

            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=GetPlanPago', {
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
                .then(function(data) {
                    // Recorre los datos JSON y agrega filas a la tabla
                    var tbody = document.querySelector('#Lista-Cuotas tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior
                    //consol.log(data);
                    data.forEach(function(plan) {
                        // Convertir el array a un objeto
                        // plan = Object.assign({}, plan[0]);
                        var row = '<tr>' +
                            '<td style="display:none;">' + plan.ID_PLANP + '</td>' +
                            '<td style="display:none;">' + plan.ID_PRESTAMO + '</td>' +
                            '<td>' + plan.NUMERO_CUOTA + '</td>' +
                            '<td>' + plan.FECHA_VENC_C + '</td>' +
                            '<td>' + plan.FECHA_R_PAGO + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(plan.VALOR_CUOTA)) + '</td>' +
                            '<td style="display: none;">' + plan.MONTO_ADEUDADO + '</td>' +
                            '<td style="display: none;">' + plan.MONTO_PAGADO + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(plan.MONTO_ADEUDADO_CAP)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(plan.MONTO_PAGADO_CAP)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(plan.MONTO_ADEUDADO_ITS)) + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(plan.MONTO_PAGADO_ITS)) + '</td>' +
                            '<td style="display:none;">' + plan.MONTO_ADEUDADO_MORA + '</td>' +
                            '<td style="display:none;">' + plan.MONTO_PAGADO_MORA + '</td>' +
                            '<td>' + plan.ESTADO + '</td>';
                        '</tr>';
                        //Cambiar palabra null por vacio.
                        newrow = row.replaceAll("null", " ");
                        row = newrow;
                        tbody.innerHTML += row;
                    });
                    // consol.log(data);
                    // Llamar a EstadoFinalizado después de cargar los datos de las cuotas
                    EstadoFinalizado(data[0].ID_PLANP, data[0].ESTADO); // Aquí asumo que ID_PLANP está disponible en el primer objeto de datos.

                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });
        }



        function PagoInteres(ID_PLANP) {
            // Obtener el estado actual del pago
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=obtenerEstadoPago', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_PPAGO": ID_PLANP
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data === 'PENDIENTE') {
                        // Realizar la acción solo si el estado es "PENDIENTE"
                        fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=PagoInteres', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    "ID_PPAGO": ID_PLANP
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Procesar la respuesta del servidor si es necesario
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pago Interes Realizado',
                                    text: 'El pago del Interes se ha realizado correctamente.'
                                }).then(function() {
                                    // Realizar otras acciones si es necesario, como cambiar el estado
                                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=PagoPEstado', {
                                            method: 'POST',
                                            headers: {
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                "ID_PPAGO": ID_PLANP
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            // Procesar la respuesta del cambio de estado si es necesario
                                            return data;
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });

                                    location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error en la solicitud:', error);
                            });
                    } else if (data === 'PARCIAL') {
                        // Puedes mostrar una alerta indicando que el pago ya ha sido realizado parcialmente
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pago Parcial',
                            text: 'El pago del Interes ya ha sido realizado parcialmente.'
                        });
                    } else if (data === 'PAGADO') {
                        // Puedes mostrar una alerta indicando que el pago ya ha sido realizado
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pago Realizado',
                            text: 'Esta cuota ya ha sido pagada.'
                        });
                    } else {
                        // Puedes manejar otros estados si es necesario
                        console.error('Error en el estado del pago:', data);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                });
        }


        function PagoTotal(ID_PLANP) {
            // Obtener el estado actual del pago
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=obtenerEstadoPago', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_PPAGO": ID_PLANP
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data === 'PENDIENTE' || data === 'PARCIAL') {
                        // Realizar la acción solo si el estado es "PENDIENTE" o "PARCIAL"
                        fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=PagoTotalCuota', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    "ID_PPAGO": ID_PLANP,
                                    "CREADO_POR" :  usuarioP
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Verificar si el estado es "PAGADO"
                                if (data.message === 'Pago De Cuota Total Realizado') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pago Realizado',
                                        text: 'El pago total de la cuota se ha realizado correctamente.'
                                    }).then(function() {
                                        // Realizar otras acciones si es necesario, como cambiar el estado
                                        fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=PagoTEstado', {
                                                method: 'POST',
                                                headers: {
                                                    'Accept': 'application/json',
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    "ID_PPAGO": ID_PLANP
                                                    
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                // Procesar la respuesta del cambio de estado si es necesario
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Cambio de Estado Realizado',
                                                    text: 'El estado del pago ha sido actualizado correctamente.'
                                                });
                                                return data;
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                            });

                                        location.reload();
                                    });
                                } else {
                                    // Si el pago ya está realizado, mostrar una alerta
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Pago ya realizado',
                                        text: 'Esta cuota ya ha sido pagada.'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error en la solicitud:', error);
                            });
                    } else if (data === 'PAGADO') {
                        // Mostrar alerta si ya está pagado
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pago ya realizado',
                            text: 'Esta cuota ya ha sido pagada.'
                        });
                    } else {
                        // Puedes manejar otros estados si es necesario
                        console.error('Error en el estado del pago:', data);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                    // Mostrar un mensaje de error al usuario
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la solicitud',
                        text: 'Se produjo un error al procesar la solicitud. Por favor, inténtalo de nuevo más tarde.'
                    });
                });
        }


        /////////////////////////ESTO FUNCIONA BIEN 
        function EstadoFinalizado(ID_PLANP, ESTADO) {
            console.log("entra estado finalizado " + ID_PLANP);
            console.log("VALORES DATA " + ESTADO);

            // Contar las cuotas pendientes
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=estadoFinalizado', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_PPAGO": ID_PLANP
                    })
                }).then(response => response.json())
                .then(responseData => {
                    console.log(responseData);
                    // Verificar si message1 está presente en responseData
                    if (responseData.hasOwnProperty('message1')) {
                        // Mostrar un SweetAlert con el mensaje
                        Swal.fire({
                            icon: 'info',
                            title: 'Préstamo Finalizado ',
                            text: responseData.message1,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud:', error);
                });
        }

        function tipoPago(ID_PLANP) {
            //console.log(ID_PLANP);
            // Verificar el estado de las casillas de verificación
            // var pagoInteres = document.getElementById('pagoInteres').checked;
            var pagoTotal = document.getElementById('pagoTotal').checked;

            // Ejecutar funciones según las casillas de verificación seleccionadas
            /*  if (pagoInteres) {
                 PagoInteres(ID_PLANP);
                 //console.log("Entra Interes");
             } */
            if (pagoTotal) {
                PagoTotal(ID_PLANP);
                //EstadoFinalizado(ID_PLANP);
                //console.log("Entra Total");
            }
        }

        function formatoNumero(numero) {
            return numero.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        $(document).ready(function() {
            Lista_CuotaActual();
            Lista_Cuotas();

        });
    </script>
    <script>
        // Agrega un evento click al botón "Cancelar"
        document.getElementById('btn-cancelar').addEventListener('click', function() {
            // Recarga la página
            location.reload();
        });
        document.getElementById('btn-Aceptar').addEventListener('click', function() {
            // Muestra un mensaje de confirmación con SweetAlert
            Swal.fire({
                title: '¿Está seguro?',
                text: 'Desear realizar el siguiente pago',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, realizar Pago'
            }).then((result) => {
                if (result.isConfirmed) {
                    tipoPago(idplanp);
                    // Si el usuario hace clic en "Sí, recargar", entonces recarga la página

                }
            });
        });
    </script>
    <script>
        // Obtén todos los checkboxes y el botón de Aceptar
        const checkboxes = document.querySelectorAll('.form-check-input');
        const btnAceptar = document.getElementById('btn-Aceptar');

        // Añade un listener a cada checkbox
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                // Verifica cuántos checkboxes están seleccionados
                const seleccionados = Array.from(checkboxes).filter(cb => cb.checked);

                // Habilita o deshabilita el botón según la cantidad de checkboxes seleccionados
                btnAceptar.disabled = seleccionados.length !== 1;
            });
        });
    </script>
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>
<html>