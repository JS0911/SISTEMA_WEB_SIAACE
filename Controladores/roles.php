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
require_once("../modelos/roles.php");
require_once("../Modelos/bitacora.php");

$com = new Roles();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetRoles":
        $datos = $com->get_roles();
        echo json_encode($datos);
        break;

    case "InsertRol":

        // Obtén los datos del ROL
        $ROL = $body["ROL"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];

        if (verificarExistenciaRol($ROL) > 0) {
            // Envía una respuesta de conflicto (409) si el ROL ya existe
            http_response_code(409);
            echo json_encode(["error" => "El rol ya existe en la base de datos."]);
            exit; // Detener la ejecución del script
        } else {
            // Inserta el ROL en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_rol($ROL, $DESCRIPCION, $ID_ESTADO_USUARIO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Rol insertado exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL ROL: $ROL", $_SESSION['id_usuario'], 1, $_SESSION['usuario'], $dateNew);
            exit; // Detener la ejecución del script después de enviar la respuesta exitosa
        }



        break;

    case "GetRol":
        $datos = $com->get_rol($body["ID_ROL"]);
        echo json_encode($datos);
        break;

    case "UpdateRol":
        $ID_ROL = $body["ID_ROL"];
        $ROL = $body["ROL"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");

        $datos = $com->update_rol(
            $ID_ROL,
            $ROL,
            $DESCRIPCION,
            $ID_ESTADO_USUARIO,
            $_SESSION['usuario'],
            $dateNew

        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL ROL # $ID_ROL", $_SESSION['id_usuario'], 1, $_SESSION['usuario'], $dateNew);

        break;

    case "EliminarRol":
        $ID_ROL = $body["ID_ROL"];
        $datos = $com->eliminar_ROL($ID_ROL);
        echo json_encode("Rol eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL ROL # $ID_ROL", $_SESSION['id_usuario'], 1);

        break;
        case "get_permisos_por_rol":
            $ID_ROL = $body["ID_ROL"];
        
            // Obtener la lista de permisos para el rol
            $permisos = $com->get_permisos_por_rol($ID_ROL);
        
            // Combinar la información del rol y la lista de permisos en un solo arreglo
            $datos = array(
                
                "permisos" => $permisos
            );
        
            echo json_encode($datos);
            break;
          
}

function verificarExistenciaRol($rol)
{
    // Realiza una consulta en la base de datos para verificar si el ROL ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_roles WHERE ROL = :rol";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rol', $rol);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
