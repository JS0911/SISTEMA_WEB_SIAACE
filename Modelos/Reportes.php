<?php
class Reporte extends Conectar
{
    public function ReporteAnulaciones($fechaInicio, $fechaFin)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ID_TRANSACCION, CREADO_POR, FECHA, MONTO, DESCRIPCION 
        FROM TBL_TRANSACCIONES 
        WHERE ID_TIPO_TRANSACCION IN (3, 4)
        AND DATE(FECHA) BETWEEN :fechaInicio AND :fechaFin
        ORDER BY FECHA DESC;";

        // Agregar filtro por fecha si se proporcionan fechas
        if ($fechaInicio !== null && $fechaFin !== null) {
            $sql .= " AND FECHA BETWEEN :fechaInicio AND :fechaFin";
        } elseif ($fechaInicio !== null) {
            $sql .= " AND FECHA >= :fechaInicio";
        } elseif ($fechaFin !== null) {
            $sql .= " AND FECHA <= :fechaFin";
        }

        $sql .= " ORDER BY FECHA DESC;";

        $stmt = $conectar->prepare($sql);

        // Asignar valores de parámetros si se proporcionan fechas
        if ($fechaInicio !== null) {
            $stmt->bindValue(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        }
        if ($fechaFin !== null) {
            $stmt->bindValue(':fechaFin', $fechaFin, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ReporteDepositos($fechaInicio, $fechaFin)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ID_TRANSACCION, CREADO_POR, FECHA, MONTO, DESCRIPCION 
            FROM TBL_TRANSACCIONES 
            WHERE ID_TIPO_TRANSACCION = 1
            AND DATE(FECHA) BETWEEN :fechaInicio AND :fechaFin
            ORDER BY FECHA DESC;";

        // Agregar filtro por fecha si se proporcionan fechas
        if ($fechaInicio !== null && $fechaFin !== null) {
            $sql .= " AND DATE(FECHA) BETWEEN :fechaInicio AND :fechaFin";
        } elseif ($fechaInicio !== null) {
            $sql .= " AND FECHA >= :fechaInicio";
        } elseif ($fechaFin !== null) {
            $sql .= " AND FECHA <= :fechaFin";
        }

        $sql .= " ORDER BY FECHA DESC";

        $stmt = $conectar->prepare($sql);

        // Asignar valores de parámetros si se proporcionan fechas
        if ($fechaInicio !== null) {
            $stmt->bindValue(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        }
        if ($fechaFin !== null) {
            $stmt->bindValue(':fechaFin', $fechaFin, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ReporteRetiros($fechaInicio, $fechaFin)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "SELECT ID_TRANSACCION, CREADO_POR, FECHA, MONTO, DESCRIPCION 
            FROM TBL_TRANSACCIONES 
            WHERE ID_TIPO_TRANSACCION = 2
            AND DATE(FECHA) BETWEEN :fechaInicio AND :fechaFin
            ORDER BY FECHA DESC;";

        // Agregar filtro por fecha si se proporcionan fechas
        if ($fechaInicio !== null && $fechaFin !== null) {
            $sql .= " AND DATE(FECHA) BETWEEN :fechaInicio AND :fechaFin";
        } elseif ($fechaInicio !== null) {
            $sql .= " AND FECHA >= :fechaInicio";
        } elseif ($fechaFin !== null) {
            $sql .= " AND FECHA <= :fechaFin";
        }

        $sql .= " ORDER BY FECHA DESC";

        $stmt = $conectar->prepare($sql);

        // Asignar valores de parámetros si se proporcionan fechas
        if ($fechaInicio !== null) {
            $stmt->bindValue(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        }
        if ($fechaFin !== null) {
            $stmt->bindValue(':fechaFin', $fechaFin, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $reporte = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
