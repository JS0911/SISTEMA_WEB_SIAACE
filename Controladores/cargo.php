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
require_once("../modelos/cargo.php"); 
require_once("../Modelos/bitacora.php");

$com = new Cargos(); 
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetCargos":
        $datos = $com-> get_cargos();
        echo json_encode($datos);
        break;

    case "InsertCargo":

        $CARGO =$body["CARGO"];
       $DESCRIPCION =$body["DESCRIPCION"];
        $ESTADO=$body["ESTADO"];

        if (verificarExistenciaCargo($CARGO) > 0) {
            // Envía una respuesta de conflicto (409) si el cargo ya existe
            http_response_code(409);
            echo json_encode(["error" => "El cargo ya existe en la base de datos."]);
        } else {
            // Inserta el cargo en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-8 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_cargo($CARGO, $DESCRIPCION,$ESTADO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Cargo insertado exitosamente."]);
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL CARGO: $CARGO", $_SESSION['id_usuario'], 26, $_SESSION['usuario'], $dateNew);
       
        }

        break;

    case "GetCargo":
        $datos = $com->get_cargo($body["ID_CARGO"]);
        echo json_encode($datos);
        break;

    case "UpdateCargo":
        $ID_CARGO = $body["ID_CARGO"];
        $CARGO = $body["CARGO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $ESTADO = $body["ESTADO"];

         
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 


        $datos = $com->update_cargo(
            $ID_CARGO,
            $CARGO,
            $DESCRIPCION,
            $ESTADO,
            $_SESSION['usuario'],
            $dateNew
        );
        echo json_encode($datos);
        $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL CARGO # $ID_CARGO", $_SESSION['id_usuario'], 26, $_SESSION['usuario'], $dateNew);

        break;

        case "EliminarCargo":
            $ID_CARGO = $body["ID_CARGO"];
            $datos = $com->eliminar_cargo($ID_CARGO);
            echo json_encode("Cargo eliminado");
            $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL CARGO # $ID_CARGO", $_SESSION['id_usuario'], 26);
    
            break;
}

function verificarExistenciaCargo($cargo) {
    // Realiza una consulta en la base de datos para verificar si el ROL ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_me_cargo WHERE CARGO = :cargo";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
?>
