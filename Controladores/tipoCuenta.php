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
require_once("../modelos/tipoCuenta.php"); 

$com = new Cuentas(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetTiposCuentas":
        $datos = $com-> get_tipoCuentas();
        echo json_encode($datos);
        break;

    case "InsertTipoCuenta":
        $datos = $com->insert_tipoCuenta(
            $body["TIPO_CUENTA"],
            $body["DESCRIPCION"],
            $body["TASA"],
            $body["ESTADO"]
        );
        echo json_encode("Tipo de cuenta Insertado");
        break;

    case "GetTipoCuenta":
        $datos = $com->get_tipoCuenta($body["ID_TIPOCUENTA"]);
        echo json_encode($datos);
        break;



    case "UpdateTipoCuenta":
            $ID_TIPOCUENTA = $body["ID_TIPOCUENTA"];
            $TIPO_CUENTA = $body["TIPO_CUENTA"];
            $DESCRIPCION = $body["DESCRIPCION"];
            $TASA = $body["TASA"];
            $ESTADO = $body["ESTADO"];
          
    
            $datos = $com->update_tipoCuenta(
                $ID_TIPOCUENTA,
                $TIPO_CUENTA,
                $DESCRIPCION,
                $TASA,
                $ESTADO 
              
        
            );
            echo json_encode($datos);
            break;

        case "EliminarTipoCuenta":
            $ID_TIPOCUENTA = $body["ID_TIPOCUENTA"];
            $datos = $com->eliminar_tipoCuenta($ID_TIPOCUENTA);
            echo json_encode("Tipo de cuenta eliminado");
            break;
}
?>
