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

class modeloPublisher extends modeloPrincipal
{
    protected function addPublisherModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO publisher(publisherCodigo,publisherNombre, publisherEncargado,publisherTlfn,publisherEmail,publisherDir)
         VALUES(:codigo,:nombre,:encargado,:tlfn,:email,:dir)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":encargado", $data['encargado']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->execute();
        return $sql;
    }

    protected function dataPublisherModel($tipoConsulta, $codigoPublisher)
    {
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM publisher 
            WHERE publisherCodigo=:codigo");
            $sql->bindParam(":codigo", $codigoPublisher);
            //contamos todos las publisher
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM publisher");
        }
        $sql->execute();
        return $sql;
    }

    protected function deletePublisherModel($codigoPublisher)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM publisher WHERE publisherCodigo=:codigo");
        $query->bindParam("codigo", $codigoPublisher);
        $query->execute();
        return $query;
    }

    protected function updatePublisherModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("UPDATE publisher SET publisherNombre=:nombre, publisherEncargado=:encargado, publisherTlfn=:tlfn,
        publisherEmail=:email, publisherDir=:dir
        WHERE publisherCodigo=:codigo");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":encargado", $data['encargado']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->execute();
        return $sql;
    }

}