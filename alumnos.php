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
?>
        <?php
        $conexion = conectarBD();
        
        if(isset($_GET['id'])){ 
          $consulta_borrar_alumno = $conexion->prepare("DELETE FROM alumno WHERE nif_alumno=?");

          $id_alumno=$_GET['id'];

          $consulta_borrar_alumno->bindParam(1, $id_alumno);

          $consulta_borrar_alumno->execute();
        }


        $consulta_alumnos = $conexion->prepare("SELECT nif_alumno, nombre, apellido1, apellido2, email, fecha_nacimiento, img FROM alumno");

        $consulta_alumnos->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_alumnos->execute();

        $num_alumnos = $consulta_alumnos->rowCount();

        if ($num_alumnos > 0) {
        ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">NIF</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Fecha de nacimiento</th>
                        <th scope="col"></th>
                        <th scope="col">
    <a href="nuevo-alumno.php"><button type="button" class="btn btn-success"">Nuevo Alumno</button></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($datos = $consulta_alumnos->fetch()) {
                    $fecha_de_nacimiento=formatearFecha($datos['fecha_nacimiento']);
                    echo "
                        <tr>
                            <td scope='row'>$datos[nif_alumno]</td>
                            <td scope='row'><img style='width: 50px;' src='../../assets/images/alumnos/$datos[img]'></td>
                            <td scope='row'>$datos[nombre] $datos[apellido1] $datos[apellido2]</td>
                            <td scope='row'>$datos[email]</td>
                            <td scope='row'>$fecha_de_nacimiento</td>
                            
                            <td scope='row'><a class='btn btn-danger' href='alumnos.php?id=$datos[nif_alumno]'>Borrar</a></td>

                            <td><a class='btn btn-primary' href='editar-alumno.php?id=$datos[nif_alumno]'>Editar</a></td>
                        </tr>";
                }
           

                ?>
                </tbody>
            </table>
            <?php
            }else{
                echo "<p>No hay alumnos actualmente</p>";
            }

            $conexion = null;
            import_js_bootstrap();
}
            ?>
</body>
</html>