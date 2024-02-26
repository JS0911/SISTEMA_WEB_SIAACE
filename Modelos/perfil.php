<?php

require_once '../../Config/conexion.php';

class Perfil
{
    public function obtenerPerfil($id_usuario)
    {
        $sql = "SELECT USUARIO, NOMBRE_USUARIO, CORREO_ELECTRONICO, CONTRASENA FROM tbl_ms_usuario WHERE ID_USUARIO = :id_usuario";
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function obtenerPrimeraPregunta($id_usuario)
    {
        $sql = "SELECT pu.ID_PREGUNTA, p.PREGUNTA, pu.RESPUESTAS FROM tbl_ms_preguntas_usuario as pu INNER JOIN tbl_ms_preguntas as p ON pu.ID_PREGUNTA = p.ID_PREGUNTA WHERE pu.ID_USUARIO = :id_usuario AND pu.ID_PREGUNTA = 1 LIMIT 1"; 
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function obtenerSegundaPregunta($id_usuario)
    {
        $sql = "SELECT pu.ID_PREGUNTA, p.PREGUNTA, pu.RESPUESTAS FROM tbl_ms_preguntas_usuario as pu INNER JOIN tbl_ms_preguntas as p ON pu.ID_PREGUNTA = p.ID_PREGUNTA WHERE pu.ID_USUARIO = :id_usuario LIMIT 1 OFFSET 1"; 
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function obtenerTerceraPregunta($id_usuario)
    {
        $sql = "SELECT pu.ID_PREGUNTA, p.PREGUNTA, pu.RESPUESTAS FROM tbl_ms_preguntas_usuario as pu INNER JOIN tbl_ms_preguntas as p ON pu.ID_PREGUNTA = p.ID_PREGUNTA WHERE pu.ID_USUARIO = :id_usuario LIMIT 1 OFFSET 2"; 
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function actualizarRespuestas($id_usuario, $idPregunta1, $respuesta1, $idPregunta2, $respuesta2, $idPregunta3, $respuesta3)
    {
        $sql = "UPDATE tbl_ms_preguntas_usuario SET RESPUESTAS = :respuesta1 WHERE ID_USUARIO = :id_usuario AND ID_PREGUNTA = :idPregunta1; UPDATE tbl_ms_preguntas_usuario SET RESPUESTAS = :respuesta2 WHERE ID_USUARIO = :id_usuario AND ID_PREGUNTA = :idPregunta2; UPDATE tbl_ms_preguntas_usuario SET RESPUESTAS = :respuesta3 WHERE ID_USUARIO = :id_usuario AND ID_PREGUNTA = :idPregunta3;";
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':idPregunta1', $idPregunta1);
        $stmt->bindParam(':respuesta1', $respuesta1);
        $stmt->bindParam(':idPregunta2', $idPregunta2);
        $stmt->bindParam(':respuesta2', $respuesta2);
        $stmt->bindParam(':idPregunta3', $idPregunta3);
        $stmt->bindParam(':respuesta3', $respuesta3);
        $stmt->execute();
        return $stmt;
    }

    public function actualizarDatos($id_usuario, $correo, $nombreUsuarioP)
    {
        $sql = "UPDATE tbl_ms_usuario SET CORREO_ELECTRONICO = :correo, NOMBRE_USUARIO=:nombreUsuarioP WHERE ID_USUARIO = :id_usuario" ;
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':nombreUsuarioP', $nombreUsuarioP);
        $stmt->execute();
        return $stmt;
    }

    public function cambiarContrasena($id_usuario, $contrasena)
    {
        $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = :contrasena WHERE ID_USUARIO = :id_usuario";
        $conexion = new Conectar();
        $conn = $conexion->Conexion();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
        return $stmt;
    }
}

?>