<?php
include 'assets/php/functions.php';

menu_principal();

        $conexion = conectarBD();
        if (isset($_GET['id'])) {
        $consulta_cursos = $conexion->prepare("SELECT id_curso, nombre_curso, descrip_ext, img, nif_profesor, max_estudiantes, precio, seo_img FROM curso WHERE id_curso=?");

        $id_curso=$_GET['id'];
        $consulta_cursos->bindParam(1,$id_curso);

        $consulta_cursos->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_cursos->execute();

        $num_cursos = $consulta_cursos->rowCount();
        
        if ($num_cursos > 0 ) {
            while ($datos = $consulta_cursos->fetch()) {
                    $consulta_profesor = $conexion->prepare("SELECT nombre, apellido1, apellido2, img FROM profesor WHERE nif_profesor=?");

                    $consulta_profesor->bindParam(1, $datos['nif_profesor']);

                    $consulta_profesor->setFetchMode(PDO::FETCH_ASSOC);

                    $consulta_profesor->execute();

                    $datos_profesor = $consulta_profesor->fetch();


?>
<section id="cabecera-curso" class="container-fluid" style="background-image:url('assets/images/cursos/imagen/<?= $datos['img']?>');">
<div class="row">
    <div class="col-12">
        <h2><?= $datos['nombre_curso'] ?></h2>
        <span>
            · <?= $datos['max_estudiantes'] ?> estudiantes ·
        </span>
    </div>
</div>
</section>
<section id="descripcion-curso" class="container">
        <div class="row">
                <div class="col-md-8">
                   <h3>Descripción</h3>
                   <h4>Precio: <span><?=$datos['precio']?>€</span></h4>
                    <p><?=$datos['descrip_ext']?></p>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-title">
                            <h6>Docente</h6>
                        </div>
                        <?php echo"<img src='assets/images/profesores/$datos_profesor[img]' class='card-img-top' alt='foto perfil profesor'>";
                        ?>
                        <div class="card-body">
                            <h5><?php echo"$datos_profesor[nombre] 
                            $datos_profesor[apellido1] 
                            $datos_profesor[apellido2]";?> </h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="solicitar-info" class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="form">
                        <h3>Soliciar información</h3>
                        <form action="registro.php" method="POST">
                            <input type="text"class="form-control " name="nombre" placeholder="Nombre" required>
                            <input type="email" class="form-control " name="email" placeholder="Email" required>
                            <textarea name="textarea" id="textarea" placeholder="Mensaje"></textarea>
                            <input type="submit"  value="Enviar" class="boton-rectangular">
                        </form>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}

$conexion = null;
footer();

}else{
          echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    
}
?>
        