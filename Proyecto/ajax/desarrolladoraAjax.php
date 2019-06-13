<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['dni-reg']) || isset($_POST['codDelete']) || isset($_POST['dni-up']) ) {
    require_once "../controladores/controladorDesarrolladora.php";
    $instDesar = new controladorDesarrolladora();
    //si estos campos no vienen defininidos, NO se va a poder registrar. Son los que tienen la etiqueta REQUIRE
    if (isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['year-reg']) && isset($_POST['director-reg'])) {
        echo $instDesar->addDesarrController();
    }

    if (isset($_POST['dni-up'])) {
        echo $instDesar->updateDesarrController();
    }

    if (isset($_POST['codDelete']) && isset($_POST['privilegioAdmin'])) {
        echo $instDesar->deleteDesarrController();
    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}