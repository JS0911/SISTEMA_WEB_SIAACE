<?php
session_start();
// Conectar a la base de datos
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");

$row= '';
$conexion = new Conectar();
$conn = $conexion->Conexion();

//$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT ID_PREGUNTA, PREGUNTA FROM tbl_ms_preguntas";
$preguntas = $conn->query($sql);

if (!empty($_POST)) { //verificar si se recibio el metodo post
    $usuario = $_POST['inputUsuario'];
    $pregunta = $_POST['pregunta'];
    $respuesta = $_POST['inputRespuesta'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        // Verificar si la pregunta y respuesta existe en la base de datos
        $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE USUARIO = '$usuario'";
        $idusuario = $conn->query($sql);
        
        $row = $idusuario->fetch(PDO::FETCH_ASSOC);
        $id_usuario = $row['ID_USUARIO'];

        $_SESSION['usuario'] = $usuario;
        $_SESSION['id_usuario']= $id_usuario;

        $sql = "SELECT RESPUESTAS FROM tbl_ms_preguntas_Usuario where ID_PREGUNTA = '$pregunta' AND ID_USUARIO = '$id_usuario';";
        $stmt = $conn->query($sql);
        $num = $stmt->rowCount();

        if ($num > 0) {
            $ConfirmarRespuesta = $stmt->fetch(PDO::FETCH_ASSOC);
            $Confirmar = $ConfirmarRespuesta['RESPUESTAS'];
            if($respuesta == $Confirmar){
                header("Location: ../../Vistas/RecuperacionContrasenia/CambioContrasenia.php");
                exit;
            }else{
                echo "<script type='text/javascript'>
                alert('¡Respuestas correctas.!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php';
                }, 0);
                </script>";
                exit;
            }   
        } else {
            echo "<script type='text/javascript'>
            alert('¡El Usuario, Pregunta o Respuesta no son correctos.!');
            setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php';
            }, 0);
            </script>";
            exit;
        }
    }else {
        echo "<script type='text/javascript'>
        alert('¡Conexion a la base no realizada.!');
        setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php';
            }, 0);
            </script>";
        exit;
    };
}else{

};
?>