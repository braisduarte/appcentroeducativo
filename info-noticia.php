<?php
include 'assets/php/functions.php';

menu_principal();

        $conexion = conectarBD();
        if (isset($_GET['id'])) {
        $consulta_noticias = $conexion->prepare("SELECT id_noticia, titulo, texto, fecha_evento, hora_comienzo_evento, hora_fin_evento, img, seo_img, visible FROM noticia WHERE id_noticia=?");

        $id_noticia=$_GET['id'];
        $consulta_noticias->bindParam(1,$id_noticia);

        $consulta_noticias->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_noticias->execute();

        $num_noticias = $consulta_noticias->rowCount();
        
        if ($num_noticias > 0 ) {
            while ($noticias = $consulta_noticias->fetch()) {
                $hora_comienzo=formatearHora($noticias['hora_comienzo_evento']);
                 $hora_fin=formatearHora($noticias['hora_fin_evento']);
                 $fecha=formatearFecha($noticias['fecha_evento']);
                    
?>
<section id="cabecera_curso" class="container-fluid" style="background-image:url('assets/images/noticias/imagen/<?= $noticias['img']?>');">
<div class="row">
    <div class="col-12">
        <h2><?= $noticias['titulo'] ?></h2>
        <span>
            · <?= $fecha?> ·
        </span>
        <br>
        <span>
           <?= $hora_comienzo ?> - <?= $hora_fin ?>
        </span>
    </div>
</div>
</section>
<section id="descripcion-curso" class="container">
        <div class="row">
                <div class="col-md-12">
                    <p><?=$noticias['texto']?></p>
                </div>
            </div>
        </section>
<?php
    }
}

$conexion = null;
footer();

}else{
          echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    
}
?>
      