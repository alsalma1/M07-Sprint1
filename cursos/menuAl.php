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
    <title>Menu alumno</title>
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
                    <li><a href="modificarAl.php">Modificar perfil</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <?php
        $nombreA = $_SESSION['nombreA'];
        ?>
        <h4 class="rol"><?php echo $nombreA.": Alumno" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <div class="G">
            <p class="Gp"><a  href="CursosD.php">Cursos disponibles</a></p>
            <p  class="Gc"><a href="misCursos.php">Mis cursos</a></p>
        </div>
        
        <?php
    }
    else{
        mensageErrorA();
    }
    ?>
    
</body>
</html>