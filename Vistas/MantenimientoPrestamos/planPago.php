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

        function Insertar_Amortizacion() {
            ID_PRESTAMO = ID_PRESTAMOP;
            QUINCENAS = PLAZO * 2;
            TASAREAL = (TASA/PLAZO);
            MONTO_APROBADO = -(MONTO_SOLICITADO);
            VALOR_CUOTA = pago(TASAREAL, QUINCENAS, MONTO_APROBADO);

            console.log('VALOR_CUOTA:', VALOR_CUOTA);
            console.log('QUINCENAS:', QUINCENAS);
            console.log('TASA REAL:', TASAREAL);
            console.log('MONTO APROBADO:', MONTO_APROBADO);

        }


        function pago(tasa, nper, va) {
            try {
                if (isNaN(tasa) || isNaN(nper) || isNaN(va)) {
                    throw new Error("Los parámetros deben ser numéricos.");
                }
                const vp = va * Math.pow(1 + tasa, -nper);
                const f_desc = 1 / (1 - Math.pow(1 + tasa, -nper));

                return parseFloat((vp * f_desc).toFixed(5));

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