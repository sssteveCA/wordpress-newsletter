<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Dotenv\Dotenv;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Exceptions\WrongCredentialsException;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Classes\Log\NewsletterLogManager;
use Newsletter\Classes\Log\NewsletterLogManagerErrors as Nlme;
use Newsletter\Exceptions\FileNotFoundException;

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
        $log_path = sprintf("%s/newsletter%s",WP_PLUGIN_DIR,C::REL_NEWSLETTER_LOG);
        $nlm = new NewsletterLogManager($log_path);
        $nlm->deleteFile();
        switch($nlm->getErrno()){
            case 0:
                $response = [ C::KEY_DONE => true, C::KEY_MESSAGE => 'Il contenuto del file di log è stato rimosso'];
                break;
            case Nlme::ERR_INVALID_FILE:
                throw new FileNotFoundException;
            case Nlme::ERR_DELETE_FILE:
                throw new FileNotDeletedException;
            default:
                throw new Exception;
        }
    }//if($authCheck->getErrno() == 0){
    else throw new WrongCredentialsException;
}catch(NotSettedException|WrongCredentialsException $e){
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}catch(FileNotFoundException $e){
    http_response_code(404);
    $response[C::KEY_MESSAGE] = 'Il file di log non è stato trovato';
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = 'Errore durante la cancellazione del file di log';
}

echo json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

?>