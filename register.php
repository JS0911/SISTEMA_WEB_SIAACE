<?php

require "Config/conexion.php";
require "funcs.php";

$errors = array();

if($_POST){
    $nombre =$conectar-> real_escape_string($_POST ['nombre' ]);
    $usuario =$conectar-> real_escape_string($_POST ['usuario' ]);
    $email =$conectar-> real_escape_string($_POST ['email' ]);
    $contrasena =$conectar-> real_escape_string($_POST ['contrasena' ]);
    $confirmContrasena =$conectar-> real_escape_string($_POST ['confirmContrasena' ]);

   $estado_usuario=2;
   $rol= 2 ;

   if(isNull($nombre,$usuario,$email,$contrasena,$confirmContrasena)){
    $errors [ ]="Debe llemar todos los campos";
   }
   
   if(validarContrasena($contrasena,$confirmContrasena)){
    $errors [ ]="Las contraseñas no coinciden";
   }
   if(usuarioExiste($usuario)){
    $errors [ ]="El nombre de Usuario $usuario ya existe";
   }

   if(emailExiste($email)){
    $errors [ ]="El correo electronico $email ya existe";
   }

   if(count($errors)==0){
    $registro=registraUsuario($nombre,$usuario,$email,$contrasena,$estado_usuario,$rol);
    if($registro>0){
echo 'REGISTRO CON EXITO';
    }else{
        $errors[ ]="error al registrar";
    }
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
        <link href="css/styles.css" rel="stylesheet" />
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
                                             <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="inputFirstName">Nombre Completo</label><input class="form-control py-4" id="inputFirstName" name="nombre" type="text" placeholder="Ingrese su nombre:" require/></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="inputUser">Nombre Usuario</label><input class="form-control py-4" id="inputUser"  name="usuario" type="text" placeholder="Ingrese su usuario:" require/></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" name="email" type="email" aria-describedby="emailHelp" placeholder="Ingrese su correo electrónico:"require/></div>
                                            
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label><input class="form-control py-4" id="inputPassword" name="contrasena" type="password" placeholder="Ingrese su contraseña:" require/></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirmar Contraseña</label><input class="form-control py-4" id="inputConfirmPassword"  name="confirmContrasena" type="password" placeholder="Confirme su contraseña:" require/></div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0"></div><a href="login.php"><button type="submit" class="btn btn-primary btn-block">Crear Usuario</button></a></div>
                                            
                                        </form>
                                        <?php echo resultBlock($errors);?>
                                    
                                    <div class="card-footer text-center">
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
        <script src="js/scripts.js"></script>
    </body>
</html>
