
<?php
    session_start();
    include("funciones.php");

    $conn = conexion();
    $alumEmail = $_SESSION['email'];
    $codiCurso = $_GET['codi'];
    $sql = "SELECT * FROM matricula INNER JOIN cursos on codigo_curso = codigo WHERE email_alumno='$alumEmail' and codigo_curso=$codiCurso";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $linea = mysqli_fetch_assoc($result);

    if($count>=1){
        //Mientras el alumno no tiene nota (el curso aun no se ha acabado) ,  puede desmatricularse
        if($linea['fechaFinal'] < date("Y-m-d")){?>
            <script>alert("Ya se ha acabado , no puedes desmatricularte ahora!")</script>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=misCursos.php">
            <?php
        }
        else{
            $sql = "DELETE FROM matricula WHERE email_alumno = '$alumEmail' and codigo_curso = '$codiCurso' ";
            $result = mysqli_query($conn,$sql);
            ?>
            <script>alert("Te has desmatriculado del curso con éxito!")</script>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=misCursos.php">
            <?php
        }
    }
?>

