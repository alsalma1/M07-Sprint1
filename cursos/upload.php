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
    <title></title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body>
    <?php
    if(isset($_SESSION['admin'])){
        if(isset($_SESSION['admin'])){
            $uploadedfileload="true";
            echo $_FILES['file']['name'];
            $file_name=$_FILES['file']['name'];
            $add="pic/$file_name";
            if($uploadedfileload=="true"){
                if(move_uploaded_file ($_FILES['file']['tmp_name'], $add)){
                echo " Ha sido subido satisfactoriamente";
                echo "<img src='$add'>";
                }
                else{
                    echo "Error al subir el archivo";
                }
            }
        else{echo $msg;}
        }
    }
    else{
        mensageError();
    }
    ?>
    
</body>
</html>
<?php

?>
