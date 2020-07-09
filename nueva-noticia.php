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
    <h1 class="col-12">Crear noticia</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="texto">Texto</label>
                <input type="text"  class="form-control" id="texto" name="texto" required>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha evento</label>
                <input type="text"  class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <div class="form-group">
                <label for="hora_comienzo_evento">Hora comienzo evento</label>
                <input type="text" class="form-control" id="hora_comienzo_evento" name="hora_comienzo_evento" required>
            </div>
            <div class="form-group">
                <label for="hora_fin_evento">Hora fin evento</label>
                <input type="text"  class="form-control" id="hora_fin_evento" name="hora_fin_evento" required>
            </div>
            <label for="imagen">Imagen</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="imagen" id="imagen" lang="es">
                <label class="custom-file-label" for="imagen">Seleccionar Archivo</label>
            </div>
            <div class="form-group">
                <label for="seo_imagen">SEO imagen</label>
                <input type="text"  class="form-control" id="seo_imagen" name="seo_imagen" required>
            </div>
            <label for="thumbnail">Thumbnail</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" lang="es">
                <label class="custom-file-label" for="thumbnail">Seleccionar Archivo</label>
            </div>
            <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="visible" name="visible">
            <label class="form-check-label" for="visible">
               Noticia visible
            </label>
        </div>
            <br>
            <br>
            <button type="submit" class="btn btn-primary" name="crear">Crear</button>
        </form>
    </div>
</div>
    <?php
    if (isset($_POST['crear'])) {
        $consulta=$conexion->prepare("INSERT INTO noticia values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $id_noticia=null;
        $titulo=$_POST['titulo'];
        $texto=$_POST['texto'];
        $fecha_evento=$_POST['fecha_evento'];
        $hora_comienzo_evento=$_POST['hora_comienzo_evento'];
        $hora_fin_evento=$_POST['hora_fin_evento'];
        $imagen="";
        $seo_imagen=$_POST['seo_imagen'];
        $thumbnail="";
        if (isset($_POST['visible'])) {
                $visible=1;
        }

        $consulta->bindParam(1, $id_noticia);
        $consulta->bindParam(2, $titulo);
        $consulta->bindParam(3, $texto);
        $consulta->bindParam(4, $fecha_evento);
        $consulta->bindParam(5,$hora_comienzo_evento);
        $consulta->bindParam(6, $hora_fin_evento);
        $consulta->bindParam(7, $imagen);
        $consulta->bindParam(8, $seo_imagen);
        $consulta->bindParam(9, $thumbnail);
        $consulta->bindParam(10, $visible);

        $consulta->execute();

        $id_noticia = $conexion->lastInsertId();

        if (!file_exists("../../assets/images/noticias")) {
              mkdir("../../assets/images/noticias");
        }

        if (!file_exists("../../assets/images/noticias/imagen")) {
              mkdir("../../assets/images/noticias/imagen");
            }

            if (!file_exists("../../assets/images/noticias/thumbnail")) {
              mkdir("../../assets/images/noticias/thumbnail");
            }


        $nombre_temporal_imagen = $_FILES['imagen']['tmp_name'];
        $extension_imagen = extension_imagen($_FILES['imagen']['type']);
        $nombre_imagen = "imagen_noticia_$id_noticia" . $extension_imagen;
        move_uploaded_file($nombre_temporal_imagen, "../../assets/images/noticias/imagen/$nombre_imagen");

        $nombre_temporal_thumbnail = $_FILES['thumbnail']['tmp_name'];
        $extension_thumbnail = extension_imagen($_FILES['thumbnail']['type']);
        $nombre_thumbnail = "thumbnail_noticia_$id_noticia" . $extension_thumbnail;
        move_uploaded_file($nombre_temporal_thumbnail, "../../assets/images/noticias/thumbnail/$nombre_thumbnail");


        $consulta_actualizacion = $conexion->prepare("UPDATE noticia SET img=?, thumbnail=? WHERE id_noticia=$id_noticia");
            $consulta_actualizacion->bindParam(1, $nombre_imagen);
            $consulta_actualizacion->bindParam(2, $nombre_thumbnail);
            $consulta_actualizacion->execute();



        echo "<meta http-equiv='refresh' content='0; url=noticias.php'>";
    }
        $conexion=null;
        import_js_bootstrap();
}
    ?>
</body>
</html>