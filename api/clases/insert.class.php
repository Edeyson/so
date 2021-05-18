<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class insert extends conexion{
    private $token="";
    //b6b0496e72b2551d9f02f8c92e7496e3
    public function insert($json){
        $_respuestas = new respuesta;
        $datos = json_decode($json, true);


        if(!isset($datos['token'])){
            return $_respuestas->error_401();
        }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken($this->token);
            if($arrayToken){
                if(!isset($datos['name']) || !isset($datos['type']) || !isset($datos['dad'])){
                    //error en los campos
                    return $_respuestas->error_400();
                }else{
                    // todo esta bien
                    $name = $datos['name'];
                    $type = $datos['type'];
                    $dad = $datos['dad'];
                    if($this->buscarDad($dad)){
                        $this->crearArchivo($name, $type,$dad);
                    }else{
                        return $_respuestas->error_200("padre incorrecto");
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
    private function actualizarToken($tokenId){
        $date = date("Y-m-d H:i");
        $query = "UPDATE tokens SET fecha='$date' WHERE id='$tokenId'";
        $resp = parent::nonQuery($query);
        if($resp>=1){
            return $resp;
        }else{
            return 0;
        }
    }


    private function buscarDad($dad){
        $query = "SELECT * FROM archivos WHERE id=$dad";
        $datos = parent::obtenerDatos($query);
        if($datos){
            return true;    
        }else{
            return false;
        }
        
    }

    private function crearArchivo($name, $type, $dad){
        $query = "INSERT INTO archivos (name, type, dad) VALUES ('$name', '$type', $dad)";
        $datos = parent::nonQuery($query);
        echo "registrado con exito";
        print_r($datos);
    }
}



?>