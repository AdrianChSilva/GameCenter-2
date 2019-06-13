<?php
class modeloVistas
{
    protected function obtenerVistasModel($vistas)
    {   //Esto es una lista de las palabras que están permitidas para escribir (en el primer valor)
        // en la URL, es decir, para acceder directamente a la página que se desee (y que exista)
        $palabPermit = [
            "admin", "adminbusq", "adminlists", "busqueda", "catalogo", "genero", "generolists",
            "user", "userbusq", "userlists", "desarrolladora", "desarrolladoralists", "home", "micuenta",
            "misdatos", "publisher", "publisherlists", "videojuego", "WIP", "videojuegoconfig", "videojuegoinfo", "registro",
            "actudesarrolladora", "actugenero", "actupublisher"
        ];
        if (in_array($vistas, $palabPermit)) {
            if (is_file("./vistas/contenidos/" . $vistas . "-vista.php")) {
                $devuelve = "./vistas/contenidos/" . $vistas . "-vista.php";
            } else {
                $devuelve = "login";
            }
        } elseif ($vistas == "login") {
            $devuelve = "login";
        } elseif ($vistas == "index") {
            $devuelve = "login";
        } elseif ($vistas == "registro") {
            $devuelve = "registro";
        } else {
            $devuelve = "404";
        }
        return $devuelve;
    }
}
