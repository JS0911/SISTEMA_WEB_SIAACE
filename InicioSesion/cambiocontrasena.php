<?php

session_start();

require "../Config/conexion.php";
require_once '../Modelos/permisoUsuario.php';
require_once '../Modelos/Usuarios.php';

$permisosUsuarios = new PermisosUsuarios();
$usuario_obj = new Usuario();

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol =$_SESSION['id_rol'];
$id_objeto_Usuario = "2";
$id_objeto_Seguridad = "25";
$id_objeto_Cuentas = "28";


$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisos1 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$datos_usuario = $usuario_obj->get_usuario($_SESSION['id_usuario']);
$nombre_usuario = $datos_usuario['NOMBRE_USUARIO'];
// $contrasenaActualError = "";
// $nuevaContrasenaError = "";
// $confirmarContrasenaError = "";
$contrasenaCambiadaExito = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Entró en el bloque POST"; 
    $contrasenaActual = $_POST["contrasenaActual"];
    $nuevaContraseña = $_POST["contraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];

    // Crear una instancia de la clase Conectar
    $conexion = new Conectar();
    $conn = $conexion->Conexion();

    // Consultar la contraseña actual del usuario desde la base de datos
    $sql = "SELECT contrasena FROM tbl_ms_usuario WHERE id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $contrasenaBD = $row['contrasena'];

        if (password_verify($contrasenaActual, $contrasenaBD)) {
            // Contraseña actual es correcta

            if ($nuevaContraseña === $confirmarContraseña) {
                // Nuevas contraseñas coinciden

                $conexion = new Conectar();
                $conn = $conexion->Conexion();
                $conexion->set_names();
                $idUsuario = $usuario;

                $hashedPassword = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
                $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = ? WHERE USUARIO= ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bindParam(1, $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(2, $idUsuario, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        //$contrasenaCambiadaExito = "Contraseña Cambiada con exito";
                        //echo $contrasenaCambiada;
                        echo "Contraseña cambiada con éxito.";
                        // $conn = null;
                        header("refresh: 2; url=login.php");
                        exit;
                    } else {

                        echo "Error al cambiar la contraseña: " . $stmt->errorInfo()[2];
                    }
                } else {
                    echo "Error en la preparación de la consulta: " . $conn->errorInfo()[2];
                }
            } else {
                $confirmarContrasenaError = "Las contraseñas nuevas no coinciden. Por favor, inténtalo de nuevo.";
            }
        } else {

            $contrasenaActualError = "La contraseña actual no es válida. Por favor, inténtalo de nuevo.";
            // echo $contrasenaActualError;
        }
    } else {
        echo "Error al obtener la contraseña actual desde la base de datos.";
    }
    // Cierra la conexión
    $conn = null;
    header("refresh:1");
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
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
</style>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cambio de Contraseña</title>
    <link rel="shortcut icon" href="../src/IconoIDH.ico">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
         <!-- Navbar Search-->
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
                    <a class="dropdown-item" href="cambiocontrasena.php">Cambiar Contraseña</a>
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
                           if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Modulo Seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/bitacora.php"><i class="fa fa-book" aria-hidden="true"></i></i><span style="margin-left: 5px;"> Bitacora </a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/error.php"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i><span style="margin-left: 5px;"> Error </a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/historial_contrasena.php"><i class="fas fa-history" aria-hidden="true"></i><span style="margin-left: 5px;"> H. Contraseña </a>';
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
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
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
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Cuenta</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoCuentas/MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Cuentas</a>';
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
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                echo '<a class="nav-link" href="../Vistas/MantenimientoPrestamos/prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Prestamos</a>';
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usuario: <?php echo $nombre_usuario;?></div>
                    Sesión activa: Conectado(a).
                </div>
            </nav>
        </div>
    </div>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Cambio de Contraseña</h3>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                        <!-- input para Contraseña Actual -->
                                        <div class="wrap-input mb-3" id="grupo__password">
                                            <label><b>Contraseña Actual</b></label>
                                            <span class="lock conteiner-icon">
                                                <i class="icon type-lock fa fa-eye-solid  fa fa-eye-slash"></i>
                                            </span>
                                            <input type="password" class="form-control input" name="contrasenaActual" id="passwordActual" maxlength="15" placeholder="Contraseña Actual">
                                            <p class="mensaje"></p>
                                            <br>
                                        </div>
                                        <!-- input para Contraseña -->
                                        <div class="wrap-input mb-3" id="grupo__password">
                                            <label><b>Contraseña</b></label>
                                            <span class="lock conteiner-icon">
                                                <i class="icon type-lock fa fa-eye-solid  fa fa-eye-slash"></i>
                                            </span>
                                            <input type="password" class="form-control input" name="contraseña" id="password" maxlength="15" placeholder="Contraseña">
                                            <!--  <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                            <p class="mensaje"></p>
                                            <br>
                                        </div>
                                        <!-- input para confirmación Contraseña -->
                                        <div class="wrap-input mb-3" id="grupo__password2">
                                            <label><b>Confirmar contraseña</b></label>
                                            <span class="lock conteiner-icon">
                                                <i class="icon type-lock fa-eye-solid  fa fa-eye-slash"></i>
                                            </span>
                                            <input type="password" class="form-control input" name="confirmarContraseña" id="password2" maxlength="15" placeholder="Confirmar Contraseña">
                                            <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                            <p class="mensaje"></p>
                                            <button type="button" class="btn btn-danger" name="cancelar" id="clickCancelar">Cancelar</button>
                                            <button type="submit" class="btn btn-primary" name="submit" id="click">Guardar</button>
                                            
                                            <script>
                                                document.getElementById("clickCancelar").addEventListener("click", function() {
                                                    window.location.href = "index.php";
                                                });
                                            </script>
                                        </div>
                                </div>
                                <!-- Este div se utilizará para mostrar mensajes -->
                                <div id="mensajeDiv">
                                <?php if (!empty($contrasenaActualError)) : ?>
                                        <div class="alert alert-danger"><?php echo $contrasenaActualError; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($contrasenaCambiadaExito)) : ?>
                                        <div class="alert alert-danger"><?php echo $contrasenaCambiadaExito; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($nuevaContrasenaError)) : ?>
                                        <div class="alert alert-danger"><?php echo $nuevaContrasenaError; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($confirmarContrasenaError)) : ?>
                                        <div class="alert alert-danger"><?php echo $confirmarContrasenaError; ?></div>
                                    <?php endif; ?>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <!-- <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <!-- <script src="../assets/demo/datatables-demo.js"></script>                     -->
</body>
<html>