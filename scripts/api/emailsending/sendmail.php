<?php

require_once("../../../../../../wp-load.php");
require_once("../../../enums/languages.php");
require_once("../../../interfaces/constants.php");
require_once("../../../interfaces/exceptionmessages.php");
require_once("../../../interfaces/messages.php");
require_once("../../../exceptions/notsettedexception.php");
require_once("../../../exceptions/mailnotsentexception.php");
require_once("../../../vendor/autoload.php");
//require_once("../../traits/properties/messages/activationmailtrait.php");
require_once("../../../traits/properties/messages/newusertrait.php");
require_once("../../../traits/properties/messages/othertrait.php");
require_once("../../../traits/properties/messages/unsubscribetrait.php");
require_once("../../../traits/properties/messages/verifytrait.php");
require_once("../../../traits/properties/propertiesmessagestrait.php");
require_once("../../../traits/properties/propertiesurltrait.php");
//require_once("../../traits/properties/propertiesvaluestrait.php");
require_once("../../../traits/emailmanagertrait.php");
require_once("../../../traits/templatetrait.php");
require_once("../../../traits/errortrait.php");
require_once("../../../traits/modeltrait.php");
require_once("../../../traits/sqltrait.php");
require_once("../../../traits/usertrait.php");
require_once("../../../traits/userstrait.php");
require_once("../../../traits/usercommontrait.php");
require_once("../../../classes/properties.php");
require_once("../../../classes/template.php");
require_once("../../../classes/database/tables/table.php");
require_once("../../../classes/database/model.php");
require_once("../../../classes/database/models.php");
require_once("../../../classes/database/models/user.php");
require_once("../../../classes/database/models/users.php");
require_once("../../../classes/email/emailmanager.php");
require_once("../../../classes/api/authcheck.php");

use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Dotenv\Dotenv;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\NotSettedException;

$response = [
    'done' => false, 'msg' => ''
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
        $input = file_get_contents("php://input");
        $post = json_decode($input,true);
        //$response['data'] = $post;
        if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
            if(is_array($post['emails']) && sizeof($post['emails']) > 0){
                $snData = [
                    'body' => $post['body'], 'emails' => $post['emails'], 'subject' => $post['subject']
                ];
                $emErrno = sendNewsletterMail($snData);
                switch($emErrno){
                    case 0:
                        $response['done'] = true;
                        $response['msg'] = "La mail ?? stata inviata a tutti i destinatari indicati";
                        break;
                    case Eme::ERR_EMAIL_SEND:
                        http_response_code(400);
                        $response['msg'] = $emailManager->getError();
                        break;
                    default:
                        throw new Exception;    
                }//switch($emErrno){
            }//if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
            else{
                http_response_code(400);
                $response['msg'] = M::ERR_ATLEAST_ONE_EMAIL;
            }
        }//if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
        else{
            http_response_code(400);
            $response['msg'] = M::ERR_MISSING_FORM_VALUES;
        }
    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response["msg"] = M::ERR_UNAUTHORIZED;
    }
}catch(NotSettedException $nse){
    http_response_code(400);
    $response['msg'] = M::ERR_UNAUTHORIZED;
}catch(Exception $e){
    http_response_code(500);
    $response['msg'] = M::ERR_UNKNOWN;
}
    

//}//if($logged && $administrator){
/* else{
    http_response_code(401);
    $response['msg'] = M::ERR_UNAUTHORIZED;
} */

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

function sendNewsletterMail(array $params):int {
    $from = isset($params['from']) ? $params['from'] : $_ENV['EMAIL_USERNAME'];
    $fromNickname = isset($params['fromNickname']) ? $params['fromNickname'] : $_ENV['EMAIL_NICKNAME'];
    $host = isset($params['host']) ? $params['host'] : $_ENV['EMAIL_HOST'];
    $password = isset($params['password']) ? $params['password'] : $_ENV['EMAIL_PASSWORD'];
    $port = isset($params['port']) ? $params['port'] : $_ENV['EMAIL_PORT'];
    $em_data = [
        'body' => $params['body'], 'from' => $from, 'fromNickname' => $fromNickname, 'emails' => $params['emails'], 
        'host' => $host, 'password' => $password, 'port' => $port, 'subject' => $params['subject']
    ];
    $emailManager = new EmailManager($em_data);
    $emailManager->sendNewsletterMail();
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>