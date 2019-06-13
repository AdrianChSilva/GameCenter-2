<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->redireccionar($_SESSION['tipoGC']);
}
?>
<div class="container-fluid">
<div class="page-header">
    <h1 class="text-titles">Estadísticas <small>de la base de datos</small></h1>
</div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
<?php 
require_once "./controladores/controladorAdmin.php";
require_once "./controladores/controladorUser.php";
require_once "./controladores/controladorDesarrolladora.php";
require_once "./controladores/controladorPublisher.php";
require_once "./controladores/controladorGenero.php";
require_once "./controladores/controladorVideojuego.php";
$instAdmin = new controladorAdmin();
$contarAdmin = $instAdmin->dataAdminController("Todos", 0);

$instUser = new controladorUser();
$contarUser = $instUser->dataUserController("Todos", 0);

$instDesarr = new controladorDesarrolladora();
$contarDesarr = $instDesarr->dataDesarrController("Todos", 0);

$instPublisher = new controladorPublisher();
$contarPublisher = $instPublisher->dataPublisherController("Todos", 0);

$instGenero = new controladorGenero();
$contarGenero = $instGenero->dataGeneroController("Todos", 0);

$instVideojuego = new controladorVideojuego();
$contarVideojuego = $instVideojuego->dataVideojuegoController("Todos", 0);
?>

<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        administradores
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-account"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarAdmin->rowCount(); ?></p>
        <small><a class="noTocar" href="<?php echo SERVERURL ?>admin/">Registrados</a></small>
    </div>
</article>
<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        Clientes
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-male-alt"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarUser->rowCount(); ?></p>
        <small><a href="<?php echo SERVERURL ?>user/">Registrados</a></small>
    </div>
</article>
<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        Desarrolladoras
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-steam"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarDesarr->rowCount(); ?></p>
        <small><a href="<?php echo SERVERURL ?>desarrolladora/">Registrados</a></small>
    </div>
</article>
<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        Publishers
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-playstation"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarPublisher->rowCount(); ?></p>
        <small><a href="<?php echo SERVERURL ?>publisher/">Registrados</a></small>
    </div>
</article>
<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        Géneros
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-more"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarGenero->rowCount(); ?></p>
        <small><a href="<?php echo SERVERURL ?>genero/">Registrados</a></small>
    </div>
</article>
<article class="full-box tile">
    <div class="full-box tile-title text-center text-titles text-uppercase">
        Videojuegos
    </div>
    <div class="full-box tile-icon text-center">
        <i class="zmdi zmdi-gamepad"></i>
    </div>
    <div class="full-box tile-number text-titles">
        <p class="full-box"><?php echo $contarVideojuego->rowCount(); ?></p>
        <small><a href="<?php echo SERVERURL ?>videojuego/">Registrados</a></small>
    </div>
</article>
</div>
<div class="container-fluid">
<div class="page-header">
    <h1 class="text-titles">TimeLine <small>últimas sesiones</small></h1>
</div>

<?php
    require_once "./controladores/controladorHistorico.php";
    $historico = new controladorHistorico();
?>

<section id="cd-timeline" class="cd-container">
 
<?php
            echo $historico->HistoricoController(20);
            ?>
</section>
</div>