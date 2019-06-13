<?php
require_once "./archConfGeneral/configGeneral.php" ;
//include "vistas/plantilla.php";
require_once "./controladores/controladorVistas.php";

$plantilla = new controladorVistas();
$plantilla->obtenerPlantillaController();

