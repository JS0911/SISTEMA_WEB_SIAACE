<?php
class cuenta extends Conectar
{
    //TRAE TODAS LAS CUENTAS
    public function get_cuentas()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT C.*,E.PRIMER_NOMBRE, E.PRIMER_APELLIDO, T.TIPO_CUENTA
        FROM siaace.tbl_mc_cuenta AS C
        INNER JOIN siaace.tbl_me_empleados AS E ON C.ID_EMPLEADO = E.ID_EMPLEADO
        INNER JOIN siaace.tbl_mc_tipocuenta AS T ON C.ID_TIPOCUENTA = T.ID_TIPOCUENTA;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UNA CUENTA 
     public function get_cuenta($ID_CUENTA)
     {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_mc_cuenta where ID_CUENTA = :ID";
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
        $sql = "SELECT * FROM siaace.tbl_mc_cuenta where ID_EMPLEADO = :ID";
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
            $sql = "INSERT INTO `siaace`.`tbl_mc_cuenta` (`ID_EMPLEADO`, `ID_TIPOCUENTA`, `SALDO`, `NUMERO_CUENTA`, `ESTADO`, `CREADO_POR`, `FECHA_CREACION`) VALUES ( :ID_EMPLEADO, :ID_TIPOCUENTA, :SALDO, :NUMERO_CUENTA, :ESTADO, :CREADO_POR, :FECHA_CREACION)";

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
        $sql = "SELECT  T.ID_CUENTA, T.ID_TRANSACCION, T.FECHA, T.MONTO, TT.TIPO_TRANSACCION FROM tbl_transacciones AS T
        INNER JOIN tbl_tipo_transaccion AS TT ON T.ID_TIPO_TRANSACCION = TT.ID_TIPO_TRANSACCION
        WHERE T.ID_CUENTA = :ID_CUENTA";
  
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->execute();
        return $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
    }
    
    //HACE DEPOSITO EN CUENTA
    public function deposito_cuenta($ID_CUENTA, $DEPOSITO){
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario
        $sql = "UPDATE tbl_mc_cuenta SET SALDO = SALDO + :SALDO  WHERE ID_CUENTA = :ID_CUENTA";
        $sql2 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`) VALUES (:SALDO_D,:ID_CUENTA_D, 1, NOW())";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->bindParam(':SALDO', $DEPOSITO, PDO::PARAM_INT);
        $stmt->execute();

        $stmt2 = $conectar->prepare($sql2);
        $stmt2->bindParam(':ID_CUENTA_D', $ID_CUENTA, PDO::PARAM_INT);
        $stmt2->bindParam(':SALDO_D', $DEPOSITO, PDO::PARAM_INT);
        $stmt2->execute();

        if ($stmt->rowCount() > 0) {
            return "Saldo Actualizado";
        } else {
            return "Error al actualizar saldo";
        }
    }

    public function reembolso_cuenta($ID_CUENTA, $REEMBOLSO){
        $conectar = parent::conexion();
        parent::set_names();

        // Consulta SQL para actualizar los campos del usuario
        $sql = "UPDATE tbl_mc_cuenta SET SALDO = SALDO - :SALDO  WHERE ID_CUENTA = :ID_CUENTA";
        $sql2 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`) VALUES (:SALDO_R,:ID_CUENTA_R, 2, NOW())";

        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
        $stmt->bindParam(':SALDO', $REEMBOLSO, PDO::PARAM_INT);
        $stmt->execute();

        $stmt2 = $conectar->prepare($sql2);
        $stmt2->bindParam(':ID_CUENTA_R', $ID_CUENTA, PDO::PARAM_INT);
        $stmt2->bindParam(':SALDO_R', $REEMBOLSO, PDO::PARAM_INT);
        $stmt2->execute();

        if ($stmt->rowCount() > 0) {
            return "Saldo Actualizado";
        } else {
            return "Error al actualizar saldo";
        }
    }


    public function anular($ID_CUENTA,$ID_TRANSACCION){
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

        if ($TIPO_TRANSACCION == 1) {
            $sql2 = "UPDATE tbl_mc_cuenta SET SALDO = SALDO - $MONTO  WHERE ID_CUENTA = :ID_CUENTA";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt2->execute();

            $sql3 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`) VALUES (:MONTO,:ID_CUENTA, 3, NOW())";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt3->bindParam(':MONTO', $MONTO, PDO::PARAM_INT);
            $stmt3->execute();
        } else {
            $sql2 = "UPDATE tbl_mc_cuenta SET SALDO = SALDO + $MONTO  WHERE ID_CUENTA = :ID_CUENTA";
            $stmt2 = $conectar->prepare($sql2);
            $stmt2->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt2->execute();

            $sql3 = "INSERT INTO tbl_transacciones (`MONTO`, `ID_CUENTA`, `ID_TIPO_TRANSACCION`,`FECHA`) VALUES (:MONTO,:ID_CUENTA, 4, NOW())";
            $stmt3 = $conectar->prepare($sql3);
            $stmt3->bindParam(':ID_CUENTA', $ID_CUENTA, PDO::PARAM_INT);
            $stmt3->bindParam(':MONTO', $MONTO, PDO::PARAM_INT);
            $stmt3->execute();
        }    
      
        if ($stmt->rowCount() > 0) {
            return "ANULACION REALIZADA";
        } else {
            return "ERRRRRRRRORR";
        }
    }
}

