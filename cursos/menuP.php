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
    <title>Menu profesor</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    $conn = conexion();
    if(isset($_SESSION['dni'])){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <p class="salir"><a href="salir.php">Cerrar sesión</a></p>
        <?php
            //Nombre del profesor
            $nombre = $_SESSION['nombre'];
            echo "<h2 class='h2'>Bienvenido/a ". $nombre. ". </h2>";
            $dni = $_SESSION['dni'];

            //Si no se han enviado datos para buscar :
            if(!$_POST){
                $sql="SELECT * FROM profesores p INNER JOIN cursos c ON c.profesor = p.DNI WHERE profesor = '$dni'";
                $result = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($result);

                if($num==0){
                    //Si el profesor esta activado pero aun no tiene ningun curso asignado:
                    echo "<h2 class='h2'><br>Aún no tienes ningún curso asignado</h2>";
                }
                else{?>
                    <form class="busc" action="menuP.php" method=POST>
                        <input type="text" name="buscador" placeholder="Search by name"/>
                        <input class="bus" type="submit" name="enviar" value="Buscar"/>
                    </form>
                    <?php

                    //Imprimir los datos de los cursos
                    mostrarCursos($conn,$result,$num);
                }       
            }
            else{
                $nombre = $_POST['buscador'];
                $sql = "SELECT * FROM profesores p INNER JOIN cursos c ON c.profesor = p.DNI WHERE profesor = '$dni' and nombreC LIKE '%$nombre%'";
                $result= mysqli_query($conn,$sql);
                $num = mysqli_num_rows($result)?>
                <h1 class="lc">Listado cursos</h1>
                <a href='menuP.php'><img class="atrasB" src="pic/atras.png" alt=""/></a>
                <?php mostrarCursos($conn,$result ,$num) ; ?>
                <?php
            }
            
            ?>
        
        <?php
    }
    else{
        mensageErrorP();
    }
    ?>
    
</body>
</html>