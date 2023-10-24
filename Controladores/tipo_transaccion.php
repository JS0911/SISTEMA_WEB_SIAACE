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
require_once("../modelos/tipo_transaccion.php");

$com = new tipoTransaccion;

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

        if (verificarExistenciaTransaccion($TIPO_TRANSACCION) > 0) {
            // Envía una respuesta de conflicto (409) si la transacción ya existe
            http_response_code(409);
            echo json_encode(["error" => "La transacción ya existe en la base de datos."]);
        } else {
            // Inserta una transacción en la base de datos
            $datos = $com->insert_tipoTransaccion($TIPO_TRANSACCION, $DESCRIPCION, $SIGNO_TRANSACCION);
            echo json_encode(["message" => "Transacción insertada exitosamente."]);
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

        $datos = $com->update_tipoTransaccion(
            $ID_TIPO_TRANSACCION,
            $TIPO_TRANSACCION,
            $DESCRIPCION,
            $SIGNO_TRANSACCION
        );
        echo json_encode($datos);
    break;

    case "EliminarTipoTransaccion":
        $ID_TIPO_TRANSACCION = $body["ID_TIPO_TRANSACCION"];
        $datos = $com->eliminar_tipoTransaccion($ID_TIPO_TRANSACCION);
        echo json_encode("Transacción eliminada");
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
