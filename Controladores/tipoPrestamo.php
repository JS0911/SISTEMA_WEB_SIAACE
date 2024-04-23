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
require_once("../Modelos/tipoPrestamo.php");


$com = new TipoPrestamo();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetTipoprestamos":
        $datos = $com->get_tipoprestamos();
        echo json_encode($datos);
        break;

    case "InsertTipoprestamo":

         // Obtén los datos del tipo prestamo
        

         $TIPO_PRESTAMO = $body["TIPO_PRESTAMO"];
         $DESCRIPCION = $body["DESCRIPCION"];
         $APLICA_SEGUROS = $body["APLICA_SEGUROS"];
         $MONTO_MAXIMO = $body["MONTO_MAXIMO"];
         $MONTO_MINIMO = $body["MONTO_MINIMO"];
         $TASA_MAXIMA = $body["TASA_MAXIMA"];
         $TASA_MINIMA = $body["TASA_MINIMA"];
         $PLAZO_MAXIMO = $body["PLAZO_MAXIMO"];
         $PLAZO_MINIMO = $body["PLAZO_MINIMO"];
         $ESTADO = $body["ESTADO"];
       
         if (verificarExistenciaTipoprestamo($TIPO_PRESTAMO) > 0 && !esMismoPrestamo($ID_TIPO_PRESTAMO, $TIPO_PRESTAMO))  {
             // Envía una respuesta de conflicto (409) si el tipo prestamo ya existe
             http_response_code(409);
             echo json_encode(["error" => "El Tipo Prestamo ya existe en la base de datos."]);
         } else {
             // Inserta una tipo prestamo en la base de datos
             $datos = $com->insert_tipoprestamo($TIPO_PRESTAMO, $DESCRIPCION, $APLICA_SEGUROS, $MONTO_MAXIMO, $MONTO_MINIMO, $TASA_MAXIMA, $TASA_MINIMA, $PLAZO_MAXIMO,$PLAZO_MINIMO, $ESTADO );
             echo json_encode(["message" => "Tipo Prestamo insertado exitosamente."]);
         }
        break;
   
    case "GetTipoprestamo":
        $datos = $com->get_tipoprestamo($body["ID_TIPO_PRESTAMO"]);
        echo json_encode($datos);
        break;

    case "updateTipoprestamo":
        $ID_TIPO_PRESTAMO = $body["ID_TIPO_PRESTAMO"];
        $TIPO_PRESTAMO = $body["TIPO_PRESTAMO"];
        $DESCRIPCION = $body["DESCRIPCION"];
        $APLICA_SEGUROS = $body["APLICA_SEGUROS"];
        $MONTO_MAXIMO = $body["MONTO_MAXIMO"];
        $MONTO_MINIMO = $body["MONTO_MINIMO"];
        $TASA_MAXIMA = $body["TASA_MAXIMA"];
        $TASA_MINIMA = $body["TASA_MINIMA"];
        $PLAZO_MAXIMO = $body["PLAZO_MAXIMO"];
        $PLAZO_MINIMO = $body["PLAZO_MINIMO"];
        $ESTADO = $body["ESTADO"];
        if (verificarExistenciaTipoprestamo($TIPO_PRESTAMO) > 0) {
            // Envía una respuesta de conflicto (409) si el tipo prestamo ya existe
            http_response_code(409);
            echo json_encode(["error" => "El Tipo Prestamo ya existe en la base de datos."]);
        } else {
        $datos = $com->update_tipoprestamo(
            $ID_TIPO_PRESTAMO,
            $TIPO_PRESTAMO, 
            $DESCRIPCION, 
            $APLICA_SEGUROS,
            $MONTO_MAXIMO, 
            $MONTO_MINIMO,
            $TASA_MAXIMA,
            $TASA_MINIMA,
            $PLAZO_MAXIMO,
            $PLAZO_MINIMO,
            $ESTADO );
        echo json_encode($datos);
        }
        break;

        
    case "eliminarTipoprestamo":
        $ID_TIPO_PRESTAMO = $body["ID_TIPO_PRESTAMO"];
        $datos = $com->eliminar_tipoprestamo($ID_TIPO_PRESTAMO);
        echo json_encode("Tipo Prestamo eliminada");
        break;
}

function verificarExistenciaTipoprestamo($TIPO_PRESTAMO) {
    // Realiza una consulta en la base de datos para verificar si el Tipo Prestamo ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_mp_tipo_prestamo WHERE TIPO_PRESTAMO = :TIPO_PRESTAMO";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':TIPO_PRESTAMO', $TIPO_PRESTAMO);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

function esMismoPrestamo($ID_TIPO_PRESTAMO, $TIPO_PRESTAMO) {
    // Realiza una consulta en la base de datos para verificar si el tipo de préstamo tiene el mismo ID y nombre
    $sql = "SELECT COUNT(*) AS count FROM tbl_mp_tipo_prestamo WHERE id_tipo_prestamo = :id_tipo_prestamo AND tipo_prestamo = :tipo_prestamo";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_tipo_prestamo', $ID_TIPO_PRESTAMO); // Corregido el nombre de la variable
    $stmt->bindParam(':tipo_prestamo', $TIPO_PRESTAMO); // Corregido el nombre de la variable
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el número de resultados encontrados es mayor que 0, significa que el tipo de préstamo tiene el mismo ID y nombre
    return $row['count'] > 0;
}


?>
