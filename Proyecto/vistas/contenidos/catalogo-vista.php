<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-gamepad"></i> CATÁLOGO</h1>
    </div>
    <p class="lead">Aquí puedes ver el catálogo de guías de videojuegos que tenemos disponible</p>
</div>

<?php 
  require_once "./controladores/controladorVideojuego.php";
  $videojuego = new controladorVideojuego();

?>
<div class="container-fluid">
    <h2 class="text-titles text-center">Lista de videojuegos</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="list-group">
            <?php
            $pagina = explode("/", $_GET['vistas']);
            echo $videojuego->paginadorVideojuegoController($pagina[1],500,"");
            ?>
            </div>

        </div>
    </div>
</div>