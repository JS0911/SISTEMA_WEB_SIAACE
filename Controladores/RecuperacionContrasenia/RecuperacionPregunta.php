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
    $usuario = $_POST['inputUsuarios'];
    $pregunta = $_POST['cmbPreguntas'];
    $respuesta = $_POST['inputRespuesta'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        // Verificar si la pregunta y respuesta existe en la base de datos
        $sql = "SELECT ID_USUARIO FROM tbl_ms_usuario WHERE USUARIO = '$usuario'";
        $idusuario = $conn->query($sql);
        $row = $idusuario->fetch(PDO::FETCH_ASSOC);
        $id_usuario = $row['ID_USUARIO'];

        $sql = "SELECT ID_PREGUNTA FROM tbl_ms_preguntas WHERE PREGUNTA = '$pregunta'";
        $idpregunta = $conn->query($sql);
        $row = $idpregunta->fetch(PDO::FETCH_ASSOC);
        $id_pregunta = $row['ID_PREGUNTA'];

        $_SESSION['usuario'] = $usuario;
        $_SESSION['user']= $id_usuario;

        $sql = "SELECT RESPUESTAS FROM tbl_ms_preguntas_usuario where ID_PREGUNTA = '$id_pregunta' AND ID_USUARIO = '$id_usuario';";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $respuesta2 = $row['RESPUESTAS'];
        $num = $stmt->rowCount();

        if ($num > 0) {
            if($respuesta == $respuesta2){
                echo "<script type='text/javascript'>
                alert('¡Respuestas Correcta!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/CambioContrasenia.php';
                }, 0);
                </script>";
                exit;
            }else{
                echo $usuario;
            echo $id_usuario;
            echo $pregunta;
            echo $id_pregunta;
            echo $respuesta;
            echo $respuesta2;
                /*echo "<script type='text/javascript'>
                alert('¡El Usuario, Pregunta o Respuesta no son correctos.!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php';
                }, 0);
                </script>";
                exit;*/
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