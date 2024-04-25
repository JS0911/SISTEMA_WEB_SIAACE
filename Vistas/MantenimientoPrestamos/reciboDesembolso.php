<?php
session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/prestamo.php"; // Asegúrate de incluir el archivo correcto

if (isset($_GET['ID_PRESTAMO'])) {
    $ID_PRESTAMO = $_GET['ID_PRESTAMO'];
} else {
    echo "No se proporcionó el ID_PRESTAMO en la URL.";
    exit; // Salir del script si no hay ID_PRESTAMO
}

// Crear una instancia del modelo de préstamo
$modeloPrestamo = new prestamo();

// Obtener los datos del préstamo
$datosPrestamo = $modeloPrestamo->get_PrestamoRecibo($ID_PRESTAMO);
date_default_timezone_set('America/Tegucigalpa'); // Establece la zona horaria 

$fechaActual = date("Y-m-d H:i:s"); // Obtén la fecha y hora actual

// Verificar si se obtuvieron los datos del préstamo
if ($datosPrestamo) {
    // Obtener el primer elemento del array (el único en este caso)
    $Prestamo = $datosPrestamo[0];
} else {
    echo "No se encontraron datos del préstamo con el ID_PRESTAMO proporcionado.";
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
            text-align: center;
            /* Alinea el contenido al centro */
        }

        .titulo {
            font-size: 28px;
            margin-bottom: 20px;
            font-family: 'Arial Black', sans-serif;
            /* Tipo de letra */
            text-decoration: underline;
            /* Subrayado */
        }

        .detalle {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .detalle span {
            font-weight: bold;
        }

        .firma-label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .logo img {
            width: 100px;
            /* Ajusta el ancho del logo */
            height: auto;
            /* Mantiene la proporción de aspecto */
            margin-bottom: 20px;
            /* Espacio entre el logo y el título */
        }

        .firma-espacio {
            height: 100px;
            /* Altura del espacio para firmar */
        }
    </style>
</head>

<body>
    <div class="recibo">
        <div class="logo">
            <img src="../../src/IconoIDH.ico" alt="Logo de la empresa">
        </div>
        <div class="titulo">Recibo de Desembolso</div>

        <div class="detalle">
            <span>ID del Préstamo:</span> <span id="idPrestamo"><?php echo $Prestamo['ID_PRESTAMO']; ?></span>
        </div>
        <div class="detalle">
            <span>Nombre del Empleado:</span> <?php echo $Prestamo['PRIMER_NOMBRE'] . ' ' . $Prestamo['PRIMER_APELLIDO']; ?>
        </div>
        <div class="detalle">
            <span>Monto Desembolsado:</span> <span id="montoDesembolsado"><?php echo $Prestamo['MONTO_SOLICITADO']; ?></span>
        </div>
        <div class="detalle">
            <span>Estado del Prestamo:</span> <span id="estado"><?php echo $Prestamo['ESTADO_PRESTAMO']; ?></span>
        </div>
        <div class="detalle">
            <span>Fecha de Desembolso:</span> <span id="fechaDesembolso"><?php echo $Prestamo['FECHA_DE_DESEMBOLSO']; ?></span>
        </div>

        <div class="detalle">
            <span>Desembolsado Por:</span> <span id="DesembolsadoPor"><?php echo $Prestamo['DESEMBOLSADO_POR']; ?></span>
        </div>
        <div class="detalle">
            <span>Fecha de Impresión del Recibo:</span> <?php echo $fechaActual; ?>
        </div>
        <!-- Otros detalles del desembolso -->

        <div class="firma-label">Firma de la Tesorera:</div>
        <div class="firma-espacio"></div> <!-- Espacio para firmar -->
        <hr class="firma-linea"> <!-- Línea para la firma -->

      

    </div>
    <script>

          // Obtener la hora actual del dispositivo del usuario
    var horaActual = new Date().toLocaleTimeString(); 

        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>