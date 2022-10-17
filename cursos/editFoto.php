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
    <title>Modificar imagen</title>
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){?>
        <?php
        $conn = conexion();
        $dn = $_SESSION['dni'];
        if (is_uploaded_file ($_FILES['archivo']['tmp_name'])){
            $nombreDirectorio = "img/";
            $archivo=$_FILES['archivo']['name'];

            move_uploaded_file ($_FILES['archivo']['tmp_name'],$nombreDirectorio .$archivo );
        }

        $ruta = $nombreDirectorio.$archivo;
        $sql = "UPDATE `profesores` SET fotografia = '$ruta' WHERE DNI='$dn'";
        $result = mysqli_query($conn,$sql);
        ?>
        <script>alert("Imagen modificada correctamente!")</script> 
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php">
        <?php 
    }
    else{
            mensageError();
        }
    ?>
</body>
</html>