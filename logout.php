<?php
    session_start();
    if($_SESSION['usuario']){
        session_destroy(); // Destruye la sesión
        // Redirige al usuario a la página de inicio de sesión o a una página de confirmación
        header("Location: login.php");
    }

    exit;
    
?>