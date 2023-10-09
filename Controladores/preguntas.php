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
require_once("../modelos/Preguntas.php");


$com = new preguntas();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetPreguntas":
        $datos = $com->get_preguntas($body["ID_USUARIO"]);
        echo json_encode($datos);
        break; 
           
    case "InsertRespuesta":
        $datos = $com->insert_respuesta($body["ID_PREGUNTA"],$body["ID_USUARIO"],$body["RESPUESTAS"]);
        echo json_encode($datos);
        break;  

    case "ContarPregunta":
        $datos = $com->ContarPreguntas($body["ID_USUARIO"]);
        echo json_encode($datos);
        break; 
}
