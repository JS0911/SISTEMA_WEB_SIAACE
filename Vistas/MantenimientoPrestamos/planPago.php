<?php
session_start();
require "../../Config/conexion.php";
//require_once "../../Modelos/permisoUsuario.php";


if (isset($_GET['ID_PRESTAMOP'], $_GET['MONTO_SOLICITADO'], $_GET['PLAZO'], $_GET['TASA'])) {
    $ID_PRESTAMOP = $_GET['ID_PRESTAMOP'];
    $MONTO_SOLICITADO = $_GET['MONTO_SOLICITADO'];
    $PLAZO = $_GET['PLAZO'];
    $TASA = $_GET['TASA'];
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body >
    <!-- <div class="container">
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
    </div> -->



    <script>
        var ID_PRESTAMOP = <?php echo json_encode($ID_PRESTAMOP); ?>;
        var PLAZO = <?php echo json_encode($PLAZO); ?>;
        var MONTO_SOLICITADO = <?php echo json_encode($MONTO_SOLICITADO); ?>;
        var TASA = <?php echo json_encode($TASA); ?>;
        var PLAZOQUINCENAS = PLAZO * 2;

        function Insertar_Amortizacion() {
           if (PLAZO == "" || MONTO_SOLICITADO == "" || TASA == "" || PLAZOQUINCENAS == "" ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        ID_PRESTAMO: ID_PRESTAMOP,
                        TASA: TASA,
                        PLAZO: PLAZO,
                        MONTO_SOLICITADO: MONTO_SOLICITADO,
                        PLAZOQUINCENAS: PLAZOQUINCENAS
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/planPago.php?op=InsertarAmortizacion', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(datos)
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Si la solicitud fue exitosa, puedes manejar la respuesta aquí
                                return response.json();
                            } else {
                                // Si hubo un error en la solicitud, maneja el error aquí
                                throw new Error('Error en la solicitud');
                            }
                        })
                        .then(function(data) {
                            console.log(data);

                            // Mostrar SweetAlert de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado exitoso',
                                text: 'Plan de pago Creado Exitosamente.'
                            }).then(function() {
                                // Recargar la página para mostrar los nuevos datos
                                //location.reload();
                                window.location.href = 'prestamo.php';
                            });

                        })
                        .catch(function(error) {
                            console.log(error.message);

                            // Mostrar SweetAlert de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar los datos: ' + error.message
                            });
                        });
                }

        }

        $(document).ready(function() {
            //Lista_Prestamo();
            Insertar_Amortizacion();
        });
    </script>
</body>

</html>