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
require_once("../Modelos/cuenta.php");
require_once("../Modelos/bitacora.php"); 

$com = new cuenta();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetCuentas":
        $datos = $com->get_cuentas();
        echo json_encode($datos);
    break;

    case "GetCuenta_Emple":
        $datos = $com->get_cuentas_emp($body["ID_EMPLEADO"]);
        echo json_encode($datos);
    break;

    case "GetCuenta":
        $datos = $com->get_cuenta($body["ID_CUENTA"]);
        echo json_encode($datos);
    break;

    case "InsertCuenta":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        $ID_TIPOCUENTA = $body["ID_TIPOCUENTA"];
        $SALDO = $body["SALDO"];
        $NUMERO_CUENTA = $body["NUMERO_CUENTA"];
        $ESTADO = $body["ESTADO"];
        if (verificarExistenciaCuenta($NUMERO_CUENTA) > 0) {
            Http_response_code(409);
            echo json_encode(["error" => "La cuenta ya existe en la base de datos."]);
        } else {
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_cuenta($ID_EMPLEADO, $ID_TIPOCUENTA, $SALDO, $NUMERO_CUENTA, $ESTADO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Cuenta insertada Exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO LA CUENTA: $NUMERO_CUENTA", $_SESSION['id_usuario'], 28, $_SESSION['usuario'], $dateNew);
        }
       
    break;

    case "EditCuenta":
        $datos = $com->update_cuenta($body["ID_CUENTA"],$body["ESTADO"]);
        echo json_encode($datos);
    break;

    case "HistorialCuenta":
        $datos = $com->historial_cuenta($body["ID_CUENTA"]);
        echo json_encode($datos);
    break;

    case "DepositoCuenta":
        $datos = $com->deposito_cuenta($body["ID_CUENTA"],$body["DEPOSITO"],$_SESSION['usuario']);
        echo json_encode($datos);
    break;

    case "ReembolsoCuenta":
        $datos = $com->reembolso_cuenta($body["ID_CUENTA"],$body["REEMBOLSO"],$_SESSION['usuario']);
        echo json_encode($datos);
    break;

    case "Anulacion_Dep_Ret":
        $datos = $com->anular($body["ID_CUENTA"],$body["ID_TRANSACCION"],$_SESSION['usuario']);
        echo json_encode($datos);
    break;

    case "insert_cuentaAutomatica":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        if (verificarExistenciaCuenta($NUMERO_CUENTA) > 0) {
            Http_response_code(409);
            echo json_encode(["error" => "La cuenta ya existe en la base de datos."]);
        } else {
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_cuentaAutomatica($ID_EMPLEADO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Cuenta insertada Exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO LA CUENTA: $NUMERO_CUENTA", $_SESSION['id_usuario'], 28, $_SESSION['usuario'], $dateNew);
        }
}


function verificarExistenciaCuenta($cuenta) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_mc_cuenta WHERE NUMERO_CUENTA = :cuenta";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cuenta', $cuenta);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
