<?php
class Region extends Conectar
{
    // TRAE TODAS LAS REGIONES
    public function get_regiones()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_me_region;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UNA REGIÓN
    public function get_region($ID_REGION)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_me_region WHERE ID_REGION = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_REGION, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // INSERTA UNA REGIÓN
    public function insert_region($REGION, $DESCRIPCION, $CREADO_POR, $FECHA_CREACION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_me_region` ( `REGION`, `DESCRIPCION`, `CREADO_POR`, `FECHA_CREACION`, `ESTADO`) VALUES ( :REGION, :DESCRIPCION, :CREADO_POR, :FECHA_CREACION, :ESTADO)";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':REGION', $REGION, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Región Insertada";
            } else {
                return "Error al insertar la región";
            }
        } catch (PDOException $e) {
            return "Error al insertar la región: " . $e->getMessage();
        }
    }

    // EDITA UNA REGIÓN
    public function update_region($ID_REGION, $REGION, $DESCRIPCION, $MODIFICADO_POR, $FECHA_MODIFICACION, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para actualizar los campos de la región
            $sql = "UPDATE `tbl_me_region` 
                SET `REGION` = :REGION, 
                    `DESCRIPCION` = :DESCRIPCION,
                    `MODIFICADO_POR` = :MODIFICADO_POR, 
                    `FECHA_MODIFICACION` = :FECHA_MODIFICACION,
                    `ESTADO` = :ESTADO
                WHERE `ID_REGION` = :ID_REGION";
            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_REGION', $ID_REGION, PDO::PARAM_INT);
            $stmt->bindParam(':REGION', $REGION, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Región actualizada correctamente";
            } else {
                return "No se realizó ninguna actualización, o la región no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la región: " . $e->getMessage();
        }
    }

    // ELIMINA UNA REGIÓN
    public function eliminar_region($ID_REGION)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar la región
            $sql = "DELETE FROM `tbl_me_region` WHERE `ID_REGION` = :ID_REGION";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_REGION', $ID_REGION, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Región eliminada correctamente";
            } else {
                return "No se realizó ninguna eliminación, o la región no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar la región: " . $e->getMessage();
        }
    }
}
?>
