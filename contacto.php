<?php
include 'assets/php/functions.php';

menu_principal();
?>
<section id="cabecera-contacto" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Contacto</h2>
        </div>
    </div>

</section>
    <section id="solicitar-info" class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                    <div class="form">
                        <h3>Te leemos</h3>
                        <form class=" align-content-center" action="registro.php" method="POST">
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
footer();
?>