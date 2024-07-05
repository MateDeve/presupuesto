<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    require_once("includes/conexion.php");

    $usuarios = mysqli_query($enlace, "select id_usuario, status
                                    from usuarios where nombre_usuario = '$user' AND contraseña = '$pass'") or 
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));
    if($usuario = mysqli_fetch_array($usuarios, MYSQLI_ASSOC)){
        $user_status = $usuario['status'];
        $id_usuario = $usuario['id_usuario'];

        echo $id_usuario;
        mysqli_close($enlace);

        session_start();
        $_SESSION["usuario"] = $user;
        $_SESSION["id_usuario"] = $id_usuario;

        if($user_status == 0){
            header('Location: cambiar_contraseña.php');
            echo $user_status;
        }else{
            header("Location: index.php");
        }
    }else{
        session_start();
        $_SESSION['invalido'] = "El usuario no existe";
        header("Location: /login.php");
    }
    
}




?>