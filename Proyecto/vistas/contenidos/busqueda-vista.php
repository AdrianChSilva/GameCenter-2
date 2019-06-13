<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-search zmdi-hc-fw"></i> BUSCAR VIDEOJUEGO</h1>
    </div>
    <p class="lead">Aquí puedes buscar un videojuego según su: Título, Plataforma, País y código</p>
</div>


<?php
    require_once "./controladores/controladorVideojuego.php";
    $videojuego = new controladorVideojuego();

    if(isset($_POST['busquedaVideojuego'])){
        $_SESSION['busqueda']=$_POST['busquedaVideojuego'];
    }

    if(isset($_POST['eliminarBusquedaVideojuego'])){
        unset( $_SESSION['busqueda']);
    }

    if(!isset($_SESSION['busqueda']) && empty($_SESSION['busqueda'])):
?>

<div class="container-fluid">
    <form class="well" method="POST" action="">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="form-group label-floating">
                    <span class="control-label">¿Qué videojuego estás buscando?</span>
                    <input class="form-control" type="text" name="busquedaVideojuego" required="">
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
            <input class="form-control" type="hidden" name="eliminarBusquedaVideojuego">
            <div class="col-xs-12">
                <p class="text-center">
                    <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
                </p>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid">
    <h2 class="text-titles text-center">Búsqueda seleccionada</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="list-group">
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $videojuego->paginadorVideojuegoController($pagina[1],10, $_SESSION['busqueda']);
            ?>
            </div>
        </div>
    </div>
</div>
<?php endif?>