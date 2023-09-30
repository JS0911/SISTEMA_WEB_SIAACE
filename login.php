<?php
//CREAR CONEXION
require "Config/conexion.php";
session_start();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Crear una instancia de la clase Conectar
    $conexion = new Conectar();
    $conn = $conexion->Conexion();

    if ($conn) { // Verificar si la conexión se estableció correctamente
        $sql = "SELECT id_usuario, usuario, contrasena FROM tbl_ms_usuario WHERE usuario='$usuario'";
        //echo $sql;
        $stmt = $conn->query($sql);

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
                    header("Location: index.php");
                } else {
                    echo "La contraseña no coincide";
                }
            } else {
                echo "No existe usuario";
            }
        } else {
            echo "Error en la consulta: " . $conn->errorInfo()[2]; // Mostrar el mensaje de error de PDO
        }
    } else {
        echo "Error al conectar a la base de datos.";
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
        <title>SIAACE - Login</title>
        <link href="css/styles.css" rel="stylesheet" />
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">IDH Microfinanciera</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label><input class="form-control py-4" id="inputEmailAddress" name="usuario" type="text" placeholder="Ingresa tu usuario:" /></div>
                                            <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" placeholder="Ingresa tu contraseña:" /></div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox"><input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" /><label class="custom-control-label" for="rememberPasswordCheck">Recordar contraseña</label></div>
											</div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="password.php">¿Olvido su contraseña? Recuperar aquí</a></div>
											<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="register.php">¿No tienes cuenta? Crea una aqui</a>
                                            <button type="submit" class="btn btn-primary">Ingresar</button></div>
										</form>
									</div>
                                    <div class="card-footer text-center">
                                    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Crear Cuenta</button>
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

    <!-- Modal para crear un nuevo registro -->
    <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
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
                            <label for="nombre">Usuario</label>
                            <input type="text" class="form-control" id="agregar-usuario">

                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="agregar-nombre">

                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="agregar-estado">

                            <label for="estado">Correo Electronico</label>
                            <input type="text" class="form-control" id="agregar-correo">

                            <label for="estado">Rol</label>
                            <input type="text" class="form-control" id="agregar-rol">

                            <label for="estado">Contraseña</label>
                            <input type="password" class="form-control" id="agregar-contrasena">

                            <label for="estado">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirmar-contrasena">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn-agregar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Final de la modal de autoregistro -->
    
        <script src="Vistas/MantenimientoUsuario/Insertar_Usuario.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>

	</body>

</html>
