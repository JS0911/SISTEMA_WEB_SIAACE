<?php
class Errores extends Conectar
{
    public function get_error() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_error;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert_error($ERROR, $CODIGO, $MENSAJE)
    {
        try
        {
            $conectar = parent::Conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_ms_error` (`ERROR`, `CODIGO`, `MENSAJE`) VALUES (:ERROR, :CODIGO, :MENSAJE)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ERROR', $ERROR, PDO::PARAM_STR);
            $stmt->bindParam(':CODIGO', $CODIGO, PDO::PARAM_STR);
            $stmt->bindParam(':MENSAJE', $MENSAJE, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                return "Error Insertado";
            }
            else
            {
                return "Error al insertar";
            }
        } catch(PDOException $e)
        {
            return "Error al insertar: " . $e->getMessage();
        }
    }
}
