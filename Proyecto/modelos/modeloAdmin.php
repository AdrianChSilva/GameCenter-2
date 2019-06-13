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

class modeloAdmin extends modeloPrincipal
{
    protected function addAdminModel($data)
    {
        $sql = modeloPrincipal::conectDB()->prepare("INSERT INTO admin(adminDNI,adminNombre,adminApellido,adminTlfn,adminDir,cuentaCodigo)
         VALUES(:DNI,:nombre,:apellido,:tlfn,:dir,:codigo)");
        $sql->bindParam(":DNI", $data['DNI']);
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":apellido", $data['apellido']);
        $sql->bindParam(":tlfn", $data['tlfn']);
        $sql->bindParam(":dir", $data['dir']);
        $sql->bindParam(":codigo", $data['codigo']);
        $sql->execute();
        return $sql;
    }
    protected function deleteAdminModel($codigoCuenta)
    {
        $query = modeloPrincipal::conectDB()->prepare("DELETE FROM admin WHERE cuentaCodigo=:codigo");
        $query->bindParam("codigo", $codigoCuenta);
        $query->execute();
        return $query;
    }
    /**
     * Con esta función haremos dos cosas. Traer los datos del administrador cuando éste
     * hace click en el boton correspondiente o si vamos a consultar el número de
     * administradores que hay registrados en la base de datos actualmente (lo que se
     * muestra en el dashboard)
     */
    protected function dataAdminModel($tipoConsulta, $codigoAdmin)
    {
        if ($tipoConsulta == "Uno") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT * FROM admin 
            WHERE cuentaCodigo=:codigo"); //con WHERE id!=13 podemos devitar que se cuente el administrador principal
            $sql->bindParam(":codigo", $codigoAdmin);
            //contamos todos los administradores, incluido el principal.
        } elseif ($tipoConsulta == "Todos") {
            $sql = modeloPrincipal::conectDB()->prepare("SELECT id FROM admin");
        }
        $sql->execute();
        return $sql;
    }

    protected function updateAdminModel($data)
    {
        $query = modeloPrincipal::conectDB()->prepare("UPDATE admin SET adminDNI=:DNI,
         adminNombre=:nombre, adminApellido=:apellido, adminTlfn=:tlfn, adminDir=:dir
         WHERE cuentaCodigo=:codigo");
        $query->bindParam(":DNI", $data['DNI']);
        $query->bindParam(":nombre", $data['nombre']);
        $query->bindParam(":apellido", $data['apellido']);
        $query->bindParam(":tlfn", $data['tlfn']);
        $query->bindParam(":dir", $data['dir']);
        $query->bindParam(":codigo", $data['codigo']);
        $query->execute();
        return $query;

        
    }
}
