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
        <title>SIAACE - Recuperación por Correo</title>
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
                                    <div class="card-header"><img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Ingrese su correo electronico </div>
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/RecuperacionCorreo.php"name="formRecetPass" method="POST">
                                            <!--
                                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Usuario</label>
                                            <input class="form-control py-4" id="inputUsuarios" name="inputUsuario" type="text" maxlength="15" placeholder="Ingresa tu usuario:" 
                                            required pattern="^(?!.*\s).*$" title="No se permiten espacios en blanco o campos vacios." oninput="this.value = this.value.toUpperCase()" /></div>
                                        -->
                                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Correo:</label>
                                            <input class="form-control py-4" maxlength="70" name="inputEmail" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Ingrese su Correo:" required/></div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Enviar Token</button>
                                            </div>  <!-- href="../../Controladores/Recuperacion.php" -->
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
