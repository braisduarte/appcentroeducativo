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
    <h1 class="col-12">Crear matricula</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id_curso">Curso</label>
            <select class="custom-select" name="curso" required>
            <option selected disabled>Elige un curso</option>
                <?php
                $consulta_curso=$conexion->prepare("SELECT id_curso, nombre_curso FROM curso");
                $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_curso->execute();

                while($curso=$consulta_curso->fetch()){
                        echo"<option value='$curso[id_curso]'>$curso[nombre_curso]</option>";
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nif_alumno">Alumno</label>
            <select class="custom-select" name="alumno" required>
            <option selected disabled>Elige un alumno</option>
                <?php
                $consulta_alumno=$conexion->prepare("SELECT nif_alumno, nombre, apellido1, apellido2 FROM alumno");
                $consulta_alumno->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_alumno->execute();

                while($alumno=$consulta_alumno->fetch()){
                        echo"<option value='$alumno[nif_alumno]'>$alumno[nombre] $alumno[apellido1] $alumno[apellido2]</option>";
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="fecha_matricula">Fecha matricula</label>
            <input type="text" class="form-control" id="fecha_matricula" name="fecha_matricula" ria-describedby="nombre" required>
          </div>
              <br>
    <button name="crear" type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
      <?php 
        if (isset($_POST['crear'])) {
            $consulta_insercion=$conexion->prepare("INSERT INTO matricula VALUES (?, ?, ?)");

            $alumno=$_POST['alumno'];
            $curso=$_POST['curso'];
            $fecha_matricula=$_POST['fecha_matricula'];

            $consulta_insercion->bindParam(1, $alumno);
            $consulta_insercion->bindParam(2, $curso);
            $consulta_insercion->bindParam(3, $fecha_matricula);

            $consulta_insercion->execute();


        echo "<meta http-equiv='refresh' content='0; url=matriculas.php'>";

      }


        $conexion=null;
        import_js_bootstrap();
}
    ?>
</body>
</html>