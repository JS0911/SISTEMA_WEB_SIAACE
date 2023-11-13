<?php


class PlanPago extends Conectar

{

    public function get_planPago($ID_PRESTAMO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mp_planp WHERE ID_PRESTAMO = :ID_PRESTAMO";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(":ID_PRESTAMO", $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    /* public function get_planPago()
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
    } */


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
            return  round($cuota, 5);
        } catch (Exception $error) {
            // Manejar el error aquí
            return "Error: " . $error->getMessage();
        }
    }

    public function calcularInteresCapital($TASA, $SALDO, $VALOR_CUOTA)
    {
        try {
            // Consulta SQL para actualizar los campos del usuario

            //MONTO ADEUDADO DE CAPITAL Y INTERES
            $tasaPeriodica = floatval($TASA / 100 / 24); // Tasa de interés periódica

            $interes = ($SALDO * $tasaPeriodica); //CALCULO DE INTERES 
            $capital = ($VALOR_CUOTA - $interes); //CALCULO DEL CAPITAL ADEUDADO
            $saldoCapital = $SALDO - $capital; //SALDO ANTERIOR

            $resultados = array(

                "interes" => round($interes, 5),
                "capital" => round($capital, 5),
                "saldo" => round($saldoCapital, 5),

            );
            return $resultados;
        } catch (Exception $error) {
            // Manejar el error aquí
            return "Error: " . $error->getMessage();
        }
    }

    public function InsertarAmortizacion($ID_PRESTAMO, $TASA, $PLAZO, $MONTO_SOLICITADO, $PLAZOQUINCENAS)
    {
        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {

            $sql1 = "UPDATE tbl_mp_planp
         SET MONTO_ADEUDADO_CAP = :MONTO_SOLICITADO
         WHERE ID_PRESTAMO = :ID_PRESTAMO";


            // Consulta SQL para realizar el INSERT repetido
            $sql = "INSERT INTO `siaace`.`tbl_mp_planp` (
            ID_PRESTAMO,
            FECHA_VENC_C,
            NUMERO_CUOTA,
            ESTADO,
            VALOR_CUOTA,
            MONTO_ADEUDADO_CAP,
            MONTO_ADEUDADO_ITS,
            MONTO_PAGADO_CAP,
            MONTO_PAGADO_ITS
        ) VALUES (
            :ID_PRESTAMO,
            :FECHA_VENC_C,
            :NUMERO_CUOTA,
            :ESTADO,
            :VALOR_CUOTA,
            :MONTO_ADEUDADO_CAP,
            :MONTO_ADEUDADO_ITS,
            0,
            0
        )";

            // // Preparar la consulta
            $stmt = $conectar->prepare($sql);
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindParam(':MONTO_SOLICITADO', $MONTO_SOLICITADO, PDO::PARAM_STR);
            $stmt1->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
            $stmt1->execute(); // Ejecutar la consulta de actualización


            $MONTO_ADEUDADO_CAP = $MONTO_SOLICITADO; //VALOR INICIAL  DE SALDO CAPITAL O MONTO SOLICITADO            
            $totalInteresesPagados = 0; // Inicializa el total de intereses pagados en 0            
            // Loop para insertar según plazoQuincenas
            for ($i = 1; $i <= $PLAZOQUINCENAS; $i++) {
                // Calcular la fecha según la lógica
                $fechaVencimiento = date('Y-m-d ', strtotime('+' . ($i * 14) . ' days')); // Sumar 15 días por cuincena
                $ESTADO = "PENDIENTE";
                // Setear los valores para cada iteración
                // Calcular el valor de la cuota
                $VALOR_CUOTA = $this->calcularCuota($TASA, $PLAZO, $MONTO_SOLICITADO, $PLAZOQUINCENAS);
                $MONTO = $this->calcularInteresCapital($TASA, $MONTO_ADEUDADO_CAP, $VALOR_CUOTA);
                // Llama a la función para calcular los intereses y el capital

                // Acumula los intereses calculados en esta iteración
                $MONTO_ADEUDADO_CAPITAL = $MONTO["capital"];
                $MONTO_ADEUDADO_ITS = $MONTO["interes"];
                $MONTO_ADEUDADO_CAP = $MONTO["saldo"];


                $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
                $stmt->bindParam(':FECHA_VENC_C', $fechaVencimiento, PDO::PARAM_STR);
                $stmt->bindParam(':NUMERO_CUOTA', $i, PDO::PARAM_INT);
                $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
                $stmt->bindParam(':VALOR_CUOTA', $VALOR_CUOTA, PDO::PARAM_STR);
                $stmt->bindParam(':MONTO_ADEUDADO_CAP', $MONTO_ADEUDADO_CAPITAL, PDO::PARAM_STR);
                $stmt->bindParam(':MONTO_ADEUDADO_ITS', $MONTO_ADEUDADO_ITS, PDO::PARAM_STR);

                //Ejecutar la consulta
                $stmt->execute();
            }

            //return "Registros insertados correctamente.";
            return [
                'message' => 'Registros insertados correctamente.',
                // 'valor_cuota' => $VALOR_CUOTA,
                // 'capital' => $MONTO["capital"],
                'interes Total' => $totalInteresesPagados,
            ];
        } catch (PDOException $e) {
            return "Error al insertar registros: " . $e->getMessage();
        }
    }
}
