<?php
    require ("../../Config/conexion.php");
    require ("../../Modelos/Recuperacion.php");

    session_start();
    if(!empty($_GET['token'])){
        $user = $_GET['usuario'];
        $token = $_GET['token'];
        $verificar = new recuperar();

        $errors = $verificar->VerificarToken($token,$user);
        if($errors == 'ok'){
            session_start();
            $_SESSION['id_usuario'] = $_GET['usuario'];
            header('Location: ../../Vistas/RecuperacionContrasenia/CambioContrasenia.php');
            session_destroy();
            exit;
        }
    }
?>