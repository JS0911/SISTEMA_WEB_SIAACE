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
require_once("../modelos/forma_pago.php");
require_once("../Modelos/bitacora.php"); 

$com = new Fpago(); 
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetFpagos":
        $datos = $com->get_fpagos();
        echo json_encode($datos);
    break;

    case "InsertFpago":
        // Obtén los datos de la FPAGOS
        $FORMA_DE_PAGO = $body["FORMA_DE_PAGO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO =  $body["ESTADO"];
        if (verificarExistenciaFpago($FORMA_DE_PAGO) > 0) {
            // Envía una respuesta de conflicto (409) si la Forma de pago ya existe
            http_response_code(409);
            echo json_encode(["error" => "La Forma de Pago ya existe en la base de datos."]);
        } else {
            // Inserta una Forma de pago en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s"); 
            $datos = $com->insert_fpago($FORMA_DE_PAGO, $DESCRIPCION, $_SESSION['usuario'], $dateNew, $ESTADO);
            echo json_encode(["message" => "Forma de pago insertada exitosamente."]);
            $bit->insert_bitacora($dateNew, $_SESSION['id_usuario'], 12, "INSERTAR");
        }

    break;

    case "GetFpago":
        $datos = $com->get_fpago($body["ID_FPAGO"]);
        echo json_encode($datos);
    break;

    case "UpdateFpago":
        $ID_FPAGO = $body["ID_FPAGO"];
        $FORMA_DE_PAGO = $body["FORMA_DE_PAGO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO =  $body["ESTADO"];

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        
        $valoresAntiguos = $com->get_fpago($ID_FPAGO);
        $descripcionAntes = $valoresAntiguos['DESCRIPCION'];
        $estadoAntes = $valoresAntiguos['ESTADO'];


        $datos = $com->update_fpago(
            $ID_FPAGO,
            $FORMA_DE_PAGO,
            $DESCRIPCION,
            $_SESSION['usuario'],
            $dateNew,
            $ESTADO
        );
        echo json_encode($datos);
        

        //********************************************************Decisiones*******************/
    
        if(strcmp($descripcionAntes, $DESCRIPCION) != 0)
        {
            $bit->insert_bitacoraModificacion($dateNew, $descripcionAntes, $DESCRIPCION, $_SESSION['id_usuario'], 12, "DESCRIPCIÓN", $ID_FPAGO, "MODIFICAR");
        }

        if(strcmp($estadoAntes, $ESTADO) != 0)
        {
            $bit->insert_bitacoraModificacion($dateNew, $estadoAntes, $ESTADO, $_SESSION['id_usuario'], 12, "ESTADO", $ID_FPAGO, "MODIFICAR");
        }
        break;

    case "EliminarFpago":
        $ID_FPAGO = $body["ID_FPAGO"];  
        $datos = $com->eliminar_fpago($ID_FPAGO);
        echo json_encode("Forma de Pago eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, $_SESSION['id_usuario'], 12, $ID_FPAGO, "ELIMINAR");
    break;
}
function verificarExistenciaFpago($FORMA_DE_PAGO) {
    // Realiza una consulta en la base de datos para verificar si el Forma de pago ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_formapago WHERE FORMA_DE_PAGO = :FORMA_DE_PAGO";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':FORMA_DE_PAGO', $FORMA_DE_PAGO);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
