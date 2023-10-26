<?php
class Sucursal extends Conectar
{
    // TRAE TODOS LAS SUCURSALES
    public function get_sucursales() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "   SELECT S.*, R.REGION
        FROM siaace.tbl_me_sucursal S
        INNER JOIN siaace.tbl_me_region R ON S.ID_REGION = R.ID_REGION;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN SUCURSAL
    public function get_sucursal($ID_SUCURSAL) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_me_sucursal WHERE ID_SUCURSAL = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_SUCURSAL, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA 
    public function insert_sucursal( $SUCURSAL,$DESCRIPCION,$DIRECCION,$ID_REGION,$TELEFONO,$ESTADO ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_me_sucursal` ( `SUCURSAL`, `DESCRIPCION`, `DIRECCION`, `ID_REGION`, `TELEFONO`,`ESTADO` ) VALUES ( :SUCURSAL,:DESCRIPCION, :DIRECCION, :ID_REGION, :TELEFONO,:ESTADO )";
    
            $stmt = $conectar->prepare($sql);
          
            $stmt->bindParam(':SUCURSAL', $SUCURSAL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION', $DIRECCION, PDO::PARAM_STR);
            $stmt->bindParam(':ID_REGION', $ID_REGION, PDO::PARAM_INT);
            $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Sucursal Insertada";
            } else {
                return "Error al insertar la sucursal"; 
            }
        } catch (PDOException $e) {
            return "Error al insertar la sucursal: " . $e->getMessage();
        }
    }

    // EDITA 
    public function update_sucursal($ID_SUCURSAL, $SUCURSAL, $DESCRIPCION,$DIRECCION,$ID_REGION,$TELEFONO,$ESTADO ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
    
            // Consulta SQL para actualizar los campos de la sucursal
            $sql = "UPDATE `tbl_me_sucursal` 
                    SET `SUCURSAL` = :SUCURSAL, 
                        `DESCRIPCION` = :DESCRIPCION, 
                        `DIRECCION` = :DIRECCION,
                        `ID_REGION` = :ID_REGION,
                        `TELEFONO` = :TELEFONO,
                        `ESTADO` = :ESTADO
                    WHERE `ID_SUCURSAL` = :ID_SUCURSAL";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
            $stmt->bindParam(':SUCURSAL', $SUCURSAL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION', $DIRECCION, PDO::PARAM_STR);
            $stmt->bindParam(':ID_REGION', $ID_REGION, PDO::PARAM_INT);
            $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Sucursal actualizada correctamente";
            } else {
                return "No se realizó ninguna actualización, o la sucursal no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la sucursal: " . $e->getMessage();
        }
    }
    
    // ELIMINA 
    public function eliminar_sucursal($ID_SUCURSAL) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el objeto
            $sql = "DELETE FROM `tbl_me_sucursal` WHERE `ID_SUCURSAL` = :ID_SUCURSAL";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Sucursal eliminada correctamente";
            } else {
                return "No se realizó ninguna eliminación, o la sucursal no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar la sucursal: " . $e->getMessage();
        }
    }
}
?>
