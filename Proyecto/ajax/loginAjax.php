<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_GET['token'])) {
    require_once "../controladores/controladorLogin.php";
    $logout= new controladorLogin();
    echo $logout->cerrarSesionController();

} else {
    session_start(['name'=>'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}