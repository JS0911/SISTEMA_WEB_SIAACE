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
require_once("../modelos/objetos.php"); 

$com = new Objetos(); 

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetObjetos":
        $datos = $com->get_objetos();
        echo json_encode($datos);
    break;

    case "InsertObjeto":
        // Obtén los datos del objeto
        $OBJETO = $body["OBJETO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $TIPO_OBJETO = $body["TIPO_OBJETO"];
        
        if (verificarExistenciaObjeto($OBJETO) > 0) {
            // Envía una respuesta de conflicto (409) si el objeto ya existe
            http_response_code(409);
            echo json_encode(["error" => "El objeto ya existe en la base de datos."]);
        } else {
            // Inserta el objeto en la base de datos
            $datos = $com->insert_objeto($OBJETO, $DESCRIPCION, $TIPO_OBJETO);
            echo json_encode(["message" => "Objeto insertado exitosamente."]);
        }

    break;

    case "GetObjeto":
        $datos = $com->get_objeto($body["ID_OBJETO"]);
        echo json_encode($datos);
    break;

    case "UpdateObjeto":
        $ID_OBJETO = $body["ID_OBJETO"];
        $OBJETO = $body["OBJETO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $TIPO_OBJETO = $body["TIPO_OBJETO"];

        $datos = $com->update_objeto(
            $ID_OBJETO,
            $OBJETO,
            $DESCRIPCION,
            $TIPO_OBJETO
        );
        echo json_encode($datos);
    break;

    case "EliminarObjeto":
        $ID_OBJETO = $body["ID_OBJETO"];
        $datos = $com->eliminar_objeto($ID_OBJETO);
        echo json_encode("Objeto eliminado");
    break;
}
function verificarExistenciaObjeto($objeto) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_objetos WHERE OBJETO = :objeto";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':objeto', $objeto);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

?>

