<?php
class Empleados extends Conectar
{
    //TRAE TODOS LOS empleados
    public function get_empleados()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM siaace.tbl_me_empleados";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //TRAE SOLO UN EMPLEADO
    public function get_empleado($ID_EMPLEADO)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM tbl_me_empleados WHERE ID_EMPLEADO = :ID";
        $stmt = $conectar->prepare($sql);
        $stmt->bindParam(':ID', $ID_EMPLEADO, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //INSERTA UN EMPLEADO
    public function insert_empleado($DNI, $PRIMER_NOMBRE, $SEGUNDO_NOMBRE, $PRIMER_APELLIDO, $SEGUNDO_APELLIDO, $EMAIL, $SALARIO, $ESTADO, $TELEFONO, $DIRECCION1, $DIRECCION2,$ID_SUCURSAL,$ID_CARGO)
    {
        try {

            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO `siaace`.`tbl_me_empleados` ( `DNI`, `PRIMER_NOMBRE`, `SEGUNDO_NOMBRE`, `PRIMER_APELLIDO`, `SEGUNDO_APELLIDO`, `EMAIL`,`SALARIO`,`ESTADO`,`TELEFONO`,`DIRECCION1`,`DIRECCION2`,`ID_SUCURSAL`,`ID_CARGO`) 
            VALUES ( :DNI, :PRIMER_NOMBRE, :SEGUNDO_NOMBRE, :PRIMER_APELLIDO, :SEGUNDO_APELLIDO, :EMAIL, :SALARIO, :ESTADO, :TELEFONO, :DIRECCION1, :DIRECCION2 , :ID_SUCURSAL, :ID_CARGO)";

            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':DNI', $DNI, PDO::PARAM_INT);
            $stmt->bindParam(':PRIMER_NOMBRE', $PRIMER_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_NOMBRE', $SEGUNDO_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':PRIMER_APELLIDO', $PRIMER_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_APELLIDO', $SEGUNDO_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR);
            $stmt->bindParam(':SALARIO', $SALARIO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);  // HACER EN SELECT 
            $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_INT);
            $stmt->bindParam(':DIRECCION1', $DIRECCION1, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION2', $DIRECCION2, PDO::PARAM_STR);
            $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
            $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);


            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Empleado Insertado";
            } else {
                return "Error al insertar el empleado";
            }
        } catch (PDOException $e) {

            return "Error al insertar el empleado: " . $e->getMessage();
        }
    }

    // //EDITA UN empleado
    public function update_empleado(
        $ID_EMPLEADO,
        $DNI,
        $PRIMER_NOMBRE,
        $SEGUNDO_NOMBRE,
        $PRIMER_APELLIDO,
        $SEGUNDO_APELLIDO,
        $EMAIL,
        $SALARIO,
        $ESTADO,
        $TELEFONO,
        $DIRECCION1,
        $DIRECCION2,
        $ID_SUCURSAL,
        $ID_CARGO
       
    ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del usuario
            $sql = "UPDATE `siaace`.`tbl_me_empleados` 
                SET `DNI` = :DNI,
                    `PRIMER_NOMBRE` = :PRIMER_NOMBRE, 
                    `SEGUNDO_NOMBRE` = :SEGUNDO_NOMBRE, 
                    `PRIMER_APELLIDO` = :PRIMER_APELLIDO, 
                    `SEGUNDO_APELLIDO` = :SEGUNDO_APELLIDO, 
                    `EMAIL` = :EMAIL,
                    `SALARIO` = :SALARIO, 
                    `ESTADO` = :ESTADO,
                    `TELEFONO` = :TELEFONO,
                    `DIRECCION1` = :DIRECCION1,
                    `DIRECCION2` = :DIRECCION2,
                    `ID_SUCURSAL` = :ID_SUCURSAL,
                    `ID_CARGO` = :ID_CARGO
                    
                    
                WHERE `ID_EMPLEADO` = :ID_EMPLEADO";


            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->bindParam(':DNI', $DNI, PDO::PARAM_INT);
            $stmt->bindParam(':PRIMER_NOMBRE', $PRIMER_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_NOMBRE', $SEGUNDO_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':PRIMER_APELLIDO', $PRIMER_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_APELLIDO', $SEGUNDO_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR);
            $stmt->bindParam(':SALARIO', $SALARIO, PDO::PARAM_STR);
            $stmt->bindParam(':ESTADO', $ESTADO, PDO::PARAM_STR);  // HACER EN SELECT 
            $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION1', $DIRECCION1, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION2', $DIRECCION2, PDO::PARAM_STR);
            $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
            $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);
           
           // echo $stmt->queryString;

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Empleaado actualizado correctamente";
            } else {
                return "No se realizó ninguna actualización, o el empleado no existe";
            }
        } catch (PDOException $e) {
            return "Error al actualizar el empleado: " . $e->getMessage();
        }
    }

    // // ELIMINA UN empleado
    public function eliminar_empleado($ID_EMPLEADO)
    {
        try {
            $conectar = parent::conexion();
            parent::set_names();
            // Consulta SQL para eliminar el usuario
            $sql = "DELETE FROM `tbl_me_empleados` WHERE `ID_EMPLEADO` = :ID_EMPLEADO";
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return "Empleado eliminado correctamente";
            } else {
                return "No se realizó ninguna eliminación, o el empleado no existe";
            }
        } catch (PDOException $e) {
            return  $e->getCode();
        }
    }
}
