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
    <title>Formulario administardor</title>
    <link rel="stylesheet" href="proyecto.css">
</head>
<body id='la'>
    <?php
        if($_POST){
            $conn = conexion();
            loginAd();            
         
        }
        else{ 
           imprimirFormularioAdmin();
        }
        ?>
</body>
</html>