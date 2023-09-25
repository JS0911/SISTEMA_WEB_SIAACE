<?php
class Usuario extends Conectar
{
    public function get_usuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_usuario;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_usuarios($USUARIO, $NOMBRE_USUARIO, $ID_ESTADO_USUARIO, $CONTRASENA, $CORREO_ELECTRONICO, $ID_ROL)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_usuario` (`USUARIO`, `NOMBRE_USUARIO`, `ID_ESTADO_USUARIO`, `CONTRASENA`, `CORREO_ELECTRONICO`, `ID_ROL`) VALUES ( :USUARIO, :NOMBRE_USUARIO, :ID_ESTADO_USUARIO, :CONTRASENA, :CORREO_ELECTRONICO, :ID_ROL)";

        // Preparar la consulta
        $stmt = $conectar->prepare($sql);

        // Asignar valores a los parámetros
        $stmt->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':NOMBRE_USUARIO', $NOMBRE_USUARIO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':CONTRASENA', $CONTRASENA, PDO::PARAM_STR);
        $stmt->bindParam(':CORREO_ELECTRONICO', $CORREO_ELECTRONICO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ROL', $ID_ROL, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si la inserción se realizó correctamente
        if ($stmt->rowCount() > 0) {
            return "Usuario Insertado";
        } else {
            return "Error al insertar el usuario"; // Cambia este mensaje según tus necesidades
        }
    } catch (PDOException $e) {
        // En caso de error, puedes registrar el error o devolver un mensaje de error personalizado
        return "Error al insertar el usuario: " . $e->getMessage();
    }
}

    
    
}