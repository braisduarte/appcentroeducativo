<?php
session_start();
include 'assets/php/functions.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    }
menu_principal();
?>
      <section id="cabecera" class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h2>Cursos Online</h2>
            <p>
              Html - Css - Php - MySql - Javascript - WordPress - Prestashop
            </p>
            <a href="#" class="btn-info">Más información</a>
          </div>
        </div>
      </section>
      <section id="bienvenido">
        <div class="container">
          <div class="row mensaje">
            <h2>Bienvenido a la plataforma E-Web</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad
              veritatis eveniet nam cum repellendus quas possimus?
            </p>
          </div>
          <div class="row">
            <div class="col-md-3">
              <img src="img/icon_1.png" alt="" />
              <h3>Expertos</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatem, aliquid.
              </p>
            </div>
            <div class="col-md-3">
              <img src="img/icon_2.png" alt="" />
              <h3>Recursos</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatem, aliquid.
              </p>
            </div>
            <div class="col-md-3">
              <img src="img/icon_3.png" alt="" />
              <h3>Cursos</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatem, aliquid.
              </p>
            </div>
            <div class="col-md-3">
              <img src="img/icon_4.png" alt="" />
              <h3>Premios</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatem, aliquid.
              </p>
            </div>
          </div>
        </div>
      </section>
      <section id="cursos">
        <div class="container">
          <div class="row mensaje">
            <h2>Cursos Online</h2>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad
              veritatis eveniet nam cum repellendus quas possimus?
            </p>
          </div>
          <div class='card-deck row'>
               <?php
        //conectamos con la base de datos
        $conexion = conectarBD();
        //hacemos la consulta a base de datos
        $consulta_cursos = $conexion->prepare("SELECT id_curso, nombre_curso, descrip_corta, img, nif_profesor, max_estudiantes, precio, seo_img, visible FROM curso LIMIT 3");

        $consulta_cursos->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_cursos->execute();

        $num_cursos = $consulta_cursos->rowCount();

        if ($num_cursos > 0 ) {
            while ($cursos = $consulta_cursos->fetch()) {
                    $consulta_profesor = $conexion->prepare("SELECT nombre, apellido1, apellido2 FROM profesor WHERE nif_profesor=?");

                    $consulta_profesor->bindParam(1, $cursos['nif_profesor']);

                    $consulta_profesor->setFetchMode(PDO::FETCH_ASSOC);

                    $consulta_profesor->execute();

                    $datos_profesor = $consulta_profesor->fetch();

                    if ($cursos['visible']==1) {
           echo" 
            <div class='col-md-4'>
              <div class='card'>
                <a href='info-curso.php?id=$cursos[id_curso]'
                  ><img src='assets/images/cursos/imagen/$cursos[img]' class='card-img-top' alt='...'
                /></a>
                <div class='card-body'>
                  <a href='info-curso.php?id=$cursos[id_curso]'>
                    <h3 class='card-title'>$cursos[nombre_curso]</h3>
                  </a>
                  <span>$datos_profesor[nombre] $datos_profesor[apellido1] $datos_profesor[apellido2]</span>
                  <p class='card-text'>
                    $cursos[descrip_corta]
                  </p>
                </div>
                <div class='card-footer'>
                  <small class='text-muted'
                    ><i class='fa fa-graduation-cap'></i> $cursos[max_estudiantes] Estudiantes</small
                  >
                  <small class='precio'>$cursos[precio]€</small>
                </div>
              </div>
            </div>
          ";
                    }
            }
        }else{
          echo "<p>No disponemos de cursos todavía</p>";
        }
        ?>
        </div>
          <div class="row">
            <a href="todo-cursos.php" class="mx-auto my-5 btn-vercursos"
              >Ver todos los cursos</a
            >
          </div>
        </div>
      </section>
      <section id="noticias" class="container">
        <div class="row mensaje">
          <h2>Noticias</h2>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Consectetur laboriosam expedita sed saepe, repudiandae molestias
            blanditiis ullam quas animi excepturi.
          </p>
        </div>
        <div class="card-deck">
           <?php
        //conectamos con la base de datos
        $conexion = conectarBD();
        //hacemos la consulta a base de datos
        $consulta_noticias = $conexion->prepare("SELECT id_noticia, titulo, texto, fecha_evento, hora_comienzo_evento, hora_fin_evento, img, seo_img, visible FROM noticia LIMIT 3");

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
              <div class='card'>
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
        <div class="row">
          <a href="#" class="col-12">Suscribir</a>
        </div>
      </section>
  
<?php
$conexion = null;
footer();
?>