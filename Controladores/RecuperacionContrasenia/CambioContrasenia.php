<?php
session_start();
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");
//require ("../../Config/Ruta.php");


// Conectar a la base de datos


$conexion = new Conectar();
$conn = $conexion->Conexion();

$idusuario = $_SESSION['user'];

if (!empty($_POST)) { //verificar si se recibio el metodo post
    $nuevaContraseña = $_POST['inputPassword'];
    $confirmarContraseña = $_POST['inputConfirm'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        if ($nuevaContraseña === $confirmarContraseña) {
            // Nuevas contraseñas coinciden

            // Encriptar la contraseña
            $hash_contrasena = password_hash($confirmarContraseña, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = ? WHERE ID_USUARIO = ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bindParam(1, $hash_contrasena, PDO::PARAM_STR);
                    $stmt->bindParam(2, $idusuario, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $date = new DateTime(date("Y-m-d H:i:s"));
                        $dateMod = $date->modify("-7 hours");
                        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
                        $sql2 = "INSERT INTO tbl_ms_historial_contrasena(CONTRASENA, ID_USUARIO, FECHA_MODIFICACION) VALUES ('$hash_contrasena', '$idusuario', '$dateNew');";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->execute();
                        echo "<script type='text/javascript'>
                            alert('¡Contraseña Cambiada con exito.!');
                            setTimeout(function() {
                            window.location.href = '../../InicioSesion/login.php';
                            }, 0);
                            </script>";
                        exit;
                    } else {

                        echo "Error al cambiar la contraseña: " . $stmt->errorInfo()[2];
                    }
                }
        } else {
            echo "<script type='text/javascript'>
                alert('¡Las contraseñas no Coinsiden.!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/CambioContrasenia.php';
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
}
?>

