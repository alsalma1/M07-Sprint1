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
    <title>Añadir o modificar nota</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>

    <?php
    if(isset($_SESSION['dni'])){
        $conn = conexion();?>
        <!-- Menu -->
        <ul class="vertical-menu">
            <li>
                <a href="#"><img src="pic/menu.png" alt=""></a>
                <ul>
                    <li><a href="menuP.php">Ver cursos</a></li>
                    <li><a href="salir.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
        <h4 class="rol"><?php echo $_SESSION['nombre'].": Profesor" ?></h4>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <h1 class='lc'>Añadir o modificar nota</h1>
        <?php
        
        $email = $_GET['email'];
        $codigo = $_GET['codi'];
        $nombreC = $_GET['nombreC'];

        $sql = "SELECT * FROM cursos c INNER JOIN matricula m ON codigo_curso = codigo WHERE codigo = $codigo and email_alumno = '$email'";
        $result = mysqli_query($conn,$sql);
        $linea = mysqli_fetch_assoc($result);
        //Mensage de error cuando el profesor quiere poner nota antes que el curso acabe
        if($linea['fechaFinal'] > date("Y-m-d")){?>
            <script>alert("No puedes poner la nota hasta que se acabe el curso !")</script>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=menuP.php"><?php
        }

        // Si el curso se acabó , puede poner la nota o modificarla
        else{
         ?>
            <form class="mfoto" action="addMark.php?email=<?php echo $email?>&codi=<?php echo $codigo ?>&nombreC=<?php echo $nombreC?>"  method="POST">
                <div>
                    <label for="nota">Nota </label>
                    <div>
                        <input type="Number" max="10" name="nota" value="<?php echo $linea['nota'] ?>" required />
                    </div>
                </div>
                <input class="modi" type="submit" name="enviar" value="Aceptar"/>
                <input type="hidden" name ="email" value="<?php echo $email ?>"/>
                <input type="hidden" name="codi" value = "<?php echo $codigo ?>"/>
                <input type="hidden" name="nombreC" value = "<?php echo $nombreC ?>"/>
            </form>

                <?php
            

                //-----------------  Insertar en la tabla --------------->
            if($_POST){
                $nota = $_POST['nota'];
                $email = $_POST['email'];
                $codigo = $_POST['codi'];
                $nombreC = $_POST['nombreC'];
                ?>

                <?php
                //Recogida de los datos introducidos en el formulario
                //Consulta para insertar los datos en la tabla
                $sql = "UPDATE `matricula` SET nota=$nota WHERE email_alumno='$email' and codigo_curso=$codigo";
                $result = mysqli_query($conn,$sql);

                if($result==FALSE){?>
                    <script>alert("Fallo al insertar la nota , intenta otra vez!")</script>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=menuP.php">
                    <?php
                }
                else{?>
                    <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=alumnos.php?codi=<?php echo $codigo?>&nombreC=<?php echo $nombreC?>">
                    <?php
                }
            } 
        }

    }
    else{
        mensageErrorP();
    }
        ?>
</body>
</html>