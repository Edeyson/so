<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class auth extends conexion{
    public function login($json){
        $_respuestas = new respuesta;
        $datos = json_decode($json, true);
        if(!isset($datos['email']) || !isset($datos['password'])){
            //error de campos
            return $_respuestas->error_400();
        }else{
            //todo esta bien
            $email = $datos['email'];
            $password = $datos['password'];
            $datosLog = $this->obdtenerDatosUsuario($email);
            if($datosLog){
                if($password == $datosLog[0]['password']){
                    // crear token
                    $verificar = $this->insertarToken($datosLog[0]['id']);
                    if($verificar){
                        // se guardo
                        $result = $_respuestas->response;
                        $result['result']= array(
                            "token" => $verificar
                        );
                        return $result;
                    }else{
                        // error al guardar
                        return $_respuestas->error_500("Error interno, no hemos podido guardar");
                    }
                    
                }
                else{
                    return $_respuestas->error_200("contraseña incorrecta");
                }
            }else{
                return $_respuestas->error_200("el usuario $email no existe");
            }
        }
    }

    private function obdtenerDatosUsuario($email){
        $query = "SELECT * FROM usersadmin WHERE email='$email'";
        $datos = parent::obtenerDatos($query);
        if(isset($datos[0]['id'])){
            return $datos;
        }else{
            return false;
        }
    }
    
    private function insertarToken($userId){
        $val = TRUE;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("Y-m-d H:i");
        $estado = "Activo";
        $query = "INSERT INTO tokens (usuarioId, token, estado, fecha) VALUES ('$userId', '$token', '$estado','$date')";
        $verifica = parent::nonQuery($query);
        if($verifica){
            return $token;
        }else{
            return 0;
        }
    }
    
}


?>