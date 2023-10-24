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
$id_objeto_Seguridad = "25";
$id_objeto_Cuentas = "28";

$permisos1 = $permisosObjeto->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos = $permisosObjeto->get_Permisos_Usuarios($id_rol, $id_objeto_Permisos);
$permisos2 = $permisosObjeto->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);

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
    <title>Permisos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>


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

        /* Estilo personalizado para el placeholder */
        #myInput {
            border: 2px solid #000;
            /* Borde más oscuro, en este caso, negro (#000) */

        }


        .check {
            color: green;
            font-size: 20px;
        }

        .x {
            color: red;
            font-size: 25px;
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
                                echo '<a class="nav-link" href="../MantenimientoCuentas/tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                echo '<a class="nav-link" href="../MantenimientoCuentastipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de cuenta</a>';
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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO PERMISO -->
            <main>
                <div class="container-fluid">

                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Permisos</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-1 custom-button" data-toggle="modal" data-target="#crearModalPermisos">Nuevo</button>';
                            }
                            ?>

                        </div>

                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-Permiso" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id Rol</th> <!--OCULTAR LAS CABEZERAS -->
                                    <th> Rol</th>
                                    <th style="display: none;">Id Objeto</th>
                                    <th>Objeto</th>
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
                                        <label>Permisos</label>

                                        <!-- Checkbox para Insertar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agregar-pInsercion" name="permisos_Inser" value="1">
                                            <label class="form-check-label" for="agregar-pInsercion">Insertar</label>
                                        </div>

                                        <!-- Checkbox para Eliminar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agregar-pEliminacion" name="permisos_elim" value="1">
                                            <label class="form-check-label" for="agregar-pEliminacion">Eliminar</label>
                                        </div>

                                        <!-- Checkbox para Actualizar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agregar-pActualizacion" name="permisos_actu" value="1">
                                            <label class="form-check-label" for="agregar-pActualizacion">Actualizar</label>
                                        </div>

                                        <!-- Checkbox para Consultar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agregar-pConsultar" name="permisos_cons" value="1">
                                            <label class="form-check-label" for="agregar-pConsultar">Consultar</label>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-guardarAgregar" disabled>Guardar</button>
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



                                        <label>Permisos</label>

                                        <!-- Checkbox para Insertar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editar-pInsercion" name="permisos_Inser" value="1">
                                            <label class="form-check-label" for="editar-pInsercion">Insertar</label>
                                        </div>

                                        <!-- Checkbox para Eliminar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editar-pEliminacion" name="permisos_elim" value="1">
                                            <label class="form-check-label" for="editar-pEliminacion">Eliminar</label>
                                        </div>

                                        <!-- Checkbox para Actualizar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editar-pActualizacion" name="permisos_actu" value="1">
                                            <label class="form-check-label" for="editar-pActualizacion">Actualizar</label>
                                        </div>

                                        <!-- Checkbox para Consultar -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editar-pConsultar" name="permisos_cons" value="1">
                                            <label class="form-check-label" for="editar-pConsultar">Consultar</label>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarEditar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-guardarEditar" onclick="updatePermiso()">Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- AQUI FINALIZA EL MANTENIMIENTO DE USUARIO -->

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-start justify-content-center small">
                        <div class="text-muted">Copyright &copy; IA-UNAH 2023</div>
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
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(permiso) {


                        var row = '<tr>' +
                            '<td style="display:none;">' + permiso.ID_ROL + '</td>' + /* OCULTAR LAS COLUMNAS */
                            '<td>' + permiso.ROL + '</td>' +
                            '<td style="display:none;">' + permiso.ID_OBJETO + '</td>' +
                            '<td>' + permiso.OBJETO + '</td>' +
                            '<td>' + (permiso.PERMISOS_INSERCION === 'Sí' ? '<span class="check">&#10004;</span>' : '<span class="x">&#10008;</span>') + '</td>' +
                            '<td>' + (permiso.PERMISOS_ELIMINACION === 'Sí' ? '<span class="check">&#10004;</span>' : '<span class="x">&#10008;</span>') + '</td>' +
                            '<td>' + (permiso.PERMISOS_ACTUALIZACION === 'Sí' ? '<span class="check">&#10004;</span>' : '<span class="x">&#10008;</span>') + '</td>' +
                            '<td>' + (permiso.PERMISOS_CONSULTAR === 'Sí' ? '<span class="check">&#10004;</span>' : '<span class="x">&#10008;</span>') + '</td>' +
                            '<td>';




                        console.log(permiso);
                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar
                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarPermiso(' + permiso.ID_ROL + ',' + permiso.ID_OBJETO + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-permiso" data-id="' + permiso.ID_ROL + ',' + permiso.ID_OBJETO + '" onclick="eliminarPermiso(' + permiso.ID_ROL + ',' + permiso.ID_OBJETO + ')">Eliminar</button>';
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
            $('#Lista-Permiso').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function Insertar_Permiso() {
            $("#btn-guardarAgregar").click(function() {
                // Obtener los valores de los campos del formulario
                var idRol = $("#agregar-IdRol").val();
                var idObjeto = $("#agregar-IdObjeto").val()
                // Crear un objeto con los datos a enviar al servidor
                var datos1 = {
                    ID_ROL: idRol,
                    ID_OBJETO: idObjeto
                };

                // Hacer una solicitud para verificar si el permiso ya existe
                fetch('http://localhost:90/SISTEMA1/Controladores/permisosUsuario.php?op=verificarPermisoExistente', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(datos1)
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Error en la solicitud de verificación');
                        }
                    })
                    .then(function(data) {
                        if (data == 'SI EXISTE EL PERMISO') {

                            // Mostrar un mensaje de error ya que el permiso ya existe
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'El permiso para este rol y objeto ya existe.'
                            });
                        } else {
                            // Si el permiso no existe, procede a insertarlo
                            var pInsercion = $("#agregar-pInsercion").prop("checked") ? "1" : "0";
                            var pEliminacion = $("#agregar-pEliminacion").prop("checked") ? "1" : "0";
                            var pActualizacion = $("#agregar-pActualizacion").prop("checked") ? "1" : "0";
                            var pConsultar = $("#agregar-pConsultar").prop("checked") ? "1" : "0";

                            // Crear un objeto con los datos a enviar al servidor
                            var datos = {
                                ID_ROL: idRol,
                                ID_OBJETO: idObjeto,
                                PERMISOS_INSERCION: pInsercion,
                                PERMISOS_ELIMINACION: pEliminacion,
                                PERMISOS_ACTUALIZACION: pActualizacion,
                                PERMISOS_CONSULTAR: pConsultar
                            };

                            // Realizar la solicitud de inserción después de verificar
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
                                        throw new Error('Error en la solicitud de inserción');
                                    }
                                })
                                .then(function(data) {
                                    console.log(data);
                                    // Cerrar la modal después de guardar
                                    $('#crearModalPermisos').modal('hide');

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
                                    // Manejar el error aquí
                                    console.log(error.message);

                                    // Mostrar SweetAlert de error
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error al guardar los datos: ' + error.message
                                    });
                                });
                        }
                    })
                    .catch(function(error) {
                        // Manejar el error de verificación aquí
                        console.log(error.message);
                        // Mostrar SweetAlert de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al verificar el permiso: ' + error.message
                        });
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
                        
                        var pInsercion = document.getElementById('editar-pInsercion').checked ? 'Sí' : 'No';
                        var pEliminacion = document.getElementById('editar-pEliminacion').checked ? 'Sí' : 'No';
                        var pActualizacion = document.getElementById('editar-pActualizacion').checked ? 'Sí' : 'No';
                        var pConsultar = document.getElementById('editar-pConsultar').checked ? 'Sí' : 'No';

                        console.log("Permiso de Inserción: " + pInsercion);
                        console.log("Permiso de Eliminación: " + pEliminacion);
                        console.log("Permiso de Actualización: " + pActualizacion);
                        console.log("Permiso de Consulta: " + pConsultar);



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
            var insercion = document.getElementById('editar-pInsercion').checked ? 1 : 0;
            var eliminacion = document.getElementById('editar-pEliminacion').checked ? 1 : 0;
            var actualizacion = document.getElementById('editar-pActualizacion').checked ? 1 : 0;
            var consultar = document.getElementById('editar-pConsultar').checked ? 1 : 0;

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
                        // Actualización exitosa
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

        // //FUNCION CON EL SWEETALERT
        function eliminarPermiso(idRol, idObjeto) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esto.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                confirmButtonColor: '#3085d6'

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

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los elementos select y el botón de guardar
        var selectRol = document.getElementById("agregar-IdRol");
        var selectObjeto = document.getElementById("agregar-IdObjeto");
        var btnGuardar = document.getElementById("btn-guardarAgregar");

        // Función para verificar y habilitar o deshabilitar el botón
        function verificarSeleccion() {
            if (selectRol.value && selectObjeto.value) {
                // Ambos selects tienen valores seleccionados, habilitar el botón
                btnGuardar.disabled = false;
            } else {
                // Al menos uno de los selects no tiene un valor seleccionado, deshabilitar el botón
                btnGuardar.disabled = true;
            }
        }

        // Agregar escuchadores de eventos para detectar cambios en los selects
        selectRol.addEventListener("change", verificarSeleccion);
        selectObjeto.addEventListener("change", verificarSeleccion);

        // Llamar a verificarSeleccion una vez al inicio para verificar el estado inicial
        verificarSeleccion();
    </script>

    <script>
        // Escuchar eventos de cambio en los elementos <select>
        $('#agregar-IdRol, #agregar-IdObjeto').on('change', function() {
            var select = $(this);
            var selectedValue = select.val();

            if (selectedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'Debes seleccionar una opción',
                    icon: 'warning',
                });
            }
        });

        // Escuchar eventos de cambio en los elementos <select> deshabilitados
        $('#editar-IdRol, #editar-IdObjeto').on('change', function() {
            var select = $(this);
            var selectedValue = select.val();

            if (selectedValue === '') {
                Swal.fire({
                    title: 'Advertencia',
                    text: 'Debes seleccionar una opción',
                    icon: 'warning',
                });
            }
        });
    </script>

    <script>
        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL AGREGAR--------------------
        document.getElementById('btn-cancelarAgregar').addEventListener('click', function() {
            document.getElementById('agregar-IdRol').value = "";
            document.getElementById('agregar-IdObjeto').value = "";

            // Limpia los checkboxes
            document.getElementById('agregar-pInsercion').checked = false;
            document.getElementById('agregar-pEliminacion').checked = false;
            document.getElementById('agregar-pActualizacion').checked = false;
            document.getElementById('agregar-pConsultar').checked = false;

            // Desactivar el botón "Guardar" en el modal Agregar
            document.getElementById('btn-guardarAgregar').disabled = true;
        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {


            // Limpia los checkboxes
            document.getElementById('editar-pInsercion').checked = false;
            document.getElementById('editar-pEliminacion').checked = false;
            document.getElementById('editar-pActualizacion').checked = false;
            document.getElementById('editar-pConsultar').checked = false;
            // Desactivar el botón "Guardar" en el modal Editar
            //document.getElementById('btn-guardarEditar').disabled = true;
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>