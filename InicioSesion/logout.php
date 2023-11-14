<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
    header("Location: inicio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión'
    }).then((result) => {
        if (result.value) {
            console.log('El usuario ha decidido cerrar sesión. Redirigiendo a inicio.php...');
            window.location.href = 'inicio.php?logout=true';
        } else {
            console.log('El usuario ha cancelado. Redirigiendo a index.php...');
            window.location.href = 'index.php';
        }
    });
</script>
</body>
</html>
