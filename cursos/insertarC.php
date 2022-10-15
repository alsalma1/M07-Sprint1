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
    <title>Insertar cursos</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<?php
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
        <h4 class="rol"><?php echo $_SESSION['admin'].": Administrador" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <h1 class='lc'>Añadir nuevos cursos</h1>
            <!-- Imprimir el formulario -->
        <?php formInsertarCursos(); ?>
        

        <!------------------  Insertar los datos enviados en la tabla --------------->
        <?php
        $conn = conexion();
        if($_POST){
            //Recogida de los datos introducidos en el formulario
            $NombreCurso =  $_POST['nombreC'];
            $descri =  $_POST['descri'];
            $horas =  $_POST['horas'];
            $fechaI =  $_POST['fechaI'];
            $fechaF =  $_POST['fechaF'];
            $profesor =  $_POST['prof'];

            if($fechaI<$fechaF){
                $sql = "INSERT INTO cursos (nombreC , descripcion , horas , fechaInicio , fechaFinal , profesor) VALUES ('$NombreCurso' , '$descri' , '$horas' , '$fechaI' , '$fechaF' , '$profesor')";
                $result = mysqli_query($conn,$sql);
                if($result==False){?>
                    <script>alert("Fallo al insertar el curso!!")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=insertarC.php">
                    <?php
                }
                else{?>
                <script>alert("Se ha guardado el curso correctamente!")</script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gcursos.php"><
                <?php 
                }
            }
            else{?>
                <script>
                    alert("La fecha de inicio de curso tiene que ser menor que la fecha del final")
                </script>
                <?php
            }
        }
           
    }
    else{
        mensageError();
    }
    ?>
</body>
</html>