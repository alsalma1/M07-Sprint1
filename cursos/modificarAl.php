<?php
    session_start();
    include("funciones.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar perfil alumno</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        //Variable con los datos de conexión
    $conn = conexion();
    if(isset($_SESSION['email'])){
        //Recogida de los datos introducidos en el formulario
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM alumnos where email='$email'";
        $resultado = mysqli_query($conn,$sql);
        $fila = mysqli_fetch_array($resultado);
        ?>
        <p class="salir"><a href="salir.php">Cerrar sesión</p>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <?php
        if (!$_POST){
            ?>
            <h1 class='lc'>Modificar mi perfil</h1>
            <?php modificarAlumno($conn,$fila); ?>
        <?php
        }
        else{?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=editA.php">
            <?php
        }
    }
    else{
        mensageErrorA();
    }
    ?>     
</body>
</html>