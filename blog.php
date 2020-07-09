<?php
include 'assets/php/functions.php';
menu_principal();
?>
<main>
      <section id="cabecera-cursos" class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h2>Noticias</h2>
          </div>
        </div>
      </section>

      <section id="noticias" class="container">
        <div class="card-deck">
           <?php
        //conectamos con la base de datos
        $conexion = conectarBD();
        //hacemos la consulta a base de datos
        $consulta_noticias = $conexion->prepare("SELECT id_noticia, titulo, texto, fecha_evento, hora_comienzo_evento, hora_fin_evento, img, seo_img, visible FROM noticia");

        $consulta_noticias->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_noticias->execute();

        $num_noticias = $consulta_noticias->rowCount();
        if ($num_noticias> 0 ){
          while($noticias=$consulta_noticias->fetch()){
               if ($noticias['visible']==1) {
                 $hora_comienzo=formatearHora($noticias['hora_comienzo_evento']);
                 $hora_fin=formatearHora($noticias['hora_fin_evento']);
                 $dia=dia($noticias['fecha_evento']);
                 $mes=mes($noticias['fecha_evento']);

                echo"
               <div class='col-md-4'>
              <div class='card mb-5'>
            <a href='info-noticia.php?id=$noticias[id_noticia]'
              ><img src='assets/images/noticias/imagen/$noticias[img]' class='card-img-top' alt='...'
            /></a>
            <div class='card-body row'>
              <div class='col-2 fecha'>
                <span>$dia</span>
                <span>$mes</span>
              </div>
              <div class='col-10'>
                <a href='#'>
                  <h3 class='card-title'>$noticias[titulo]</h3>
                </a>
                <small><i class='fa fa-clock-o'></i>$hora_comienzo - $hora_fin</small>
                <p class='card-text'>$noticias[texto]
                </p>
              </div>
            </div>
          </div>
          </div>

                ";
              }
          }
        }else{
          echo "<p>No disponemos de noticias todavía</p>";
        }
        ?>
        </div>

      </section>

<?php
$conexion = null;
footer();
?>