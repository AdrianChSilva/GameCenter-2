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
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Usuarios <small>ADMINISTRADORES</small></h1>
    </div>
    <p class="lead">Aquí se muestra una lista con todos los administradores. Si eres administrador de nivel 1 podrás eliminar y actualizar. Si eres de nivel 2 sólo podrás actualizar</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL?>admin/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ADMINISTRADOR
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL?>adminlists/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL?>adminbusq/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR
            </a>
        </li>
    </ul>
</div>

<?php
    require_once "./controladores/controladorAdmin.php";
    $admin = new controladorAdmin();
?>
<!-- Panel listado de administradores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES</h3>
        </div>
        <div class="panel-body">
 
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $admin->paginadorAdminController($pagina[1],8,$_SESSION['privilegioGC'],
            $_SESSION['cuentaCodigoGC'],"");
            ?>
        </div>
    </div>
</div>