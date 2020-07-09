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
    <p class="nav-item nav-link m-auto text-light">Hola, <?= $_SESSION['nombre']; ?></p>
    <a class="nav-link btn btn-light" href="ruta-del-profesor.php">Tutorías</a>
  </div>
  <div>
    <a class="nav-link text-danger text-danger bg-light" href="index.php?logout=true">Cerrar sesión</a>
  </div>
</nav>
<?php
    $conexion=conectarBD();
    if (isset($_GET['id']) && isset($_GET['alumno'])) {
        $consulta_curso=$conexion->prepare("SELECT id_curso, nombre_curso FROM curso WHERE id_curso=?");
        $id_curso=$_GET['id'];
        $consulta_curso->bindParam(1, $id_curso);
        $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_curso->execute();
        $curso=$consulta_curso->fetch();

        $consulta_alumno=$conexion->prepare("SELECT nif_alumno, nombre, apellido1, apellido2 FROM alumno WHERE nif_alumno=?");
        $nif_alumno=$_GET['alumno'];
        $consulta_alumno->bindParam(1, $nif_alumno);$consulta_alumno->setFetchMode(PDO::FETCH_ASSOC);$consulta_alumno->execute();
        $num_alumno=$consulta_alumno->rowCount();
        $alumno=$consulta_alumno->fetch();

        $consulta_tutoria=$conexion->prepare("SELECT * FROM tutoria WHERE nif_alumno=? and id_curso=?");
        $nif_alumno=$_GET['alumno'];
        $id_curso=$_GET['id'];
        $consulta_tutoria->bindParam(1, $nif_alumno);
        $consulta_tutoria->bindParam(2, $id_curso);
        $consulta_tutoria->setFetchMode(PDO::FETCH_ASSOC);$consulta_tutoria->execute();
        $tutoria=$consulta_tutoria->fetch();
        ?>
        <div class="container mt-3">
            <div class="row">
                <h1 class="col-12 mb-2">Editar tutoría</h1>
                <?php
                    
                if ($_GET['alumno']==$alumno['nif_alumno']) {
                    echo"<p class='col-12'>Fecha y hora para $alumno[nombre] $alumno[apellido1] $alumno[apellido2] en $curso[nombre_curso]</p>";

                ?>
                 <form action="#" method="POST" class="col-6">
                 <div class="form-group">
                    <label for="fecha">Fecha de la tutoría</label>
                    <input type="text" class="form-control" id="fecha_tutoria" name="fecha_tutoria" value="<?php echo $tutoria['fecha_tutoria'];?>" ria-describedby="nombre" required>
                 </div>
                 <div class="form-group">
                    <label for="hora">Hora de la tutoría</label>
                    <input type="text" class="form-control" id="hora" name="hora" value="<?php echo $tutoria['hora'];?>" ria-describedby="nombre" required>
                 </div>
                <button name="confirmar" type="submit" class="btn btn-primary">Confirmar</button>
                 </form>
                <?php
                }    
                ?>
            </div>
        </div>
        <?php
}else{
    echo "<meta http-equiv='refresh' content='0; url=ruta-del-profesor.php'>";
}
if (isset($_POST['confirmar'])) {
        $consulta_actualizar=$conexion->prepare("UPDATE tutoria SET fecha_tutoria=?, hora=? WHERE nif_alumno=? and id_curso=?");

        $fecha_tutoria=$_POST['fecha_tutoria'];
        $hora=$_POST['hora'];

        $nif_alumno=$_GET['alumno'];
        $id_curso=$_GET['id'];
        
        $consulta_actualizar->bindParam(1,$fecha_tutoria);
        $consulta_actualizar->bindParam(2,$hora);

        $consulta_actualizar->bindParam(3,$nif_alumno);
        $consulta_actualizar->bindParam(4,$id_curso);

        $consulta_actualizar->execute();

        echo "<meta http-equiv='refresh' content='0; url=ruta-del-profesor.php'>";
        
    }

?>





<?php
$conexion = null;
import_js_bootstrap();
}
?>
    
</body>
</html>