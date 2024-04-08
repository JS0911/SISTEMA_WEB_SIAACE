<?php
class Cuentas extends Conectar
{
    // TRAE TODOS LOS OTIPO DE CUENTA
    public function get_tipoCuentas() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_mc_tipocuenta;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN TIPO DE CUENTA
    public function get_tipoCuenta($ID_TIPOCUENTA) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mc_tipocuenta WHERE ID_TIPOCUENTA = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_TIPOCUENTA, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA UN TIPO DE CUENTA
    public function insert_tipoCuenta($TIPO_CUENTA, $DESCRIPCION,$TASA, $ESTADO, $CREADO_POR, $FECHA_CREACION) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
           
            $sql = "INSERT INTO `siaace`.`tbl_mc_tipocuenta` (`TIPO_CUENTA`, `DESCRIPCION`, `TASA`, `ESTADO`,`CREADO_POR`,`FECHA_CREACION`) VALUES (:TIPO_CUENTA, :DESCRIPCION, :TASA, :ESTADO,:CREADO_POR,:FECHA_CREACION)";

            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':TIPO_CUENTA', $TIPO_CUENTA, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':TASA', $TASA, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            
            
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "TIPO DE CUENTA Insertado";
            } else {
                return "Error al insertar el Tipo de Cuenta";
            }
        } catch (PDOException $e) {
            return "Error al insertar el tipo de cuenta: " . $e->getMessage();
        }
    }
    

 // EDITA UN TIPO CUENTA
 public function update_tipoCuenta($ID_TIPOCUENTA, $TIPO_CUENTA, $DESCRIPCION, $TASA, $ESTADO, $MODIFICADO_POR, $FECHA_MODIFICACION) {
    try {
        $conectar = parent::conexion();
        parent::set_names();
      

        // Consulta SQL para actualizar los campos del ROL
        $sql = "UPDATE `tbl_mc_tipocuenta` 
        SET `TIPO_CUENTA` = :TIPO_CUENTA, 
            `DESCRIPCION` = :DESCRIPCION, 
            `TASA` = :TASA, 
            `ESTADO` = :ESTADO,
            `MODIFICADO_POR` = :MODIFICADO_POR, 
                `FECHA_MODIFICACION` = :FECHA_MODIFICACION
        WHERE `ID_TIPOCUENTA` = :ID_TIPOCUENTA";

        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':ID_TIPOCUENTA', $ID_TIPOCUENTA, PDO::PARAM_INT);
        $stmt->bindParam(':TIPO_CUENTA', $TIPO_CUENTA, PDO::PARAM_STR);
        $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
        $stmt->bindParam(':TASA', $TASA, PDO::PARAM_STR);
        $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
        $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
        $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
       
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Tipo de Cuenta actualizado correctamente";
        } else {
            return "No se realizó ninguna actualización, o el Tipo de Cuenta no existe";
        }
    } catch (PDOException $e) {
        return "Error al actualizar el Tipo de Cuenta: " . $e->getMessage();
    }
}

    
    
    // ELIMINA UN TIPO CUENTA
    public function eliminar_tipoCuenta($ID_TIPOCUENTA) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el TIPO DE CUENTA
            $sql = "DELETE FROM `tbl_mc_tipocuenta` WHERE `ID_TIPOCUENTA` = :ID_TIPOCUENTA";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_TIPOCUENTA', $ID_TIPOCUENTA, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "TIPO DE CUENTA eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el tipo cuenta no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el TIPO DE CUENTA: " . $e->getMessage();
        }
    }
}
?>
