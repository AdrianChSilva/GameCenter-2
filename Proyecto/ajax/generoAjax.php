<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['nombre-reg']) || isset($_POST['codDelete']) || isset($_POST['nombre-up'])) {
    require_once "../controladores/controladorGenero.php";
    $instGenero = new controladorGenero();
    //si estos campos no vienen defininidos, NO se va a poder registrar.
    if (isset($_POST['nombre-reg']) && isset($_POST['codigo-reg'])) {
        echo $instGenero->addGeneroController();
    }

    if (isset($_POST['codDelete']) && isset($_POST['privilegioAdmin'])) {
        echo $instGenero->deleteGeneroController();
    }

    if (isset($_POST['codigo-up'])) {
        echo $instGenero->updateGeneroController();
    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}