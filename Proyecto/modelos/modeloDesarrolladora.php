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

class modeloDesarrolladora extends modeloPrincipal
{
    protected function addDesarrModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO desarrolladora(desarrCodigo,desarrNombre,desarrTlfn,desarrEmail,desarrDir,desarrCEO,desarrAno)
         VALUES(:codigo,:nombre,:tlfn,:email,:dir,:ceo,:anno)");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->bindParam(":ceo", $data['ceo']);
        $sql->bindParam(":anno", $data['anno']);
        $sql->execute();
        return $sql;
    }

    protected function dataDesarrModel($tipoConsulta, $codigoDesarr)
    {
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM desarrolladora 
            WHERE desarrCodigo=:codigo");
            $sql->bindParam(":codigo", $codigoDesarr);
            //contamos todos las desarrolladoras
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM desarrolladora");
        }
        $sql->execute();
        return $sql;
    }

    protected function deleteDesarrModel($codigoDesarr)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM desarrolladora WHERE desarrCodigo=:codigo");
        $query->bindParam("codigo", $codigoDesarr);
        $query->execute();
        return $query;
    }

    protected function updateDesarrModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("UPDATE desarrolladora SET desarrNombre=:nombre,
        desarrTlfn=:tlfn, desarrEmail=:email, desarrDir=:dir, desarrCEO=:ceo, desarrAno=:anno
        WHERE desarrCodigo=:codigo");
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->bindParam(":ceo", $data['ceo']);
        $sql->bindParam(":anno", $data['anno']);
        $sql->execute();
        return $sql;
    }

}