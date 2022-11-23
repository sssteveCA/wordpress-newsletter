<?php

require_once("../../../../../wp-load.php");
require_once("../../interfaces/messages.php");

use Newsletter\Interfaces\Messages as M;

$response = [
    'done' => false, 'msg' => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    $input = file_get_contents("php://input");
    $post = json_decode($input,true);
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
}
?>