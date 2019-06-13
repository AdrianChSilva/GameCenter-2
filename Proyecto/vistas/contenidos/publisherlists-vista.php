<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->forzarCierreSesionController();
}
?>
<!-- Content page -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administración <small>PUBLISHERS</small></h1>
    </div>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL ?>publisher/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO PUBLISHER
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL ?>publisherlists/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PUBLISHERS
            </a>
        </li>
    </ul>
</div>

<?php
    require_once "./controladores/controladorPublisher.php";
    $publisher = new controladorPublisher();
?>


<!-- Panel listado de proveedores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PUBLISHERS</h3>
        </div>
        <div class="panel-body">
 
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $publisher->paginadorPublisherController($pagina[1],5,$_SESSION['privilegioGC'],
            $_SESSION['cuentaCodigoGC'],"");
            ?>
        </div>
    </div>
</div>