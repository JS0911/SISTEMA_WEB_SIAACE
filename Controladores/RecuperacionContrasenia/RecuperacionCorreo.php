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
    $usuario = $_POST['inputUsuario'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        // Verificar si el correo electrónico y usuario existen en la base de datos
        $sql = "SELECT * FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$email' and USUARIO = '$usuario'";
        $stmt = $conn->query($sql);
        $num = $stmt->rowCount();

        if ($num > 0) {
            $token = new recuperar();
            $tokeng = $token->generar_Token();

            $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$email' and USUARIO = '$usuario'";
        	$idusuario = $conn->query($sql);

            $_SESSION['token'] = $tokeng;
            $_SESSION['user'] = $idusuario;

            $savetoken = new recuperar();
            $savetokenn = $savetoken->setTokenUser($usuario,$tokeng);

            $insToken = $conn->query($savetokenn);

            //enviarCorreo($email, $tokeng);

            //enviar mail-------------
            $destinatario = '$email';
            $asunto = "Prueba de correo desde PHP";
            $mensaje = "Hola,\n\nEste es un correo de prueba enviado desde PHP.";

            // Cabeceras del correo
            $headers = "From: lester.padilla@unah.hn\r\n";
            $headers .= "Reply-To: lester.padilla@unah.hn\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Enviar el correo
            $mail_enviado = mail($destinatario, $asunto, $mensaje, $headers);

            if ($mail_enviado) {
                /*echo "<script type='text/javascript'>
                alert('¡Se ha enviado un enlace de recuperación a tu correo electrónico.!');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/IngresoToken.php';
                }, 0);
                </script>";*/
            exit();
            } else {
                /*echo "<script type='text/javascript'>
                alert('¡Correo no se ha enviado.!');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php';
                }, 0);
                </script>";*/
                exit();
            }
            //enviar mail-------------

            
        } else {
            echo "<script>
                alert('¡El Usuario o Correo electronico no son correctos.!');
                setTimeout(function() {
                    window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php';
                }, 0);
            </script>";
            exit();
        }
    };
};
?>