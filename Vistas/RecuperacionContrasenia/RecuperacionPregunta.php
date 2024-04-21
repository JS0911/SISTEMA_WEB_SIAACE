<style>
    .logo {
        width: 100px;
        margin: 0 auto;
        display: block;
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
                                    
                                    <div class="card-header"><img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"></div>
                                    <div class="card-body">
                                        
                                        <form id="formRecetPass" action= "../../Controladores/RecuperacionContrasenia/RecuperacionPregunta.php" name="formRecetPass" method="POST">
                                            <div class="form-group"><label class="small mb-1" for="inputUsuario">Usuario</label>
                                            <input class="form-control py-4" id="inputUsuarios" name="inputUsuarios" aria-describedby="emailHelp" type="text" maxlength="15" placeholder="Ingresa tu usuario:" 
                                            required title="No se permiten espacios en blanco o campos vacios." oninput="this.value = this.value.toUpperCase()" />
                                            <input class="form-control py-4" id="inputUsuarios2" name="inputUsuarios2" style="display: none;"/>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                                <button class="btn btn-primary" disabled onclick="verificarFormulario()" id="verPreguntas" name="verPreguntas" type="button" >Ver Preguntas</button>
                                                
                                            </div>
                                            
                                            <div id="preguntasid" style="display: none; ">
                                                <div class="form-group"><label class="small mb-1" for="pregunta">Preguntas de Seguridad</label>
                                                <select id="cmbPreguntas" require name="cmbPreguntas" class="form-select form-control form-control" style="width:400px">
                                                    
                                                    <?php
                                                        if (isset($_POST['verPreguntas'])) {
                                                            foreach($preguntas as $row ) {
                                                                echo "<option value='$row[ID_PREGUNTA]'>$row[PREGUNTA]</option>";
                                                                echo "hola";
                                                           }
                                                        } 
                                                        
                                                    
                                                    ?>
                                                </select></div>
                                                <div class="form-group"><label class="small mb-1" for="inputRespuesta">Respuesta</label>
                                                <input class="form-control py-4" name="inputRespuesta" id="inputRespuestas" aria-describedby="emailHelp" placeholder="Ingrese su respuesta:" required/></div>
                                                
                                                <div class="form-group d-md-flex align-items-center justify-content-center mt-4 mb-0">
                                                <button class="btn btn-success mr-2" id="editarnombre" name="editarnombre" type="button" style="display: none;" >Editar Usuario</button>
                                                <button id="btnverrespuesta"class="btn btn-primary mr-2" type="submit">Enviar Respuesta</button>
                                                </div>
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
        <script>
            document.getElementById("verPreguntas").addEventListener("click", function() {
                document.getElementById("inputUsuarios").disabled = true;
                document.getElementById("inputUsuarios2").disabled = false;
                this.style.display = "none";
                document.getElementById("preguntasid").style.display = "block";
                document.getElementById("editarnombre").style.display = "block";
            });
            document.getElementById("editarnombre").addEventListener("click", function() {
                document.getElementById("inputUsuarios").disabled = false; 
                document.getElementById("preguntasid").style.display = "none"; 
                document.getElementById("verPreguntas").style.display = "block";
                this.style.display = "none"; 
            }); 
            var inputUsuario = document.getElementById("inputUsuarios");
            inputUsuario.addEventListener("input", function() {
                if (inputUsuario.value.trim() !== "") {
                    document.getElementById("verPreguntas").disabled = false;
                } else {
                    document.getElementById("verPreguntas").disabled = true;
                }
            });  
                const inputOriginal = document.getElementById('inputUsuarios');
                const inputCopia = document.getElementById('inputUsuarios2');
                inputOriginal.addEventListener('input', function() {
                    inputCopia.value = inputOriginal.value;
                });
        </script>
        <script>
            function verificarFormulario() {
                    var comboBox = document.getElementById("cmbPreguntas");
                    comboBox.innerHTML = "";
                    var Usuario = document.getElementById("inputUsuarios").value;
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var datos = JSON.parse(xhr.responseText); 
                            for (var i = 0; i < datos.length; i++) {
                                var option = document.createElement("option");
                                option.text = datos[i];
                                comboBox.add(option);
                                
                            }
                        }
                    };
                    xhr.open("POST","../../Modelos/recuperacionfunciones.php?", true); 
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("Usuario=" + Usuario); 
                }
        </script>
        
    </body>
</html>
