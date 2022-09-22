<?php
    include("funciones.php");
    session_start();
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
    if(isset($_SESSION['admin'])){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <?php
        $conn = conexion();
        $DNI =  $_POST['dni'];
        $Nombre =  $_POST['nombre'];
        $Apel =  $_POST['ape'];
        $nu =  $_POST['nombreU'];
        $tituA =  $_POST['ta'];
        $foto =  $_POST['file'];
        $nn = $_SESSION['dni'];
    
        $sql = "UPDATE `profesores` SET `DNI`='$DNI',`nombre`='$Nombre',`apellidos`='$Apel',`titulo_academico`='$tituA',`fotografia`='$foto',`NombreUsu`='$nu' WHERE DNI='$nn'";
        $result = mysqli_query($conn,$sql);
        ?>
        <script>alert("Curso modificado correctamente")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php"><?php
    }
    else{
            mensageError();
        }
    ?>
</body>
</html>