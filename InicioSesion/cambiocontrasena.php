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
$id_objeto_Empleado = "27";
$id_objeto_Cuentas = "36";
$id_objeto_Prestamos = "35";


$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario);
$permisos1 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos3 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);

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
                        //echo "Contraseña cambiada con éxito.";
                        // $conn = null;
                        $date = new DateTime(date("Y-m-d H:i:s"));
                        $dateMod = $date->modify("-7 hours");
                        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

                        $sql2 = "INSERT INTO tbl_ms_historial_contrasena(CONTRASENA, ID_USUARIO, FECHA_MODIFICACION) VALUES ('$hashedPassword', '$id_usuario', '$dateNew');";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute();

                        $sql3 = "UPDATE tbl_ms_usuario SET ID_ESTADO_USUARIO = '1' WHERE ID_USUARIO = $id_usuario;";
                        $stmt3 = $conn->prepare($sql3);
                        $stmt3->execute();

                        $sql4 = "UPDATE tbl_ms_usuario SET AUTO_REGISTRO = '2' WHERE ID_USUARIO = $id_usuario;";
                        $stmt4 = $conn->prepare($sql4);

                        $_SESSION['cambio_contrasena'] = true;
                        //header("refresh: 2; url=login.php");
                        //exit;
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
            //echo $contrasenaActualError;
        }
    } else {
        echo "Error al obtener la contraseña actual desde la base de datos.";
    }
    // Cierra la conexión
    $conn = null;
    //header("refresh:1");
}

if (!isset($_SESSION['usuario'])) {
    $stmt4->execute();
    header("Location: login.php");
    session_destroy();
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
        <a class="navbar-brand">
            <img src="../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
         <!-- Navbar Search-->
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
                        <a class="nav-link">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> 
                        </a>
                       
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
                                            <button type="submit" class="btn btn-primary" name="submit" id="click" disabled>Guardar</button>
                                            
                                            <script>
                                                document.getElementById("clickCancelar").addEventListener("click", function() {
                                                    window.location.href = "login.php";
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

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const contrasenaActual = document.getElementById('passwordActual');
        const contrasena = document.getElementById('password');
        const contrasena2 = document.getElementById('password2');
        const guardarButton = document.getElementById('click');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = contrasenaActual.value.trim() !== '' && contrasena.value.trim() !== '' && contrasena2.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }
        // Agrega un evento input a cada campo de entrada
        contrasenaActual.addEventListener('input', checkForm);
        contrasena.addEventListener('input', checkForm);
        contrasena2.addEventListener('input', checkForm);
        guardarButton.addEventListener('input', checkForm);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php
                if (isset($_SESSION['cambio_contrasena'])) {
                    echo "
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Cambio de contraseña realizado exitosamente. Tiene 10 seg. Para confirmar, pronto se cerrará la sesión...',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        timer: 10000
                    }).then(() => {
                        window.location.href = '../Vistas/MantenimientoUsuario/Contestar_preguntas.php';
                    });";
                    unset($_SESSION['cambio_contrasena']);
                }
            ?>
        });
    </script>
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#passwordActual, #password, #password2').on('input', function() {
                var input = $(this);
                var trimmedValue = input.val().trim();

                if (trimmedValue === '') {
                    Swal.fire({
                        title: 'Advertencia',
                        text: 'El campo no puede estar vacío',
                        icon: 'warning',
                    });
                }
            });
        });
    </script>
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