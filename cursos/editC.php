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
    <title>Modificar curso</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        if(isset($_SESSION['admin'])){?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <?php
            $conn = conexion();
            $NombreCurso =  $_POST['nombreC'];
            $descri =  $_POST['descri'];
            $horas =  $_POST['horas'];
            $fechaI =  $_POST['fechaI'];
            $fechaF =  $_POST['fechaF'];
            $profesor =  $_POST['prof'];
            $co = $_SESSION['codi'];
            
            if($fechaI<$fechaF){

                $sql = "UPDATE `cursos` SET `nombreC`='$NombreCurso',`descripcion`='$descri',`horas`='$horas',`fechaInicio`='$fechaI',`fechaFinal`='$fechaF', `profesor`='$profesor' WHERE codigo='$co'";
                $result = mysqli_query($conn,$sql);
                if($result==False){?>
                    <script>alert("Fallo al editar el curso!!")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php">
                    <?php
                }
                else{?>
                    <script>alert("Curso modificado correctamente")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php">
                    <?php 
                }
            }
            else{?>
                <script>
                    alert("La fecha de inicio de curso tiene que ser menor que la fecha del final")
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php">
                <?php
            }
        }
        else{
            mensageError();
        }
?>
</body>
</html>