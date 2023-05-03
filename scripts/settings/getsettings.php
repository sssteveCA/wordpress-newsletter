<?php
use Newsletter\Classes\Database\Models\Settings;

require_once("../../../../../wp-load.php");
require_once("../../vendor/autoload.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    try{
        $settings = new Settings([]);
        $settings->getSettings();
        if($settings->getErrno() == 0){

        }//if($settings->getErrno() == 0){
        else{
            
        }
    }catch(Exception $e){
        http_response_code(500);
        $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);


?>