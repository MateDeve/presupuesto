<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Location: ../login.php"); // Redirige a la página de inicio de sesión si el usuario no ha iniciado sesión
    }
    else{
        echo "<h5>Bienvenid@ " . $_SESSION["usuario"] . "</h5>";
    }
?>