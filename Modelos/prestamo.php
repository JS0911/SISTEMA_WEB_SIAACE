<?php
class Prestamo extends Conectar
{
    // TRAE TODAS LOS PRESTAMOS
    public function get_prestamos()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT P.*, T.TIPO_PRESTAMO, F.FORMA_DE_PAGO, E.PRIMER_NOMBRE, E.PRIMER_APELLIDO
        FROM siaace.tbl_mp_prestamos AS P
        INNER JOIN siaace.tbl_mp_tipo_prestamo AS T ON P.ID_TIPO_PRESTAMO = T.ID_TIPO_PRESTAMO
        INNER JOIN siaace.tbl_me_empleados AS E ON P.ID_EMPLEADO = E.ID_EMPLEADO
        INNER JOIN siaace.tbl_formapago AS F ON P.ID_FPAGO = F.ID_FPAGO";

        $sql = $conectar->prepare($sql);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function SaldoTotal($ID_PRESTAMO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT SUM((MONTO_ADEUDADO_ITS) + (MONTO_ADEUDADO_CAP)) AS SALDO_TOTAL
                FROM siaace.tbl_mp_planp 
                WHERE ID_PRESTAMO = :ID_PRESTAMO";

        $sql = $conectar->prepare($sql);
        $sql->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    // //TRAE SOLO UN PRESTAMO
    public function get_Prestamo($ID_EMPLEADO)
    {
        $conectar = parent::conexion();
        parent::set_names();


        $sql = "SELECT P.*, T.TIPO_PRESTAMO, F.FORMA_DE_PAGO
        FROM siaace.tbl_mp_prestamos AS P
        INNER JOIN siaace.tbl_mp_tipo_prestamo AS T ON P.ID_TIPO_PRESTAMO = T.ID_TIPO_PRESTAMO
        INNER JOIN siaace.tbl_formapago AS F ON P.ID_FPAGO = F.ID_FPAGO 
                WHERE ID_EMPLEADO = :ID_EMPLEADO";
        $sql = $conectar->prepare($sql);
        $sql->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
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
    public function insert_prestamo($ID_EMPLEADO, $ID_TIPO_PRESTAMO, $ID_FPAGO, $TASA, $PLAZO, $MONTO_SOLICITADO, $ESTADO_PRESTAMO)
    {
        try {

            $conectar = parent::conexion();
            parent::set_names();
            $ESTADO_PRESTAMO = "PENDIENTE";
            $sql = "INSERT INTO `siaace`.`tbl_mp_prestamos` ( `ID_EMPLEADO`, `ID_TIPO_PRESTAMO`, `ID_FPAGO`, `PLAZO`, `TASA`, `MONTO_SOLICITADO`, `FECHA_SOLICITUD`, `ESTADO_PRESTAMO`) 
            VALUES ( :ID_EMPLEADO, :ID_TIPO_PRESTAMO, :ID_FPAGO, :PLAZO, :TASA, :MONTO_SOLICITADO, NOW(), :ESTADO_PRESTAMO)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_TIPO_PRESTAMO', $ID_TIPO_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_FPAGO', $ID_FPAGO, PDO::PARAM_INT);
            $stmt->bindParam(':PLAZO', $PLAZO, PDO::PARAM_INT);
            $stmt->bindParam(':TASA', $TASA, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO_PRESTAMO', $ESTADO_PRESTAMO, PDO::PARAM_STR);

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

    public function anular_prestamo($ID_PRESTAMO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");

            // Consulta SQL para actualizar el estado del préstamo a "Anulado" y la fecha de cancelación
            $sql = "UPDATE `tbl_mp_prestamos` SET `ESTADO_PRESTAMO` = 'ANULADO', `FECHA_DE_CANCELACION` = :FECHA_DE_CANCELACION WHERE `ID_PRESTAMO` = :ID_PRESTAMO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_DE_CANCELACION', $dateNew, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('message' => 'Préstamo anulado correctamente'));
            } else {
                echo json_encode(array('message' => 'No se realizó ninguna anulación, o el préstamo no existe'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
        }
    }
    public function aprobar_prestamo($ID_PRESTAMO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");

            // Consulta SQL para actualizar el estado del préstamo a "Aprobado" y la fecha de aprobación
            $sql = "UPDATE `tbl_mp_prestamos` SET `ESTADO_PRESTAMO` = 'APROBADO', `FECHA_APROBACION` = :FECHA_APROBACION WHERE `ID_PRESTAMO` = :ID_PRESTAMO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_APROBACION', $dateNew, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('message' => 'Préstamo aprobado correctamente'));
            } else {
                echo json_encode(array('message' => 'No se realizó ninguna aprobación, o el préstamo no existe'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
        }
    }
    public function desembolso_prestamo($ID_PRESTAMO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");

            // Consulta SQL para actualizar la fecha de desembolso
            $sql = "UPDATE `tbl_mp_prestamos` SET `FECHA_DE_DESEMBOLSO` = :FECHA_DE_DESEMBOLSO WHERE `ID_PRESTAMO` = :ID_PRESTAMO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_DE_DESEMBOLSO', $dateNew, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('message' => 'Desembolso realizado correctamente'));
            } else {
                echo json_encode(array('message' => 'No se realizó ningun desembolso, o el préstamo no existe'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
        }
    }
    public function obtenerEstadoPrestamo($ID_PRESTAMO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SELECT para obtener el estado del préstamo
            $select_sql = "SELECT `ESTADO_PRESTAMO` FROM `tbl_mp_prestamos` WHERE `ID_PRESTAMO` = :ID_PRESTAMO";
            $stmt_select = $conectar->prepare($select_sql);
            $stmt_select->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt_select->execute();

            // Obtener el resultado como un array asociativo
            $resultado = $stmt_select->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                // Devolver el estado del préstamo
                return $resultado['ESTADO_PRESTAMO'];
            } else {
                // El préstamo no se encontró o no existe
                return "NO ENCONTRADO";
            }
        } catch (PDOException $e) {
            return "Error al Consultar el Estado de Prestamo: " . $e->getMessage();
        }
    }


    public function validarMonto($ID_EMPLEADO, $MONTO_SOLICITADO)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Obtener el salario
        $sql = "SELECT `SALARIO` FROM `tbl_me_empleados` WHERE `ID_EMPLEADO` = :ID_EMPLEADO";
        $sql2 = "SELECT `SALDO` FROM `tbl_mc_cuenta` WHERE `ID_EMPLEADO` = :ID_EMPLEADO";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
        //$stmt->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_STR);
        $stmt->execute();
       // $resultSalario = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt2 = $conectar->prepare($sql2);
        $stmt2->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
       // $stmt2->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_STR);
        $stmt2->execute();
        //$resultAhorro = $stmt2->fetch(PDO::FETCH_ASSOC);

       // return "Saldo:" . $resultAhorro ;
        if (!$stmt || !$stmt2) {
            return "No se encontró el salario o el saldo del empleado.";
        }

        $salario = $stmt['SALARIO'];
        $ahorro = $stmt2['SALDO'];

        $montoMinimo = ($ahorro * 3) + ($salario / 2);

        if ($MONTO_SOLICITADO <= $montoMinimo) {
            return "MONTO CALCULADO: " . $montoMinimo . "\nMONTO SOLICITADO: " . $MONTO_SOLICITADO;
        } else {
            return "El monto solicitado no debe exceder de " . $montoMinimo;
        }
    } catch (PDOException $e) {
        return "Error al Consultar: " . $e->getMessage();
    }
}

}
