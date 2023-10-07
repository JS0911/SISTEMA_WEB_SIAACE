<?php
class preguntas extends Conectar
{
    //TRAE TODAS LAS PREGUNTAS
    public function get_preguntas() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_preguntas;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_respuesta($ID_PREGUNTA,$ID_USUARIO,$RESPUESTAS) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_preguntas_usuario` (`ID_PREGUNTA`, `ID_USUARIO`, `RESPUESTAS`) VALUES (:ID_PREGUNTA, :ID_USUARIO, :RESPUESTA);";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}