<?php

// Conectar a la base de datos
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");
session_start();
$conexion = new Conectar();
$conn = $conexion->Conexion();
$errors = "";

if (!empty($_POST)) {
    $imptoken = $_POST['inputToken'];
    $user = $_SESSION['user'];
    $toke = $_SESSION['token'];
    if ($imptoken == ""){
        echo "<script type='text/javascript'>
            alert('¡campos vacios.!');
            setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/IngresoToken.php';
            }, 0);
            </script>";
            exit;
    }else{
        if($_SESSION['token'] === $imptoken) {
            $verificar = new recuperar();
            $errors = $verificar->VerificarToken($token,$user);
            if($errors == 'ok'){
                header('Location: ../../Vistas/RecuperacionContrasenia/CambioContrasenia.php');
                exit;
            }
        }else{
        }
        echo "<script type='text/javascript'>
        alert('¡Token Incorrecto.!');
        setTimeout(function() {
            window.location.href = '../../Vistas/RecuperacionContrasenia/IngresoToken.php';
        }, 0);
        </script>";
        exit;
    }   
}
?>