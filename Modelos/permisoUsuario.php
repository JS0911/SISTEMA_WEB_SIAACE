<?php

class PermisosUsuarios extends Conectar
{
    public function get_Permisos_Usuarios($id_rol, $id_objeto) 
{
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT PERMISOS_INSERCION, PERMISOS_ELIMINACION, PERMISOS_ACTUALIZACION, PERMISOS_CONSULTAR 
            FROM siaace.tbl_ms_permisos 
            WHERE id_rol = :id_rol AND id_objeto = :id_objeto";
    $sql = $conectar->prepare($sql);
    $sql->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $sql->bindParam(':id_objeto', $id_objeto, PDO::PARAM_INT);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
}


    //TRAE SOLO UN PERMISO
    // public function get_PermisoUsuario($ID_ROL, $ID_OBJETO) 
    // {
    //     $conectar = parent::conexion();
    //     parent::set_names();
    //     $sql = "SELECT * FROM tbl_ms_permisos WHERE ID_ROL = :ID , ID_OBJETO = :ID_OBJETO";
    //     $stmt = $conectar->prepare($sql);
    //     $stmt->bindParam(':ID', $ID_ROL, PDO::PARAM_INT ,':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT ); 
    
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC); 
    // }
    
    // //INSERTA UN USUARIO
    // public function insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL) {
    // try {
    //     $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
    //     //echo $contrasenaEncriptada;
    //     $conectar = parent::conexion();
    //     parent::set_names();
    //     $sql = "INSERT INTO `siaace`.`tbl_ms_usuario` (`USUARIO`, `NOMBRE_USUARIO`, `ID_ESTADO_USUARIO`, `CONTRASENA`, `CORREO_ELECTRONICO`, `ID_ROL`) VALUES ( :USUARIO, :NOMBRE_USUARIO, :ID_ESTADO_USUARIO, :CONTRASENA, :CORREO_ELECTRONICO, :ID_ROL)";

    //     $stmt = $conectar->prepare($sql);
      
    //     $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
    //     $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
    //     $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
    //     $stmt->bindParam(':CONTRASENA', $contrasenaEncriptada, PDO::PARAM_STR);
    //     $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
    //     $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
        
    //     $stmt->execute();

    //     if ($stmt->rowCount() > 0) {
    //         return "Usuario Insertado";
    //     } else {
    //         return "Error al insertar el usuario"; 
    //     }
    // } catch (PDOException $e) {
       
    //     return "Error al insertar el usuario: " . $e->getMessage();
    // }
    // }

    // //EDITA UN USUARIO
    // public function update_usuario($ID_USUARIO, $USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CORREO_ELECTRONICO, $ID_ROL) {
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
    

    
}