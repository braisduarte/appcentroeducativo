<?php

function conectarBD(){
    /*ESTABLECER CONEXIÓN A LA BASE DE DATOS PDO*/
    $usuario="root";
    $contrasena="";
    try{
         $mbd = new PDO(
              'mysql:host=localhost;dbname=centro_educativo',
              $usuario,
              $contrasena,
              array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
         );
    }catch(PDOException $e){
         echo $e->getMessage();
    }

    return $mbd;
}

function formatearFecha($fecha){
    /***Formatear fechas***/
    //Obtener marca de tiempo de la fecha
    $timestamp=strtotime($fecha);
    //Formatear la fecha 
    $fecha_nacimiento=date('d/m/Y', $timestamp);
    return $fecha_nacimiento;
}

function formatearHora($hora){
    $timestamp=strtotime($hora);
    $hora_final=date('H:i', $timestamp);
    return $hora_final;
}

function dia($fecha){
    $timestamp=strtotime($fecha);
    $dia=date('d', $timestamp);
    return $dia;
}

function mes($fecha){
    $timestamp=strtotime($fecha);
    $mes=date('M', $timestamp);
    return $mes;
}

//funcion para importar css bootstrap
function import_css_bootstrap(){
    echo"
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css' integrity='sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk' crossorigin='anonymous'>
    ";
}
//funcion para importar jquery y js bootstrap
function import_js_bootstrap(){
    echo"
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js' integrity='sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj' crossorigin='anonymous'></script>

    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>

    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js' integrity='sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI' crossorigin='anonymous'></script>
    ";
}

//funcion del menu del administrador
function menu_administrador(){
    ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>E-Web</title>
    <link
      href="https://fonts.googleapis.com/css?family=Roboto+Slab|Roboto:400,500,700"
      rel="stylesheet"
    />
    <?php
    import_css_bootstrap();
    ?>
    <link rel="stylesheet" href="../../css/estilos.css" />
  </head>
<nav class="navbar navbar-expand-lg navbar-light nav-back">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link text-light" href="../curso/cursos.php">Cursos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../noticias/noticias.php">Noticias</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../alumno/alumnos.php">Alumnos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../profesor/profesores.php">Profesores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="../matricula/matriculas.php">Matrículas</a>
      </li>  
    </ul>
  </div>
  <div class="d-flex ">
    <p class="m-auto text-light">Hola, <?= $_SESSION['nombre']; ?></p>

    <a class="nav-link text-danger bg-light" href="../../index.php?logout=true">Cerrar sesión</a>
  </div>
</nav>
<?php
}
// header frontend
function menu_principal(){
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>E-Web</title>
    <link
      href="https://fonts.googleapis.com/css?family=Roboto+Slab|Roboto:400,500,700"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="icons/css/font-awesome.min.css" />
    <?php
    import_css_bootstrap();
    ?>
    <link rel="stylesheet" href="css/estilos.css" />
  </head>
<body>
<header id="header">
      <aside id="info-top">
        <div class="container">
          <div>
            <a href="contacto.php">¿Tienes alguna pregunta?</a>
            <a href="tel:+34958278060"
              ><i class="fa fa-phone"></i>958 27 80 60</a
            >
            <a href="mailto:info@escuelaartegranada.com"
              ><i class="fa fa-envelope"></i>info@escuelaartegranada.com</a
            >
          </div>
          <div>
            <a
              href="login.php"
              class="login"
              ><i class="fa fa-user"></i
            ></a>
          </div>
        </div>
      </aside>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand" href="index.php">
            <h1>E-<span>Web</span></h1>
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#menu"
            aria-controls="menu"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="menu">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link" href="index.php">Home</a>
              <a class="nav-item nav-link" href="escuela.php">Escuela</a>
              <a class="nav-item nav-link" href="todo-cursos.php">Cursos</a>
              <a class="nav-item nav-link" href="blog.php">Blog</a>
              <a class="nav-item nav-link" href="contacto.php">Contacto</a>
              <a class="nav-item nav-link" href="#"
                ><i class="fa fa-search"></i
              ></a>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <main>
<?php
}
//funcion para determinar la extensión de una imagen

function extension_imagen($tipo_imagen){
  $extension="";
      switch ($tipo_imagen) {
        case "image/jpeg":$extension=".jpg";
          break;
        case "image/png":$extension=".png";
          break;
      }
  return $extension;
}
?>

<?php
function footer(){
?>
    </main>
    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <a href="#"
              ><h2>E-<span>Web</span></h2></a
            >
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores,
              perferendis praesentium atque eius maxime rerum fugiat quas!
            </p>
            <div class="rrss">
              <a href="https://www.facebook.com/escuelaartegranada" class="fa fa-facebook-f"></a>
              <a href="https://www.pinterest.es/eartegranada/" class="fa fa-pinterest"></a>
              <a href="https://www.instagram.com/escuelaartegranada/" class="fa fa-instagram"></a>
              <a href="https://twitter.com/artegranada" class="fa fa-twitter"></a>
            </div>
          </div>
          <div class="col-md-4">
            <h4>Contactar</h4>
            <ul>
              <li>
                <a href="mailto:info@escuelaartegranada.com"
                  >info@escuelaartegranada.com</a
                >
              </li>
              <li><a href="tel:+34958278060">Telf: 958 27 80 60</a></li>
              <li><a href="#">Avda. Doctor Olóriz, 6. Granada, 18012.</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h4>Cursos</h4>
            <div class="footer-cursos">
              <ul>
                <li><a href="#">Web</a></li>
                <li><a href="#">Gráfico</a></li>
                <li><a href="#">Informática</a></li>
                <li><a href="#">3D</a></li>
              </ul>
              <ul>
                <li><a href="#">Interiores</a></li>
                <li><a href="#">Ciclos</a></li>
                <li><a href="#">Fotografía</a></li>
                <li><a href="#">Audiovisual</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <small>
              Copyright ©2020 Todos los derechos reservados |
              <a href="#">Escuela Arte Granada</a>
            </small>
          </div>
        </div>
      </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>


<?php
}

?>
