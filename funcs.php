<?php
 function isNull ($nombre,$usuario,$email,$contrasena,$confirmContrasena){
    if(strlen(trim($nombre))<1 || strlen(trim($usuario))<1 ||strlen(trim($email))<1 ||
    strlen(trim($contrasena))<1 || strlen(trim($confirmContrasena))<1){
       return true; 
    }else{
        return false;
    }
 }
 function isEmail($email){
    if (filter_var($email,FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
 }

 function validarContrasena($var1, $var2){
    if (strcmp($var1,$var2)!==0){
        return true;
    }else{
        return false;
    }
 }

 function usuarioExiste($usuario) {
    global $mysqli;


    $stmt = $conectar->prepare("SELECT id_usuario FROM tbl_ms_usuario WHERE usuario=? LIMIT 1");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close(); 
    if($num>0){
        return true;
    }else{
        return false;
    }
}


 function emailExiste($email){
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id_usuario FROM tbl_ms_usuario WHERE correo_electronico=?  LIMIT 1 ");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    $num=$stmt-> num_rows;
    $stmt->close();

    if($num>0){
        return true;
    }else{
        return false;
    }
 }

 function registraUsuario($nombre, $usuario, $email, $contrasena, $estado_usuario, $rol) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO tbl_ms_usuario(USUARIO, NOMBRE_USUARIO, ID_ESTADO_USUARIO, CONTRASENA, CORREO_ELECTRONICO, ID_ROL,FECHA_CREACION) VALUES (?, ?, ?, ?, ?, ?,NOW())");
    $stmt->bind_param('ssissi', $usuario, $nombre, $estado_usuario, $contrasena, $email, $rol);

    if ($stmt->execute()) {
        return $mysqli->insert_id;
    } else {
        return 0;
    }
}




 function resultBlock($errors) {
    if (count($errors) > 0) {
        echo "<div id='error' class='alert alert-danger' role='alert'>
        <a href='#' onclick=\"showHide('error');\"> [X]</a>
        <ul>";
        foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul>";
        echo "</div>"; // Se agregó una comilla simple antes de </div>
    }
}

?>