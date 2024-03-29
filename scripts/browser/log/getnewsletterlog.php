<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Log\NewsletterLogManager;
use Newsletter\Classes\Log\NewsletterLogManagerErrors as Nlme;
use Newsletter\Exceptions\FileNotFoundException;

$response = [
    C::KEY_DONE => false, C::KEY_EMPTY => false, C::KEY_MESSAGE => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    try{
        $log_path = sprintf("%s/newsletter%s",WP_PLUGIN_DIR,C::REL_NEWSLETTER_LOG);
        $nlm = new NewsletterLogManager($log_path);
        $nlm->readFile();
        switch($nlm->getErrno()){
            case 0:
                if($nlm->getFileSize() > 0){
                    $log_info_array = $nlm->getLogInfoAssociative();
                    $response = [
                        C::KEY_DONE => true, C::KEY_EMPTY => false, C::KEY_MESSAGE => '', 'loginfo' => $log_info_array
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
    }catch(FileNotFoundException $e){
    http_response_code(404);
    $response[C::KEY_MESSAGE] = 'Il file di log non è stato trovato';
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = 'Errore durante la lettura del file di log';
}
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);


?>