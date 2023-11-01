<?php
session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosPrestamo1 = new PermisosUsuarios();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

if (isset($_GET['ID_EMPLEADO'])) {
    $ID_EMPLEADO = $_GET['ID_EMPLEADO'];

    // Redirige al usuario a la página IngresarPrestamo.php con el parámetro ID_EMPLEADO
    header("Location: http://localhost:90/SISTEMA_WEB_SIAACE/Vistas/MantenimientoPrestamo/IngresarPrestamo.php?ID_EMPLEADO=$ID_EMPLEADO");
    exit; // Asegúrate de salir para evitar que se siga ejecutando el código actual
} else {
    echo "No se proporcionó el ID_EMPLEADO en la URL.";
}


$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
//$selec_id_usuario = $session['selec_idusuario'];
$id_objeto_PrestamoMantenimiento = "30";


$permisos = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);

?>
<style>
    .logo {
        width: 50px;
        /* Ancho deseado del logo */
        margin-right: 10px;
        /* Espacio a la derecha del logo para separarlo del texto */

        /* Define a custom CSS class for success messages */
    }

    .success-message {
        color: green;
        /* Change the color to your preferred color */
        font-weight: bold;
        /* Optionally make the text bold */
    }
</style>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Prestamo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../../src/IconoIDH.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <style>
        /* Estilo para la tabla */
        #Lista-tipoprestamo {
            border-collapse: collapse;
            /* Combina los bordes de las celdas */
            width: 100%;
        }

        /* Estilo para las celdas del encabezado (th) */
        #Lista-tipoprestamo th {
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

        /* Estilo para el main (td) */
        #Lista-tipoprestamo td {
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
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../../InicioSesion/cambiocontrasena.php">Cambio de Contraseña</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../InicioSesion/logout.php">Salir</a>
                </div>
            </li>
        </ul>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline mr-0 my-2 my-md-0 order-2">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
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

                        //----------------------------MODULO DE PRESTAMOS------------------------------------
                        if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
                            echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMantenimientoPrestamo" aria-expanded="false" aria-controls="collapseMantenimientoPrestamo">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-check"></i></div>
                            Modulo Prestamo
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </a>';
                            echo '<div class="collapse" id="collapseMantenimientoPrestamo" aria-labelledby="headingMantenimientoPrestamo" data-parent="#sidenavAccordion">';
                            echo '<nav class="sb-sidenav-menu-nested nav">';

                            if (!empty($permisos) && $permisos[0]['PERMISOS_CONSULTAR'] == 1) {
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
    </div>

    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>

                <div class="container">
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body">
                                    <div class="grid-row align-items-center">
                                        <div class="col-9 bel-padding-reset">
                                            <div class="display-flex flex-direction-column">
                                                <h2 class="bel-typography bel-typography-h2">Cuentas y Prestamos</h2>
                                                <span class="bel-typography bel-typography-h5"><?php echo $usuario; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6 bel-padding-reset">
                                            <div class="display-flex justify-content-end">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="accordion col-lg-10" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Prestamos
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#crearModal"> Nuevo</button>
                                        </div>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Numero</th>
                                                    <th scope="col">Saldo Capital</th>
                                                    <th scope="col">Saldo interes</th>
                                                    <th scope="col">Detalles</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>1000</td>
                                                    <td>10000</td>
                                                    <td><a href="URL_DEL_DESTINO">Ver Cuotas</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Cuentas
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Numero</th>
                                                    <th scope="col">Saldo</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>10000</td>
                                                    <td><a href="URL_DEL_DESTINO">Depositos</a><br><a href="URL_DEL_DESTINO">Retiros</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

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
                                        
                                            

                                            <label for="tipoPrestamo">Tipo Prestamo</label>
                                            <input type="text" maxlength="15" class="form-control" id="agregar-tipoPrestamo" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                            <div id="mensaje3"></div>

                                            <label for="FPago">Forma de Pago</label>
                                            <input type="text" maxlength="15" class="form-control" id="agregar-Fpago" required pattern="^(?!\s)(?!.*\s$).*$" title="No se permiten espacios en blanco ni campo vacío" oninput="this.value = this.value.toUpperCase()">
                                            <div id="mensaje4"></div>

                                            <label for="Mdesembolso">Monto Solicitado</label>
                                            <input type="text" class="form-control" id="agregar-MDesembolsao" required pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un salario válido (hasta 8 dígitos enteros y 2 decimales)">
                                            <div id="mensaje7"></div>

                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-agregarCancelar" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-agregar" disabled>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </main>
        </div>
    </div>

    <script>
        function Insertar_Prestamo() {
            $("#btn-agregar").click(function() {
                // Obtener los valores de los campos del formulario
                var dni = $("#agregar-dni").val();
                var Pnombre = $("#agregar-Pnombre").val();
                var Snombre = $("#agregar-Snombre").val();
                var Papellido = $("#agregar-Papellido").val();
                var Sapellido = $("#agregar-Sapellido").val();
                var email = $("#agregar-email").val();
                var salario = $("#agregar-salario").val();
                var estado = document.getElementById("agregar-estado").value; // Obtener el valor del select
                var telefono = $("#agregar-telefono").val();
                var direccion1 = $("#agregar-direccion1").val();
                var direccion2 = $("#agregar-direccion2").val();

                if (dni == "" || Pnombre == "" || Snombre == "" || Papellido == "" || Sapellido == "" ||
                    email == "" || salario == "" || estado == "" || telefono == "" || direccion1 == "" || direccion2 == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        DNI: dni,
                        PRIMER_NOMBRE: Pnombre,
                        SEGUNDO_NOMBRE: Snombre,
                        PRIMER_APELLIDO: Papellido,
                        SEGUNDO_APELLIDO: Sapellido,
                        EMAIL: email,
                        SALARIO: salario,
                        ESTADO: estado,
                        TELEFONO: telefono,
                        DIRECCION1: direccion1,
                        DIRECCION2: direccion2
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/empleados.php?op=InsertEmpleado', {
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
                            console.log(error.message);

                            // Mostrar SweetAlert de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al guardar los datos: ' + error.message
                            });
                        });
                }
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <!-- <script src="../assets/demo/datatables-demo.js"></script>                     -->
</body>
<html>