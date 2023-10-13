<?php

session_start();
require "../../Config/conexion.php";


$id_usuario = $_SESSION['id_usuario'];
$conexion = new Conectar();
$conn = $conexion->Conexion();

$sql = "SELECT * FROM tbl_ms_parametros";
$stmt = $conn->prepare($sql);
$stmt->execute();
$parametros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el valor de la columna 'valor' en la tabla 'tbl_ms_parametros' con id_parametro igual a 3
$sqlParametros = "SELECT valor FROM tbl_ms_parametros WHERE id_parametro = 3";
$stmtParametros = $conn->prepare($sqlParametros);
$stmtParametros->execute();
$parametro = $stmtParametros->fetch(PDO::FETCH_ASSOC);

$valorParametro = $parametro['valor']; // Valor de la columna 'valor'

if ($valorParametro < 0) {
    // Obtener la cantidad de preguntas contestadas por el usuario
    $sqlPreguntasContestadas = "SELECT PREGUNTAS_CONTESTADAS FROM tbl_ms_usuario WHERE ID_USUARIO = $id_usuario";
    $stmtPreguntasContestadas = $conn->prepare($sqlPreguntasContestadas);
    $stmtPreguntasContestadas->execute();
    $preguntasContestadas = $stmtPreguntasContestadas->fetchColumn();
    echo($preguntasContestadas);
    if ($preguntasContestadas == $valorParametro) {
        echo($preguntasContestadas);
        // Actualizar el estado del usuario en tbl_ms_estadoUsuario
        $sqlActualizarEstado = "UPDATE `siaace`.`tbl_ms_usuario` SET ID_ESTADO_USUARIO = 1 WHERE ID_USUARIO = $id_usuario";
        $stmtActualizarEstado = $conn->prepare($sqlActualizarEstado);
        $stmtActualizarEstado->execute();
        // Redirigir al usuario a login.php
        echo "<script>window.location.href = '../../InicioSesion/cambiocontrasena.php';</script>";
        exit;
    }
}

$sql1 = "UPDATE `siaace`.`tbl_ms_usuario` SET `PREGUNTAS_CONTESTADAS` = `PREGUNTAS_CONTESTADAS`+1
        WHERE  (`ID_USUARIO` = $id_usuario)";
$stmt1 = $conn->prepare($sql1);


// $sql2 = "UPDATE `siaace`.`tbl_ms_usuario` SET `ID_ESTADO_USUARIO` = 1
//         WHERE  (`ID_USUARIO` = $id_usuario)";
// $stmt2 = $conn->prepare($sql2);
?>
<style>
    .logo {
        width: 100px;
        /* Ancho deseado del logo */
        margin: 0 auto;
        /* Auto-centrar horizontalmente */
        display: block;
        /* Asegurarse de que sea un bloque para que el auto-centrado funcione */
    }
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Formulario de Preguntas de Seguridad</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <!-- Agrega los enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Formulario de Preguntas de Seguridad</h3><img src="../../src/Logo.png" alt="Logo SIAACE" class="logo">
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="preguntaSeguridad">Selecciona una pregunta de seguridad:</label>
                                            <select class="form-control" id="preguntaSeguridad" name="preguntaSeguridad">
                                                <!-- Agrega más opciones de preguntas aquí -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="respuestaSeguridad">Tu respuesta:</label>
                                            <input type="text" class="form-control" id="respuestaSeguridad" name="respuestaSeguridad" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="btn-enviar" onclick="EnviarRespuestas()">Enviar</button>
                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
        
    </div>
    <!-- Agrega los enlaces a los archivos JavaScript de Bootstrap (jQuery y Popper.js) y Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>


    <script>
        function cargarPreguntas() {


            var ID = <?php echo json_encode($id_usuario); ?>;
            var data = {
                "ID_USUARIO": ID
            };

            // Realiza una solicitud fetch para obtener la lista de preguntas desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/preguntas.php?op=GetPreguntas', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el objeto en formato JSON
                })
                .then(response => response.json()) // Parsea la respuesta como JSON
                .then(data => {
                    // Limpia el select actual
                    var selectElement = document.getElementById('preguntaSeguridad');
                    selectElement.innerHTML = '';

                    // Itera sobre las preguntas y agrega cada una como una opción al select
                    data.forEach(function(pregunta) {
                        var option = document.createElement('option');
                        option.value = pregunta.ID_PREGUNTA; // El valor de la opción
                        option.text = pregunta.PREGUNTA; // El texto visible de la opción
                        selectElement.appendChild(option);
                    });

                })
                .catch(error => {
                    console.error('Error al cargar las preguntas: ', error);
                });
        }

        function EnviarRespuestas() {


            var ID = <?php echo json_encode($id_usuario); ?>; //CUENTA LAS PREGUNTAS 
            var RESP = document.getElementById("respuestaSeguridad").value; // Obtener el valor de la respuesta

            // Obtener el elemento <select> y su opción seleccionada
            var selectElement = document.getElementById('preguntaSeguridad');
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            // Obtener el valor de la opción seleccionada (que representa el ID de la pregunta)
            var ID_PREGUNTA = selectedOption.value;

            // Crear el objeto de datos con el ID de pregunta, ID de usuario y respuesta
            var data = {
                "ID_PREGUNTA": ID_PREGUNTA,
                "ID_USUARIO": ID,
                "RESPUESTAS": RESP
            };

            // Realizar una solicitud POST utilizando fetch
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/preguntas.php?op=InsertRespuesta', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convertir el objeto de datos a JSON
                })
                .then(response => response.json())
                .then(data => {
                    // Manejar la respuesta del servidor si es necesario
                    console.log(data);
                    <?php

                    $stmt1->execute();

                    ?>;
                })
                .catch(error => {
                    // Manejar errores si ocurren durante la solicitud
                    console.error('Error:', error);
                });



        }



        // Llama a la función cargarPreguntas para cargar las preguntas al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarPreguntas();
        });
    </script>


  
</body>

</html>