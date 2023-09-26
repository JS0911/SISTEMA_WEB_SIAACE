document.addEventListener('DOMContentLoaded', function() {
    // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=GetUsuarios', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
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
        // Recorre los datos JSON y agrega filas a la tabla
        var tbody = document.querySelector('#Lista-Usuarios tbody');
        data.forEach(function(usuario) {
            var row = '<tr>' +
                '<td>' + usuario.ID_USUARIO + '</td>' +
                '<td>' + usuario.USUARIO + '</td>' +
                '<td>' + usuario.NOMBRE_USUARIO + '</td>' +
                '<td>' + usuario.ID_ESTADO_USUARIO + '</td>' +
                '<td>' + usuario.CORREO_ELECTRONICO + '</td>' +
                '<td>' + usuario.ID_ROL + '</td>' +
                '<td>' +
                '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal">Editar</button>' +
                '<button class="btn btn-danger">Eliminar</button>' +
                '</td>' +
                '</tr>';
            tbody.innerHTML += row;
        });
    })
    .catch(function(error) {
        // Manejar el error aquí
        alert('Error al cargar los datos: ' + error.message);
    });
});
