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
    <title>Gestión profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){
        $conn = conexion();
        if(!$_POST){//Si no se envia nada desde el formulario , imprime la tabla con todos los datos
            $sql = "SELECT * FROM profesores";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado);?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <p class="salir"><a href="Menu.php">Ver menú</p></a>
            <h1 class='lc'>Listado profesores</h1>
            <form class="busc" action="Gprof.php" method=POST>
                <input type="text" name="buscador"/>
                <input class="bus" type="submit" name="enviar" value="Buscar"/>
            </form>

            <!-- Imprimir la tabla -->
            <?php tablaProfesores($num , $resultado); ?>

            <h3 class="ac"><a href='insertarP.php'>Añadir profesores</a></h3>
            <?php
        }
        else{
            $nombre = $_POST['buscador'];
            $sql = "SELECT * FROM profesores WHERE nombre LIKE '%$nombre%'";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado)?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <p class="salir"><a href="Menu.php">Ver menú</p></a>
            <h1 class="lc">Lista de profesores</h1>
            <?php tablaProfesores($num , $resultado) ; ?>
            <h3 class="ac"><a href='insertarP.php'>Añadir profesores</a></h3>
            <?php
        }
    }
    else{
        mensageError();
    }
    ?>      
</body>
</html>