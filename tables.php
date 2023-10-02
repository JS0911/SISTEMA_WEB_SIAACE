
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
        <title>Mantenimiento Usuario</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Start Bootstrap</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
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
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard</a
                            >
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
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts</a
                            ><a class="nav-link" href="tables.html"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Lista de Usuarios</a
                            >
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                
            <!-- DESDE AQUI COMIENZA EL MANTENIMIENTO DE USUARIO -->    
            <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Mantenimiento Usuario</h1>
                        
                                   <!-- Botón para abrir el formulario de creación -->
                                    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#crearModal">Crear Nuevo</button>

                                <!-- Tabla para mostrar los datos -->
                                <table class="table table-bordered" id="Lista-Usuarios">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Estado</th>
                                            <th>Correo Electronico</th>
                                            <th>Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
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
                                                        <label for="nombre">Usuario</label>
                                                        <input type="text" class="form-control" id="agregar-usuario">

                                                        <label for="nombre">Nombre</label>
                                                        <input type="text" class="form-control" id="agregar-nombre">

                                                        <label for="estado">Estado</label>
                                                        <input type="text" class="form-control" id="agregar-estado">

                                                        <label for="estado">Correo Electronico</label>
                                                        <input type="text" class="form-control" id="agregar-correo">

                                                        <label for="estado">Rol</label>
                                                        <input type="text" class="form-control" id="agregar-rol">

                                                        <label for="estado">Contraseña</label>
                                                        <input type="password" class="form-control" id="agregar-contrasena">

                                                        <label for="estado">Confirmar Contraseña</label>
                                                        <input type="password" class="form-control" id="confirmar-contrasena">
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
                                                        <label for="nombre">Nombre</label>
                                                        <input type="text" class="form-control" id="editar-nombre">
                                                        <label for="estado">Estado</label>
                                                        <input type="text" class="form-control" id="editar-estado">
                                                        <label for="estado">Correo Electronico</label>
                                                        <input type="text" class="form-control" id="editar-correo">
                                                        <label for="estado">Rol</label>
                                                        <input type="text" class="form-control" id="editar-rol">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary">Guardar Cambios</button>
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

<!-- EL CODIGO ESTA QUEMADO AQUI, NO FUNCIONA REFERENCIA A LOS ARCHIVOS -->           
<script >

    function Lista_Usuarios() {
           // Realizar una solicitud FETCH para obtener los datos JSON desde tu servidor
           fetch('http://localhost:90/SISTEMA1/Controladores/usuarios.php?op=GetUsuarios', {
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
                var tbody = document.querySelector('#Lista-Usuarios tbody');
                data.forEach(function(usuario) {
                    var row = '<tr>' +
                        '<td>' + usuario.ID_USUARIO + '</td>' +
                        '<td>' + usuario.USUARIO + '</td>' +
                        '<td>' + usuario.NOMBRE_USUARIO + '</td>' +
                        '<td>' + usuario.ID_ESTADO_USUARIO + '</td>' +
                        '<td>' + usuario.CORREO_ELECTRONICO + '</td>' +
                        '<td>' + usuario.ID_ROL + '</td>' +
                        '<td>' +
                        '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal">Editar</button>' +
                        '<button class="btn btn-danger">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    tbody.innerHTML += row;
                });

            })
            
            .catch(function(error) {
                // Manejar el error aquí
                alert('Error al cargar los datos: ' + error.message);
            });
         
        }
          
    function Insertar_Usuario() {
    $("#btn-agregar").click(function() {
        // Obtener los valores de los campos del formulario
        var usuario = $("#agregar-usuario").val();
        var nombre = $("#agregar-nombre").val();
        var estado = $("#agregar-estado").val();
        var correo = $("#agregar-correo").val();
        var rol = $("#agregar-rol").val();
        var contrasena = $("#agregar-contrasena").val();
        var confirmarContrasena = $("#confirmar-contrasena").val();
        
        // Verificar que las contraseñas coincidan
        if (contrasena !== confirmarContrasena) {
            alert("Las contraseñas no coinciden.");
            return;
        }
        
        // Crear un objeto con los datos a enviar al servidor
        var datos = {
            USUARIO: usuario,
            NOMBRE_USUARIO: nombre,
            ID_ESTADO_USUARIO: estado,
            CORREO_ELECTRONICO: correo,
            ID_ROL: rol,
            CONTRASENA: contrasena
        };

        fetch('http://localhost:90/SISTEMA1/Controladores/usuarios.php?op=InsertUsuarios', {
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
            Lista_Usuarios();
            console.log(data);
            alert(data);
            // Cerrar la modal después de guardar
            $('#crearModal').modal('hide');
           
        })
        .catch(function(error) {
            // Manejar el error aquí
            alert('Error al guardar el usuario: ' + error.message);
            console.log(error.message);
        });            
    });  
 }
    
    $(document).ready(function() { 
            Lista_Usuarios();
            Insertar_Usuario();  
    });

 </script> 

        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
