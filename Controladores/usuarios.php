<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once("../config/conexion.php");
require_once("../modelos/Usuarios.php");
require_once("../Modelos/bitacora.php"); 

$com = new Usuario();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetUsuarios":
        $datos = $com->get_usuarios();
        echo json_encode($datos);
    break;

    case "InsertUsuarios":
        $USUARIO = $body["USUARIO"];
        $NOMBRE_USUARIO = $body["NOMBRE_USUARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $CONTRASENA = $body["CONTRASENA"];
        $CORREO_ELECTRONICO = $body["CORREO_ELECTRONICO"];
        $ID_ROL = $body["ID_ROL"];
        if (verificarExistenciaUsuario($USUARIO) > 0){
            http_response_code(409);
            echo json_encode(["error" => "El usuario ya existe en la base de datos."]);
        } elseif (verificarExistenciaEmail($CORREO_ELECTRONICO) > 0) {      
            Http_response_code(409);
            echo json_encode(["error" => "El correo ya existe en la base de datos."]);
        } else {
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Usuario insertado Exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL USUARIO: $USUARIO", $_SESSION['id_usuario'], 2, $_SESSION['usuario'], $dateNew);
        }
    break;

    case "GetUsuario":
        $datos = $com->get_usuario($body["ID_USUARIO"]);
        echo json_encode($datos);
    break;

    case "updateUsuario":
        $ID_USUARIO = $body["ID_USUARIO"];
        $USUARIO = $body["USUARIO"];
        $NOMBRE_USUARIO = $body["NOMBRE_USUARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $CORREO_ELECTRONICO = $body["CORREO_ELECTRONICO"];
        $ID_ROL = $body["ID_ROL"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        $datos = $com->update_usuario($ID_USUARIO, 
            $USUARIO, 
            $NOMBRE_USUARIO, 
            $ID_ESTADO_USUARIO,
            $CORREO_ELECTRONICO, 
            $ID_ROL,
            $_SESSION['usuario'],
            $dateNew
        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL USUARIO # $ID_USUARIO", $_SESSION['id_usuario'], 2, $_SESSION['usuario'], $dateNew);
    break;

    case "eliminarUsuario":
        $ID_USUARIO = $body["ID_USUARIO"];
        $datos = $com->eliminar_usuario($ID_USUARIO);
        echo json_encode("Usuario eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL USUARIO # $ID_USUARIO", $_SESSION['id_usuario'], 2);
    break;
}
function verificarExistenciaUsuario($usuario) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_usuario WHERE USUARIO = :usuario";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

function verificarExistenciaEmail($correo) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = :correo";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

?>
