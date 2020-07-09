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

            if(isset($_GET['nif_alumno']) && isset($_GET['id_curso']) && isset($_GET['fecha_matricula'])){
            $consulta_borrar_matricula = $conexion -> prepare("DELETE FROM matricula WHERE nif_alumno=? and id_curso=? and fecha_matricula=?");

            $id_alumno=$_GET['nif_alumno'];
            $id_curso=$_GET['id_curso'];
            $fecha_matricula=$_GET['fecha_matricula'];

            $consulta_borrar_matricula -> bindParam(1, $id_alumno);
            $consulta_borrar_matricula -> bindParam(2, $id_curso);
            $consulta_borrar_matricula -> bindParam(3, $fecha_matricula);

            $consulta_borrar_matricula -> execute();

            }

        $consulta_matriculas = $conexion->prepare("SELECT a.nombre nom_alum, a.apellido1 ap1_alum, a.apellido2 ap2_alum, a.nif_alumno nif_alumno, c.nombre_curso nom_curso, c.id_curso id_curso, m.fecha_matricula fecha_matricula
        FROM alumno a, curso c, matricula m 
        WHERE m.nif_alumno=a.nif_alumno and m.id_curso=c.id_curso");

        $consulta_matriculas->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_matriculas->execute();

        $num_matriculas = $consulta_matriculas->rowCount();

        if ($num_matriculas > 0) {
        ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Alumno</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Fecha Matricula</th>
                        <th scope="col"></th>
                        <th scope="col">
                            <a href="nueva-matricula.php"><button type="button" class="btn btn-success">Nueva Matricula</button></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($datos = $consulta_matriculas->fetch()) {
                    $fecha_matricula=formatearFecha($datos['fecha_matricula']);
                    echo "
                            <tr>
                                <td>$datos[nom_alum] $datos[ap1_alum] $datos[ap2_alum]</td>
                                <td>$datos[nom_curso]</td>
                                <td>$fecha_matricula</td>";

                        echo "
                <td><a class='btn btn-danger'  href='matriculas.php?nif_alumno=$datos[nif_alumno]&id_curso=$datos[id_curso]&fecha_matricula=$datos[fecha_matricula]'>Borrar</a></td>

                <td><a class='btn btn-primary'  href='editar-matricula.php?nif_alumno=$datos[nif_alumno]&id_curso=$datos[id_curso]&fecha_matricula=$datos[fecha_matricula]'>Editar</a></td>
            </tr>";
                    }
                }else{
                echo "<p>No hay matriculas actualmente</p>";
                }

                ?>
                </tbody>
            </table>

            <?php

            $conexion = null;
            import_js_bootstrap();
}
            ?>
</body>
</html>


