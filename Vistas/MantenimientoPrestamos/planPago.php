<?php
session_start();
require "../../Config/conexion.php";
//require_once "../../Modelos/permisoUsuario.php";


if (isset($_GET['ID_PRESTAMOP'], $_GET['MONTO_SOLICITADO'], $_GET['PLAZO'], $_GET['TASA'])) {
    $ID_PRESTAMOP = $_GET['ID_PRESTAMOP'];
    $MONTO_SOLICITADO = $_GET['MONTO_SOLICITADO'];
    $PLAZO = $_GET['PLAZO'];
    $TASA = $_GET['TASA'];
    echo "ID_PRESTAMOP: " . $ID_PRESTAMOP;
    echo "MONTO_SOLICITADO: " . $MONTO_SOLICITADO;
    echo "PLAZO: " . $PLAZO;
    echo "TASA: " . $TASA;
} else {
    echo "No se proporcionó el ID_PRESTAMO en la URL.";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Plan de Pago</title>
</head>

<body class="sb-nav-fixed">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Plan de Pago</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>ID_PRESTAMO: </strong> <?php echo $ID_PRESTAMOP; ?>
                </p>
                <p>
                    <strong>MONTO_SOLICITADO: </strong> <?php echo $MONTO_SOLICITADO; ?>
                </p>
                <p>
                    <strong>PLAZO: </strong> <?php echo $PLAZO; ?>
                </p>
                <p>
                    <strong>TASA: </strong> <?php echo $TASA; ?>
                </p>
            </div>
        </div>
    </div>



    <script>
        var ID_PRESTAMOP = <?php echo json_encode($ID_PRESTAMOP); ?>;
        var PLAZO = <?php echo json_encode($PLAZO); ?>;
        var MONTO_SOLICITADO = <?php echo json_encode($MONTO_SOLICITADO); ?>;
        var TASA = <?php echo json_encode($TASA); ?>;
        var plazoQuincenas = PLAZO * 2;

        function Insertar_Amortizacion() {
            ID_PRESTAMO = ID_PRESTAMOP;
           
            VALOR_CUOTA = calcularCuota(TASA, PLAZO, MONTO_SOLICITADO);
             console.log('VALOR_CUOTA:', VALOR_CUOTA);
           // console.log('PRESTAMO:', ID_PRESTAMO);

        }


        function calcularCuota(TASA, PLAZO, MONTO_SOLICITADO) {
            try {
                if (isNaN(TASA) || isNaN(PLAZO) || isNaN(MONTO_SOLICITADO)) {
                    throw new Error("Los parámetros deben ser numéricos.");
                }
               
                // Calcular la cuota usando la fórmula PMT
                const tasaPeriodica = parseFloat((TASA / 100 / 24).toFixed(5)); // Tasa de interés periódica
                const cuota = (parseFloat(MONTO_SOLICITADO) * tasaPeriodica * 1) / (1-Math.pow(1+tasaPeriodica,-plazoQuincenas));

                console.log('tasa:', tasaPeriodica);
                console.log('monto:', MONTO_SOLICITADO);
                // Redondear a dos decimales
                return parseFloat(cuota.toFixed(2));
            } catch (error) {
                // Manejar el error aquí
                console.log(error.message);
            }
        }

        $(document).ready(function() {
            //Lista_Prestamo();
            Insertar_Amortizacion();
        });
    </script>
</body>

</html>