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
require_once("../Modelos/estadousuario.php"); 
require_once("../Modelos/bitacora.php"); 

$com = new Estados(); 
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetEstados":
        $datos = $com->get_estados();
        echo json_encode($datos);
    break;

    case "InsertEstado":
        // Obtén los datos del Estado
        $NOMBRE = $body["NOMBRE"];
        $DESCRIPCION = $body["DESCRIPCION"];
        if (verificarExistenciaEstado($NOMBRE) > 0) {
            // Envía una respuesta de conflicto (409) si el objeto ya existe
            http_response_code(409);
            echo json_encode(["error" => "El estado ya existe en la base de datos."]);
        } else {
            // Inserta el estado en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-8 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_estado($NOMBRE, $DESCRIPCION);
            echo json_encode(["message" => "Estado insertado exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL ESTADO: $NOMBRE", $_SESSION['id_usuario'], 6, $_SESSION['usuario'], $dateNew);

        }
    
    break;

    case "GetEstado":
        $datos = $com->get_estado($body["ID_ESTADO_USUARIO"]);
        echo json_encode($datos);
    break;

    case "UpdateEstado":
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $NOMBRE = $body["NOMBRE"];
        $DESCRIPCION = $body["DESCRIPCION"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");

        $datos = $com->update_estado(
            $ID_ESTADO_USUARIO,
            $NOMBRE,
            $DESCRIPCION
        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL ESTADO # $ID_ESTADO_USUARIO", $_SESSION['id_usuario'], 6, $_SESSION['usuario'], $dateNew);

    break;

    case "EliminarEstado":
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $datos = $com->eliminar_estado($ID_ESTADO_USUARIO);
        echo json_encode("Estado eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL ESTADO # $ID_ESTADO_USUARIO", $_SESSION['id_usuario'], 6);
    break;
}
    function verificarExistenciaEstado($nombre) {
        // Realiza una consulta en la base de datos para verificar si el objeto ya existe
        $sql = "SELECT COUNT(*) as count FROM tbl_ms_estadousuario WHERE NOMBRE = :nombre";

        // Realiza la conexión a la base de datos y ejecuta la consulta
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devuelve el número de resultados encontrados
        return $row['count'];
    }

?>