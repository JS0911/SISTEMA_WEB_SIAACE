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

Programa:         Pantalla de Historial de Cuenta
Fecha:            
Programador:      
descripcion:      Pantalla que muestra las cuentas que existen

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
require_once "../../Modelos/cuenta.php";
require_once '../../Modelos/Usuarios.php';

$permisosHistorial = new PermisosUsuarios();
$usuario_obj = new Usuario();

$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_empleado = $_SESSION['id_empleado'];
$id_objeto_H_Cuenta = "31";
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
$permisosUsuario = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisosBitacora = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosEstados = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosObjetos = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);

//-------------------------Mant.Empleado----------
$permisosSucursal = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);

$permisos = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_H_Cuenta);
$permisos1 = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos3 = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosHistorial->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);

$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

if (isset($_GET['ID_CUENTA'])) {
    $ID_CUENTA = $_GET['ID_CUENTA'];
} else {
    echo "No se proporcionó la cuenta en la URL.";
}

//---------CONEXION A LA TABLA EMPLEADOS --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT PRIMER_NOMBRE, PRIMER_APELLIDO FROM tbl_me_empleados WHERE ID_EMPLEADO= $id_empleado ";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$nombre_empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unir el primer nombre y apellido
$nombre_empleado_unido = implode(" ", $nombre_empleado[0]);

// Obtener los resultados en un array asociativo
$TipoPrestamoPlazo = $stmt->fetchAll(PDO::FETCH_ASSOC);
//-----------------------------------------------------------------------------
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

    .btn.btn-link.collapsed,
    .btn.btn-link.collapsed:visited {
        font-family: 'Open Sans', sans-serif !important;
        font-weight: 800 !important;
        font-size: 20px !important;
        color: green !important;
        text-decoration: none !important;
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
    <title>Historial de Cuenta</title>
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
                    <div class="small">Usuario: <?php echo $nombre_usuario; ?><div>
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
                                            <div class="display-flex flex-direction-column" style="font-family: sans-serif;">
                                                <h2>Cuenta Bancaria</h2>
                                                <h6 class="bel-typography bel-typography-h2">
                                                    <?php echo $nombre_empleado_unido; ?>
                                                    <small class="text-muted"><?php echo $ID_CUENTA; ?></small>
                                                </h6>
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
                                            Estado de Cuenta
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <h2 class="bel-typography bel-typography-h2">Movimientos</h2>
                                        <p class="bel-typography bel-typography-h2">Consulta todos los movimientos realizados por la cuenta seleccionada</p>
                                        <div style="max-height: 400px; overflow-y: auto;">
                                            <table class="table table-bordered mx-auto" id="Lista-Transacciones" style="margin-top: 20px; margin-bottom: 20px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Usuario</th>
                                                        <th scope="col">Monto</th>
                                                        <th scope="col">Descripcion</th>
                                                        <th scope="col">Acciones</th>
                                                    </tr>
                                                </thead>

             <!-- Modal De Descripcion De Anulaciones-->
                <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalLabel">Motivo De Anulacion</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">
                                        <label for="estado">Describe el motivo de la anulacion</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-descripcion" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-agregar" disabled>Guardar</button>
                                <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                                             










                                                <tbody>
                                                    <?php
                                                    $consulta = new cuenta();
                                                    $result = $consulta->historial_cuenta($ID_CUENTA);

                                                    if ($result !== false) {
                                                        // Ordenar los resultados por fecha de más reciente a más antigua
                                                        usort($result, function ($a, $b) {
                                                            return strtotime($b['FECHA']) - strtotime($a['FECHA']);
                                                        });

                                                        if (is_array($result) && count($result) > 0) {
                                                            foreach ($result as $row) {
                                                                echo "<tr>";
                                                                echo "<td>" . $row["FECHA"] . "</td>";
                                                                echo "<td>" . $row["CREADO_POR"] . "</td>";
                                                                echo "<td class='texto-derecha'>" . "L.".formatoNumero($row["MONTO"]) . "</td>";
                                                                echo "<td>" . $row["DESCRIPCION"] . "</td>";
                                                                echo "<td><button type='button' id='btn-anular' class='btn btn-outline-danger'>Anular</button></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='4'>No hay datos</td></tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4'>Error en la consulta</td></tr>";
                                                    }

                                                    function formatoNumero($numero)
                                                    {
                                                        return number_format($numero, 2, '.', ',');
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
            </main>
        </div>
    </div>
    <script>
        var permisos = <?php echo json_encode($permisos); ?>;
        //DEBE DE ESTAR VALIDADO LA ANULACION Y LA VISUALIZACION 
        function Anular(id_cuenta, id_transaccion) {
            var datos = {
                "ID_CUENTA": id_cuenta,
                "ID_TRANSACCION": id_transaccion,
            };

            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=Anulacion_Dep_Ret', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos) // Convierte el objeto en formato JSON
                })
                .then(response => response.json()) // Parsea la respuesta como JSON
                .then(data => {
                    console.log('Anulación realizada con éxito:', data);

                    // Mostrar el SweetAlert después de una anulación exitosa
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Anulación Realizada Con Éxito',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error al anular la transacción:', error);
                    // Aquí puedes manejar errores si la anulación falla
                });
        }

        /* Imprime los datos en la tabla
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td>" . $row["monto"] . "</td>";
                        echo "<td>" . $row["descripcion"] . "</td>";
                        echo "<td>Acciones</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay datos</td></tr>";
                }*/
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>
<html>