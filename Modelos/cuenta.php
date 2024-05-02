<?php
class cuenta extends Conectar
{
    //TRAE TODAS LAS CUENTAS
    public function get_cuentas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT C.*,E.PRIMER_NOMBRE, E.PRIMER_APELLIDO, T.TIPO_CUENTA
        FROM tbl_mc_cuenta AS C
        INNER JOIN tbl_me_empleados AS E ON C.ID_EMPLEADO = E.ID_EMPLEADO
        INNER JOIN tbl_mc_tipocuenta AS T ON C.ID_TIPOCUENTA = T.ID_TIPOCUENTA
        ORDER BY FECHA_CREACION DESC;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UNA CUENTA 
    public function get_cuenta($ID_CUENTA)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_mc_cuenta where ID_CUENTA = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO LAS CUENTAS PERTENECIENTES A UN EMPLEADO
    public function get_cuentas_emp($ID_EMPLEADO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT C.*, T.TIPO_CUENTA
        FROM tbl_mc_cuenta AS C
        INNER JOIN tbl_mc_tipocuenta AS T ON C.ID_TIPOCUENTA = T.ID_TIPOCUENTA
        WHERE C.ID_EMPLEADO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_EMPLEADO, PDO::PARAM_INT);
        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //INSERTA CUENTA
    public function insert_cuenta($ID_EMPLEADO, $ID_TIPOCUENTA, $SALDO, $NUMERO_CUENTA, $ESTADO, $CREADO_POR, $FECHA_CREACION)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `tbl_mc_cuenta` (`ID_EMPLEADO`, `ID_TIPOCUENTA`, `SALDO`, `NUMERO_CUENTA`, `ESTADO`, `CREADO_POR`, `FECHA_CREACION`) VALUES ( :ID_EMPLEADO, :ID_TIPOCUENTA, :SALDO, :NUMERO_CUENTA, :ESTADO, :CREADO_POR, :FECHA_CREACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_TIPOCUENTA', $ID_TIPOCUENTA, PDO::PARAM_INT);
            $stmt->bindParam(':SALDO', $SALDO, PDO::PARAM_INT);
            $stmt->bindParam(':NUMERO_CUENTA', $NUMERO_CUENTA, PDO::PARAM_INT);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Cuenta Insertada";
            } else {
                return "Error al insertar la cuenta";
            }
        } catch (PDOException $e) {

            return "Error al insertar el usuario: " . $e->getMessage();
        }
    }

    //INSERTA CUENTA AUTOMATICA
    public function insert_cuentaAutomatica($ID_EMPLEADO, $CREADO_POR, $FECHA_CREACION)
    {
        $saldo = 0;
        $estado = "ACTIVO";
        $tipoCuenta = 1;

        // Genera un número de cuenta único
        $numeroCuenta = $this->generarNumeroCuentaUnico($ID_EMPLEADO);

        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Utiliza el número de cuenta generado en la consulta SQL
            $sql = "INSERT INTO `tbl_mc_cuenta` (`ID_EMPLEADO`, `ID_TIPOCUENTA`, `SALDO`, `NUMERO_CUENTA`, `ESTADO`, `CREADO_POR`, `FECHA_CREACION`) VALUES (:ID_EMPLEADO, :ID_TIPOCUENTA, :SALDO, :NUMERO_CUENTA, :ESTADO, :CREADO_POR, :FECHA_CREACION)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->bindParam(':ID_TIPOCUENTA', $tipoCuenta, PDO::PARAM_INT);
            $stmt->bindParam(':SALDO', $saldo, PDO::PARAM_INT);
            $stmt->bindParam(':NUMERO_CUENTA', $numeroCuenta, PDO::PARAM_INT);
            $stmt->bindParam(':ESTADO', $estado, PDO::PARAM_STR);
            $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Cuenta Insertada";
            } else {
                return "Error al insertar la cuenta";
            }
        } catch (PDOException $e) {
            return "Error al insertar el usuario: " . $e->getMessage();
        }
    }

    private function generarNumeroCuentaUnico($idEmpleado)
    {
        // Obtiene la fecha actual en formato Unix timestamp
        $timestamp = time();

        // Convierte el ID del empleado a una cadena de longitud fija de 3 dígitos (puedes ajustar la longitud si es necesario)
        $idEmpleadoStr = str_pad($idEmpleado, 3, '0', STR_PAD_LEFT);

        // Genera un número de cuenta concatenando el ID del empleado y la fecha actual
        // Asegura que el número de cuenta tenga 8 dígitos truncando los caracteres sobrantes
        $numeroCuenta = substr($idEmpleadoStr, -3) . substr($timestamp, -5);

        return $numeroCuenta;
    }


    //EDITA CUENTA
    public function update_cuenta($ID_CUENTA, $ESTADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del usuario
            $sql = "UPDATE `tbl_mc_cuenta` 
                    SET `ESTADO` = :ESTADO
                    WHERE `ID_CUENTA` = :ID_CUENTA";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Cuenta actualizada correctamente";
            } else {
                return "No se realizó ninguna actualización, o el usuario no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar la cuenta: " . $e->getMessage();
        }
    }

    //HISTORIAL DE LA CUENTA
    public function historial_cuenta($ID_CUENTA)
    {

        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario
        $sql = "SELECT  T.ID_CUENTA, T.ID_TRANSACCION, T.ESTADO, T.ID_TIPO_TRANSACCION, T.FECHA, T.MONTO, T.CREADO_POR, TT.DESCRIPCION 
        FROM tbl_transacciones AS T
        INNER JOIN tbl_tipo_transaccion AS TT ON T.ID_TIPO_TRANSACCION = TT.ID_TIPO_TRANSACCION
        WHERE T.ID_CUENTA = :ID_CUENTA";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //HACE DEPOSITO EN CUENTA
    public function deposito_cuenta($ID_CUENTA, $DEPOSITO, $CREADO_POR)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario
        // En sql2 la insercion del estado del deposito esta directamente en el codigo.

        $Estado ="ACTIVO";
        $sql = "UPDATE tbl_mc_cuenta SET SALDO = SALDO + :SALDO  WHERE ID_CUENTA = :ID_CUENTA";
        $sql2 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`,`CREADO_POR`,`ESTADO`) VALUES (:SALDO_D,:ID_CUENTA_D, 1, NOW(),:CREADO_POR,:ESTADO)";

        // En sql2 la insercion del estado del deposito esta directamente en el codigo.

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->bindParam(':SALDO', $DEPOSITO, PDO::PARAM_STR);
        $stmt->execute();

        $stmt2 = $conectar->prepare($sql2);
        $stmt2->bindParam(':ID_CUENTA_D', $ID_CUENTA, PDO::PARAM_INT);
        $stmt2->bindParam(':SALDO_D', $DEPOSITO, PDO::PARAM_STR);
        $stmt2->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
        $stmt2->bindParam(':ESTADO', $Estado, PDO::PARAM_STR);
        $stmt2->execute();

        if ($stmt->rowCount() > 0) {
            return "Saldo Actualizado";
        } else {
            return "Error al actualizar saldo";
        }
    }

    public function reembolso_cuenta($ID_CUENTA, $REEMBOLSO, $CREADO_POR)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario y validar campos
        $sqlV = "SELECT SALDO FROM tbl_mc_cuenta WHERE ID_CUENTA = :ID_CUENTA";
        $stmtV = $conectar->prepare($sqlV);
        $stmtV->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmtV->execute();
        $saldo = $stmtV->fetchColumn();
        $Estado ="ACTIVO";

        if ($REEMBOLSO > $saldo) {
            return "El Monto a retirar es mayor al saldo";
        } else {
            $sql = "UPDATE tbl_mc_cuenta SET SALDO = SALDO - :SALDO  WHERE ID_CUENTA = :ID_CUENTA";
            $sql2 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`,`CREADO_POR`,`ESTADO`) VALUES (:SALDO_R,:ID_CUENTA_R, 2, NOW(),:CREADO_POR,:ESTADO)";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt->bindParam(':SALDO', $REEMBOLSO, PDO::PARAM_STR);
            $stmt->execute();

            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindParam(':ID_CUENTA_R', $ID_CUENTA, PDO::PARAM_INT);
            $stmt2->bindParam(':SALDO_R', $REEMBOLSO, PDO::PARAM_STR);
            $stmt2->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt2->bindParam(':ESTADO', $Estado, PDO::PARAM_STR);
            $stmt2->execute();

            if ($stmt->rowCount() > 0) {
                return "Saldo Actualizado";
            } else {
                return "Error al actualizar saldo";
            }
        }
    }


    public function anular($ID_CUENTA, $ID_TRANSACCION, $CREADO_POR, $DESCRIPCION)
    {
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario
        $sql = "SELECT ID_TIPO_TRANSACCION FROM TBL_TRANSACCIONES WHERE ID_TRANSACCION = $ID_TRANSACCION";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $TIPO_TRANSACCION = $stmt->fetchColumn();

        $sql1 = "SELECT MONTO FROM TBL_TRANSACCIONES WHERE ID_TRANSACCION = $ID_TRANSACCION";
        $stmt1 = $conectar->prepare($sql1);
        $stmt1->execute();
        $MONTO = $stmt1->fetchColumn();
        $Estado ="ANULADO";

      
        if ($TIPO_TRANSACCION == 1) {
            $sql2 = "UPDATE tbl_mc_cuenta SET SALDO = SALDO - $MONTO  WHERE ID_CUENTA = :ID_CUENTA";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt2->execute();

            $sql3 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`, `CREADO_POR`,`DESCRIPCION`) 
            VALUES (:MONTO,:ID_CUENTA, 3, NOW(),:CREADO_POR, CONCAT(:DESCRIPCION, ', TRANSACCION ANULADA: $ID_TRANSACCION'))";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt3->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt3->bindParam(':MONTO', $MONTO, PDO::PARAM_INT);
            $stmt3->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt3->execute();

            $sql4 = "UPDATE tbl_transacciones SET ESTADO = :ESTADO, FECHA_MODIFICACION = NOW(), MODIFICADO_POR = :MODIFICADO_POR WHERE ID_TRANSACCION = $ID_TRANSACCION";
            $stmt4 = $conectar->prepare($sql4);
            $stmt4->bindParam(':ESTADO', $Estado, PDO::PARAM_STR);
            $stmt4->bindParam(':MODIFICADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt4->execute();

        } else {
            $sql2 = "UPDATE tbl_mc_cuenta SET SALDO = SALDO + $MONTO  WHERE ID_CUENTA = :ID_CUENTA";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt2->execute();

            $sql3 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`,`CREADO_POR`,`DESCRIPCION` ) 
            VALUES (:MONTO,:ID_CUENTA, 4, NOW(),:CREADO_POR, CONCAT(:DESCRIPCION, ', TRANSACCION ANULADA: $ID_TRANSACCION'))";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt3->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt3->bindParam(':MONTO', $MONTO, PDO::PARAM_INT);
            $stmt3->bindParam(':DESCRIPCION', $DESCRIPCION, PDO::PARAM_STR);
            $stmt3->execute();

            $sql4 = "UPDATE tbl_transacciones SET ESTADO = :ESTADO, FECHA_MODIFICACION = NOW(), MODIFICADO_POR = :MODIFICADO_POR WHERE ID_TRANSACCION = $ID_TRANSACCION";
            $stmt4 = $conectar->prepare($sql4);
            $stmt4->bindParam(':ESTADO', $Estado, PDO::PARAM_STR);
            $stmt4->bindParam(':MODIFICADO_POR', $CREADO_POR, PDO::PARAM_STR);
            $stmt4->execute();

        }

        if ($stmt->rowCount() > 0) {
            return "ANULACION REALIZADA";
        } else {
            return "ERRRRRRRRORR";
        }
        
    }


    public function obtenerTransacciones($ID_TRANSACCION)
    {
        $conectar = parent::conexion();
        parent::set_names();

        try {
            $sql = "SELECT t.ID_TRANSACCION, t.MONTO, t.ID_TIPO_TRANSACCION, t.ID_CUENTA, tt.DESCRIPCION
                FROM tbl_transacciones t
                INNER JOIN tbl_tipo_transaccion tt ON t.ID_TIPO_TRANSACCION = tt.ID_TIPO_TRANSACCION
                WHERE t.ID_TRANSACCION = :ID_TRANSACCION";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_TRANSACCION', $ID_TRANSACCION, PDO::PARAM_INT);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (PDOException $e) {
            // Manejo de errores
            // Puedes registrar el error, lanzar una excepción, o devolver un mensaje de error
            return "Error al obtener las transacciones: " . $e->getMessage();
        }
    }

    public function ReporteAnulaciones()
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT CREADO_POR, FECHA, MONTO, DESCRIPCION 
        FROM TBL_TRANSACCIONES 
        WHERE ID_TIPO_TRANSACCION IN (3, 4)
        ORDER BY FECHA DESC;";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute();

        return $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
