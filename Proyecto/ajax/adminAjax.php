<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['dni-reg']) || isset($_POST['codDelete']) || isset($_POST['cuenta-up'])) {
    require_once "../controladores/controladorAdmin.php";
    $instAdmin = new controladorAdmin();
    //si estos campos no vienen defininidos, NO se va a poder registrar. Son los que tienen la etiqueta REQUIRE
    if (isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg']) && isset($_POST['alias-reg'])) {
        echo $instAdmin->addAdminController();
    }

    if (isset($_POST['codDelete']) && isset($_POST['privilegioAdmin'])) {
        echo $instAdmin->deleteAdminController();
    }

    if(isset($_POST['cuenta-up']) && isset($_POST['dni-up'])){
        echo $instAdmin->updateAdminController();
    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}