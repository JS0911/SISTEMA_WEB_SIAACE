<?php
session_start();
// Conectar a la base de datos
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");
//require ("../../Modelos/EnviarCorreo.php");

$conexion = new Conectar();
$conn = $conexion->Conexion();

if (!empty($_POST)) { //verificar si se recibio el metodo post
    $email = $_POST['inputEmail'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        // Verificar si el correo electrónico y usuario existen en la base de datos
        $sql = "SELECT * FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$email'";
        $stmt = $conn->query($sql);
        $num = $stmt->rowCount();
        $use1 = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($num > 0) {
            $token = new recuperar();

            //cosulta de id_usuario
            $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$email'";
        	$idusuario = $conn->query($sql);

            //genera token y guarda en la base de datos
            $tokeng = $token->generar_Token();

            

            $savetoken = new recuperar();

            $row = $idusuario->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $row['ID_USUARIO'];
            $usuario = $use1['USUARIO'];

            //guardar datos en sesión
            $_SESSION['token'] = $tokeng;
            $_SESSION['user'] = $id_usuario;

            $savetokenn = $savetoken->setTokenUser($usuario,$tokeng,$id_usuario);

            $insToken = $conn->query($savetokenn);
            //enviarCorreo($email, $tokeng);
            
            //enviar mail-------------
            //$asunto = "Método de recuperación de contraseña por Correo Electrónico.";
            //$mensaje = "<div>Hola $usuario de SIAACE - IDH Microfinanciera. </div><br><div>Recibimos una solicitud para restablecer tu password.</div>
            //<div>Ingresa el siguiente codigo para restablecer la password.</div><br>
            //<div><h2>$tokeng</h2></div><br>";
            //<div><a href=https://idhcoop.site/SISTEMA_WEB_SIAACE/Vistas/RecuperacionContrasenia/IngresoToken.php?token='$tokeng'&usuario='$id_usuario'>Recuperar</a></div>";

            $asunto = "=?UTF-8?B?".base64_encode("Método de recuperación de contraseña por Correo Electrónico")."?=";
            $mensaje = "<html>
            <head>
            <title>Método de recuperación de contraseña por Correo Electrónico.</title>
            </head>
            <body>
            <div style='font-family: Arial, sans-serif;'>
            <h2>Hola $usuario de SIAACE - IDH Microfinanciera,</h2>
            <p>Recibimos una solicitud para restablecer tu contraseña.</p>
            <p>Sigue las instrucciones a continuación:</p>

            <p>1. Ingresa el siguiente código para restablecerla:</p>
            <h3>$tokeng</h3>
            <p>2. Verificalo.</p>
            <p>3. Si no solicitaste este cambio, por favor ignora este mensaje.</p>

            <p>Gracias. Atentamente, <br>Equipo de soporte de SIAACE - IDH Microfinanciera.</p>
            </div>
            <div class='container content'>
                <p>Oficina Principal: Final del Blvd. Los Próceres entrada a colonia San Miguel, Tegucigalpa, Honduras, C.A.</p>
                <p>Teléfono: + (504) 2276-3550</p>
                <p>Email: info@idhmicrofinanciera.hn</p>

                <!-- Agregar enlaces a Facebook y YouTube -->
                <p>Síguenos en:</p>
                <a href='https://www.facebook.com/idhmicrofinanciera' target='_blank'>Facebook</a>
                <a href='https://www.youtube.com/channel/UCeeQoHQn0Vl53elS6aJsxdg' target='_blank'>YouTube</a>
            </div>
            <img src='../../src/Dashboard.jpg' alt='Dashboard Image' style='display: block; margin: 20px auto; max-width: 100%;'>
            </body>
            </html>";


            $errors = $savetoken->enviarCorreo($email,$asunto,$mensaje);
            If ($errors !="Ha ocurrido un error. Intentelo mas tarde."){
            echo "<script>
                alert('$errors');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/IngresoToken.php';
                }, 0);
            </script>";
            
            exit();
            }else{
                echo "<script>
                alert('$errors');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php';
                }, 0);
            </script>";
            
            exit();
            }
        } else {
            echo "<script>
                alert('¡El Correo electronico no es correcto.!');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php';
                }, 0);
            </script>";
            exit();
        }
    };
};
?>