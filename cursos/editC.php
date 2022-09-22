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
    <title>Modificar curso</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        if(isset($_SESSION['admin'])){?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <?php
            $conn = conexion();
            $NombreCurso =  $_POST['nombre'];
            $descri =  $_POST['descri'];
            $horas =  $_POST['horas'];
            $fechaI =  $_POST['fechaI'];
            $fechaF =  $_POST['fechaF'];
            $profesor =  $_POST['prof'];
            $nn = $_SESSION['codi'];
            
            $sql = "UPDATE `cursos` SET `nombre`='$NombreCurso',`descripcion`='$descri',`horas`='$horas',`fechaInicio`='$fechaI',`fechaFinal`='$fechaF',`profesor`='$profesor' WHERE codigo='$nn'";
            $result = mysqli_query($conn,$sql);
            ?>
            <script>alert("Curso modificado correctamente")</script>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php"><?php
        }
        else{
            mensageError();
        }
?>
</body>
</html>