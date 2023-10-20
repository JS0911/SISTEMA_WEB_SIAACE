<?php
class bitacora extends Conectar
{

public function get_bitacora() 
{
    $conectar = parent::conexion();
    parent::set_names();
    $sql = "SELECT * FROM siaace.tbl_ms_bitacora;";
    $sql = $conectar->prepare($sql);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
}


}
?>