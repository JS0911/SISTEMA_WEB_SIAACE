
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
require_once("../Modelos/sucursal.php");
require_once("../Modelos/bitacora.php");


$com = new Sucursal();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetSucursales":
        $datos = $com->get_sucursales();
        echo json_encode($datos);
        break;

    case "InsertSucursal":
         // Obtén los datos de la region
         $SUCURSAL = $body["SUCURSAL"];
         $DESCRIPCION = $body["DESCRIPCION"];
         $DIRECCION = $body["DIRECCION"];
         $ID_REGION = $body["ID_REGION"];
         $TELEFONO = $body["TELEFONO"];
         $ESTADO = $body["ESTADO"];
        
         if (verificarExistenciaSucursal($SUCURSAL) > 0 ) {
             // Envía una respuesta de conflicto (409) si la region ya existe
             http_response_code(409);
             echo json_encode(["error" => "La Sucursal ya existe en la base de datos."]);
         } else {
             // Inserta una region en la base de datos
             $date = new DateTime(date("Y-m-d H:i:s"));
             $dateMod = $date->modify("-8 hours");
             $dateNew = $dateMod->format("Y-m-d H:i:s");

             $datos = $com->insert_sucursal($SUCURSAL, $DESCRIPCION, $DIRECCION, $ID_REGION, $TELEFONO,$ESTADO);
             echo json_encode(["message" => "Sucursal insertada exitosamente."]);
             $bit->insert_bitacora($dateNew, $_SESSION['id_usuario'], 9, "INSERTAR");
         }
        break;

    case "GetSucursal":
        $datos = $com->get_sucursal($body["ID_SUCURSAL"]);
        echo json_encode($datos);
        break;

    case "updateSucursal":
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $SUCURSAL = $body["SUCURSAL"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $DIRECCION = $body["DIRECCION"];
        $ID_REGION = $body["ID_REGION"];
        $TELEFONO = $body["TELEFONO"];
        $ESTADO = $body["ESTADO"];
        if (verificarExistenciaSucursal($SUCURSAL) > 0 &&  !esMismoRegion($ID_SUCURSAL, $SUCURSAL)) {
            // Envía una respuesta de conflicto (409) si la region ya existe
            http_response_code(409);
            echo json_encode(["error" => "La Sucursal ya existe en la base de datos."]);
        } else {
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        $valoresAntiguos = $com -> get_sucursal($ID_SUCURSAL);
        $SucursalAntes = $valoresAntiguos['SUCURSAL'];
        $DescripcionAntes = $valoresAntiguos['DESCRIPCION'];
        $DireccionAntes = $valoresAntiguos['DIRECCION'];
        $RegionAntes = $valoresAntiguos['ID_REGION'];
        $TelefonoAntes = $valoresAntiguos['TELEFONO'];
        $EstadoAntes = $valoresAntiguos['ESTADO'];

        $datos = $com->update_sucursal($ID_SUCURSAL, $SUCURSAL, $DESCRIPCION , $DIRECCION,$ID_REGION,$TELEFONO, $ESTADO, $_SESSION['usuario'],$dateNew);
        echo json_encode($datos);
        
         //-----------------------------------------------------Decisiones-------------------------------------------------
         if(strcmp($SucursalAntes, $SUCURSAL) != 0){
            $bit-> insert_bitacoraModificacion($dateNew, $SucursalAntes, $SUCURSAL, $_SESSION['id_usuario'], 9, "SUCURSAL", $ID_SUCURSAL, "MODIFICAR");
        }

        if(strcmp($DescripcionAntes, $DESCRIPCION) != 0 ){
            $bit->insert_bitacoraModificacion($dateNew, $DescripcionAntes, $DESCRIPCION, $_SESSION['id_usuario'], 9, "DESCRIPCIÓN", $ID_SUCURSAL, "MODIFICAR");
        }

        if(strcmp($DireccionAntesoAntes, $DIRECCION) != 0 ){
            $bit->insert_bitacoraModificacion($dateNew, $DireccionAntes, $DIRECCION, $_SESSION['id_usuario'], 9, "DIRECCIÓN", $ID_SUCURSAL, "MODIFICAR");
        }

        if(strcmp($RegionAntes, $ID_REGION) != 0){
            $bit-> insert_bitacoraModificacion($dateNew, $RegionAntes, $ID_REGION, $_SESSION['id_usuario'], 9, "REGIÓN", $ID_REGION, "MODIFICAR");
        }

        if(strcmp($TelefonoAntes, $TELEFONO) != 0){
            $bit-> insert_bitacoraModificacion($dateNew, $TelefonoAntes, $TELEFONO, $_SESSION['id_usuario'], 9, "TELEFONO", $ID_SUCURSAL, "MODIFICAR");
        }

        if(strcmp($EstadoAntes, $ESTADO) != 0 ){
            $bit->insert_bitacoraModificacion($dateNew, $EstadoAntes, $ESTADO, $_SESSION['id_usuario'], 9, "ESTADO", $ID_SUCURSAL, "MODIFICAR");
        }
        }
        break;
    case "eliminarSucursal":
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $datos = $com->eliminar_sucursal($ID_SUCURSAL);
        echo json_encode("Sucursal eliminada");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, $_SESSION['id_usuario'], 9, $ID_SUCURSAL, "ELIMINAR");
        break;
}


function verificarExistenciaSucursal($SUCURSAL) {
    // Realiza una consulta en la base de datos para verificar si el REGION ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_me_sucursal WHERE sucursal = :sucursal";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sucursal', $SUCURSAL);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}
function esMismoRegion($id_sucursal, $sucursal) {
    // Realiza una consulta en la base de datos para verificar si la sucursal tiene el mismo id_sucursal y nombre de sucursal
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_sucursales WHERE id_sucursal = :id_sucursal AND sucursal = :sucursal";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_sucursal', $id_sucursal);
    $stmt->bindParam(':sucursal', $sucursal);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el número de resultados encontrados es mayor que 0, significa que la sucursal tiene el mismo id_sucursal y nombre de sucursal
    return $row['count'] > 0;
}


?>
