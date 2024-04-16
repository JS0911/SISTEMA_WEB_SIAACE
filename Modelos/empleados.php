<?php
class Empleados extends Conectar
{
    //TRAE TODOS LOS empleados
    public function get_empleados()
    {
        $conectar = parent::conexion();
        parent::set_names();
        //$sql = "SELECT * FROM tbl_me_empleados";
        $sql = "SELECT U.*, E.NOMBRE
        FROM tbl_me_empleados U
        INNER JOIN tbl_ms_estadousuario E ON U.ID_ESTADO_USUARIO = E.ID_ESTADO_USUARIO"; 
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
public function insert_empleado($DNI, $PRIMER_NOMBRE, $SEGUNDO_NOMBRE, $PRIMER_APELLIDO, $SEGUNDO_APELLIDO, $EMAIL, $SALARIO, $ID_ESTADO_USUARIO, $TELEFONO, $DIRECCION1, $DIRECCION2, $ID_SUCURSAL, $ID_CARGO, $CREADO_POR, $FECHA_CREACION)
{
    try {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `tbl_me_empleados` (`DNI`, `PRIMER_NOMBRE`, `SEGUNDO_NOMBRE`, `PRIMER_APELLIDO`, `SEGUNDO_APELLIDO`, `EMAIL`, `SALARIO`, `ID_ESTADO_USUARIO`, `TELEFONO`, `DIRECCION1`, `DIRECCION2`, `ID_SUCURSAL`, `ID_CARGO`, `CREADO_POR`, `FECHA_CREACION`) 
        VALUES (:DNI, :PRIMER_NOMBRE, :SEGUNDO_NOMBRE, :PRIMER_APELLIDO, :SEGUNDO_APELLIDO, :EMAIL, :SALARIO, :ID_ESTADO_USUARIO, :TELEFONO, :DIRECCION1, :DIRECCION2 , :ID_SUCURSAL, :ID_CARGO, :CREADO_POR, :FECHA_CREACION)";

        $stmt = $conectar->prepare($sql);

        $stmt->bindParam(':DNI', $DNI, PDO::PARAM_INT);
        $stmt->bindParam(':PRIMER_NOMBRE', $PRIMER_NOMBRE, PDO::PARAM_STR);
        $stmt->bindParam(':SEGUNDO_NOMBRE', $SEGUNDO_NOMBRE, PDO::PARAM_STR);
        $stmt->bindParam(':PRIMER_APELLIDO', $PRIMER_APELLIDO, PDO::PARAM_STR);
        $stmt->bindParam(':SEGUNDO_APELLIDO', $SEGUNDO_APELLIDO, PDO::PARAM_STR);
        $stmt->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR);
        $stmt->bindParam(':SALARIO', $SALARIO, PDO::PARAM_STR);
        $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);  // HACER EN SELECT 
        $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_INT);
        $stmt->bindParam(':DIRECCION1', $DIRECCION1, PDO::PARAM_STR);
        $stmt->bindParam(':DIRECCION2', $DIRECCION2, PDO::PARAM_STR);
        $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
        $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);
        $stmt->bindParam(':CREADO_POR', $CREADO_POR, PDO::PARAM_STR);
        $stmt->bindParam(':FECHA_CREACION', $FECHA_CREACION, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $lastInsertedId = $conectar->lastInsertId();
            // Si se insertó correctamente, devolver el ID_EMPLEADO y un mensaje de éxito
          //  return array("ID_EMPLEADO" => $lastInsertedId, "message" => "Empleado Insertado");
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
        $ID_ESTADO_USUARIO,
        $TELEFONO,
        $DIRECCION1,
        $DIRECCION2,
        $ID_SUCURSAL,
        $ID_CARGO,
        $MODIFICADO_POR, 
        $FECHA_MODIFICACION
    ) {
        try {
            $conectar = parent::conexion();
            parent::set_names();

            // Consulta SQL para actualizar los campos del usuario
            $sql = "UPDATE `tbl_me_empleados` 
                SET `DNI` = :DNI,
                    `PRIMER_NOMBRE` = :PRIMER_NOMBRE, 
                    `SEGUNDO_NOMBRE` = :SEGUNDO_NOMBRE, 
                    `PRIMER_APELLIDO` = :PRIMER_APELLIDO, 
                    `SEGUNDO_APELLIDO` = :SEGUNDO_APELLIDO, 
                    `EMAIL` = :EMAIL,
                    `SALARIO` = :SALARIO, 
                    `ID_ESTADO_USUARIO` = :ID_ESTADO_USUARIO,
                    `TELEFONO` = :TELEFONO,
                    `DIRECCION1` = :DIRECCION1,
                    `DIRECCION2` = :DIRECCION2,
                    `ID_SUCURSAL` = :ID_SUCURSAL,
                    `ID_CARGO` = :ID_CARGO,
                    `MODIFICADO_POR` = :MODIFICADO_POR, 
                    `FECHA_MODIFICACION` = :FECHA_MODIFICACION
                WHERE `ID_EMPLEADO` = :ID_EMPLEADO";


            $stmt = $conectar->prepare($sql);

            $stmt->bindParam(':ID_EMPLEADO', $ID_EMPLEADO, PDO::PARAM_INT);
            $stmt->bindParam(':DNI', $DNI, PDO::PARAM_STR);
            $stmt->bindParam(':PRIMER_NOMBRE', $PRIMER_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_NOMBRE', $SEGUNDO_NOMBRE, PDO::PARAM_STR);
            $stmt->bindParam(':PRIMER_APELLIDO', $PRIMER_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':SEGUNDO_APELLIDO', $SEGUNDO_APELLIDO, PDO::PARAM_STR);
            $stmt->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR);
            $stmt->bindParam(':SALARIO', $SALARIO, PDO::PARAM_STR);
            $stmt->bindParam(':ID_ESTADO_USUARIO', $ID_ESTADO_USUARIO, PDO::PARAM_INT);  // HACER EN SELECT 
            $stmt->bindParam(':TELEFONO', $TELEFONO, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION1', $DIRECCION1, PDO::PARAM_STR);
            $stmt->bindParam(':DIRECCION2', $DIRECCION2, PDO::PARAM_STR);
            $stmt->bindParam(':ID_SUCURSAL', $ID_SUCURSAL, PDO::PARAM_INT);
            $stmt->bindParam(':ID_CARGO', $ID_CARGO, PDO::PARAM_INT);
            $stmt->bindParam(':MODIFICADO_POR', $MODIFICADO_POR, PDO::PARAM_STR);
            $stmt->bindParam(':FECHA_MODIFICACION', $FECHA_MODIFICACION, PDO::PARAM_STR);
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
