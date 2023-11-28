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
<?php
require("../../Controladores/RecuperacionContrasenia/RecuperacionPregunta.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIAACE - Recuperación por Pregunta</title>
        <link rel="shortcut icon" href="../../src/IconoIDH.ico">
        <link href="../../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Recuperación por Pregunta</h3><img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"></div>
                                    <div class="card-body">
                                        <div class="small mb-3 text-muted">Seleccione una pregunta de seguridad y conteste: </div>
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/RecuperacionPregunta.php"name="formRecetPass" method="POST">
                                            <div class="form-group"><label class="small mb-1" for="inputUsuario">Usuario</label>
                                            <input class="form-control py-4" id="inputUsuarios" name="inputUsuario" type="text" maxlength="15" placeholder="Ingresa tu usuario:" 
                                            required pattern="^(?!.*\s).*$" title="No se permiten espacios en blanco o campos vacios." oninput="this.value = this.value.toUpperCase()" /></div>
                                        
                                            <div class="form-group"><label class="small mb-1" for="pregunta">Preguntas de Seguridad</label>
                                            <select name="pregunta" class="form-select form-control form-control" style="width:400px">
                                                <?php
                                                foreach($preguntas as $row ) {
                                                    echo "<option value='$row[ID_PREGUNTA]'>$row[PREGUNTA]</option>";
                                                }
                                                ?>
                                            </select></div>
                                            <div class="form-group"><label class="small mb-1" for="inputRespuesta">Respuesta</label>
                                            <input class="form-control py-4" name="inputRespuesta" id="inputRespuestas" aria-describedby="emailHelp" placeholder="Ingrese su respuesta:" required/></div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" href="../../InicioSesion/login.php">Regresar al Inicio de Sesión</a><a class="small" href="SeleccionarMetodo.php">Probar otro metodo</a></div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Enviar Respuesta</button>
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
