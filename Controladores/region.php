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
require_once("../modelos/region.php"); 
require_once("../Modelos/bitacora.php"); 

$com = new Region(); 
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetRegiones":
        $datos = $com->get_regiones();
        echo json_encode($datos);
    break;

    case "InsertRegion":
        // Obtén los datos de la region
        $REGION = $body["REGION"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO =  $body["ESTADO"];
        if (verificarExistenciaRegion($REGION) > 0) {
            // Envía una respuesta de conflicto (409) si la region ya existe
            http_response_code(409);
            echo json_encode(["error" => "La Region ya existe en la base de datos."]);
        } else {
            // Inserta una region en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-8 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s"); 
            $datos = $com->insert_region($REGION, $DESCRIPCION, $_SESSION['usuario'], $dateNew, $ESTADO);
            echo json_encode(["message" => "Region insertada exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO LA REGION: $REGION", $_SESSION['id_usuario'], 8, $_SESSION['usuario'], $dateNew);
        }

    break;

    case "GetRegion":
        $datos = $com->get_region($body["ID_REGION"]);
        echo json_encode($datos);
    break;

    case "UpdateRegion":
        $ID_REGION = $body["ID_REGION"];
        $REGION = $body["REGION"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO =  $body["ESTADO"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        $datos = $com->update_region(
            $ID_REGION,
            $REGION,
            $DESCRIPCION,
            $_SESSION['usuario'],
            $dateNew,
            $ESTADO
        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO LA REGION # $ID_REGION", $_SESSION['id_usuario'], 8, $_SESSION['usuario'], $dateNew);

    break;

    case "EliminarRegion":
        $ID_REGION = $body["ID_REGION"];
        $datos = $com->eliminar_region($ID_REGION);
        echo json_encode("Region eliminada");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO LA REGION # $ID_REGION", $_SESSION['id_usuario'], 8);
    break;
}
function verificarExistenciaRegion($region) {
    // Realiza una consulta en la base de datos para verificar si el REGION ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_me_region WHERE REGION = :region";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':region', $region);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
