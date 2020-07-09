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
        if (isset($_GET['nif_alumno']) && isset($_GET['id_curso']) && isset($_GET['fecha_matricula'])) {
            $consulta=$conexion->prepare("SELECT * FROM matricula WHERE nif_alumno=?, id_curso=?, fecha_matricula=?");
            $nif_alumno=$_GET['nif_alumno'];
            $id_curso=$_GET['id_curso'];
            $fecha_matricula=$_GET['fecha_matricula'];
            $consulta->bindParam(1, $nif_alumno);
            $consulta->bindParam(2, $id_curso);
            $consulta->bindParam(3, $fecha_matricula);
            $consulta->execute();

    ?>
    
<div class="container">
    <div class="row">
    <h1 class="col-12">Editar matricula</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id_curso">Curso</label>
            <select class="custom-select" name="curso" required>
                <?php
                $consulta_curso=$conexion->prepare("SELECT id_curso, nombre_curso FROM curso");
                $consulta_curso->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_curso->execute();

                while($curso=$consulta_curso->fetch()){
                    if ($_GET['id_curso']==$curso['id_curso']) {
                        echo"<option value='$curso[id_curso]' selected>$curso[nombre_curso]</option>";
                    }else{
                        echo"<option value='$curso[id_curso]'>$curso[nombre_curso]</option>";
                    }
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nif_alumno">Alumno</label>
            <select class="custom-select" name="alumno" required>
                <?php
                $consulta_alumno=$conexion->prepare("SELECT nif_alumno, nombre, apellido1, apellido2 FROM alumno");
                $consulta_alumno->setFetchMode(PDO::FETCH_ASSOC);
                $consulta_alumno->execute();

                while($alumno=$consulta_alumno->fetch()){
                    if ($_GET['nif_alumno']==$alumno['nif_alumno']) {
                        echo"<option value='$alumno[nif_alumno]' selected>$alumno[nombre] $alumno[apellido1] $alumno[apellido2]</option>";
                    }else{

                        echo"<option value='$alumno[nif_alumno]'>$alumno[nombre] $alumno[apellido1] $alumno[apellido2]</option>";
                    }
                }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="fecha_matricula">Fecha matricula</label>
            <input type="text" class="form-control" id="fecha_matricula" name="fecha_matricula" value="<?php echo $_GET['fecha_matricula'];?>" ria-describedby="nombre" required>
          </div>
    <button name="actualizar" type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
      <?php 
        }else {
            echo "<meta http-equiv='refresh' content='0; url=matriculas.php'>";
        }
        if (isset($_POST['actualizar'])) {

            $consulta_actualizar=$conexion->prepare("UPDATE matricula SET nif_alumno=?, id_curso=?, fecha_matricula=? WHERE nif_alumno=?, id_curso=?, fecha_matricula=?");

            $nuevo_nif_alumno=$_POST['alumno'];
            $nuevo_id_curso=$_POST['curso'];
            $nueva_fecha_matricula=$_POST['fecha_matricula'];
            
           
            $nif_alumno=$_GET['nif_alumno'];
            $id_curso=$_GET['id_curso'];
            $fecha_matricula=$_GET['fecha_matricula'];

            
            $consulta_actualizar->bindParam(1, $nuevo_nif_alumno);
            $consulta_actualizar->bindParam(2, $nuevo_id_curso);
            $consulta_actualizar->bindParam(3, $nueva_fecha_matricula);

            $consulta_actualizar->bindParam(4, $nif_alumno);
            $consulta_actualizar->bindParam(5, $id_curso);
            $consulta_actualizar->bindParam(6, $fecha_matricula);



            $consulta_actualizar->execute();

           

          echo "<meta http-equiv='refresh' content='0; url=matriculas.php'>";
      }
    $conexion = null;
        import_js_bootstrap();
    
}
?>
</body>
</html>