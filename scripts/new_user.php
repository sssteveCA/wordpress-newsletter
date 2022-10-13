<?php

require_once("../../wp-load.php");

$inputs = file_get_contents("php://input");
$post = json_decode($inputs,true);

$response = [
    'msg' => '',
    'done' => false
];

if(isset($post['email'],$post['cb_privacy'],$post['cb_terms'],$post['lang']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] && $post['lang'] != ''){

}//if(isset($post['email'],$post['cb_privacy'],$post['cb_terms'],$post['lang']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] && $post['lang'] != ''){

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>