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
    <title>Activar o desactivar</title>
</head>
<body>
    <?php
        $conn = conexion();
        $dni = $_GET['dniP'];
        $act = $_GET['act'];
        if ($_GET['act']== 0){
            $sql = "UPDATE `profesores` SET estadop='$act' WHERE DNI='$dni'";
            $result = mysqli_query($conn,$sql);

            $sql = "UPDATE `cursos` SET estado = 0 , profesor = NULL WHERE profesor='$dni'";
            $result = mysqli_query($conn,$sql);
            ?>

            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php">
            <?php

        }
        else{
            $sql = "UPDATE `profesores` SET estadop='$act' WHERE DNI='$dni'";
            $result = mysqli_query($conn,$sql);?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php"><?php
            
        }
    ?>
</body>
</html>