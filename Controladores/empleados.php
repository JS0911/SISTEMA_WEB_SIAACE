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

require_once("../Config/conexion.php");
require_once("../Modelos/empleados.php");


$com = new Empleados();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetEmpleados":
        $datos = $com->get_empleados();
        echo json_encode($datos);
        break;

    case "InsertEmpleado":
        $datos = $com->insert_empleado($body["DNI"], $body["PRIMER_NOMBRE"], $body["SEGUNDO_NOMBRE"], $body["PRIMER_APELLIDO"], $body["SEGUNDO_APELLIDO"], $body["EMAIL"],$body["SALARIO"], $body["ESTADO"], $body["TELEFONO"], $body["DIRECCION1"], $body["DIRECCION2"], $body["ID_SUCURSAL"], $body["ID_CARGO"]);
        echo json_encode("Empleado Insertado");
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
        $TELEFONO = $body["TELEFONO"];
        $DIRECCION1 = $body["DIRECCION1"];
        $DIRECCION2 = $body["DIRECCION2"];
        $ID_SUCURSAL = $body["ID_SUCURSAL"];
        $ID_CARGO = $body["ID_CARGO"];
        $ESTADO = $body["ESTADO"];

        $datos = $com->update_empleado($ID_EMPLEADO, $DNI, $PRIMER_NOMBRE, $SEGUNDO_NOMBRE, $PRIMER_APELLIDO, $SEGUNDO_APELLIDO, $EMAIL, $SALARIO, $ESTADO, $TELEFONO, $DIRECCION1, $DIRECCION2, $ID_SUCURSAL, $ID_CARGO, $ESTADO);
        echo json_encode($datos);
        break;
        
    case "eliminarEmpleado":
        $ID_EMPLEADO = $body["ID_EMPLEADO"];
        $datos = $com->eliminar_empleado($ID_EMPLEADO);
        echo json_encode($datos);
        break;
}
?>
