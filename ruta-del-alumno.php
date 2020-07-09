<?php
session_start();

include 'assets/php/functions.php';

if (!isset($_SESSION['nif_alumno'])) {
    
    echo "<meta http-equiv='refresh' content='0; url=login.php'>";
    
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área alumno</title>
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
  <div>
    <p class="nav-item nav-link m-auto text-light">Hola, <?= $_SESSION['nombre']; ?></p>
  </div>
  <div>
    <a class="nav-link text-danger text-danger bg-light" href="index.php?logout=true">Cerrar sesión</a>
  </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12">
        <?php
        $conexion=conectarBD();

        $consulta_matriculas = $conexion->prepare("SELECT nif_alumno, id_curso
        FROM  matricula WHERE nif_alumno=?");

        $nif=$_SESSION['nif_alumno'];

        $consulta_matriculas->bindParam(1,$nif);

        $consulta_matriculas->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_matriculas->execute();

        $num_matriculas = $consulta_matriculas->rowCount();

        if ($num_matriculas > 0) {
                $time=time();
                $fecha=date('Y/m/d',$time);
                $hora="00:00:00";
        ?>
    <form id="select" action="#" method="POST" class="mt-6">
        <label for="solicitar" class="my-auto">Solicitar tutoría</label>
        <select class="custom-select col-8 ml-3" name="curso" required>
        <option selected disabled>Elige un curso</option>
        <?php
                while ($datos = $consulta_matriculas->fetch()) {
                    $consulta_curso = $conexion->prepare("SELECT id_curso, nombre_curso FROM curso WHERE id_curso=?");

                    $consulta_curso->bindParam(1, $datos['id_curso']);

                    $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);

                    $consulta_curso->execute();

                    $curso=$consulta_curso->fetch();

                    if ($_SESSION['nif_alumno']==$datos['nif_alumno']) {
                        echo"
                            <option value='$curso[id_curso]'>$curso[nombre_curso]</option>
                        ";
                    }
                }
        ?>
        </select>
        <button type="submit" class="btn btn-enviar ml-3" name="enviar">Enviar</button>
    </form>
        <?php
        }else{
            echo "
            <div class='container'>
            <div class='row'>
                <table class='table table-bordered mt-10'>
                <thead class='thead-dark'>
                    <tr>
                        <th class='text-center'>
                        No estás matriculado todavía
                        </th>
                    </tr>
                </thead>
                </table>
            </div>
            </div>
                        ";
        }
?>

        </div>
    </div>
</div>
<?php
if (isset($_POST['enviar'])) {
    $consulta=$conexion->prepare("INSERT INTO tutoria VALUES (?, ?, ?, ?)");

    $nif=$_SESSION['nif_alumno'];
    $curso=$_POST['curso'];
    $fecha=$fecha;
    
    $consulta->bindParam(1, $nif);
    $consulta->bindParam(2, $curso);
    $consulta->bindParam(3, $fecha);
    $consulta->bindParam(4, $hora);
    
    
    $consulta->execute();
    
}

    $consulta_confirmacion=$conexion->prepare("SELECT * FROM tutoria WHERE nif_alumno=?");

    $nif=$_SESSION['nif_alumno'];

    $consulta_confirmacion->bindParam(1,$nif);

    $consulta_confirmacion->setFetchMode(PDO::FETCH_ASSOC);
    $consulta_confirmacion->execute();

    $num_confirmacion=$consulta_confirmacion->rowCount();
    
    if ($num_confirmacion>0) {
        ?>
        <div class="container">
            <div class="row">
                <table class="table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">
                            Tutorías del alumno
                        </th>
                    </tr>
                </thead>
                <tbody>
        <?php
       while ($confirmacion=$consulta_confirmacion->fetch()) {
           $consulta_curso = $conexion->prepare("SELECT id_curso, nombre_curso FROM curso WHERE id_curso=?");

            $consulta_curso->bindParam(1, $confirmacion['id_curso']);

            $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);

            $consulta_curso->execute();$curso=$consulta_curso->fetch();

            if ($confirmacion['hora']=="00:00:00") {
                echo "<tr><td scope='row' class='text-danger'>La tutoría de la asignatura $curso[nombre_curso] está pendiente de confirmación</td></tr>";
            }else{
                $fecha=formatearFecha($confirmacion['fecha_tutoria']);
                $hora=formatearHora($confirmacion['hora']);
                echo "<tr><td scope='row' class='text-success'>La tutoría de la asignatura $curso[nombre_curso] está confirmada para el día $fecha a las $hora</td></tr>";
            }
        }
        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }else{
        echo"
            <div class='container'>
            <div class='row'>
                <table class='table table-bordered mt-10'>
                <thead class='thead-dark'>
                    <tr>
                        <th class='text-center'>
                        No hay tutorías todavía
                        </th>
                    </tr>
                </thead>
                </table>
            </div>
            </div>
        ";
    }


$conexion = null;
import_js_bootstrap();
}

?>
    
</body>
</html>
