<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIAACE - Recuperación por Correo</title>
        <link rel="icon" href="../../src/IconoIDH.ico">
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Metodo de Recuperación</h3></div>
                                    <div class="card-body">
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/MetodoRecuperacion.php" name="formRecetPass" method="POST">
                                            <h2 class ="titulo-registro" style="font-size: 1.8rem;  ">Elije un método para la recuperación</h2>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="radioOption" id="correo" value="correo" checked>
                                                <label class="form-check-label" for="correo" style="font-size: 1rem;">Correo electrónico</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="radioOption" id="pregunta" value="pregunta">
                                                <label class="form-check-label" for="pregunta" style="font-size: 1rem;">Pregunta secreta</label>
                                            </div></div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Continuar</button>
                                            </div>  <!-- href="../../Controladores/Recuperacion.php" -->
                                            <div class="form-group d-flex align-items-center justify-content-center mt-2 mb-0">
                                            <a href="../../InicioSesion/login.php" class="btn btn-danger" style="margin-top: 1.5rem; ">Cancelar</a>
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
