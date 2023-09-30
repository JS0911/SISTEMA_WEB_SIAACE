<?php
class Usuario extends Conectar
{
    public function get_usuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_usuario;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_usuario($ID_USUARIO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $sql = $conectar->prepare($sql);

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':USUARIO', $ID_USUARIO, PDO::PARAM_STR);

        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL) {


    try {
        $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
        //echo $contrasenaEncriptada;
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_usuario` (`USUARIO`, `NOMBRE_USUARIO`, `ID_ESTADO_USUARIO`, `CONTRASENA`, `CORREO_ELECTRONICO`, `ID_ROL`) VALUES ( :USUARIO, :NOMBRE_USUARIO, :ID_ESTADO_USUARIO, :CONTRASENA, :CORREO_ELECTRONICO, :ID_ROL)";

        $stmt = $conectar->prepare($sql);
      
        $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':CONTRASENA', $contrasenaEncriptada, PDO::PARAM_STR);
        $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Usuario Insertado";
        } else {
            return "Error al insertar el usuario"; 
        }
    } catch (PDOException $e) {
       
        return "Error al insertar el usuario: " . $e->getMessage();
    }
}

/* public function VerificarUsuario($USUARIO,$CONTRASENA){
require "../Config/conexion.php";
session_start();

if ($_POST) {
    $USUARIO = $_POST['usuario'];
    $CONTRASENA = $_POST['contrasena'];

    // Crear una instancia de la clase Conectar
    $conexion = new Conectar();
    $conn = $conexion->Conexion();

    if ($conn) { // Verificar si la conexión se estableció correctamente
        $sql = "SELECT id_usuario, usuario, contrasena FROM tbl_ms_usuario WHERE usuario='$USUARIO'";
        //echo $sql;
        $stmt = $conn->query($sql);

        if ($stmt) {
            $num = $stmt->rowCount();

            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $password_bd = $row['contrasena'];
                //PARA ENCRIPTAR LA CONTRASEÑA
                $pass_c = password_hash($CONTRASENA, PASSWORD_DEFAULT);
                echo $pass_c;
                // PARA VERIFICAR QUE LA CONTRASEÑA ENCRIPTADA COINCIDA CON LA QUE ESTÁ EN LA BASE DE DATOS
                if (password_verify($CONTRASENA, $password_bd)) {
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['usuario'] = $row['usuario'];
                    header("Location: index.php");
                } else {
                    echo "La contraseña no coincide";
                }
            } else {
                echo "No existe usuario";
            }
        } else {
            echo "Error en la consulta: " . $conn->errorInfo()[2]; // Mostrar el mensaje de error de PDO
        }
    } else {
        echo "Error al conectar a la base de datos.";
    }
}
} */

/* public function EditUsuarios($ID_USUARIO,$USUARIO,$NOMBRE_USUARIO,$ID_ESTADO_USUARIO,$CORREO_ELECTRONICO,$ID_ROL){
    $conectar = parent::conexion();
    parent::set_names();

    $sql = "SELECT *  FROM tbl_ms_usuario WHERE ID_USUARIO = $ID_USUARIO";
    $stmt = $conectar->prepare($sql);

    
    $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
    $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
    $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
    $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
    $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
} */
    
}