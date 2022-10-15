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
    <title>Mis cursos</title>
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
            ?>
            <h4 class="rol"><?php echo $nombreA.": Alumno" ?></h4><?php
            $email = $_SESSION['email'];
            if(!$_POST){ //Si no se envia el formulario , es porque el usuario todavia no ha buscado nada , entoces se le muestra la tabla con todos los datos
                //Juntamos la tabla profesores para obtener el nombre del profesor , para mostarlo el la tabla (DNI-Nombre)
                $sql = "SELECT * FROM cursos as c INNER JOIN matricula as m on c.codigo = m.codigo_curso INNER JOIN profesores p ON c.profesor = p.DNI WHERE m.email_alumno = '$email' and Estado = 1";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);
                ?>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <h1 class='lc'>Mis cursos</h1>

                <form class="busc" action="misCursos.php" method=POST>
                    <input type="text" name="buscador" placeholder="Search by name"/>
                    <input class="bus" type="submit" name="enviar" value="Buscar"/>
                </form>
                
                <!-- Imprimir la tabla -->
                <?php 
                tablaMisCursos($conn,$num,$resultado);
                 ?>

            <?php
            }
            else{
                //Cuando busca el usuario , se genera una tabla con solo los datos buscados
                $nombre = $_POST['buscador'];
                $sql = "SELECT * FROM cursos as c INNER JOIN matricula as m on c.codigo = m.codigo_curso INNER JOIN profesores p ON c.profesor = p.DNI WHERE  m.email_alumno = '$email' and nombreC LIKE '%$nombre%'";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);?>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <h1 class='lc'>Mis cursos</h1>
                <?php 
                tablaMisCursos($conn,$num,$resultado);
                ?>
                <a href='misCursos.php'><img class="atras" src="pic/atras.png" alt=""/></a>
                <?php
            }
        }
        else{
            mensageErrorA();
        }
        ?>

</body>
</html>