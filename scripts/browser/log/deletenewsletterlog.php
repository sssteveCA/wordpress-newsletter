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

    }catch(Exception $e){
        
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

?>