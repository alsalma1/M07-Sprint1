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
    <title>Menu</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){
        ?>
        <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <p class="salir"><a href="salir.php">Cerrar sesión</a></p>
        <div class="G">
            <p class="Gp"><a href="Gprof.php">Gestionar profesores</a></p>
            <p  class="Gc"><a href="Gcursos.php">Gestionar cursos</a></p>
        </div>
        
        <?php
    }
    else{
        mensageError();
    }
    ?>
    
</body>
</html>