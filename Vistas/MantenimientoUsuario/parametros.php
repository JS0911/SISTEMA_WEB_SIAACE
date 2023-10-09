<?php

session_start();
require "../../Config/conexion.php";
require_once '../../Modelos/parametros.php';
require_once "../../Modelos/permisoUsuario.php";

$permisosParametros = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}


$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Parametro = "4";

$permisos = $permisosParametros->get_Permisos_Usuarios($id_rol, $id_objeto_Parametro);
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
    <title>Mantenimiento Parametros</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-Parametros {
            border-collapse: collapse; /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-Parametros th {
            border: 2px solid white; /* Bordes negros para las celdas del encabezado */
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif; /* Cambia el tipo de letra */
            padding: 8px; /* Espaciado interno para las celdas */
            text-align: center; /* Alineación del texto al centro */
        }

        /* Estilo para las celdas de datos (td) */
        #Lista-Parametros td {
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
                                    echo '<a class="nav-link" href="/usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
                                }
                                
                                echo '<a class="nav-link" href="../../roles.php"><i class="fas fa-user-lock"> </i><span style="margin-left: 5px;">    Roles</a>';
                                echo '<a class="nav-link" href="permisos.php"><i class="fas fa-key"> </i><span style="margin-left: 5px;">   Permisos</a>';
                                echo '<a class="nav-link" href="objetos.php"><i class="fas fa-object-group"> </i><span style="margin-left: 5px;">    Objetos</a>';
                                echo '<a class="nav-link" href="parametros.php"><i class="fas fa-cogs"></i><span style="margin-left: 5px;"> Parámetros</a>';

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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE PARAMETROS -->
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Mantenimiento Parametros</h1>

                    <!-- Botón para abrir el formulario de creación -->

                        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Crear Nuevo</button>';


                    <!-- Tabla para mostrar los datos -->
                    <table class="table table-bordered" id="Lista-Parametros">
                        <thead>
                            <tr>
                                <th>Id Parametro</th>
                                <th>Parametro</th>
                                <th>Valor</th>
                                <!-- <th>Id Usuario</th>
                                <th>Creado por</th>
                                <th>Modificado por</th>
                                <th>fecha creacion</th>
                                <th>fecha modificacion</th> -->

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- Modal para crear un nuevo Parametro -->
                <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalLabel">Crear Nuevo Parametro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Parametro</label>
                                        <input type="text" class="form-control" id="agregar-parametro">

                                        <label for="nombre">Valor</label>
                                        <input type="text" class="form-control" id="agregar-valor">

                                        <!-- <label for="nombre">Id Usuario</label>
                                        <input type="text" class="form-control" id="agregar-id-usuario">

                                        <label for="nombre">Creado por</label>
                                        <input type="text" class="form-control" id="agregar-creado-por">

                                        <label for="nombre">modificado por</label>
                                        <input type="text" class="form-control" id="agregar-modificado-por"> -->

                                        <!-- <label for="nombre">fecha creacion</label>
                                        <input type="text" class="form-control" id="agregar-fecha-creacion">

                                        <label for="nombre">fecha modificacion</label>
                                        <input type="text" class="form-control" id="agregar-fecha-modificacion"> -->
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

                <!-- Modal para editar un Parametro -->
                <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarModalLabel">Editar Parametro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de edición -->
                                <form>
                                    <div class="form-group">
                                        <label for="nombre">Id Parametro</label>
                                        <input type="text" class="form-control" id="editar-id-parametro">
                                        <label for="nombre">Parametro</label>
                                        <input type="text" class="form-control" id="editar-parametro">
                                        <label for="nombre">Valor</label>
                                        <input type="text" class="form-control" id="editar-valor">
                                        <!-- <label for="estado">Id Usuario</label> -->
                                        <!-- <input type="text" class="form-control" id="editar-id-usuario">
                                        <label for="estado">Creado por</label>
                                        <input type="text" class="form-control" id="editar-creado-por">
                                        <label for="estado">modificado por</label>
                                        <input type="text" class="form-control" id="editar-modificado-por"> -->
                                        <!-- <label for="estado">Fecha Creacion</label>
                                        <input type="text" class="form-control" id="editar-fecha-creacion">
                                        <label for="estado">Fecha Modificacion </label>
                                        <input type="text" class="form-control" id="editar-fecha-modificacion"> -->
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="updateParametro()">Guardar
                                    Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE PARAMETROS -->

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- EL CODIGO ESTA QUEMADO AQUI, NO FUNCIONA REFERENCIA A LOS ARCHIVOS -->
    <script>
       

        function Lista_Parametros() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/parametros.php?op=GetParametros', {
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
                    var tbody = document.querySelector('#Lista-parametros tbody');


                    data.forEach(function(parametro) {
                        var row = '<tr>' +
                            '<td>' + parametro.ID_PARAMETRO + '</td>' +
                            '<td>' + parametro.PARAMETRO + '</td>' +
                            '<td>' + parametro.VALOR + '</td>' +
                            // '<td>' + parametro.ID_USUARIO + '</td>' +
                            // '<td>' + parametro.CREADO_POR + '</td>' +
                            // '<td>' + parametro.MODIFICADO_POR + '</td>' +
                            // '<td>' + parametro.FECHA_CREACION + '</td>' +
                            // '<td>' + parametro.FECHA_MODIFICACION + '</td>' +
                            '<td>'+

                        '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarParametro(' + parametro.ID_PARAMETRO + ')">Editar</button>'+
                         '<button class="btn btn-danger eliminar-usuario" data-id="' + parametro.ID_PARAMETRO + '" onclick="eliminarParametro(' + parametro.ID_PARAMETRO + ')">Eliminar</button>';
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


        function Insertar_Parametro() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var parametro = $("#agregar-parametro").val();
                var valor = $("#agregar-valor").val();
                // var id_usuario = $("#agregar-id-usuario").val();
                // var creado_por = $("#agregar-creado-por").val();
                // var modificado_por = $("#agregar-modificado-por").val();
                // var fecha_creacion = $("#agregar-fecha-creacion").val();
                // var fecha_modificacion = $("#agregar-fecha-modificacion").val();

                // // Verificar que las contraseñas coincidan
                // if (contrasena !== confirmarContrasena) {
                //     alert("Las contraseñas no coinciden.");
                //     return;
                // }

                // Crear un objeto con los datos a enviar al servidor
                var datos = {
                    PARAMETRO: parametro,
                    VALOR: valor
                    // ID_USUARIO: id_usuario,
                    // CREADO_POR: creado_por,
                    // MODIFICADO_POR: modificado_por,
                    // FECHA_CREACION: fecha_creacion,
                    // FECHA_MODIFICACION: fecha_modificacion
                };

                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/parametros.php?op=InsertParametros', {
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
                        Lista_Parametros();
                       

                    })
                    .catch(function(error) {
                        // Manejar el error aquí
                        alert('Error al guardar el parametro: ' + error.message);
                        console.log(error.message);
                    });
            });
        }

        function cargarParametro(id) {
            // Crear un objeto con el ID del parametro
            var data = {
                "ID_PARAMETRO": id
            };

            // Realiza una solicitud FETCH para obtener los detalles del usuario por su ID
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/parametros.php?op=GetParametro', {
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
                .then(function(parametro) {
                    // Llena los campos del modal con los datos del parametro
                    document.getElementById('editar-id-parametro').value = parametro.ID_PARAMETRO;
                    document.getElementById('editar-parametro').value = parametro.PARAMETRO;
                    document.getElementById('editar-valor').value = parametro.VALOR;
                    // document.getElementById('editar-id-usuario').value = parametro.ID_USUARIO;
                    // document.getElementById('editar-creado-por').value = parametro.CREADO_POR;
                    // document.getElementById('editar-modificado-por').value = parametro.MODIFICADO_POR;
                    // document.getElementById('editar-fecha-creacion').value = parametro.FECHA_CREACION;
                    // document.getElementById('editar-fecha-modificacion').value = parametro.FECHA_MODIFICACION;
                })
                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos del parametro: ' + error.message);
                });
        }

        function updateParametro() {
            // Obtén el ID del parametro 
            var idparametro = document.getElementById('editar-id-parametro').value;
            // Obtén los valores de los campos de edición
            var parametro = document.getElementById('editar-parametro').value;
            var valor = document.getElementById('editar-valor').value;
            // var idusuario = document.getElementById('editar-id-usuario').value;
            // var creadopor = document.getElementById('editar-creado-por').value;
            // var modificadopor = document.getElementById('editar-modificado-por').value;
            // var fechacreacion = document.getElementById('editar-fecha-creacion').value;
            // var fechamodificacion = document.getElementById('editar-fecha-modificacion').value;
           

            // Realiza una solicitud FETCH para actualizar los datos del usuario
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/parametros.php?op=updateParametro', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_PARAMETRO": idparametro,
                        "PARAMETRO": parametro,
                        "VALOR": valor
                        // "ID_USUARIO": idusuario,
                        // "CREADO_POR": creadopor,
                        // "MODIFICADO_POR": modificadopor,
                        // "FECHA_CREACION": fechacreacion,
                        // "FECHA_MODIFICACION": fechamodificacion
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
                    alert('Error al actualizar los datos del parametro: ' + error.message);
                });

        }

        //FUNCION CON EL SWEETALERT
        function eliminarParametro(idparametro) {
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
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/parametros.php?op=eliminarParametro', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_PARAMETRO": idparametro
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('parametro eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de parametros después de eliminar
                                       
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
          
            Insertar_Parametro();
            Lista_Parametros();
            
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