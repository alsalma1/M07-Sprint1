<?php
    session_start();
    include("funciones.php");

    $conn = conexion();
    $alumEmail = $_SESSION['email'];
    $codiCurso = $_GET['codi'];
    $sql = "SELECT * FROM matricula WHERE email_alumno='$alumEmail' and codigo_curso=$codiCurso";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);

    if($count==0){
        $sql1 = "INSERT INTO matricula (email_alumno, codigo_curso) VALUES ('$alumEmail','$codiCurso')";
        $result = mysqli_query($conn,$sql1);
        ?>
        <script>alert("Te has dado la alta correctamente!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=cursosD.php">
        <?php
    }
    else{?>
        <script>alert("Ya estás matriculado en este curso!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=cursosD.php">
        <?php
    }
    
?>

