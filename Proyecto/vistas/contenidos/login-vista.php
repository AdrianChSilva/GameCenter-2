<div class="full-box login-container cover">
    <form action="" method="POST" autocomplete="off" class="logInForm">
        <p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
        <p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>
        <div class="form-group label-floating">
            <label class="control-label" for="UserName">Usuario</label>
            <input required="" class="form-control" id="UserName" name="user" type="text" style="color: #FFF;">
            <p class="help-block">Escribe tú nombre de usuario</p>
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="UserPass">Contraseña</label>
            <input required="" class="form-control" id="UserPass" name="pass" type="password" style="color: #FFF;">
            <p class="help-block">Escribe tú contraseña</p>
        </div>
        <div class="form-group text-center">
            <input type="submit" value="Iniciar sesión" class="btn btn-info" style="color: #FFF;">
            <a href="<?php echo SERVERURL ?>registro/" class="btn btn-info" style="color: #FFF;">Registrarse</a>
        </div>
    </form>
</div>
<?php
require_once "./controladores/controladorLogin.php";
$login = new controladorLogin();
if (isset($_SESSION['tipoGC'])) {
    echo $login->redireccionar($_SESSION['tipoGC']);
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    echo $login->iniciarSesionController();
}


?>