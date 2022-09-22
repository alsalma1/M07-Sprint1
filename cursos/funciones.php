<?php
    function conexion(){
        $conn = new mysqli('localhost', 'root','', 'infobdn');
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
    /* -------------Mensage de error si no esta registrado ---------- */
    function mensageError(){?>
        <script>alert("Por favor registrate primero")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=loginAdmin.php">
        <?php
    }

    /* -------------------------------- Login ----------------- */
    function login(){
        $conn = conexion();
        $NombreUsuario =  $_POST['admin'];
        $_SESSION['admin'] = $NombreUsuario;
        $password =  md5($_POST['password']);
        $sql = "SELECT * FROM administradores WHERE nombre_Usuario = '$NombreUsuario' AND passwd = '$password'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
    
        //Control para validar si el usuario existe , si existe le muestra las opciones para gestionar profesores / alumnos
        if($count == 1) { 
            ?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Menu.php">
            <?php
        }
        
        //Control del login
        else{
            ?>
            <script>alert( "Datos incorrectos , intenta otra vez")</script>
        <?php
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0';URL='loginAdmin.php'>";     
        }
    }

    /* ---------------- imprimir Formulario Admin ---------- */
    function imprimirFormularioAdmin(){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
            <h1 class="T1">Area administrador</h1>
            <div id="divf">
                <img class="img1" src="pic/img1.png" alt="">
                <form action="loginAdmin.php" method="POST">
                    <input class="inp1" type="text" name="admin" placeholder=" Nombre de usuario" required/><br><br>
                    <input class="inp2" type="password" name="password" placeholder=" Password" required/><br><br>

                    <input type="submit" name="enviar" value="Aceptar"/>
                </form>
            </div>
            <?php
    }

    /* ---------------- imprimir la tabla de cursos---------- */
    function tablaCursos($num,$resultado){?>
        <table class="Tcur">
            <tr class="tr">
                <td>Codigo</td>
                <td>Nombre</td>
                <td>Descripción</td>
                <td>Horas</td>
                <td>Fecha inicial</td>
                <td>Fecha final</td>
                <td>Profesor</td>
                <td>Opciones</td>
            </tr>
        <?php
        // Imprimir los valores de las otras filas desde la tabla 'cursos'
            for ($i = 0 ; $i < $num ; $i++)
            {
                $linea = mysqli_fetch_assoc($resultado);
                ?>
            <tr>
                <td><?php echo $linea['codigo'] ?></td>
                <td><?php echo $linea['nombre'] ?></td>
                <td><?php echo $linea['descripcion'] ?></td>
                <td><?php echo $linea['horas'] ?></td>
                <td><?php echo $linea['fechaInicio'] ?></td>
                <td><?php echo $linea['fechaFinal'] ?></td>
                <td><?php echo $linea['profesor'] ?></td>
                <td>
                    <a href="borrarC.php?ide=<?php echo $linea['codigo'];?>"><img class="elim" src="pic/eliminar.png"></a>
                    <a href="modificarC.php?codi=<?php echo $linea['codigo'];?>"><img class="edit" src="pic/modificar.png"></a>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }

    // --------------- Formulario para insertar nuevo curso ---------------
    function formInsertarCursos(){?>
        <form action="insertarC.php" method="POST">  
                <table class="tbl">
                    <tr>
                        <td>Nombre </td>
                        <td><input type="text" name="nombre"  required /></td>
                    </tr>

                    <tr>
                        <td>Descripción </td>
                        <td><textarea name="descri" maxlength="50" ></textarea></td>
                    </tr>
                    <tr>
                        <td>Horas </td>
                        <td><input type="Number"  max="5000" name="horas" maxlength="2" required /></td>
                    </tr>

                    <tr>
                        <td>Fecha inicio </td>
                        <td><input type="date" name="fechaI"required /></td>
                    </tr>

                    <tr>
                        <td>Fecha final </td>
                        <td><input type="date" name="fechaF"required /></td>
                    </tr>

                    <tr>
                        <td>Profesor </td>
                        <td>
                            <select name="prof" id="prof" required>
                                <option value="" selected>Selecciona el profesor</option>
                                
                                <?php
                                    $conn = conexion();
                                    $sql ="SELECT * FROM profesores";
                                    $resultado = mysqli_query($conn,$sql);
                                    $num = mysqli_num_rows($resultado);
                                    //Visualizar los profesores en lista desplegable
                                    for ($i = 0; $i < $num ; $i++)
                                    {
                                        $linea = mysqli_fetch_assoc($resultado);
                                        echo "<option value='".$linea['DNI']."'>".$linea['DNI']."-".$linea['nombre']."</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
        <input class="enviar" type="submit" name="enviar" value="Aceptar"/>
        </form>
    <?php
    }
    



    /* ---------------- imprimir la tabla de profesores---------- */
    function tablaProfesores($num , $resultado){?>
        <table class="Tcur">
        <tr class="tr">
            <td>DNI</td>
            <td>Nombre</td>
            <td>Apellidos</td>
            <td>Nombre usuario</td>
            <td>Titúlo academico</td>
            <td>Fotografía</td>
            <td>Opciones</td>
        </tr>
        <?php
        for ($i = 0 ; $i < $num ; $i++)
        {
            $linea = mysqli_fetch_assoc($resultado);
            ?>
        <tr>
            <!-- Generar la tabla con los valores  -->
            <td><?php echo $linea['DNI'] ?></td>
            <td><?php echo $linea['nombre'] ?></td>
            <td><?php echo $linea['apellidos'] ?></td>
            <td><?php echo $linea['NombreUsu'] ?></td>
            <td><?php echo $linea['titulo_academico'] ?></td>
            <td>
                <img scr="<?php echo $linea['fotografia'] ?>" alt=""/>
            </td>

            <td>
                <a href="borrarP.php?id=<?php echo $linea['DNI'];?>"><img class="elim" src="pic/eliminar.png"></a>
                <a href="modificarP.php?dni=<?php echo $linea['DNI'];?>"><img class="edit" src="pic/modificar.png"></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    }


    // --------------- Formulario para insertar nuevo curso ---------------
    function formInsertarProfesores(){?>
        <form action="insertarP.php" method="POST">  
        <table class="tbl">
            <tr>
                <td>DNI </td>
                <td><input type="text" name="dni"  required /></td>
            </tr>

            <tr>
                <td>Nombre </td>
                <td><input type="text" name="nombre" required></td>
            </tr>
            <tr>
                <td>Apellidos </td>
                <td><input type="text" name="ape" required></td>
            </tr>
            <tr>
                <td>Nombre usuario </td>
                <td><input type="text" name="nombreU" required></td>
            </tr>
            <tr>
                <td>Contraseña </td>
                <td><input type="password" name="pass" required></td>
            </tr>
       
            <tr>
                <td>Título académico </td>
                <td><input type="text" name="ta" required/></td>
            </tr>
            <!---------------------- Insertar la foto -------------->
            <tr>
                <td>Fotografía </td>
                <td>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" required>
                    <input type="submit" value="Subir archivo" required>
                </form>
                </td>
            </tr>
        </table>
        <input class="enviar" type="submit" name="enviar" value="Aceptar"/>
        </form>
    <?php
    }
    




    
    