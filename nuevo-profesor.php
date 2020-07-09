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
    ?>

<div class="container">
    <div class="row">
    <h1 class="col-12">Crear profesor</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nif_profesor">NIF</label>
                <input type="text" class="form-control" id="nif_profesor" name="nif_profesor" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido1">Primer apellido</label>
                <input type="text"  class="form-control" id="apellido1" name="apellido1" required>
            </div>
            <div class="form-group">
                <label for="apellido2">Segundo apellido</label>
                <input type="text"  class="form-control" id="apellido2" name="apellido2" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="text"  class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <label for="imagen">Selecciona una imagen</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagen" id="imagen" lang="es">
            <label class="custom-file-label" for="imagen">Seleccionar Archivo</label>
          </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="crear">Crear</button>
        </form>
    </div>
</div>
    <?php
    if (isset($_POST['crear'])) {
        $consulta=$conexion->prepare("INSERT INTO profesor values (?, ?, ?, ?, ?, ?, ?, ?)");

        $nif=$_POST['nif_profesor'];
        $nombre=$_POST['nombre'];
        $apellido1=$_POST['apellido1'];
        $apellido2=$_POST['apellido2'];
        $email=$_POST['email'];
        $fecha_nacimiento=$_POST['fecha_nacimiento'];
        $imagen="";
        $contrasena=$_POST['contrasena'];

        $contrasena=password_hash($contrasena, PASSWORD_DEFAULT);



        if (!file_exists("../../assets/images/profesores")) {
              mkdir("../../assets/images/profesores");
        }


        $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
        $extension_imagen = extension_imagen($_FILES['imagen']['type']);
        $nombre_imagen = "imagen_profesor_$nif" . $extension_imagen;
        move_uploaded_file($nombre_temporal_imagen, "../../assets/images/profesores/$nombre_imagen");

        $imagen=$nombre_imagen;


        $consulta->bindParam(1, $nif);
        $consulta->bindParam(2, $nombre);
        $consulta->bindParam(3, $apellido1);
        $consulta->bindParam(4, $apellido2);
        $consulta->bindParam(5,$email);
        $consulta->bindParam(6, $fecha_nacimiento);
        $consulta->bindParam(7, $imagen);
        $consulta->bindParam(8, $contrasena);

        $consulta->execute();

        echo "<meta http-equiv='refresh' content='0; url=profesores.php'>";
    }
        $conexion=null;
        import_js_bootstrap();
}
    ?>
</body>
</html>