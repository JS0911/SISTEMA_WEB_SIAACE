<?php
class Prestamo extends Conectar
{
    // TRAE TODAS LOS PRESTAMOS
    public function get_prestamos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_mp_prestamos;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // //TRAE SOLO UN PRESTAMO
    public function get_Prestamo($ID_PRESTAMO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT ID_EMPLEADO,ID_TIPO_PRESTAMO,ID_FPAGO, FECHA_SOLICITUD, FECHA_APROBACION, FECHA_DE_CANCELACION, FECHA_DE_DESEMBOLSO,ESTADO_PRESTAMO,MONTO_SOLICITADO,MONTO_DESEMBOLSO,MONTO_ADEUDADO 
                FROM siaace.tbl_mp_prestamos 
                WHERE ID_PRESTAMO = :ID_PRESTAMO";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $sql->execute();
        //echo $sql;
        // Verificar si se obtuvieron resultados
        if ($sql->rowCount() > 0) {
            // echo "Si se obtuvieron resultados";
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return "No existe ";
        }
    }

    // //INSERTA UN PRESTAMO
    public function insert_prestamo($ID_EMPLEADO, $ID_TIPO_PRESTAMO, $ID_FPAGO, $FECHA_SOLICITUD, $FECHA_APROBACION, $FECHA_DE_CANCELACION, $FECHA_DE_DESEMBOLSO, $ESTADO_PRESTAMO, $MONTO_SOLICITADO, $MONTO_DESEMBOLSO, $MONTO_ADEUDADO)
    {
        try {

            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_mp_prestamos` (`ID_EMPLEADO`, `ID_TIPO_PRESTAMO`, `ID_FPAGO`, `FECHA_SOLICITUD`, `FECHA_APROBACION`, `FECHA_DE_CANCELACION`, `FECHA_DE_DESEMBOLSO`, `ESTADO_PRESTAMO`, `MONTO_SOLICITADO`, `MONTO_DESEMBOLSO`, `MONTO_ADEUDADO`) 
            VALUES (:ID_EMPLEADO, :ID_TIPO_PRESTAMO, :ID_FPAGO, :FECHA_SOLICITUD, :FECHA_APROBACION, :FECHA_DE_CANCELACION, :FECHA_DE_DESEMBOLSO, :ESTADO_PRESTAMO, :MONTO_SOLICITADO, :MONTO_DESEMBOLSO, :MONTO_ADEUDADO)";


            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_STR);
            $stmt->bindParam(':ID_TIPO_PRESTAMO', $ID_TIPO_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_SOLICITUD', $FECHA_SOLICITUD, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_APROBACION', $FECHA_APROBACION, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_DE_CANCELACION', $FECHA_DE_CANCELACION, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_DE_DESEMBOLSO', $FECHA_DE_DESEMBOLSO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO_PRESTAMO', $ESTADO_PRESTAMO, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_DESEMBOLSO', $MONTO_DESEMBOLSO, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_ADEUDADO', $MONTO_ADEUDADO, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Prestamo Insertado";
            } else {
                return "Error al insertar el prestamo";
            }
        } catch (PDOException $e) {

            return "Error al insertar el prestamo: " . $e->getMessage();
        }
    }

    //EDITA UN USUARIO
    public function update_prestamo($ID_PRESTAMO, $ID_FPAGO, $FECHA_DE_CANCELACION, $FECHA_DE_DESEMBOLSO, $ESTADO_PRESTAMO, $MONTO_SOLICITADO, $MONTO_DESEMBOLSO, $MONTO_ADEUDADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del usuario
            $sql = "UPDATE `tbl_mp_prestamos` 
            SET `ID_FPAGO` = :ID_FPAGO, 
                `FECHA_DE_CANCELACION` = :FECHA_DE_CANCELACION, 
                `FECHA_DE_DESEMBOLSO` = :FECHA_DE_DESEMBOLSO, 
                `ESTADO_PRESTAMO` = :ESTADO_PRESTAMO, 
                `MONTO_SOLICITADO` = :MONTO_SOLICITADO, 
                `MONTO_DESEMBOLSO` = :MONTO_DESEMBOLSO,  
                `MONTO_ADEUDADO` = :MONTO_ADEUDADO 
            WHERE `ID_PRESTAMO` = :ID_PRESTAMO";


            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_DE_CANCELACION', $FECHA_DE_CANCELACION, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_DE_DESEMBOLSO', $FECHA_DE_DESEMBOLSO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO_PRESTAMO', $ESTADO_PRESTAMO, PDO::PARAM_STR);
            $stmt->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_DESEMBOLSO', $MONTO_DESEMBOLSO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_ADEUDADO', $MONTO_ADEUDADO, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Prestamo actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el prestamo no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el prestamo: " . $e->getMessage();
        }
    }

    // // ELIMINA UN USUARIO
    // public function eliminar_usuario($ID_USUARIO)
    // {
    //     try {
    //         $conectar = parent::conexion();
    //         parent::set_names();
    //         // Consulta SQL para eliminar el usuario
    //         $sql = "DELETE FROM `tbl_ms_usuario` WHERE `ID_USUARIO` = :ID_USUARIO";
    //         $stmt = $conectar->prepare($sql);
    //         $stmt->bindParam(':ID_USUARIO', $ID_USUARIO, PDO::PARAM_INT);
    //         $stmt->execute();
    //         if ($stmt->rowCount() > 0) {
    //             return "Usuario eliminado correctamente";
    //         } else {
    //             return "No se realizó ninguna eliminación, o el usuario no existe";
    //         }
    //     } catch (PDOException $e) {
    //         return  $e->getCode();
    //     }
    // }
}
