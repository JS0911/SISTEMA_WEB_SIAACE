<?php
class Historial extends Conectar
{
    public function get_historial() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT H.CONTRASENA, U.USUARIO, H.FECHA_MODIFICACION FROM siaace.tbl_ms_historial_contrasena as H join tbl_ms_usuario as U on H.ID_USUARIO = U.ID_USUARIO;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert_historial($CONTRASENA, $ID_USUARIO, $FECHA_MODIFICACION)
    {
        try
        {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_historial_contrasena` (`CONTRASENA`, `ID_USUARIO`, `FECHA_MODIFICACION`) VALUES (:CONTRASENA, :ID_USUARIO, :FECHA_MODIFICACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':CONTRASENA', $CONTRASENA, PDO::PARAM_STR);
            $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                return "Cambio de la contrañesa Insertada en Historial";
            }
            else
            {
                return "Error al insertar el cambio en el Historial";
            }
        } catch(PDOException $e)
        {
            return "Error al insertar cambio en historial: " . $e->getMessage();
        }
    }
}
