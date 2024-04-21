<?php

session_start();

require "../Config/conexion.php";
require_once '../Modelos/permisoUsuario.php';
require_once '../Modelos/Usuarios.php';
require_once "../request.php";

$permisosUsuarios = new PermisosUsuarios();
$usuario_obj = new Usuario();

// Si el usuario no tiene sesión activa, redirigir a login.php
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    session_destroy();
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
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
$permisosUsuario = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisosBitacora = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosError = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Error);
$permisosEstados = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosHistorial = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Historial);
$permisosObjetos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);

//-------------------------Mant.Empleado----------
$permisosSucursal = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);
//------------------------------------------------------------------------------------
$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos1 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos3 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);

$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

$estadoUsuario = $_SESSION['id_estado_usuario'];

// Verificar si el usuario está en estado 2 o 4 y redirigir
if (isset($_SESSION['id_estado_usuario'])) {
    $estadoUsuario = $_SESSION['id_estado_usuario'];
    if ($estadoUsuario == 2 || $estadoUsuario == 4) {
        $mensajeEstado = ($estadoUsuario == 2) ? 'Su usuario se encuentra inactivo' : 'Su usuario se encuentra bloqueado.';
        echo $mensajeEstado;
        header("Location: login.php");
        exit();
    }
}
?>

<style>
    .logo {
        width: 50px;
        /* Ancho deseado del logo */
        margin-right: 10px;
        /* Espacio a la derecha del logo para separarlo del texto */
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
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Index - Pagina Principal</title>
    <link rel="shortcut icon" href="../src/IconoIDH.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

        <a class="navbar-brand" href="index.php">
            <img src="../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
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
                    <a class="dropdown-item" href="../Vistas/MantenimientoUsuario/perfil.php">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Inicio
                        </a>
                        <div class="sb-sidenav-menu-heading">Pestañas</div>

                        <?php

                        //-------------------------------------MODULO DE SEGURIDAD----------------------------
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
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                }
                                if (!empty($permisosRoles) && $permisosRoles[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                }
                                if (!empty($permisosEstados) && $permisosEstados[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                }
                                if (!empty($permisosPermiso) && $permisosPermiso[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                }
                                if (!empty($permisosObjetos) && $permisosObjetos[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                }
                                if (!empty($permisosParametro) && $permisosParametro[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                }
                                if (!empty($permisosBitacora) && $permisosBitacora[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
                                }
                                if (!empty($permisosError) && $permisosError[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/error.php"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i><span style="margin-left: 5px;"> Error </a>';
                                }
                                if (!empty($permisosHistorial) && $permisosHistorial[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/historial_contrasena.php"><i class="fas fa-history" aria-hidden="true"></i><span style="margin-left: 5px;"> H. Contraseña </a>';
                                }
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        //----------------------------------MODULO DE EMPLEADO---------------------------------
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                        Empleados
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosEmpleado) && $permisosEmpleado[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                            }
                            if (!empty($permisosCargo) && $permisosCargo[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                            }
                            if (!empty($permisosRegion) && $permisosRegion[0]['PERMISOS_CONSULTAR'] == 1) {    
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                            }
                            if (!empty($permisosSucursal) && $permisosSucursal[0]['PERMISOS_CONSULTAR'] == 1) {  
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
                            }
                        }
                            echo '</nav>';
                            echo '</div>';
                        }
                        //-------------------------------MODULO DE CUENTAS--------------------------------------
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoCuentas" aria-expanded="false" aria-controls="collapseMantenimientoCuentas">
                                        <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                                        Cuentas
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>';
                            echo '<div class="collapse" id="collapseMantenimientoCuentas" aria-labelledby="headingMantenimientoCuentas" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosTransaccion) && $permisosTransaccion[0]['PERMISOS_CONSULTAR'] == 1) { 
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                            }
                            if (!empty($permisosTipoCuenta) && $permisosTipoCuenta[0]['PERMISOS_CONSULTAR'] == 1) {  
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Cuenta</a>';
                            }
                            if (!empty($permisosMantCuenta) && $permisosMantCuenta[0]['PERMISOS_CONSULTAR'] == 1) { 
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista Cuentas</a>';
                            }
                        }
                            echo '</nav>';
                            echo '</div>';
                        }
                        //-------------------------------MODULO DE PRESTAMOS--------------------------------------
                        if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoPrestamos" aria-expanded="false" aria-controls="collapseMantenimientoPrestamos">
                                        <div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>
                                        Prestamos
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>';
                            echo '<div class="collapse" id="collapseMantenimientoPrestamos" aria-labelledby="headingMantenimientoPrestamos" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                                if (!empty($permisosFormaPago) && $permisosFormaPago[0]['PERMISOS_CONSULTAR'] == 1) { 
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                            }
                            if (!empty($permisosTipoPrestamo) && $permisosTipoPrestamo[0]['PERMISOS_CONSULTAR'] == 1) { 
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                            }
                            if (!empty($permisosPresMantenimiento) && $permisosPresMantenimiento[0]['PERMISOS_CONSULTAR'] == 1) { 
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista Prestamos</a>';
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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Inicio</h1>
                    <div class="container-fluid">
                        <!-- Mensaje de Bienvenida -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1 style="font-size: 24px; font-weight: bold;">¡Bienvenido al Sistema Informático para la Administración de Ahorro y Crédito de los Empleados SIAACE para IDH Microfinanciera!</h1>
                                <h2 style="font-size: 16px; font-weight: bold;">Este dashboard es tu ventana al mundo de la información crítica que necesitas para tomar decisiones informadas y estratégicas.</h2>
                                <img src="../src/Dashboard.jpg" alt="Imagen de Bienvenida">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p style="font-style: italic; font-size: 14px;">No dudes en ponerte en contacto con nuestro equipo de soporte si tienes alguna pregunta o necesitas ayuda en cualquier momento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-start justify-content-center small">
                        <div class="text-muted">Copyright &copy; IA-UNAH 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
</body>

</html>