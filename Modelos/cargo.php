<?php
class Cargos extends Conectar
{
    // TRAE TODOS LOS OCARGO
    public function get_cargos() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_me_cargo;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN CARGO
    public function get_cargo($ID_CARGO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_me_cargo WHERE ID_CARGO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_CARGO, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA UN CARGO
    public function insert_cargo($CARGO, $DESCRIPCION, $ESTADO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $fecha_actual = DATE("Y-m-d H:i:s"); 
            $sql = "INSERT INTO `siaace`.`tbl_me_cargo` (`CARGO`, `DESCRIPCION`, `FECHA_CREACION`, `ESTADO`) VALUES (:CARGO, :DESCRIPCION, :FECHA_CREACION, :ESTADO)";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':CARGO', $CARGO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $fecha_actual, PDO::PARAM_STR); // Enlaza la fecha actual
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Cargo Insertado";
            } else {
                return "Error al insertar el cargo";
            }
        } catch (PDOException $e) {
            return "Error al insertar el cargo: " . $e->getMessage();
        }
    }
    

    // EDITA UN CARGO
    public function update_cargo($ID_CARGO, $CARGO, $DESCRIPCION, $ESTADO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            
            $fecha_modificacion = date("Y-m-d H:i:s"); // Obtiene la fecha actual en el formato 'YYYY-MM-DD HH:MM:SS'
    
            // Consulta SQL para actualizar los campos del CARGO
            $sql = "UPDATE `tbl_me_cargo` 
                    SET `CARGO` = :CARGO, 
                        `DESCRIPCION` = :DESCRIPCION, 
                        `ESTADO` = :ESTADO,
                        `FECHA_MODIFICACION` = :FECHA_MODIFICACION
                    WHERE `ID_CARGO` = :ID_CARGO";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);
            $stmt->bindParam(':CARGO', $CARGO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $fecha_modificacion, PDO::PARAM_STR); // Enlaza la fecha de modificación
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Cargo actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el Cargo no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el cargo: " . $e->getMessage();
        }
    }
    
    
    // ELIMINA UN CARGO
    public function eliminar_cargo($ID_CARGO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el cargo
            $sql = "DELETE FROM `tbl_me_cargo` WHERE `ID_CARGO` = :ID_CARGO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Cargo eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el cargo no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el cargo: " . $e->getMessage();
        }
    }
}
?>
