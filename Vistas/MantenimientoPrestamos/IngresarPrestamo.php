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

$permisosPrestamo1 = new PermisosUsuarios();
$usuario_obj = new Usuario();

$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
//---------------------PERMISOS DE LOS MANTENIMIENTOS----------------------
$id_objeto_Usuario = "2";
$id_objeto_Bitacora = "14";
$id_objeto_Error = "33";
$id_objeto_Estados = "6";
$id_objeto_Historial = "34";
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
$permisosUsuario = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisosBitacora = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosError = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Error);
$permisosEstados = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosHistorial = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Historial);
$permisosObjetos = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);

//-------------------------Mant.Empleado----------
$permisosSucursal = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);


$permisos = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisos0 = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);
$permisos1 = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos3 = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);

$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

if (isset($_GET['ID_EMPLEADO'])) {
    $ID_EMPLEADO = $_GET['ID_EMPLEADO'];
    $_SESSION['id_empleado'] = $ID_EMPLEADO;
} else {
    echo "No se proporcionó el ID_EMPLEADO en la URL.";
}

//---------CONEXION A LA TABLA EMPLEADOS --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT PRIMER_NOMBRE, PRIMER_APELLIDO FROM tbl_me_empleados WHERE ID_EMPLEADO= $ID_EMPLEADO ";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$nombre_empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unir el primer nombre y apellido
$nombre_empleado_unido = implode(" ", $nombre_empleado[0]);

//------------------------------------------------------------------------

//---------CONEXION A LA TABLA TIPO PRESTAMO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT id_tipo_prestamo, tipo_prestamo FROM tbl_mp_tipo_prestamo";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$TipoPrestamo = $stmt->fetchAll(PDO::FETCH_ASSOC);
//-----------------------------------------------------------------------------

//---------CONEXION A LA TABLA FORMA DE PAGO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT id_fpago, forma_de_pago FROM tbl_formapago";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$formaPago = $stmt->fetchAll(PDO::FETCH_ASSOC);

//------------------------------------------------------------------------------------
// Traer tipo de cuentas

$sql1 = "SELECT ID_TIPOCUENTA, TIPO_CUENTA FROM tbl_mc_tipocuenta";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$TiposCuentas = $stmt1->fetchAll(PDO::FETCH_ASSOC);

//---------CONEXION A LA TABLA TIPO PRESTAMO TASA --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT id_tipo_prestamo, tasa_maxima,tasa_minima FROM tbl_mp_tipo_prestamo";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$TipoPrestamoTasa = $stmt->fetchAll(PDO::FETCH_ASSOC);
//-----------------------------------------------------------------------------

//---------CONEXION A LA TABLA TIPO PRESTAMO PLAZO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT id_tipo_prestamo, plazo_maximo,plazo_minimo FROM tbl_mp_tipo_prestamo";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$TipoPrestamoPlazo = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        color: green;
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
    <title>Vista Prestamo</title>
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
        <!-- Icono de Atras -->
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
                        //------------------------MODULO DE SEGURIDAD--------------------------------
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
                                if (!empty($permisosError) && $permisosError[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/error.php"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i><span style="margin-left: 5px;"> Error </a>';
                                }
                                if (!empty($permisosHistorial) && $permisosHistorial[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoUsuario/historial_contrasena.php"><i class="fas fa-history" aria-hidden="true"></i><span style="margin-left: 5px;"> H. Contraseña </a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        //------------------------MODULO DE EMPLEADO--------------------------------
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
                    <div class="small">Usuario: <?php echo $nombre_usuario; ?></div>
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
                        <div class="col-lg-10">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body">
                                    <div class="grid-row align-items-center">
                                        <div class="col-9 bel-padding-reset">
                                            <div class="display-flex flex-direction-column">
                                                <h2 class="bel-typography bel-typography-h2" style="font-family: sans-serif;">Cuentas y Prestamos</h2>
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
                        <div class="accordion col-lg-10" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Prestamos
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#crearModalP"> Nuevo</button>
                                        </div>
                                        <div style="max-height: 400px; overflow-y: auto;">
                                            <table class="table table-bordered mx-auto" id="Lista-Prestamos" style="margin-top: 20px; margin-bottom: 20px">
                                                <thead>
                                                    <tr>
                                                       <th scope="col">Id</th>
                                                        <th scope="col">Plazo Prestamo</th>
                                                        <th scope="col">Forma Pago</th>
                                                        <th scope="col">Monto</th>
                                                        <th scope="col">Saldo Adeudado</th>
                                                        <th scope="col">Fecha Aprobado</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Cuentas
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <button class="btn  btn-outline-success" data-toggle="modal" data-target="#crearModalC"> Nuevo</button>
                                        </div>
                                        <table class="table table-bordered mx-auto" id="Lista-Cuentas" style="margin-top: 20px; margin-bottom: 20px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Numero De Cuenta</th>
                                                    <th scope="col">Saldo</th>
                                                    <th scope="col">Acciones</th>
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

                    <!-- Modal para crear un nuevo registro de prestamo -->
                    <div class="modal fade" id="crearModalP" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
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
                                            <label for="tipoPrestamo">Tipo Prestamo</label>
                                            <select class="form-control" id="agregar-tipoPrestamo" name="tipoPrestamo" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($TipoPrestamo as $tipo) : ?>
                                                    <option value="<?php echo $tipo['id_tipo_prestamo']; ?>"><?php echo $tipo['tipo_prestamo']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="FPago">Forma de Pago</label>
                                            <select class="form-control" id="agregar-formaPago" name="formaPago" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($formaPago as $formaPago) : ?>
                                                    <option value="<?php echo $formaPago['id_fpago']; ?>"><?php echo $formaPago['forma_de_pago']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <!-- Segundo select para la tasa, inicialmente vacío -->
                                            <label for="tipoPrestamoTasa">Tasa (menor a mayor)</label>
                                            <select class="form-control" id="agregar-tipoPrestamoTasa" name="tipoPrestamoTasa" required>
                                                <option value="" disabled selected>Selecciona un tipo de préstamo primero</option>
                                            </select>

                                            <!-- Segundo select para la plazo, inicialmente vacío -->
                                            <label for="tipoPrestamoPlazo">Plazo en Meses (menor a mayor)</label>
                                            <select class="form-control" id="agregar-tipoPrestamoPlazo" name="tipoPrestamoPlazo" required>
                                                <option value="" disabled selected>Selecciona un tipo de préstamo primero</option>
                                            </select>

                                            <label for="MSolicitado">Monto Solicitado</label>
                                            <input type="text" class="form-control" id="agregar-MSolicitado" required pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un monto válido (hasta 8 dígitos enteros y 2 decimales)">
                                            <div id="mensaje1"></div>


                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-agregarCancelar" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-agregarP" disabled>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para crear un nuevo registro de cuentas -->
                    <div class="modal fade" id="crearModalC" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
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

                                            <label for="NumeroCuenta">Numero De Cuenta</label>
                                            <input type="text" maxlength="10" class="form-control" id="NumeroCuenta" required pattern="^[0-9-]+$" title="Ingrese un número de cuenta válido (solo números y -)">
                                            <div id="mensaje2"></div>

                                            <label for="id-tipo-cuenta">Tipo Cuenta</label>
                                            <select class="form-control" id="agregar-tipo-cuenta" name="Id-tipo-cuenta" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($TiposCuentas as $TiposCuentas) : ?>
                                                    <option value="<?php echo $TiposCuentas['ID_TIPOCUENTA']; ?>"><?php echo $TiposCuentas['TIPO_CUENTA']; ?></option>
                                                <?php endforeach; ?>

                                            </select>

                                            <label for="Estado">Estado</label>
                                            <select class="form-control" id="agregar-estado" maxlength="15" name="estado" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="INACTIVO">INACTIVO</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-agregarC" disabled>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para hacer un deposito -->
                    <div class="modal fade" id="DepositoModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel">Hacer Deposito</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición -->
                                    <form>
                                        <div class="form-group">
                                            <input style="display:none" type="text" class="form-control" id="id-cuenta-edit" disabled>
                                            <label for="numero">Numero De Cuenta</label>
                                            <input type="text" class="form-control" id="Numero-Cuenta" disabled>
                                            <label for="saldo">Saldo</label>
                                            <input type="text" class="form-control" id="Saldo" disabled>
                                            <label for="Deposito">Monto De Deposito</label>

                                            <input type="text" class="form-control" id="Monto_Deposito " required pattern="[0-9]{1,8}(\.[0-9]{0,2})?" title="Ingrese un depósito válido (hasta 8 dígitos enteros y 2 decimales)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && this.value.indexOf('.') === -1)">
                                            <div id="mensaje3"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-enviar-deposito" disabled>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para hacer un reembolso -->
                    <div class="modal fade" id="ReembolsoModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel">Hacer Reembolso</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición -->
                                    <form>
                                        <div class="form-group">
                                            <input style="display:none" type="text" class="form-control" id="id-cuenta-editR" disabled>
                                            <label for="numero">Numero De Cuenta</label>
                                            <input type="text" class="form-control" id="Numero-CuentaR" disabled>
                                            <label for="saldo">Saldo</label>
                                            <input type="text" class="form-control" id="SaldoR" disabled>
                                            <label for="Deposito">Monto De Reembolso</label>
                                            <input type="text" class="form-control" id="Monto_Reembolso" required pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un retiro válido (hasta 8 dígitos enteros y 2 decimales)" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46 && this.value.indexOf('.') === -1)">
                                            <div id="mensaje4"></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-cancelarEditar1" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-enviar-reembolso" disabled>Guardar</button>
                                </div>
                            </div>

                        </div>
                    </div>
            </main>
        </div>
    </div>

<!-- Modal Alerta Re -->

    <script>
        var permisos = <?php echo json_encode($permisos); ?>;

        function Lista_Prestamos() {
            var data = {
                "ID_EMPLEADO": <?php echo $ID_EMPLEADO; ?>,
            };

            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=GetPrestamo', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(data) {
                    // Ordenar los datos por fecha de aprobación (asumiendo que FECHA_APROBACION es la clave para la fecha)
                    data.sort(function(a, b) {
                        return new Date(b.FECHA_APROBACION) - new Date(a.FECHA_APROBACION);
                    });

                    var tbody = document.querySelector('#Lista-Prestamos tbody');
                    tbody.innerHTML = '';

                    data.forEach(async function(prestamo) {
                        var row = '<tr>' +
                            '<td >' + prestamo.ID_PRESTAMO + '</td>' +
                            '<td>' + prestamo.PLAZO + ' meses</td>' +
                            '<td style="display:none;">' + prestamo.ID_FPAGO + '</td>' +
                            '<td>' + prestamo.FORMA_DE_PAGO + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(prestamo.MONTO_SOLICITADO)) + '</td>' +
                            '<td class="texto-derecha">' + (isNaN(await SaldoTotal(prestamo.ID_PRESTAMO)) ? '' : formatoNumero(parseFloat(await SaldoTotal(prestamo.ID_PRESTAMO)))) + '</td>' +
                            '<td>' + prestamo.FECHA_APROBACION + '</td>' +
                            '<td>' + prestamo.ESTADO_PRESTAMO + '</td>' +
                            '<td>';
                        row += '<button class="btn btn-outline-secondary" data-id="' + prestamo.ID_PRESTAMO + '" onclick="redirectToPlanPago(' + prestamo.ID_PRESTAMO + ')">Cuota</button>';

                        row += '</td>' +
                            '</tr>';

                        newrow = row.replaceAll("null", " ");
                        row = newrow;
                        tbody.innerHTML += row;
                    });
                })
                .catch(function(error) {
                    console.error('Error al cargar los datos: ' + error.message);
                });
        }


        function Insertar_Prestamo() {

            $("#btn-agregarP").click(function() {
                var tipoPrestamo = document.getElementById("agregar-tipoPrestamo").value;
                var formaPago = document.getElementById("agregar-formaPago").value;
                var montoSolicitado = $("#agregar-MSolicitado").val();
                var plazo = $("#agregar-tipoPrestamoPlazo").val();
                var tasa = $("#agregar-tipoPrestamoTasa").val();

                if (tipoPrestamo == "" || formaPago == "" || montoSolicitado == "" || tasa == "" || plazo == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    var datos = {
                        ID_EMPLEADO: <?php echo $ID_EMPLEADO; ?>,
                        ID_TIPO_PRESTAMO: tipoPrestamo,
                        ID_FPAGO: formaPago,
                        PLAZO: plazo,
                        TASA: tasa,
                        MONTO_SOLICITADO: montoSolicitado,
                        ESTADO_PRESTAMO: "PENDIENTE"
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=ValidarMonto', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(datos)
                        })
                        .then(function(response) {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Error en la solicitud');
                            }
                        })
                        .then(function(data) {
                            console.log(data);
                            var responseData = JSON.parse(data);
                            var isValid = responseData.valido === true || responseData.valido === 'true'; // Comparar con booleano o string 'true'
                            if (isValid) {
                                // Si el monto es válido, procede a insertar el préstamo
                                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=InsertPrestamo', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(datos)
                                    })
                                    .then(function(response) {
                                        if (response.ok) {
                                            return response.json();
                                        } else {
                                            throw new Error('Error en la solicitud de inserción');
                                        }
                                    })
                                    .then(function(data) {
                                        console.log(data);
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado exitoso',
                                            text: 'Los datos se han guardado correctamente.'
                                        }).then(function() {
                                            window.location.href = 'prestamo.php';
                                        });
                                    })
                                    .catch(function(error) {
                                        console.log(error.message);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Error al guardar los datos: ' + error.message
                                        });
                                    });
                            } else {
                                // Suponiendo que estás llamando a validarMonto y recibiendo la respuesta en 'data'
                                var responseData = JSON.parse(data);

                                console.log('Monto Mínimo Permitido:', responseData.montoMaximo);
                                montoMaximo = responseData.montoMaximo;
                                cantidadRestante = responseData.cantidadRestante;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Su monto maximo es de Lps.' + montoMaximo + ' ,Pero tiene prestamos activos, su saldo restante a prestar es de Lps. '+ cantidadRestante
                                });
                            }
                        })
                        .catch(function(error) {
                            console.log(error.message);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar los datos: ' + error.message
                            });
                        });
                }
            });
        }

        async function SaldoTotal(ID_PRESTAMO) {
            try {
                const response = await fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=SaldoTotal', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_PRESTAMO": ID_PRESTAMO
                    })
                });

                if (!response.ok) {
                    throw new Error('Error en la solicitud');
                }

                const data = await response.json();

                // Verificar si SALDO_TOTAL es un número
                const saldoTotal = parseFloat(data[0]?.SALDO_TOTAL);

                // Verificar si es NaN o indefinido
                return isNaN(saldoTotal) ? 0 : saldoTotal;
            } catch (error) {
                console.error('Error en la solicitud:', error.message);
                return 0; // o podrías devolver NaN o cualquier otro valor predeterminado
            }
        }


        //FUNCIONES PARA CUENTAS
        function Lista_Cuentas() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado

            var data = {
                "ID_EMPLEADO": <?php echo $ID_EMPLEADO; ?>,
            };

            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=GetCuenta_Emple', {
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
                    var tbody = document.querySelector('#Lista-Cuentas tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(cuenta) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + cuenta.ID_CUENTA + '</td>' +
                            '<td>' + cuenta.NUMERO_CUENTA + '</td>' +
                            '<td class="texto-derecha">' + formatoNumero(parseFloat(cuenta.SALDO)) + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar
                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-outline-primary" data-toggle="modal" data-target="#DepositoModal" onclick="CargarCuenta(' + cuenta.ID_CUENTA + ')">Deposito</button>';
                            row += '<button class="btn btn-outline-secondary" crear-movimiento" data-toggle="modal" data-target="#ReembolsoModal" onclick="CargarCuentaR(' + cuenta.ID_CUENTA + ')">Retiro</button>';
                            row += '<button class="btn btn-outline-info" crear-movimiento" data-id="' + cuenta.ID_CUENTA + '" onclick="redirectToHistorialCuenta(' + cuenta.ID_CUENTA + ')">Historial Transaccional</button>';
                        }

                        row += '</td>' +
                            '</tr>';
                        //Cambiar palabra null por vacio.
                        newrow = row.replaceAll("null", " ");
                        row = newrow;
                        tbody.innerHTML += row;
                    });
                    //habilitarPaginacion();
                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }

        function Insertar_Cuenta() {
            $("#btn-agregarC").click(function() {
                // Obtener los valores de los campos del formulario
                var tipo_cuenta = $("#agregar-tipo-cuenta").val();
                var estado = $("#agregar-estado").val();
                var NumeroCuenta = $("#NumeroCuenta").val();
                var saldo = 0;

                if (tipo_cuenta == "" || estado == "" || NumeroCuenta == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un tipo_cuenta con los datos a enviar al servidor
                    var datos = {
                        ID_EMPLEADO: <?php echo $ID_EMPLEADO; ?>,
                        ID_TIPOCUENTA: tipo_cuenta,
                        SALDO: saldo,
                        NUMERO_CUENTA: NumeroCuenta,
                        ESTADO: estado
                    };
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=InsertCuenta', {

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
                                        $('#crearModalC').modal('hide');
                                        // Mostrar SweetAlert de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado exitoso',
                                            text: data.message
                                        }).then(function() {
                                            // Recargar la página para mostrar los nuevos datos
                                            window.location.href = '../MantenimientoCuentas/MantenimientoCuentas.php';
                                        });
                                    });
                                } else if (response.status === 409) {
                                    // Si el código de respuesta es 409 (Conflict), muestra mensaje de TIPO CUENTA existente
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
                                throw new Error('El registro ya existe en la Base de Datos.');
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

        // REDIRIGIR A HISTORIAL 
        function redirectToPlanPago(ID_PRESTAMO, ID_EMPLEADO) {
            // Redirigir a la página Plan_pago con el parametro ID_PRESTAMO
            // window.location.href = 'plan_pago.php?ID_PRESTAMO=' + ID_PRESTAMO;
            window.location.href = 'cuota.php?ID_PRESTAMO=' + ID_PRESTAMO;

        }
        // REDIRIGIR A HISTORIAL 
        function redirectToHistorialCuenta(ID_CUENTA) {
            // Redirigir a la página HistorialCuenta.php con el parámetro ID_CUENTA
            window.location.href = '../MantenimientoPrestamos/HistorialCuenta.php?ID_CUENTA=' + ID_CUENTA;
        }

        function CargarCuenta(id) {
            var data = {
                "ID_CUENTA": id
            };

            // Realiza una solicitud FETCH para obtener los detalles de la forma de pago por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=GetCuenta', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte la forma de pago en formato JSON

                })

                .then(function(response) {

                    if (response.ok) {

                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(cuenta) {


                    // Convertir el array a un objeto
                    cuenta = Object.assign({}, cuenta[0]);

                    // Llena los campos del modal con los datos de la forma de pago
                    document.getElementById('id-cuenta-edit').value = cuenta.ID_CUENTA;
                    document.getElementById('Numero-Cuenta').value = cuenta.NUMERO_CUENTA;
                    document.getElementById('Saldo').value = cuenta.SALDO;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos de la forma de pago: ' + error.message);
                });
        }

        function CargarCuentaR(id) {
            var data = {
                "ID_CUENTA": id
            };

            // Realiza una solicitud FETCH para obtener los detalles de la forma de pago por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=GetCuenta', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte la forma de pago en formato JSON

                })

                .then(function(response) {

                    if (response.ok) {

                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(cuenta) {


                    // Convertir el array a un objeto
                    cuenta = Object.assign({}, cuenta[0]);

                    // Llena los campos del modal con los datos de la forma de pago
                    document.getElementById('id-cuenta-editR').value = cuenta.ID_CUENTA;
                    document.getElementById('Numero-CuentaR').value = cuenta.NUMERO_CUENTA;
                    document.getElementById('SaldoR').value = cuenta.SALDO;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos de la forma de pago: ' + error.message);
                });
        }

        function Deposito() {
            $("#btn-enviar-deposito").click(function() {
                // Obtener los valores de los campos del formulario

                var id_cuenta = document.getElementById("id-cuenta-edit").value; // Obtener el valor del select
                var deposito = document.getElementById("Monto_Deposito ").value; // Obtener el valor del select
                // Crear un objeto con los datos a enviar al servidor
                var datos = {
                    ID_CUENTA: id_cuenta,
                    DEPOSITO: deposito
                }
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=DepositoCuenta', {
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
                        $('#DepositoModal').modal('hide');

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

        function Reembolso() {
            $("#btn-enviar-reembolso").click(function() {
                // Obtener los valores de los campos del formulario

                var id_cuenta = document.getElementById("id-cuenta-editR").value; // Obtener el valor del select
                var reembolso = document.getElementById("Monto_Reembolso").value; // Obtener el valor del select
                // Crear un objeto con los datos a enviar al servidor
                var datos = {
                    ID_CUENTA: id_cuenta,
                    REEMBOLSO: reembolso
                }
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=ReembolsoCuenta', {
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
                        $('#ReembolsoModal').modal('hide');

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


        function validarMonto(ID_EMPLEADO) {
            // Obtener el valor ingresado en el campo de texto
            var montoSolicitado = $("#agregar-MSolicitado").val();
            // Realiza una solicitud FETCH al servidor para anular el préstamo
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=ValidarMonto', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_EMPLEADO": ID_EMPLEADO,
                        "MONTO_SOLICITADO": monto
                    })
                })
                .then(response => {
                    if (response.ok) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Desembolso Realizado',
                            text: 'El Desembolso ha sido realizado exitosamente.'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 5000)
                    } else {
                        console.error('Error en la solicitud');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            var agregarMSolicitado = document.getElementById("agregar-MSolicitado");
            var agregarNumeroCuenta = document.getElementById("NumeroCuenta");
            var agregarDeposito = document.getElementById("Monto_Deposito ");
            var agregarRetiro = document.getElementById("Monto_Reembolso");

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
                inputElement.addEventListener("input", function() {
                    validateInput(inputElement, expression, messageElement, message);
                });

                inputElement.addEventListener("blur", function() {
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

            var expresionValidadora1 = /^\d+(\.\d{2})?$/;
            var mensaje1 = document.getElementById("mensaje1");
            handleInputAndBlurEvents(agregarMSolicitado, expresionValidadora1, mensaje1, "Ingrese un monto válido (por ejemplo, 1000.00)");

            var expresionValidadora2 = /^[0-9-]+/;
            var mensaje2 = document.getElementById("mensaje2");
            handleInputAndBlurEvents(NumeroCuenta, expresionValidadora2, mensaje2, "Ingrese un número de cuenta válido (solo números y -)");

            var mensaje3 = document.getElementById("mensaje3");
            handleInputAndBlurEvents(Monto_Deposito, expresionValidadora1, mensaje3, "Ingrese un deposito válido (por ejemplo, 1000.00)");

            var mensaje4 = document.getElementById("mensaje4");
            handleInputAndBlurEvents(Monto_Reembolso, expresionValidadora1, mensaje4, "Ingrese un retiro válido (por ejemplo, 1000.00)");

        }

        //FUNCION SEPARADOR DE MILES Y DECIMALES
        function formatoNumero(numero) {
            return numero.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        $(document).ready(function() {
            Lista_Prestamos();
            Insertar_Prestamo();

            Lista_Cuentas();
            Insertar_Cuenta();
            Deposito();
            Reembolso();
            //validarMonto();
            validarNombre();
        });
    </script>

    <script>

    </script>
    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const agregartipoPrestamo = document.getElementById("agregar-tipoPrestamo");
        const agregarformaPago = document.getElementById("agregar-formaPago");
        const agregarTasa = document.getElementById("agregar-tipoPrestamoTasa");
        const agregarPlazo = document.getElementById("agregar-tipoPrestamoPlazo");
        const agregarMSolicitadoInput = document.getElementById("agregar-MSolicitado");
        const guardarButton = document.getElementById('btn-agregarP');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = agregartipoPrestamo.value.trim() !== '' && agregarformaPago.value.trim() !== '' && agregarTasa.value.trim() !== '' && agregarPlazo.value.trim() !== '' && agregarMSolicitadoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        agregartipoPrestamo.addEventListener('input', checkForm);
        agregarformaPago.addEventListener('input', checkForm);
        agregarTasa.addEventListener('input', checkForm);
        agregarPlazo.addEventListener('input', checkForm);
        agregarMSolicitadoInput.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-tipoPrestamo, #agregar-formaPago, #agregar-MSolicitado, #agregar-tipoPrestamoTasa, #agregar-tipoPrestamoPlazo').on('input', function() {
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
    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const agregarNCuenta = document.getElementById("NumeroCuenta");
        const agregarTipoCuenta = document.getElementById("agregar-tipo-cuenta");
        const agregarEstado = document.getElementById("agregar-estado");
        const guardarButton1 = document.getElementById('btn-agregarC');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = agregarNCuenta.value.trim() !== '' && agregarTipoCuenta.value.trim() !== '' && agregarEstado.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        agregarNCuenta.addEventListener('input', checkForm);
        agregarTipoCuenta.addEventListener('input', checkForm);
        agregarEstado.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const agregarDeposito = document.getElementById("Monto_Deposito ");
        const guardarButton2 = document.getElementById('btn-enviar-deposito');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = agregarDeposito.value.trim() !== '';
            guardarButton2.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        agregarDeposito.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const agregarRetiro = document.getElementById("Monto_Reembolso");
        const guardarButton3 = document.getElementById('btn-enviar-reembolso');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = agregarRetiro.value.trim() !== '';
            guardarButton3.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        agregarRetiro.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#NumeroCuenta, #agregar-tipo-cuenta, #agregar-estado, #Monto_Deposito , #Monto_Reembolso').on('input', function() {
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
        document.getElementById('btn-agregarCancelar').addEventListener('click', function() {
            document.getElementById('agregar-tipoPrestamo').value = "";
            document.getElementById('agregar-formaPago').value = "";
            document.getElementById('agregar-MSolicitado').value = "";
            document.getElementById('agregar-tipoPrestamoTasa').value = "";
            document.getElementById('agregar-tipoPrestamoPlazo').value = "";
            // Limpia los checkboxes
            document.getElementById('agregar-tipoPrestamo').checked = false;
            document.getElementById('agregar-formaPago').checked = false;
            document.getElementById('agregar-MSolicitado').checked = false;
            document.getElementById('agregar-tipoPrestamoTasa').checked = false;
            document.getElementById('agregar-tipoPrestamoPlazo').checked = false;
            location.reload();
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL AGREGAR--------------------
        document.getElementById('btn-cancelarAgregar').addEventListener('click', function() {
            document.getElementById('NumeroCuenta').value = "";
            document.getElementById('agregar-tipo-cuenta').value = "";
            document.getElementById('agregar-estado').value = "";

            // Limpia los checkboxes
            document.getElementById('NumeroCuenta').checked = false;
            document.getElementById('agregar-tipo-cuenta').checked = false;
            document.getElementById('agregar-estado').checked = false;
            location.reload();
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {
            document.getElementById('Monto_Deposito ').value = "";

            // Limpia los checkboxes
            document.getElementById('Monto_Deposito ').checked = false;
            location.reload();
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar1').addEventListener('click', function() {
            document.getElementById('Monto_Reembolso').value = "";

            // Limpia los checkboxes
            document.getElementById('Monto_Reembolso').checked = false;
            location.reload();
        });
    </script>

    <script>
        var TipoPrestamoTasa = <?php echo json_encode($TipoPrestamoTasa); ?>;
        // Obtener referencias a los elementos select
        const tipoPrestamoSelect = document.getElementById('agregar-tipoPrestamo');
        const tipoPrestamoTasaSelect = document.getElementById('agregar-tipoPrestamoTasa');

        // Evento que se dispara cuando se selecciona un tipo de préstamo
        tipoPrestamoSelect.addEventListener('change', function() {

            // console.log("Cambio detectado"); // Obtener el valor seleccionado
            const selectedTipoPrestamo = tipoPrestamoSelect.value;

            // Limpiar el select de tasa
            tipoPrestamoTasaSelect.innerHTML = '';

            // Recorrer el array $TipoPrestamoTasa y agregar opciones al select de tasa
            TipoPrestamoTasa.forEach(tasa => {
                // console.log("tasa.id_tipo_prestamo:", tasa.id_tipo_prestamo);
                // console.log("selectedTipoPrestamo:", selectedTipoPrestamo);

                if (tasa.id_tipo_prestamo === parseInt(selectedTipoPrestamo)) {
                    // Crear un rango de números entre tasa_minima y tasa_maxima
                    for (let i = tasa.tasa_minima; i <= tasa.tasa_maxima; i++) {
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = i;
                        tipoPrestamoTasaSelect.appendChild(option);
                    }
                }

            });
        });
    </script>

    <script>
        var TipoPrestamoPlazo = <?php echo json_encode($TipoPrestamoPlazo); ?>;
        // Obtener referencias a los elementos select
        const tipoPrestamoSelect1 = document.getElementById('agregar-tipoPrestamo');
        const tipoPrestamoPlazoSelect = document.getElementById('agregar-tipoPrestamoPlazo');

        // Evento que se dispara cuando se selecciona un tipo de préstamo
        tipoPrestamoSelect1.addEventListener('change', function() {

            console.log("Cambio detectado"); // Obtener el valor seleccionado
            const selectedTipoPrestamo = tipoPrestamoSelect1.value;

            // Limpiar el select de tasa
            tipoPrestamoPlazoSelect.innerHTML = '';

            // Recorrer el array $TipoPrestamoPlazo y agregar opciones al select de tasa
            TipoPrestamoPlazo.forEach(plazo => {


                if (plazo.id_tipo_prestamo === parseInt(selectedTipoPrestamo)) {

                    // console.log("tasa.id_tipo_prestamo:", plazo.id_tipo_prestamo);
                    //  console.log("selectedTipoPrestamo:", selectedTipoPrestamo);

                    // Crear un rango de números entre plazo_minimo y plazo_maximo
                    for (let i = plazo.plazo_minimo; i <= plazo.plazo_maximo; i++) {
                        const option = document.createElement('option');
                        option.value = i;
                        option.textContent = i;
                        tipoPrestamoPlazoSelect.appendChild(option);
                    }
                }

            });
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>
<html>