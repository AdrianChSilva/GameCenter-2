<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['codigo-reg']) || isset($_POST['codDelete']) || isset($_POST['codigo-up'])) {
    require_once "../controladores/controladorVideojuego.php";
    $instVideojuego = new controladorVideojuego();
    //si estos campos no vienen defininidos, NO se va a poder registrar. Son los que tienen la etiqueta REQUIRE
    if (isset($_POST['titulo-reg']) && isset($_POST['codigo-reg'])) {
        echo $instVideojuego->addVideojuegoController();
    }

    if (isset($_POST['codDelete'])) {
        echo $instVideojuego->deleteVideojuegoController();
    }

    if(isset($_POST['codigo-up']) && isset($_POST['titulo-up'])){
        echo $instVideojuego->updateVideojuegoController();
    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}