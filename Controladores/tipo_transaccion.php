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
require_once("../modelos/tipo_transaccion.php");
require_once("../Modelos/bitacora.php"); 

$com = new tipoTransaccion;
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetTipoTransacciones":
        $datos = $com->get_tipoTransacciones();
        echo json_encode($datos);
    break;

    case "InsertTipoTransaccion":
        // Obtén los datos de la transacción
        $TIPO_TRANSACCION = $body["TIPO_TRANSACCION"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $SIGNO_TRANSACCION = $body["SIGNO_TRANSACCION"];
        $ESTADO =  $body["ESTADO"];
        if (verificarExistenciaTransaccion($TIPO_TRANSACCION) > 0) {
            // Envía una respuesta de conflicto (409) si la transacción ya existe
            http_response_code(409);
            echo json_encode(["error" => "La transacción ya existe en la base de datos."]);
        } else {
            // Inserta una transacción en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_tipoTransaccion($TIPO_TRANSACCION, $DESCRIPCION, $SIGNO_TRANSACCION, $_SESSION['usuario'], $dateNew, $ESTADO);
            echo json_encode(["message" => "Transacción insertada exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL TIPO TRANSACCION: $TIPO_TRANSACCION", $_SESSION['id_usuario'], 11, $_SESSION['usuario'], $dateNew);
        }

    break;

    case "GetTipoTransaccion":
        $datos = $com->get_tipoTransaccion($body["ID_TIPO_TRANSACCION"]);
        echo json_encode($datos);
    break;

    case "UpdateTipoTransaccion":
        $ID_TIPO_TRANSACCION = $body["ID_TIPO_TRANSACCION"];
        $TIPO_TRANSACCION = $body["TIPO_TRANSACCION"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $SIGNO_TRANSACCION = $body["SIGNO_TRANSACCION"];
        $ESTADO =  $body["ESTADO"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");

        $datos = $com->update_tipoTransaccion(
            $ID_TIPO_TRANSACCION,
            $TIPO_TRANSACCION,
            $DESCRIPCION,
            $SIGNO_TRANSACCION,
            $_SESSION['usuario'],
            $dateNew,
            $ESTADO
        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL TIPO DE TRANSACCION # $ID_TIPO_TRANSACCION", $_SESSION['id_usuario'], 11, $_SESSION['usuario'], $dateNew);

    break;

    case "EliminarTipoTransaccion":
        $ID_TIPO_TRANSACCION = $body["ID_TIPO_TRANSACCION"];
        $datos = $com->eliminar_tipoTransaccion($ID_TIPO_TRANSACCION);
        echo json_encode("Transacción eliminada");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL TIPO DE TRANSACCION # $ID_TIPO_TRANSACCION", $_SESSION['id_usuario'], 11);

    break;
}

function verificarExistenciaTransaccion($TIPO_TRANSACCION)
{
    // Realiza una consulta en la base de datos para verificar si la transacción ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_tipo_transaccion WHERE TIPO_TRANSACCION = :TIPO_TRANSACCION";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':TIPO_TRANSACCION', $TIPO_TRANSACCION);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
