<?php
session_start();

include 'assets/php/functions.php';
menu_principal();

if (isset($_GET['logout'])) {
    session_destroy();
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
}
?>
   <section id="inicio-sesion">
       <div id="login">
           <div class="container">
               <div class="row">
                   <div class="form-group">
                       <form action="#" method="POST" id="login">
                            <input type="mail" class="form-control" name="email" placeholder="Email">
                            <input type="password" class="form-control" name="contrasena" placeholder="Contraseña">
                            <br>
                            <button class="btn btn-primary" type="submit" name="enviar">Iniciar sesión</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </section>

        <?php
        $conexion=conectarBD();
        if (isset($_POST['enviar'])) {
            $email=$_POST['email'];
            $contrasena=$_POST['contrasena'];
            // profesor
            $consulta_profesor=$conexion->prepare("SELECT nif_profesor, nombre, contrasena FROM profesor WHERE email=?");

            $consulta_profesor->bindParam(1, $email);
            $consulta_profesor->execute();

            $filas_devueltas_profesor=$consulta_profesor->rowCount();
            // alumno
            $consulta_alumno=$conexion->prepare("SELECT nif_alumno, nombre, contrasena FROM alumno WHERE email=?");

            $consulta_alumno->bindParam(1, $email);
            $consulta_alumno->execute();

            $filas_devueltas_alumno=$consulta_alumno->rowCount();

            // administrador
            $consulta_administrador=$conexion->prepare("SELECT id, nombre, contrasena FROM administrador WHERE email=?");
            
            $consulta_administrador->bindParam(1, $email);
            $consulta_administrador->execute();

            $filas_devueltas_administrador=$consulta_administrador->rowCount();

            if ($filas_devueltas_profesor>0) {
                $datos_profesor=$consulta_profesor->fetch();

                if (password_verify($contrasena, $datos_profesor['contrasena'])) {
                    $_SESSION['nombre']=$datos_profesor['nombre'];
                    $_SESSION['nif_profesor']=$datos_profesor['nif_profesor'];

                    echo "<meta http-equiv='refresh' content='0; url=ruta-del-profesor.php'>";
                }else{
                    echo "                    
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Los datos no coinciden</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                    </div>
                    
                    ";
                }
            }else if($filas_devueltas_alumno>0){
                $datos_alumno=$consulta_alumno->fetch();

                if (password_verify($contrasena, $datos_alumno['contrasena'])) {
                    $_SESSION['nombre']=$datos_alumno['nombre'];
                    $_SESSION['nif_alumno']=$datos_alumno['nif_alumno'];

                    echo "<meta http-equiv='refresh' content='0; url=ruta-del-alumno.php'>";
                }else{
                    echo "                    
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Los datos no coinciden</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                    </div>
                    ";
                }
            }else if($filas_devueltas_administrador>0){
                $datos_administrador=$consulta_administrador->fetch();

                if (password_verify($contrasena, $datos_administrador['contrasena'])) {
                    $_SESSION['nombre']=$datos_administrador['nombre'];
                    $_SESSION['id']=$datos_administrador['id'];

                    echo "<meta http-equiv='refresh' content='0; url=administracion/curso/cursos.php'>";
                }else{
                    echo "                    
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Los datos no coinciden</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                    </div>
                    
                    
                    ";
                }
            }else{
                echo "                
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>No existe ningún email</strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                </div>
                
                ";
            }
        }
    
        $conexion = null;

        ?>

            <?php
            import_js_bootstrap();
            ?>
<?php
$conexion = null;
footer();
?>