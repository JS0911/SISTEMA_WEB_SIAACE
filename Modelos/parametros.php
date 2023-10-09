<?php
class Parametro extends Conectar
{
    //TRAE TODOS LOS PARAMETROS
    public function get_parametros() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_ms_parametros;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UN PARAMETRO
    public function get_parametro($ID_PARAMETRO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_ms_parametros WHERE ID_PARAMETRO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_PARAMETRO, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    //INSERTA UN PARAMETRO
    public function insert_parametros($PARAMETRO, $VALOR/* , $ID_USUARIO, $CREADO_POR, $MODIFICADO_POR  *//*, $FECHA_CREACION, $FECHA_MODIFICACION */) {
    try {
        // $contrasenaEncriptada = password_hash($CONTRASENA, PASSWORD_DEFAULT);
        // //echo $contrasenaEncriptada;
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `siaace`.`tbl_ms_parametros` (`PARAMETRO`, `VALOR`/* , `ID_USUARIO`, `CREADO_POR`, `MODIFICADO_POR` *//* , `FECHA_CREACION`,  `FECHA_MODIFICACION` */) VALUES ( :PARAMETRO, :VALOR/* , :ID_USUARIO, :CREADO_POR, :MODIFICADO_POR *//* , :FECHA_CREACION,:FECHA_MODIFICACION */ )";

        $stmt = $conectar->prepare($sql);
      
        $stmt->bindParam(':PARAMETRO', $PARAMETRO, PDO::PARAM_STR);
        $stmt->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
        // $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
        // $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
        // $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
        // $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
        // $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Parametro Insertado";
        } else {
            return "Error al insertar el parametro"; 
        }
    } catch (PDOException $e) {
       
        return "Error al insertar el parametro: " . $e->getMessage();
    }
    }

    //EDITA UN PARAMETRO
    public function update_parametro($ID_PARAMETRO,$PARAMETRO, $VALOR/* , $ID_USUARIO, $CREADO_POR, $MODIFICADO_POR *//* , $FECHA_CREACION, $FECHA_MODIFICACION */) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
    
            // Consulta SQL para actualizar los campos del parametro
            $sql = "UPDATE `tbl_ms_parametros` 
                    SET `PARAMETRO` = :PARAMETRO, 
                        `VALOR` = :VALOR 
/*                         `ID_USUARIO` = :ID_USUARIO, 
                        `CREADO_POR` = :CREADO_POR, 
                        `MODIFICADO_POR` = :MODIFICADO_POR  */
/*                         `FECHA_CREACION` = :FECHA_CREACION, 
                        `FECHA_MODIFICACION` = :FECHA_MODIFICACION,  */

                    WHERE `ID_PARAMETRO` = :ID_PARAMETRO";
    
            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_PARAMETRO', $ID_PARAMETRO, PDO::PARAM_INT);
            $stmt->bindParam(':PARAMETRO', $PARAMETRO, PDO::PARAM_STR);
            $stmt->bindParam(':VALOR', $VALOR, PDO::PARAM_STR);
/*             $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR); */
/*             $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR); */
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Parametro actualizado correctamente modelo";
            } else {
                return "No se realizó ninguna actualización, o el parametro no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el parametro: " . $e->getMessage();
        }
    }
    
    // ELIMINA UN PARAMETRO
public function eliminar_parametro($ID_PARAMETRO) {
    try {
        $conectar = parent::conexion();
        parent::set_names();
        // Consulta SQL para eliminar el parametro
        $sql = "DELETE FROM `tbl_ms_parametros` WHERE `ID_PARAMETRO` = :ID_PARAMETRO";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_PARAMETRO', $ID_PARAMETRO, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return "Parametro eliminado correctamente";
        } else {
            return "No se realizó ninguna eliminación, o el Parametro no existe";
        }
    } catch (PDOException $e) {
        return "Error al eliminar el Parametro: " . $e->getMessage();
    }
}

  
}