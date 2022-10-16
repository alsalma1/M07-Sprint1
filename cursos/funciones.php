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
        <script>alert("No puedes ver esta página si no estás logueado!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=loginAdmin.php">
        <?php
    }
    function mensageErrorA(){?>
        <script>alert("No puedes ver esta página si no estás logueado!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=formA.php">
        <?php
    }
    function mensageErrorP(){?>
        <script>alert("No puedes ver esta página si no estás logueado!")</script>
        <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=formP.php">
        <?php
    }

    /* -------------------------------- Login administrador ----------------- */
    function loginAd(){
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
    function tablaCursos($conn,$num,$resultado){?>
        <table class="Tcur">
            <tr class="tr">
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Horas</th>
                <th>Fecha inicial</th>
                <th>Fecha final</th>
                <th>Profesor</th>
                <th>Modificar</th>
                <th>Estado</th>
            </tr>
        <?php
        // Imprimir los valores de las otras filas desde la tabla 'cursos'
            for ($i = 0 ; $i < $num ; $i++){
                $linea = mysqli_fetch_assoc($resultado);
                ?>
            <tr>
                <td><?php echo $linea['codigo'] ?></td>
                <td><?php echo $linea['nombreC'] ?></td>
                <td><?php echo $linea['descripcion'] ?></td>
                <td><?php echo $linea['horas'] ?></td>
                <td><?php echo $linea['fechaInicio'] ?></td>
                <td><?php echo $linea['fechaFinal'] ?></td><?php
                
                //Si el profesor esta desactivado
                if($linea['estadop']==0){?>
                    <td>No hay profesor</td><?php
                }
                else{?>
                    <td>
                        <?php echo $linea['profesor'] ?>
                    </td><?php
                }

                ?>
                <td>
                    <a href="modificarC.php?codi=<?php echo $linea['codigo'];?>"><img class="edit" src="pic/modificar.png"></a>
                </td>

                <?php
                $sql2 = "SELECT Estado FROM cursos ";
                $res = mysqli_query($conn,$sql2);
                //Si el estado es 1 , esta activado y muestra la foto de activado
                if($linea['Estado']==1){?>
                    <td>
                        <a href="activarCurso.php?act=0&codigo=<?php echo $linea['codigo'] ;?>"><img class="act" src="pic/activado.png"></a>
                    </td><?php
                }
                else{
                    ?>
                    <td>
                        <a href="activarCurso.php?act=1&codigo=<?php echo $linea['codigo'] ;?>"><img class="act" src="pic/desactivado.png"></a>
                    </td><?php
                }  
                ?>
            </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }

    // --------------- Formulario para insertar nuevo curso ---------------
    function formInsertarCursos(){?>
        <form class="formGrid" action="insertarC.php" method="POST" >  
        <div class="grid">
            <div>
                <label for="nombreC">Nombre </label>
                <input type="text" name="nombreC"  required />
            </div>

            <div>
                <label for="fechaI">Fecha inicio </label>
                <input type="date" name="fechaI" required />
            </div>

            <div>
                <label for="descri">Descripción </label>
                <textarea name="descri" maxlength="50" ></textarea>
            </div>
            
            <div>
                <label for="fechaF">Fecha final </label>
                <input type="date" name="fechaF"required />
            </div>

            <div>
                <label for="horas">Horas </label>
                <input type="Number"  max="5000" name="horas" maxlength="2" required />
            </div>

            <div>
                <label for="prof">Profesor </label>
                <select name="prof" id="prof" required>
                    <option value="" selected>Selecciona el profesor</option>
                    
                    <?php
                        $conn = conexion();
                        $sql ="SELECT * FROM profesores WHERE estadop=1";
                        $resultado = mysqli_query($conn,$sql);
                        $num = mysqli_num_rows($resultado);
                        //Visualizar los profesores en lista desplegable
                        for ($i = 0; $i < $num ; $i++){
                            $linea = mysqli_fetch_assoc($resultado);
                            echo "<option value='".$linea['DNI']."'>".$linea['DNI']."-".$linea['nombre']."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="div_enviar">
            <input class="enviar" type="submit" name="enviar" value="Aceptar"/>
        </div>
        </form>
    <?php
    }
    // ---------------- Modificar un curso ---------------
    function modificarCurso($conn , $fila){
        ?>
        <form class="formGrid" action="editC.php" method="POST">  
            <!------------------- Formulario con valores anteriores para modificar ------>
            <div class="grid">
                <div>
                    <label for="nombreC">Nombre </label>
                    <input type="text" name="nombreC" value="<?php echo $fila['nombreC'] ?>" required />
                </div>

                <div>
                    <label for="fechaI">Fecha inicio </label> 
                    <input type="date" name="fechaI" value="<?php echo $fila['fechaInicio'] ?>" required />
                </div>

                <div>
                    <label for="descri">Descripción </label>
                    <textarea name="descri" maxlength="20"><?php echo $fila['descripcion']?></textarea>
                </div>

                <div>
                    <label for="fechaF">Fecha final </label>
                    <input type="date" name="fechaF" value="<?php echo $fila['fechaFinal'] ?>" required />
                </div>

                <div>
                    <label for="horas">Horas </label> 
                    <input type="Number"  max="5000" name="horas" maxlength="2" value="<?php echo $fila['horas'] ?>" required />
                </div>

                <div> 
                    <label for="prof">Profesor </label>
                    <select name="prof" id="prof">
                        <option value="<?php echo $fila['profesor']?>" selected><?php echo $fila['profesor']?></option>
                        <?php
                            $conn = conexion();
                            $sql ="SELECT * FROM profesores WHERE estadop = 1";
                            $resultado = mysqli_query($conn,$sql);
                            $num = mysqli_num_rows($resultado);

                            for ($i = 0; $i < $num ; $i++)
                            {
                                $linea = mysqli_fetch_assoc($resultado);
                                echo "<option>".$linea['DNI']."</option>";;
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="div_enviar">
                <input class="enviar" type="submit" name="Modificar" value="Modificar"/>
            </div>                
        </form> 
        <?php
    }
    /* ---------------- imprimir la tabla de profesores---------- */
    function tablaProfesores($conn,$num , $resultado){
        ?>
        <table class="Tcur">
        <tr class="tr">
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Nombre usuario</th>
            <th>Titúlo academico</th>
            <th>Fotografía</th>
            <th>Editar</th>
            <th>Estado</th>
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
                <img class="picture" src="<?php echo $linea['fotografia'] ?>" alt=""/>
            </td>
  

            <td>
                <a href="modificarP.php?dni=<?php echo $linea['DNI'];?>"><img class="edit" src="pic/datos.png"></a>
                <a href="modificarFoto.php?dni=<?php echo $linea['DNI'];?>"><img class="edit" src="pic/image.png"></a>
            </td><?php
            $sql2 = "SELECT estadop FROM profesores ";
            $res = mysqli_query($conn,$sql2);
            //Si el estado es 1 , esta activado y muestra la foto de activado
            if($linea['estadop']==1){?>
                <td>
                    <a href="activarProfesor.php?act=0&dniP=<?php echo $linea['DNI'] ;?>"><img class="act" src="pic/activado.png"></a>
                </td><?php
            }
            else{?>
                <td>
                    <a href="activarProfesor.php?act=1&dniP=<?php echo $linea['DNI'] ;?>"><img class="act" src="pic/desactivado.png"></a>
                </td><?php
            }
            ?>
            
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    }

    // --------------- Formulario para insertar nuevo prof ---------------
    function formInsertarProfesores(){?>
        <form class="formGrid" action="insertarP.php" method="POST" enctype="multipart/form-data">  
            <div class= "grid">
                <div>
                    <label for="dni">DNI </label>
                    <input type="text" name="dni"  required />
                </div>

                <div>
                    <label for="nombreU">Nombre usuario </label> 
                    <input type="text" name="nombreU" required>
                </div>

                <div>
                    <label for="nombre">Nombre </label>
                    <input type="text" name="nombre" required>
                </div>

                <div>
                    <label for="pass">Contraseña </label>
                    <input type="password" name="pass" required>
                </div>

                <div>
                    <label for="ape">Apellidos </label>
                    <input type="text" name="ape" required>
                </div>

                <div>
                    <label for="archivo">Fotografía </label>
                    <input class="file" type="file" name="archivo" value="Selecciona un archivo" style="color:#4959ff" required>
                </div>

                <div>
                    <label for="ta">Título académico </label>
                    <input type="text" name="ta" required/>
                </div>
            </div>
            <div class="div_enviar">
                <input class="enviar" type="submit" name="enviar" value="Aceptar"/>
            </div>
        </form>
    <?php
    }

    /* --------------------- Formulario para modificar un profesor -------------------------*/
    function modificarProf($conn , $fila){
        ?>
        <form class="formGrid" action="editP.php" method="POST" enctype="multipart/form-data">  
            <div class="grid">
                <div>
                    <label for="dni">DNI </label>
                    <input type="text" name="dni" value="<?php echo $fila['DNI'] ?>" readonly required />
                </div>

                <div>
                    <label for="nombreU">Nombre usuario </label> 
                    <input type="text" name="nombreU" value="<?php echo $fila['NombreUsu']?>" required>
                </div>

                <div>
                    <label for="nombre">Nombre </label>
                    <input type="text" name="nombre" value="<?php echo $fila['nombre']?>" required>
                </div>

                <div>
                    <label for="ape">Apellidos </label>
                    <input type="text" name="ape" value="<?php echo $fila['apellidos']?>" required>
                </div>

                <div>
                    <label for="ta">Título académico </label>
                    <input type="text" name="ta" value="<?php echo $fila['titulo_academico']?>" required/>
                </div>
            </div>
            <div class="div_enviar">
                <input class="enviar" type="submit" name="Modificar" value="Modificar"/>
            </div>
        </form> 
        <?php
    }

        /* ---------------- imprimir Formulario Alumno ---------- */
    function imprimirFormularioAlumno(){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <h1 class="T1">Area alumno</h1>
        <div id="divf">
            <img class="img1" src="pic/img1.png" alt="">
            <form action="formA.php" method="POST">
                <input class="inp1" type="text" name="email" placeholder=" E-mail" required/><br><br>
                <input class="inp2" type="password" name="password" placeholder=" Password" required/><br><br>

                <input type="submit" name="enviar" value="Aceptar"/>
            </form>
            <p class="na"><a href="crearA.php">Crear mi cuenta</a></p>
        </div>

            <?php
    }


    /* -------------------------------- Login alumno ----------------- */
    function loginAl(){
        $conn = conexion();
        $emailA =  $_POST['email'];
        $_SESSION['email'] = $emailA;
        $password =  md5($_POST['password']);
        $sql = "SELECT * FROM alumnos WHERE email = '$emailA' AND passwd = '$password'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        $linea = mysqli_fetch_assoc($result);
        $_SESSION['nombreA'] = $linea['nombre'];
        //Control para validar si el usuario existe , si existe le muestra las opciones para gestionar profesores / alumnos
        if($count == 1) { 
            ?>
            <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=menuAl.php">
            <?php
        }
        
        //Control del login
        else{
            ?>
            <script>alert( "Datos incorrectos , intenta otra vez")</script>
        <?php
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0';URL='formA.php'>";     
        }
    }
    


        // --------------- Formulario para  crear cuenta alumno ---------------
    function formCrearAlumno(){?>
        <form class="formGrid" action="crearA.php" method="POST" enctype="multipart/form-data">  
            <div class="grid">
                <div>
                    <label for="dniAl">DNI </label>
                    <input type="text" name="dniAl"  required />
                </div>

                <div>
                    <label for="nombreAl">Nombre </label>
                    <input type="text" name="nombreAl" required>
                </div>
                <div>
                    <label for="apeAl">Apellidos </label>
                    <input type="text" name="apeAl" required>
                </div>
                <div>
                    <label for="edad">Edad </label>
                    <input type="Number" min="10" max="80" name="edad" required/>
                </div>
                <div>
                    <label for="email">Email </label>
                    <input type="text" name="email" required>
                </div>
                <div>
                    <label for="passAl">Contraseña </label>
                    <input type="password" name="passAl" required>
                </div>
            
                <!---------------------- Insertar la foto -------------->
                <div>
                    <label for="archivo">Fotografía </label>
                    <input  type="file" name="archivo" value="" required>
                    
                </div>
            </div>
            <div class="div_enviar">
                <input class="enviar" type="submit" name="enviar" value="Aceptar"/>
            </div>
        </form>
        <a href='formA.php'><img class="atras" src="pic/atras.png" alt=""/></a>
        
    <?php
    }

    /* ---------------- imprimir Formulario Profesor ---------- */  
    function modificarAlumno($conn,$fila){?>
        <form class="formGrid" action="editA.php" method="POST">  
            <!------------------- Formulario con valores anteriores para modificar ------>
            <div class="grid">
                <div>
                    <label for="dni">DNI </label>
                    <input type="text" name="dni" value="<?php echo $fila['DNI'] ?>" readonly required />
                </div>

                <div>
                    <label for="nombre">Nombre </label>
                    <input type="text" name="nombre" value="<?php echo $fila['nombre']?>" required>
                </div>
                <div>
                    <label for="ape">Apellidos </label>
                    <input type="text" name="ape" value="<?php echo $fila['apellidos']?>" required>
                </div>
                <div>
                    <label for="email">Email </label>
                    <input type="text" name="email" value="<?php echo $fila['email']?>" readonly required>
                </div>
                <div>
                    <label for="edad">Edad </label>
                    <input type="Number" min="10" max="80" name="edad" value="<?php echo $fila['edad']?>" required/>
                </div>
            </div>

            <div class="div_enviar">
                <input class="enviar" type="submit" name="Modificar" value="Modificar"/>
            </div>
        </form> 
        <a href='menuAl.php'><img class="atras" src="pic/atras.png" alt=""/></a>
    <?php
    }
    /* ---------------- imprimir Formulario Profesor ---------- */
    function imprimirFormularioProfesor(){?>
        <a href="principal.php"><img class="logo" src="pic/logoN.png" alt="" /></a>
        <h1 class="T1">Area profesor</h1>
        <div id="divf">
            <img class="img1" src="pic/img1.png" alt="">
            <form action="formP.php" method="POST">
                <input class="inp1" type="text" name="dni" placeholder=" DNI" required/><br><br>
                <input class="inp2" type="password" name="password" placeholder=" Password" required/><br><br>
                <input type="submit" name="enviar" value="Aceptar"/>
            </form>

        </div>

            <?php
    }
    
    /* -------------------------------- Login profesor ----------------- */
    function loginP(){
        $conn = conexion();
        $dni =  $_POST['dni'];
        $_SESSION['dni'] = $dni;

        $password =  md5($_POST['password']);
        $sql = "SELECT * FROM profesores WHERE DNI = '$dni' AND passwd = '$password'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        //Consulta para sacar el nombre del profesor que se ha logeado y guardar este nombre en una variables de sesion para llamarla luego en las otras pagina
        $consulta = "SELECT * FROM profesores WHERE DNI = '$dni'";
        $result = mysqli_query($conn,$consulta);
        $linea = mysqli_fetch_assoc($result);
        $_SESSION['nombre']=$linea['nombre'];
        //Control para validar si el usuario existe
        if($count == 1) {
            //Si el profesor esta desactivado , no le deja entrar
            if($linea['estadop']==0){
                ?>
                <script>alert("Error, no puedes acceder !")</script>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=formP.php"><?php
            }
            else{
                ?>
                <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=menuP.php">
            <?php
            }
        }

        //Control del login
        else{
            ?>
            <script>alert( "Datos incorrectos , intenta otra vez")</script>
        <?php
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0';URL='formP.php'>";     
        }
    }


        /* ---------------- imprimir la tabla de cursos disponibles---------- */
        function tablaCursosDispo($conn,$num,$resultado){?>
            <table class="Tcur">
                <tr class="tr">
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Horas</th>
                    <th>Fecha inicial</th>
                    <th>Fecha final</th>
                    <th>Profesor</th>
                    <th></th>
                </tr>
            <?php
            // Imprimir los valores de las otras filas desde la tabla 'cursos'
                for ($i = 0 ; $i < $num ; $i++)
                {
                    $linea = mysqli_fetch_assoc($resultado);
                    ?>
                <tr>
                    <td><?php echo $linea['codigo'] ?></td>
                    <td><?php echo $linea['nombreC'] ?></td>
                    <td><?php echo $linea['descripcion'] ?></td>
                    <td><?php echo $linea['horas'] ?></td>
                    <td><?php echo $linea['fechaInicio'] ?></td>
                    <td><?php echo $linea['fechaFinal'] ?></td>
                    <td><?php echo $linea['profesor']." - ".$linea['nombre'] ?></td>
                    <td class="matricular"><a href="darAlta.php?codi=<?php echo $linea['codigo'] ?>">Matricularme</a></td>  
                </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }


       /* ---------------- imprimir la tabla de los cursos donde esta matriculado el alumno---------- */
       function tablaMisCursos($conn,$num,$resultado){?>
        <table class="Tcur">
            <tr class="tr">
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Horas</th>
                <th>Fecha inicial</th>
                <th>Fecha final</th>
                <th>Profesor</th>
                <th>Nota</th>
                <th></th>
            </tr>
        <?php
        // Imprimir los valores de las otras filas desde la tabla 'cursos'
            for ($i = 0 ; $i < $num ; $i++)
            {
                $linea = mysqli_fetch_assoc($resultado);
                ?>
            <tr>
                <td><?php echo $linea['codigo'] ?></td>
                <td><?php echo $linea['nombreC'] ?></td>
                <td><?php echo $linea['descripcion'] ?></td>
                <td><?php echo $linea['horas'] ?></td>
                <td><?php echo $linea['fechaInicio'] ?></td>
                <td><?php echo $linea['fechaFinal'] ?></td>
                <td><?php echo $linea['profesor']." - ".$linea['nombre'] ?></td>
                <td>
                    <?php 
                    if($linea['nota']==NULL || $linea['nota']==0){
                        echo "-----";
                    }
                    else{echo $linea['nota'];}
                    
                    ?>
                </td>
                <td class="matricular"><a href="darBaja.php?codi=<?php echo $linea['codigo'] ?>">Desmatricularme</a></td>  
            </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }

   
    /* ---------------- imprimir la tabla de profesores---------- */
    function tablaAlumnos($conn,$num , $resultado){
        ?>
        <table class="Tcur">
            <tr class="tr">
                <th>DNI</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Edad</th>
                <th>Fotografía</th>
                <th>Nota</th>
                <th>Editar/Añadir</th>
            </tr>
            <?php
            
            for ($i = 0 ; $i < $num ; $i++)
            {
                $linea = mysqli_fetch_assoc($resultado);
                ?>
            <tr>
                <!-- Generar la tabla con los valores  -->
                <td><?php echo $linea['DNI'] ?></td>
                <td><?php echo $linea['email'] ?></td>
                <td><?php echo $linea['nombre'] ?></td>
                <td><?php echo $linea['apellidos'] ?></td>
                <td><?php echo $linea['edad'] ?></td>
                <td>
                    <img class="picture" src="<?php echo $linea['fotografia'] ?>" alt=""/>
                </td>
                <td>
                    <?php 
                    if($linea['nota']==NULL){
                        echo "--------";
                    }
                    else{echo $linea['nota'];}
                    
                    ?>
                </td>
                <td>
                    <a href="addMark.php?email=<?php echo $linea['email']?>&codi=<?php echo $linea['codigo']?>&nombreC=<?php echo $linea['nombreC']?>"><img class="edit" src="pic/modificar.png"></a>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }


    // -------------- Funcion para mostrar los cursos que da este profesor
    function mostrarCursos($conn,$result,$num){
        for ($i = 0 ; $i < $num ; $i++){
            $linea = mysqli_fetch_assoc($result);?>
            
            <div class="contenedor">
                    <?php echo "<h1>".$linea['nombreC']."</h1>";?>
                <div class="curso">
                    <div>
                        <h3>Codigo </h3>
                        <?php echo $linea['codigo'];?>
                    </div>
                    
                    <div>
                        <h3>Descripción </h3>
                        <?php echo $linea['descripcion'];?>
                        <br><br>
                    </div>

                    <div>
                        <h3>Fecha inicio </h3>
                        <?php echo $linea['fechaInicio'];?>
                        <br><br>
                    </div>

                    <div>
                        <h3>Fecha final </h3>
                        <?php echo $linea['fechaFinal']?>
                        <br><br>
                    </div>
                   
                    <div>
                        <h3>Horas </h3>
                        <?php echo $linea['horas'];?>
                        <br><br>
                    </div>

                </div>
                <p class="alumn"><a href="alumnos.php?codi=<?php echo $linea['codigo'] ?>&nombreC=<?php echo $linea['nombreC']?>">Ver alumnos</p></a>
            </div>
            <?php
        }
    }


    function is_valid_dni($DNI){
        $ExpReg = "/\d{8}[TRWAGMYFPDXBNJZSQVHLCKE]/";
        if(preg_match($ExpReg, $DNI)){
            return true;
        }
        return false;
    }
