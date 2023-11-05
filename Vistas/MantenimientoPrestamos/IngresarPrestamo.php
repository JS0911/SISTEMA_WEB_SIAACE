<?php
session_start();
require "../../Config/conexion.php";
require_once "../../Modelos/permisoUsuario.php";

$permisosPrestamo1 = new PermisosUsuarios();
$usuario = $_SESSION['usuario'];
$id_rol = $_SESSION['id_rol'];
$id_objeto_PrestamoMantenimiento = "30";
$id_objeto_MantCuenta = "29";

$permisos = $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_PrestamoMantenimiento);
$permisos2 =  $permisosPrestamo1->get_Permisos_Usuarios($id_rol, $id_objeto_MantCuenta);

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

$sql = "SELECT PRIMER_NOMBRE, PRIMER_APELLIDO FROM tbl_me_empleados WHERE ID_EMPLEADO= $ID_EMPLEADO ";
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

$sql = "SELECT id_tipo_prestamo, tipo_prestamo FROM tbl_mp_tipo_prestamo";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$TipoPrestamo = $stmt->fetchAll(PDO::FETCH_ASSOC);
//-----------------------------------------------------------------------------

//---------CONEXION A LA TABLA FORMA DE PAGO --------
// Crear una instancia de la clase Conectar
$conexion = new Conectar(); 
$conn = $conexion->Conexion();

$sql = "SELECT id_fpago, forma_de_pago FROM tbl_formapago";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Obtener los resultados en un array asociativo
$formaPago = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traer tipo de cuentas


$sql1 = "SELECT ID_TIPOCUENTA, TIPO_CUENTA FROM tbl_mc_tipocuenta";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute();
$TiposCuentas = $stmt1->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="shortcut icon" href="../../src/IconoIDH.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../../css/styles.css" rel="stylesheet" />
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
                                            <button class="btn btn-success" data-toggle="modal" data-target="#crearModalP"> Nuevo</button>
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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#crearModalC"> Nuevo</button>
                                        </div>
                                        <table class="table table-bordered mx-auto" id="Lista-Cuentas" style="margin-top: 20px; margin-bottom: 20px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Numero De Cuenta</th>
                                                    <th scope="col">Saldo</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Modal para crear un nuevo registro de prestamo -->
                    <div class="modal fade" id="crearModalP" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
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
                                            <select class="form-control" id="agregar-tipoPrestamo" name="tipoPrestamo" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($TipoPrestamo as $tipo) : ?>
                                                    <option value="<?php echo $tipo['id_tipo_prestamo']; ?>"><?php echo $tipo['tipo_prestamo']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="FPago">Forma de Pago</label>
                                            <select class="form-control" id="agregar-formaPago" name="formaPago" required>
                                                <option value="" disabled selected>Selecciona una opción</option>
                                                <?php foreach ($formaPago as $formaPago) : ?>
                                                    <option value="<?php echo $formaPago['id_fpago']; ?>"><?php echo $formaPago['forma_de_pago']; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="MSolicitado">Monto Solicitado</label>
                                            <input type="text" class="form-control" id="agregar-MSolicitado" required pattern="\d{1,8}(\.\d{0,2})?" title="Ingrese un salario válido (hasta 8 dígitos enteros y 2 decimales)">
                                            <div id="mensaje1"></div>
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

                    <!-- Modal para crear un nuevo registro de cuentas -->
                    <div class="modal fade" id="crearModalC" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
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

                                        <label for="nombre">Numero De Cuenta</label>
                                        <input type="text" maxlength="10" class="form-control" id="NumeroCuenta">
                                        <div id="mensaje2"></div>

                                        <label for="id-estado">Tipo Cuenta</label>
                                        <select class="form-control" id="agregar-tipo-cuenta" name="Id-tipo-cuenta" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <?php foreach ($TiposCuentas as $TiposCuentas) : ?>
                                                <option value="<?php echo $TiposCuentas['ID_TIPOCUENTA']; ?>"><?php echo $TiposCuentas['TIPO_CUENTA']; ?></option>
                                            <?php endforeach; ?>
                                            <div id="mensaje3"></div>
                                        </select>

                                        <label for="Estado">Estado</label>
                                        <select class="form-control" id="agregar-estado" maxlength="15" name="estado" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="ACTIVO">ACTIVO</option>
                                            <option value="INACTIVO">INACTIVO</option>
                                        </select>
                                        <div id="mensaje4"></div>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btn-cancelarAgregar" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-agregarC">Guardar</button>
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
                        ID_EMPLEADO: <?php echo $ID_EMPLEADO; ?>,
                        ID_TIPO_PRESTAMO: tipoPrestamo,
                        ID_FPAGO: formaPago,
                        MONTO_SOLICITADO: montoSolicitado,
                        ESTADO_PRESTAMO: "PENDIENTE"
                    };

                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/prestamo.php?op=InsertPrestamo', {
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
                                //location.reload();
                                window.location.href = 'prestamo.php';
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


        function Lista_Cuentas() {
            // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
            // Actualizar el valor predeterminado

            var data = {
                "ID_EMPLEADO": <?php echo $ID_EMPLEADO; ?>, 
            };

            fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=GetCuenta', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Convierte la forma de pago en formato JSON
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
                    var tbody = document.querySelector('#Lista-Cuentas tbody');
                    tbody.innerHTML = ''; // Limpia el contenido anterior

                    data.forEach(function(pago) {
                        var row = '<tr>' +
                            '<td style="display:none;">' + pago.ID_CUENTA + '</td>' +
                            '<td>' + pago.NUMERO_CUENTA + '</td>' +
                            '<td>' + pago.SALDO + '</td>' +
                            '<td>';

                        // Validar si PERMISOS_ACTUALIZACION es igual a 1 para mostrar el botón de editar
        
                        
                            row += '<button class="btn btn-secondary crear-movimiento" data-id="' + pago.ID_CUENTA + '" onclick="redirectToIngresarPrestamo(' + pago.ID_CUENTA + ')">Depositar</button>';
                            row += '<button class="btn btn-secondary crear-movimiento" data-id="' + pago.ID_CUENTA + '" onclick="redirectToIngresarPrestamo(' + pago.ID_CUENTA + ')">Reembolso</button>';
                       
                        row += '</td>' +
                            '</tr>';
                            //Cambiar palabra null por vacio.
                            newrow = row.replaceAll("null", " ");
                            row = newrow;
                        tbody.innerHTML += row;
                    });
                    habilitarPaginacion();
                })

                .catch(function(error) {
                    // Manejar el error aquí
                    alert('Error al cargar los datos: ' + error.message);
                });

        }
        function Insertar_Cuenta() {
            $("#btn-agregarC").click(function() {
                // Obtener los valores de los campos del formulario
                var tipo_cuenta = $("#agregar-tipo-cuenta").val();
                var estado = $("#agregar-estado").val();
                var NumeroCuenta = $("#NumeroCuenta").val();
                var saldo = 0;

                if (tipo_cuenta == "" || estado == "" || NumeroCuenta == "" ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'No se pueden enviar Campos Vacios.'
                    });
                } else {
                    // Crear un tipo_cuenta con los datos a enviar al servidor
                    var datos = {
                        ID_EMPLEADO: <?php echo $ID_EMPLEADO; ?>,
                        ID_TIPOCUENTA: tipo_cuenta,
                        SALDO: saldo,
                        NUMERO_CUENTA: NumeroCuenta,
                        ESTADO: estado
                    };

                    
                    fetch('http://localhost:90/SISTEMA_WEB_SIAACE/Controladores/cuenta.php?op=InsertCuenta', {
                            
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
                                        $('#crearModalC').modal('hide');
                                        // Mostrar SweetAlert de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado exitoso',
                                            text: data.message
                                        }).then(function() {
                                            // Recargar la página para mostrar los nuevos datos
                                            window.location.href = '../MantenimientoCuentas/MantenimientoCuentas.php';
                                        });
                                    });
                                } else if (response.status === 409) {
                                    // Si el código de respuesta es 409 (Conflict), muestra mensaje de TIPO CUENTA existente
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

        
        function Deposito(){


        }



        // VALIDACIONES FUNCIONES    
        function validarNombre() {
            var agregarMSolicitado = document.getElementById("agregar-MSolicitado");

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

            var expresionValidadora1 = /^\d+(\.\d{2})?$/;
            var mensaje1 = document.getElementById("mensaje1");
            handleInputAndBlurEvents(agregarMSolicitado, expresionValidadora1, mensaje1, "Ingrese un salario válido (por ejemplo, 1000.00)");
        }
     
        $(document).ready(function() {
            Lista_Cuentas();
            Insertar_Prestamo();
            Insertar_Cuenta();
            validarNombre();
            
        });
    </script>

    <!-- VALIDACIONES SCRIPT -->
    <script>
        // Obtén los campos de entrada y el botón "Guardar para insertar"
        const agregartipoPrestamo = document.getElementById("agregar-tipoPrestamo");
        const agregarformaPago = document.getElementById("agregar-formaPago");
        const agregarMSolicitadoInput = document.getElementById("agregar-MSolicitado");
        const guardarButton = document.getElementById('btn-agregar');

        // Función para verificar si todos los campos están llenos
        function checkForm() {
            const isFormValid = agregartipoPrestamo.value.trim() !== '' && agregarformaPago.value.trim() !== '' && agregarMSolicitadoInput.value.trim() !== '';
            guardarButton.disabled = !isFormValid;
        }

        // Agrega un evento input a cada campo de entrada
        agregartipoPrestamo.addEventListener('input', checkForm);
        agregarformaPago.addEventListener('input', checkForm);
        agregarMSolicitadoInput.addEventListener('input', checkForm);
    </script>

    <script>
        // Escuchar eventos de cambio en los campos de entrada para eliminar espacios en blanco al principio y al final
        $('#agregar-tipoPrestamo, #agregar-formaPago, #agregar-MSolicitado').on('input', function() {
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
        document.getElementById('btn-agregarCancelar').addEventListener('click', function() {
            document.getElementById('agregar-tipoPrestamo').value = "";
            document.getElementById('agregar-formaPago').value = "";
            document.getElementById('agregar-MSolicitado').value = "";

            // Limpia los checkboxes
            document.getElementById('agregar-tipoPrestamo').checked = false;
            document.getElementById('agregar-formaPago').checked = false;
            document.getElementById('agregar-MSolicitado').checked = false;
            location.reload();  
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>
<html>