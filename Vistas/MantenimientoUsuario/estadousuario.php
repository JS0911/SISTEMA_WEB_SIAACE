<?php 

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosEstados = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Estados = "6";
$id_objeto_Seguridad = "25";

$permisos1 = $permisosEstados->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosEstados->get_Permisos_Usuarios($id_rol, $id_objeto_Estados)

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
    <title>Mantenimiento Estado Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-estados {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-estados th {
            border: 2px solid white;
            /* Bordes negros para las celdas del encabezado */
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
            /* Cambia el tipo de letra */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
        }

        /* Estilo para las celdas de datos (td) */
        #Lista-estados td {
            border: 1px solid grey;
            /* Bordes negros para las celdas de datos */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
        }

        /* Estilo personalizado para el placeholder */
        #myInput {
            border: 1px solid #000;
            /* Borde más oscuro, en este caso, negro (#000) */
        }

        /*BOTON DE CREAR NUEVO */
        .custom-button {
            background-color: #4CAF50;
            /* Verde */
            color: #fff;
            /* Texto en blanco */
            border: 2px solid #4CAF50;
            /* Borde verde */
            margin-top: 1px;

        }
    </style>

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

                        <div class="sb-sidenav-menu-heading">Pestañas</div>

                        <?php
                        if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Modulo seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                echo '<a class="nav-link" href="roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                echo '<a class="nav-link" href="permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                echo '<a class="nav-link" href="bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
    
                            }
                            echo '</nav>';
                            echo '</div>';
                        }
                         //-------------------------MODULO DE EMPLEADO---------------------------------------------
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Modulo Empleado
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                    echo '<a class="nav-link" href="../MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';

                                }
                            echo '</nav>';
                            echo '</div>';
                        }


                        ?>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado a Sistema:</div>
                    SIAACE - IDH Microfinanciera
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE ESTADOS -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Estados de Usuario</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?>
                            <!--<div class="d-flex align-items-center w-50">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>--> <!-- Puedes usar una fuente de iconos como Font Awesome -->
                                        <!--</span>
                                    </div>
                                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                                </div>
                            </div>-->
                        </div>

                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-estados" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id</th> <!-- Ocultar el ID -->
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <!--<nav aria-label="Pagination" class="pagination-container">
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
                        </nav>-->
                    </div>

                </div>

                <!-- Modal para crear un nuevo estado -->
                <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalLabel">Nuevo Estado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="agregar-nombre" maxlength="15" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje1"></div>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" class="form-control" id="agregar-descripcion" maxlength="15" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-agregar" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar un estado -->
                <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarModalLabel">Editar Estado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de edición -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Id</label>
                                        <input type="text" class="form-control" id="editar-id-estado" disabled>
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="editar-nombre" maxlength="15" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje3"></div>
                                        <label for="nombre">Descripcion</label>
                                        <input type="text" class="form-control" id="editar-descripcion" maxlength="15" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje4"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateEstado()" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE ESTADOS -->

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

        function Lista_Estados() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/estadousuario.php?op=GetEstados', {
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
                    var tbody = document.querySelector('#Lista-estados tbody');
                    tbody.innerHTML = ''; // Limpiar el contenido anterior////////////////////////////

                    data.forEach(function(estado) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + estado.ID_ESTADO_USUARIO + '</td>' + // Ocultar el ID
                            '<td>' + estado.NOMBRE + '</td>' +
                            '<td>' + estado.DESCRIPCION + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarEstado(' + estado.ID_ESTADO_USUARIO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-estado" data-id="' + estado.ID_ESTADO_USUARIO + '" onclick="eliminarEstado(' + estado.ID_ESTADO_USUARIO + ')">Eliminar</button>';
                        }


                        row += '</td>' +
                            '</tr>';
                        tbody.innerHTML += row;
                    });

                    habilitarPaginacion();
                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }

        function habilitarPaginacion() {
            $('#Lista-estados').DataTable({
                "paging": true, 
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Estado() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var nombre = $("#agregar-nombre").val();
                var descripcion = $("#agregar-descripcion").val();

                if (nombre == "" || descripcion == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    })
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        NOMBRE: nombre,
                        DESCRIPCION: descripcion,

                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/estadousuario.php?op=InsertEstado', {
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
                            // Cerrar la modal después de guardar
                            $('#crearModal').modal('hide');

                            // Mostrar SweetAlert de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado exitoso',
                                text: 'Los datos se han guardado correctamente.'
                            }).then(function() {
                                // Recargar la página para mostrar los nuevos datos
                                location.reload();
                            });
                        })
                        .catch(function(error) {
                            // Mostrar SweetAlert de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar los datos: ' + error.message
                            });
                            console.log(error.message);
                        });
                }
            });
        }

        function cargarEstado(id) {
            // Crear un objeto con el ID del estado
            var data = {
                "ID_ESTADO_USUARIO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del estado por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/estadousuario.php?op=GetEstado', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el estado en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(estado) {
                    // Llena los campos del modal con los datos del estado
                    document.getElementById('editar-id-estado').value = estado.ID_ESTADO_USUARIO;
                    document.getElementById('editar-nombre').value = estado.NOMBRE;
                    document.getElementById('editar-descripcion').value = estado.DESCRIPCION;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del estado : ' + error.message);
                });
        }

        function updateEstado() {
            var id_estado = document.getElementById('editar-id-estado').value;
            var nombre = document.getElementById('editar-nombre').value;
            var descripcion = document.getElementById('editar-descripcion').value;


            if (nombre == "" || descripcion == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
                // Realiza una solicitud FETCH para actualizar los datos del estado
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/estadousuario.php?op=UpdateEstado', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            "ID_ESTADO_USUARIO": id_estado,
                            "NOMBRE": nombre,
                            "DESCRIPCION": descripcion
                        }) // Convierte los datos en formato JSON
                    })
                    .then(function(response) {
                        if (response.ok) {
                            // Cerrar la modal después de guardar
                            $('#editarModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Actualización exitosa',
                                text: 'Los datos se han actualizado correctamente.'
                            }).then(function() {
                                // Recargar la página para mostrar los nuevos datos
                                location.reload();
                            });

                        } else {
                            throw new Error('Error en la solicitud de actualización');
                        }
                    })
                    .catch(function(error) {
                        // Manejar el error aquí
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al actualizar los datos del estado: ' + error.message
                        });
                    });
            }
        }

        //FUNCION CON EL SWEETALERT
        function eliminarEstado(id_estado) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/estadousuario.php?op=EliminarEstado', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_ESTADO_USUARIO": id_estado
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Estado eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de estados después de eliminar
                                        //Lista_estados();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el estado: ' + error.message, 'error');
                        });
                }
            });
        }

        // VALIDACIONES FUNCIONES  
        function validarNombre() {
            var nombreEstado = document.getElementById("agregar-nombre");
            var descripcion = document.getElementById("agregar-descripcion");
            var nombreEditar =document.getElementById("editar-nombre");
            var descripcionEditar = document.getElementById("editar-descripcion");

            function clearMessage(messageElement, inputElement) {
                messageElement.innerHTML = ""; // Elimina el contenido del mensaje
                inputElement.style.borderColor = ""; // Restablece el borde
                inputElement.style.boxShadow = ""; // Restablece la sombra
            }

            function validateInput(inputElement, expression, messageElement, message) {
                if (inputElement.value === "") {
                    clearMessage(messageElement, inputElement);
                } else if (!expression.test(inputElement.value)) {
                    inputElement.style.borderColor = "red";
                    inputElement.style.boxShadow = "0 0 10px red";
                    messageElement.innerHTML = "<i class='fas fa-times-circle'></i> " + message;
                    messageElement.style.color = "red";
                } else {
                    clearMessage(messageElement, inputElement); // Restablece los estilos
                    messageElement.innerHTML = "<i class='fas fa-check-circle'></i> Campo Válido!";
                    messageElement.style.color = "green";
                }
            }

            function handleInputAndBlurEvents(inputElement, expression, messageElement, message) {
                inputElement.addEventListener("input", function () {
                    validateInput(inputElement, expression, messageElement, message);
                });

                inputElement.addEventListener("blur", function () {
                    clearMessage(messageElement, inputElement);
                });
            }

            function handleDescriptionKeypressEvent(inputElement) {
                inputElement.addEventListener("keypress", function(e) {
                    var currentDescription = inputElement.value;
                    if (e.key === " " && currentDescription.endsWith(" ")) {
                        e.preventDefault();
                    }
                });
            }

            var expresionValidadora1 = /^[A-Z]+$/;
            var mensaje1 = document.getElementById("mensaje1");
            handleInputAndBlurEvents(nombreEstado, expresionValidadora1, mensaje1, "Solo se permiten Letras Mayúsculas");

            var expresionValidadora2 = /^[A-Z0-9\s]+$/;
            var mensaje2 = document.getElementById("mensaje2");
            handleInputAndBlurEvents(descripcion, expresionValidadora2, mensaje2, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcion);
            
            var mensaje3 = document.getElementById("mensaje3");
            handleInputAndBlurEvents(nombreEditar, expresionValidadora1, mensaje3, "Solo se permiten Letras Mayúsculas");

            var mensaje4 = document.getElementById("mensaje4");
            handleInputAndBlurEvents(descripcionEditar, expresionValidadora2, mensaje4, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcionEditar);
        }

        $(document).ready(function() {
            Lista_Estados();
            Insertar_Estado();
            validarNombre();
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const nombreInput = document.getElementById('agregar-nombre');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = nombreInput.value.trim() !== '' && descripcionInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        nombreInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
    </script>
    
    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const nombreInput1 = document.getElementById('editar-nombre');
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = nombreInput1.value.trim() !== '' && descripcionInput1.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        nombreInput1.addEventListener('input', checkForm);
        descripcionInput1.addEventListener('input', checkForm);
    </script>

    
    <script>
        // Escuchar eventos de cambio en los campos de entrada deshabilitados para eliminar espacios en blanco al principio y al final
        $('#agregar-nombre, #editar-nombre').on('input', function() {
            var input = $(this);
            var trimmedValue = input.val().trim();
            input.val(trimmedValue);
            
            if (trimmedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'El campo no puede estar vacío',
                    icon: 'warning',
                });
            }
        });

        // Validar que no hayan campos vacios
        $('#agregar-descripcion, #editar-descripcion').on('input', function() {
            var input = $(this);
            var trimmedValue = input.val();
            input.val(trimmedValue);
            
            if (trimmedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'El campo no puede estar vacío',
                    icon: 'warning',
                });
            }
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL AGREGAR--------------------
        document.getElementById('btn-cancelarAgregar').addEventListener('click', function() {
        document.getElementById('agregar-nombre').value = "";
        document.getElementById('agregar-descripcion').value = "";

        // Limpia los checkboxes
        document.getElementById('agregar-nombre').checked = false;
        document.getElementById('agregar-descripcion').checked = false;

            location.reload();  

        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {
       
        // Limpia los checkboxes
        document.getElementById('editar-nombre').checked = false;
        document.getElementById('editar-descripcion').checked = false;
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

</body>

</html>