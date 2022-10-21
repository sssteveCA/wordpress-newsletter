<?php

require_once("../../wp-load.php");
require_once("../interfaces/constants.php");
require_once("../interfaces/messages.php");
require_once("../exceptions/notsettedexception.php");
require_once("../traits/errortrait.php");
require_once("../traits/sqltrait.php");
require_once("../traits/usercommontrait.php");
require_once("../traits/usertrait.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Properties;

$inputs = file_get_contents("php://input");
$post = json_decode($inputs,true);

//var_dump($post);

$response = [
    'msg' => '',
    'done' => false
];

if(isset($post['email'],$post['cb_privacy'],$post['cb_terms'],$post['lang']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] == '1' && $post['lang'] != ''){
    $user_data = [
        'tableName' => C::TABLE_USERS,'email' => $post['email'], 'lang' => $post['lang']
    ];
    //var_dump($user_data);
    try{
        $user = new User($user_data);
        $user->insertUser();
        $userE = $user->getErrno();
        switch($userE){
            case 0:
                $response['msg'] = Properties::subscribeCompleted($post['lang']);
                break;
            default:
                http_response_code(500);
                $response['msg'] = M::ERR_UNKNOWN;
                break;
        }
    }catch(NotSettedException $nse){
        echo "NotSettedException\r\n";
    }catch(Exception $e){
        echo "Exception\n";
        http_response_code(500);
        $response['msg'] = M::ERR_UNKNOWN;
    }
}//if(isset($post['email'],$post['cb_privacy'],$post['cb_terms'],$post['lang']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] && $post['lang'] != ''){
else{
    http_response_code(400);
    $response['msg'] = M::ERR_MISSING_FORM_VALUES;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>