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
    <h1 class="text-titles">System <small>Tiles</small></h1>
</div>
</div>
<div class="full-box text-center" style="padding: 30px 10px;">
<?php 
require_once "./controladores/controladorAdmin.php";
require_once "./controladores/controladorUser.php";
require_once "./controladores/controladorDesarrolladora.php";
require_once "./controladores/controladorPublisher.php";
require_once "./controladores/controladorGenero.php";
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
        <small>Registrados</small>
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
        <small>Registrados</small>
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
        <small>Registrados</small>
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
        <small>Registrados</small>
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
        <small>Registrados</small>
    </div>
</article>
</div>
<div class="container-fluid">
<div class="page-header">
    <h1 class="text-titles">System <small>TimeLine</small></h1>
</div>
<section id="cd-timeline" class="cd-container">
    <div class="cd-timeline-block">
        <div class="cd-timeline-img">
            <img src="<?php echo SERVERURL ?>vistas/assets/avatars/UserMale.png" alt="user-picture">
        </div>
        <div class="cd-timeline-content">
            <h4 class="text-center text-titles">1 - Name (Admin)</h4>
            <p class="text-center">
                <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
            </p>
            <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
        </div>
    </div>  
    <div class="cd-timeline-block">
        <div class="cd-timeline-img">
            <img src="<?php echo SERVERURL ?>vistas/assets/avatars/UserMale.png" alt="user-picture">
        </div>
        <div class="cd-timeline-content">
            <h4 class="text-center text-titles">2 - Name (Teacher)</h4>
            <p class="text-center">
                <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
            </p>
            <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
        </div>
    </div>
    <div class="cd-timeline-block">
        <div class="cd-timeline-img">
            <img src="<?php echo SERVERURL ?>vistas/assets/avatars/UserMale.png" alt="user-picture">
        </div>
        <div class="cd-timeline-content">
            <h4 class="text-center text-titles">3 - Name (Student)</h4>
            <p class="text-center">
                <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
            </p>
            <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
        </div>
    </div>
    <div class="cd-timeline-block">
        <div class="cd-timeline-img">
            <img src="<?php echo SERVERURL ?>vistas/assets/avatars/UserMale.png" alt="user-picture">
        </div>
        <div class="cd-timeline-content">
            <h4 class="text-center text-titles">4 - Name (Personal Ad.)</h4>
            <p class="text-center">
                <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp; 
                <i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
            </p>
            <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
        </div>
    </div>   
</section>
</div>