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
require_once("../Modelos/parametros.php");
require_once("../Modelos/bitacora.php");


$com = new Parametro();
$bit = new bitacora();

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
        

        if (verificarExistenciaParametro($PARAMETRO) > 0 ) {
            // Envía una respuesta de conflicto (409) si la region ya existe
            http_response_code(409);
            echo json_encode(["error" => "El parametro ya existe en la base de datos."]);
        } else {
            // Inserta una parametro en la base de datos
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-8 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_parametros($PARAMETRO, $VALOR,$_SESSION['usuario'], $dateNew);
            echo json_encode(["message" => "Parametro insertado exitosamente."]);
            $bit->insert_bitacora($dateNew, $_SESSION['id_usuario'], 4, "INSERTAR");

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
        if (verificarExistenciaParametro($PARAMETRO) > 0 && !esMismoParametro($ID_PARAMETRO, $PARAMETRO)) {
            // Envía una respuesta de conflicto (409) si la region ya existe
            http_response_code(409);
            echo json_encode(["error" => "El parametro ya existe en la base de datos."]);
        } else {
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 

        $valoresAntiguos = $com -> get_parametro($ID_PARAMETRO);
        $ParametroAntes = $valoresAntiguos['PARAMETRO'];
        $ValorAntes = $valoresAntiguos['VALOR'];

        $datos = $com->update_parametro($ID_PARAMETRO,
        $PARAMETRO,
        $VALOR,$_SESSION['usuario'],
        $dateNew);

        
        echo json_encode($datos);
       
        //-------------------------------------------------Decisiones-----------------------------------------------
        if(strcmp($ParametroAntes, $PARAMETRO) != 0 ){
            $bit->insert_bitacoraModificacion($dateNew, $ParametroAntes, $PARAMETRO, $_SESSION['id_usuario'], 4, "PARAMETRO", $ID_PARAMETRO, "MODIFICAR");
        }

        if(strcmp($ValorAntes, $VALOR) != 0 ){
            $bit->insert_bitacoraModificacion($dateNew, $ValorAntes, $VALOR, $_SESSION['id_usuario'], 4, "VALOR", $ID_PARAMETRO, "MODIFICAR");
        }
        break;
    }
    case "eliminarParametro":
        $ID_PARAMETRO = $body["ID_PARAMETRO"];
        $datos = $com->eliminar_parametro($ID_PARAMETRO);
        echo json_encode("Parametro eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-8 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, $_SESSION['id_usuario'], 4, $ID_PARAMETRO, "ELIMINAR");
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
        function esMismoParametro($ID_PARAMETRO, $PARAMETRO) {
            // Realiza una consulta en la base de datos para verificar si el parámetro tiene el mismo ID y nombre
            $sql = "SELECT COUNT(*) AS count FROM tbl_ms_parametros WHERE ID_PARAMETRO = :id_parametro AND PARAMETRO = :parametro";
            
            // Realiza la conexión a la base de datos y ejecuta la consulta
            $conexion = new Conectar();
            $conn = $conexion->Conexion();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_parametro', $ID_PARAMETRO); 
            $stmt->bindParam(':parametro', $PARAMETRO); 
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Devuelve true si el número de resultados encontrados es mayor que 0, lo que significa que el parámetro tiene el mismo ID y nombre
            return $row['count'] > 0;
        }
        

?>
