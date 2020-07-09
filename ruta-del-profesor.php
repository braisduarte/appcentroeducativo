<?php
session_start();

include 'assets/php/functions.php';

if (!isset($_SESSION['nif_profesor'])) {
    
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área profesor</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between nav-back">
  <div class="d-flex">
    <p class="nav-link m-auto text-light">Hola, <?= $_SESSION['nombre']; ?></p>
    <a class="nav-link m-auto btn btn-light" href="ruta-del-profesor.php">Tutorías</a>
  </div>
  <div>
    <a class="nav-link text-danger text-danger bg-light" href="index.php?logout=true">Cerrar sesión</a>
  </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php
         $conexion=conectarBD();

         $consulta_tutoria=$conexion->prepare("SELECT * FROM tutoria");
         $consulta_tutoria->setFetchMode(PDO::FETCH_ASSOC);
         $consulta_tutoria->execute();

         $num_tutoria = $consulta_tutoria->rowCount();
         
         if ($num_tutoria>0) {
             ?>
            <div class="container">
            <div class="row">
                <table class="table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">
                            Tutorías
                        </th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
         <?php
             while ($datos=$consulta_tutoria->fetch()) {
                 $consulta_curso = $conexion->prepare("SELECT id_curso, nombre_curso, nif_profesor FROM curso WHERE id_curso=?");
                    $consulta_curso->bindParam(1, $datos['id_curso']);

                    $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);

                    $consulta_curso->execute();

                    $curso=$consulta_curso->fetch();
                
                    if ($_SESSION['nif_profesor']==$curso['nif_profesor'] && $datos['id_curso']==$curso['id_curso']) {

                        $consulta_alumno=$conexion->prepare("SELECT nif_alumno, nombre, apellido1, apellido2 FROM alumno");

                        $consulta_alumno->setFetchMode(PDO::FETCH_ASSOC);
                        $consulta_alumno->execute();

                        $num_alumno=$consulta_alumno->rowCount();
                        if ($num_alumno>0) {
                           while ($alumno=$consulta_alumno->fetch()) {
                           $fecha=formatearFecha($datos['fecha_tutoria']);
                           $hora=formatearHora($datos['hora']);
                            if ($datos['nif_alumno']==$alumno['nif_alumno']) {
                                if ($datos['hora']!="00:00:00") {
                                    echo "<tr>
                                <td scope='row' class='text-success'>Tutoría para $alumno[nombre] $alumno[apellido1] $alumno[apellido2] en el curso $curso[nombre_curso] el $fecha a las $hora</td>

                                <td class='text-center'><a class='btn btn-primary'  href='editar-tutoria.php?id=$curso[id_curso]&alumno=$alumno[nif_alumno]'>Editar</a></td>
                                </tr>
                                ";
                                }else{
                                    echo "<tr>
                                <td scope='row' class='text-danger'>Tutoría pendiente para $alumno[nombre] $alumno[apellido1] $alumno[apellido2] en el curso $curso[nombre_curso] solicitada el $fecha</td>

                                <td class='text-center'><a class='btn btn-primary'  href='editar-tutoria.php?id=$curso[id_curso]&alumno=$alumno[nif_alumno]'>Editar</a></td>
                                </tr>
                                ";
                                }
                            }
                        }
                        }

                        
                    }else{

                    }
            }
             ?>
                    </tbody>
                </thead>
                </table>
            </div>
        </div>
        <?php
         }
         ?>
        
        </div>
    </div>
</div>


<?php
$conexion = null;
import_js_bootstrap();
}
?>
    
</body>
</html>
