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

class modeloGenero extends modeloPrincipal
{
    protected function addGeneroModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO genero(generoCodigo,generoNombre)
         VALUES(:codigo,:nombre)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->execute();
        return $sql;
    }

    protected function dataGeneroModel($tipoConsulta, $codigoGenero)
    {
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM genero 
            WHERE generoCodigo=:codigo");
            $sql->bindParam(":codigo", $codigoGenero);
            //contamos todos las Genero
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM genero");
        }
        $sql->execute();
        return $sql;
    }

    protected function deleteGeneroModel($codigoGenero)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM genero WHERE generoCodigo=:codigo");
        $query->bindParam("codigo", $codigoGenero);
        $query->execute();
        return $query;
    }

    protected function updateGeneroModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("UPDATE genero SET generoNombre=:nombre WHERE generoCodigo=:codigo");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->execute();
        return $sql;
    }
}
