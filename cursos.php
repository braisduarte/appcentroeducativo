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
          $consulta_borrar_curso = $conexion->prepare("DELETE FROM curso WHERE id_curso=?");

          $id_curso=$_GET['id'];

          $consulta_borrar_curso->bindParam(1, $id_curso);

          $consulta_borrar_curso->execute();
        }
        
        $consulta_cursos = $conexion->prepare("SELECT id_curso, nombre_curso, thumbnail, nif_profesor, max_estudiantes, precio, seo_img, visible FROM curso");
        $consulta_cursos->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_cursos->execute();

        $num_cursos = $consulta_cursos->rowCount();

        if ($num_cursos > 0) {
        ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Profesor</th>
                        <th scope="col">Nº estudiantes</th>
                        <th scope="col">Precio</th>
                        <th scope="col">SEO imagen</th>
                        <th scope="col">¿Visible?</th>
                        <th scope="col"></th>
                        <th scope="col">
                            <a href="nuevo-curso.php"><button type="button" class="btn btn-success"">Nuevo Curso</button></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($datos = $consulta_cursos->fetch()) {

                    $consulta_profesor = $conexion->prepare("SELECT nombre, apellido1, apellido2 FROM profesor WHERE nif_profesor=?");

                    $consulta_profesor->bindParam(1, $datos['nif_profesor']);

                    $consulta_profesor->setFetchMode(PDO::FETCH_ASSOC);

                    $consulta_profesor->execute();

                    while ($datos_profesor = $consulta_profesor->fetch()) {
                       echo "
                            <tr>
                                <td scope='row'>$datos[id_curso]</td>
                                <td><img style='width: 50px;' src='../../assets/images/cursos/thumbnail/$datos[thumbnail]'</td>
                                <td>$datos[nombre_curso]</td>
                                <td>$datos_profesor[nombre] $datos_profesor[apellido1] $datos_profesor[apellido2]</td>
                                <td>$datos[max_estudiantes]</td>
                                <td>$datos[precio]€</td>
                                <td>$datos[seo_img]</td>";

                    if ($datos['visible'] == 0) {
                        echo "<td>No</td>";
                    } else {
                        echo "<td>Si</td>";
                    }
                        echo "
                <td><a class='btn btn-danger' href='cursos.php?id=$datos[id_curso]'>Borrar</a></td>

                <td><a class='btn btn-primary'  href='editar-curso.php?id=$datos[id_curso]'>Editar</a></td>
            </tr>";
                    }
                }
            }else{
                echo "<p>No hay cursos actualmente</p>";
            }

                ?>
                </tbody>
            </table>

            <?php

            $conexion = null;

            ?>

            <?php
            import_js_bootstrap();

}
            ?>

</body>
</html>

