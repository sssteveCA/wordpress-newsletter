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
    'done' => false,
    'msg' => '',
    'subscribers' => [] 
];

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
            $response['done'] = true;
            $response['subscribers'] = subscribeData($users_array);
            break;
        case Me::ERR_GET_NO_RESULT:
            http_response_code(404);
            $response['msg'] = "Nessun iscritto trovato";
            break;
        default:
            http_response_code(500);
            $response['msg'] = M::ERR_UNKNOWN;
            break;
    }

}catch(Exception $e){
    //echo "GetSubscribers exception => ".$e->getMessage()."\r\n";
    http_response_code(500);
    $response['msg'] = M::ERR_UNKNOWN;
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