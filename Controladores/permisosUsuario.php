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

require_once("../Config/conexion.php");
require_once("../modelos/permisoUsuario.php");


$com = new PermisosUsuarios();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetPermisoUsuario":
        $datos = $com->get_Permisos_Usuarios($body["id_rol"], $body["id_objeto"]);
        echo json_encode($datos);


        break;

        case "InsertPermiso":
            $datos = $com->insert_permiso($body["ID_ROL"], $body["ID_OBJETO"], $body["PERMISOS_INSERCION"], $body["PERMISOS_ELIMINACION"], $body["PERMISOS_ACTUALIZACION"], $body["PERMISOS_CONSULTAR"]);
            echo json_encode($datos); // Envía la respuesta de la función insert_permiso
            break;
        

    case "Get_Permisos":
        $datos = $com->get_Permisos();
        echo json_encode($datos);
        break;

        case "updatePermiso":
            $ID_ROL = $body["ID_ROL"];
            $ID_OBJETO = $body["ID_OBJETO"];
            $PERMISOS_INSERCION = $body["PERMISOS_INSERCION"];
            $PERMISOS_ELIMINACION = $body["PERMISOS_ELIMINACION"];
            $PERMISOS_ACTUALIZACION = $body["PERMISOS_ACTUALIZACION"];
            $PERMISOS_CONSULTAR = $body["PERMISOS_CONSULTAR"];

            $datos = $com->update_permiso($ID_ROL, $ID_OBJETO, $PERMISOS_INSERCION, $PERMISOS_ELIMINACION, $PERMISOS_ACTUALIZACION, $PERMISOS_CONSULTAR);
            echo json_encode($datos);
        break;

        case "deletePermiso":
            $ID_ROL = $body["ID_ROL"];
            $ID_OBJETO = $body["ID_OBJETO"];
            $datos = $com->eliminar_permiso($ID_ROL,$ID_OBJETO);
            echo json_encode($datos); // Donde $datos contiene el mensaje de resultado ("Permiso eliminado" o cualquier otro mensaje).
            //echo json_encode("Permiso eliminado");
            break;
}
