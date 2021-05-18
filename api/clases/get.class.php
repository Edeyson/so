<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class get extends conexion{
    public function getAll(){
        $query = "SELECT * FROM archivos";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }
    public function getOne($id){
        $query = "SELECT * FROM archivos WHERE id=$id";
        $datos = parent::obtenerDatos($query);
        return  $datos;
    }
    public function getByDad($dad){
        $query = "SELECT * FROM archivos WHERE dad=$dad";
        $datos = parent::obtenerDatos($query);
        return  $datos;
    }

}


?>