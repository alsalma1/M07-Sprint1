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
    <title>Borrar profesor</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
        if(isset($_SESSION['admin'])){?>
            <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <?php
            $conn = conexion();
            $id = $_GET['id'];

            try{
                $sql = "DELETE FROM profesores WHERE DNI='$id'";
                $result = mysqli_query($conn,$sql);
                ?>
                <script>
                    alert("Profesor borrado");
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php">
            <?php
            }

            catch(Exception $e){?>
                <script>
                    alert("ERROR! \nNo se puede borrar este profesor ");
                </script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Gprof.php">
                <?php
            }
        }
        else{
            mensageError();
        }
            ?>
    
</body>
</html>