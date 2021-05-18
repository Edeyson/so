<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';


class put extends conexion{
    public function modify($json){
        $_respuestas = new respuesta;
        $datos = json_decode($json, true);

        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken($this->token);
            if($arrayToken){
                if(!isset($datos['id']) ||!isset($datos['name']) ||!isset($datos['dad'])){
                    return $_respuestas->error_400();
                }else{
                    // todo esta bien
                    $id = $datos['id'];
                    $name = $datos['name'];
                    $dad = $datos['dad'];
                    if($this->buscarId($id)){
                        if( $this->buscarDad($dad, $id)){
                            $this->edidar($name, $id, $dad);
                        }else{
                            return $_respuestas->error_200("el destino a donde intenta mover no existe");
                        }
                    }else{
                        return $_respuestas->error_200("el archivo que intenta modificar no existe");
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
    private function buscarDad($dad, $id){
        if($dad!==$id){
            $query = "SELECT * FROM archivos WHERE id=$dad";
            $datos = parent::obtenerDatos($query);
            if($datos){
                return true;    
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }
    private function edidar($name, $id, $dad){
        $query = "UPDATE archivos SET name='$name', dad=$dad WHERE id=$id";
        $datos = parent::nonQuery($query);
        echo "archivo modificado con exito";
        print_r($datos);
    }
    

}

?>