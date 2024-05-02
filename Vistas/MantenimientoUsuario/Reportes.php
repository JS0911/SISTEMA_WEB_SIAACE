<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Reportes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Generador de Reportes</h2>
        <form id="reporteForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipoReporte">Seleccione un tipo de reporte:</label>
                    <select class="form-control" id="tipoReporte">
                        <option value="ReporteAnulaciones">Reporte de Anulaciones</option>
                        <!-- Agrega aquí más opciones de reporte según tus necesidades -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="fechaInicio">Fecha de inicio:</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                </div>
                <div class="form-group col-md-6">
                    <label for="fechaFin">Fecha de fin:</label>
                    <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>

        <!-- Contenedor para mostrar el resultado del reporte -->
        <div id="reporteContainer"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('reporteForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Evitar que se envíe el formulario normalmente

                // Obtener el tipo de reporte y las fechas del formulario
                var tipoReporte = document.getElementById('tipoReporte').value;
                var fechaInicio = document.getElementById('fechaInicio').value;
                var fechaFin = document.getElementById('fechaFin').value;

                // Realizar la solicitud fetch al servidor
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/reportes.php?op=' + tipoReporte, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin
                    })
                })
                .then(response => response.json()) // Convertir la respuesta a JSON
                .then(data => {
                    // Crear la tabla con los datos del reporte
                    var tableHTML = '<table class="table">';
                    tableHTML += '<thead><tr>';
                    tableHTML += '<th>ELABORADO POR</th>';
                    tableHTML += '<th>FECHA</th>';
                    tableHTML += '<th>MONTO</th>';
                    tableHTML += '<th>DESCRIPCIÓN</th>';
                    tableHTML += '</tr></thead>';
                    tableHTML += '<tbody>';
                    data.forEach(item => {
                        tableHTML += '<tr>';
                        tableHTML += `<td>${item.CREADO_POR}</td>`;
                        tableHTML += `<td>${item.FECHA}</td>`;
                        tableHTML += `<td>${item.MONTO}</td>`;
                        tableHTML += `<td>${item.DESCRIPCION}</td>`;
                        tableHTML += '</tr>';
                    });
                    tableHTML += '</tbody></table>';

                    // Mostrar la tabla en el contenedor
                    document.getElementById('reporteContainer').innerHTML = tableHTML;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>
