<?php
    require_once "../Config/conexion.php";
	session_start();
    $date = new DateTime(date("Y-m-d H:i:s"));
    $dateMod = $date->modify("-7 hours");
    $dateNew = $dateMod->format("Y-m-d H:i:s"); 

	$conexion = new Conectar();
	$conectar = $conexion->Conexion();
    $conexion->set_names();
    $sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ACCION`, `DESCRIPCION`, `ID_USUARIO`, `ID_OBJETO`, `CREADO_POR`, `FECHA_CREACION`) VALUES ('$dateNew', 'CIERRE DE SESION', 'CERRO SESION EL USUARIO: " . $_SESSION['usuario'] ."', '" . $_SESSION['id_usuario'] . "', 14, '" . $_SESSION['usuario'] . "' , '$dateNew')";
    //$sql = "INSERT INTO `siaace`.`tbl_ms_bitacora` (`FECHA`, `ACCION`, `DESCRIPCION`, `ID_USUARIO`, `ID_OBJETO`, `CREADO_POR`, `FECHA_CREACION`) VALUES ('$dateNew', 'CIERRE DE SESION', 'CERRO SESION EL USUARIO: " . $_SESSION['usuario'] ."', '" . $_SESSION['id_usuario'] . "', 33, '" . $_SESSION['usuario'] . "' , '$dateNew')";
    $stmt = $conectar->prepare($sql);
    $stmt->execute();
	session_destroy();
	header("Location: inicio.html");
    exit();
?>