<?php
include 'assets/php/functions.php';

menu_principal();

?>
<main>
      <section id="cabecera-cursos" class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h2>Curso Online</h2>
          </div>
        </div>
      </section>
      <section id="todo-cursos">
        <div class="container">
          <div class='card-deck row'>
               <?php
        //conectamos con la base de datos
        $conexion = conectarBD();
        //hacemos la consulta a base de datos
        $consulta_cursos = $conexion->prepare("SELECT id_curso, nombre_curso, descrip_corta, img, nif_profesor, max_estudiantes, precio, seo_img, visible FROM curso");

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
              <div class='card mb-5'>
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
                <div class='card-footer d-flex justify-content-between'>
                  <small class='text-muted'
                    ><i class='fa fa-graduation-cap'></i> $cursos[max_estudiantes] Estudiantes</small
                  >
                  <small class='precio' style='color: #38b9db;
                  font-size: 1rem;
                  font-weight: 700;'>$cursos[precio]€</small>
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
      </section>

<?php
$conexion = null;
footer();
?>