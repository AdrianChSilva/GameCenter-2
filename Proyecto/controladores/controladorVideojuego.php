<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../modelos/modeloVideojuego.php";
} else {
    require_once "./modelos/modeloVideojuego.php";
}
class controladorVideojuego extends modeloVideojuego
{
    //Con esta función añadimos al videojuego en la base de datos, con sus
    //correspondientes comprobaciones.
    public function addVideojuegoController()
    {
        $codigo = modeloPrincipal::cleanInsert($_POST['codigo-reg']);
        $titulo = modeloPrincipal::cleanInsert($_POST['titulo-reg']);
        $pais = modeloPrincipal::cleanInsert($_POST['pais-reg']);
        $year = modeloPrincipal::cleanInsert($_POST['year-reg']);
        $desarrolladora = modeloPrincipal::cleanInsert($_POST['desarrolladora-reg']);
        $genero = modeloPrincipal::cleanInsert($_POST['genero-reg']);
        $publisher = modeloPrincipal::cleanInsert($_POST['publisher-reg']);
        $precio = modeloPrincipal::cleanInsert($_POST['precio-reg']);
        $plataforma = modeloPrincipal::cleanInsert($_POST['stock-reg']);
        $analisis = modeloPrincipal::cleanInsert($_POST['analisis-reg']);
        $video = modeloPrincipal::cleanInsert($_POST['video-reg']);

        //Se podrian hacer muchas comprobaciones cuando se sube un fichero
        //lo dejaremos para más adelante
        $imagen = DIRECTORIO . basename($_FILES['imagen-reg']["name"]);
        $pdf = DIRECTORIO . basename($_FILES['pdf-reg']["name"]);
        move_uploaded_file($_FILES['imagen-reg']["tmp_name"], $imagen);
        move_uploaded_file($_FILES['pdf-reg']["tmp_name"], $pdf);

        if ($codigo != "") {
            $comprobacion1 = modeloPrincipal::executeQuery("SELECT vidCodigo FROM videojuego WHERE vidCodigo='$codigo'");
            $codigoVideojuego = $comprobacion1->rowCount();
        } else {
            $codigoVideojuego = 0;
        }
        if ($codigoVideojuego >= 1) {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "El Código del videojuego ya existe",
                "Tipo" => "error"
            ];
        } else {
            $comprobacion2 = modeloPrincipal::executeQuery("SELECT vidTitulo FROM videojuego WHERE vidTitulo='$titulo'");
            if ($comprobacion2->rowCount() >= 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El TÍTULO del videojuego ya existe",
                    "Tipo" => "error"
                ];
            } else {
                $dataVideojuego = [
                    "codigo" => $codigo,
                    "titulo" => $titulo,
                    "pais" => $pais,
                    "anno" => $year,
                    "precio" => $precio,
                    "plataforma" => $plataforma,
                    "analisis" => $analisis,
                    "video" => $video,
                    "imagen" => $imagen,
                    "pdf" => $pdf,
                    "genCodigo" => $genero,
                    "pubCodigo" => $publisher,
                    "desarCodigo" => $desarrolladora

                ];
                $insertarVideojuego = modeloVideojuego::addVideojuegoModel($dataVideojuego);
                //Comprobamos si el Videojuego se ha registrado satisfactoriamente
                if ($insertarVideojuego->rowCount() >= 1) {
                    $alert = [
                        "Alert" => "limpiar",
                        "Titulo" => "ÉXITO",
                        "Texto" => "El Videojuego se registró satisfactoriamente",
                        "Tipo" => "success"
                    ];
                } else {
                    $alert = [
                        "Alert" => "simple",
                        "Titulo" => "ERROR",
                        "Texto" => "No se ha registrado el Videojuego. Es necesario introducir género, desarrolladora y publisher",
                        "Tipo" => "error"
                    ];
                }
            }
        }
        return modeloPrincipal::sweetAlert($alert);
    }

    public function dataGenVidController()
    {
        $sql = "SELECT * FROM genero ORDER BY id DESC";
        $conex = modeloPrincipal::conectDB();
        $generos = $conex->query($sql);
        $generos = $generos->fetchAll();

        $desplegable = "";

        foreach ($generos as $rows) {
            $desplegable .= '
            <option value="' . $rows['generoCodigo'] . '">' . $rows['generoNombre'] . '</option>
            ';
        }
        return $desplegable;
    }
    public function dataPubVidController()
    {
        $sql = "SELECT * FROM publisher ORDER BY id DESC";
        $conex = modeloPrincipal::conectDB();
        $publishers = $conex->query($sql);
        $publishers = $publishers->fetchAll();

        $desplegable = "";

        foreach ($publishers as $rows) {
            $desplegable .= '
            <option value="' . $rows['publisherCodigo'] . '">' . $rows['publisherNombre'] . '</option>
            ';
        }
        return $desplegable;
    }

    public function dataDesVidController()
    {
        $sql = "SELECT * FROM desarrolladora ORDER BY id DESC";
        $conex = modeloPrincipal::conectDB();
        $desarrolladoras = $conex->query($sql);
        $desarrolladoras = $desarrolladoras->fetchAll();

        $desplegable = "";

        foreach ($desarrolladoras as $rows) {
            $desplegable .= '
            
            <option value="' . $rows['desarrCodigo'] . '">' . $rows['desarrNombre'] . '</option>
            ';
        }
        return $desplegable;
    }

    public function nombreGenVidController($codigoGenero, $html)
    {
        $sql = "SELECT * FROM genero WHERE generoCodigo='$codigoGenero'";
        $conex = modeloPrincipal::conectDB();
        $genero = $conex->query($sql);
        $genero = $genero->fetchAll();
        $generoUp = "";
        if ($html) {
            foreach ($genero as $rows) {
                $generoUp = '<option value="' . $rows['generoCodigo'] . '">' . $rows['generoNombre'] . '</option>';
            }
        } else {
            foreach ($genero as $rows) {
                $generoUp = $rows['generoNombre'];
            }
        }
        return $generoUp;
    }


    public function nombreDesVidController($codigoDesarrolladora, $html)
    {
        $sql = "SELECT * FROM desarrolladora WHERE desarrCodigo='$codigoDesarrolladora'";
        $conex = modeloPrincipal::conectDB();
        $desarrolladora = $conex->query($sql);
        $desarrolladora = $desarrolladora->fetchAll();
        $desarrolladoraUp = "";
        if ($html) {
            foreach ($desarrolladora as $rows) {
                $desarrolladoraUp = '<option value="' . $rows['desarrCodigo'] . '">' . $rows['desarrNombre'] . '</option>';
            }
        } else {
            foreach ($desarrolladora as $rows) {
                $desarrolladoraUp = $rows['desarrNombre'];
            }
        }
        return $desarrolladoraUp;
    }

    public function nombrePublisherVidController($codigoPublisher, $html)
    {
        $sql = "SELECT * FROM publisher WHERE publisherCodigo='$codigoPublisher'";
        $conex = modeloPrincipal::conectDB();
        $publisher = $conex->query($sql);
        $publisher = $publisher->fetchAll();
        $publisherUp = "";
        if ($html) {
            foreach ($publisher as $rows) {
                $publisherUp = '<option value="' . $rows['publisherCodigo'] . '">' . $rows['publisherNombre'] . '</option>';
            }
        } else {
            foreach ($publisher as $rows) {
                $publisherUp = $rows['publisherNombre'];
            }
        }
        return $publisherUp;
    }


    //Con este controlador paginamos a los videojuegos
    public function paginadorVideojuegoController($pagina, $registros, $busq)
    {
        //lo primero que hacemos es limpiar las cadenas
        $pagina = modeloPrincipal::cleanInsert($pagina);
        $registros = modeloPrincipal::cleanInsert($registros);

        $busq = modeloPrincipal::cleanInsert($busq);
        //creamos una variable más que nos permitirá retornar la tabla de los publishers
        $tabla = "";

        /**
         * Calculamos la página en la que nos encontramos. No permitiremos que
         * alguien pueda escribir un numero de página con decimales
         */
        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1; //el 1 sirve para que, si pone por ej: (...)adminlists/paginaQueNoExiste, devuelva siempre la página 1 

        //con esta variable vamos a saber desde donde va a recoger los datos en la BD
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
        //comprobamos qué paginador usamos, si el de la pagina de desarrolladoras o el de busqueda
        if (isset($busq) && $busq != "") {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM videojuego
                       WHERE (vidTitulo LIKE '%$busq%' 
                       OR vidPais LIKE '%$busq%' OR vidCodigo LIKE '%$busq%' OR vidPlataforma LIKE '%$busq%') 
                       ORDER BY vidTitulo ASC LIMIT $inicio,$registros";
            $paginaURL = "busqueda";
        } else {
            $consulta2 = "SELECT SQL_CALC_FOUND_ROWS * FROM videojuego 
                       ORDER BY vidTitulo ASC LIMIT $inicio,$registros";
            $paginaURL = "catalogo";
        }

        $conex = modeloPrincipal::conectDB();
        $datos = $conex->query($consulta2);

        $datos = $datos->fetchAll();
        $total = $conex->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn(); //con esa funcion solo cuenta los registros de la tabla

        //con esto obtendremos el numero total de páginas según los registros que haya en BD
        //usamos ceil() porque coge un int y lo redondea
        $totalPaginas = ceil($total / $registros);


        //A PARTIR DE AQUÍ HACEMOS LA PARTE GRÁFICA DE LA TABLA///


        /**Con esto hacemos que si alguien escribe un numero mayor al total de páginas (según la cantidad de registros)
         * ésto muestre la tabla de que no hay registros en la BD
         */
        if ($total >= 1 && $pagina <= $totalPaginas) {
            $contador = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '<div class="list-group-item">
                <div class="row-picture">
                    <img src="' . $rows['vidImagen'] . '" alt="icon">
                </div>
                <div class="row-content">
                    <h4 class="list-group-item-heading">' . $contador . ' - ' . $rows['vidTitulo'] . '</h4>
                    <p class="list-group-item-text">';
                if ($_SESSION['tipoGC'] == "Administrador" || $_SESSION['tipoGC'] == "Cliente") {
                    if ($_SESSION['privilegioGC'] <= 2) {
                        $tabla .= '<a href="' . SERVERURL . 'videojuegoinfo/' . $rows['vidCodigo'] . '" class="btn btn-primary" title="Más información"><i class="zmdi zmdi-info"></i></a>
                         <a href="' . SERVERURL . 'videojuegoconfig/' . $rows['vidCodigo'] . '"  class="btn btn-primary" title="Gestionar videojuego"><i class="zmdi zmdi-wrench"></i></a>';
                    } else {
                        $tabla .= '<a href="' . SERVERURL . 'videojuegoinfo/' . $rows['vidCodigo'] . '" class="btn btn-primary" title="Más información"><i class="zmdi zmdi-info"></i></a>';
                    }
                }

                $tabla .= '</p>
                </div>
            </div>
            <div class="list-group-separator"></div>';
                $contador++;
            }
        } else {
            //si se borra en una página donde solo se muestra 1 registro (pero siguen existiendo más, lógicamente)
            //mostraremos un botón para recargar la tabla
            if ($total >= 1) {
                $tabla .= '
                <tr>
                    <td colspan="5">
                        <a href="' . SERVERURL . $paginaURL . '/" class="btn btn-group-sm btn-info btn-raised">
                            Recargar Catálogo
                        </a>
                    </td>
                </tr>
                ';
            } else {
                $tabla .= '
                <tr>
                    <td colspan="5">No hay registros en la Base de Datos</td>
                </tr>
                ';
            }
        }

        if ($total >= 1 && $pagina <= $totalPaginas) {
            $tabla .= '
                           <nav class="text-center">
                           <ul class="pagination pagination-sm">
                       ';
            if ($pagina == 1) {
                $tabla .= '<li class="disabled"><a><i class="zmdi zmdi-chevron-left"></i></a></li>';
            } else {
                $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . ($pagina - 1) . '/"><i class="zmdi zmdi-chevron-left"></i></a></li>';
            }
            //Esto es para marcar con un color al número de la página que nos encontramos
            for ($i = 1; $i <= $totalPaginas; $i++) {
                if ($pagina == $i) {
                    $tabla .= '<li class="active"><a href="' . SERVERURL . $paginaURL . '/' . $i . '/">' . $i . '</a></li>';
                } else {
                    $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . $i . '/">' . $i . '</a></li>';
                }
            }

            if ($pagina == $totalPaginas) {
                $tabla .= '<li class="disabled"><a><i class="zmdi zmdi-chevron-right"></i></a></li>';
            } else {
                $tabla .= '<li><a href="' . SERVERURL . $paginaURL . '/' . ($pagina + 1) . '/"><i class="zmdi zmdi-chevron-right"></i></a></li>';
            }

            $tabla .= '
                           </ul>
                           </nav>
                   ';
        }


        return $tabla;
    }

    //Con este controlador traemos los datos de la tabla de Videojuegos
    public function dataVideojuegoController($tipoConsulta, $codigoVideojuego)
    {
        //podría encriptar el código del videojuego, pero por ahora no le veo razón para hacer eso.
        //$codigoVideojuego = modeloPrincipal::decryption($codigoVideojuego);
        $codigoVideojuego = modeloPrincipal::cleanInsert($codigoVideojuego);
        $tipoConsulta = modeloPrincipal::cleanInsert($tipoConsulta);

        return modeloVideojuego::dataVideojuegoModel($tipoConsulta, $codigoVideojuego);
    }
    //Con este controlador actualizamos el videojuego. Hay que mejorar (en futuras versiones) el apartado de la imagen
    public function updateVideojuegoController()
    {
        
        $codigo = modeloPrincipal::cleanInsert($_POST['codigo-up']);
        $titulo = modeloPrincipal::cleanInsert($_POST['titulo-up']);
        $pais = modeloPrincipal::cleanInsert($_POST['pais-up']);
        $year = modeloPrincipal::cleanInsert($_POST['year-up']);
        $desarrolladora = modeloPrincipal::cleanInsert($_POST['desarrolladora-up']);
        $publisher = modeloPrincipal::cleanInsert($_POST['publisher-up']);
        $genero = modeloPrincipal::cleanInsert($_POST['genero-up']);
        $precio = modeloPrincipal::cleanInsert($_POST['precio-up']);
        $plataforma = modeloPrincipal::cleanInsert($_POST['stock-up']);
        $analisis = modeloPrincipal::cleanInsert($_POST['analisis-up']);
        $video = modeloPrincipal::cleanInsert($_POST['video-up']);





        //Realizamos las comprobaciones
        $comprobacion1 = modeloPrincipal::executeQuery("SELECT * FROM videojuego where vidCodigo='$codigo'");
        $datosVideojuego = $comprobacion1->fetch();

        if ($titulo != $datosVideojuego['vidTitulo']) {
            //comprobamos que el titulo que se introduce (actualiza) no existe ya dentro de la BD
            $query1 = modeloPrincipal::executeQuery("SELECT vidTitulo FROM videojuego where vidTitulo='$titulo'");
            if ($query1->rowCount() == 1) {
                $alert = [
                    "Alert" => "simple",
                    "Titulo" => "ERROR",
                    "Texto" => "El TÍTULO del videojuego que has escrito ya se encuentra registrado",
                    "Tipo" => "error"
                ];
                return modeloPrincipal::sweetAlert($alert);
                exit(); //esta función lo que hace es parar la ejecución del codigo PHP
            }
        }
        //Si se actualiza la imagen pero no el PDF
        if (is_uploaded_file($_FILES['imagen-up']["tmp_name"]) && !is_uploaded_file($_FILES['pdf-up']["tmp_name"])) {
            $imagen = DIRECTORIO . basename($_FILES['imagen-up']["name"]);
            move_uploaded_file($_FILES['imagen-up']["tmp_name"], $imagen);
            $queryPDF = modeloPrincipal::executeQuery("SELECT vidGuiaPDF FROM videojuego where vidCodigo='$codigo'");
            $pdfBD =  $queryPDF->fetch();

            $datosVideojuego = [
                "titulo" => $titulo,
                "pais" => $pais,
                "anno" => $year,
                "precio" => $precio,
                "plataforma" => $plataforma,
                "analisis" => $analisis,
                "video" => $video,
                "imagen" =>  $imagen,
                "pdf" =>  $pdfBD['vidGuiaPDF'],
                "genero" => $genero,
                "publisher" => $publisher,
                "desarrolladora" => $desarrolladora,
                "codigo" => $codigo
            ];
            //Si se actualiza el PDF pero no la imagen
        } elseif (is_uploaded_file($_FILES['pdf-up']["tmp_name"]) && !is_uploaded_file($_FILES['imagen-up']["tmp_name"])) {
            $pdf = DIRECTORIO . basename($_FILES['pdf-up']["name"]);
            move_uploaded_file($_FILES['pdf-up']["tmp_name"], $pdf);
            $queryIMG = modeloPrincipal::executeQuery("SELECT vidImagen FROM videojuego where vidCodigo='$codigo'");
            $imgBD = $queryIMG->fetch();

            $datosVideojuego = [
                "titulo" => $titulo,
                "pais" => $pais,
                "anno" => $year,
                "precio" => $precio,
                "plataforma" => $plataforma,
                "analisis" => $analisis,
                "video" => $video,
                "imagen" =>  $imgBD['vidImagen'],
                "pdf" =>  $pdf,
                "genero" => $genero,
                "publisher" => $publisher,
                "desarrolladora" => $desarrolladora,
                "codigo" => $codigo
            ];
            //si se actualizan ambas cosas
        } elseif (is_uploaded_file($_FILES['pdf-up']["tmp_name"]) && is_uploaded_file($_FILES['imagen-up']["tmp_name"])) {
            $imagen = DIRECTORIO . basename($_FILES['imagen-up']["name"]);
            $pdf = DIRECTORIO . basename($_FILES['pdf-up']["name"]);
            move_uploaded_file($_FILES['pdf-up']["tmp_name"], $pdf);
            move_uploaded_file($_FILES['imagen-up']["tmp_name"], $imagen);

            $datosVideojuego = [
                "titulo" => $titulo,
                "pais" => $pais,
                "anno" => $year,
                "precio" => $precio,
                "plataforma" => $plataforma,
                "analisis" => $analisis,
                "video" => $video,
                "imagen" =>  $imagen,
                "pdf" =>  $pdf,
                "genero" => $genero,
                "publisher" => $publisher,
                "desarrolladora" => $desarrolladora,
                "codigo" => $codigo
            ];
            //si no se actualiza ninguna de las dos llamamos a la bd y le insertamos lo que ya existia
        } else {

            $queryIMG = modeloPrincipal::executeQuery("SELECT vidImagen FROM videojuego where vidCodigo='$codigo'");
            $queryPDF = modeloPrincipal::executeQuery("SELECT vidGuiaPDF FROM videojuego where vidCodigo='$codigo'");
            $pdfBD =  $queryPDF->fetch();
            $imgBD = $queryIMG->fetch();
            $datosVideojuego = [
                "titulo" => $titulo,
                "pais" => $pais,
                "anno" => $year,
                "precio" => $precio,
                "plataforma" => $plataforma,
                "analisis" => $analisis,
                "video" => $video,
                "imagen" =>  $imgBD['vidImagen'],
                "pdf" =>  $pdfBD['vidGuiaPDF'],
                "genero" => $genero,
                "publisher" => $publisher,
                "desarrolladora" => $desarrolladora,
                "codigo" => $codigo
            ];
        }


        if (modeloVideojuego::updateVideojuegoModel($datosVideojuego)) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "Se han actualizado los datos del videojuego satisfactoriamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha podido actualizar los datos del videojuego",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }

    //Con este controlador eliminamos el videojuego
    public function deleteVideojuegoController()
    {
        //primero desencriptamos los values del formulario de BORRAR
        $codigo = $_POST['codDelete'];
        //limpiamos cualquier inserción de datos que pueda ocurrir
        $codigo = modeloPrincipal::cleanInsert($codigo);

        $consulta = modeloPrincipal::executeQuery("SELECT id FROM videojuego Where vidCodigo='$codigo'");
        $dataVideojuego = $consulta->fetch();

        $delVideojuego = modeloVideojuego::deleteVideojuegoModel($codigo);

        if ($delVideojuego->rowCount() >= 1) {
            $alert = [
                "Alert" => "actualizar",
                "Titulo" => "ÉXITO",
                "Texto" => "Videojuego eliminado correctamente",
                "Tipo" => "success"
            ];
        } else {
            $alert = [
                "Alert" => "simple",
                "Titulo" => "ERROR",
                "Texto" => "No se ha podido eliminar la Videojuego",
                "Tipo" => "error"
            ];
        }
        return modeloPrincipal::sweetAlert($alert);
    }
}
