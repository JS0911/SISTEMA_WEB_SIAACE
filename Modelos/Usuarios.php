<?php
class Usuario extends Conectar
{
    //TRAE TODOS LOS USUARIO
    public function get_usuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT U.*, R.ROL, E.NOMBRE
        FROM tbl_ms_usuario U
        INNER JOIN tbl_ms_roles R ON U.ID_ROL = R.ID_ROL
        INNER JOIN tbl_ms_estadousuario E ON U.ID_ESTADO_USUARIO = E.ID_ESTADO_USUARIO
        ORDER BY FECHA_CREACION DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UN USUARIO
    public function get_usuario($ID_USUARIO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_ms_usuario WHERE ID_USUARIO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //INSERTA UN USUARIO
    public function insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL, $CREADO_POR, $FECHA_CREACION)

    {
        try {
            
            $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `tbl_ms_usuario` (`USUARIO`, `NOMBRE_USUARIO`, `ID_ESTADO_USUARIO`, `CONTRASENA`, `CORREO_ELECTRONICO`, `ID_ROL`, `CREADO_POR`, `FECHA_CREACION`,`PRIMER_INGRESO`,`PREGUNTAS_CONTESTADAS`,`AUTO_REGISTRO`) 
            VALUES ( :USUARIO, :NOMBRE_USUARIO, :ID_ESTADO_USUARIO, :CONTRASENA, :CORREO_ELECTRONICO, :ID_ROL, :CREADO_POR, :FECHA_CREACION, 1,0,0)";
            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
            $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':CONTRASENA', $contrasenaEncriptada, PDO::PARAM_STR);
            $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
            $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
           
            $stmt->execute(); // Ejecutar la consulta preparada

            if ($stmt->rowCount() > 0) {
                return "Usuario Insertado";
            } else {
                return "Error al insertar el usuario";
            }
        } catch (PDOException $e) {

            return "Error al insertar el usuario: " . $e->getMessage();
        }
    }

    public function update_usuario($ID_USUARIO, $USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL, $MODIFICADO_POR, $FECHA_MODIFICACION)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Construir la consulta SQL
        $sql = "UPDATE `tbl_ms_usuario` 
                SET `USUARIO` = :USUARIO, 
                    `NOMBRE_USUARIO` = :NOMBRE_USUARIO, 
                    `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO, ";

        // Agregar el campo de contraseña solo si se proporciona una nueva contraseña
        if (!empty($CONTRASENA)) {
            $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
            $sql .= "`CONTRASENA` = :CONTRASENA, ";
        }

        $sql .= "`CORREO_ELECTRONICO` = :CORREO_ELECTRONICO, 
                 `ID_ROL` = :ID_ROL,
                 `MODIFICADO_POR` = :MODIFICADO_POR, 
                 `FECHA_MODIFICACION` = :FECHA_MODIFICACION
                WHERE `ID_USUARIO` = :ID_USUARIO";

        // Preparar la consulta
        $stmt = $conectar->prepare($sql);

        // Vincular parámetros
        $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);
        $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
        $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);

        // Si se proporciona una nueva contraseña, vincularla
        if (!empty($CONTRASENA)) {
            $stmt->bindParam(':CONTRASENA', $contrasenaEncriptada, PDO::PARAM_STR);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se realizó la actualización
        if ($stmt->rowCount() > 0) {
            return "Usuario actualizado correctamente";
        } else {
            return "No se realizó ninguna actualización, o el usuario no existe";
        }
    } catch (PDOException $e) {
        return "Error al actualizar el usuario: " . $e->getMessage();
    }
}

    // ELIMINA UN USUARIO
    public function eliminar_usuario($ID_USUARIO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el usuario
            $sql = "DELETE FROM `tbl_ms_usuario` WHERE `ID_USUARIO` = :ID_USUARIO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Usuario eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el usuario no existe";
            }
        } catch (PDOException $e) {
            return  $e->getCode();
        }
    }
}
