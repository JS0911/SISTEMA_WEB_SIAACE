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
require_once("../modelos/objetos.php"); 
require_once("../Modelos/bitacora.php"); 

$com = new Objetos(); 
$bit = new bitacora();

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
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_objeto($OBJETO, $DESCRIPCION, $TIPO_OBJETO, $_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Objeto insertado exitosamente."]);
            if($bit->obtenervalorBitacora() == 1)
            {
               $bit->insert_bitacora($dateNew, $_SESSION['id_usuario'], 5, "INSERTAR");
            }
           
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
        if (verificarExistenciaObjeto($OBJETO) > 0 && !esMismoObjeto($ID_OBJETO, $OBJETO)) {
            // Envía una respuesta de conflicto (409) si el objeto ya existe
            http_response_code(409);
            echo json_encode(["error" => "El objeto ya existe en la base de datos."]);
        } else {
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        $valoresAntiguos = $com -> get_objeto ($ID_OBJETO);
        $ObjetoAntes = $valoresAntiguos['OBJETO'];
        $DescripcionAntes = $valoresAntiguos['DESCRIPCION'];
        $TipoObjetoAntes = $valoresAntiguos['TIPO_OBJETO'];

        $datos = $com->update_objeto(
            $ID_OBJETO,
            $OBJETO,
            $DESCRIPCION,
            $TIPO_OBJETO,
            $_SESSION['usuario'],
            $dateNew
        );
        echo json_encode($datos);
        

        //-----------------------------------------------------Decisiones----------------------------------------------------
        if(strcmp($ObjetoAntes, $OBJETO) != 0){
            if($bit->obtenervalorBitacora() == 1)
            {
               $bit-> insert_bitacoraModificacion($dateNew, $ObjetoAntes, $OBJETO, $_SESSION['id_usuario'], 5, "OBJETO", $ID_OBJETO, "MODIFICAR");
            }
        }
 
        if(strcmp($DescripcionAntes, $DESCRIPCION) != 0 ){
            if($bit->obtenervalorBitacora() == 1)
            {
              $bit->insert_bitacoraModificacion($dateNew, $DescripcionAntes, $DESCRIPCION, $_SESSION['id_usuario'], 5, "DESCRIPCIÓN", $ID_OBJETO, "MODIFICAR");  
            }
        }
 
        if(strcmp($TipoObjetoAntes, $TIPO_OBJETO) != 0 ){
            if($bit->obtenervalorBitacora() == 1)
            {
               $bit->insert_bitacoraModificacion($dateNew, $TipoObjetoAntes, $TIPO_OBJETO, $_SESSION['id_usuario'], 5, "TIPO OBJETO", $ID_OBJETO, "MODIFICAR");
            }
        }
    }
    break;

    case "EliminarObjeto":
        $ID_OBJETO = $body["ID_OBJETO"];
        $datos = $com->eliminar_objeto($ID_OBJETO);
        echo json_encode("Objeto eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        if($bit->obtenervalorBitacora() == 1)
        {
           $bit->insert_bitacoraEliminar($dateNew, $_SESSION['id_usuario'], 5 , $ID_OBJETO, "ELIMINAR");
        }
       
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


function esMismoObjeto($ID_OBJETO, $OBJETO) {
    // Realiza una consulta en la base de datos para verificar si el objeto tiene el mismo ID y nombre
    $sql = "SELECT COUNT(*) AS count FROM tbl_ms_objetos WHERE id_objeto = :id_objeto AND objeto = :objeto";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_objeto', $ID_OBJETO);
    $stmt->bindParam(':objeto', $OBJETO);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el número de resultados encontrados es mayor que 0, significa que el objeto tiene el mismo ID y nombre
    return $row['count'] > 0;
}


?>

