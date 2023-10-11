<?php
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

$com = new Roles(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetRoles":
        $datos = $com->get_roles();
        echo json_encode($datos);
        break;

    case "InsertRol":
        $datos = $com->insert_rol(
            $body["ROL"],
            $body["DESCRIPCION"]
        );
        echo json_encode("rol Insertado");
        break;

    case "GetRol":
        $datos = $com->get_rol($body["ID_ROL"]);
        echo json_encode($datos);
        break;

    case "UpdateRol":
        $ID_ROL = $body["ID_ROL"];
        $ROL = $body["ROL"];
        $DESCRIPCION = $body["DESCRIPCION"];
      

        $datos = $com->update_rol(
            $ID_ROL,
            $ROL,
            $DESCRIPCION,
    
        );
        echo json_encode($datos);
        break;

    case "EliminarRol":
        $ID_ROL= $body["ID_ROL"];
        $datos = $com->eliminar_ROL($ID_ROL);
        echo json_encode("rol eliminado");
        break;
}
?>
