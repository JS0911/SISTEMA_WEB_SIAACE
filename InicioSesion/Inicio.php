<?php

    session_start();

    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        if (isset($_SESSION['usuario'])) {
            require_once "../Config/conexion.php";
            require_once "../Modelos/bitacora.php";
            $bitacora = new bitacora();
            $date = new DateTime(date("Y-m-d H:i:s"));
            $dateMod = $date->modify("-7 hours");
            $dateNew = $dateMod->format("Y-m-d H:i:s");
            $conexion = new Conectar();
            $conectar = $conexion->Conexion();
            $conexion->set_names();

            $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;
            $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario Desconocido';

            if($bitacora->obtenervalorBitacora() == 1)
            {
              $sql = "INSERT INTO tbl_ms_bitacora (FECHA,ID_USUARIO, TABLA, OPERACION) VALUES ('$dateNew','$id_usuario', 2, 'CIERRE DE SESION')";
              $stmt = $conectar->prepare($sql);
              $stmt->execute();
            }

            session_destroy();

        } else {
            echo "No se puede salir, ya que el usuario no ha cerrado sesión.";
            header("Location: index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio SIAACE</title>
  <link rel="shortcut icon" href="../src/IconoIDH.ico">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
  crossorigin="anonymous">
  <style>
      .logo {
          width: 50px; /* Ancho deseado del logo */
          margin-right: 10px; /* Espacio a la derecha del logo para separarlo del texto */
      }

      /* Estilo para difuminar la imagen de fondo */
      .background-image {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          z-index: -1;
          filter: blur(2.5px); /* Ajustar la cantidad de desenfoque */
          background-size: cover; /* Ajustar la imagen para que cubra todo el fondo sin recortar */
          height: 100vh; /* Ajustar el alto al 100% de la ventana */
      }
      
  </style>  
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <img src="../src/Logo.png" alt="Logo SIAACE" class="logo"> <a class="navbar-brand" href="#">SIAACE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Nosotros
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="historia.html" style="color: green;">Historia</a></li>
            <li><a class="dropdown-item" href="mision.html" style="color: green;">Misión</a></li>
            <li><a class="dropdown-item" href="vision.html" style="color: green;">Visión</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contacto.html" style="color: white;">Contáctanos</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<!-- Agrega un elemento div para la imagen de fondo -->
<div id="background-image" class="background-image"></div>

<!-- JavaScript para cambiar la imagen de fondo y aplicar desenfoque -->
<script>
    // Lista de imágenes
    const images = [
        '../src/IDH1.jpg',
        '../src/IDH2.jpg',
        '../src/IDH3.jpg',
    ];

    // Función para cambiar la imagen de fondo y aplicar desenfoque
    function changeBackgroundImage() {
        const randomImage = images[Math.floor(Math.random() * images.length)];
        const backgroundImage = document.getElementById('background-image');
        backgroundImage.style.backgroundImage = `url(${randomImage})`;
    }

    // Cambia la imagen de fondo cada 3 segundos (3000 milisegundos)
    setInterval(changeBackgroundImage, 3000);

    // Cambia la imagen de fondo al cargar la página
    window.onload = changeBackgroundImage;
</script>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
crossorigin="anonymous"></script>
</body>
</html>
