<?php
session_start();
include '../../assets/php/functions.php';
if (!isset($_SESSION['id'])) {
    
    echo "<meta http-equiv='refresh' content='0; url=../../login.php'>";
    
}else{
?>
<body>
    <?php
        menu_administrador();
        $conexion=conectarBD();
        if (isset($_GET['id'])) {
            $consulta_alumno=$conexion->prepare("SELECT * FROM alumno WHERE nif_alumno=?");
            $id_alumno=$_GET['id'];
            $consulta_alumno->bindParam(1, $id_alumno);
            $consulta_alumno->setFetchMode(PDO::FETCH_ASSOC);
            $consulta_alumno->execute();
            $datos=$consulta_alumno->fetch();
    ?>
    
<div class="container">
    <div class="row">
    <h1 class="col-12">Editar alumno</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" value="<?php echo $datos['nombre'];?>" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" required>
          </div>
          <div class="form-group">
            <label for="apellido1">Primer Apellido</label>
            <input type="text" value="<?php echo $datos['apellido1'];?>" class="form-control" id="apellido1" name="apellido1" aria-describedby="apellido1" required>
          </div>
          <div class="form-group">
            <label for="apellido2">Segundo Apellido</label>
            <input type="text" value="<?php echo $datos['apellido2'];?>" class="form-control" id="apellido2" name="apellido2" aria-describedby="apellido2" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" value="<?php echo $datos['email'];?>" class="form-control" id="email" name="email" aria-describedby="email" required>
          </div>
          <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="text" value="<?php echo $datos['fecha_nacimiento'];?>" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" aria-describedby="fecha_nacimiento" required>
          </div>
          <label for="imagen">Selecciona una imagen</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagen" id="imagen" lang="es">
            <label class="custom-file-label" for="imagen">Seleccionar Archivo</label>
          </div>
          <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" value="<?php echo $datos['contrasena'];?>"class="form-control" id="contrasena" name="contrasena" required>
          </div>
          <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
        </form>
    </div>
</div>
      <?php 
        }else {
            echo "<meta http-equiv='refresh' content='0; url=alumno.php'>";
        }
        if (isset($_POST['actualizar'])) {


            $consulta_insercion=$conexion->prepare("UPDATE alumno SET nombre=?,apellido1=?,apellido2=?,email=?,fecha_nacimiento=?,img=?,contrasena=? WHERE nif_alumno=?");

            $nombre_alumno=$_POST['nombre'];
            $apellido1=$_POST['apellido1'];
            $apellido2=$_POST['apellido2'];
            $email=$_POST['email'];
            $fecha_nacimiento=$_POST['fecha_nacimiento'];
            $imagen=$datos['img'];
            $contrasena=$_POST['contrasena'];
            $id_alumno=$_GET['id'];

          if ($contrasena==$datos['contrasena']) {
            $contrasena=$datos['contrasena'];
          }else{
            $contrasena=password_hash($contrasena, PASSWORD_DEFAULT);
          }

            if ($_FILES['imagen']['tmp_name']!="") {
                unlink("../../assets/images/alumnos/$datos[img]");

                if (!file_exists("../../assets/images/alumnos")) {
                mkdir("../../assets/images/alumnos");
                }

                $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
                $extension_imagen = extension_imagen($_FILES['imagen']['type']);
                $nombre_imagen = "imagen_alumno_$id_alumno" . $extension_imagen;
                move_uploaded_file($nombre_temporal_imagen, "../../assets/images/alumnos/$nombre_imagen");

                $imagen=$nombre_imagen;

            }
                      
            $consulta_insercion->bindParam(1, $nombre_alumno);
            $consulta_insercion->bindParam(2, $apellido1);
            $consulta_insercion->bindParam(3, $apellido2);
            $consulta_insercion->bindParam(4, $email);
            $consulta_insercion->bindParam(5, $fecha_nacimiento);
            $consulta_insercion->bindParam(6, $imagen);
            $consulta_insercion->bindParam(7, $contrasena);
            $consulta_insercion->bindParam(8, $id_alumno);


            $consulta_insercion->execute();

           

          echo "<meta http-equiv='refresh' content='0; url=alumnos.php'>";
      }
$conexion = null;
        import_js_bootstrap();
}
?>
</body>
</html>