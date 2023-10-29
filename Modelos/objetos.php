<?php
class Objetos extends Conectar
{
    // TRAE TODOS LOS OBJETOS
    public function get_objetos() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_objetos;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN OBJETO
    public function get_objeto($ID_OBJETO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_ms_objetos WHERE ID_OBJETO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_OBJETO, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA UN OBJETO
    public function insert_objeto( $OBJETO, $DESCRIPCION, $TIPO_OBJETO, $CREADO_POR, $FECHA_CREACION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_objetos` ( `OBJETO`, `DESCRIPCION`, `TIPO_OBJETO`, `CREADO_POR`, `FECHA_CREACION`) VALUES ( :OBJETO, :DESCRIPCION, :TIPO_OBJETO, :CREADO_POR, :FECHA_CREACION)";
    
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':OBJETO', $OBJETO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':TIPO_OBJETO', $TIPO_OBJETO, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Objeto Insertado";
            } else {
                return "Error al insertar el objeto"; 
            }
        } catch (PDOException $e) {
            return "Error al insertar el objeto: " . $e->getMessage();
        }
    }

    // EDITA UN OBJETO
    public function update_objeto($ID_OBJETO, $OBJETO, $DESCRIPCION, $TIPO_OBJETO, $MODIFICADO_POR, $FECHA_MODIFICACION,) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para actualizar los campos del objeto
            $sql = "UPDATE `tbl_ms_objetos` 
            SET `OBJETO` = :OBJETO, 
                `DESCRIPCION` = :DESCRIPCION, 
                `TIPO_OBJETO` = :TIPO_OBJETO,
                `MODIFICADO_POR` = :MODIFICADO_POR, 
                `FECHA_MODIFICACION` = :FECHA_MODIFICACION
            WHERE `ID_OBJETO` = :ID_OBJETO";        
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
            $stmt->bindParam(':OBJETO', $OBJETO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':TIPO_OBJETO', $TIPO_OBJETO, PDO::PARAM_STR);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Objeto actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el objeto no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el objeto: " . $e->getMessage();
        }
    }
    
    // ELIMINA UN OBJETO
    public function eliminar_objeto($ID_OBJETO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el objeto
            $sql = "DELETE FROM `tbl_ms_objetos` WHERE `ID_OBJETO` = :ID_OBJETO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Objeto eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el objeto no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el objeto: " . $e->getMessage();
        }
    }
}
?>
