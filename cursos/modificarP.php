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
    <title>Modificar profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        //Variable con los datos de conexión
    if(isset($_SESSION['admin'])){
        $conn = conexion();?>
        <!-- Menu -->
        <ul class="vertical-menu">
            <li>
                <a href="#"><img src="pic/menu.png" alt=""></a>
                <ul>
                    <li><a href="Menu.php">Ver menú</a></li>
                    <li><a href="Gprof.php">Ver profesores</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <?php
        //Recogida de los datos introducidos en el formulario
        $dni = $_GET['dni'];
        $_SESSION['dni'] = $dni;
        $sql = "SELECT * FROM profesores where DNI='$dni'";
        $resultado = mysqli_query($conn,$sql);
        $fila = mysqli_fetch_array($resultado);
        ?>
        <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <?php
        if (!$_POST){
            ?>
            <h1 class='lc'>Modificar profesores</h1>
            <?php modificarProf($conn , $fila); ?>

        <?php
        }
        else{?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=editP.php?>">
            <?php
        }
    }
    else{
        mensageError();
    }
    ?>     
</body>
</html>