<?php
class cuenta extends Conectar
{
    //TRAE TODOS LOS USUARIO
    public function get_cuentas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_mc_cuenta;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UN USUARIO
    public function get_cuenta($ID_CUENTA)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_mc_cuenta where ID_CUENTA = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // //INSERTA UN USUARIO
    // public function insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL)
    // {
    //     try {
    //         $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
    //         //echo $contrasenaEncriptada;
    //         $conectar = parent::conexion();
    //         parent::set_names();
    //         $sql = "INSERT INTO `siaace`.`tbl_ms_usuario` (`USUARIO`, `NOMBRE_USUARIO`, `ID_ESTADO_USUARIO`, `CONTRASENA`, `CORREO_ELECTRONICO`, `ID_ROL`) VALUES ( :USUARIO, :NOMBRE_USUARIO, :ID_ESTADO_USUARIO, :CONTRASENA, :CORREO_ELECTRONICO, :ID_ROL)";

    //         $stmt = $conectar->prepare($sql);

    //         $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
    //         $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
    //         $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
    //         $stmt->bindParam(':CONTRASENA', $contrasenaEncriptada, PDO::PARAM_STR);
    //         $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
    //         $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);

    //         $stmt->execute();

    //         if ($stmt->rowCount() > 0) {
    //             return "Usuario Insertado";
    //         } else {
    //             return "Error al insertar el usuario";
    //         }
    //     } catch (PDOException $e) {

    //         return "Error al insertar el usuario: " . $e->getMessage();
    //     }
    // }

    // //EDITA UN USUARIO
    // public function update_usuario($ID_USUARIO, $USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CORREO_ELECTRONICO, $ID_ROL)
    // {
    //     try {
    //         $conectar = parent::conexion();
    //         parent::set_names();

    //         // Consulta SQL para actualizar los campos del usuario
    //         $sql = "UPDATE `tbl_ms_usuario` 
    //                 SET `USUARIO` = :USUARIO, 
    //                     `NOMBRE_USUARIO` = :NOMBRE_USUARIO, 
    //                     `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO, 
    //                     `CORREO_ELECTRONICO` = :CORREO_ELECTRONICO, 
    //                     `ID_ROL` = :ID_ROL 
    //                 WHERE `ID_USUARIO` = :ID_USUARIO";

    //         $stmt = $conectar->prepare($sql);

    //         $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
    //         $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
    //         $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
    //         $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
    //         $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
    //         $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);

    //         $stmt->execute();

    //         if ($stmt->rowCount() > 0) {
    //             return "Usuario actualizado correctamente";
    //         } else {
    //             return "No se realizó ninguna actualización, o el usuario no existe";
    //         }
    //     } catch (PDOException $e) {
    //         return "Error al actualizar el usuario: " . $e->getMessage();
    //     }
    // }

    // // ELIMINA UN USUARIO
    // public function eliminar_usuario($ID_USUARIO)
    // {
    //     try {
    //         $conectar = parent::conexion();
    //         parent::set_names();
    //         // Consulta SQL para eliminar el usuario
    //         $sql = "DELETE FROM `tbl_ms_usuario` WHERE `ID_USUARIO` = :ID_USUARIO";
    //         $stmt = $conectar->prepare($sql);
    //         $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
    //         $stmt->execute();
    //         if ($stmt->rowCount() > 0) {
    //             return "Usuario eliminado correctamente";
    //         } else {
    //             return "No se realizó ninguna eliminación, o el usuario no existe";
    //         }
    //     } catch (PDOException $e) {
    //         return  $e->getCode();
    //     }
    // }
}
