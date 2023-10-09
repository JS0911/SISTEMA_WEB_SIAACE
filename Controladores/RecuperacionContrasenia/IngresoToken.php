<?php
session_start();
// Conectar a la base de datos
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");

$conexion = new Conectar();
$conn = $conexion->Conexion();

if (!empty($_POST)) {
    $imptoken = $_POST['inputToken'];

    if ($imptoken == ""){
        echo "<script type='text/javascript'>
            alert('¡campos vacios.!');
            setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/IngresoToken.php';
            }, 0);
            </script>";
            exit;
    }else{

        /*$Tokens = $_SESSION['token'];
        $User = $_SESSION['user'];*/

        
        if(isset($_SESSION['token'])) {
            $sql = "SELECT id_token FROM tbl_ms_token where ID_TOKEN = '$imptoken'";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $idtoken = $row['id_token'];
        echo "Tamos bien".$imptoken,$idtoken;
        exit();
        
        
        $valor = $_SESSION['mi_variable'];
            echo $valor; // Esto imprimirá 'Hola, Mundo!'
        } else {
            echo "La variable de sesión no está definida.";
        }
        /*if (!empty($_POST)) { //verificar si se recibio el metodo post
            $usuario = $_POST['inputUsuario'];
            $pregunta = $_POST['pregunta'];
            $respuesta = $_POST['inputRespuesta'];

            if ($conn) {// Verificar si la conexión se estableció correctamente
                // Verificar si la pregunta y respuesta existe en la base de datos
                $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE USUARIO = '$usuario'";
                $idusuario = $conn->query($sql);

                $sql = "SELECT * FROM tbl_ms_preguntas_Usuario where ID_PREGUNTA=$pregunta AND ID_USUARIO = $idusuario;";
                $stmt = $conn->query($sql);
                $num = $stmt->rowCount();

                if ($num > 0) {
                    $savetoken = new recuperar();
                    $savetokenn = $savetoken->setTokenUser($usuario,$tokeng);

                    exit;
                } else {
                    echo "<script type='text/javascript'>
                    alert('¡El Usuario, Pregunta o Respuesta no son correctos.!');
                    </script>";
                }
            }else {
                echo "<script type='text/javascript'>
                alert('¡Conexion a la base no realizada.!');
                </script>";
            };
        }else{

        };*/
    }   
}
?>