<?php

session_start();

//CREAR CONEXION
require "../Config/conexion.php";

//Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    //$id_usuario = $_POST['id_usuario'];
    //$id_estado_usuario = $_POST['id_estado_usuario'];
    //$id_rol = $_POST['id_rol'];

    //$ID_ROL = $_SESSION ['ID_ROL'];
    
    // V A L I D A C I O N E S 
    
    define('MAX_LONGITUD_USUARIO', 15); 
    define('MAX_LONGITUD_CONTRASENA', 100); 
    $usuario = strtoupper($usuario);
    if (empty($usuario) || empty($contrasena)) {
        $mensajeCampos = "Ambos campos deben estar llenos.";
    } elseif (strlen($usuario) > MAX_LONGITUD_USUARIO || strlen($contrasena) > MAX_LONGITUD_CONTRASENA) {
        $mensajeLimite = "Se ha excedido la longitud máxima permitida para uno o ambos campos.";
    } elseif (empty($usuario) || empty($contrasena) || strpos($usuario, ' ') !== false || strpos($contrasena, ' ') !== false) {
        $mensajeEspacio = "Ambos campos no pueden contener espacios en blanco."; 
    } else {
        $mensajeError = "Lo siento, ha ocurrido un error inesperado."; 
    }

    if ($conn) { // Verificar si la conexión se estableció correctamente
        $sql = "SELECT id_usuario, usuario, contrasena, id_estado_usuario ,id_rol, preguntas_contestadas,id_rol FROM tbl_ms_usuario WHERE usuario='$usuario'";
        $sql1 = "SELECT * FROM tbl_ms_parametros WHERE PARAMETRO = 'BLOQUEO'";
        //echo $sql;
        $stmt = $conn->query($sql);
        $filaintentos = $conn->query($sql1);

        //BLOQUEO SI SUPERA LOS INTENTOS FALLIDOS: OBTENCION DE VALOR DE INTENTOS
        $row1 = $filaintentos->fetch(PDO::FETCH_ASSOC);
        $cantMaximaIntentos = $row1['VALOR'];
        
        if ($stmt) {
            $num = $stmt->rowCount();

            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $password_bd = $row['contrasena'];
                //PARA ENCRIPTAR LA CONTRASEÑA
                $pass_c = password_hash($contrasena, PASSWORD_DEFAULT);
                //echo $pass_c;
                // PARA VERIFICAR QUE LA CONTRASEÑA ENCRIPTADA COINCIDA CON LA QUE ESTÁ EN LA BASE DE DATOS
                if (password_verify($contrasena, $password_bd)) {
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['usuario'] = $row['usuario'];
                    $_SESSION['id_estado_usuario'] = $row['id_estado_usuario'];
                    $_SESSION['id_rol'] = $row['id_rol'];

                    //ESTADO DEL USUARIO
                    if($row['id_estado_usuario'] == 2)
                    {
                        $mensajeEstado = 'Su usuario se encuentra inactivo';
                    }
                    else if($row['id_estado_usuario'] == 3)
                    {
                        //Cambiar la ruta a login por primera vez
                        header("Location: ../Vistas/MantenimientoUsuario/Contestar_preguntas.php");
                    }
                    else if($row['id_estado_usuario'] == 4)
                    {
                        $mensajeEstado = 'Su usuario se encuentra bloqueado.';
                    }
                    else
                    {
                        header("Location: index.php");
                        echo $id_rol;
                    }

                } else {
                    
                    $contrasenaNoCoincice = "La contraseña no coincide";
                    // echo "La contraseña no coincide";

                    if(!isset($_COOKIE['intentosFallidos']))
                    {
                        setcookie('intentosFallidos', 1, time() + (86400));
                        setcookie('usuarioIntento', $usuario, time() + (86400));
                    }
                    else
                    {
                        $cont = $_COOKIE['intentosFallidos'];
                        $usuarioAnterior = $_COOKIE['usuarioIntento'];

                        if($usuarioAnterior != $usuario)
                        {
                            setcookie('intentosFallidos', 1, time() + (86400));
                            setcookie('usuarioIntento', $usuario, time() + (86400));
                        }
                        else
                        {
                            $cont++;
                            setcookie('intentosFallidos', $cont, time() + (86400));
                    
                            if($cantMaximaIntentos <= $_COOKIE['intentosFallidos'])
                            {
                                $contrasenaNoCoincice = "Su usuario ha sido bloqueado debido a que excedio la cantidad de intentos.";
                                $sql2 = "UPDATE tbl_ms_usuario SET ID_ESTADO_USUARIO = 4 WHERE USUARIO = '$usuario'";
                                $conn->query($sql2);
                                setcookie('intentosFallidos', "", time() - 3600);
                                setcookie('usuarioIntento', "", time() - 3600);
                            }
                        }
                        
                    }
                }
            } else {
                $NoExisteUsuario = "No existe usuario"; 
                
                //echo"No existe usuario";
            }
        } else {
            echo "Error en la consulta: " . $conn->errorInfo()[2]; // Mostrar el mensaje de error de PDO
        }
       
    } else {
        echo "Error al conectar a la base de datos.";
    }
    header("refresh: 2; url=login.php");
}
?>

<style>
    .logo {
        width: 100px;
        /* Ancho deseado del logo */
        margin: 0 auto;
        /* Auto-centrar horizontalmente */
        display: block;
        /* Asegurarse de que sea un bloque para que el auto-centrado funcione */
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
    <title>SIAACE - Login</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">SIAACE LOGIN</h3><img src="../src/Logo.png" alt="Logo SIAACE" class="logo">
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label><input class="form-control py-4" id="inputEmailAddress" name="usuario" type="text" maxlength="15" placeholder="Ingresa tu usuario:" required pattern="^\S.*$" title="No se permiten espacios en blanco al principio." oninput="this.value = this.value.toUpperCase()" /></div>
                                        <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" maxlength="100" placeholder="Ingresa tu contraseña:" required pattern="^\S.*$" title="No se permiten espacios en blanco al principio."/></div>
                                        <div style="text-align: center;">
                                            <button type="submit" class="btn btn-primary">Ingresar</button>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php">¿Olvido su contraseña? Recuperar aquí</a>

                                    </form>

                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.php">Registrarse</a></div>
                                        
                                    </div>

                                </div>
                                <!-- Este div se utilizará para mostrar mensajes -->
                                <div id="mensajeDiv">
                                    <?php if (!empty($contrasenaNoCoincice)) : ?>
                                        <div class="alert alert-danger"><?php echo $contrasenaNoCoincice; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($NoExisteUsuario)) : ?>
                                        <div class="alert alert-danger"><?php echo $NoExisteUsuario; ?></div>
                                    <?php endif; ?>
                                    <?php if(!empty($mensajeEstado)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeEstado; ?></div>
                                    <?php endif ?>
                                    <?php if (!empty($mensajeCampos)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeCampos; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($mensajeLimite)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeLimite; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($mensajeEspacio)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeEspacio; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($mensajeError)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeError; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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
</body>
</html>