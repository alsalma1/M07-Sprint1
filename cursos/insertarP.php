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
    <title>Insertar profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <p class="salir"><a href="Menu.php">Ver menú</p></a>
        <h1>Añadir nuevos profesores</h1>

        <!-- Formulario profesores -->
        <?php formInsertarProfesores(); ?>

        <h3 class="vc"><a href ='Gprof.php'>Ver profesores</a><h3>
            

            <!------------------  Insertar en la tabla --------------->
        <?php
        
        if($_POST){
            //Variable con los datos de conexión
            $conn = conexion();
            //Recogida de los datos introducidos en el formulario
            $DNI =  $_POST['dni'];
            $Nombre =  $_POST['nombre'];
            $Apel =  $_POST['ape'];
            $nu =  $_POST['nombreU'];
            $pass =  $_POST['pass'];
            $passw = md5($pass);
            $tituA =  $_POST['ta'];
            $foto =  $_POST['file'];
            
            //Controlar la entrada de clave primaria repetida
            try{
                //Consulta para insertar los datos en la tabla 
                $sql = "INSERT INTO profesores (DNI , Nombre , Apellidos , NombreUsu,passwd,titulo_academico , fotografia) VALUES ('$DNI' , '$Nombre' , '$Apel' , '$nu' , '$passw' , '$tituA' , '$foto')";
                //Consulta para buscar si hay valores repetidos
                $sql2 = "SELECT * FROM profesores WHERE DNI='$DNI'";
                $result = mysqli_query($conn,$sql);
                $re = mysqli_query($conn,$sql2);
                $count = mysqli_num_rows($re);
                ?>
                <script>alert("Se ha guardado el profesor")</script>
                <META HTTP-EQUIV="REFRESH" CONTENT=";URL=Gprof.php">
                <?php
            }
            catch(Exception $e){?>
                <script>
                    alert("ERROR! \nYa existe este profesor")
                </script><?php
            }
            
        } 
    }
    else{
        mensageError();
    }
        ?>
</body>
</html>