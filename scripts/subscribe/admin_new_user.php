<?php

require_once("../../config/cors.php");
require_once("../../../../../wp-load.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/subscribetrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");

use Newsletter\Classes\Database\Models\User;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Interfaces\Constants as C;

$response = [
    'done' => false, 'msg' => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    $input = file_get_contents("php://input");
    $post = json_decode($input,true);
    if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
        $userData = [
            'tableName' => C::TABLE_USERS, 'email' => $post['email'], 'lang' => $post['lang_code']
        ];
        if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
            $userData['firstName'] = $post['name'];
            $userData['lastName'] = $post['lastName'];
        }//if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
        try{
            $user = new User($userData);
        }catch(Exception $e){
            http_response_code(500);
            $response['msg'] = M::ERR_ADMIN_NEW_USER_UNKNOWN;
        }
    }//if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
    else{
        http_response_code(400);
        $response['msg'] = M::ERR_MISSING_FORM_VALUES;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
}
?>