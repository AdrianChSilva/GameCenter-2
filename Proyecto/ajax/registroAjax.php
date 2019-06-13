<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['dni-reg'])) {
    require_once "../controladores/controladorRegistro.php";
    $instRegistro = new controladorRegistro();
    if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg'])){
        echo $instRegistro->registerController();


    }

} 