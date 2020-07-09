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
?>
<div class="container">
    <div class="row">
    <h1 class="col-12">Crear curso</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nombre_curso">Nombre curso</label>
            <input type="text" class="form-control" id="nombre_curso" name="nombre_curso" aria-describedby="nombre_curso" required>
          </div>
          <div class="form-group">
            <label for="nif_profesor">Profesor</label>
            <select class="custom-select" name="profesor" required>
                <option selected disabled>Elige un profesor</option>
                <?php
                $consulta_profesores=$conexion->prepare("SELECT nif_profesor, nombre, apellido1, apellido2 FROM profesor");
                $consulta_profesores->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_profesores->execute();
                while($profesor=$consulta_profesores->fetch()){
                   echo"<option value='$profesor[nif_profesor]'>$profesor[nombre] $profesor[apellido1] $profesor[apellido2]</option>";
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="descripcion_breve">Descripción breve</label>
            <textarea class="form-control" id="descripcion_breve" name="descripcion_breve" maxlenth="150" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="descripcion_extensa">Descripción extensa</label>
            <textarea class="form-control" id="descripcion_extensa" name="descripcion_extensa" maxlenth="1500" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="num_maximo_alumnos">Nº máximo de alumnos</label>
            <input type="number" class="form-control" id="num_maximo_alumnos" name="num_maximo_alumnos" maxlenth="2" rows="3" required></input>
          </div>
          <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="any" class="form-control" id="precio" name="precio" maxlenth="2" required></input>
          </div>
          <label for="thumbnail">Selecciona una imagen</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagen" id="imagen" lang="es">
            <label class="custom-file-label" for="imagen">Seleccionar Archivo</label>
          </div>
          <br><br>
          <label for="thumbnail">Selecciona una imagen de vista previa</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" lang="es">
            <label class="custom-file-label" for="thumbnail">Seleccionar Archivo</label>
          </div>
          <br><br>
          <div class="form-group">
            <label for="seo_imagen">SEO imagen</label>
            <input type="text" step="any" class="form-control" id="seo_imagen" name="seo_imagen" maxlenth="20" required></input>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="visible" name="visible">
            <label class="form-check-label" for="visible">
                Curso visible
            </label>
        </div>
          <button type="submit" class="btn btn-primary" name="crear">Crear</button>
        </form>
    </div>
</div>
      <?php 
        if (isset($_POST['crear'])) {
            $consulta_insercion=$conexion->prepare("INSERT INTO curso VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $id=null;
            $nombre_curso=$_POST['nombre_curso'];
            $profesor=$_POST['profesor'];
            $descripcion_breve=$_POST['descripcion_breve'];
            $descripcion_extensa=$_POST['descripcion_extensa'];
            $num_max_alumnos=$_POST['num_maximo_alumnos'];
            $precio=$_POST['precio'];
            $imagen="";
            $thumbnail="";
            $seo_imagen=$_POST['seo_imagen'];
            $visible=0;
            if (isset($_POST['visible'])) {
                $visible=1;
            }

            $consulta_insercion->bindParam(1, $id);
            $consulta_insercion->bindParam(2, $nombre_curso);
            $consulta_insercion->bindParam(3, $profesor);
            $consulta_insercion->bindParam(4, $descripcion_breve);
            $consulta_insercion->bindParam(5, $descripcion_extensa);
            $consulta_insercion->bindParam(6, $num_max_alumnos);
            $consulta_insercion->bindParam(7, $precio);
            $consulta_insercion->bindParam(8, $imagen);
            $consulta_insercion->bindParam(9, $thumbnail);
            $consulta_insercion->bindParam(10, $seo_imagen);
            $consulta_insercion->bindParam(11, $visible);

            $consulta_insercion->execute();



            $id_curso = $conexion->lastInsertId();


            if (!file_exists("../../assets/images/cursos")) {
              mkdir("../../assets/images/cursos");
            }


            if (!file_exists("../../assets/images/cursos/imagen")) {
              mkdir("../../assets/images/cursos/imagen");
            }

            if (!file_exists("../../assets/images/cursos/thumbnail")) {
              mkdir("../../assets/images/cursos/thumbnail");
            }




            $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
            $extension_imagen = extension_imagen($_FILES['imagen']['type']);
            $nombre_imagen = "imagen_curso_$id_curso" . $extension_imagen;
            move_uploaded_file($nombre_temporal_imagen, "../../assets/images/cursos/imagen/$nombre_imagen");


            $nombre_temporal_thumbnail = $_FILES['thumbnail']['tmp_name'];
            $extension_thumbnail = extension_imagen($_FILES['thumbnail']['type']);
            $nombre_thumbnail = "thumbnail_curso_$id_curso" . $extension_thumbnail;
            move_uploaded_file($nombre_temporal_thumbnail, "../../assets/images/cursos/thumbnail/$nombre_thumbnail");


            $consulta_actualizacion = $conexion->prepare("UPDATE curso SET img=?, thumbnail=? WHERE id_curso=$id_curso");
            $consulta_actualizacion->bindParam(1, $nombre_imagen);
            $consulta_actualizacion->bindParam(2, $nombre_thumbnail);
            $consulta_actualizacion->execute();

            echo "<meta http-equiv='refresh' content='0; url=cursos.php'>";
      }


        $conexion=null;
        import_js_bootstrap();
}
    ?>
</body>
</html>