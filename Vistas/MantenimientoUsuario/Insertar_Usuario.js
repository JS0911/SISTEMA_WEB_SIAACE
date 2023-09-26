
$(document).ready(function() {
    // Evento de clic en el botón "Guardar"
    $("#btn-agregar").click(function() {
        // Obtener los valores de los campos del formulario
        var usuario = $("#agregar-usuario").val();
        var nombre = $("#agregar-nombre").val();
        var estado = $("#agregar-estado").val();
        var correo = $("#agregar-correo").val();
        var rol = $("#agregar-rol").val();
        var contrasena = $("#agregar-contrasena").val();
        var confirmarContrasena = $("#confirmar-contrasena").val();
        
        // Verificar que las contraseñas coincidan
        if (contrasena !== confirmarContrasena) {
            alert("Las contraseñas no coinciden.");
            return;
        }
        
        // Crear un objeto con los datos a enviar al servidor
        var datos = {
            USUARIO: usuario,
            NOMBRE_USUARIO: nombre,
            ID_ESTADO_USUARIO: estado,
            CORREO_ELECTRONICO: correo,
            ID_ROL: rol,
            CONTRASENA: contrasena
        };

        fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/usuarios.php?op=InsertUsuarios', {
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
            alert(data);
            // Cerrar la modal después de guardar
            $('#crearModal').modal('hide');
        })
        .catch(function(error) {
            // Manejar el error aquí
            alert('Error al guardar el usuario: ' + error.message);
        });            
    });
});
