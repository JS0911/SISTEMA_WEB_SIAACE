<?php
class Roles extends Conectar
{
    // TRAE TODOS LOS ROL
    public function get_roles()
    {
        $conectar = parent::conexion();
        parent::set_names();
        //$sql = "SELECT * FROM siaace.tbl_ms_roles;"
        $sql = "SELECT U.*, E.NOMBRE
        FROM siaace.tbl_ms_roles U
        INNER JOIN siaace.tbl_ms_estadousuario E ON U.ID_ESTADO_USUARIO = E.ID_ESTADO_USUARIO";
       
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
    public function insert_rol($ROL, $DESCRIPCION, $ID_ESTADO_USUARIO, $CREADO_POR, $FECHA_CREACION)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_roles` ( `ROL`, `DESCRIPCION`,`ID_ESTADO_USUARIO`,`CREADO_POR`,`FECHA_CREACION`) VALUES ( :ROL, :DESCRIPCION, :ID_ESTADO_USUARIO, :CREADO_POR,:FECHA_CREACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ROL', $ROL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);


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
    public function update_rol($ID_ROL, $ROL, $DESCRIPCION, $ID_ESTADO_USUARIO, $MODIFICADO_POR, $FECHA_MODIFICACION)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del ROL
            $sql = "UPDATE `tbl_ms_roles` 
                    SET `ROL` = :ROL, 
                        `DESCRIPCION` = :DESCRIPCION ,
                        `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO ,
                        `MODIFICADO_POR` = :MODIFICADO_POR, 
                `FECHA_MODIFICACION` = :FECHA_MODIFICACION
                    WHERE `ID_ROL` = :ID_ROL";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->bindParam(':ROL', $ROL, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INPUT_OUTPUT);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);

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
    public function eliminar_rol($ID_ROL)
    {
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
