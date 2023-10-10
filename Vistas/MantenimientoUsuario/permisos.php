<?php
session_start();
require "../../Config/conexion.php";

//$permisosUsuarios = new PermisosUsuarios();
require_once '../../Modelos/permisoUsuario.php';

$permisosObjeto = new PermisosUsuarios();
//$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_Permisos = "3";

$permisos = $permisosObjeto->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);

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
    <title>Permisos</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Estilo para la tabla */
        #Lista-Permiso {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-Permiso th {
            border: 2px solid white;
            /* Bordes blancos para las celdas del encabezado */
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
        #Lista-Permiso td {
            border: 1px solid grey;
            /* Bordes negros para las celdas de datos */
            padding: 8px;
            /* Espaciado interno para las celdas */
            text-align: center;
            /* Alineación del texto al centro */
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
                                    echo '<a class="nav-link" href="usuarios.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Usuarios</a>';
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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE USUARIO -->
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Mantenimiento Permisos</h1>

                    <!-- Botón para abrir el formulario de creación -->
                    <?php
                    if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                        echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModalPermisos">Crear Nuevo</button>';
                    }
                    ?>

                    <!-- Tabla para mostrar los datos -->
                    <table class="table table-bordered" id="Lista-Permiso" style="background-color: lightblue;">
                        <thead>
                            <tr>
                                <th>Id Rol</th>
                                <th>Id Objeto</th>
                                <th>Permisos Inserción</th>
                                <th>Permisos Eliminación</th>
                                <th>Permisos Actualización</th>
                                <th>Permisos Consultar</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <!-- Modal para crear un nuevo registro -->
                <div class="modal fade" id="crearModalPermisos" tabindex="-1" role="dialog" aria-labelledby="crearModalPermisoLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearModalPermisoLabel">Crear Nuevo Permiso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de creación -->
                                <form>
                                    <div class="form-group">

                                        <?php
                                        //---------CONEXION A LA TABLA ROLES --------
                                        // Crear una instancia de la clase Conectar
                                        $conexion = new Conectar();
                                        $conn = $conexion->Conexion();

                                        // Consultar la contraseña actual del usuario desde la base de datos
                                        $sql = "SELECT id_rol ,rol FROM tbl_ms_roles";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Obtener los resultados en un array asociativo
                                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <!------- SELECT DE ROLES -------------->
                                        <label for="id-rol">Rol</label>
                                        <select class="form-control" id="agregar-IdRol" name="IdRol">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <?php foreach ($roles as $rol) : ?>
                                                <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['rol']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php
                                        //---------CONEXION A LA TABLA OBJETOS --------
                                        // Crear una instancia de la clase Conectar
                                        $conexion = new Conectar();
                                        $conn = $conexion->Conexion();

                                        // Consultar la contraseña actual del usuario desde la base de datos
                                        $sql = "SELECT id_objeto ,objeto FROM tbl_ms_objetos";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Obtener los resultados en un array asociativo
                                        $objetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <!------- SELECT DE OBJETOS -------------->
                                        <label for="id-rol">Objeto</label>
                                        <select class="form-control" id="agregar-IdObjeto" name="IdObjeto">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <?php foreach ($objetos as $objeto) : ?>
                                                <option value="<?php echo $objeto['id_objeto']; ?>"><?php echo $objeto['objeto']; ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <label for="Permisos Insercion">Permisos Inserción</label>
                                        <select class="form-control" id="agregar-pInsercion" name="permisos_Inser">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>

                                        <label for="Permisos Eliminacion">Permisos Eliminación</label>
                                        <select class="form-control" id="agregar-pEliminacion" name="permisos_elim">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>


                                        <div> </div>
                                        <label for="Permisos Eliminacion">Permisos Actualizacion</label>
                                        <select class="form-control" id="agregar-pActualizacion" name="permisos_actu">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                        <label for="Permisos Consultar">Permisos Consultar</label>
                                        <select class="form-control" id="agregar-pConsultar" name="permisos_cons">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>

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

                <!-- Modal para editar un Permiso -->
                <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarModalLabel">Editar Permiso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de Edición -->
                                <form>
                                    <div class="form-group">

                                        <?php
                                        //---------CONEXION A LA TABLA ROLES --------
                                        // Crear una instancia de la clase Conectar
                                        $conexion = new Conectar();
                                        $conn = $conexion->Conexion();

                                        // Consultar la contraseña actual del usuario desde la base de datos
                                        $sql = "SELECT id_rol ,rol FROM tbl_ms_roles";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Obtener los resultados en un array asociativo
                                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <!------- SELECT DE ROLES -------------->
                                        <label for="id-rol">Rol</label>
                                        <select class="form-control" id="editar-IdRol" name="IdRol" disabled>
                                            <option value="" selected>Selecciona una opción</option>
                                            <?php foreach ($roles as $rol) : ?>
                                                <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['rol']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php
                                        //---------CONEXION A LA TABLA OBJETOS --------
                                        // Crear una instancia de la clase Conectar
                                        $conexion = new Conectar();
                                        $conn = $conexion->Conexion();

                                        // Consultar la contraseña actual del usuario desde la base de datos
                                        $sql = "SELECT id_objeto ,objeto FROM tbl_ms_objetos";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();

                                        // Obtener los resultados en un array asociativo
                                        $objetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <!------- SELECT DE OBJETOS -------------->
                                        <label for="id-rol">Objeto</label>
                                        <select class="form-control" id="editar-IdObjeto" name="IdObjeto" disabled>
                                            <option value="" selected>Selecciona una opción</option>
                                            <?php foreach ($objetos as $objeto) : ?>
                                                <option value="<?php echo $objeto['id_objeto']; ?>"><?php echo $objeto['objeto']; ?></option>
                                            <?php endforeach; ?>
                                            </select>



                                            <label for="Permisos Insercion">Permisos Inserción</label>
                                            <select class="form-control" id="editar-pInsercion" name="permisos_Inser">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>

                                            <label for="Permisos Eliminacion">Permisos Eliminación</label>
                                            <select class="form-control" id="editar-pEliminacion" name="permisos_elim">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>


                                            <div> </div>
                                            <label for="Permisos Eliminacion">Permisos Actualizacion</label>
                                            <select class="form-control" id="editar-pActualizacion" name="permisos_actu">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>
                                            <label for="Permisos Consultar">Permisos Consultar</label>
                                            <select class="form-control" id="editar-pConsultar" name="permisos_cons">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <option value="1">Sí</option>
                                                <option value="0">No</option>
                                            </select>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" onclick="updatePermiso()">Guardar
                                    Cambios</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE USUARIO -->

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

    <script>
        var permisos = <?php echo json_encode($permisos); ?>;

        function Lista_Permisos() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/permisosUsuario.php?op=Get_Permisos', {
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
                    var tbody = document.querySelector('#Lista-Permiso tbody');


                    data.forEach(function(permiso) {
                        var row = '<tr>' +
                            '<td>' + permiso.ID_ROL + '</td>' +
                            '<td>' + permiso.ID_OBJETO + '</td>' +
                            '<td>' + permiso.PERMISOS_INSERCION + '</td>' +
                            '<td>' + permiso.PERMISOS_ELIMINACION + '</td>' +
                            '<td>' + permiso.PERMISOS_ACTUALIZACION + '</td>' +
                            '<td>' + permiso.PERMISOS_CONSULTAR + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar
                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarPermiso(' + permiso.ID_ROL + ',' + permiso.ID_OBJETO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-permiso" data-id="' + permiso.ID_ROL + ',' + permiso.ID_OBJETO +  '" onclick="eliminarPermiso(' + permiso.ID_ROL + ',' + permiso.ID_OBJETO +')">Eliminar</button>';
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


        function Insertar_Permiso() {

            $("#btn-agregar").click(function() {
                console.log("entra a la funcion");
                // Obtener los valores de los campos del formulario
                var idRol = $("#agregar-IdRol").val();
                var idObjeto = $("#agregar-IdObjeto").val();
                var pInsercion = $("#agregar-pInsercion").val();
                var pEliminacion = $("#agregar-pEliminacion").val();
                var pActualizacion = $("#agregar-pActualizacion").val();
                var pConsultar = $("#agregar-pConsultar").val();


                // Crear un objeto con los datos a enviar al servidor
                var datos = {
                    ID_ROL: idRol,
                    ID_OBJETO: idObjeto,
                    PERMISOS_INSERCION: pInsercion,
                    PERMISOS_ELIMINACION: pEliminacion,
                    PERMISOS_ACTUALIZACION: pActualizacion,
                    PERMISOS_CONSULTAR: pConsultar
                };

                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/permisosUsuario.php?op=InsertPermiso', {
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
                        $('#crearModalPermisos').modal('hide');

                        // Recargar la página para mostrar los nuevos datos
                        location.reload();

                    })
                    .catch(function(error) {
                        // Manejar el error aquí
                        alert('Error al guardar el usuario: ' + error.message);
                        console.log(error.message);
                    });
            });
        }

        function cargarPermiso(id_rol, id_objeto) {
            // Crear un objeto con el ID del PERMISO
            var data = {
                "id_rol": id_rol,
                "id_objeto": id_objeto

            };

            // Realiza una solicitud FETCH para obtener los detalles del permio por su ID OBJETO Y ID ROL
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/permisosUsuario.php?op=GetPermisoUsuario', {
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
                .then(function(permiso) {
                    if (permiso) {
                        document.getElementById('editar-IdRol').value = id_rol;
                        document.getElementById('editar-IdObjeto').value = id_objeto;
                        document.getElementById('editar-pInsercion').value = permiso[0].PERMISOS_INSERCION;
                        document.getElementById('editar-pEliminacion').value = permiso[0].PERMISOS_ELIMINACION;
                        document.getElementById('editar-pActualizacion').value = permiso[0].PERMISOS_ACTUALIZACION;
                        document.getElementById('editar-pConsultar').value = permiso[0].PERMISOS_CONSULTAR;
                    } else {
                        console.log('La respuesta JSON está vacía o no válida.');
                    }
                })

                .catch(function(error) {
                    // Manejar el error aquí  

                    alert('Error al cargar los datos del permiso: ' + error.message);
                });

        }

        function updatePermiso() {
            // Obtén el ID del usuario 
            var idRol = parseInt(document.getElementById('editar-IdRol').value);
            // Obtén los valores de los campos de edición
            var idObjeto = parseInt(document.getElementById('editar-IdObjeto').value); 
            var insercion = parseInt(document.getElementById('editar-pInsercion').value); 
            var eliminacion = parseInt(document.getElementById('editar-pEliminacion').value); 
            var actualizacion= parseInt(document.getElementById('editar-pActualizacion').value);
            var consultar = parseInt(document.getElementById('editar-pConsultar').value);
            console.log(insercion)
            console.log(eliminacion)
            console.log(actualizacion)
            console.log(consultar)
            // Realiza una solicitud FETCH para actualizar los datos del usuario
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/permisosUsuario.php?op=updatePermiso', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "ID_ROL": idRol,
                        "ID_OBJETO": idObjeto,
                        "PERMISOS_INSERCION": insercion,
                        "PERMISOS_ELIMINACION": eliminacion,
                        "PERMISOS_ACTUALIZACION": actualizacion,
                        "PERMISOS_CONSULTAR": consultar


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
                    alert('Error al actualizar los datos del permiso: ' + error.message);
                });

        }

        // //FUNCION CON EL SWEETALERT
        function eliminarPermiso(idRol,idObjeto) {
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
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/permisosUsuario.php?op=deletePermiso', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_ROL": idRol,
                                "ID_OBJETO": idObjeto
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('permiso eliminado', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de usuarios después de eliminar
                                        Lista_Usuarios();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar el permiso: ' + error.message, 'error');
                        });
                }
            });
        }

        $(document).ready(function() {
            Lista_Permisos();
            Insertar_Permiso();
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