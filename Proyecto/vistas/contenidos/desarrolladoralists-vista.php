<!-- Content page -->
<?php

/**
 * Como esta vista es para  administradores, quedaría restringida su
 * visualización para usuarios normales. 
 */
if ($_SESSION['tipoGC'] != "Administrador") {
    echo $loginController->forzarCierreSesionController();
}
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>DESARROLLADORA</small></h1>
    </div>
    <p class="lead">Aquí se muestra una lista con todas las desarrolladoras. Si eres administrador de nivel 1 podrás eliminar y actualizar. Si eres de nivel 2 sólo podrás actualizar</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL ?>desarrolladora/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVA DESARROLLADORA
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL ?>desarrolladoralists/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE DESARROLLADORAS
            </a>
        </li>
    </ul>
</div>
<?php
    require_once "./controladores/controladorDesarrolladora.php";
    $desarr = new controladorDesarrolladora();
?>

<!-- panel lista de empresas -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE DESARROLLADORA</h3>
        </div>
        <div class="panel-body">
 
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $desarr->paginadorDesarrController($pagina[1],5,$_SESSION['privilegioGC'],
            $_SESSION['cuentaCodigoGC'],"");
            ?>
        </div>
    </div>
</div>