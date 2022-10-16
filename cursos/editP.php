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
    if(isset($_SESSION['admin'])){?>
        <?php
        $conn = conexion();
        $dn = $_SESSION['dni'];
        $DNI =  $_POST['dni'];
        $Nombre =  $_POST['nombre'];
        $Apel =  $_POST['ape'];
        $nu =  $_POST['nombreU'];
        $tituA =  $_POST['ta'];

        
        $sql = "UPDATE `profesores` SET `nombre`='$Nombre',`apellidos`='$Apel',`titulo_academico`='$tituA',`NombreUsu`='$nu' WHERE DNI='$dn'";
        $result = mysqli_query($conn,$sql);
        ?>
        <script>alert("Datos del profesor modificados correctamente!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php"><?php
    }
    else{
            mensageError();
        }
    ?>
</body>
</html>