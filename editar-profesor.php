<?php
session_start();
include '../../assets/php/functions.php';
if (!isset($_SESSION['id'])) {
    
    echo "<meta http-equiv='refresh' content='0; url=../../login.php'>";
    
}else{
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>
    <?php 
        import_css_bootstrap();
    ?>
</head>
<body>
    <?php
        menu_administrador();
        $conexion=conectarBD();
        if (isset($_GET['id'])) {
            $consulta_profesor=$conexion->prepare("SELECT * FROM profesor WHERE nif_profesor=?");
            $id_profesor=$_GET['id'];
            $consulta_profesor->bindParam(1, $id_profesor);
            $consulta_profesor->setFetchMode(PDO::FETCH_ASSOC);
            $consulta_profesor->execute();
            $datos=$consulta_profesor->fetch();
    ?>
    
<div class="container">
    <div class="row">
    <h1 class="col-12">Editar profesor</h1>
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
            echo "<meta http-equiv='refresh' content='0; url=profesor.php'>";
        }
        if (isset($_POST['actualizar'])) {


            $consulta_insercion=$conexion->prepare("UPDATE profesor SET nombre=?,apellido1=?,apellido2=?,email=?,fecha_nacimiento=?,img=?,contrasena=? WHERE nif_profesor=?");

            $nombre_profesor=$_POST['nombre'];
            $apellido1=$_POST['apellido1'];
            $apellido2=$_POST['apellido2'];
            $email=$_POST['email'];
            $fecha_nacimiento=$_POST['fecha_nacimiento'];
            $imagen=$datos['img'];
            $contrasena=$_POST['contrasena'];
            $id_profesor=$_GET['id'];


          if ($contrasena==$datos['contrasena']) {
            $contrasena=$datos['contrasena'];
          }else{
            $contrasena=password_hash($contrasena, PASSWORD_DEFAULT);
          }

            if ($_FILES['imagen']['tmp_name']!="") {
                unlink("../../assets/images/profesores/$datos[img]");


                if (!file_exists("../../assets/images/profesores")) {
                mkdir("../../assets/images/profesores");
                }


                $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
                $extension_imagen = extension_imagen($_FILES['imagen']['type']);
                $nombre_imagen = "imagen_profesor_$id_profesor" . $extension_imagen;
                move_uploaded_file($nombre_temporal_imagen, "../../assets/images/profesores/$nombre_imagen");

                $imagen=$nombre_imagen;

            }
                      
            $consulta_insercion->bindParam(1, $nombre_profesor);
            $consulta_insercion->bindParam(2, $apellido1);
            $consulta_insercion->bindParam(3, $apellido2);
            $consulta_insercion->bindParam(4, $email);
            $consulta_insercion->bindParam(5, $fecha_nacimiento);
            $consulta_insercion->bindParam(6, $imagen);
            $consulta_insercion->bindParam(7, $contrasena);
            $consulta_insercion->bindParam(8, $id_profesor);


            $consulta_insercion->execute();

           

          echo "<meta http-equiv='refresh' content='0; url=profesores.php'>";
      }
$conexion = null;
        import_js_bootstrap();
}
    ?>
</body>
</html>