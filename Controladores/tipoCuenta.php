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
require_once("../modelos/tipoCuenta.php"); 
require_once("../Modelos/bitacora.php");

$com = new Cuentas(); 
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetTiposCuentas":
        $datos = $com-> get_tipoCuentas();
        echo json_encode($datos);
        break;

    case "InsertTipoCuenta":
        $TIPO_CUENTA = $body["TIPO_CUENTA"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $TASA = $body["TASA"];
        $ESTADO = $body["ESTADO"];


        if (verificarExistenciaTipoCuenta($TIPO_CUENTA) > 0) {
            // Envía una respuesta de conflicto (409) si el Tipo de cuenta ya existe
            http_response_code(409);
            echo json_encode(["error" => "El Tipo de cuenta ya existe en la base de datos."]);
        } else {
            // Inserta el tipo de cuenta en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_tipoCuenta($TIPO_CUENTA, $DESCRIPCION,$TASA,$ESTADO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Rol insertado exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL TIPO DE CUENTA: $TIPO_CUENTA", $_SESSION['id_usuario'], 28, $_SESSION['usuario'], $dateNew);
       
        }



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

            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
    
            $datos = $com->update_tipoCuenta(
                $ID_TIPOCUENTA,
                $TIPO_CUENTA,
                $DESCRIPCION,
                $TASA,
                $ESTADO ,
                $_SESSION['usuario'],
                $dateNew
              
        
            );
            echo json_encode($datos);
            $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL TIPO DE CUENTA # $ID_TIPOCUENTA", $_SESSION['id_usuario'], 28, $_SESSION['usuario'], $dateNew);

            break;

        case "EliminarTipoCuenta":
            $ID_TIPOCUENTA = $body["ID_TIPOCUENTA"];
            $datos = $com->eliminar_tipoCuenta($ID_TIPOCUENTA);
            echo json_encode("Tipo de cuenta eliminado");
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s"); 
            $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL TIPO DE CUENTA # $ID_TIPOCUENTA", $_SESSION['id_usuario'], 28);
        
            break;
}


function verificarExistenciaTipoCuenta($tipo_cuenta) {
    // Realiza una consulta en la base de datos para verificar si el TIPO_CUENTA ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_mc_tipocuenta WHERE TIPO_CUENTA = :tipo_cuenta";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tipo_cuenta', $tipo_cuenta);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
