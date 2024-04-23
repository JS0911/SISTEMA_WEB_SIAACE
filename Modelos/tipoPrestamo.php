<?php
class TipoPrestamo extends Conectar
{
    // TRAE TODOS LAS SUCURSALES
    public function get_tipoprestamos() 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mp_tipo_prestamo ORDER BY FECHA_CREACION DESC;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // TRAE SOLO UN SUCURSAL
    public function get_tipoprestamo($ID_TIPO_PRESTAMO) 
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mp_tipo_prestamo WHERE ID_TIPO_PRESTAMO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_TIPO_PRESTAMO, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
    // INSERTA 
    public function insert_tipoprestamo($TIPO_PRESTAMO, $DESCRIPCION, $APLICA_SEGUROS, $MONTO_MAXIMO, $MONTO_MINIMO, $TASA_MAXIMA, $TASA_MINIMA, $PLAZO_MAXIMO, $PLAZO_MINIMO, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $fecha_actual = date("Y-m-d");
            // Convertir el valor de APLICA_SEGUROS a 0 o 1
            $aplica_seguros_db = ($APLICA_SEGUROS === "Sí") ? 1 : 0;
            $sql = "INSERT INTO `tbl_mp_tipo_prestamo` ( `TIPO_PRESTAMO`, `DESCRIPCION`, `APLICA_SEGUROS`, `MONTO_MAXIMO`, `MONTO_MINIMO`, `TASA_MAXIMA`, `TASA_MINIMA`, `PLAZO_MAXIMO`, `PLAZO_MINIMO` ,`ESTADO` , `FECHA_CREACION`) VALUES ( :TIPO_PRESTAMO,:DESCRIPCION, :APLICA_SEGUROS, :MONTO_MAXIMO, :MONTO_MINIMO, :TASA_MAXIMA,:TASA_MINIMA, :PLAZO_MAXIMO, :PLAZO_MINIMO, :ESTADO,:FECHA_CREACION)";
    
            $stmt = $conectar->prepare($sql);
    
            $stmt->bindParam(':TIPO_PRESTAMO', $TIPO_PRESTAMO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            // Usar el valor convertido para APLICA_SEGUROS
            $stmt->bindParam(':APLICA_SEGUROS', $aplica_seguros_db, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_MAXIMO', $MONTO_MAXIMO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_MINIMO', $MONTO_MINIMO, PDO::PARAM_INT);
            $stmt->bindParam(':TASA_MAXIMA', $TASA_MAXIMA, PDO::PARAM_INT);
            $stmt->bindParam(':TASA_MINIMA', $TASA_MINIMA, PDO::PARAM_INT);
            $stmt->bindParam(':PLAZO_MAXIMO', $PLAZO_MAXIMO, PDO::PARAM_INT);
            $stmt->bindParam(':PLAZO_MINIMO', $PLAZO_MINIMO, PDO::PARAM_INT);
    
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $fecha_actual, PDO::PARAM_STR);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Tipo Prestamo Insertado";
            } else {
                return "Error al insertar el Tipo Prestamo ";
            }
        } catch (PDOException $e) {
            return "Error al insertar el Tipo prestamo " . $e->getMessage();
        }
    }
    

    // EDITA 
    public function update_tipoprestamo($ID_TIPO_PRESTAMO,$TIPO_PRESTAMO, $DESCRIPCION, $APLICA_SEGUROS, $MONTO_MAXIMO, $MONTO_MINIMO, $TASA_MAXIMA, $TASA_MINIMA, $PLAZO_MAXIMO,$PLAZO_MINIMO, $ESTADO ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $FECHA_MODIFICACION = date("Y-m-d");
    
            // Consulta SQL para actualizar los campos de la sucursal
            $sql = "UPDATE `tbl_mp_tipo_prestamo` 
                    SET `TIPO_PRESTAMO` = :TIPO_PRESTAMO, 
                        `DESCRIPCION` = :DESCRIPCION, 
                        `APLICA_SEGUROS` = :APLICA_SEGUROS,
                        `MONTO_MAXIMO` = :MONTO_MAXIMO,
                        `MONTO_MINIMO` = :MONTO_MINIMO,
                        `TASA_MAXIMA` = :TASA_MAXIMA, 
                        `TASA_MINIMA` = :TASA_MINIMA,
                        `PLAZO_MAXIMO` = :PLAZO_MAXIMO,
                        `PLAZO_MINIMO` = :PLAZO_MINIMO,
                        `ESTADO` = :ESTADO,
                        `FECHA_MODIFICACION` = :FECHA_MODIFICACION
                    WHERE `ID_TIPO_PRESTAMO` = :ID_TIPO_PRESTAMO";
    
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_TIPO_PRESTAMO', $ID_TIPO_PRESTAMO, PDO::PARAM_STR);
            $stmt->bindParam(':TIPO_PRESTAMO', $TIPO_PRESTAMO, PDO::PARAM_STR);
            $stmt->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt->bindParam(':APLICA_SEGUROS', $APLICA_SEGUROS, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_MAXIMO', $MONTO_MAXIMO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_MINIMO', $MONTO_MINIMO, PDO::PARAM_INT);
            $stmt->bindParam(':TASA_MAXIMA', $TASA_MAXIMA, PDO::PARAM_INT);
            $stmt->bindParam(':TASA_MINIMA', $TASA_MINIMA, PDO::PARAM_INT);
            $stmt->bindParam(':PLAZO_MAXIMO', $PLAZO_MAXIMO, PDO::PARAM_INT);
            $stmt->bindParam(':PLAZO_MINIMO', $PLAZO_MINIMO, PDO::PARAM_INT);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Tipo Prestamo actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el Tipo Prestamo no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el Tipo Prestamo: " . $e->getMessage();
        }
    }
    
    // ELIMINA 
    public function eliminar_tipoprestamo($ID_TIPO_PRESTAMO) {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el tipo prestamo
            $sql = "DELETE FROM `tbl_mp_tipo_prestamo` WHERE `ID_TIPO_PRESTAMO` = :ID_TIPO_PRESTAMO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_TIPO_PRESTAMO', $ID_TIPO_PRESTAMO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Tipo Prestamo eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el tipo prestamo no existe";
            }
        } catch (PDOException $e) {
            return "Error al eliminar el tipo prestamo: " . $e->getMessage();
        }
    }
}
?>
