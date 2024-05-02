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
require_once("../Modelos/Reportes.php");

$body = json_decode(file_get_contents("php://input"), true);

$com = new Reporte();

switch ($_GET["op"]) {
    case "ReporteAnulaciones":
        $datos = $com->ReporteAnulaciones($body["fechaInicio"], $body["fechaFin"]);
        echo json_encode($datos);
    break;

    case "ReporteDepositos":
        $datos = $com->ReporteDepositos($body["fechaInicio"], $body["fechaFin"]);
        echo json_encode($datos);
    break;
    case "ReporteRetiros":
        $datos = $com->ReporteRetiros($body["fechaInicio"], $body["fechaFin"]);
        echo json_encode($datos);
    break;
}
