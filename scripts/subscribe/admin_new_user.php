<?php

require_once("../../config/cors.php");
require_once("../../../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../interfaces/subscribeerrors.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../exceptions/incorrectvariableformatexception.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/subscribetrait.php");
require_once("../../traits/templatetrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/general.php");
require_once("../../classes/properties.php");
require_once("../../classes/template.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/subscribe/adminusersubscribe.php");

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\AdminUserSubscribe;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\AdminUserSubscribeErrors as Ause;
use Newsletter\Enums\Langs;

$response = [
    'done' => false, 'msg' => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

//if($logged && $administrator){
    $input = file_get_contents("php://input");
    $post = json_decode($input,true);
    if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
        $userData = [
            'tableName' => C::TABLE_USERS, 'email' => $post['email'], 'lang' => $post['lang_code']
        ];
        if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
            $userData['firstName'] = $post['name'];
            $userData['lastName'] = $post['surname'];
        }//if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
        try{
            //echo "Admin new User userData => ".var_export($userData,true)."\r\n";
            $user = new User($userData);
            $ausData = ['user' => $user];
            $aus = new AdminUserSubscribe($ausData);
            $ausError = $aus->getErrno();
            switch($ausError){
                case 0:
                    $response['done'] = true;
                    $response['msg'] = "L'utente inserito è stato aggiunto alla lista degli iscritti";
                    break;
                case Ause::INCORRECT_EMAIL:
                    http_response_code(400);
                    $response['msg'] = Properties::wrongEmailFormat(Langs::$langs["it"]);
                    break;
                case Ause::EMAIL_EXISTS:
                    http_response_code(400);
                    $response['msg'] = Properties::emailExists(Langs::$langs["it"]);
                    break;
                default:
                    http_response_code(500);
                    $response['msg'] = M::ERR_ADMIN_NEW_USER_UNKNOWN;
                    break;
            }
        }catch(Exception $e){
            http_response_code(500);
            $response['msg'] = M::ERR_ADMIN_NEW_USER_UNKNOWN;
        }
    }//if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
    else{
        http_response_code(400);
        $response['msg'] = M::ERR_MISSING_FORM_VALUES;
    }
/* }//if($logged && $administrator){
else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
} */

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>