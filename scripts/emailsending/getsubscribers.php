<?php

require_once("../../../../../wp-load.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../exceptions/incorrectvariableformatexception.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/userstrait.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/database/models/users.php");

use Newsletter\Classes\Database\Models\Users;
use Newsletter\Classes\Database\ModelErrors as Me;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;

$response = [
    C::KEY_DONE => false,'empty' => false, 'msg' => '','subscribers' => [] 
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    try{
        $users_data = ['tableName' => C::TABLE_USERS];
        $users = new Users($users_data);
        $users_where = ['subscribed' => 1];
        $users_array = $users->getUsers($users_where);
        //echo "GetSubscribers users_array => ".var_export($users_array,true)."\r\n";
        $usersE = $users->getErrno();
        //echo "GetSubscribers errno => ".var_export($usersE,true)."\r\n";
        switch($usersE){
            case 0:
                $response[C::KEY_DONE] = true;
                $response['subscribers'] = subscribeData($users_array);
                break;
            case Me::ERR_GET_NO_RESULT:
                http_response_code(404);
                $response['empty'] = true;
                $response['msg'] = "Nessun iscritto trovato";
                break;
            default:
                throw new Exception;
        }
    
    }catch(Exception $e){
        //echo "GetSubscribers exception => ".$e->getMessage()."\r\n";
        http_response_code(500);
        $response['msg'] = M::ERR_UNKNOWN;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

/**
 * Get the subscriber email and language list
 * @param array $users the array with User object to pick the needed values
 * @return array An array with user email/languages list
 */
function subscribeData(array $users): array{
    $subscribeData = [];
    foreach($users as $user){
        array_push($subscribeData,[
            'email' => $user->getEmail(), 'lang' => $user->getLang()
        ]);
    }
    return $subscribeData;
}
?>