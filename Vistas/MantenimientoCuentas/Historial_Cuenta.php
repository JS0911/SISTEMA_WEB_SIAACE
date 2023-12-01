<!-- -----------------------------------------------------------------------
	Universidad Nacional Autonoma de Honduras (UNAH)
		Facultad de Ciencias Economicas
	Departamento de Informatica administrativa
         Analisis, Programacion y Evaluacion de Sistemas
                    Tercer Periodo 2023


Equipo:
Sahory Garcia          sahori.garcia@unah.hn
Jairo Garcia           jairo.lagos@unah.hn
Ashley Matamoros       Ashley.matamoros@unah.hn
Lester Padilla         Lester.padilla@unah.hn
Khaterine Ordoñez      khaterine.ordonez@unah.hn
Yeniffer Velasquez     yeniffer.velasquez@unah.hn
Kevin Zuniga           kgzuniga@unah.hn

Catedratico analisis y diseño: Lic. Giancarlos Martini Scalici Aguilar
Catedratico programacion e implementacion: Lic. Karla Melisa Garcia Pineda 
Catedratico evaluacion de sistemas: ???


---------------------------------------------------------------------

Programa:         Pantalla de Bitacora
Fecha:            15-oct-2023
Programador:      Kevin Zuniga y Yeniffer Velasquez
descripcion:      Pantalla que muestra las acciones realizadas dentro y fuera del sistema en cada mantenimiento que existe 

-----------------------------------------------------------------------

                Historial de Cambio

-----------------------------------------------------------------------

Programador               Fecha                      Descripcion
Kevin Zuniga              25-nov-2023                 Se agrego reporteria y rutas hacia otras nuevas vistas, ademas de algunos detalles esteticos
Sahori Garcia             30-11-2023                   Cambio de permisos y objetos 
------------------------------------------------------------------------->
<?php

session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosHistorialCuenta = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_H_Cuenta = "31";
$id_objeto_Seguridad = "25";
$id_objeto_Empleado = "27";
$id_objeto_Cuentas = "36";
$id_objeto_Prestamos = "35";

$permisos = $permisosHistorialCuenta->get_Permisos_Usuarios($id_rol, $id_objeto_H_Cuenta);
$permisos1 = $permisosHistorialCuenta->get_Permisos_Usuarios($id_rol, $id_objeto_Seguridad);
$permisos2 = $permisosHistorialCuenta->get_Permisos_Usuarios($id_rol, $id_objeto_Empleado);
$permisos3 = $permisosHistorialCuenta->get_Permisos_Usuarios($id_rol, $id_objeto_Cuentas);
$permisos4 = $permisosHistorialCuenta->get_Permisos_Usuarios($id_rol, $id_objeto_Prestamos);


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
    <title>Mantenimiento Tipo de Cuenta</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-tipo-cuenta {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-tipo-cuenta th {
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
        #Lista-tipo-cuenta td {
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
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2" />
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
                        //----------------------MODULO DE SEGURIDAD-------------------------------------
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
                        if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoEmpleado" aria-expanded="false" aria-controls="collapseMantenimientoEmpleado">
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Modulo Empleado
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>';
                            echo '<div class="collapse" id="collapseMantenimientoEmpleado" aria-labelledby="headingMantenimientoEmpleado" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos2) && $permisos2[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/empleado.php"><i class="fas fa-user"></i><span style="margin-left: 5px;"> Empleado</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/cargo.php"><i class="fas fa-briefcase"></i></i><span style="margin-left: 5px;"> Cargo</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/region.php"><i class="fas fa-globe"></i></i><span style="margin-left: 5px;"> Region</a>';
                                echo '<a class="nav-link" href="../MantenimientoEmpleado/sucursal.php"><i class="fas fa-building"></i></i><span style="margin-left: 5px;"> Sucursal</a>';
                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE CUENTAS------------------------------------
                        if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoCuentas" aria-expanded="false" aria-controls="collapseMantenimientoCuentas">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Modulo Cuenta
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoCuentas" aria-labelledby="headingMantenimientoCuentas" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos3) && $permisos3[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="tipo_transaccion.php"><i class="fas fa-money-check-alt"></i><span style="margin-left: 5px;"> Tipo Transaccion</a>';
                                echo '<a class="nav-link" href="tipoCuenta.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de cuenta</a>';
                                echo '<a class="nav-link" href="MantenimientoCuentas.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de cuenta</a>';

                            }
                            echo '</nav>';
                            echo '</div>';
                        }

                        //----------------------------MODULO DE PRESTAMOS------------------------------------
                        if (!empty($permisos4) && $permisos4[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoPrestamo" aria-expanded="false" aria-controls="collapseMantenimientoPrestamo">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>
                            Modulo Prestamo
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoPrestamo" aria-labelledby="headingMantenimientoPrestamo" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos4) && $permisos4[0]['PERMISOS_CONSULTAR'] == 1) {
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/forma_pago.php"><i class="fas fa-hand-holding-usd"></i><span style="margin-left: 5px;"> Forma de Pago</a>';
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/tipoprestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Tipo de Prestamo</a>';
                                echo '<a class="nav-link" href="../MantenimientoPrestamos/prestamo.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span style="margin-left: 5px;"> Lista de Prestamo</a>';
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

            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE TIPO DE CUENTAS -->
            <main>
                <div class="container-fluid">
                    <!-- Botón para abrir el formulario de creación -->
                    <div class="container" style="max-width: 1400px;">
                        <center>
                            <h1 class="mt-4 mb-4">Mantenimiento Tipo de Cuentas</h1>
                        </center>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php
                            if (!empty($permisos) && $permisos[0]['PERMISOS_INSERCION'] == 1) {
                                echo '<button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Nuevo</button>';
                            }
                            ?>
                        </div>
                        <!-- Tabla para mostrar los datos -->
                        <table class="table table-bordered mx-auto" id="Lista-tipo-cuenta" style="margin-top: 20px; margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Tipo Transaccion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            

            <!-- AQUI FINALIZA EL MANTENIMIENTO DE TIPO CUENTA -->

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

        function Historial_Cuenta() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado
            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=HistorialCuenta', {
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
                    var tbody = document.querySelector('#Lista-tipo-cuenta tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(cuenta) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + cuenta.ID_TRASACCION + '</td>' +
                            '<td>' + cuenta.FECHA + '</td>' +
                            '<td>' + cuenta.MONTO + '</td>' +
                            '<td>' + cuenta.TIPO_TRANSACCION + '</td>' +

                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar

                        if (parseInt(permisos[0]['PERMISOS_ACTUALIZACION']) === 1) {
                            row += '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" onclick="cargarTipoCuenta(' + cuenta.ID_TIPOCUENTA + ')">Editar</button>';
                        }

                        if (parseInt(permisos[0]['PERMISOS_ELIMINACION']) === 1) {
                            row += '<button class="btn btn-danger eliminar-tipo-cuenta" data-id="' + cuenta.ID_TIPOCUENTA + '" onclick="eliminarTipoCuenta(' + cuenta.ID_TIPOCUENTA + ')">Eliminar</button>';
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
            $('#Lista-tipo-cuenta').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 20, 30, 50, 100],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
            });
        }

        function updateTipoCuenta() {
            var id_cuenta = document.getElementById('editar-id-cuenta').value;
            var cuenta = document.getElementById('editar-cuenta').value;
            var descripcion = document.getElementById('editar-descripcion').value;
            var tasa = document.getElementById('editar-tasa').value;
            var estado = document.getElementById('editar-estado').value;

            if (cuenta == "" || descripcion == "" || tasa == "" || estado == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'No se pueden enviar Campos Vacios.'
                })
            } else {
                // Realiza una solicitud FETCH para actualizar los datos del tipo cuenta
                fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoCuenta.php?op=UpdateTipoCuenta', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            "ID_TIPOCUENTA": id_cuenta,
                            "TIPO_CUENTA": cuenta,
                            "DESCRIPCION": descripcion,
                            "TASA": tasa,
                            "ESTADO": estado
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
                            text: 'Error al actualizar los datos de la Tipo de Cuenta: ' + error.message
                        });
                    });
            }
        }

        //FUNCION CON EL SWEETALERT
        function eliminarTipoCuenta(id_tipocuenta) {
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
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/tipoCuenta.php?op=EliminarTipoCuenta', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                "ID_TIPOCUENTA": id_tipocuenta
                            })
                        })
                        .then(function(response) {
                            if (response.ok) {
                                // Eliminación exitosa, puedes hacer algo aquí si es necesario
                                Swal.fire('Tipo de Cuenta eliminada', '', 'success')
                                    .then(() => {
                                        // Recargar la página para mostrar los nuevos datos
                                        location.reload();
                                        // Recargar la lista de TIPO CUENTA después de eliminar
                                        //Lista_Tipo_Cuenta();
                                    });
                            } else {
                                throw new Error('Error en la solicitud de eliminación');
                            }
                        })
                        .catch(function(error) {
                            // Manejar el error aquí
                            Swal.fire('Error', 'Error al eliminar la Tipo de Cuenta: ' + error.message, 'error');
                        });
                }
            });
        }

        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            var nombreTipoCuenta = document.getElementById("agregar-cuenta");
            var descripcion = document.getElementById("agregar-descripcion");
            var tasa = document.getElementById("agregar-tasa");
            var estado = document.getElementById("agregar-estado");
            var descripcionEditar = document.getElementById("editar-descripcion");
            var tasaEditar = document.getElementById("editar-tasa");
            var estadoEditar = document.getElementById("editar-estado");

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
            handleInputAndBlurEvents(nombreTipoCuenta, expresionValidadora1, mensaje1, "Solo se permiten Letras Mayúsculas");

            var expresionValidadora2 = /^[A-Z0-9\s]+$/;
            var mensaje2 = document.getElementById("mensaje2");
            handleInputAndBlurEvents(descripcion, expresionValidadora2, mensaje2, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcion);

            var expresionValidadora3 = /^\d+(\.\d+)?/;
            var mensaje3 = document.getElementById("mensaje3");
            handleInputAndBlurEvents(tasa, expresionValidadora3, mensaje3, "Solo se permiten Datos Numericos");
            handleDescriptionKeypressEvent(tasa);

            var mensaje4 = document.getElementById("mensaje4");
            handleInputAndBlurEvents(estado, expresionValidadora1, mensaje4, "Solo se permiten Letras Mayúsculas");


            var mensaje5 = document.getElementById("mensaje5");
            handleInputAndBlurEvents(descripcionEditar, expresionValidadora2, mensaje5, "Solo se permiten Letras Mayúsculas & un espacio entre palabra");
            handleDescriptionKeypressEvent(descripcionEditar);


            var mensaje6 = document.getElementById("mensaje6");
            handleInputAndBlurEvents(tasaEditar, expresionValidadora3, mensaje6, "Solo se permiten Datos Numericos");
            handleDescriptionKeypressEvent(tasaEditar);

            var mensaje7 = document.getElementById("mensaje7");
            handleInputAndBlurEvents(estado, expresionValidadora1, mensaje7, "Solo se permiten Letras Mayúsculas");




        }

        $(document).ready(function() {
            Historial_Cuenta();
            validarNombre();
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const cuentaInput = document.getElementById('agregar-cuenta');
        const descripcionInput = document.getElementById('agregar-descripcion');
        const tasaInput = document.getElementById('agregar-tasa');
        const estadoInput = document.getElementById('agregar-estado');
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = cuentaInput.value.trim() !== '' && descripcionInput.value.trim() !== '' &&
                tasaInput.value.trim() !== '' && estadoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        cuentaInput.addEventListener('input', checkForm);
        descripcionInput.addEventListener('input', checkForm);
        tasaInput.addEventListener('input', checkForm);
        estadoInput.addEventListener('input', checkForm);
        guardarButton.addEventListener('input', checkForm);
    </script>

    <script>
        // Obtén los campos de entrada y el botón "Guardar para editar"
        const descripcionInput1 = document.getElementById('editar-descripcion');
        const tasaInput2 = document.getElementById('editar-tasa');
        const estadoInput3 = document.getElementById('editar-estado');
        const guardarButton1 = document.getElementById('btn-editar'); // Asegúrate de que el ID del botón sea correcto

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = descripcionInput1.value.trim() !== '' || tasaInput2.value.trim() !== '' || estadoInput3.value.trim() !== '';
            guardarButton1.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        descripcionInput1.addEventListener('input', checkForm);
        tasaInput2.addEventListener('input', checkForm);
        estadoInput3.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-cuenta, #editar-cuenta').on('input', function() {
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
            document.getElementById('agregar-cuenta').value = "";
            document.getElementById('agregar-descripcion').value = "";
            document.getElementById('agregar-tasa').value = "";
            document.getElementById('agregar-estado').value = "";


            // Limpia los checkboxes
            document.getElementById('agregar-cuenta').checked = false;
            document.getElementById('agregar-descripcion').checked = false;

            location.reload();
        });

        //--------LIMPIAR MODALES DESPUES DEL BOTON CANCELAR MODAL EDITAR--------------------
        document.getElementById('btn-cancelarEditar').addEventListener('click', function() {

            // Limpia los checkboxes
            document.getElementById('editar-descripcion').checked = false;
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>

</html>