<?php
class bitacora extends Conectar
{

public function get_bitacora() 
{
    $conectar = parent::Conexion();
    parent::set_names();
    $sql = "SELECT b.FECHA, b.ACCION, b.DESCRIPCION, u.NOMBRE_USUARIO, o.OBJETO 
    FROM siaace.tbl_ms_bitacora AS b 
    JOIN siaace.tbl_ms_usuario AS u ON b.ID_USUARIO = u.ID_USUARIO 
    LEFT JOIN siaace.tbl_ms_objetos AS o ON b.ID_OBJETO = o.ID_OBJETO;";
    
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
}
public function insert_bitacora($FECHA, $ACCION, $DESCRIPCION, $ID_USUARIO, $ID_OBJETO, $CREADO_POR, $FECHA_CREACION)
{
    try
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ACCION`, `DESCRIPCION`, `ID_USUARIO`, `ID_OBJETO`, `CREADO_POR`, `FECHA_CREACION`) VALUES (:FECHA, :ACCION, :DESCRIPCION, :ID_USUARIO, :ID_OBJETO, :CREADO_POR, :FECHA_CREACION)";

        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
        $stmt->bindParam(':ACCION', $ACCION, PDO::PARAM_STR);
        $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
        $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
        $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
        $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return "Bitacora Insertada";
        }
        else
        {
            return "Error al insertar la Bitacora";
        }
    } catch(PDOException $e)
    {
        return "Error al insertar la bitacora: " . $e->getMessage();
    }
}

public function insert_bitacoraModificacion($FECHA, $ACCION, $DESCRIPCION, $ID_USUARIO, $ID_OBJETO, $MODIFICADO_POR, $FECHA_MODIFICACION)
{
    try
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ACCION`, `DESCRIPCION`, `ID_USUARIO`, `ID_OBJETO`, `MODIFICADO_POR`, `FECHA_MODIFICACION`) VALUES (:FECHA, :ACCION, :DESCRIPCION, :ID_USUARIO, :ID_OBJETO, :MODIFICADO_POR, :FECHA_MODIFICACION)";

        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
        $stmt->bindParam(':ACCION', $ACCION, PDO::PARAM_STR);
        $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
        $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
        $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
        $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return "Bitacora Insertada";
        }
        else
        {
            return "Error al insertar la Bitacora";
        }
    } catch(PDOException $e)
    {
        return "Error al insertar la bitacora: " . $e->getMessage();
    }
}

public function insert_bitacoraEliminar($FECHA, $ACCION, $DESCRIPCION, $ID_USUARIO, $ID_OBJETO)
{
    try
    {
        $conectar = parent::Conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ACCION`, `DESCRIPCION`, `ID_USUARIO`, `ID_OBJETO`) VALUES (:FECHA, :ACCION, :DESCRIPCION, :ID_USUARIO, :ID_OBJETO)";

        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':FECHA', $FECHA, PDO::PARAM_STR);
        $stmt->bindParam(':ACCION', $ACCION, PDO::PARAM_STR);
        $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
        $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':ID_OBJETO', $ID_OBJETO, PDO::PARAM_INT);
        
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return "Bitacora Insertada";
        }
        else
        {
            return "Error al insertar la Bitacora";
        }
    } catch(PDOException $e)
    {
        return "Error al insertar la bitacora: " . $e->getMessage();
    }
}

}
