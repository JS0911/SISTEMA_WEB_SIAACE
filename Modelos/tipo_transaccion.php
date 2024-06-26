<?php 
class tipoTransaccion extends Conectar
{
    // TRAE TODAS LAS TRANSACCION
    public function get_tipoTransacciones()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_tipo_transaccion ORDER BY FECHA_CREACION DESC;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UNA TRANSACCION
    public function get_tipoTransaccion($ID_TIPO_TRANSACCION)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_tipo_transaccion WHERE ID_TIPO_TRANSACCION = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_TIPO_TRANSACCION, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // INSERTA UNA TRANSACCION
    public function insert_tipoTransaccion($TIPO_TRANSACCION, $DESCRIPCION, $SIGNO_TRANSACCION, $CREADO_POR, $FECHA_CREACION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `tbl_tipo_transaccion` ( `TIPO_TRANSACCION`, `DESCRIPCION`, `SIGNO_TRANSACCION`, `CREADO_POR`, `FECHA_CREACION`, `ESTADO`) VALUES ( :TIPO_TRANSACCION, :DESCRIPCION, :SIGNO_TRANSACCION, :CREADO_POR, :FECHA_CREACION, :ESTADO)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':TIPO_TRANSACCION', $TIPO_TRANSACCION, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':SIGNO_TRANSACCION', $SIGNO_TRANSACCION, PDO::PARAM_INT);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Transaccion Insertada";
            } else {
                return "Error al insertar la transaccion";
            }
        } catch (PDOException $e) {
            return "Error al insertar la transaccion: " . $e->getMessage();
        }
    }

    // EDITA UNA TRANSACCION
    public function update_tipoTransaccion($ID_TIPO_TRANSACCION, $TIPO_TRANSACCION, $DESCRIPCION, $SIGNO_TRANSACCION, $MODIFICADO_POR, $FECHA_MODIFICACION, $ESTADO )
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos de la región
            $sql = "UPDATE `tbl_tipo_transaccion` 
                    SET `TIPO_TRANSACCION` = :TIPO_TRANSACCION, 
                        `DESCRIPCION` = :DESCRIPCION,
                        `SIGNO_TRANSACCION` = :SIGNO_TRANSACCION,
                        `MODIFICADO_POR` = :MODIFICADO_POR, 
                        `FECHA_MODIFICACION` = :FECHA_MODIFICACION,
                        `ESTADO` = :ESTADO
                    WHERE `ID_TIPO_TRANSACCION` = :ID_TIPO_TRANSACCION";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_TIPO_TRANSACCION', $ID_TIPO_TRANSACCION, PDO::PARAM_INT);
            $stmt->bindParam(':TIPO_TRANSACCION', $TIPO_TRANSACCION, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':SIGNO_TRANSACCION', $SIGNO_TRANSACCION, PDO::PARAM_INT);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Transaccion actualizada correctamente";
            } else {
                return "No se realizó ninguna actualización, o la transaccion no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la transaccion: " . $e->getMessage();
        }
    }

    // ELIMINA UNA TRANSACCION
    public function eliminar_tipoTransaccion($ID_TIPO_TRANSACCION)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar la región
            $sql = "DELETE FROM `tbl_tipo_transaccion` WHERE `ID_TIPO_TRANSACCION` = :ID_TIPO_TRANSACCION";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_TIPO_TRANSACCION', $ID_TIPO_TRANSACCION, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Transaccion eliminada correctamente";
            } else {
                return "No se realizó ninguna eliminación, o la transaccion no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar la transaccion: " . $e->getMessage();
        }
    }

    public function modificarRegistroImportado($TIPO_TRANSACCION, $DESCRIPCION, $SIGNO_TRANSACCION , $CREADO_POR, $FECHA_CREACION, $MODIFICADO_POR, $FECHA_MODIFICACION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE `tbl_tipo_transaccion`
            SET `DESCRIPCION` = :DESCRIPCION, 
                `SIGNO_TRANSACCION` = :SIGNO_TRANSACCION, 
                `CREADO_POR` = :CREADO_POR, 
                `FECHA_CREACION` = :FECHA_CREACION,
                `MODIFICADO_POR` = :MODIFICADO_POR,
                `FECHA_MODIFICACION` = :FECHA_MODIFICACION,
                `ESTADO` = :ESTADO
            WHERE `TIPO_TRANSACCION` = :TIPO_TRANSACCION";
            
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':TIPO_TRANSACCION', $TIPO_TRANSACCION, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':SIGNO_TRANSACCION', $SIGNO_TRANSACCION, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Forma de pago actualizada.";
            } else {
                return "No se realizó ninguna actualización, o la forma de pago no existe.";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la forma de pago: " . $e->getMessage();
        }
    }

}
?>
