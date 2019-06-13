<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['nombre-reg']) || isset($_POST['codDelete']) || isset($_POST['codigo-up'])) {
    require_once "../controladores/controladorPublisher.php";
    $instPublish = new controladorPublisher();
    //si estos campos no vienen defininidos, NO se va a poder registrar.
    if (isset($_POST['nombre-reg']) && isset($_POST['encargado-reg'])) {
        echo $instPublish->addPublisherController();
    }

    if (isset($_POST['codigo-up'])) {
        echo $instPublish->updatePublisherController();
    }

    if (isset($_POST['codDelete']) && isset($_POST['privilegioAdmin'])) {
        echo $instPublish->deletePublisherController();
    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}
