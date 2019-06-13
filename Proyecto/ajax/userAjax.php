<?php
$peticionAjax = true;
require_once "../archConfGeneral/configGeneral.php";
/**
 * Comprobamos si estamos recibiendo datos a través del envío de formularios
 * y que nadie pueda acceder a ésta pagina
 */
if (isset($_POST['dni-reg']) || isset($_POST['codDelete']) || isset($_POST['cuenta-up'])) {
    require_once "../controladores/controladorUser.php";
    $instUser = new controladorUser();
    if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg'])){
        echo $instUser->addUserController();

    }
    if (isset($_POST['codDelete']) && isset($_POST['privilegioAdmin'])) {
        echo $instUser->deleteUserController();
    }
    if(isset($_POST['cuenta-up']) && isset($_POST['dni-up'])){
        echo $instUser->updateUserController();
    }

} else {
    session_start(['name' => 'GC']);
    session_destroy();
    echo '<script> window.location.href="' . SERVERURL . 'login/"</script>';
}