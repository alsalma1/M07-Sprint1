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
    <title>Gestión cursos</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        if(isset($_SESSION['admin'])){
            $conn = conexion();
            if(!$_POST){ //Si no se envia el formulario , es porque el usuario todavia no ha buscado nada , entoces se le muestra la tabla con todos los datos
                $sql = "SELECT * FROM cursos";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);?>
                
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <p class="salir"><a href="Menu.php">Ver menú</p></a>
                <h1 class='lc'>Listado cursos</h1>

                <form class="busc" action="Gcursos.php" method=POST>
                    <input class="search" type="text" name="buscador"/>
                    <input class="bus" type="submit" name="enviar" value="Buscar"/>
                </form>
                <!-- Imprimir la tabla -->
                <?php 
                tablaCursos($num,$resultado);
                 ?>

                <h3 class="ac"><a href='insertarC.php'>Añadir cursos</a></h3>
            <?php
            }
            else{
                //Cuando busca el usuario , se genera una tabla con solo los datos buscados
                $nombre = $_POST['buscador'];
                $sql = "SELECT * FROM cursos WHERE nombre LIKE '%$nombre%'";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);?>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <p class="salir"><a href="Menu.php">Ver menú</p></a>
                <h1 class='lc'>Listado cursos</h1>
                <?php 
                tablaCursos($num,$resultado);
                ?>
                <h3 class="ac"><a href='insertarC.php'>Añadir cursos</a></h3>
                <?php
            }
        }
        else{
            mensageError();
        }
        ?>

</body>
</html>