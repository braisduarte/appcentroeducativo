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
          $consulta_borrar_noticia = $conexion->prepare("DELETE FROM noticia WHERE id_noticia=?");

          $id_noticia=$_GET['id'];

          $consulta_borrar_noticia->bindParam(1, $id_noticia);

          $consulta_borrar_noticia->execute();
        }

        $consulta_noticias = $conexion->prepare("SELECT * FROM noticia");

        $consulta_noticias->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_noticias->execute();

        $num_noticias = $consulta_noticias->rowCount();

        if ($num_noticias > 0) {
        ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Título</th>
                        <th scope="col">Texto</th>
                        <th scope="col">Fecha Evento</th>
                        <th scope="col">Hora comienzo</th>
                        <th scope="col">Hora fin</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">SEO imagen</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">¿Visible?</th>
                        <th scope="col"></th>
                        <th scope="col">
                            <a href="nueva-noticia.php"><button type="button" class="btn btn-success"">Nueva Noticia</button></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($datos = $consulta_noticias->fetch()) {
                    $fecha_evento=formatearFecha($datos['fecha_evento']);
                    echo "
                        <tr>
                            <td scope='row'>$datos[id_noticia]</td>
                            <td scope='row'>$datos[titulo]</td>
                            <td scope='row' width='50'>
                            <textarea>$datos[texto]</textarea></td>
                            <td scope='row'>$fecha_evento</td>
                            <td scope='row'>$datos[hora_comienzo_evento]</td>
                            <td scope='row'>$datos[hora_fin_evento]</td>
                            <td scope='row'><img style='width: 50px;' src='../../assets/images/noticias/imagen/$datos[img]'></td>
                            <td scope='row'>$datos[seo_img]</td>
                            <td scope='row'><img style='width: 50px;' src='../../assets/images/noticias/thumbnail/$datos[thumbnail]'></td>";

                            if ($datos['visible'] == 0) {
                                 echo "<td>No</td>";
                            } else {
                                echo "<td>Si</td>";
                            }
                                echo "
                            <td><a class='btn btn-danger'  href='noticias.php?id=$datos[id_noticia]'>Borrar</a></td>

                            <td><a class='btn btn-primary'  href='editar-noticia.php?id=$datos[id_noticia]'>Editar</a></td>
                        </tr>";
                     
                }
            
                ?>
                </tbody>
            </table>
            <?php
            }else{
                echo "<p>No hay noticias actualmente</p>";
            }

            $conexion = null;
            import_js_bootstrap();
}
            ?>
</body>
</html>