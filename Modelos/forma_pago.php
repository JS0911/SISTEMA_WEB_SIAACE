<?php
class Fpago extends Conectar
{
   public function get_fpagos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_formapago";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert_fpago($FORMA_DE_PAGO, $DESCRIPCION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_formapago` (`FORMA_DE_PAGO`, `DESCRIPCION`, `ESTADO`) VALUES (:FORMA_DE_PAGO, :DESCRIPCION, :ESTADO)";
            
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':FORMA_DE_PAGO', $FORMA_DE_PAGO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Forma de pago insertada exitosamente.";
            } else {
                return "Error al insertar la forma de pago.";
            }
        } catch (PDOException $e) {
            return "Error al insertar la forma de pago: " . $e->getMessage();
        }
    }
    public function get_fpago($ID_FPAGO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_formapago WHERE ID_FPAGO = :ID_FPAGO";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update_fpago($ID_FPAGO, $FORMA_DE_PAGO, $DESCRIPCION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE `tbl_formapago` SET `FORMA_DE_PAGO` = :FORMA_DE_PAGO, `DESCRIPCION` = :DESCRIPCION, `ESTADO` = :ESTADO WHERE `ID_FPAGO` = :ID_FPAGO";
            
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
            $stmt->bindParam(':FORMA_DE_PAGO', $FORMA_DE_PAGO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Forma de pago actualizada correctamente.";
            } else {
                return "No se realizó ninguna actualización, o la forma de pago no existe.";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la forma de pago: " . $e->getMessage();
        }
    }
    public function eliminar_fpago($ID_FPAGO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "DELETE FROM `tbl_formapago` WHERE `ID_FPAGO` = :ID_FPAGO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Forma de pago eliminada correctamente.";
            } else {
                return "No se realizó ninguna eliminación, o la forma de pago no existe.";
            }
        } catch (PDOException $e) {
            return "Error al eliminar la forma de pago: " . $e->getMessage();
        }
    }
}
?>