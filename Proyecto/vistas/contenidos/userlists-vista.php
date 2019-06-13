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
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Usuarios <small>CLIENTES</small></h1>
    </div>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>

<div class="container-fluid">
<ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>user/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO CLIENTE
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>userlists/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CLIENTES
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>userbusq/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR CLIENTE
            </a>
        </li>
    </ul>
</div>

<?php
    require_once "./controladores/controladorUser.php";
    $user = new controladorUser();
?>

<!-- Panel listado de clientes -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ADMINISTRADORES</h3>
        </div>
        <div class="panel-body">
 
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $user->paginadorUserController($pagina[1],8,$_SESSION['privilegioGC'],"");
            ?>
        </div>
    </div>
</div>