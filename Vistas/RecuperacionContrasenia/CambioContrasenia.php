<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIAACE - Cambio de contraseña</title>
        <link rel="shortcut icon" href="../../src/IconoIDH.ico">
        <link href="../../css/styles.css" rel="stylesheet" />
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Cambio de Contraseña</h3></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Ingrese su correo para enviar </div>
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/CambioContrasenia.php" name="formRecetPass" method="POST">
                                            <div class="form-group"><label class="small mb-1" for="inputPassword">Contraseña</label>
                                            <input class="form-control py-4" name="inputPassword" id="inputPassword" type="password" aria-describedby="emailHelp" placeholder="Ingrese su contraseña:"required /></div>
                                            <div class="form-group"><label class="small mb-1" for="inputConfirm">Confirmar Contraseñá</label>
                                            <input class="form-control py-4" name="inputConfirm" id="inputConfirm" type="password" aria-describedby="emailHelp" placeholder="Confirmar Contraseña:" required/></div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="../../InicioSesion/login.php">Regresar al Inicio de Sesión</a>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Confirmar Contraseña</button>
                                            </div>  
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="../../InicioSesion/register.php">¿Aún no tiene una cuenta? Registrarse</a></div>
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
