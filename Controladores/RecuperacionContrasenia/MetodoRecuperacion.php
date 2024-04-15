<?php
if (isset($_POST['radioOption'])) {
    $selectedOption = $_POST['radioOption'];
    if ($selectedOption == 'correo') {
        // Acción cuando se selecciona "Correo electrónico"
        //header("Location: ../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php");
        echo '<script type="text/javascript">';
        echo 'window.location.href="../../Vistas/RecuperacionContrasenia/RecuperacionCorreo.php";';
        echo '</script>';
    } elseif ($selectedOption == 'pregunta') {
        // Acción cuando se selecciona "Pregunta secreta"
        echo '<script type="text/javascript">';
        echo 'window.location.href="../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php";';
        echo '</script>';
        //header("Location: ../../Vistas/RecuperacionContrasenia/RecuperacionPregunta.php");
    } else {
        // Acción por defecto si no se selecciona ninguna opción válida
        echo "<script type='text/javascript'>
                alert('¡Ninguna opción válida.!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/MetodoRecuperacion.php';
                }, 0);
                </script>";
        exit;
    }
} else {
    // Acción por defecto si no se recibe ninguna opción
    echo "<script type='text/javascript'>
                alert('¡No se recibe ninguna opción.!');
                setTimeout(function() {
                window.location.href = '../../Vistas/RecuperacionContrasenia/MetodoRecuperacion.php';
                }, 0);
                </script>";
    exit;
}
