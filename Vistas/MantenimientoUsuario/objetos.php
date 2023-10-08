<?php

session_start();
require "../../Config/conexion.php";
require_once '../../Modelos/permisoUsuario.php';

$permisosUsuarios = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Usuario = "2";

$permisos = $permisosUsuarios->get_Permisos_Usuarios($id_rol, $id_objeto_Usuario)

// Verificar si se obtuvieron resultados
// if (!empty($permisos)) {
//     // Recorrer el array de permisos y mostrar los valores
//     foreach ($permisos as $permiso) {
//         echo "PERMISOS_INSERCION: " . $permiso['PERMISOS_INSERCION'] . "<br>";
//         echo "PERMISOS_ELIMINACION: " . $permiso['PERMISOS_ELIMINACION'] . "<br>";
//         echo "PERMISOS_ACTUALIZACION: " . $permiso['PERMISOS_ACTUALIZACION'] . "<br>";
//         echo "PERMISOS_CONSULTAR: " . $permiso['PERMISOS_CONSULTAR'] . "<br>";
//     }
// } else {
//     echo "No se encontraron permisos para el rol y objeto especificados.";
// }

?>

<style>
    .logo {
        width: 50px;
        /* Ancho deseado del logo */
        margin-right: 10px;
        /* Espacio a la derecha del logo para separarlo del texto */
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento Usuario</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-objetos {
            border-collapse: collapse; /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-objetos th {
            border: 2px solid white; /* Bordes negros para las celdas del encabezado */
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif; /* Cambia el tipo de letra */
            padding: 8px; /* Espaciado interno para las celdas */
            text-align: center; /* Alineación del texto al centro */
        }

        /* Estilo para las celdas de datos (td) */
        #Lista-objetos td {
            border: 1px solid grey; /* Bordes negros para las celdas de datos */
            padding: 8px; /* Espaciado interno para las celdas */
            text-align: center; /* Alineación del texto al centro */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="../../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../../InicioSesion/cambiocontrasena.php">Cambiar Contraseña</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../InicioSesion/logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="../../InicioSesion/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Inicio
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="../charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts</a>
                            <?php
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            // Mostrar la pestaña de "objetos" si PERMISOS_CONSULTAR es igual a 1
                            echo '<a class="nav-link" href="../Vistas/MantenimientoUsuario/objetos.php">';
                            echo '<div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Objetos';
                            echo '</a>';

                        } else{
                            echo "No tiene permiso";
                        }
                        
                        ?>
                        <a class="nav-link" href="../../roles.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Roles
                        </a>
                        <a class="nav-link" href="permisos.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>Permisos
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado a Sistema:</div>
                    SIAACE - IDH Microfinanciera
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE OBJETOS -->
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Mantenimiento Objetos</h1>

                    <!-- Botón para abrir el formulario de creación -->
                    <?php
                    if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                        echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Crear Nuevo</button>';
                    }
                    ?>
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                    <!-- Tabla para mostrar los datos -->
                    <table class="table table-bordered" id="Lista-objetos">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Objeto</th>
                                <th>Descripcion</th>
                                <th>Tipo Objeto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <nav aria-label="Pagination">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Atrás</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">2</span>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Modal para crear un nuevo registro -->
                <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalLabel">Crear Nuevo Registro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Objeto</label>
                                        <input type="text" class="form-control" id="agregar-objeto">

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" class="form-control" id="agregar-descripcion">

                                        <label for="estado">Tipo Objeto</label>
                                        <input type="text" class="form-control" id="agregar-tipoObjeto">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="btn-agregar">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar un registro -->
                <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarModalLabel">Editar Registro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de edición -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Id</label>
                                        <input type="text" class="form-control" id="editar-id-objeto">
                                        <label for="nombre">Objeto</label>
                                        <input type="text" class="form-control" id="editar-objeto">
                                        <label for="nombre">Descripcion</label>
                                        <input type="text" class="form-control" id="editar-descripcion">
                                        <label for="estado">Tipo Objeto</label>
                                        <input type="text" class="form-control" id="editar-tipoObjeto">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="updateObjeto()">Guardar
                                    Cambios</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE OBJETOS -->

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-start justify-content-center small">
                        <div class="text-muted">Copyright &copy; IA-UNAH 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- EL CODIGO ESTA QUEMADO AQUI, NO FUNCIONA REFERENCIA A LOS ARCHIVOS -->
    <script>
        var permisos = <?php echo json_encode($permisos); ?>;

        function Lista_Objetos() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/objetos.php?op=GetObjetos', {
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
                    var tbody = document.querySelector('#Lista-objetos tbody');


                    data.forEach(function(objeto) {
                        var row = '<tr>' +
                            '<td>' + objeto.ID_OBJETO + '</td>' +
                            '<td>' + objeto.OBJETO + '</td>' +
                            '<td>' + objeto.DESCRIPCION + '</td>' +
                            '<td>' + objeto.TIPO_OBJETO + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarObjeto(' + objeto.ID_OBJETO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-objeto" data-id="' + objeto.ID_OBJETO + '" onclick="eliminarObjeto(' + objeto.ID_OBJETO + ')">Eliminar</button>';
                        }


                        row += '</td>' +
                            '</tr>';
                        tbody.innerHTML += row;
                    });


                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }

        function Insertar_Objeto() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var objeto = $("#agregar-objeto").val();
                var descripcion = $("#agregar-descripcion").val();
                var tipo_objeto = $("#agregar-tipoObjeto").val();

                // Crear un objeto con los datos a enviar al servidor
                var datos = {
                    OBJETO: objeto,
                    DESCRIPCION: descripcion,
                    TIPO_OBJETO: tipo_objeto,
                    
                };

                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/objetos.php?op=InsertObjeto', {
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

                        // Recargar la página para mostrar los nuevos datos
                        location.reload();

                    })
                    .catch(function(error) {
                        // Manejar el error aquí
                        alert('Error al guardar el objeto: ' + error.message);
                        console.log(error.message);
                    });
            });
        }

        function cargarObjeto(id) {
            // Crear un objeto con el ID del objeto
            var data = {
                "ID_OBJETO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del objeto por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/objetos.php?op=GetObjeto', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el objeto en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(objeto) {
                    // Llena los campos del modal con los datos del objeto
                    document.getElementById('editar-id-objeto').value = objeto.ID_OBJETO;
                    document.getElementById('editar-objeto').value = objeto.OBJETO;
                    document.getElementById('editar-descripcion').value = objeto.DESCRIPCION;
                    document.getElementById('editar-tipoObjeto').value = objeto.TIPO_OBJETO;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del objeto : ' + error.message);
                });
        }

        function updateObjeto() {
            var id_objeto = document.getElementById('editar-id-objeto').value;
            var objeto = document.getElementById('editar-objeto').value;
            var descripcion = document.getElementById('editar-descripcion').value;
            var tipo_objeto = document.getElementById('editar-tipoObjeto').value;

            // Realiza una solicitud FETCH para actualizar los datos del objeto
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/objetos.php?op=UpdateObjeto', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_OBJETO": id_objeto,
                        "OBJETO": objeto,
                        "DESCRIPCION": descripcion,
                        "TIPO_OBJETO": tipo_objeto
                    }) // Convierte los datos en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        // Cerrar la modal después de guardar
                        $('#editarModal').modal('hide');
                        // Actualización exitosa, puedes hacer algo aquí si es necesario
                        // Recargar la página para mostrar los nuevos datos
                        location.reload();
                        alert('Datos actualizados correctamente');

                    } else {
                        throw new Error('Error en la solicitud de actualización');
                    }
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al actualizar los datos del usuario: ' + error.message);
                });

        }

        //FUNCION CON EL SWEETALERT
        function eliminarObjeto(id_objeto) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/objetos.php?op=EliminarObjeto', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_OBJETO": id_objeto
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Usuario eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de objetos después de eliminar
                                        Lista_objetos();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el usuario: ' + error.message, 'error');
                        });
                }
            });
        }

        $(document).ready(function() {
            Lista_Objetos();
            Insertar_Objeto();
        });
    </script>

    <script>
    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#Lista-objetos tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/datatables-demo.js"></script>
</body>

</html>