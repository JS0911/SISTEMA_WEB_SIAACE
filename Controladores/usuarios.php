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
require_once("../modelos/Usuarios.php");
require_once("../Modelos/bitacora.php"); 

$com = new Usuario();
$bit = new bitacora();

$body = json_decode(file_get_contents("php://input"), true);


switch ($_GET["op"]) {
    case "GetUsuarios":
        $datos = $com->get_usuarios();
        echo json_encode($datos);
    break;

    case "InsertUsuarios":
        $USUARIO = $body["USUARIO"];
        $NOMBRE_USUARIO = $body["NOMBRE_USUARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $CORREO_ELECTRONICO = $body["CORREO_ELECTRONICO"];
        $ID_ROL = $body["ID_ROL"];
        $CONTRASENA = $body["CONTRASENA"];
       // $AUTO_REGISTRO = $body["AUTO_REGISTRO"];
    
        if (verificarExistenciaUsuario($USUARIO) > 0) {
            http_response_code(409);
            echo json_encode(["error" => "El usuario ya existe en la base de datos."]);
        } elseif (verificarExistenciaEmail($CORREO_ELECTRONICO) > 0) {      
            http_response_code(409);
            echo json_encode(["error" => "El correo ya existe en la base de datos."]);
        } else {
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
           // $AUTO_REGISTRO=1;
           $datos = $com->insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL, $_SESSION['usuario'], $dateNew);
           $bit->insert_bitacora($dateNew, $_SESSION['id_usuario'], 2,"INSERTAR");
            if ($datos === "Usuario Insertado") {
                echo json_encode(["message" => "Usuario insertado exitosamente."]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => $datos]);
            }
        }
        break;    

    case "GetUsuario":
        $datos = $com->get_usuario($body["ID_USUARIO"]);
        echo json_encode($datos);
    break;

    case "updateUsuario":
        // Obtener los datos del cuerpo de la solicitud
        $ID_USUARIO = $body["ID_USUARIO"];
        $USUARIO = $body["USUARIO"];
        $NOMBRE_USUARIO = $body["NOMBRE_USUARIO"];
        $ID_ESTADO_USUARIO = $body["ID_ESTADO_USUARIO"];
        $CORREO_ELECTRONICO = $body["CORREO_ELECTRONICO"];
        $ID_ROL = $body["ID_ROL"];
        $CONTRASENA = $body["CONTRASENA"]; // Nueva contraseña, si se proporciona
    
        // Verificar si el usuario ya existe en la base de datos (si es diferente)
        if (verificarExistenciaUsuario($USUARIO) > 0 && !esMismoUsuario($ID_USUARIO, $USUARIO)) {
            http_response_code(409);
            echo json_encode(["error" => "El usuario ya existe en la base de datos."]);
        } else {
            // Actualizar el usuario
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            
            //------------------------ValoresAntiguos------------------------
            $valoresAntiguos = $com->get_usuario_bitacora($ID_USUARIO);
            $UsuarioAntes = $valoresAntiguos['USUARIO'];
            $NombreUsuarioAntes = $valoresAntiguos['NOMBRE_USUARIO'];
            $EstadoUsuarioAntes = $valoresAntiguos['NOMBRE'];
            $CorreoElectronicoAntes = $valoresAntiguos['CORREO_ELECTRONICO'];
            $RolAntes = $valoresAntiguos['ROL'];
 
            $estadoUsuarioNuevo = $com ->get_EstadoUsuario($ID_ESTADO_USUARIO)['NOMBRE'];
            $rolNuevo = $com->get_nombreRol($ID_ROL)['ROL'];
            
            $datos = $com->update_usuario(
                $ID_USUARIO,
                $USUARIO,
                $NOMBRE_USUARIO,
                $ID_ESTADO_USUARIO,
                $CONTRASENA, 
                $CORREO_ELECTRONICO,
                $ID_ROL,
                $_SESSION['usuario'],
                $dateNew
            );
    
            // Respuesta exitosa
            echo json_encode(["message" => "Usuario editado exitosamente."]);
    
            // Registrar la modificación en la bitácora
            //------------------------------------------------------Decisiones-------------------------
            if(strcmp($UsuarioAntes, $USUARIO) != 0){
                $bit->insert_bitacoraModificacion($dateNew, $UsuarioAntes, $USUARIO, $_SESSION['id_usuario'], 2, "USUARIO", $ID_USUARIO, "MODIFICAR");
            }
    
            if(strcmp($NombreUsuarioAntes, $NOMBRE_USUARIO) != 0){
                $bit->insert_bitacoraModificacion($dateNew, $NombreUsuarioAntes, $NOMBRE_USUARIO, $_SESSION['id_usuario'], 2, "NOMBRE USUARIO", $ID_USUARIO, "MODIFICAR");
            }
    
            if(strcmp($EstadoUsuarioAntes, $ID_ESTADO_USUARIO) != 0){
                $bit->insert_bitacoraModificacion($dateNew, $EstadoUsuarioAntes, $estadoUsuarioNuevo, $_SESSION['id_usuario'], 2, "ESTADO USUARIO", $ID_USUARIO, "MODIFICAR");
            }
    
            if(strcmp($CorreoElectronicoAntes, $CORREO_ELECTRONICO) != 0){
                $bit->insert_bitacoraModificacion($dateNew, $CorreoElectronicoAntes, $CORREO_ELECTRONICO, $_SESSION['id_usuario'], 2, "CORREO ELECTRONICO", $ID_USUARIO, "MODIFICAR");
            }
    
            if(strcmp($RolAntes, $ID_ROL) != 0){
                $bit->insert_bitacoraModificacion($dateNew, $RolAntes, $rolNuevo, $_SESSION['id_usuario'], 2, "ROL", $ID_USUARIO, "MODIFICAR");
            }
            
        }
        break;
    

    case "eliminarUsuario":
        $ID_USUARIO = $body["ID_USUARIO"];
        $datos = $com->eliminar_usuario($ID_USUARIO);
        echo json_encode("Usuario eliminado");
        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s"); 
        $bit->insert_bitacoraEliminar($dateNew, $_SESSION['id_usuario'], 2, $ID_USUARIO,"ELIMINAR");
    break;
}
function verificarExistenciaUsuario($usuario) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_usuario WHERE USUARIO = :usuario";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

function verificarExistenciaEmail($correo) {
    // Realiza una consulta en la base de datos para verificar si el objeto ya existe
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_usuario WHERE CORREO_ELECTRONICO = :correo";

    // Realiza la conexión a la base de datos y ejecuta la consulta
    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devuelve el número de resultados encontrados
    return $row['count'];
}

function esMismoUsuario($ID_USUARIO, $USUARIO) {
    $sql = "SELECT COUNT(*) as count FROM tbl_ms_usuario WHERE ID_USUARIO = :id_usuario AND USUARIO = :usuario";

    $conexion = new Conectar();
    $conn = $conexion->Conexion();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $ID_USUARIO);
    $stmt->bindParam(':usuario', $USUARIO);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['count'];
}





?>
