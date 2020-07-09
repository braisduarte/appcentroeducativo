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
            $consulta_noticia=$conexion->prepare("SELECT * FROM noticia WHERE id_noticia=?");
            $id_noticia=$_GET['id'];
            $consulta_noticia->bindParam(1, $id_noticia);
            $consulta_noticia->setFetchMode(PDO::FETCH_ASSOC);
            $consulta_noticia->execute();
            $datos=$consulta_noticia->fetch();
    ?>
    
<div class="container">
    <div class="row">
    <h1 class="col-12">Editar Noticia</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" value="<?php echo $datos['titulo'];?>" class="form-control" id="titulo" name="titulo" aria-describedby="titulo" required>
          </div>
          <div class="form-group">
            <label for="texto">Texto</label>
            <textarea class="form-control" id="texto" name="texto"  maxlenth="1500" rows="3"><?php echo $datos['texto'];?></textarea>
          </div>
          <div class="form-group">
            <label for="fecha_evento">Fecha evento</label>
            <input type="text" value="<?php echo $datos['fecha_evento'];?>" class="form-control" id="fecha_evento" name="fecha_evento" aria-describedby="fecha_evento" required>
          </div>
          <div class="form-group">
            <label for="hora_comienzo_evento">Hora comienzo</label>
            <input type="text" value="<?php echo $datos['hora_comienzo_evento'];?>" class="form-control" id="hora_comienzo_evento" name="hora_comienzo_evento" aria-describedby="hora_comienzo_evento" required>
          </div>
          <div class="form-group">
            <label for="hora_fin_evento">Hora fin</label>
            <input type="text" value="<?php echo $datos['hora_fin_evento'];?>" class="form-control" id="hora_fin_evento" name="hora_fin_evento" aria-describedby="hora_fin_evento" required>
          </div>
          <label for="imagen">Selecciona una imagen</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="imagen" id="imagen" lang="es">
            <label class="custom-file-label" for="imagen">Seleccionar Archivo</label>
          </div>
          <div class="form-group">
            <label for="seo_imagen">SEO imagen</label>
            <input type="text" step="any" class="form-control" id="seo_imagen" name="seo_imagen" value="<?php echo $datos['seo_img'];?>" maxlenth="20" required></input>
          </div>
          <label for="thumbnail">Selecciona una thumbnail</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" lang="es">
            <label class="custom-file-label" for="thumbnail">Seleccionar Archivo</label>
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
            echo "<meta http-equiv='refresh' content='0; url=noticias.php'>";
        }
        if (isset($_POST['actualizar'])) {

            $consulta_insercion=$conexion->prepare("UPDATE noticia SET titulo=?,texto=?,fecha_evento=?,hora_comienzo_evento=?,hora_fin_evento=?,img=?,seo_img=?,thumbnail=?,visible=? WHERE id_noticia=?");

            $id=null;
            $titulo=$_POST['titulo'];
            $texto=$_POST['texto'];
            $fecha_evento=$_POST['fecha_evento'];
            $hora_comienzo_evento=$_POST['hora_comienzo_evento'];
            $hora_fin_evento=$_POST['hora_fin_evento'];
            $imagen=$datos['img'];
            $seo_imagen=$_POST['seo_imagen'];
            $thumbnail=$datos['thumbnail'];
            $visible=0;
            if (isset($_POST['visible'])) {
                $visible=1;
            }
            $id_noticia=$_GET['id'];

           if ($_FILES['imagen']['tmp_name']!="") {

                unlink("../../assets/images/noticias/imagen/$datos[imagen]");


                if (!file_exists("../../assets/images/noticias/imagen")) {
                mkdir("../../assets/images/noticias/imagen");
                }

                $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
                $extension_imagen = extension_imagen($_FILES['imagen']['type']);
                $nombre_imagen = "imagen_noticia_$id_noticia" . $extension_imagen;
                move_uploaded_file($nombre_temporal_imagen, "../../assets/images/noticias/imagen/$nombre_imagen");

                $imagen=$nombre_imagen;

            }

            if ($_FILES['thumbnail']['tmp_name']!="") {

                unlink("../../assets/images/noticias/thumbnail/$datos[thumbnail]");


                if (!file_exists("../../assets/images/noticias/thumbnail")) {
                mkdir("../../assets/images/noticias/thumbnail");
                }


                $nombre_temporal_thumbnail = $_FILES['thumbnail']['tmp_name'];
                $extension_thumbnail = extension_imagen($_FILES['thumbnail']['type']);
                $nombre_thumbnail = "thumbnail_noticia_$id_noticia" . $extension_thumbnail;
                move_uploaded_file($nombre_temporal_thumbnail, "../../assets/images/noticias/thumbnail/$nombre_thumbnail");

                $thumbnail=$nombre_thumbnail;

            }
            
            
            $consulta_insercion->bindParam(1, $titulo);
            $consulta_insercion->bindParam(2, $texto);
            $consulta_insercion->bindParam(3, $fecha_evento);
            $consulta_insercion->bindParam(4, $hora_comienzo_evento);
            $consulta_insercion->bindParam(5, $hora_fin_evento);
            $consulta_insercion->bindParam(6, $imagen);
            $consulta_insercion->bindParam(7, $seo_imagen);
            $consulta_insercion->bindParam(8, $thumbnail);
            $consulta_insercion->bindParam(9, $visible);
            $consulta_insercion->bindParam(10, $id_noticia);


            $consulta_insercion->execute();

           

          echo "<meta http-equiv='refresh' content='0; url=noticias.php'>";
      }
      $conexion = null;

        import_js_bootstrap();
}
    ?>
</body>
</html>