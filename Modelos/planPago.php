<?php


class PlanPago extends Conectar


{

    public function insert_amortizacion(
        $ID_PRESTAMO,
        $FECHA_VENC_C,
        $NUMERO_CUOTA,
        $FECHA_R_PAGO,
        $VALOR_CUOTA,
        $MONTO_ADEUDADO,
        $MONTO_PAGADO,
        $MONTO_ADEUDADO_CAP,
        $MONTO_PAGADO_CAP,
        $MONTO_ADEUDADO_ITS,
        $MONTO_PAGADO_ITS,
        $MONTO_ADEUDADO_MORA,
        $MONTO_PAGADO_MORA,
        $ESTADO
    ) {
        

        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {
            // Consulta SQL para realizar el INSERT
            $sql = "INSERT INTO  `siaace`.`tbl_mp_planp` (
                ID_PRESTAMO,
                FECHA_VENC_C,
                NUMERO_CUOTA,
                FECHA_R_PAGO,
                VALOR_CUOTA,
                MONTO_ADEUDADO,
                MONTO_PAGADO,
                MONTO_ADEUDADO_CAP,
                MONTO_PAGADO_CAP,
                MONTO_ADEUDADO_ITS,
                MONTO_PAGADO_ITS,
                MONTO_ADEUDADO_MORA,
                MONTO_PAGADO_MORA,
                ESTADO
            ) VALUES (
                :ID_PRESTAMO,
                :FECHA_VENC_C,
                :NUMERO_CUOTA,
                :FECHA_R_PAGO,
                :VALOR_CUOTA,
                :MONTO_ADEUDADO,
                :MONTO_PAGADO,
                :MONTO_ADEUDADO_CAP,
                :MONTO_PAGADO_CAP,
                :MONTO_ADEUDADO_ITS,
                :MONTO_PAGADO_ITS,
                :MONTO_ADEUDADO_MORA,
                :MONTO_PAGADO_MORA,
                :ESTADO
            )";

            // Preparar la consulta
            $stmt = $conectar->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_VENC_C', $FECHA_VENC_C, PDO::PARAM_STR);
            $stmt->bindParam(':NUMERO_CUOTA', $NUMERO_CUOTA, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_R_PAGO', $FECHA_R_PAGO, PDO::PARAM_STR);
            $stmt->bindParam(':VALOR_CUOTA', $VALOR_CUOTA, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_ADEUDADO', $MONTO_ADEUDADO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_PAGADO', $MONTO_PAGADO, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_ADEUDADO_CAP', $MONTO_ADEUDADO_CAP, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_PAGADO_CAP', $MONTO_PAGADO_CAP, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_ADEUDADO_ITS', $MONTO_ADEUDADO_ITS, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_PAGADO_ITS', $MONTO_PAGADO_ITS, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_ADEUDADO_MORA', $MONTO_ADEUDADO_MORA, PDO::PARAM_INT);
            $stmt->bindParam(':MONTO_PAGADO_MORA', $MONTO_PAGADO_MORA, PDO::PARAM_INT);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);



            // Ejecutar la consulta
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Amortizacion Insertada";
            } else {
                return "Error al insertar la amortizacion";
            }
        } catch (PDOException $e) {

            return "Error al insertar la amortizacion: " . $e->getMessage();
        }
    }

    /* function pago($tasa, $nper, $va)
    {
        try {
            if (!is_numeric($tasa) || !is_numeric($nper) || !is_numeric($va)) {
                throw new Exception("Los parámetros deben ser numéricos.");
            }

            $vp = $va * pow(1 + $tasa, -$nper);
            $f_desc = 1 / (1 - pow(1 + $tasa, -$nper));

            return number_format($vp * $f_desc, 2);
        } catch (Exception $e) {
            echo json_encode(array('error' => $e->getMessage()));
        }
    } */
}
