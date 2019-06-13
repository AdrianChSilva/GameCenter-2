<?php

/**
 * si la peticion contiene ajax, pediremos los archivos REGRESANDO una carpeta
 * hacia atrás.
 */
if ($peticionAjax) {
    require_once "../archConfGeneral/modeloPrincipal.php";
} else {
    require_once "./archConfGeneral/modeloPrincipal.php";
}

class modeloVideojuego extends modeloPrincipal
{
    protected function addVideojuegoModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO videojuego(vidCodigo,vidTitulo,vidPais,vidAnno,vidPrecio,vidPlataforma,vidAnalisis,vidImagen,vidGuiaPDF,generoCodigo,publisherCodigo,desarrCodigo,vidVideo)
        VALUES(:codigo,:titulo,:pais,:anno,:precio,:plataforma,:analisis,:imagen,:pdf,:genCodigo,:pubCodigo,:desarCodigo,:video)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":titulo", $data['titulo']);
        $sql->bindParam(":pais", $data['pais']);
        $sql->bindParam(":anno", $data['anno']);
        $sql->bindParam(":precio", $data['precio']);
        $sql->bindParam(":plataforma", $data['plataforma']);
        $sql->bindParam(":analisis", $data['analisis']);
        $sql->bindParam(":imagen", $data['imagen']);
        $sql->bindParam(":pdf", $data['pdf']);
        $sql->bindParam(":genCodigo", $data['genCodigo']);
        $sql->bindParam(":pubCodigo", $data['pubCodigo']);
        $sql->bindParam(":desarCodigo", $data['desarCodigo']);
        $sql->bindParam(":video", $data['video']);
        $sql->execute();
        return $sql;
    }


    protected function dataVideojuegoModel($tipoConsulta, $codigoVideojuego)
    {
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM videojuego 
            WHERE vidCodigo=:codigo");
            $sql->bindParam(":codigo", $codigoVideojuego);
            //contamos todos los videojuegos
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM videojuego");
        }
        $sql->execute();
        return $sql;
    }

    protected function deleteVideojuegoModel($codigoVideojuego)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM videojuego WHERE vidCodigo=:codigo");
        $query->bindParam("codigo", $codigoVideojuego);
        $query->execute();
        return $query;
    }

    protected function updateVideojuegoModel($data)
    {
        $query = modeloPrincipal::conectDB()->prepare("UPDATE videojuego SET vidTitulo=:titulo,
        vidPais=:pais, vidAnno=:anno, vidPrecio=:precio, vidPlataforma=:plataforma, vidAnalisis=:analisis,
        vidImagen=:imagen, vidGuiaPDF=:pdf, generoCodigo=:genero, publisherCodigo=:publisher,
        desarrCodigo=:desarrolladora, vidVideo=:video
        WHERE vidCodigo=:codigo"); 
        $query->bindParam(":titulo", $data['titulo']);
        $query->bindParam(":pais", $data['pais']);
        $query->bindParam(":anno", $data['anno']);
        $query->bindParam(":precio", $data['precio']);
        $query->bindParam(":plataforma", $data['plataforma']);
        $query->bindParam(":analisis", $data['analisis']);
        $query->bindParam(":imagen", $data['imagen']);
        $query->bindParam(":pdf", $data['pdf']);
        $query->bindParam(":genero", $data['genero']);
        $query->bindParam(":publisher", $data['publisher']);
        $query->bindParam(":desarrolladora", $data['desarrolladora']);
        $query->bindParam(":codigo", $data['codigo']);
        $query->bindParam(":video", $data['video']);
        $query->execute();
        return $query;

        
    }
}