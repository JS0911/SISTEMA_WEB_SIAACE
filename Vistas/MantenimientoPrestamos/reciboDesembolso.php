<?php
session_start();
require "../../Config/conexion.php";
//require_once "../../Modelos/permisoUsuario.php";


if (isset($_GET['ID_PRESTAMO'])) {
    $ID_PRESTAMO = $_GET['ID_PRESTAMO'];
    // $MONTO_SOLICITADO = $_GET['MONTO_SOLICITADO'];
    // $PLAZO = $_GET['PLAZO'];
    // $TASA = $_GET['TASA'];
    // echo "ID_PRESTAMOP: " . $ID_PRESTAMOP;
    // echo "MONTO_SOLICITADO: " . $MONTO_SOLICITADO;
    // echo "PLAZO: " . $PLAZO;
    // echo "TASA: " . $TASA;
} else {
    echo "No se proporcionó el ID_PRESTAMO en la URL.";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Desembolso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .recibo {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }
        .titulo {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .detalle {
            margin-bottom: 10px;
        }
        .detalle span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="recibo">
        <div class="titulo">Recibo de Desembolso</div>
        <div class="detalle">
            <span>Fecha de Desembolso:</span> <span id="fechaDesembolso"></span>
        </div>
        <div class="detalle">
            <span>ID del Préstamo:</span> <span id="idPrestamo"></span>
        </div>
        <div class="detalle">
            <span>Monto Desembolsado:</span> <span id="montoDesembolsado"></span>
        </div>
        <!-- Otros detalles del desembolso -->
    </div>

    <script>
        // Aquí puedes llenar dinámicamente los datos del desembolso utilizando JavaScript
        const datosDesembolso = {
            fechaDesembolso: '2024-03-15',
            idPrestamo: $ID_PRESTAMO,
            montoDesembolsado: '$1000.00' // Puedes llenar con los datos reales obtenidos del backend
        };

        // Llenar los datos en la plantilla
        document.getElementById('fechaDesembolso').textContent = datosDesembolso.fechaDesembolso;
        document.getElementById('idPrestamo').textContent = datosDesembolso.idPrestamo;
        document.getElementById('montoDesembolsado').textContent = datosDesembolso.montoDesembolsado;
    </script>
</body>
</html>
