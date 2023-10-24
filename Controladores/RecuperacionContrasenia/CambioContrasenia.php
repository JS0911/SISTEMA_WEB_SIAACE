<?php
session_start();
// Conectar a la base de datos
require ("../../Config/conexion.php");
require ("../../Modelos/Recuperacion.php");

$conexion = new Conectar();
$conn = $conexion->Conexion();

$idusuario = $_SESSION['id_usuario'];

if (!empty($_POST)) { //verificar si se recibio el metodo post
    $nuevaContraseña = $_POST['inputPassword'];
    $confirmarContraseña = $_POST['inputConfirm'];

    if ($conn) {// Verificar si la conexión se estableció correctamente
        if ($nuevaContraseña === $confirmarContraseña) {
            // Nuevas contraseñas coinciden

            // Encriptar la contraseña
            $hash_contrasena = password_hash($confirmarContraseña, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = ?WHERE ID_USUARIO = ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bindParam(1, $hash_contrasena, PDO::PARAM_STR);
                    $stmt->bindParam(2, $idusuario, PDO::PARAM_STR);

                    if ($stmt->execute()) {
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