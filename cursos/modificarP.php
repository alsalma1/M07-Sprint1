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
    <title>Modificar profesores</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        //Variable con los datos de conexión
    $conn = conexion();
    if(isset($_SESSION['admin'])){
        //Recogida de los datos introducidos en el formulario
        $dni = $_GET['dni'];
        $_SESSION['dni'] = $dni;
        $sql = "SELECT * FROM profesores where DNI='$dni'";
        $resultado = mysqli_query($conn,$sql);
        $fila = mysqli_fetch_array($resultado);
        ?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <?php
        if (!$_POST){
            ?>
            <h1>Modificar profesores</h1>
            <form action="editP.php" method="POST">  
                <!------------------- Formulario con valores anteriores para modificar ------>
                <table class="tbl">
            <tr>
                <td>DNI </td>
                <td><input type="text" name="dni" value="<?php echo $fila['DNI'] ?>" required /></td>
            </tr>

            <tr>
                <td>Nombre </td>
                <td><input type="text" name="nombre" value="<?php echo $fila['nombre']?>" required></td>
            </tr>
            <tr>
                <td>Apellidos </td>
                <td><input type="text" name="ape" value="<?php echo $fila['apellidos']?>" required></td>
            </tr>
            <tr>
                <td>Nombre usuario </td>
                <td><input type="text" name="nombreU" value="<?php echo $fila['NombreUsu']?>" required></td>
            </tr>
                   
            <tr>
                <td>Título académico </td>
                <td><input type="text" name="ta" value="<?php echo $fila['titulo_academico']?>" required/></td>
            </tr>
            <!---------------------- Insertar la foto -------------->
            <tr>
                <td>Fotografía </td>
                <td>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" >
                    <input type="submit" value="Subir archivo" >
                </form>
                </td>
            </tr>
        </table>
            <input class="modificar" type="submit" name="Modificar" value="Modificar"/>
            </form> 

            <h3 class="vc"><a href ='Gprof.php'>Ver profesores</a><h3>
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