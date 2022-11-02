<?php

require_once("../../../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/templatetrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/properties.php");
require_once("../../classes/template.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/email/emailmanager.php");

use Dotenv\Dotenv;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;

$input = file_get_contents("php://input");
$post = json_decode($input,true);

$response = [
    'done' => false, 'msg' => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    if(isset($post['emails']) && sizeof($post['emails']) > 0){
        if(is_array($post['emails']) && sizeof($post['emails']) > 0){
            $sdData = [
                'body' => '', 'emails' => $post['emails'], 'operation' => EmailManager::EMAIL_USER_DELETE, 'subject' => ''
            ];
            try{
                $emErrno = sendDeleteUserNotify($sdData);
                switch($emErrno){
                    case 0:
                        $response['done'] = true;
                        $response['msg'] = "I contatti indicati sono stati rimossi dalla lista degli iscritti";
                        break;
                    case Eme::ERR_EMAIL_SEND:
                        http_response_code(400);
                        $response['msg'] = $emailManager->getError();
                        break;
                    default:
                        http_response_code(500);
                        $response['msg'] = M::ERR_UNKNOWN;
                        break;
                }
            }catch(NotSettedException $nse){
                http_response_code(400);
                $response['msg'] = $nse->getMessage();
            }catch(Exception $e){
                http_response_code(500);
                $response['msg'] = M::ERR_UNKNOWN;
            }
        }//if(is_array($post['emails']) && sizeof($post['emails']) > 0){
        else{
            http_response_code(400);
            $response['msg'] = M::ERR_ATLEAST_ONE_EMAIL;
        }
    }//if(isset($post['emails']) && sizeof($post['emails']) > 0){
    else{
        http_response_code(400);
        $response['msg'] = M::ERR_MISSING_FORM_VALUES;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

function sendDeleteUserNotify(array $params):int {
    $dotenv = Dotenv::createImmutable("../../");
    $dotenv->safeLoad();
    $from = isset($params['from']) ? $params['from'] : $_ENV['EMAIL_USERNAME'];
    $fromNickname = isset($params['fromNickname']) ? $params['fromNickname'] : $_ENV['EMAIL_NICKNAME'];
    $host = isset($params['host']) ? $params['host'] : $_ENV['EMAIL_HOST'];
    $password = isset($params['password']) ? $params['password'] : $_ENV['EMAIL_PASSWORD'];
    $port = isset($params['port']) ? $params['port'] : $_ENV['EMAIL_PORT'];
    $emData = [
        'body' => $params['body'], 'from' => $from, 'emails' => $params['emails'], 
        'fromNickname' => $fromNickname, 'host' => $host, 'operation' => $params['operation'],
        'password' => $password, 'port' => $port, 'subject' => $params['subject']
    ];
    $emailManager = new EmailManager($emData);
    $emailManager->sendDeleteUserNotify();
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>

