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
    <title>Modificar profesor</title>
</head>
<body>
    <?php

        $conn = conexion();

        $DNI =  $_POST['dni'];
        $Nombre =  $_POST['nombre'];
        $Apel =  $_POST['ape'];
        $email =  $_POST['email'];
        $edad =  $_POST['edad'];
        $emailA = $_SESSION['email'];

        $sql = "UPDATE `alumnos` SET `email`='$email',`nombre`='$Nombre',`apellidos`='$Apel',`edad`='$edad' WHERE email = '$emailA'";
        $result = mysqli_query($conn,$sql);
        ?>
        <script>alert("Perfil modificado correctamente!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=menuAl.php"><?php

    ?>
</body>
</html>