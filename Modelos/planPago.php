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


    public function get_cuotaActual($ID_PRESTAMO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mp_planp WHERE ID_PRESTAMO = :ID_PRESTAMO AND ESTADO = 'PENDIENTE' ORDER BY FECHA_VENC_C ASC LIMIT 1";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(":ID_PRESTAMO", $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
            $sql = "INSERT INTO `tbl_mp_planp` (
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

            $fechaActual = date('Y-m-d');  // Obtener la fecha actual
            $MONTO_ADEUDADO_CAP = $MONTO_SOLICITADO; //VALOR INICIAL  DE SALDO CAPITAL O MONTO SOLICITADO            
            $totalInteresesPagados = 0; // Inicializa el total de intereses pagados en 0            
            // Loop para insertar según plazoQuincenas

            for ($i = 1; $i <= $PLAZOQUINCENAS; $i++) {
                // Calcular la fecha según la lógica
                // Calcular la fecha según la lógica
                $diasParaSumar = ($i * 15);  // Sumar 15 días por quincena
                $fechaVencimiento = date('Y-m-d', strtotime($fechaActual . ' +' . $diasParaSumar . ' days'));

                // Verificar si la fecha de vencimiento es antes o después del día 15 del mes
                $dia = date('j', strtotime($fechaVencimiento));
                if ($dia <= 15) {
                    // Si es antes del día 15, establecer la fecha al 10 del mismo mes
                    $fechaVencimiento = date('Y-m-10', strtotime($fechaVencimiento));
                } else {
                    // Si es después del día 15, establecer la fecha al 25 del próximo mes
                    $fechaVencimiento = date('Y-m-25', strtotime($fechaVencimiento));
                }
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
   
    public function PagoTCuota($ID_PPAGO)
    {
        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {

            $sql1 = "UPDATE tbl_mp_planp SET MONTO_PAGADO_CAP = MONTO_ADEUDADO_CAP , MONTO_ADEUDADO_CAP = 0, MONTO_PAGADO_ITS = MONTO_ADEUDADO_ITS, MONTO_ADEUDADO_ITS = 0
            WHERE ID_PLANP = :ID_PLANP";


            // // Preparar la consulta
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);

            $stmt1->execute(); // Ejecutar la consulta de actualización
            return [
                'message' => 'Pago De Cuota Total Realizado',
            ];
        
        } catch (PDOException $e) {
            return "Error al hacer pago total de la cuota: " . $e->getMessage();
        }
    }

    public function PagoCapital($ID_PPAGO)
    {
        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {

            $sql1 = "UPDATE tbl_mp_planp SET MONTO_PAGADO_CAP = MONTO_ADEUDADO_CAP, MONTO_ADEUDADO_CAP = 0
            WHERE ID_PLANP = :ID_PLANP;";


            // // Preparar la consulta
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);

            $stmt1->execute(); // Ejecutar la consulta de actualización

            //return "Registros insertados correctamente.";
            return [
                'message' => 'Pago De Capital Realizado',

            ];
        } catch (PDOException $e) {
            return "Error al hacer Pago De Capital: " . $e->getMessage();
        }
    }

    public function PagoInteres($ID_PPAGO)
    {
        // Conectar a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        try {

            $sql1 = "UPDATE tbl_mp_planp SET MONTO_PAGADO_ITS = MONTO_ADEUDADO_ITS, MONTO_ADEUDADO_ITS = 0
            WHERE ID_PLANP = :ID_PLANP";


            // // Preparar la consulta
            $stmt1 = $conectar->prepare($sql1);
            $stmt1->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);

            $stmt1->execute(); // Ejecutar la consulta de actualización

            //return "Registros insertados correctamente.";
            return [
                'message' => 'Pago De Interes Realizado',

            ];
        } catch (PDOException $e) {
            return "Error al Pago De Interes: " . $e->getMessage();
        }
    }


    public function PAGOT_ESTADO($ID_PPAGO)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();

        $date = new DateTime(date("Y-m-d H:i:s"));
        $dateMod = $date->modify("-7 hours");
        $dateNew = $dateMod->format("Y-m-d H:i:s");

        // Consulta SQL para actualizar el estado del préstamo a "PAGADO" y la fecha de aprobación
        $sql = "UPDATE tbl_mp_planp SET ESTADO = 'PAGADO', FECHA_R_PAGO = :FECHA_R_PAGO WHERE ID_PLANP = :ID_PLANP";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);
        $stmt->bindParam(':FECHA_R_PAGO', $dateNew, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Préstamo aprobado correctamente'));
            
        } else {
            echo json_encode(array('message' => 'No se realizó ningún pago, o el pago no existe'));
        }
    } catch (PDOException $e) {
        echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
    }
}
 
private function marcarPrestamoComoEnCurso($ID_PRESTAMO) {
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar el estado del préstamo a "EN CURSO" en tbl_mp_prestamos
        $sql = "UPDATE tbl_mp_prestamos SET ESTADO_PRESTAMO = 'EN CURSO' WHERE ID_PRESTAMO = :ID_PRESTAMO";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt->execute();

    } catch (PDOException $e) {
        echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
    }
}

public function EstadoFinalizado($ID_PPAGO) {
    try {
        // Obtener el ID_PRESTAMO correspondiente al ID_PPAGO
        $ID_PRESTAMO = $this->obtenerIdPrestamo($ID_PPAGO);

        // Contar cuántas filas están pendientes para el ID_PRESTAMO dado
        $numero_cuotas_pendientes = $this->contarCuotasPendientes($ID_PRESTAMO);
        $mensaje1="Prestamo Finalizado, No hay cuotas pendientes. ";
        $mensaje2="Marcado como EN CURSO ,Número de cuotas pendientes: $numero_cuotas_pendientes";

        // Si no hay cuotas pendientes, marcar el préstamo como finalizado
        if ($numero_cuotas_pendientes < 1) {
            $this->marcarPrestamoComoFinalizado($ID_PRESTAMO);
            // Si hay cuotas NO HAY pendientes, cambia de estado
            // echo json_encode(array('message' => $mensaje1));
            return [
                'message1' => $mensaje1,
            ];
        } else {
            // Si hay cuotas pendientes, mostrar el número de cuotas pendientes
            // Verificar si es la primera cuota y cambiar el estado del préstamo a "EN CURSO"
            $cuota_pagada = $this->verificarPrimeraCuotaPagada($ID_PRESTAMO);
            if ($cuota_pagada) {
                $this->marcarPrestamoComoEnCurso($ID_PRESTAMO);
            }
            // echo json_encode(array('message' => $mensaje2));
            return [
                'message2' => $mensaje2,
            ];
        }
    } catch (PDOException $e) {
        // Manejar cualquier error de base de datos
        echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
    }
}

private function verificarPrimeraCuotaPagada($ID_PRESTAMO) {
    $conectar = parent::conexion();
    parent::set_names();

    try {
        // Consulta SQL para verificar si la primera cuota ha sido pagada
        $sql = "SELECT COUNT(*) AS cuotas_pagadas FROM tbl_mp_planp WHERE ID_PRESTAMO = :ID_PRESTAMO AND ESTADO = 'PAGADO'";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado como un array asociativo
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver true si la primera cuota ha sido pagada, false en caso contrario
        return $resultado['cuotas_pagadas'] > 0;
    } catch (PDOException $e) {
        // Manejar errores de PDO
        throw new Exception("Error al verificar si la primera cuota ha sido pagada: " . $e->getMessage());
    }
}


private function obtenerIdPrestamo($ID_PPAGO) {
    $conectar = parent::conexion();
    parent::set_names();

    // Consulta SQL para obtener el ID_PRESTAMO correspondiente al ID_PPAGO
    $sql = "SELECT ID_PRESTAMO FROM tbl_mp_planp WHERE ID_PLANP = :ID_PLANP";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener el resultado como un array asociativo
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Devolver el ID_PRESTAMO encontrado
        return $resultado['ID_PRESTAMO'];
    } else {
        // Manejar el caso en que no se encuentre el ID_PRESTAMO
        throw new Exception("No se encontró el ID_PRESTAMO para el ID_PPAGO proporcionado.");
    }
}

private function contarCuotasPendientes($ID_PRESTAMO) {
    $conectar = parent::conexion();
    parent::set_names();

    try {
        // Consulta SQL para contar las cuotas pendientes
        $sql = "SELECT COUNT(*) AS cuotas_pendientes FROM tbl_mp_planp WHERE ID_PRESTAMO = :ID_PRESTAMO AND ESTADO = 'PENDIENTE'";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado como un array asociativo
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Devolver el número de cuotas pendientes
            return $resultado['cuotas_pendientes'];
        } else {
            // Si no se encuentra ningún resultado, devolver 0
            return 0;
        }
    } catch (PDOException $e) {
        // Manejar errores de PDO
        throw new Exception("Error al contar las cuotas pendientes: " . $e->getMessage());
    }
}

private function marcarPrestamoComoFinalizado($ID_PRESTAMO) {
    try {
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar el estado del préstamo a "FINALIZADO" en tbl_mp_prestamos
        $sql1 = "UPDATE tbl_mp_prestamos SET ESTADO_PRESTAMO = 'FINALIZADO' WHERE ID_PRESTAMO = :ID_PRESTAMO";
        $stmt1 = $conectar->prepare($sql1);
        $stmt1->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt1->execute();

        // Consulta SQL para actualizar el estado del préstamo a "FINALIZADO" en tbl_mp_planp
        $sql2 = "UPDATE tbl_mp_planp SET ESTADO = 'FINALIZADO' WHERE ID_PRESTAMO = :ID_PRESTAMO";
        $stmt2 = $conectar->prepare($sql2);
        $stmt2->bindParam(':ID_PRESTAMO', $ID_PRESTAMO, PDO::PARAM_INT);
        $stmt2->execute();

    } catch (PDOException $e) {
        echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
    }
}

    public function PAGOP_ESTADO($ID_PPAGO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");

            // Consulta SQL para actualizar el estado del préstamo a "Aprobado" y la fecha de aprobación
            $sql = "UPDATE tbl_mp_planp SET ESTADO = 'PARCIAL', FECHA_R_PAGO = :FECHA_R_PAGO WHERE ID_PLANP = :ID_PLANP";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_PLANP', $ID_PPAGO, PDO::PARAM_INT);
            $stmt->bindParam(':FECHA_R_PAGO', $dateNew, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(array('message' => 'Préstamo aprobado correctamente'));
            } else {
                echo json_encode(array('message' => 'No se realizó ningun pago, o el pago no existe'));
            }
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'Error en la solicitud: ' . $e->getMessage()));
        }
    }

    public function obtenerEstadoPago($ID_PPAGO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SELECT para obtener el estado del préstamo
            $select_sql = "SELECT `ESTADO` FROM `tbl_mp_planp` WHERE `ID_PLANP` = :ID_PPAGO";
            $stmt_select = $conectar->prepare($select_sql);
            $stmt_select->bindParam(':ID_PPAGO', $ID_PPAGO, PDO::PARAM_INT);
            $stmt_select->execute();

            // Obtener el resultado como un array asociativo
            $resultado = $stmt_select->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                // Devolver el estado del plan pago
                return $resultado['ESTADO'];
            } else {
                // El plan de pago no se encontró o no existe
                return "NO ENCONTRADO";
            }
        } catch (PDOException $e) {
            return "Error al Consultar el Estado del Plan de Pago: " . $e->getMessage();
        }
    }
}
