<?php

class respuesta{
    public $response = [
        'status' => "ok",
        "result" => array()
    ];

    public function error_405(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        return $this->response;
    }
    public function error_200($valor = "datos incorrectos"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_400(){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos o formato incorrecto"
        );
        return $this->response;
    }
    public function error_500($valor = "error interno del servidor"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        return $this->response;
    }

    public function error_401($valor = "no autorizado"){
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $valor
        );
        return $this->response;
    }

}




?>