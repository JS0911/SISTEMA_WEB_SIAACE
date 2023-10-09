<?php

class PermisosUsuarios extends Conectar
{
    public function get_Permisos_Usuarios($id_rol, $id_objeto)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT PERMISOS_INSERCION, PERMISOS_ELIMINACION, PERMISOS_ACTUALIZACION, PERMISOS_CONSULTAR 
                FROM siaace.tbl_ms_permisos 
                WHERE id_rol = :id_rol AND id_objeto = :id_objeto";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $sql->bindParam(':id_objeto', $id_objeto, PDO::PARAM_INT);
        $sql->execute();
        //echo $sql;
        // Verificar si se obtuvieron resultados
        if ($sql->rowCount() > 0) {
            // echo "Si se obtuvieron resultados";
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            //echo "no se encontraron resultado, puedes manejarlo como desees";
            // En este caso, no se encontraron resultados, puedes manejarlo como desees
            return array(); // Devuelve un array vacío o un valor que indique la ausencia de resultados
        }
    }


    //TRAE TODA LA TABLA PERMISOS
    public function get_Permisos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_permisos";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        //echo $sql;
        // Verificar si se obtuvieron resultados
        if ($sql->rowCount() > 0) {
            // echo "Si se obtuvieron resultados";
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            //echo "no se encontraron resultado, puedes manejarlo como desees";
            // En este caso, no se encontraron resultados, puedes manejarlo como desees
            return array(); // Devuelve un array vacío o un valor que indique la ausencia de resultados
        }
    }


    //INSERTA UN PERMISO
    public function insert_permiso($ID_ROL, $ID_OBJETO, $PERMISOS_INSERCION, $PERMISOS_ELIMINACION, $PERMISOS_ACTUALIZACION, $PERMISOS_CONSULTAR)
    {
        try {

            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_permisos` (`ID_ROL`, `ID_OBJETO`, `PERMISOS_INSERCION`, `PERMISOS_ELIMINACION`, `PERMISOS_ACTUALIZACION`, `PERMISOS_CONSULTAR`) VALUES ( :ID_ROL, :ID_OBJETO, :PERMISOS_INSERCION, :PERMISOS_ELIMINACION, :PERMISOS_ACTUALIZACION, :PERMISOS_CONSULTAR)";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_INSERCION', $PERMISOS_INSERCION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_ELIMINACION', $PERMISOS_ELIMINACION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_ACTUALIZACION', $PERMISOS_ACTUALIZACION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_CONSULTAR', $PERMISOS_CONSULTAR, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Permiso Insertado";
            } else {
                return "Error al insertar el permiso";
            }
        } catch (PDOException $e) {

            return "Error al insertar el permiso: " . $e->getMessage();
        }
    }

    // //EDITA UN PERMISO
    public function update_permiso($ID_ROL, $ID_OBJETO, $PERMISOS_INSERCION, $PERMISOS_ELIMINACION, $PERMISOS_ACTUALIZACION, $PERMISOS_CONSULTAR)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del usuario
            $sql = "UPDATE `tbl_ms_permisos` 
                    SET `PERMISOS_INSERCION` = :PERMISOS_INSERCION, 
                        `PERMISOS_ELIMINACION` = :PERMISOS_ELIMINACION, 
                        `PERMISOS_ACTUALIZACION` = :PERMISOS_ACTUALIZACION, 
                        `PERMISOS_CONSULTAR` = :PERMISOS_CONSULTAR 
                         
                    WHERE `ID_ROL` = :ID_ROL AND `ID_OBJETO` = :ID_OBJETO";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_INSERCION', $PERMISOS_INSERCION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_ELIMINACION', $PERMISOS_ELIMINACION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_ACTUALIZACION', $PERMISOS_ACTUALIZACION, PDO::PARAM_INT);
            $stmt->bindParam(':PERMISOS_CONSULTAR', $PERMISOS_CONSULTAR, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Permiso actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el rol u objeto no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el permiso: " . $e->getMessage();
        }
    }

    // ELIMINA UN PERMISO
    public function eliminar_permiso($ID_ROL, $ID_OBJETO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SELECT para verificar si el permiso existe
            $select_sql = "SELECT * FROM `tbl_ms_permisos` WHERE `ID_ROL` = :ID_ROL AND `ID_OBJETO` = :ID_OBJETO";
            $stmt_select = $conectar->prepare($select_sql);
            $stmt_select->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt_select->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
            $stmt_select->execute();

            // Verificar si se encontró el permiso
            if ($stmt_select->rowCount() > 0) {
                // El permiso existe, proceder con la eliminación
                $delete_sql = "DELETE FROM `tbl_ms_permisos` WHERE `ID_ROL` = :ID_ROL AND `ID_OBJETO` = :ID_OBJETO";
                $stmt_delete = $conectar->prepare($delete_sql);
                $stmt_delete->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
                $stmt_delete->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
                $stmt_delete->execute();

                if ($stmt_delete->rowCount() > 0) {
                    return "Permiso eliminado correctamente";
                } else {
                    return "No se realizó ninguna eliminación, o el rol u objeto no existe";
                }
            } else {
                return "El permiso no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el objeto: " . $e->getMessage();
        }
    }
}
