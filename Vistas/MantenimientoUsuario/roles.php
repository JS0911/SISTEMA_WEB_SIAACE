<?php 

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosRoles = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Roles = "1";
$id_objeto_Seguridad = "25";

$permisos1 = $permisosRoles->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosRoles->get_Permisos_Usuarios($id_rol, $id_objeto_Roles);

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
    <title>Mantenimiento Roles</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-rol {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-rol th {
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
        #Lista-rol td {
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
                               echo '<a class="nav-link" href="bitacora.php"><i class="fa fa-book" aria-hidden="true"></i></i><span style="margin-left: 5px;"> Bitacora </a>';
    
                                
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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE ROLES -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Roles</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?> 
                        </div>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-rol" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>Rol</th>
                                    <th>Descripcion</th>
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


                                        <label for="nombre">Rol</label>
                                        <input type="text" maxlength="100" class="form-control" id="agregar-rol" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        <label for="estado">Descripcion</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-descripcion" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje3"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
                                        <input type="text" class="form-control" id="editar-id-rol" disabled>
                            
                                        <label for="nombre">Rol</label>
                                        <input type="text" maxlength="100" class="form-control" id="editar-rol" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje4"></div>
                                        
                                        <label for="estado">Desripcion</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-descripcion" 
                                        required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje5"></div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateRol()" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE ROLES -->

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
                                
        function Lista_Roles() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/roles.php?op=GetRoles', {
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
                    var tbody = document.querySelector('#Lista-rol tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(rol) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + rol.ID_ROL + '</td>' +
                            '<td>' + rol.ROL + '</td>' +
                            '<td>' + rol.DESCRIPCION + '</td>' +

                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarRol(' + rol.ID_ROL+ ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-rol" data-id="' + rol.ID_ROL + '" onclick="eliminarRol(' + rol.ID_ROL + ')">Eliminar</button>';
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
            $('#Lista-rol').DataTable({
                "paging": true, 
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Rol() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var rol = $("#agregar-rol").val();
                var descripcion = $("#agregar-descripcion").val();

                if (rol == "" || descripcion == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    })
                } else {
                    // Crear un rol con los datos a enviar al servidor
                    var datos = {
                        ROL: rol,
                    DESCRIPCION: descripcion,                                       

                    };

                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/roles.php?op=InsertRol', {
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

        function cargarRol(id) {
            // Crear un rol con el ID del rol
            var data = {
                "ID_ROL": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del rol por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/roles.php?op=GetRol', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el rol en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(rol) {
                    // Llena los campos del modal con los datos del rol
                    document.getElementById('editar-id-rol').value = rol.ID_ROL;
                    document.getElementById('editar-rol').value = rol.ROL;
                    document.getElementById('editar-descripcion').value = rol.DESCRIPCION;
               })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del Rol : ' + error.message);
                });
        }

        function updateRol() {
            var id_rol = document.getElementById('editar-id-rol').value;
            var rol = document.getElementById('editar-rol').value;
            var descripcion = document.getElementById('editar-descripcion').value;

            if (rol == "" || descripcion == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
            // Realiza una solicitud FETCH para actualizar los datos del rol
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/roles.php?op=UpdateRol', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_ROL": id_rol,
                        "ROL": rol,
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
                        text: 'Error al actualizar los datos del permiso: ' + error.message
                    });
                });
            }    
        }

        //FUNCION CON EL SWEETALERT
        function eliminarRol(id_rol) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'eliminar',
                cancelButtonText: 'Cancelar' 
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/roles.php?op=EliminarRol', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_ROL": id_rol
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Rol eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de objetos después de eliminar
                                        //Lista_Roles();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el rol: ' + error.message, 'error');
                        });
                }
            });
        }

        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            rol = document.getElementById("agregar-rol");
            descripcion = document.getElementById("agregar-descripcion");
            rolEditar = document.getElementById("editar-rol");
            descripcionEditar = document.getElementById("editar-descripcion");

           
            rol.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z0-9\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    rol.style.borderColor = "red";
                    rol.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje2").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        rol.style.borderColor = "red";
                        rol.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje2").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        rol.style.borderColor = "green";
                        rol.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje2").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje2").style.color = "green";
                    }
                }
            });

            descripcion.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    descripcion.style.borderColor = "red";
                    descripcion.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje3").style.color = "red";
                    e.preventDefault();
                } else {
                    descripcion.style.borderColor = "green";
                    descripcion.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje3").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje3").style.color = "green";
                }
            });

            rolEditar.addEventListener("keypress", function(e) {
                expresionValidadora2 = /^[A-Z0-9\s]+$/;
                if (localStorage.getItem("letraAnterior") == 32 && e.keyCode == 32) {
                    rolEditar.style.borderColor = "red";
                    rolEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten 1 espacio en blanco entre palabras.";
                    document.getElementById("mensaje4").style.color = "red";
                    e.preventDefault();
                } else {
                    if (!expresionValidadora2.test(e.key)) {
                        rolEditar.style.borderColor = "red";
                        rolEditar.style.boxShadow = "0 0 10px red";
                        document.getElementById("mensaje4").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                        document.getElementById("mensaje4").style.color = "red";
                        e.preventDefault();
                    } else {
                        localStorage.setItem("letraAnterior", e.keyCode);
                        rolEditar.style.borderColor = "green";
                        rolEditar.style.boxShadow = "0 0 10px green";
                        document.getElementById("mensaje4").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                        document.getElementById("mensaje4").style.color = "green";
                    }
                }
            });

            descripcionEditar.addEventListener("keypress", function(e) {
                expresionValidadora1 = /^[A-Z]+$/;

                if (!expresionValidadora1.test(e.key)) {
                    descripcionEditar.style.borderColor = "red";
                    descripcionEditar.style.boxShadow = "0 0 10px red";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-times-circle'></i> Solo se permiten Letras Mayusculas";
                    document.getElementById("mensaje5").style.color = "red";
                    e.preventDefault();
                } else {
                    descripcionEditar.style.borderColor = "green";
                    descripcionEditar.style.boxShadow = "0 0 10px green";
                    document.getElementById("mensaje5").innerHTML = "<i class='fas fa-check-circle'></i> Campo Valido!";
                    document.getElementById("mensaje5").style.color = "green";
                }
            });
        }

        $(document).ready(function() {
            Lista_Roles();
            Insertar_Rol();
            validarNombre();
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
       
        const rolInput = document.getElementById('agregar-rol');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid =  rolInput.value.trim() !== '' && descripcionInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        rolInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
    </script>
    
    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const rolInput1 = document.getElementById('editar-rol');
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = rolInput1.value.trim() !== '' && descripcionInput1.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        rolInput1.addEventListener('input', checkForm);
        descripcionInput1.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-rol, #agregar-descripcion').on('input', function() {
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
        $('#editar-rol, #editar-descripcion').on('input', function() {
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>