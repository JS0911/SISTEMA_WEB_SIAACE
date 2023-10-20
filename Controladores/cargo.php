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
require_once("../modelos/cargo.php"); 

$com = new Cargos(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetCargos":
        $datos = $com-> get_cargos();
        echo json_encode($datos);
        break;

    case "InsertCargo":
        $datos = $com->insert_cargo(
            $body["CARGO"],
            $body["DESCRIPCION"],
            $body["ESTADO"]
        );
        echo json_encode("Cargo Insertado");
        break;

    case "GetCargo":
        $datos = $com->get_cargo($body["ID_CARGO"]);
        echo json_encode($datos);
        break;

    case "UpdateCargo":
        $ID_CARGO = $body["ID_CARGO"];
        $CARGO = $body["CARGO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO = $body["ESTADO"];

        $datos = $com->update_cargo(
            $ID_CARGO,
            $CARGO,
            $DESCRIPCION,
            $ESTADO
        );
        echo json_encode($datos);
        break;

        case "EliminarCargo":
            $ID_CARGO = $body["ID_CARGO"];
            $datos = $com->eliminar_cargo($ID_CARGO);
            echo json_encode("Cargo eliminado");
            break;
}
?>
