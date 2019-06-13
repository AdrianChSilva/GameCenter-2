<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['codigoCuenta-up'])) {
    require_once "../controladores/controladorCuenta.php";
    $instCuenta = new controladorCuenta();
    //si estos campos no vienen defininidos, NO se va a poder registrar


    if (isset($_POST['codigoCuenta-up']) && isset($_POST['tipoCuenta-up']) && isset($_POST['usuario-up'])) {
        echo $instCuenta->updateAccountController();

    }
} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}