<?php
session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosPrestamo1 = new PermisosUsuarios();
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_PrestamoMantenimiento = "30";

$permisos = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
}

if (isset($_GET['ID_EMPLEADO'])) {
    $ID_EMPLEADO = $_GET['ID_EMPLEADO'];
} else {
    echo "No se proporcionó el ID_EMPLEADO en la URL.";
}

//---------CONEXION A LA TABLA EMPLEADOS --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

// Consultar la contraseña actual del usuario desde la base de datos
$sql = "SELECT PRIMER_NOMBRE ,PRIMER_APELLIDO FROM tbl_me_empleados WHERE ID_EMPLEADO= $ID_EMPLEADO ";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$nombre_empleado = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Unir el primer nombre y apellido
$nombre_empleado_unido = implode(" ", $nombre_empleado[0]);

//------------------------------------------------------------------------

//---------CONEXION A LA TABLA TIPO PRESTAMO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

// Consultar la contraseña actual del usuario desde la base de datos
$sql = "SELECT id_tipo_prestamo ,tipo_prestamo FROM tbl_mp_tipo_prestamo";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$TipoPrestamo = $stmt->fetchAll(PDO::FETCH_ASSOC);
//-----------------------------------------------------------------------------

//---------CONEXION A LA TABLA FORMA DE PAGO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar();
$conn = $conexion->Conexion();

// Consultar la contraseña actual del usuario desde la base de datos
$sql = "SELECT id_fpago ,forma_de_pago FROM tbl_formapago";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$formaPago = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                                                <span class="bel-typography bel-typography-h5"><?php echo $nombre_empleado_unido; ?></span>
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
                                            <select class="form-control" id="agregar-tipoPrestamo" name="tipoPrestamo">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($TipoPrestamo as $tipo) : ?>
                                                    <option value="<?php echo $tipo['id_tipo_prestamo']; ?>"><?php echo $tipo['tipo_prestamo']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="FPago">Forma de Pago</label>
                                            <select class="form-control" id="agregar-formaPago" name="formaPago">
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($formaPago as $formaPago) : ?>
                                                    <option value="<?php echo $formaPago['id_fpago']; ?>"><?php echo $formaPago['forma_de_pago']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="MSolicitado">Monto Solicitado</label>
                                            <input type="text" class="form-control" id="agregar-MSolicitado" required pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un salario válido (hasta 8 dígitos enteros y 2 decimales)">
                                            <div id="mensaje7"></div>

                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btn-agregarCancelar" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn-agregar" >Guardar</button>
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
                
                var tipoPrestamo = document.getElementById("agregar-tipoPrestamo").value; // Obtener el valor del select
                var formaPago = document.getElementById("agregar-formaPago").value; // Obtener el valor del select
                var montoSolicitado = $("#agregar-MSolicitado").val();

                if (tipoPrestamo == "" || formaPago == "" || montoSolicitado == "" ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un objeto con los datos a enviar al servidor
                    var datos = {
                        ID_TIPO_PRESTAMO: tipoPrestamo,
                        ID_FPAGO: formaPago,
                        MONTO_SOLICITADO: montoSolicitado,
                       
                    };

                    fetch('http://localhost:90/SISTEMA1/Controladores/prestamo.php?op=InsertPrestamo', {
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
     
        $(document).ready(function() {
            Insertar_Prestamo();
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <!-- <script src="../assets/demo/datatables-demo.js"></script>                     -->
</body>
<html>