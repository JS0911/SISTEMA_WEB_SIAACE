<?php
require "../Config/conexion.php"; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verifica si las contraseñas coinciden
    if ($contrasena === $confirmar_contrasena) {
        try {
            // Hasheamos la contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Crear una instancia de la clase Conectar
            $conexion = new Conectar();
            $conn = $conexion->Conexion();

            // Configurar PDO para lanzar excepciones en caso de error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($conn) { // Verificar si la conexión se estableció correctamente
                // Preparar la consulta SQL para insertar el nuevo usuario
                $sql = "INSERT INTO tbl_ms_usuario (usuario, nombre_usuario, correo_electronico, contrasena) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$usuario, $nombre_usuario, $correo_electronico, $hashed_password]);

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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registro</h3></div>
                                    <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-group"><label class="small mb-1" for="inputUser">Usuario</label><input class="form-control py-4" id="inputUser" name="usuario" type="text" placeholder="Ingrese su usuario:" /></div>
                                        <div class="form-group"><label class="small mb-1" for="inputLastNameUser">Nombre Usuario</label><input class="form-control py-4" id="inputLastNameUser" name="nombre_usuario" type="text" placeholder="Ingrese su nombre de usuario:" /></div>
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" name="correo_electronico" type="email" aria-describedby="emailHelp" placeholder="Ingrese su correo electrónico:" /></div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" placeholder="Ingrese su contraseña:" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirmar Contraseña</label><input class="form-control py-4" id="inputConfirmPassword" name="confirmar_contrasena" type="password" placeholder="Confirme su contraseña:" /></div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                                        </div>
                                    </form>
                                    <div class="card-footer mt-4 mb-0 d-flex justify-content-center">
                                        <div class="small"><a href="login.php">¿Ya tienes una cuenta? Ir a inicio sesión</a></div>
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
