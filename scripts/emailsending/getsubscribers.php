<?php

require_once("../../../../../wp-load.php");
require_once("../../vendor/autoload.php");

use Newsletter\Classes\Database\Models\Users;
use Newsletter\Classes\Database\ModelErrors as Me;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;

$response = [
    C::KEY_DONE => false, C::KEY_EMPTY => false, C::KEY_MESSAGE => '','subscribers' => [] 
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
        $usersE = $users->getErrno();
        switch($usersE){
            case 0:
                $response[C::KEY_DONE] = true;
                $response['subscribers'] = subscribeData($users_array);
                break;
            case Me::ERR_GET_NO_RESULT:
                http_response_code(404);
                $response[C::KEY_EMPTY] = true;
                $response[C::KEY_MESSAGE] = "Nessun iscritto trovato";
                break;
            default:
                throw new Exception;
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