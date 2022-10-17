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
    <title>Crear cuenta alumno</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
    <h1 class='lc'>Crear cuenta alumno</h1>

    <!-- Formulario profesores -->
    <?php formCrearAlumno(); ?>
    <!------------------  Insertar en la tabla --------------->
    <?php
    
    if($_POST){
        //Variable con los datos de conexión
        $conn = conexion();
        //Recogida de los datos introducidos en el formulario
        $DNI =  $_POST['dniAl'];
        $Nombre =  $_POST['nombreAl'];
        $Apel =  $_POST['apeAl'];
        $edad =  $_POST['edad'];
        $email =  $_POST['email'];
        $pass =  md5($_POST['passAl']);

        //Validar formato DNI
        $resp = is_valid_dni($DNI);
        if($resp == false){
            ?>
            <script>
                alert("Formato del Dni invalido!")
            </script>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=crearA.php">

            <?php
        }
        else{
            $Nombre =  $_POST['nombreAl'];
            $Apel =  $_POST['apeAl'];
            $edad =  $_POST['edad'];
            $email =  $_POST['email'];
            $pass =  md5($_POST['passAl']);
            
            if (is_uploaded_file ($_FILES['archivo']['tmp_name'])){
                $nombreDirectorio = "img/";
                $archivo=$_FILES['archivo']['name'];
                move_uploaded_file ($_FILES['archivo']['tmp_name'],$nombreDirectorio .$archivo );
            }
            else{print ("No se ha podido subir el fichero\n");}

            $ruta = $nombreDirectorio.$archivo;
            $sql2 = "SELECT * FROM alumnos WHERE DNI='$DNI' or email = '$email'";
            $re = mysqli_query($conn,$sql2);
            $count = mysqli_num_rows($re);

            //Controlar la entrada de clave primaria repetida

            if($count>=1){?>
                <script>
                    alert("ERROR! \nExiste un alumno con los mismos datos");
                </script><?php
            }

            //Si no hay un alumno con el mismo dni o email , lo inserta en la tabla
            else{
                $sql= "INSERT INTO `alumnos`(`DNI`, `nombre`, `apellidos`, `edad`, `email`, `passwd` ,`fotografia`) VALUES ('$DNI','$Nombre','$Apel','$edad','$email','$pass','$ruta')";
                $result = mysqli_query($conn,$sql);?>
                <script>
                    alert("Enhorabuena ! Tu cuenta se ha creado correctamente");
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=formA.php">
                
    <?php
            }
        }
        
    }
    ?>
</body>
</html>