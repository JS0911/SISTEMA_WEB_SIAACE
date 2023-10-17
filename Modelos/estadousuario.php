<?php
class Estados extends Conectar
{
    // TRAE TODOS LOS ESTADOS
    public function get_estados() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_estadousuario;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN ESTADO
    public function get_estado($ID_ESTADO_USUARIO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_ms_estadousuario WHERE ID_ESTADO_USUARIO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_ESTADO_USUARIO, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA UN ESTADO
    public function insert_estado( $NOMBRE, $DESCRIPCION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_estadousuario` ( `NOMBRE`, `DESCRIPCION`) VALUES ( :NOMBRE, :DESCRIPCION)";
    
            $stmt = $conectar->prepare($sql);
          
            $stmt->bindParam(':NOMBRE', $NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Estado Insertado";
            } else {
                return "Error al insertar el estado"; 
            }
        } catch (PDOException $e) {
            return "Error al insertar el estado: " . $e->getMessage();
        }
    }

    // EDITA UN ESTADO
    public function update_estado($ID_ESTADO_USUARIO, $NOMBRE, $DESCRIPCION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
    
            // Consulta SQL para actualizar los campos del estado
            $sql = "UPDATE `tbl_ms_estadousuario` 
                    SET `NOMBRE` = :NOMBRE, 
                        `DESCRIPCION` = :DESCRIPCION
                    WHERE `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':NOMBRE', $NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Estado actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el estado no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el estado: " . $e->getMessage();
        }
    }
    
    // ELIMINA UN ESTADO
    public function eliminar_estado($ID_ESTADO_USUARIO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el estado
            $sql = "DELETE FROM `tbl_ms_estadousuario` WHERE `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Estado eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el estado no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el estado: " . $e->getMessage();
        }
    }
}
?>