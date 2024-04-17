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

require_once("../Config/conexion.php");
require_once("../Modelos/empleados.php");
require_once("../Modelos/bitacora.php");

$com = new Empleados();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);

switch ($_GET["op"]) {
    case "GetEmpleados":
        $datos = $com->get_empleados();
        echo json_encode($datos);
    break;

    case "InsertEmpleado":
        // Capturar los datos del cuerpo de la solicitud
        $DNI = $body["DNI"];
        $PRIMER_NOMBRE = $body["PRIMER_NOMBRE"];
        $SEGUNDO_NOMBRE = $body["SEGUNDO_NOMBRE"];
        $PRIMER_APELLIDO = $body["PRIMER_APELLIDO"];
        $SEGUNDO_APELLIDO = $body["SEGUNDO_APELLIDO"];
        $EMAIL = $body["EMAIL"];
        $SALARIO = $body["SALARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $TELEFONO = $body["TELEFONO"];
        $DIRECCION1 = $body["DIRECCION1"];
        $DIRECCION2 = $body["DIRECCION2"];
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $ID_CARGO = $body["ID_CARGO"];
    
        // Verificar si el empleado ya existe
        if (verificarExistenciaEmpleado($DNI) > 0){
            http_response_code(409);
            echo json_encode(["error" => "El DNI ya existe en la base de datos."]);
        } else {
            // Insertar el empleado
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $datos = $com->insert_empleado($DNI, $PRIMER_NOMBRE, $SEGUNDO_NOMBRE, $PRIMER_APELLIDO, $SEGUNDO_APELLIDO, $EMAIL, $SALARIO, $ID_ESTADO_USUARIO, $TELEFONO, $DIRECCION1, $DIRECCION2, $ID_SUCURSAL, $ID_CARGO, $_SESSION['usuario'], $dateNew);
    
            // Manejar la respuesta de la inserción del empleado
            if (is_array($datos) && isset($datos['ID_EMPLEADO'])) {
                // Si la inserción fue exitosa, mostrar el ID del empleado insertado
                echo json_encode(["message" => "Empleado insertado exitosamente.", "ID_EMPLEADO" => $datos['ID_EMPLEADO']]);
            } else {
                // Si hubo un error en la inserción, mostrar el mensaje de error
                http_response_code(500);
                echo json_encode(["error" => "Error al insertar el empleado."]);
            }
    
            // Insertar en la bitácora
            $bit->insert_bitacora($dateNew, "INSERTAR", "SE INSERTO EL EMPLEADO: $PRIMER_NOMBRE $SEGUNDO_NOMBRE $PRIMER_APELLIDO $SEGUNDO_APELLIDO", $_SESSION['id_usuario'], 7, $_SESSION['usuario'], $dateNew);
        }
    
    

        break;

    case "GetEmpleado":
        $datos = $com->get_empleado($body["ID_EMPLEADO"]);
        echo json_encode($datos);
    break;

    case "updateEmpleado":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        $DNI = $body["DNI"];
        $PRIMER_NOMBRE = $body["PRIMER_NOMBRE"];
        $SEGUNDO_NOMBRE = $body["SEGUNDO_NOMBRE"];
        $PRIMER_APELLIDO = $body["PRIMER_APELLIDO"];
        $SEGUNDO_APELLIDO = $body["SEGUNDO_APELLIDO"];
        $EMAIL = $body["EMAIL"];
        $SALARIO = $body["SALARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $TELEFONO = $body["TELEFONO"];
        $DIRECCION1 = $body["DIRECCION1"];
        $DIRECCION2 = $body["DIRECCION2"];
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $ID_CARGO = $body["ID_CARGO"];


        if (verificarExistenciaEmpleado($DNI) > 0 && !esMismoEmpleado($ID_EMPLEADO, $DNI)){
            http_response_code(409);
            echo json_encode(["error" => "El DNI ya existe en la base de datos."]);
        } else {
            $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");
        $datos = $com->update_empleado($ID_EMPLEADO, 
        $DNI, 
        $PRIMER_NOMBRE, 
        $SEGUNDO_NOMBRE, 
        $PRIMER_APELLIDO, 
        $SEGUNDO_APELLIDO, 
        $EMAIL, 
        $SALARIO, 
        $ID_ESTADO_USUARIO, 
        $TELEFONO, 
        $DIRECCION1, 
        $DIRECCION2, 
        $ID_SUCURSAL, 
        $ID_CARGO,
        $_SESSION['usuario'],
        $dateNew
    );
    echo json_encode(["message" => "Empleado insertado Exitosamente."]);
    $bit->insert_bitacoraModificacion($dateNew, "MODIFICAR", "SE MODIFICO EL EMPLEADO: $PRIMER_NOMBRE $SEGUNDO_NOMBRE $PRIMER_APELLIDO $SEGUNDO_APELLIDO", $_SESSION['id_usuario'], 7, $_SESSION['usuario'], $dateNew);
}




       
       
        break;
        
    case "eliminarEmpleado":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        $datos = $com->eliminar_empleado($ID_EMPLEADO);
        echo json_encode("Empleado eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, "ELIMINAR", "SE ELIMINO EL EMPLEADO: $PRIMER_NOMBRE $SEGUNDO_NOMBRE $PRIMER_APELLIDO $SEGUNDO_APELLIDO", $_SESSION['id_usuario'], 7);
    break;
}

function verificarExistenciaEmpleado($DNI) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_me_empleados WHERE DNI = :dni";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':dni', $DNI);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}   

function esMismoEmpleado($id_empleado, $dni) {
    // Realiza una consulta en la base de datos para verificar si el DNI pertenece al mismo empleado
    $sql = "SELECT COUNT(*) as count FROM tbl_me_empleados WHERE ID_EMPLEADO = :id_empleado AND DNI = :dni";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_empleado', $id_empleado);
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el número de resultados encontrados es mayor que 0, significa que el DNI pertenece al mismo empleado
    return $row['count'] > 0;
}


?>
