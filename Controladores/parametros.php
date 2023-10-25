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
require_once("../Modelos/parametros.php");


$com = new Parametro();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetParametros":
        $datos = $com->get_parametros();
        echo json_encode($datos);
        break;

    case "InsertParametros":
        // Obtén los datos de la region
        $PARAMETRO = $body["PARAMETRO"];
        $VALOR = $body["VALOR"];

        if (verificarExistenciaParametro($PARAMETRO) > 0) {
            // Envía una respuesta de conflicto (409) si la region ya existe
            http_response_code(409);
            echo json_encode(["error" => "El parametro ya existe en la base de datos."]);
        } else {
            // Inserta una region en la base de datos
            $datos = $com->insert_parametros($PARAMETRO, $VALOR);
            echo json_encode(["message" => "Parametro insertado exitosamente."]);
        }
       break;

    case "GetParametro":
        $datos = $com->get_parametro($body["ID_PARAMETRO"]);
        echo json_encode($datos);
        break;

    case "updateParametro":
        $ID_PARAMETRO = $body["ID_PARAMETRO"];
        $PARAMETRO = $body["PARAMETRO"];
        $VALOR = $body["VALOR"];
/*         $ID_USUARIO = $body["ID_USUARIO"];
        $CREADO_POR = $body["CREADO_POR"];
        $MODIFICADO_POR = $body["MODIFICADO_POR"]; */
/*         $FECHA_CREACION = $body["FECHA_CREACION"];
        $FECHA_MODIFICACION = $body["FECHA_MODIFICACION"]; */


        $datos = $com->update_parametro($ID_PARAMETRO, $PARAMETRO, $VALOR/* , $ID_USUARIO, $CREADO_POR, $MODIFICADO_POR *//* , $FECHA_CREACION, $FECHA_MODIFICACION */);
        echo json_encode($datos);
        break;
    case "eliminarParametro":
        $ID_PARAMETRO = $body["ID_PARAMETRO"];
        $datos = $com->eliminar_parametro($ID_PARAMETRO);
        echo json_encode("Parametro eliminado");
        break;

    }  
        function verificarExistenciaParametro($PARAMETRO) {
            // Realiza una consulta en la base de datos para verificar si el PARAMETRO ya existe
            $sql = "SELECT COUNT(*) as count FROM tbl_ms_parametros WHERE parametro = :parametro";
        
            // Realiza la conexión a la base de datos y ejecuta la consulta
            $conexion = new Conectar();
            $conn = $conexion->Conexion();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':parametro', $PARAMETRO);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Devuelve el número de resultados encontrados
            return $row['count'];
        }
?>
