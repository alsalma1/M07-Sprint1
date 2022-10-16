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
    <title>Gestión cursos</title>
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
                        <li><a href="Menu.php">Ver menú&nbsp</a></li>
                        <li><a href='insertarC.php'>Añadir cursos</a></li>
                        <li><a href="salir.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
            <?php
            if(!$_POST){ //Si no se envia el formulario , es porque el usuario todavia no ha buscado nada , entoces se le muestra la tabla con todos los datos
                $sql = "SELECT * FROM cursos as c LEFT JOIN profesores as p on c.profesor = p.DNI";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);
                ?>
                <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <h1 class='lc'>Listado de cursos</h1>
                <form class="busc" action="Gcursos.php" method=POST>
                    <input type="text" name="buscador" placeholder="Search by name"/>
                    <input class="bus" type="submit" name="enviar" value="Buscar"/>
                </form>
                <!-- Imprimir la tabla -->
                <?php 
                tablaCursos($conn,$num,$resultado);
                 ?>

            <?php
            }
            else{
                //Cuando busca el usuario , se genera una tabla con solo los datos buscados
                $nombre = $_POST['buscador'];
                $sql = "SELECT * FROM cursos as c INNER JOIN profesores as p on c.profesor = p.DNI and  nombreC LIKE '%$nombre%'";
                $resultado = mysqli_query($conn,$sql);
                $num = mysqli_num_rows($resultado);?>
                <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
                <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
                <h1 class='lc'>Listado cursos</h1>
                <?php 
                tablaCursos($conn,$num,$resultado);
                ?>
                <a href='Gcursos.php'><img class="atras" src="pic/atras.png" alt=""/></a>

                <?php
            }
        }
        else{
            mensageError();
        }
        ?>

</body>
</html>