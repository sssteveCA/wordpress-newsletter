<?php

require_once("../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../interfaces/messages.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../vendor/autoload.php");
require_once("../../traits/properties/messages/activationmailtrait.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/userstrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../classes/properties.php");
require_once("../../classes/template.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/database/models/users.php");
require_once("../../classes/email/emailmanager.php");

use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Dotenv\Dotenv;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\NotSettedException;

$response = [
    'done' => false, 'msg' => ''
];

$input = file_get_contents("php://input");
$post = json_decode($input,true);

if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
    if(is_array($post['emails']) && sizeof($post['emails']) > 0){
        try{
            $dotEnv = Dotenv::createImmutable("./../../");
            $dotEnv->safeLoad();
            $from = isset($post['from']) ? $post['from'] : $_ENV['EMAIL_USERNAME'];
            $host = isset($post['host']) ? $post['host'] : $_ENV['EMAIL_HOST'];
            $password = isset($post['password']) ? $post['password'] : $_ENV['EMAIL_PASSWORD'];
            $port = isset($post['port']) ? $post['port'] : $_ENV['EMAIL_PORT'];
            $em_data = [
                'body' => $post['body'], 'from' => $from, 'emails' => $post['emails'], 
                'host' => $host, 'password' => $password, 'port' => $port, 'subject' => $post['subject']
            ];
            $emailManager = new EmailManager($em_data);
            $emailManager->sendNewsletterMail();
            $emErrno = $emailManager->getErrno();
            switch($emErrno){
                case 0:
                    $response['done'] = true;
                    $response['msg'] = "La mail è stata inviata a tutti i destinatari indicati";
                    break;
                case Eme::ERR_EMAIL_SEND:
                    http_response_code(400);
                    $response['msg'] = $emailManager->getError();
                    break;
                default:
                    http_response_code(500);
                    $response['msg'] = M::ERR_UNKNOWN;          
            }//switch($emErrno){
        }catch(NotSettedException $nse){
            http_response_code(400);
            $response['msg'] = $nse->getMessage();
        }catch(Exception $e){
            http_response_code(500);
            $response['msg'] = M::ERR_UNKNOWN;
        }
    }//if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
    else{
        http_response_code(400);
        $response['msg'] = "Inserisci almeno un indirizzo email";
    }
}//if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
else{
    http_response_code(400);
    $response['msg'] = M::ERR_MISSING_FORM_VALUES;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>