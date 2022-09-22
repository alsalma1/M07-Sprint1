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
    <title>Insertar cursos</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<?php
    if(isset($_SESSION['admin'])){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <p class="salir"><a href="Menu.php">Ver menú</p></a>
        <h1>Añadir nuevos cursos</h1>
        <!-- Imprimir el formulario -->
        <?php formInsertarCursos(); ?>
        <h3 class="vc"><a href ='Gcursos.php'>Ver cursos</a><h3>
        

        <!------------------  Insertar los datos enviados en la tabla --------------->
        <?php
        $conn = conexion();
        if($_POST){
            //Recogida de los datos introducidos en el formulario
            $NombreCurso =  $_POST['nombre'];
            $descri =  $_POST['descri'];
            $horas =  $_POST['horas'];
            $fechaI =  $_POST['fechaI'];
            $fechaF =  $_POST['fechaF'];
            $profesor =  $_POST['prof'];

            if($fechaI<$fechaF){
                $sql = "INSERT INTO cursos (nombre , descripcion , horas , fechaInicio , fechaFinal , profesor) VALUES ('$NombreCurso' , '$descri' , '$horas' , '$fechaI' , '$fechaF' , '$profesor')";
                $result = mysqli_query($conn,$sql);
                
                ?>
                <script>alert("Se ha guardado el curso")</script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php"><?php
            }
            else{?>
                <script>
                    alert("La fecha de inicio de curso tiene que ser menor que la fecha del final")
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=insertarC.php"><?php
            }
           
        } 
    }
    else{
        mensageError();
    }
    ?>
</body>
</html>