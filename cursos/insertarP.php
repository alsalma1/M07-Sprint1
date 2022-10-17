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
    <title>Insertar profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){?>
        <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>

        <!-- Menu -->
        <ul class="vertical-menu">
            <li>
                <a href="#"><img src="pic/menu.png" alt=""></a>
                <ul>
                    <li><a href="Menu.php">Ver menú&nbsp</a></li>
                    <li><a href="Gprof.php">Ver profesores</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>

        <!-- <p class="salir"><a href="salir.php">Cerrar sesión</p> -->
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <!-- <p class="salir"><a href="Menu.php">Ver menú</p></a> -->
        <h1 class='lc'>Añadir nuevos profesores</h1>
        <!-- Formulario profesores -->
            <?php formInsertarProfesores(); ?>
            <!------------------  Insertar en la tabla --------------->
        <?php
           
        if($_POST){
            //Variable con los datos de conexión
            $conn = conexion();
            //Recogida de los datos introducidos en el formulario
            $DNI =  $_POST['dni'];
            //Validar formato DNI
            $resp = is_valid_dni($DNI);
            if($resp == false){//Si el formato es invalido , muestra al usuario un error
                ?>
                <script>
                    alert("Formato del Dni invalido!")
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=insertarP.php">
                <?php
            }
            else{
                $Nombre =  $_POST['nombre'];
                $Apel =  $_POST['ape'];
                $nu =  $_POST['nombreU'];
                $pass =  $_POST['pass'];
                $passw = md5($pass);
                $tituA =  $_POST['ta'];
    
                if (is_uploaded_file ($_FILES['archivo']['tmp_name'])){
                    $nombreDirectorio = "img/";
                    $archivo=$_FILES['archivo']['name'];
    
                    move_uploaded_file ($_FILES['archivo']['tmp_name'],$nombreDirectorio .$archivo );
                }
                else{print ("No se ha podido subir el fichero\n");}
    
                $ruta = $nombreDirectorio.$archivo;
                //Consulta para buscar si hay un profesor con el mismo dni insertado
                $sql2 = "SELECT * FROM profesores WHERE DNI='$DNI'";
                $re = mysqli_query($conn,$sql2);
                $count = mysqli_num_rows($re);
    
                //Consulta para insertar los datos en la tabla 
                $sql = "INSERT INTO profesores (DNI , Nombre , Apellidos , NombreUsu,passwd,titulo_academico , fotografia) VALUES ('$DNI' , '$Nombre' , '$Apel' , '$nu' , '$passw' , '$tituA' , '$ruta')";
                $result = mysqli_query($conn,$sql);
    
                if($count>=1){?>
                    <script>alert("ERROR! \nExiste un profesor con el mismo DNI!")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=insertarP.php">
                    <?php
                }
                else if($count==0){?>
                    <script>alert("Se ha guardado el profesor correctamente!")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php">
                    <?php
                }
            }
            
        } 
    }
    else{
        mensageError();
    }
        ?>
</body>
</html>