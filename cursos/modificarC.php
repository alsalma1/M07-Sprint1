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
    <title>Modificar curso</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        //Variable con los datos de conexión
    $conn = conexion();
    if(isset($_SESSION['admin'])){
        //Recogida de los datos introducidos en el formulario
        $codi = $_GET['codi'];
        $_SESSION['codi'] = $codi;
        $sql = "SELECT * FROM cursos where codigo='$codi'";
        $resultado = mysqli_query($conn,$sql);
        $fila = mysqli_fetch_array($resultado);
            
        if (!$_POST){
            ?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <h1>Modificar curso</h1>
            <form action="editC.php" method="POST">  
                <!------------------- Formulario con valores anteriores para modificar ------>
            <table class="tbl">
                <tr>
                    <td>Nombre </td>
                    <td><input type="text" name="nombre" value="<?php echo $fila['nombre'] ?>" required /></td>
                </tr>

                <tr>
                    <td>Descripción </td>
                    <td>
                        <textarea name="descri" maxlength="20"><?php echo $fila['descripcion']?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Horas </td>
                    <td><input type="Number"  max="5000" name="horas" maxlength="2" value="<?php echo $fila['horas'] ?>" required /></td>
                </tr>

                <tr>
                    <td>Fecha inicio </td>
                    <td><input type="date" name="fechaI" value="<?php echo $fila['fechaInicio'] ?>" required /></td>
                </tr>

                <tr>
                    <td>Fecha final </td>
                    <td><input type="date" name="fechaF" value="<?php echo $fila['fechaFinal'] ?>" required /></td>
                </tr>

                <tr>
                    <td>Profesor </td>
                    <td>
                        <select name="prof" id="prof">
                            <option value="" selected><?php echo $fila['profesor']?></option>
                            <?php
                                $conn = conexion();
                                $sql ="SELECT * FROM profesores";
                                $resultado = mysqli_query($conn,$sql);
                                $num = mysqli_num_rows($resultado);

                                for ($i = 0; $i < $num ; $i++)
                                {
                                    $linea = mysqli_fetch_assoc($resultado);
                                    echo '<option>'.$linea['nombre'].'</option> ';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <input class="modificar" type="submit" name="Modificar" value="Modificar"/>
            </form> 

            <h3 class="vc"><a href ='Gcursos.php'>Ver cursos</a><h3>
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