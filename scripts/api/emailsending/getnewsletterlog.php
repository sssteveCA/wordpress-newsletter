<?php
use Newsletter\Exceptions\FileNotFoundException;
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
        $nlm = new NewsletterLogManager(plugin_dir_path("newsletter/newsletter.php")."log_files/newsletter_status.log");
        switch($nlm->getErrno()){
            case 0:
                if($nlm->getFileSize() > 0){
                    $response = [
                        C::KEY_DONE => true, C::KEY_EMPTY => false, C::KEY_MESSAGE => '', 'loginfo' => $nlm->getLogInfo()
                    ];
                }//if($nlm->getFileSize() > 0){
                else $response = [
                    C::KEY_DONE => true, C::KEY_EMPTY => true, C::KEY_MESSAGE => 'Nessuna informazione presente nel file di log'
                ];
                break;
            case Nlme::ERR_INVALID_FILE:
                throw new FileNotFoundException;
            default:
                throw new Exception;
        }//switch($nlm->getErrno()){
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
    $response[C::KEY_MESSAGE] = 'Errore durante la lettura del file di log';
}

echo json_encode($response, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>