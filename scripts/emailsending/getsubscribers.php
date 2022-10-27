<?php

require_once("../../../wp-load.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../exceptions/incorrectvariableformatexception.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/userstrait.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/models.php");
require_once("../../classes/database/models/users.php");

use Newsletter\Classes\Database\Models\Users;
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
    $users_array = $users->getUsers([]);
    $usersE = $users->getErrno();
    switch($usersE){
        case 0:
            break;
        default:
            break;
    }

}catch(Exception $e){
    http_response_code(500);
    $response['msg'] = M::ERR_UNKNOWN;
}



echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>