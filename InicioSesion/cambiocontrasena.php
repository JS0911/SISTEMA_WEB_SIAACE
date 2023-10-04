
<?php
require "../Config/conexion.php"; 
session_start();
$id_usuario = $_SESSION['id_usuario'];
$usuario = $_SESSION['usuario'];
$contrasenaActualError = "";
$nuevaContrasenaError = "";
$confirmarContrasenaError = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Entró en el bloque POST"; 
    $contrasenaActual = $_POST["contrasenaActual"];
    $nuevaContraseña = $_POST["contraseña"];
    $confirmarContraseña = $_POST["confirmarContraseña"];

    // Crear una instancia de la clase Conectar
    $conexion = new Conectar();
    $conn = $conexion->Conexion();

    // Consultar la contraseña actual del usuario desde la base de datos
    $sql = "SELECT contrasena FROM tbl_ms_usuario WHERE id_usuario = :id_usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {$contrasenaBD = $row['contrasena'];

        if (password_verify($contrasenaActual, $contrasenaBD)) {
            // Contraseña actual es correcta

            if ($nuevaContraseña === $confirmarContraseña) {
                // Nuevas contraseñas coinciden

                $conexion = new Conectar();
                $conn = $conexion->Conexion();
                $conexion->set_names();
                $idUsuario = $usuario;

                $hashedPassword = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
                $sql = "UPDATE tbl_ms_usuario SET CONTRASENA = ? WHERE USUARIO= ?";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bindParam(1, $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(2, $idUsuario, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        echo '<p class="success-message">Contraseña cambiada con éxito.</p>';
                        header("refresh:2;url=login.php");
                        exit;
                    } else {
                        echo "Error al cambiar la contraseña: " . $stmt->errorInfo()[2];
                    }
                } else {
                    echo "Error en la preparación de la consulta: " . $conn->errorInfo()[2];
                }
            } else {
                $confirmarContrasenaError = "Las contraseñas nuevas no coinciden. Por favor, inténtalo de nuevo.";
            }
        } else {
            
                $contrasenaActualError = "La contraseña actual no es válida. Por favor, inténtalo de nuevo.";
                echo $contrasenaActualError;
        }
    } else {
        echo "Error al obtener la contraseña actual desde la base de datos.";
    }    
    // Cierra la conexión
    $conn = null;

}

?>

<style>
    .logo {
    width: 50px; /* Ancho deseado del logo */
    margin-right: 10px; /* Espacio a la derecha del logo para separarlo del texto */
    
    /* Define a custom CSS class for success messages */
}
.success-message {
        color: green; /* Change the color to your preferred color */
        font-weight: bold; /* Optionally make the text bold */
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
        <title>Cambio de Contraseña</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
    <body class="sb-nav-fixed">
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
                    <a class="navbar-brand" href="index.php">
                    <img src="../src/Logo.png" alt="Logo SIAACE" class="logo"> SIAACE</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
                    <!-- Navbar-->
                    <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $usuario; ?><i class="fas fa-user fa-fw"></i></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="cambiocontrasena.php">Cambiar Contraseña</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Salir</a>
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
                            <a class="nav-link" href="index.php"
							><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Inicio</a
							>
							<!-- <?php if($id_rol == 1) { ?>
								
								<div class="sb-sidenav-menu-heading">Interface</div>
								<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
								><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
									Layouts
									<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
									></a>
									<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
										<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a></nav>
									</div>
									<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
									><div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
										Pages
										<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
										></a>
										<div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
											<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
												<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth"
												>Authentication
													<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
													></a>
													<div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
														<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
													</div>
													<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError"
													>Error
														<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
														></a>
														<div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
															<nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
														</div>
											</nav>
										</div>
										
							<?php } ?>
                            <?php if($id_rol == 2) { ?>
								<?php echo $id_usuario; ?>
									
							<?php } ?> -->
							
							<div class="sb-sidenav-menu-heading">Addons</div>
							<a class="nav-link"  href="../charts.html"
							><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
								Charts</a
								><a class="nav-link" href="../Vistas/MantenimientoUsuario/usuarios.php"
								><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
									Usuarios</a
								>
                                <a class="nav-link" href="../roles.php"
								><div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
									Roles</a
								>
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
                            <div class="row justify-content-center">
                                <div class="col-lg-5">
                                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Cambio de Contraseña</h3></div>
                                            <div class="card-body">
                                                
                                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

                                                    <!-- input para Contraseña Actual -->
                                                    <div class="wrap-input mb-3" id="grupo__password">
                                                        <label><b>Contraseña Actual</b></label>
                                                        <span class="lock conteiner-icon">
                                                            <i class="icon type-lock fa fa-eye-solid  fa fa-eye-slash"></i>
                                                        </span>
                                                        <input type="password" class="form-control input" name="contrasenaActual" id="passwordActual" maxlength="15" placeholder="Contraseña Actual">
                                                        <p class="mensaje"></p>
                                                        <br>
                                                    </div>
                                                    <!-- input para Contraseña -->
                                                        <div class="wrap-input mb-3" id="grupo__password">
                                                            <label><b>Contraseña</b></label>
                                                                <span class="lock conteiner-icon">
                                                                    <i class="icon type-lock fa fa-eye-solid  fa fa-eye-slash"></i>
                                                                </span>
                                                            <input type="password" class="form-control input" name="contraseña" id="password" maxlength="15" placeholder="Contraseña">
                                                                    <!--  <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                                            <p class="mensaje"></p>
                                                            <br>
                                                        </div>
                                                        <!-- input para confirmación Contraseña -->
                                                        <div class="wrap-input mb-3" id="grupo__password2">
                                                            <label><b>Confirmar contraseña</b></label>
                                                                    <span class="lock conteiner-icon">
                                                                        <i class="icon type-lock fa-eye-solid  fa fa-eye-slash"></i>
                                                                    </span>
                                                                        <input type="password" class="form-control input" name="confirmarContraseña" id="password2" maxlength="15" placeholder="Confirmar Contraseña" >
                                                                        <!-- <i class="form-control__validacion-estado fas fa-times-circle"></i> -->
                                                                        <p class="mensaje"></p>
                                                            <button type="submit" class="btn btn-primary" name="submit" id= "click">Confirmar</button>
                                                            <button type="button" class="btn btn-danger" name="cancelar" id="clickCancelar">Cancelar</button>
                                                            <script>
                                                                document.getElementById("clickCancelar").addEventListener("click", function() {
                                                                    window.location.href = "index.php";
                                                                });
                                                            </script>
                                                        </div>       
                                                    </div>
                                                    <!-- Este div se utilizará para mostrar mensajes -->
                                                    <div id="mensajeDiv">
                                                                
                                                                        <?php if (!empty($contrasenaActualError)): ?>
                                                                            <div class="alert alert-danger"><?php echo $contrasenaActualError; ?></div>
                                                                        <?php endif; ?>
                                                                        <?php if (!empty($nuevaContrasenaError)): ?>
                                                                            <div class="alert alert-danger"><?php echo $nuevaContrasenaError; ?></div>
                                                                        <?php endif; ?>
                                                                        <?php if (!empty($confirmarContrasenaError)): ?>
                                                                            <div class="alert alert-danger"><?php echo $confirmarContrasenaError; ?></div>
                                                                        <?php endif; ?>
                                                                </div> 
                                                    
                                                </form>           
                                    </div>
                                </div>
                            </div>        
                        </div>           
                </main>              
            </div>
        </div> 
          
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>                    
    </body>
 <html>
