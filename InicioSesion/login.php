<?php 
session_start();

require "../Config/conexion.php";

$conexion = new Conectar();
$conn = $conexion->Conexion();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    //$id_usuario = $_POST['id_usuario'];
    //$id_estado_usuario = $_POST['id_estado_usuario'];
    //$id_rol = $_POST['id_rol'];
    //$ID_ROL = $_SESSION ['ID_ROL'];

    if ($conn) {
        $sql = "SELECT id_usuario, usuario, contrasena, id_estado_usuario, id_rol, preguntas_contestadas FROM tbl_ms_usuario WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $password_bd = $row['contrasena'];

            if (password_verify($contrasena, $password_bd)) {
                $_SESSION['id_usuario'] = $row['id_usuario'];
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['id_estado_usuario'] = $row['id_estado_usuario'];
                $_SESSION['id_rol'] = $row['id_rol'];

                if ($row['id_estado_usuario'] == 2) {
                    $mensajeEstado = 'Su usuario se encuentra inactivo';
                } elseif ($row['id_estado_usuario'] == 3) {
                    header("Location: ../Vistas/MantenimientoUsuario/Contestar_preguntas.php");
                } elseif ($row['id_estado_usuario'] == 4) {
                    $mensajeEstado = 'Su usuario se encuentra bloqueado.';
                } else {
                    header("Location: index.php");
                    //echo $id_rol;
                }
            } else {

                $contrasenaNoCoincide = "La contraseña no coincide";
                
                if (!isset($_COOKIE['intentosFallidos'])) {
                    setcookie('intentosFallidos', 1, time() + 86400);
                    setcookie('usuarioIntento', $usuario, time() + 86400);
                } else {
                    $cont = $_COOKIE['intentosFallidos'];
                    $usuarioAnterior = $_COOKIE['usuarioIntento'];

                    if ($usuarioAnterior != $usuario) {
                        setcookie('intentosFallidos', 1, time() + 86400);
                        setcookie('usuarioIntento', $usuario, time() + 86400);
                    } else {
                        $cont++;
                        setcookie('intentosFallidos', $cont, time() + 86400);
                    
                        // Obtener el valor máximo de intentos permitidos desde la base de datos
                        $sqlParametro = "SELECT VALOR FROM tbl_ms_parametros WHERE PARAMETRO = 'BLOQUEO'";
                        $stmtParametro = $conn->query($sqlParametro);
                        $rowParametro = $stmtParametro->fetch(PDO::FETCH_ASSOC);
                        $cantMaximaIntentos = $rowParametro['VALOR'];
                        
                        if ($cantMaximaIntentos <= $_COOKIE['intentosFallidos']) {
                            $contrasenaNoCoincide = "Su usuario ha sido bloqueado debido a que excedió la cantidad de intentos.";
                            
                            // Actualizar el estado del usuario en la base de datos
                            $sqlBloquearUsuario = "UPDATE tbl_ms_usuario SET id_estado_usuario = 4 WHERE usuario = :usuario";
                            $stmtBloquearUsuario = $conn->prepare($sqlBloquearUsuario);
                            $stmtBloquearUsuario->bindParam(':usuario', $usuario);
                            $stmtBloquearUsuario->execute();
                            
                            // Eliminar las cookies de intentosFallidos y usuarioIntento
                            setcookie('intentosFallidos', "", time() - 3600);
                            setcookie('usuarioIntento', "", time() - 3600);
                        }
                    }
                }
            }
        } else {
            $NoExisteUsuario = "No existe usuario";
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
                                    <h3 class="text-center font-weight-light my-4">SIAACE</h3><img src="../src/Logo.png" alt="Logo SIAACE" class="logo">
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label><input class="form-control py-4" id="inputEmailAddress" name="usuario" type="text" maxlength="15" placeholder="Ingresa tu usuario:" 
                                        required pattern="^(?!.*\s).*$" title="No se permiten espacios en blanco o campos vacios." oninput="this.value = this.value.toUpperCase()" /></div>
                                        
                                        <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" maxlength="100" placeholder="Ingresa tu contraseña:" 
                                        required pattern="^[^\s]{1,100}$" title="No se permiten espacios en blanco o campos vacios." /></div>
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
                                    <?php if (!empty($contrasenaNoCoincide)) : ?>
                                        <div class="alert alert-danger"><?php echo $contrasenaNoCoincide; ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($NoExisteUsuario)) : ?>
                                        <div class="alert alert-danger"><?php echo $NoExisteUsuario; ?></div>
                                    <?php endif; ?>
                                    <?php if(!empty($mensajeEstado)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeEstado; ?></div>
                                    <?php endif ?>
                                    <?php if (!empty($mensajeLimite)) : ?>
                                        <div class="alert alert-danger"><?php echo $mensajeLimite; ?></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
</body>
</html>