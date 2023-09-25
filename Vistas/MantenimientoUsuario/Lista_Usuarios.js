
$(document).ready(function() {
    // Realizar una solicitud AJAX para obtener los datos JSON desde tu servidor
    $.ajax({
        url: 'http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=GetUsuarios',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Recorre los datos JSON y agrega filas a la tabla
            var tbody = $('#Lista-Usuarios tbody');
            $.each(data, function(index, usuario) {
                var row = '<tr>' +
                    '<td>' + usuario.ID_USUARIO + '</td>' +
                    '<td>' + usuario.USUARIO + '</td>' +
                    '<td>' + usuario.NOMBRE_USUARIO + '</td>' +
                    '<td>' + usuario.ID_ESTADO_USUARIO + '</td>' +
                    '<td>' + usuario.CORREO_ELECTRONICO + '</td>' +
                    '<td>' + usuario.ID_ROL + '</td>' +
                    '</tr>';
                tbody.append(row);
            });
        },
        error: function() {
            alert('Error al cargar los datos.');
        }
    });
});