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

            //cosulta de id_usuario
            $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = '$email' and USUARIO = '$usuario'";
        	$idusuario = $conn->query($sql);

            //genera token y guarda en la base de datos
            $tokeng = $token->generar_Token();

            

            $savetoken = new recuperar();

            $row = $idusuario->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $row['ID_USUARIO'];

            //guardar datos en sesión
            $_SESSION['token'] = $tokeng;
            $_SESSION['user'] = $id_usuario;

            $savetokenn = $savetoken->setTokenUser($usuario,$tokeng,$id_usuario);

            $insToken = $conn->query($savetokenn);
            //enviarCorreo($email, $tokeng);
            
            //enviar mail-------------
            $asunto = "IDH - Recuperación de Correo";
            $mensaje = "<div>Hola $usuario.</div><br><div>Recibimos una solicitud para restablecer tu password de IDH.</div>
            <div>Ingresa el siguiente codigo para restablecer la password.</div><br>
            <div><h2>$tokeng</h2></div><br>";
            //<div><a href=https://idhcoop.site/SISTEMA_WEB_SIAACE/Vistas/RecuperacionContrasenia/IngresoToken.php?token='$tokeng'&usuario='$id_usuario'>Recuperar</a></div>";

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