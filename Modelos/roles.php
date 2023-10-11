<?php
class Roles extends Conectar
{
    // TRAE TODOS LOS ROL
    public function get_roles() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_roles;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN ROL
    public function get_rol($ID_ROL) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_ms_roles WHERE ID_ROL = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_ROL, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA UN ROL
    public function insert_rol( $ROL, $DESCRIPCION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_roles` ( `ROL`, `DESCRIPCION`) VALUES ( :ROL, :DESCRIPCION)";
    
            $stmt = $conectar->prepare($sql);
          
            $stmt->bindParam(':ROL', $ROL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
          
            
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "rol Insertado";
            } else {
                return "Error al insertar el rol"; 
            }
        } catch (PDOException $e) {
            return "Error al insertar el rol: " . $e->getMessage();
        }
    }

    // EDITA UN ROL
    public function update_rol($ID_ROL, $ROL, $DESCRIPCION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
    
            // Consulta SQL para actualizar los campos del ROL
            $sql = "UPDATE `tbl_ms_roles` 
                    SET `ROL` = :ROL, 
                        `DESCRIPCION` = :DESCRIPCION 
                    WHERE `ID_ROL` = :ID_ROL";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->bindParam(':ROL', $ROL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "rol actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el rol no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el rol: " . $e->getMessage();
        }
    }
    
    // ELIMINA UN ROL
    public function eliminar_rol($ID_ROL) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el ROL
            $sql = "DELETE FROM `tbl_ms_roles` WHERE `ID_ROL` = :ID_ROL";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Rol eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el rol no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el rol: " . $e->getMessage();
        }
    }
}
?>
