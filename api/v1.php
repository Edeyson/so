<?php

require_once 'clases/insert.class.php';
require_once 'clases/respuestas.class.php';
require_once 'clases/get.class.php';
require_once 'clases/put.class.php';
require_once 'clases/delete.class.php';

$_insert = new insert;
$_respuesta = new respuesta;
$_gett = new get;
$_putt = new put;
$_deletet = new delete;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //_-------------------------------------------------------

    if (isset($_GET['id'])) {
        $datoId = $_GET['id'];
        $datos = $_gett->getOne($datoId);
        header('Content-Type: application/json');
        echo json_encode($datos);
        http_response_code(200);
    } else if (isset($_GET['dad'])) {
        $datoDad = $_GET['dad'];
        $datos = $_gett->getByDad($datoDad);
        header('Content-Type: application/json');
        echo json_encode($datos);
        http_response_code(200);
    } else {
        $datos = $_gett->getAll();
        header('Content-Type: application/json');
        echo json_encode($datos);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') { //_-------------------------------------------------------
    //recibir datos
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_insert->insert($postBody);
    //Devolvemos respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') { //_-------------------------------------------------------

    //recibir datos
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_putt->modify($postBody);
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { //_-------------------------------------------------------
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_deletet->delete($postBody);
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuesta->error_405();
    echo json_encode($datosArray);
}
