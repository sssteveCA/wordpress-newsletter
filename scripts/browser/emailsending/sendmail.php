<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Dotenv\Dotenv;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\MailNotSentException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    $input = file_get_contents("php://input");
    $post = json_decode($input,true);
    //$response['data'] = $post;
    if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
        if(is_array($post['emails']) && sizeof($post['emails']) > 0){
            try{
                if($post['subject'] == '')$post['subject'] = ' '; //Avoid display '(no subject)' in the sent mail
                $snData = [
                    'body' => $post['body'], 'emails' => $post['emails'], 'subject' => $post['subject']
                ];
                $emErrno = sendNewsletterMail($snData);
                switch($emErrno){
                    case 0:
                        $response[C::KEY_DONE] = true;
                        $response[C::KEY_MESSAGE] = "La mail è stata inviata a tutti i destinatari indicati";
                        break;
                    case Eme::ERR_EMAIL_SEND:
                        throw new MailNotSentException;
                    default:
                        throw new Exception;        
                }//switch($emErrno){
            }catch(NotSettedException $nse){
                http_response_code(400);
                $response[C::KEY_MESSAGE] = $nse->getMessage();
            }catch(MailNotSentException $mnse){
                http_response_code(500);
                $response[C::KEY_MESSAGE] = "Errore durante l'invio della mail ad uno o più destinatari indicati";
            }catch(Exception $e){
                http_response_code(500);
                $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
            }
        }//if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
        else{
            http_response_code(400);
            $response[C::KEY_MESSAGE] = M::ERR_ATLEAST_ONE_EMAIL;
        }
    }//if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
    else{
        http_response_code(400);
        $response[C::KEY_MESSAGE] = M::ERR_MISSING_FORM_VALUES;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

function sendNewsletterMail(array $params):int {
    $dotEnv = Dotenv::createImmutable("../../");
    $dotEnv->safeLoad();
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