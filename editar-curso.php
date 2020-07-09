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
            $consulta=$conexion->prepare("SELECT * FROM curso WHERE id_curso=?");
            $id=$_GET['id'];
            $consulta->bindParam(1, $id);
            $consulta->setFetchMode(PDO::FETCH_ASSOC);
            $consulta->execute();
            $datos=$consulta->fetch();
    ?>
    
<div class="container">
    <div class="row">
    <h1 class="col-12">Editar curso</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nombre_curso">Nombre curso</label>
            <input type="text" value="<?php echo $datos['nombre_curso'];?>" class="form-control" id="nombre_curso" name="nombre_curso" aria-describedby="nombre_curso" required>
          </div>
          <div class="form-group">
            <label for="nif_profesor">Profesor</label>
            <select class="custom-select" name="profesor" required>
                <?php
                $consulta_profesores=$conexion->prepare("SELECT nif_profesor, nombre, apellido1, apellido2 FROM profesor");
                $consulta_profesores->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_profesores->execute();
                while($profesor=$consulta_profesores->fetch()){
                    if ($profesor['nif_profesor']==$datos['nif_profesor']) {
                        echo"<option value='$profesor[nif_profesor]' selected>$profesor[nombre] $profesor[apellido1] $profesor[apellido2]</option>";
                    }else{

                        echo"<option value='$profesor[nif_profesor]'>$profesor[nombre] $profesor[apellido1] $profesor[apellido2]</option>";
                    }
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="descripcion_breve">Descripción breve</label>
            <textarea class="form-control" id="descripcion_breve" name="descripcion_breve" maxlenth="150" rows="3"><?php echo $datos['descrip_corta'];?></textarea>
          </div>
          <div class="form-group">
            <label for="descripcion_extensa">Descripción extensa</label>
            <textarea class="form-control" id="descripcion_extensa" name="descripcion_extensa"  maxlenth="1500" rows="3"><?php echo $datos['descrip_ext'];?></textarea>
          </div>
          <div class="form-group">
            <label for="num_maximo_alumnos">Nº máximo de alumnos</label>
            <input type="number" class="form-control" id="num_maximo_alumnos" name="num_maximo_alumnos" value="<?php echo $datos['max_estudiantes'];?>" maxlenth="2" rows="3" required></input>
          </div>
          <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="any" class="form-control" id="precio" name="precio" value="<?php echo $datos['precio'];?>" maxlenth="2" required></input>
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
            <input type="text" step="any" class="form-control" id="seo_imagen" name="seo_imagen" value="<?php echo $datos['seo_img'];?>" maxlenth="20" required></input>
          </div>
          <div class="form-check">
            <?php
            if ($datos['visible']==1) {
                echo "<input class='form-check-input' type='checkbox' id='visible' name='visible' checked>";
            }else{
                echo "<input class='form-check-input' type='checkbox' id='visible' name='visible'>";
            }
            ?>
            <label class="form-check-label" for="visible">
                Curso visible
            </label>
        </div>
        <br>
          <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
        </form>
    </div>
</div>
      <?php 
        }else {
            echo "<meta http-equiv='refresh' content='0; url=cursos.php'>";
        }
        if (isset($_POST['actualizar'])) {

            $consulta_insercion=$conexion->prepare("UPDATE curso SET nombre_curso=?,nif_profesor=?,descrip_corta=?,descrip_ext=?,max_estudiantes=?,precio=?,img=?,thumbnail=?,seo_img=?,visible=? WHERE id_curso=?");

            $id=null;
            $nombre_curso=$_POST['nombre_curso'];
            $profesor=$_POST['profesor'];
            $descripcion_breve=$_POST['descripcion_breve'];
            $descripcion_extensa=$_POST['descripcion_extensa'];
            $num_max_alumnos=$_POST['num_maximo_alumnos'];
            $precio=$_POST['precio'];
            $imagen=$datos['img'];
            $thumbnail=$datos['thumbnail'];
            $seo_imagen=$_POST['seo_imagen'];
            $visible=0;
            if (isset($_POST['visible'])) {
                $visible=1;
            }
            $id_curso=$_GET['id'];

            if ($_FILES['imagen']['tmp_name']!="") {

                unlink("../../assets/images/cursos/imagen/$datos[img]");


                if (!file_exists("../../assets/images/cursos/imagen")) {
                mkdir("../../assets/images/cursos/imagen");
                }


                $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
                $extension_imagen = extension_imagen($_FILES['imagen']['type']);
                $nombre_imagen = "imagen_curso_$id_curso" . $extension_imagen;
                move_uploaded_file($nombre_temporal_imagen, "../../assets/images/cursos/imagen/$nombre_imagen");

                $imagen=$nombre_imagen;

            }

            if ($_FILES['thumbnail']['tmp_name']!="") {

                unlink("../../assets/images/cursos/thumbnail/$datos[thumbnail]");


                if (!file_exists("../../assets/images/cursos/thumbnail")) {
                mkdir("../../assets/images/cursos/thumbnail");
                }


                $nombre_temporal_thumbnail = $_FILES['thumbnail']['tmp_name'];
                $extension_thumbnail = extension_imagen($_FILES['thumbnail']['type']);
                $nombre_thumbnail = "thumbnail_curso_$id_curso" . $extension_thumbnail;
                move_uploaded_file($nombre_temporal_thumbnail, "../../assets/images/cursos/thumbnail/$nombre_thumbnail");

                $thumbnail=$nombre_thumbnail;

            }
            
            
            $consulta_insercion->bindParam(1, $nombre_curso);
            $consulta_insercion->bindParam(2, $profesor);
            $consulta_insercion->bindParam(3, $descripcion_breve);
            $consulta_insercion->bindParam(4, $descripcion_extensa);
            $consulta_insercion->bindParam(5, $num_max_alumnos);
            $consulta_insercion->bindParam(6, $precio);
            $consulta_insercion->bindParam(7, $imagen);
            $consulta_insercion->bindParam(8, $thumbnail);
            $consulta_insercion->bindParam(9, $seo_imagen);
            $consulta_insercion->bindParam(10, $visible);
            $consulta_insercion->bindParam(11, $id_curso);

            $consulta_insercion->execute();

           

           echo "<meta http-equiv='refresh' content='0; url=cursos.php'>";
      }
$conexion = null;
        import_js_bootstrap();
}       
    ?>
</body>
</html>