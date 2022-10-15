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
    <title>Modificar curso</title>
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
                    <li><a href="Menu.php">Ver menú&nbsp</a></li>
                    <li><a href="Gcursos.php">Ver cursos&nbsp</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <?php
        //Recogida de los datos introducidos en el formulario
        $codi = $_GET['codi'];
        $_SESSION['codi'] = $codi;
        $sql = "SELECT * FROM cursos where codigo='$codi'";
        $resultado = mysqli_query($conn,$sql);
        $fila = mysqli_fetch_array($resultado);
            
        if (!$_POST){
            ?>
            <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <h1 class='lc'>Modificar curso</h1>
            <?php modificarCurso($conn , $fila);?>
        <?php
        }
        else{?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=editC.php?>">
            <?php
        }
    }
    else{
        mensageError();
    }
    ?>     
</body>
</html>