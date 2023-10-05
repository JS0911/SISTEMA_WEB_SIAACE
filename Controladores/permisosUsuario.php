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
require_once("../modelos/permisoUsuario.php");


$com = new PermisosUsuarios ();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetPermisoUsuario":
        $datos = $com->get_Permisos_Usuarios($body["id_rol"], $body["id_objeto"]);
        echo json_encode($datos);
        break;

    // case "InsertUsuarios":
    //     $datos = $com->insert_usuarios($body["USUARIO"], $body["NOMBRE_USUARIO"], $body["ID_ESTADO_USUARIO"], $body["CONTRASENA"], $body["CORREO_ELECTRONICO"], $body["ID_ROL"]);
    //     echo json_encode("Usuario Insertado");
    //     break;

    // case "Get_PermisoUsuarios":
    //     $datos = $com->get_PermisoUsuario($body["ID_"]);
    //     echo json_encode($datos);
    //     break;

    // case "updateUsuario":
    //     $ID_USUARIO = $body["ID_USUARIO"];
    //     $USUARIO = $body["USUARIO"];
    //     $NOMBRE_USUARIO = $body["NOMBRE_USUARIO"];
    //     $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
    //     $CORREO_ELECTRONICO = $body["CORREO_ELECTRONICO"];
    //     $ID_ROL = $body["ID_ROL"];

    //     $datos = $com->update_usuario($ID_USUARIO, $USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CORREO_ELECTRONICO, $ID_ROL);
    //     echo json_encode($datos);
        break;
}