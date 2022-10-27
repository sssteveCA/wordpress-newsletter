<?php

require_once("../../../wp-load.php");
require_once("../../interfaces/messages.php");

use Newsletter\Interfaces\Messages as M;

$response = [
    'done' => false, 'msg' => ''
];

$input = file_get_contents("php://input");
$post = json_decode($input,true);

if(isset($post['emails'],$post['from'],$post['password'],$post['subject'],$post['body']) && $post['from'] != '' && $post['password'] != '' && $post['body'] != ''){
    if(is_array($post['emails'] && sizeof($post['emails']) > 0)){

    }//if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
}//if(isset($post['emails'],$post['from'],$post['password'],$post['subject'],$post['body']) && $post['from'] != '' && $post['password'] != '' && $post['body'] != ''){
else{
    http_response_code(400);
    $response['msg'] = M::ERR_MISSING_FORM_VALUES;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>