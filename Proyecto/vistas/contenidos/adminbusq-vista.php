<?php

/**
 * Como esta vista es para administradores, quedaría restringida su
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
    <p class="lead">Ésta es la página de buscar administradores. Por favor, para buscar alguno introduzca su nombre o apellidos o DNI. Es importante respetar las mayúsculas</p>
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

    if(isset($_POST['busquedaAdmin'])){
        $_SESSION['busqueda']=$_POST['busquedaAdmin'];
    }

    if(isset($_POST['eliminarBusquedaAdmin'])){
        unset( $_SESSION['busqueda']);
    }

    if(!isset($_SESSION['busqueda']) && empty($_SESSION['busqueda'])):
?>

<div class="container-fluid">
    <form class="well" method="POST" action="" >
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="form-group label-floating">
                    <span class="control-label">¿A quién estás buscando?</span>
                    <input class="form-control" type="text" name="busquedaAdmin" required="">
                </div>
            </div>
            <div class="col-xs-12">
                <p class="text-center">
                    <button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
                </p>
            </div>
        </div>
    </form>
</div>
<?php
else:
?>

<div class="container-fluid">
    <form class="well"  method="POST" action="">
        <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo  $_SESSION['busqueda']?>”</strong></p>
        <div class="row">
            <input class="form-control" type="hidden" name="eliminarBusquedaAdmin">
            <div class="col-xs-12">
                <p class="text-center">
                    <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
                </p>
            </div>
        </div>
    </form>
</div>

<!-- Panel listado de busqueda de administradores -->
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR</h3>
        </div>
        <div class="panel-body">
        <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $admin->paginadorAdminController($pagina[1],8,$_SESSION['privilegioGC'],
            $_SESSION['cuentaCodigoGC'], $_SESSION['busqueda']);
            ?>
        </div>
    </div>
</div>
<?php endif;?>