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
Catedratico evaluacion de sistemas:  Lic. Karla Melisa Garcia Pineda


---------------------------------------------------------------------

Programa:         Pantalla de Perfil
Fecha:           
Programador:      
descripcion:      Pantalla que muestra y actualiza la informacion de usuario
-----------------------------------------------------------------------

                Historial de Cambio

-----------------------------------------------------------------------

Programador               Fecha                      Descripcion


Kevin Zuniga              22-abril-2024             Se agrego alertas y validaciones, ademas de algunos detalles esteticos
------------------------------------------------------------------------->

<?php
session_start();

require "../../Config/conexion.php";
require_once '../../Modelos/permisoUsuario.php';
require_once '../../Modelos/Usuarios.php';
require_once "../../Controladores/perfil.php";
require_once "../../Modelos/bitacora.php";

$permisosUsuarios = new PermisosUsuarios();
$usuario_obj = new Usuario();
$bit = new bitacora();

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];

$id_usuario = $_SESSION['id_usuario'];

$perfil = obtenerPerfil($id_usuario);

$usuario = $perfil['USUARIO'];
$nombre_usuario = $perfil['NOMBRE_USUARIO'];
$correo = $perfil['CORREO_ELECTRONICO'];
$contrasena = $perfil['CONTRASENA'];

$preg1 = obtenerPrimeraPregunta($id_usuario);
$id1 = $preg1['ID_PREGUNTA'];
$pregunta1 = $preg1['PREGUNTA'];
$respuesta1 = $preg1['RESPUESTAS'];

$preg2 = obtenerSegundaPregunta($id_usuario);
$id2 = $preg2['ID_PREGUNTA'];
$pregunta2 = $preg2['PREGUNTA'];
$respuesta2 = $preg2['RESPUESTAS'];

$preg3 = obtenerTerceraPregunta($id_usuario);
$id3 = $preg3['ID_PREGUNTA'];
$pregunta3 = $preg3['PREGUNTA'];
$respuesta3 = $preg3['RESPUESTAS'];

if (isset($_POST['respuesta1'])) {
  require_once "../../Controladores/perfil.php";

  $id_usuario = $_SESSION['id_usuario'];
  $idPregunta1 = $_POST['pregunta_secreta1'];
  $respuesta1 = $_POST['respuesta1'];
  $idPregunta2 = $_POST['pregunta_secreta2'];
  $respuesta2 = $_POST['respuesta2'];
  $idPregunta3 = $_POST['pregunta_secreta3'];
  $respuesta3 = $_POST['respuesta3'];
  $correoP = $_POST['correo'];

  actualizarRespuestas($id_usuario, $id1, $respuesta1, $id2, $respuesta2, $id3, $respuesta3);
  actualizarDatos($id_usuario, $correoP);

  header("Location: perfil.php");
}

if(isset($_POST['bitacora']))
{
  require_once "../../Controladores/perfil.php";
  $valor = $_POST['bitacora'];
  activarBitacora($valor);
}

if (isset($_POST['contrasena'])) {
  require_once "../../Controladores/perfil.php";

  $id_usuario = $_SESSION['id_usuario'];
  $contrasena = $_POST['contrasena'];
  $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

  cambiarContrasena($id_usuario, $hashed_password);
}

//---------------------PERMISOS DE LOS MANTENIMIENTOS----------------------
$id_usuario_Usuario = "2";
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
$id_objeto_PestaniaEmpleado = "27";
$id_objeto_Cuentas = "36";
$id_objeto_Prestamos = "35";

//-------------------------------------------------------------------------------
$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_usuario_Usuario);
$permisosBitacora = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Bitacora);
$permisosEstados = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Estados);
$permisosObjetos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);
$permisosParametro = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
$permisosRoles = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);
$permisosPermiso = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);
//---------------------------Mant.Empleado----------
$permisosSucursal = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Sucursal);
$permisosRegion = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Region);
$permisosEmpleado = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisosCargo = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cargos);
//---------------------Mant.Cuentas----------------------
$permisosTransaccion = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisosTipoCuenta = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Tipo_cuenta);
$permisosMantCuenta = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);

//---------------------Mant.Prestamo----------------------
$permisosFormaPago = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Forma_Pago);
$permisosPresMantenimiento = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisosTipoPrestamo = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Tipoprestamo);
//------------------------------------------------------------------------------

$permisos1 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_PestaniaEmpleado);
$permisos3 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);
$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];

//---------CONEXION A LA TABLA ROLES --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();
// Consultar la contraseña actual del usuario desde la base de datos
$sql = "SELECT id_rol ,rol FROM tbl_ms_roles WHERE ID_ESTADO_USUARIO = 1";
$sql1 = "SELECT ID_ESTADO_USUARIO, NOMBRE FROM tbl_ms_estadousuario";
$stmt = $conn->prepare($sql);
$stmt1 = $conn->prepare($sql1);

$stmt->execute();
$stmt1->execute();

// Obtener los resultados en un array asociativo
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$Estados = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario</title>
  <link rel="shortcut icon" href="../../src/IconoIDH.ico">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="../../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />
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

    #Lista-Usuarios_wrapper .buttons-html5:first-child {
      margin-left: 20px;
      /* Adjust the margin value as needed */
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
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2" />
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
          <a class="dropdown-item" href="./perfil.php">Perfil</a>
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
            //--------MODULO DE SEGURIDAD---------------------------------------------------
            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
              echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
              echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
              echo '<nav class="sb-sidenav-menu-nested nav">';

              if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
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
                if (!empty($permisosObjetos) && $permisosObjetos[0]['PERMISOS_CONSULTAR'] == 1) {
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
                                    Empleado
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
                            Cuenta
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
                            Prestamo
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
          <div class="small">Usuario: <?php echo $nombre_usuario; ?></div>
          Sesión activa: Conectado(a).
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">

      <!-- INICIO -->

      <div class="container-fluid">
        <h1 class="mt-4">Perfil de Usuario</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Perfil de Usuario</li>
        </ol>
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                  <img src="../../src/usuario.png" class="card-img-top" alt="Foto de perfil">
                  <div class="card-body">
                    <h5 class="card-title">
                      <center>Foto de perfil</center>
                    </h5>
                  </div>
                </div>
              <br>
                <form id="activar-bitacora" action="./perfil.php" method="POST">
                <div class="form-group">
                    <label for="bitacora">Registrar Bitácora: </label>
                    <select class="form-control" id="bitacora" name="bitacora" style="width: 130px;">
                      <option selected disabled><?php echo ($bit->obtenervalorBitacora() == 1 ? 'Si' : 'No') ?></option>
                      <option value="1">Si</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                  <button onclick="cambiarestadoBitacora()" class="btn btn-primary">Cambiar estado Bitácora</submit>
                </form>
              </div> 
              <div class="vl" style="border-left: 2px solid #C0C0C0; height: 815px; margin-left: -75px; margin-right: 10px;"></div>
              <div class="col-md-4">
                <form id="form-perfil" action="./perfil.php" method="POST">
                  <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $nombre_usuario; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" maxlength="30" class="form-control" id="correo" name="correo" required pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" title="Ingrese una dirección de correo electrónico válida" value="<?php echo $correo; ?>" disabled>
                  </div>
                  <div id="mensaje1"></div>
                  <div class="form-group">
                    <label for="pregunta_secreta1">Pregunta Secreta 1</label>
                    <select class="form-control" id="pregunta_secreta1" name="pregunta_secreta1" disabled>
                      <option value="<?php echo $id1; ?>"><?php echo $pregunta1; ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="respuesta1">Respuesta 1</label>
                    <table width="108%">
                      <tr>
                        <td>
                          <input type="password" maxlength="30" class="form-control" id="respuesta1" name="respuesta1" value="<?php echo $respuesta1; ?>">
                        </td>
                        <td>
                          <button onclick="ver_respuesta1()" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true" style="height: 24px;"></i></button>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <div class="form-group">
                    <label for="pregunta_secreta2">Pregunta Secreta 2</label>
                    <select class="form-control" id="pregunta_secreta2" name="pregunta_secreta2" disabled selected>
                      <option value="<?php echo $id2; ?>"><?php echo $pregunta2; ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="respuesta2">Respuesta 2</label>
                    <table width="108%">
                      <tr>
                        <td>
                          <input type="password" maxlength="30" class="form-control" id="respuesta2" name="respuesta2" value="<?php echo $respuesta2; ?>">
                        </td>
                        <td>
                          <button onclick="ver_respuesta2()" class="btn btn-primary"> <i class="fa fa-eye" aria-hidden="true" style="height: 24px;"></i></button>
                        </td>
                      </tr>
                    </table>
                  </div>

                  <div class="form-group">
                    <label for="pregunta_secreta3">Pregunta Secreta 3</label>
                    <select class="form-control" id="pregunta_secreta3" name="pregunta_secreta3" disabled selected>
                      <option value="<?php echo $id3; ?>"><?php echo $pregunta3; ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="respuesta3">Respuesta 3</label>
                    <table width="108%">
                      <tr>
                        <td>
                          <input type="password" maxlength="30" class="form-control" id="respuesta3" name="respuesta3" value="<?php echo $respuesta3; ?>">
                        </td>
                        <td>
                          <button onclick="ver_respuesta3()" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true" style="height: 24px;"></i> </button>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <button onclick="actualizarRespuestas()" class="btn btn-primary">Actualizar</submit>
                    <!--<button class="btn btn-danger" style="margin-left: 5px;"><a href="../../../InicioSesion/index.php">Cancelar</a></button>-->
                </form>
              </div>
              <div class="vl" style="border-left: 2px solid #C0C0C0; height: 815px; margin-left: 20px; margin-right: 10px;"></div>
              <div class="col-md-4">
                <!-- CAMBIO DE CONTRASEÑA -->
                <form id="form-cambio-contrasena" action="./perfil.php" method="POST">
                  <div class="form-group">
                    <label for="contrasena_actual">Contraseña Actual</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="contrasena_actual" name="contrasena_actual">
                      <div class="input-group-append">
                        <button onclick="ver_contrasena()" class="btn btn-primary ml-1" type="button">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="contrasena">Nueva Contraseña</label>
                    <div class="input-group">
                      <input type="password" maxlength="15" class="form-control" id="contrasena" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" name="contrasena">
                      <div class="input-group-append">
                        <button onclick="ver_contrasena_nueva()" class="btn btn-primary ml-1" type="button">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div id="mensaje2"></div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="confirmar_contrasena">Confirmar Contraseña</label>
                    <div class="input-group">
                      <input type="password" maxlength="15" class="form-control" id="confirmar_contrasena" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" name="confirmar_contrasena">
                      <div class="input-group-append">
                        <button onclick="ver_contrasena_confirmar()" class="btn btn-primary ml-1" type="button">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                      </div>
                      <div id="mensaje3"></div>
                    </div>
                    <br>
                    <button onclick="cambiarContrasena()" class="btn btn-primary">Cambiar Contraseña</button>
                    </br>
                  </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FIN -->

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
      // FUNCION PARA VER LA RESPUESTA 1
      function ver_respuesta1() {
        var form = document.getElementById("form-perfil");
        var tipo = document.getElementById("respuesta1");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      // FUNCION PARA VER LA RESPUESTA 2
      function ver_respuesta2() {
        var form = document.getElementById("form-perfil");
        var tipo = document.getElementById("respuesta2");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      // FUNCION PARA VER LA RESPUESTA 3
      function ver_respuesta3() {
        var form = document.getElementById("form-perfil");
        var tipo = document.getElementById("respuesta3");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      function actualizarRespuestas() {
        form = document.getElementById("form-perfil");
        form.addEventListener("submit", function(event) {
          event.preventDefault();
        });

        Swal.fire({
          title: '¿Está seguro de actualizar sus respuestas?',
          text: "¡No podrás revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Sí, actualizar!',
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById("form-perfil").submit();
          }
        })
      }

      function cambiarestadoBitacora()
      {
        form = document.getElementById("activar-bitacora");
        form.addEventListener("submit", function(event) {
          event.preventDefault();
        });
 
        Swal.fire({
          title: '¿Está seguro de Activar/Desactivar la Bitácora?',
          text: "¡No podrás revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Sí, actualizar!',
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              icon: 'success',
              title: 'Actualización exitosa',
              text: 'Los datos se han actualizado correctamente.'
            }).then(function() {
              document.getElementById("activar-bitacora").submit();
            });
          }
        })
      }

      function actualizarDatos() {
        form = document.getElementById("form-perfil");
        form.addEventListener("submit", function(event) {
          event.preventDefault();
        });

        Swal.fire({
          title: '¿Está seguro de actualizar sus respuestas?',
          text: "¡No podrás revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Sí, actualizar!',
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById("form-perfil").submit();
          }
        })
      }

      function cambiarContrasena() {
        form = document.getElementById("form-cambio-contrasena");
        form.addEventListener("submit", function(event) {
          event.preventDefault();
        });

        var contraActual = document.getElementById('contrasena_actual').value;
        var contra = document.getElementById('contrasena').value;
        var confirmar = document.getElementById('confirmar_contrasena').value;

        // Verificar que las contraseñas coincidan y no estén vacías
        if (contra.trim() !== confirmar.trim()) {
          // Mostrar mensaje de error si las contraseñas no coinciden
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden.'
          });
          return;
        }
        Swal.fire({
          title: '¿Está seguro de cambiar su contraseña?',
          text: "¡No podrás revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Sí, cambiar!',
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById("form-cambio-contrasena").submit();
          } else {
            //Limpiar los input de contrasena
            contraActual = document.getElementById('contrasena_actual');
            contra = document.getElementById('contrasena');
            confirmar = document.getElementById('confirmar_contrasena');
            contraActual.value = "";
            contra.value = "";
            confirmar.value = "";
          }
        })
      }

      function ver_contrasena() {
        var form = document.getElementById("form-cambio-contrasena");
        var tipo = document.getElementById("contrasena_actual");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      function ver_contrasena_nueva() {
        var form = document.getElementById("form-cambio-contrasena");
        var tipo = document.getElementById("contrasena");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      function ver_contrasena_confirmar() {
        var form = document.getElementById("form-cambio-contrasena");
        var tipo = document.getElementById("confirmar_contrasena");
        if (tipo.type == "password") {
          form.addEventListener("submit", function(event) {
            event.preventDefault();
          });
          tipo.type = "text";
        } else {
          tipo.type = "password";
        }
      }

      function validarNombre() {
        correo = document.getElementById("correo");
        contrasena = document.getElementById("contrasena");
        confirmarContrasena = document.getElementById("confirmar_contrasena");

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

        var expresionValidadora1 = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
        var mensaje1 = document.getElementById("mensaje1");
        handleInputAndBlurEvents(correo, expresionValidadora1, mensaje1, "Ingrese una dirección de correo electrónico válida");

        var expresionValidadora2 = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;
        var mensaje2 = document.getElementById("mensaje2");
        handleInputAndBlurEvents(contrasena, expresionValidadora2, mensaje2, "La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial");

        var mensaje3 = document.getElementById("mensaje3");
        handleInputAndBlurEvents(confirmarContrasena, expresionValidadora2, mensaje3, "La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial");
      }

      $('#respuesta1, #respuesta2, #respuesta3, #correo, #contrasena_actual, #contrasena, #confirmar_contrasena').on('input', function() {
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
      $(document).ready(function() {
        validarNombre();
      });

      function regresar() {
        window.location.replace('../../InicioSesion/index.php');
      }
    </script>

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
    <script src="../../Config/constantes.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>

</html>