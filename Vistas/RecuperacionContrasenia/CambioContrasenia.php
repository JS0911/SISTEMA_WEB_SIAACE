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
                                    <div class="card-header"><img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Ingrese su nueva contraseña:</div>
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/CambioContrasenia.php" name="formRecetPass" method="POST">
                                        <label class="small mb-1" for="inputPassword">Contraseña</label>
                                        <div class="input-group">
                                            <input class="form-control py-4" name="inputPassword" id="inputPassword" type="password" aria-describedby="emailHelp" placeholder="Ingrese su contraseña:" required />
                                            <div class="input-group-append">
                                                <button type="button" id="showPasswordBtn" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                                                    <i id="eyeIcon" class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <label class="small mb-1" for="inputConfirm">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <input class="form-control py-4" name="inputConfirm" id="inputConfirm" type="password" aria-describedby="emailHelp" placeholder="Confirmar Contraseña:" required/>
                                            <div class="input-group-append">
                                                <button type="button" id="showConfirmPasswordBtn" class="btn btn-outline-secondary" onclick="toggleConfirmPasswordVisibility()">
                                                    <i id="confirmEyeIcon" class="fas fa-eye"></i>
                                                </button>
                                            </div>
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
        <script>document.querySelector('.toggle-password').addEventListener('click', function() {
            const input = document.querySelector('#inputConfirm');
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        </script>
        <script>
        function togglePasswordVisibility() {
    var passwordInput = document.getElementById("inputPassword");
    var eyeIcon = document.getElementById("eyeIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

function toggleConfirmPasswordVisibility() {
    var confirmInput = document.getElementById("inputConfirm");
    var confirmEyeIcon = document.getElementById("confirmEyeIcon");
    if (confirmInput.type === "password") {
        confirmInput.type = "text";
        confirmEyeIcon.classList.remove("fa-eye");
        confirmEyeIcon.classList.add("fa-eye-slash");
    } else {
        confirmInput.type = "password";
        confirmEyeIcon.classList.remove("fa-eye-slash");
        confirmEyeIcon.classList.add("fa-eye");
    }
}
        </script>

    </body>
</html>
