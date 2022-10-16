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
    <title>Listado alumnos</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>

    <?php
    if(isset($_SESSION['dni'])){
        $conn = conexion();
?>        
        <!-- Menu -->
        <ul class="vertical-menu">
            <li>
                <a href="#"><img src="pic/menu.png" alt=""></a>
                <ul>
                    <li><a href="menuP.php">Ver cursos&nbsp</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <h4 class="rol"><?php echo $_SESSION['nombre'].": Profesor" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <?php 
            $nom = $_REQUEST['nombreC']; 
            $codigo = $_REQUEST['codi'];
            $dni = $_SESSION['dni'];
            
            echo "<h1 class='lc'>Alumnos matriculados en '".$nom."'</h1>";
            ?>
        <form class="busc" action="alumnos.php" method=POST>
                <input type="text" name="buscador" placeholder="Search by name"/>
                <input class="bus" type="submit" name="enviar" value="Buscar"/>
                <input type="hidden" name="codi" value="<?php echo $codigo?>"/>
                <input type="hidden" name="nombreC" value="<?php echo $nom?>"/>
            </form>
        <?php
        if(!$_POST){//Si no se envia nada desde el formulario , imprime la tabla con todos los datos?>
            
            <?php

                                    //Mostrar la tabla de los alumnos
            //Seleccionar todos los datos de los alumnos matriculados en el curso elegido del profesor que se ha logeado
            $sql = "SELECT * FROM `cursos` c INNER JOIN matricula m ON codigo_curso = codigo INNER JOIN alumnos a ON email_alumno = email WHERE profesor = '$dni' and codigo = $codigo";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado);
            tablaAlumnos($conn,$num,$resultado);
        }
        else{?>
            <?php
            $dni = $_SESSION['dni'];
            if (isset($_POST['buscador'])){
                $nombre = $_POST['buscador'];
            }
            else{
                // si no se inserta ningun nombre , se muetran todos los alumnos
                $nombre = "";
            }
            if (isset($_POST['codi'])){
                $codigo = $_POST['codi'];
            }
            else{
                $codigo = "";
            }
   
            $sql = "SELECT * FROM `cursos` c INNER JOIN matricula m ON codigo_curso = codigo INNER JOIN alumnos a 
            ON email_alumno = email WHERE profesor = '$dni' and codigo = $codigo and nombre LIKE '%$nombre%'";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado)?>
            <?php tablaAlumnos($conn,$num , $resultado, ) ; ?>
            <?php
        }
    }
    else{
        mensageErrorP();
    }
    ?>      
</body>
</html>