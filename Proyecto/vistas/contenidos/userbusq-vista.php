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
        <h1 class="text-titles"><i class="zmdi zmdi-male-alt zmdi-hc-fw"></i> Usuarios <small>CLIENTES</small></h1>
    </div>
    <p class="lead">Ésta es la página de buscar clientes. Por favor, para buscar alguno introduzca su nombre o apellidos o DNI. Es importante respetar las mayúsculas</p>
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

    if(isset($_POST['busquedaUser'])){
        $_SESSION['busqueda']=$_POST['busquedaUser'];
    }

    if(isset($_POST['eliminarBusquedaUser'])){
        unset( $_SESSION['busqueda']);
    }

    if(!isset($_SESSION['busqueda']) && empty($_SESSION['busqueda'])):
?>
<div class="container-fluid">
    <form class="well" method="POST" action="">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="form-group label-floating">
                    <span class="control-label">¿A quién estas buscando?</span>
                    <input class="form-control" type="text" name="busquedaUser" required="">
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
    <form class="well" method="POST" action="">
        <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo  $_SESSION['busqueda']?>”</strong></p>
        <div class="row">
            <input class="form-control" type="hidden" name="eliminarBusquedaUser" required="">
            <div class="col-xs-12">
                <p class="text-center">
                    <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
                </p>
            </div>
        </div>
    </form>
</div>

<!-- Panel listado de busqueda de clientes -->
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR CLIENTE</h3>
        </div>
        <div class="panel-body">
        <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $user->paginadorUserController($pagina[1],8,$_SESSION['privilegioGC'], $_SESSION['busqueda']);
            ?>
        </div>
    </div>
</div>
<?php endif;?>