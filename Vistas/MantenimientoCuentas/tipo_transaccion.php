<?php

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosTransaccion = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Transaccion = "11";
$id_objeto_Cuentas = "28";
$id_objeto_Seguridad = "25";

$permisos1 = $permisosTransaccion->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosTransaccion->get_Permisos_Usuarios($id_rol, $id_objeto_Transaccion);
$permisos2 = $permisosTransaccion->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);

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
    <title>Mantenimiento Transacción</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-transaccion {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-transaccion th {
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
        #Lista-transaccion td {
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
                        //----------------------------MODULO DE SEGURIDAD------------------------------------
                        if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                                        <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                        Modulo seguridad
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>';
                            echo '<div class="collapse" id="collapseMantenimiento" aria-labelledby="headingMantenimiento" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos1) && $permisos1[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoUsuario/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/estadousuario.php"><i class="fas fa-user-shield"></i><span style="margin-left: 5px;"> Estado Usuario</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';
                                echo '<a class="nav-link" href="../MantenimientoUsuario/bitacora.php"><i class="fa fa-book" aria-hidden="true"></i><span style="margin-left: 5px;"> Bitacora </a>';
                            }

                            echo '</nav>';
                            echo '</div>';
                        }
                        //----------------------------MODULO DE EMPLEADO------------------------------------
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
                        
                        //----------------------------MODULO DE CUENTAS------------------------------------
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoCuentas" aria-expanded="false" aria-controls="collapseMantenimientoCuentas">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Modulo Cuenta
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoCuentas" aria-labelledby="headingMantenimientoCuentas" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                echo '<a class="nav-link" href="tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de cuenta</a>';
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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE TRANSACCION -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Transacción</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?>
                        </div>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-transaccion" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>Tipo Transaccion</th>
                                    <th>Descripcion</th>
                                    <th>Signo Transaccion</th>
                                    <th>Creado por</th>
                                    <th>Fecha Creacion</th>
                                    <th>Modificado por</th>
                                    <th>Fecha Modificacion</th>
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
                                        <label for="nombre">Tipo Transaccion</label>
                                        <input type="text" maxlength="15" class="form-control" id="agregar-transaccion" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje1"></div>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="45" class="form-control" id="agregar-descripcion" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje2"></div>

                                        <label for="nombre">Signo Transaccion</label>
                                        <input type="text" class="form-control" id="agregar-signo" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
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
                                        <input type="text" class="form-control" id="editar-id-transaccion" disabled>
                                        <label for="nombre">Transaccion</label>
                                        <input type="text" maxlength="15" class="form-control" id="editar-transaccion" disabled>

                                        <label for="nombre">Descripcion</label>
                                        <input type="text" maxlength="45" class="form-control" id="editar-descripcion" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje4"></div>

                                        <label for="nombre">Signo Transaccion</label>
                                        <input type="text" class="form-control" id="editar-signo" required pattern="^\S+$" title="No se permiten campos vacíos" oninput="this.value = this.value.toUpperCase()">
                                        <div id="mensaje5"></div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-editar" onclick="updateTransaccion()" disabled>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE TRANSACCION -->

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

        function Lista_Transacciones() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipo_transaccion.php?op=GetTipoTransacciones', {
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
                    var tbody = document.querySelector('#Lista-transaccion tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(transaccion) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + transaccion.ID_TIPO_TRANSACCION + '</td>' +
                            '<td>' + transaccion.TIPO_TRANSACCION + '</td>' +
                            '<td>' + transaccion.DESCRIPCION + '</td>' +
                            '<td>' + transaccion.SIGNO_TRANSACCION + '</td>' +
                            '<td>' + transaccion.CREADO_POR + '</td>' +
                            '<td>' + transaccion.FECHA_CREACION + '</td>' +
                            '<td>' + transaccion.MODIFICADO_POR + '</td>' +
                            '<td>' + transaccion.FECHA_MODIFICACION + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarTransaccion(' + transaccion.ID_TIPO_TRANSACCION + ')">Editar</button> ';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-transaccion" data-id="' + transaccion.ID_TIPO_TRANSACCION + '" onclick="eliminarTransaccion(' + transaccion.ID_TIPO_TRANSACCION + ')">Eliminar</button>';
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
            $('#Lista-transaccion').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Transaccion() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var transaccion = $("#agregar-transaccion").val();
                var descripcion = $("#agregar-descripcion").val();
                var signo = $("#agregar-signo").val();

                if (transaccion == "" || descripcion == "" || signo == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear una transaccion con los datos a enviar al servidor
                    var datos = {
                        TIPO_TRANSACCION: transaccion,
                        DESCRIPCION: descripcion,
                        SIGNO_TRANSACCION: signo,
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipo_transaccion.php?op=InsertTipoTransaccion', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(datos)
                        })
                        .then(function(response) {
                            if (response.ok) {
                                if (response.status === 200) {
                                    // Si la solicitud fue exitosa y el código de respuesta es 200 (OK), muestra mensaje de éxito
                                    return response.json().then(function(data) {
                                        console.log(data);
                                        // Cerrar la modal después de guardar
                                        $('#crearModal').modal('hide');
                                        // Mostrar SweetAlert de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado exitoso',
                                            text: data.message
                                        }).then(function() {
                                            // Recargar la página para mostrar los nuevos datos
                                            location.reload();
                                        });
                                    });
                                } else if (response.status === 409) {
                                    // Si el código de respuesta es 409 (Conflict), muestra mensaje de transferecia existente
                                    return response.json().then(function(data) {
                                        console.log(data);
                                        // Mostrar SweetAlert de error
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.error // Acceder al mensaje de error
                                        });
                                    });
                                }
                            } else {
                                // Si hubo un error en la solicitud, maneja el error aquí
                                throw new Error('Error en la solicitud');
                            }
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

        function cargarTransaccion(id) {
            // Crear una transaccion con el ID de la transaccion
            var data = {
                "ID_TIPO_TRANSACCION": id
            };

            // Realiza una solicitud FETCH para obtener los detalles de la transaccion por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipo_transaccion.php?op=GetTipoTransaccion', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte el region en formato JSON
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Error en la solicitud');
                    }
                })
                .then(function(transaccion) {
                    // Llena los campos del modal con los datos de la transaccion
                    document.getElementById('editar-id-transaccion').value = transaccion.ID_TIPO_TRANSACCION;
                    document.getElementById('editar-transaccion').value = transaccion.TIPO_TRANSACCION;
                    document.getElementById('editar-descripcion').value = transaccion.DESCRIPCION;
                    document.getElementById('editar-signo').value = transaccion.SIGNO_TRANSACCION;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos de la Transaccion: ' + error.message);
                });
        }

        function updateTransaccion() {
            var id_transaccion = document.getElementById('editar-id-transaccion').value;
            var transaccion = document.getElementById('editar-transaccion').value;
            var descripcion = document.getElementById('editar-descripcion').value;
            var signo = document.getElementById('editar-signo').value;


            if (transaccion == "" || descripcion == "" || signo == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
                // Realiza una solicitud FETCH para actualizar los datos de la transaccion
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipo_transaccion.php?op=UpdateTipoTransaccion', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            "ID_TIPO_TRANSACCION": id_transaccion,
                            "TIPO_TRANSACCION": transaccion,
                            "DESCRIPCION": descripcion,
                            "SIGNO_TRANSACCION": signo
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
                            text: 'Error al actualizar los datos de la Transaccion: ' + error.message
                        });
                    });
            }
        }

        //FUNCION CON EL SWEETALERT
        function eliminarTransaccion(id_transaccion) {
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
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipo_transaccion.php?op=EliminarTipoTransaccion', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_TIPO_TRANSACCION": id_transaccion
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Transacción eliminada', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de las transacciones después de eliminar
                                        //Lista_Transacciones();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar la Transacción: ' + error.message, 'error');
                        });
                }
            });
        }

        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            var nombreTransaccion = document.getElementById("agregar-transaccion");
            var descripcion = document.getElementById("agregar-descripcion");
            var signo = document.getElementById("agregar-signo");
            var descripcionEditar = document.getElementById("editar-descripcion");
            var signoEditar = document.getElementById("editar-signo");

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
                inputElement.addEventListener("input", function() {
                    validateInput(inputElement, expression, messageElement, message);
                });

                inputElement.addEventListener("blur", function() {
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
            handleInputAndBlurEvents(nombreTransaccion, expresionValidadora1, mensaje1, "Solo se permiten Letras Mayúsculas");

            var expresionValidadora2 = /^[A-Z0-9\s]+$/;
            var mensaje2 = document.getElementById("mensaje2");
            handleInputAndBlurEvents(descripcion, expresionValidadora2, mensaje2, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcion);

            var mensaje3 = document.getElementById("mensaje3");
            handleInputAndBlurEvents(signo, expresionValidadora1, mensaje3, "Solo se permiten Letras Mayúsculas");

            var mensaje4 = document.getElementById("mensaje4");
            handleInputAndBlurEvents(descripcionEditar, expresionValidadora2, mensaje4, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcionEditar);

            var mensaje5 = document.getElementById("mensaje5");
            handleInputAndBlurEvents(signoEditar, expresionValidadora1, mensaje5, "Solo se permiten Letras Mayúsculas");

        }

        $(document).ready(function() {
            Lista_Transacciones();
            Insertar_Transaccion();
            validarNombre();
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const transaccionInput = document.getElementById('agregar-transaccion');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const signoInput = document.getElementById('agregar-signo');
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = transaccionInput.value.trim() !== '' && descripcionInput.value.trim() !== '' && signoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        transaccionInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
        signoInput.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const signoInput1 = document.getElementById('editar-signo');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = descripcionInput1.value.trim() !== '' && signoInput1.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        descripcionInput1.addEventListener('input', checkForm);
        signoInput1.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-signo, #editar-signo, #agregar-transaccion, #editar-transaccion').on('input', function() {
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
            document.getElementById('agregar-transaccion').value = "";
            document.getElementById('agregar-descripcion').value = "";
            document.getElementById('agregar-signo').value = "";

            // Limpia los checkboxes
            document.getElementById('agregar-transaccion').checked = false;
            document.getElementById('agregar-descripcion').checked = false;
            document.getElementById('agregar-signo').checked = false;

            location.reload();
        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {

            // Limpia los checkboxes
            document.getElementById('editar-descripcion').checked = false;
            document.getElementById('editar-signo').checked = false;
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>