<?php

require_once("../../../../../../wp-load.php");
require_once("../../../interfaces/constants.php");
require_once("../../../interfaces/messages.php");
require_once("../../../interfaces/exceptionmessages.php");
require_once("../../../exceptions/incorrectvariableformatexception.php");
require_once("../../../exceptions/notsettedexception.php");
require_once("../../../vendor/autoload.php");
require_once("../../../traits/errortrait.php");
require_once("../../../traits/modeltrait.php");
require_once("../../../traits/sqltrait.php");
require_once("../../../traits/usercommontrait.php");
require_once("../../../traits/usertrait.php");
require_once("../../../traits/userstrait.php");
require_once("../../../classes/database/tables/table.php");
require_once("../../../classes/database/model.php");
require_once("../../../classes/database/models.php");
require_once("../../../classes/database/models/user.php");
require_once("../../../classes/database/models/users.php");
require_once("../../../classes/api/authcheck.php");

use Newsletter\Classes\Database\Models\Users;
use Newsletter\Classes\Database\ModelErrors as Me;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Dotenv\Dotenv;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Exceptions\NotSettedException;

$response = [
    'done' => false,'empty' => false, 'msg' => '','subscribers' => [] 
];

try{
    $dotenv = Dotenv::createImmutable("../../../");
    $dotenv->load();
    $apiAuthArray = [
        'username' => $_SERVER['PHP_AUTH_USER'],
        'password' => $_SERVER['PHP_AUTH_PW'],
        'uuid' => $_ENV['API_REST_UUID']
    ];
    $authCheck = new AuthCheck($apiAuthArray);
    if($authCheck->getErrno() == 0){
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
                $response['empty'] = true;
                $response['msg'] = "Nessun iscritto trovato";
                break;
            default:
                throw new Exception;
        }
    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response['msg'] = M::ERR_UNAUTHORIZED;
    }
}catch(NotSettedException $nse){
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
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