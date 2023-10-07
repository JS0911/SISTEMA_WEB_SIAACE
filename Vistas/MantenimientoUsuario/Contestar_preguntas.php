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
        <button type="submit" class="btn btn-primary" id="btn-enviar">Enviar</button>
    </form>
</div>

<!-- Agrega los enlaces a los archivos JavaScript de Bootstrap (jQuery y Popper.js) y Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function cargarPreguntas() {
    // Realiza una solicitud fetch para obtener la lista de preguntas desde tu servidor
    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/preguntas.php?op=GetPreguntas')
        .then(response => response.json()) // Parsea la respuesta como JSON
        .then(data => {
            // 'data' contiene la lista de preguntas en formato JSON

            // Limpia el select actual
            document.getElementById('preguntaSeguridad').innerHTML = '';

            // Itera sobre las preguntas y agrega cada una como una opción al select
            data.forEach(function(pregunta) {
            var option = document.createElement('option');
            option.value = pregunta.ID_PREGUNTA; // El valor de la opción
            option.text = pregunta.PREGUNTA; // El valor de la opción
            document.getElementById('preguntaSeguridad').appendChild(option);
});

        })
        .catch(error => {
            console.error('Error al cargar las preguntas: ', error);
        });
}

function GuardarRespuestas() {
    
 
}

// Llama a la función cargarPreguntas para cargar las preguntas al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarPreguntas();
});
</script>

</body>
</html>
