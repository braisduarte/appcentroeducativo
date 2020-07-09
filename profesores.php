<?php
session_start();

include '../../assets/php/functions.php';

if (!isset($_SESSION['id'])) {
    
    echo "<meta http-equiv='refresh' content='0; url=../../login.php'>";
    
}else{
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>
    <?php
    import_css_bootstrap();
    ?>
</head>

<body>
<?php
menu_administrador();
?>
        <?php

        $conexion = conectarBD();

        if(isset($_GET['id'])){ 
          $consulta_borrar_profesor = $conexion->prepare("DELETE FROM profesor WHERE nif_profesor=?");

          $id_profesor=$_GET['id'];

          $consulta_borrar_profesor->bindParam(1, $id_profesor);

          $consulta_borrar_profesor->execute();
        }

        $consulta_profesores = $conexion->prepare("SELECT nif_profesor,nombre,apellido1,apellido2,email,fecha_nacimiento,img FROM profesor");

        $consulta_profesores->setFetchMode(PDO::FETCH_ASSOC);
        $consulta_profesores->execute();

        $num_profesores = $consulta_profesores->rowCount();

        if ($num_profesores > 0) {
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
                            <a href="nuevo-profesor.php"><button type="button" class="btn btn-success">Nuevo Profesor</button></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($datos = $consulta_profesores->fetch()) {
                    $fecha_de_nacimiento=formatearFecha($datos['fecha_nacimiento']);
                    echo "
                        <tr>
                            <td scope='row'>$datos[nif_profesor]</td>
                            <td scope='row'><img style='width: 50px;' src='../../assets/images/profesores/$datos[img]'></td>
                            <td scope='row'>$datos[nombre] $datos[apellido1] $datos[apellido2]</td>
                            <td scope='row'>$datos[email]</td>
                            <td scope='row'>$fecha_de_nacimiento</td>
                            
                            <td><a class='btn btn-danger'  href='profesores.php?id=$datos[nif_profesor]'>Borrar</a></td>

                            <td><a class='btn btn-primary'  href='editar-profesor.php?id=$datos[nif_profesor]'>Editar</a></td>
                        </tr>";
                }
           

                ?>
                </tbody>
            </table>
            <?php
            }else{
                echo "<p>No hay profesores actualmente</p>";
            }

            $conexion = null;

            import_js_bootstrap();
}
            ?>
</body>
</html>