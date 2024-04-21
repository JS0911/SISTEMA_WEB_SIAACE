<?php

require_once '../../Modelos/perfil.php';

function obtenerPerfil($id_usuario)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->obtenerPerfil($id_usuario);
    return $row;
}

function obtenerPrimeraPregunta($id_usuario)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->obtenerPrimeraPregunta($id_usuario);
    return $row;
}

function obtenerSegundaPregunta($id_usuario)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->obtenerSegundaPregunta($id_usuario);
    return $row;
}

function obtenerTerceraPregunta($id_usuario)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->obtenerTerceraPregunta($id_usuario);
    return $row;
}

function actualizarRespuestas($id_usuario, $idPregunta1, $respuesta1, $idPregunta2, $respuesta2, $idPregunta3, $respuesta3)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->actualizarRespuestas($id_usuario, $idPregunta1, $respuesta1, $idPregunta2, $respuesta2, $idPregunta3, $respuesta3);
    return $row;
}

function actualizarDatos($id_usuario, $correo)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->actualizarDatos($id_usuario, $correo);
}

function cambiarContrasena($id_usuario, $contrasena)
{
    $modeloPerfil = new Perfil();
    $row = $modeloPerfil->cambiarContrasena($id_usuario, $contrasena);
    return $row;
}

?>