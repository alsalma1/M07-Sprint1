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
        $codi = $_GET['codigo'];
        $act = $_GET['act'];
        if ($_GET['act']== 0){
            $sql = "UPDATE `cursos` SET Estado='$act' WHERE Codigo='$codi'";
            $result = mysqli_query($conn,$sql);?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php"><?php

        }
        else{
            $sql = "SELECT * FROM `cursos` WHERE Codigo='$codi'";
            $result = mysqli_query($conn,$sql);
            $linea = mysqli_fetch_assoc($result);?>

            <?php
            if($linea['profesor']==NULL){?>
                <script>alert("Hay que asignar un profesor a este curso!")</script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php">
                <?php
            }
            else{
                $sql = "UPDATE `cursos` SET Estado='$act' WHERE Codigo='$codi'";
                $result = mysqli_query($conn,$sql);?>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php">
                <?php
            }
            
        }
    ?>
</body>
</html>