<?php
require "../Config/conexion.php"; // Incluye el archivo de conexión a la base de datos

// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

$mensajeUsuarioExistente = $mensajeCampos = $mensajeLetras = $mensajeCorreoInvalido = $mensajeContrasenaCorta = $mensajeContrasenaDebil = $mensajeContrasenaUsuario = "";

if (isset($_POST['submit'])) {
    $usuario = $_POST['usuario'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $id_estado_usuario = 3;
    $preguntas_contestadas=0;
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // V A L I D A C I O N E S 
    $sql = "SELECT usuario FROM tbl_ms_usuario WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usuario]);

    // R E V I S A R

    if ($stmt->rowCount() > 0) {
        $mensajeUsuarioExistente = "El usuario ya existe en la base de datos. Por favor, elija otro nombre de usuario.";
    } else {
        if (empty($usuario) || empty($nombre_usuario) || empty($correo_electronico) || empty($contrasena) || empty($confirmar_contrasena)) {
            $mensajeCampos = "Todos campos deben estar llenos.";
        } elseif (!preg_match("/^[a-zA-Z]+$/", $usuario)) {
            $mensajeLetras = "El campo de usuario solo debe contener letras y no números.";
        } elseif (!filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
            $mensajeCorreoInvalido = "La dirección de correo electrónico no es válida.";
        }
        if (strlen($contrasena) < 8) {
            $mensajeContrasenaCorta = "La contraseña debe tener al menos 8 caracteres.";
        } elseif (!preg_match("/[A-Z]/", $contrasena) || !preg_match("/[a-z]/", $contrasena) || !preg_match("/[0-9]/", $contrasena) || !preg_match("/[^A-Za-z0-9]/", $contrasena)) {
            $mensajeContrasenaDebil = "La contraseña debe incluir al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.";
        } elseif (strpos($contrasena, $usuario) !== false) {
            $mensajeContrasenaUsuario = "La contraseña no puede ser igual al nombre de usuario.";
        } else {
            $mensajeError = "Lo siento, ha ocurrido un error inesperado.";
        }
    }

    // Verifica si las contraseñas coinciden
    if ($contrasena === $confirmar_contrasena) {
        try {
            // Hasheamos la contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Configurar PDO para lanzar excepciones en caso de error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($conn) { // Verificar si la conexión se estableció correctamente
                // Preparar la consulta SQL para insertar el nuevo usuario
                $sql = "INSERT INTO tbl_ms_usuario (usuario, nombre_usuario, correo_electronico, contrasena,id_estado_usuario,preguntas_contestadas) VALUES (?, ?, ?, ?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$usuario, $nombre_usuario, $correo_electronico, $hashed_password,$id_estado_usuario,$preguntas_contestadas]);


                header("Location: login.php");
                echo "Usuario registrado exitosamente.";
                exit; // Asegura que no se ejecute más código después de la redirección
            } else {
                echo "Error al conectar a la base de datos.";
            }
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage(); // Mostrar el mensaje de error de PDO
        }
    } else {
        echo "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIAACE - Registro</title>
    <link href="../css//styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registro</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                        <div class="form-group"><label class="small mb-1" for="inputUser">Usuario</label><input class="form-control py-4" id="inputUser" name="usuario" type="text" maxlength="15" placeholder="Ingrese su usuario:" required pattern="^[A-Za-z]+$" title="Ingrese solo letras (sin números ni caracteres especiales)" required pattern="^\S.*$" title="No se permiten espacios en blanco al principio." oninput="this.value = this.value.toUpperCase()" /></div>

                                        <div class="form-group"><label class="small mb-1" for="inputLastNameUser">Nombre Usuario</label><input class="form-control py-4" id="inputLastNameUser" name="nombre_usuario" type="text" maxlength="100" placeholder="Ingrese su nombre de usuario:" required pattern="^[A-Za-z]+$" title="Ingrese solo letras (sin números ni caracteres especiales)" required pattern="^\S.*$" title="No se permiten espacios en blanco al principio." oninput="this.value = this.value.toUpperCase()" /></div>

                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" name="correo_electronico" type="email" maxlength="50" aria-describedby="emailHelp" placeholder="Ingrese su correo electrónico:" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Ingrese una dirección de correo electrónico válida" /></div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" maxlength="100" placeholder="Ingrese su contraseña:" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" required /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirmar Contraseña</label><input class="form-control py-4" id="inputConfirmPassword" name="confirmar_contrasena" type="password" maxlength="100" placeholder="Confirme su contraseña:" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$" title="La contraseña debe contener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial" required /></div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0 d-flex justify-content-center">
                                            <button type="submit" name="submit" class="btn btn-primary">Crear Usuario</button>
                                        </div>
                                    </form>
                                    <div class="card-footer mt-4 mb-0 d-flex justify-content-center">
                                        <div class="small"><a href="login.php">¿Ya tienes una cuenta? Ir a inicio sesión</a></div>
                                    </div>
                                    <!-- Este div se utilizará para mostrar mensajes -->
                                    <!-- R E V I S A R -->
                                    <div id="mensajeDiv">
                                        <?php if (!empty($mensajeUsuarioExistente)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeUsuarioExistente; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeCampos)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeCampos; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeLetras)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeLetras; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeCorreoInvalido)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeCorreoInvalido; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeContrasenaCorta)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeContrasenaCorta; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeContrasenaDebil)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeContrasenaDebil; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeContrasenaUsuario)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeContrasenaUsuario; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($mensajeError)) : ?>
                                            <div class="alert alert-danger"><?php echo $mensajeError; ?></div>
                                        <?php endif; ?>
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