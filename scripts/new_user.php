<?php

require_once("../../wp-load.php");
require_once("../enums/languages.php");
require_once("../interfaces/exceptionmessages.php");
require_once("../interfaces/constants.php");
require_once("../interfaces/messages.php");
require_once("../exceptions/notsettedexception.php");
require_once("../traits/errortrait.php");
require_once("../traits/properties/messages/othertrait.php");
require_once("../traits/properties/messages/newusertrait.php");
require_once("../traits/properties/messages/verifytrait.php");
require_once("../traits/properties/propertiesmessagestrait.php");
require_once("../traits/properties/propertiesurltrait.php");
require_once("../traits/sqltrait.php");
require_once("../traits/modeltrait.php");
require_once("../traits/usercommontrait.php");
require_once("../traits/usertrait.php");
require_once("../classes/general.php");
require_once("../classes/properties.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");
require_once("../classes/subscribe/usersubscribe.php");

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\General;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Subscribe\UserSubscribeError as Usee;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\UserSubscribe;

$inputs = file_get_contents("php://input");
$post = json_decode($inputs,true);

//var_dump($post);

$response = [
    'msg' => '',
    'done' => false
];

if(!isset($post['lang'])) $post['lang'] = 'en';
$lang = General::languageCode($post['lang']);

if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] == '1'){
    $user_data = [
        'tableName' => C::TABLE_USERS,'email' => $post['email'], 'lang' => $lang
    ];
    //var_dump($user_data);
    try{
        $user = new User($user_data);
        $us_data = [
            'user' => $user
        ];
        $userSubscribe = new UserSubscribe($us_data);
        $us_error = $userSubscribe->getErrno();
        switch($us_error){
            case 0:
                $response['msg'] = Properties::completeSubscribe($lang);
                $response['done'] = true;
                break;
            case Usee::INCORRECT_EMAIL:
                http_response_code(400);
                $response['msg'] = Properties::wrongEmailFormat($lang);
                break;
            case Usee::EMAIL_EXISTS:
                http_response_code(400);
                $response['msg'] = Properties::emailExists($lang);
                break;
            default:
                http_response_code(500);
                $response['msg'] = Properties::unknownError($lang);
                break;
        }
    }catch(NotSettedException $nse){
        echo "NotSettedException\r\n";
    }catch(Exception $e){
        echo "Exception\n";
        http_response_code(500);
        $response['msg'] = Properties::unknownError($lang);
    }
}//if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms']){
else{
    http_response_code(400);
    $response['msg'] = Properties::missingFormValues($lang);
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>