<?php

session_start();
require "../../Config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$conexion = new Conectar();
$conn = $conexion->Conexion();
  
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Preguntas de Seguridad</title>
    <!-- Agrega los enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Formulario de Preguntas de Seguridad</h1>
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

<!-- Agrega los enlaces a los archivos JavaScript de Bootstrap (jQuery y Popper.js) y Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
    var ID = <?php echo json_encode($id_usuario); ?>;
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
    })
    .catch(error => {
        // Manejar errores si ocurren durante la solicitud
        console.error('Error:', error);
    });
}

function ContarPreguntas(){

}


// Llama a la función cargarPreguntas para cargar las preguntas al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarPreguntas();
});
</script>

</body>
</html>
