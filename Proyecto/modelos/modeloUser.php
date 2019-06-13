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

class modeloUser extends modeloPrincipal
{
    protected function addUserModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO user(userDNI,userNombre,userApellido,userTlfn,userOcup,userDir,cuentaCodigo) 
        VALUES(:DNI,:nombre,:apellido,:tlfn,:ocup,:dir,:codigo)");
        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":apellido", $data['apellido']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":ocup", $data['ocup']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->execute();
        return $sql;
    }

    protected function deleteUserModel($codigoCuenta)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM user WHERE cuentaCodigo=:codigo");
        $query->bindParam("codigo", $codigoCuenta);
        $query->execute();
        return $query;
    }

    /**
     * Con esta función haremos dos cosas. Traer los datos del usuario cuando éste
     * hace click en el boton correspondiente o si vamos a consultar el número de
     * usuarios que hay registrados en la base de datos actualmente (lo que se
     * muestra en el dashboard)
     */
    protected function dataUserModel($tipoConsulta, $codigoUser)
    {   //Traemos los datos de un usuario o usuario
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM user 
            WHERE cuentaCodigo=:codigo"); 
            $sql->bindParam(":codigo", $codigoUser);
            //contamos todos los usuarios
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM user");
        }
        $sql->execute();
        return $sql;
    }

    protected function updateUserModel($data)
    {
        $query = modeloPrincipal::conectDB()->prepare("UPDATE user SET userDNI=:DNI,
         userNombre=:nombre, userApellido=:apellido, userTlfn=:tlfn, userOcup=:ocup, userDir=:dir
         WHERE cuentaCodigo=:codigo");
        $query->bindParam(":DNI", $data['DNI']);
        $query->bindParam(":nombre", $data['nombre']);
        $query->bindParam(":apellido", $data['apellido']);
        $query->bindParam(":tlfn", $data['tlfn']);
        $query->bindParam(":ocup", $data['ocup']);
        $query->bindParam(":dir", $data['dir']);
        $query->bindParam(":codigo", $data['codigo']);
        $query->execute();
        return $query;

        
    }


}