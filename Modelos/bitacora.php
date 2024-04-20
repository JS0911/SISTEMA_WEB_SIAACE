<?php
class bitacora extends Conectar
{

    public function get_bitacora()
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "SELECT b.FECHA, b.ANTES, b.DESPUES, u.NOMBRE_USUARIO, o.OBJETO AS TABLA, b.CAMPO, b.ID_REGISTRO, b.OPERACION 
        FROM siaace.tbl_ms_bitacora AS b 
        JOIN siaace.tbl_ms_usuario AS u ON b.ID_USUARIO = u.ID_USUARIO 
        LEFT JOIN siaace.tbl_ms_objetos AS o ON b.TABLA = o.ID_OBJETO;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_bitacora($FECHA, $ID_USUARIO, $TABLA, $OPERACION)
    {
        try {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ID_USUARIO`, `TABLA`, `OPERACION`) VALUES (:FECHA, :ID_USUARIO, :TABLA, :OPERACION);";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
            $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':TABLA', $TABLA, PDO::PARAM_INT);
            $stmt->bindParam(':OPERACION', $OPERACION, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Bitacora Insertada";
            } else {
                return "Error al insertar la Bitacora";
            }
        } catch (PDOException $e) {
            return "Error al insertar la bitacora: " . $e->getMessage();
        }
    }

    public function insert_bitacoraModificacion($FECHA, $ANTES, $DESPUES, $ID_USUARIO, $TABLA, $CAMPO, $ID_REGISTRO, $OPERACION)
    {
        try {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ANTES`, `DESPUES`, `ID_USUARIO`, `TABLA`, `CAMPO`, `ID_REGISTRO`, `OPERACION`) VALUES (:FECHA, :ANTES, :DESPUES, :ID_USUARIO, :TABLA, :CAMPO, :ID_REGISTRO, :OPERACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
            $stmt->bindParam(':ANTES', $ANTES, PDO::PARAM_STR);
            $stmt->bindParam(':DESPUES', $DESPUES, PDO::PARAM_STR);
            $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':TABLA', $TABLA, PDO::PARAM_INT);
            $stmt->bindParam(':CAMPO', $CAMPO, PDO::PARAM_STR);
            $stmt->bindParam(':ID_REGISTRO', $ID_REGISTRO, PDO::PARAM_INT);
            $stmt->bindParam(':OPERACION', $OPERACION, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Bitacora Insertada";
            } else {
                return "Error al insertar la Bitacora";
            }
        } catch (PDOException $e) {
            return "Error al insertar la bitacora: " . $e->getMessage();
        }
    }

    public function insert_bitacoraEliminar($FECHA, $ID_USUARIO, $TABLA, $ID_REGISTRO, $OPERACION)
    {
        try {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ID_USUARIO`, `TABLA`, `ID_REGISTRO`, `OPERACION`) VALUES (:FECHA, :ID_USUARIO, :TABLA, :ID_REGISTRO, :OPERACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
            $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':TABLA', $TABLA, PDO::PARAM_INT);
            $stmt->bindParam(':ID_REGISTRO', $ID_REGISTRO, PDO::PARAM_INT);
            $stmt->bindParam(':OPERACION', $OPERACION, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Bitacora Insertada";
            } else {
                return "Error al insertar la Bitacora";
            }
        } catch (PDOException $e) {
            return "Error al insertar la bitacora: " . $e->getMessage();
        }
    }

    public function limpiar_bitacora()
    {
        try {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "DELETE FROM `siaace`.`tbl_ms_bitacora` WHERE 1";

            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Bitacora Limpiada";
            } else {
                return "Error al limpiar la Bitacora";
            }
        } catch (PDOException $e) {
            return "Error al limpiar la bitacora: " . $e->getMessage();
        }
    }
}
