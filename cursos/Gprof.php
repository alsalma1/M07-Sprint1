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
    <title>Gestión profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){
        $conn = conexion();?>
        <!-- Menu -->
        <ul class="vertical-menu">
            <li>
                <a href="#"><img src="pic/menu.png" alt=""></a>
                <ul>
                    <li><a href="Menu.php">Ver menú</a></li>
                    <li><a href='insertarP.php'>Añadir profesores</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <?php
        if(!$_POST){//Si no se envia nada desde el formulario , imprime la tabla con todos los datos
            $sql = "SELECT * FROM profesores";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado);?>
            <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <h1 class='lc'>Listado profesores</h1>
            <form class="busc" action="Gprof.php" method=POST>
                <input type="text" name="buscador" placeholder="Search by name"/>
                <input class="bus" type="submit" name="enviar" value="Buscar"/>
            </form>

            <!-- Imprimir la tabla -->
            <?php tablaProfesores($conn,$num , $resultado); 
        }
        else{
            $nombre = $_POST['buscador'];
            $sql = "SELECT * FROM profesores WHERE nombre LIKE '%$nombre%'";
            $resultado = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($resultado)?>
            <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <h1 class="lc">Lista de profesores</h1>
            <?php tablaProfesores($conn,$num , $resultado) ; ?>
            <a href='Gprof.php'><img class="atras" src="pic/atras.png" alt=""/></a>
            <?php
        }
    }
    else{
        mensageError();
    }
    ?>      
</body>
</html>