
<?php
require "Config/conexion.php"; 

session_start();
$usuario = $_SESSION['usuario'];





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevaContraseña = $_POST["contraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];
        //echo $usuario;
    if ($nuevaContraseña === $confirmarContraseña) {
        // Las contraseñas coinciden, procede a cambiar la contraseña en la base de datos.

        // Crear una instancia de la clase Conectar
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $conexion->set_names();

        
        $idUsuario = $usuario; // Cambia a usuario correspondiente.

        // Hashea la nueva contraseña antes de almacenarla en la base de datos
        $hashedPassword = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
        //echo $hashedPassword;
        // consulta SQL
        $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = ? WHERE USUARIO= ?";
        //echo $sql;
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(1, $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(2, $idUsuario, PDO::PARAM_STR);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                echo " Contraseña cambiada con éxito.";
            } else {
                echo "Error al cambiar la contraseña: " . $stmt->errorInfo()[2] . ")";
            }

            // Cierra la conexión
            $conn = null;
        } else {
            echo "Error en la preparación de la consulta: " . $conn->errorInfo()[2];
        }
    } else {
        echo "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    }

    // Redirige al usuario a login.php después de un breve retraso (por ejemplo, 2 segundos)
    header("refresh:2;url=login.php"); 

    // Detiene la ejecución del script para que la redirección funcione
    exit;
}
?>

<!DOCTYPE html>
 
<html lang="es">
<head> 
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Cambio de Contraseña</title>
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
                                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Cambio de Contraseña</h3></div>
                                            <div class="card-body">
                                                
                                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                                                    <!-- input para Contraseña -->
                                                        <div class="wrap-input mb-3" id="grupo__password">
                                                            <label><b>Contraseña</b></label>
                                                                <span class="lock conteiner-icon">
                                                                    <i class="icon type-lock fa fa-eye-solid  fa fa-eye-slash"></i>
                                                                </span>
                                                            <input type="password" class="form-control input" name="contraseña" id="password" maxlength="15" placeholder="Contraseña">
                                                                    <!--  <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                                            <p class="mensaje"></p>
                                                            <br>
                                                        </div>
                                                        <!-- input para confirmación Contraseña -->
                                                        <div class="wrap-input mb-3" id="grupo__password2">
                                                            <label><b>Confirmar contraseña</b></label>
                                                                    <span class="lock conteiner-icon">
                                                                        <i class="icon type-lock fa-eye-solid  fa fa-eye-slash"></i>
                                                                    </span>
                                                                        <input type="password" class="form-control input" name="confirmarContraseña" id="password2" maxlength="15" placeholder="Confirmar Contraseña" >
                                                                        <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                                                        <p class="mensaje"></p>
                                                            <button type="submit" class="btn btn-primary" name="submit" id= "click">Confirmar</button>
                                                        </div>       
                                                    </div>
                                                </form>           
                                    </div>
                                </div>
                            </div>        
                        </div>           
                </main>              
            </div>
        </div> 
          <!-- Este div se utilizará para mostrar mensajes -->
            <div id="mensajeDiv"></div>                     
    </body>
 <html>
