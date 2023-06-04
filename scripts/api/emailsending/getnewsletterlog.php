<?php
use Newsletter\Classes\Api\AuthCheck;

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Dotenv\Dotenv;
use Newsletter\Exceptions\NotSettedException;

$response = [
    C::KEY_DONE => false, C::KEY_EMPTY => false, C::KEY_MESSAGE => ''
];

try{
    $dotenv = Dotenv::createImmutable("../../../../");
    $dotenv->load();
    $apiAuthArray = [
        'username' => $_SERVER['PHP_AUTH_USER'],
        'password' => $_SERVER['PHP_AUTH_PW'],
        'uuid' => $_ENV['API_REST_UUID']
    ];
    $authCheck = new AuthCheck($apiAuthArray);
    if($authCheck->getErrno() == 0){

    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
    }
}catch(NotSettedException $nse){
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
}

echo json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>