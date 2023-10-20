<?php

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosObjetos = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Objetos = "5";

$permisos = $permisosObjetos->get_Permisos_Usuarios($id_rol, $id_objeto_Objetos);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-objetos {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-objetos th {
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
        #Lista-objetos td {
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
                        <a class="nav-link" href="../charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Dashboard
                        </a>

                        <?php
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                    <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                    Modulo seguridad
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                            }

                            echo '<a class="nav-link" href="roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                            echo '<a class="nav-link" href="permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                            echo '<a class="nav-link" href="objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                            echo '<a class="nav-link" href="parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                            echo '<a class="nav-link" href="estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                            echo '<a class="nav-link" href="bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';

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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE OBJETOS -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Objetos</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?>
                        </div>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-objetos" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>Objeto</th>
                                    <th>Descripcion</th>
                                    <th>Tipo Objeto</th>
                                    <th>Creado por</th>
                                    <th>Modificado por</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha modicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
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
                                        <input type="text" maxlength="100" class="form-control" id="agregar-objeto" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje1"></div>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-descripcion" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        <label for="estado">Tipo Objeto</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-tipoObjeto" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje3"></div>
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
                                        <input type="text" class="form-control" id="editar-id-objeto" disabled>
                                        <label for="nombre">Objeto</label>
                                        <input type="text" class="form-control" id="editar-objeto" disabled>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="100" class="form-control" id="editar-descripcion" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje4"></div>

                                        <label for="estado">Tipo Objeto</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-tipoObjeto" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje5"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateObjeto()" disabled>Guardar</button>
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
            // Actualizar el valor predeterminado
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
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(objeto) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + objeto.ID_OBJETO + '</td>' +
                            '<td>' + objeto.OBJETO + '</td>' +
                            '<td>' + objeto.DESCRIPCION + '</td>' +
                            '<td>' + objeto.TIPO_OBJETO + '</td>' +
                            '<td>' + objeto.CREADO_POR + '</td>' +
                            '<td>' + objeto.MODIFICADO_POR + '</td>' +
                            '<td>' + objeto.FECHA_CREACION + '</td>' +
                            '<td>' + objeto.FECHA_MODIFICACION + '</td>' +
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
                    habilitarPaginacion();
                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }

        function habilitarPaginacion() {
            $('#Lista-objetos').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        
        function Insertar_Objeto() {
            $("#btn-agregar").click(function () {
                // Obtener los valores de los campos del formulario
                var objeto = $("#agregar-objeto").val();
                var descripcion = $("#agregar-descripcion").val();
                var tipo_objeto = $("#agregar-tipoObjeto").val();

                if (objeto == "" || descripcion == "" || tipo_objeto == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
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
                    .then(function (response) {
                        if (response.ok) {
                            if (response.status === 200) {
                                return response.json();
                            } else if (response.status === 409) {
                                return response.json().then(function (data) {
                                    throw new Error(data.error);
                                });
                            }
                        } else {
                            throw new Error('Error en la solicitud');
                        }
                    })
                    .then(function (data) {
                        console.log(data);
                        $('#crearModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado exitoso',
                            text: data.message
                        })
                        .then(function () {
                            location.reload();
                        });
                    })
                    .catch(function (error) {
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
                    alert('Error al cargar los datos del Objeto : ' + error.message);
                });
        }

        function updateObjeto() {
            var id_objeto = document.getElementById('editar-id-objeto').value;
            var objeto = document.getElementById('editar-objeto').value;
            var descripcion = document.getElementById('editar-descripcion').value;
            var tipo_objeto = document.getElementById('editar-tipoObjeto').value;

            if (objeto == "" || descripcion == "" || tipo_objeto == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
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
                            text: 'Error al actualizar los datos del permiso: ' + error.message
                        });
                    });
            }
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
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
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
                                Swal.fire('Objeto eliminado', '', 'success')
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
                            Swal.fire('Error', 'Error al eliminar el Objeto: ' + error.message, 'error');
                        });
                }
            });
        }

        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            nombreObjeto = document.getElementById("agregar-objeto");
            descripcion = document.getElementById("agregar-descripcion");
            tipoObjeto = document.getElementById("agregar-tipoObjeto");
            descripcionEditar = document.getElementById("editar-descripcion");
            tipoObjetoEditar = document.getElementById("editar-tipoObjeto");

            nombreObjeto.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    nombreObjeto.style.borderColor = "red";
                    nombreObjeto.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje1").style.color = "red";
                    e.preventDefault();
                } else {
                    nombreObjeto.style.borderColor = "green";
                    nombreObjeto.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje1").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje1").style.color = "green";
                }
            });

            descripcion.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z0-9\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    descripcion.style.borderColor = "red";
                    descripcion.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje2").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        descripcion.style.borderColor = "red";
                        descripcion.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje2").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        descripcion.style.borderColor = "green";
                        descripcion.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje2").style.color = "green";
                    }
                }
            });

            tipoObjeto.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    tipoObjeto.style.borderColor = "red";
                    tipoObjeto.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje3").style.color = "red";
                    e.preventDefault();
                } else {
                    tipoObjeto.style.borderColor = "green";
                    tipoObjeto.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje3").style.color = "green";
                }
            });

            descripcionEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z0-9\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    descripcionEditar.style.borderColor = "red";
                    descripcionEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje4").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        descripcionEditar.style.borderColor = "red";
                        descripcionEditar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje4").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        descripcionEditar.style.borderColor = "green";
                        descripcionEditar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje4").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje4").style.color = "green";
                    }
                }
            });

            tipoObjetoEditar.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    tipoObjetoEditar.style.borderColor = "red";
                    tipoObjetoEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje5").style.color = "red";
                    e.preventDefault();
                } else {
                    tipoObjetoEditar.style.borderColor = "green";
                    tipoObjetoEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje5").style.color = "green";
                }
            });
        }

        $(document).ready(function() {
            Lista_Objetos();
            Insertar_Objeto();
            validarNombre();
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const objetoInput = document.getElementById('agregar-objeto');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const tipoObjetoInput = document.getElementById('agregar-tipoObjeto');
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = objetoInput.value.trim() !== '' && descripcionInput.value.trim() !== '' && tipoObjetoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        objetoInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
        tipoObjetoInput.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const tipoObjetoInput1 = document.getElementById('editar-tipoObjeto');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = descripcionInput1.value.trim() !== '' && tipoObjetoInput1.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        descripcionInput1.addEventListener('input', checkForm);
        tipoObjetoInput1.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-objeto, #agregar-tipoObjeto').on('input', function() {
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

        // Escuchar eventos de cambio en los campos de entrada deshabilitados para eliminar espacios en blanco al principio y al final
        $('#editar-objeto, #editar-tipoObjeto').on('input', function() {
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
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL AGREGAR--------------------
        document.getElementById('btn-cancelarAgregar').addEventListener('click', function() {
        document.getElementById('agregar-objeto').value = "";
        document.getElementById('agregar-descripcion').value = "";
        document.getElementById('agregar-tipoObjeto').value = "";

        // Limpia los checkboxes
        document.getElementById('agregar-objeto').checked = false;
        document.getElementById('agregar-descripcion').checked = false;
        document.getElementById('agregar-tipoObjeto').checked = false;
        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {
       
        // Limpia los checkboxes
        document.getElementById('editar-objeto').checked = false;
        document.getElementById('editar-descripcion').checked = false;
        document.getElementById('editar-tipoObjeto').checked = false;
        });
    </script>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>

    
</body>

</html>