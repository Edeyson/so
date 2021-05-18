<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';


class delete extends conexion{
    public function delete($json){
        $_respuestas = new respuesta;
        $datos = json_decode($json, true);


        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken($this->token);
            if($arrayToken){
                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    // todo esta bien
                    $id = $datos['id'];
                    if($this->buscarId($id)){
                       $this->eliminar($id);
                    }else{
                        return $_respuestas->error_200("el archivo que intenta eliminar no existe");
                    }
                }
            }else{
                return $_respuestas->error_401("el token que envio es invalido o ha caducado");
            }
        }

        
    }
    private function buscarToken($token){
        $query =  "SELECT * FROM tokens WHERE token = '$token' AND estado='Activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;    
        }else{
            return 0;
        }
    }
    private function buscarId($id){
        $query = "SELECT * FROM archivos WHERE id=$id";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return true;    
        }else{
            return false;
        }   
    }
  
    private function eliminar($id){
        $query = "DELETE FROM archivos WHERE id=$id";
        $datos = parent::nonQuery($query);
        echo "archivo $id eliminado con exito";
        print_r($datos);
    }
    

}

?>