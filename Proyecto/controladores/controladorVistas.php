<?php

require_once "./modelos/modeloVistas.php";
class controladorVistas extends modeloVistas
{
    //Esto lo que nos va a devolver es la plantilla del diseño de la página
    public function obtenerPlantillaController()
    {
        return require_once "./vistas/plantilla.php";
    }
    public function obtenerVistasController()
    {
        if (isset($_GET['vistas'])) {//es la variable del .htaccess
            $url = explode("/", $_GET['vistas']);
            $devuelve = modeloVistas::obtenerVistasModel($url[0]);
        } else {
            //con esto hacemos que si en la url no hay definida ningún valor, es decir, no estás
            //en ninguna página de la aplicación, pues te devolverá al "login"
            $devuelve = "login";
        }
        return $devuelve;
    }
}