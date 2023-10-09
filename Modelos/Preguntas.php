<?php
class preguntas extends Conectar
{
    //TRAE TODAS LAS PREGUNTAS
    public function get_preguntas($ID_USUARIO) 
    {

        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT P.*
        FROM tbl_ms_preguntas P
        LEFT JOIN tbl_ms_preguntas_usuario PU
        ON P.ID_PREGUNTA = PU.ID_PREGUNTA
        AND PU.ID_USUARIO = $ID_USUARIO
        WHERE PU.ID_PREGUNTA IS NULL;";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        
        $Lista_preguntas = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $Lista_preguntas;
        
        
    }

    public function insert_respuesta($ID_PREGUNTA,$ID_USUARIO,$RESPUESTAS) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_preguntas_usuario` (`ID_PREGUNTA`, `ID_USUARIO`, `RESPUESTAS`) VALUES (:ID_PREGUNTA, :ID_USUARIO, :RESPUESTAS);";
        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':ID_PREGUNTA', $ID_PREGUNTA, PDO::PARAM_INT);
        $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        $stmt->bindParam(':RESPUESTAS', $RESPUESTAS, PDO::PARAM_STR);

        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ContarPreguntas($ID_USUARIO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "UPDATE `siaace`.`tbl_ms_usuario`
        SET `PREGUNTAS_CONTESTADAS` = `PREGUNTAS_CONTESTADAS` + 1
        WHERE `ID_USUARIO` = $ID_USUARIO;";

        $stmt = $conectar->prepare($sql);

        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}