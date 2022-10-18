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
    <title>Cursos disponibles</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        if(isset($_SESSION['email'])){
            $conn = conexion();?>
            <!-- Menu -->
            <ul class="vertical-menu">
                <li>
                    <a href="#"><img src="pic/menu.png" alt=""></a>
                    <ul>
                        <li><a href="menuAl.php">Ver menú</a></li>
                        <li><a href="salir.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
            <?php
            $nombreA = $_SESSION['nombreA'];
            $email = $_SESSION['email'];
            ?>
            <h4 class="rol"><?php echo $nombreA.": Alumno" ?></h4><?php
            if(!$_POST){ //Si no se envia el formulario , es porque el usuario todavia no ha buscado nada , entonces se le muestra la tabla con todos los datos
                ?>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <?php
                //Mostar los cursos que aún no han empezado , son activados y no se encuentran en la tabla "Matricula"
                $sql = "SELECT * FROM cursos C INNER JOIN profesores p ON c.profesor = p.DNI WHERE Estado = 1 and fechaInicio > NOW() and codigo not in (SELECT codigo_curso FROM matricula WHERE codigo_curso = codigo and email_alumno='$email')";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);
                ?>
                <h1 class='lc'>Cursos disponibles</h1>

                <!-- ---------------- Buscador --------------------->
                <form class="busc" action="cursosD.php" method=POST>
                    <input type="text" name="buscador" placeholder="Search by name"/>
                    <input class="bus" type="submit" name="enviar" value="Buscar"/>
                </form>
                <!-- Imprimir la tabla -->
                <?php 
                tablaCursosDispo($conn,$num,$resultado);
                 ?>

            <?php
            }
            else{
                //Cuando busca el usuario , se genera una tabla con solo los datos buscados
                $nombre = $_POST['buscador'];
                $sql = "SELECT * FROM cursos C INNER JOIN profesores p ON c.profesor = p.DNI WHERE nombreC LIKE '%$nombre%' and Estado = 1 and fechaInicio > NOW() and codigo not in (SELECT codigo_curso FROM matricula WHERE codigo_curso = codigo and email_alumno='$email')";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);
                ?>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <h1 class='lc'>Cursos disponibles</h1><?php 
                tablaCursosDispo($conn,$num,$resultado);?>
                <a href='cursosD.php'><img class="atras" src="pic/atras.png" alt=""/></a>
                <?php
            }
        }
        else{
            mensageErrorA();
        }
        ?>

</body>
</html>