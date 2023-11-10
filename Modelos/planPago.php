<?php


class PlanPago extends Conectar

{

    public function get_planPago()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "        SELECT
        planp.ID_PLANP,
        planp.ID_PRESTAMO,
        tipo_prestamo.TIPO_PRESTAMO,
        prestamo.TASA,
        prestamo.PLAZO,
        planp.FECHA_VENC_C,
        planp.NUMERO_CUOTA,
        planp.FECHA_R_PAGO,
        planp.VALOR_CUOTA,
        planp.MONTO_ADEUDADO,
        planp.MONTO_PAGADO,
        planp.MONTO_ADEUDADO_CAP,
        planp.MONTO_PAGADO_CAP,
        planp.MONTO_ADEUDADO_ITS,
        planp.MONTO_PAGADO_ITS,
        planp.MONTO_ADEUDADO_MORA,
        planp.MONTO_PAGADO_MORA,
        planp.ESTADO
       
    FROM
        tbl_mp_planp AS planp
    INNER JOIN
        tbl_mp_prestamos AS prestamo ON planp.ID_PRESTAMO = prestamo.ID_PRESTAMO
    INNER JOIN
        tbl_mp_tipo_prestamo AS tipo_prestamo ON prestamo.ID_TIPO_PRESTAMO = tipo_prestamo.ID_TIPO_PRESTAMO;
    
          ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function calcularCuota($TASA, $PLAZO, $MONTO_SOLICITADO, $PLAZOQUINCENAS)
    {
        try {
            if (!is_numeric($TASA) || !is_numeric($PLAZO) || !is_numeric($MONTO_SOLICITADO)) {
                throw new Exception("Los parámetros deben ser numéricos.");
            }

            // Calcular la cuota usando la fórmula PMT
            $tasaPeriodica = floatval($TASA / 100 / 24); // Tasa de interés periódica
            $cuota = (floatval($MONTO_SOLICITADO) * $tasaPeriodica * 1) / (1 - pow(1 + $tasaPeriodica, -$PLAZOQUINCENAS));

            // Redondear a dos decimales
           // return number_format($cuota, 2);
            // Redondear a dos decimales
              return  round($cuota, 2);
        } catch (Exception $error) {
            // Manejar el error aquí
            return "Error: " . $error->getMessage();
        }
    }

    public function repetirIDPrestamo($ID_PRESTAMO, $TASA, $PLAZO, $MONTO_SOLICITADO, $PLAZOQUINCENAS)
    {
        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {
            // Consulta SQL para realizar el INSERT repetido
            $sql = "INSERT INTO `siaace`.`tbl_mp_planp` (
            ID_PRESTAMO,
            FECHA_VENC_C,
            NUMERO_CUOTA,
            ESTADO,
            VALOR_CUOTA
        ) VALUES (
            :ID_PRESTAMO,
            :FECHA_VENC_C,
            :NUMERO_CUOTA,
            :ESTADO,
            :VALOR_CUOTA
        )";

            // Preparar la consulta
            $stmt = $conectar->prepare($sql);
            

            // Loop para insertar según plazoQuincenas
            for ($i = 1; $i <= $PLAZOQUINCENAS; $i++) {
                // Calcular la fecha según la lógica
                $fechaVencimiento = date('Y-m-d ', strtotime('+' . ($i * 14) . ' days')); // Sumar 15 días por cuincena
                $ESTADO = "PENDIENTE";
                // Setear los valores para cada iteración
                // Calcular el valor de la cuota
               $VALOR_CUOTA = $this->calcularCuota($TASA, $PLAZO, $MONTO_SOLICITADO, $PLAZOQUINCENAS);
                $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
                $stmt->bindParam(':FECHA_VENC_C', $fechaVencimiento, PDO::PARAM_STR);
                $stmt->bindParam(':NUMERO_CUOTA', $i, PDO::PARAM_INT);
                $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
                $stmt->bindParam(':VALOR_CUOTA', $VALOR_CUOTA, PDO::PARAM_STR);

                // Ejecutar la consulta
                $stmt->execute();
                
            }
  
            //return "Registros insertados correctamente.";
            return [
                'message' => 'Registros insertados correctamente.',
                'valor_cuota' => $VALOR_CUOTA,
            ];
        } catch (PDOException $e) {
            return "Error al insertar registros: " . $e->getMessage();
        }
    }

}
