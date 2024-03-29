<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Dotenv\Dotenv;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Exceptions\MailNotSentException;

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    $input = file_get_contents("php://input");
    $post = json_decode($input,true);
    if(isset($post['emails']) && sizeof($post['emails']) > 0){
        if(is_array($post['emails']) && sizeof($post['emails']) > 0){
            $sdData = [
                'body' => '', 'emails' => $post['emails'], 'operation' => EmailManager::EMAIL_USER_DELETE, 'subject' => ''
            ];
            try{
                $emErrno = sendDeleteUserNotify($sdData);
                switch($emErrno){
                    case 0:
                        $response[C::KEY_DONE] = true;
                        $response[C::KEY_MESSAGE] = "I contatti indicati sono stati rimossi dalla lista degli iscritti";
                        break;
                    case Eme::ERR_EMAIL_SEND:
                        throw new MailNotSentException;
                    default:
                        throw new Exception;
                }
            }catch(NotSettedException $nse){
                http_response_code(400);
                $response[C::KEY_MESSAGE] = $nse->getMessage();
            }catch(MailNotSentException $mnse){
                http_response_code(500);
                $response[C::KEY_MESSAGE] = "Errore durante l'invio della mail di notifica all'utente rimosso";
            }catch(Exception $e){
                http_response_code(500);
                $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
            }
        }//if(is_array($post['emails']) && sizeof($post['emails']) > 0){
        else{
            http_response_code(400);
            $response[C::KEY_MESSAGE] = M::ERR_ATLEAST_ONE_EMAIL;
        }
    }//if(isset($post['emails']) && sizeof($post['emails']) > 0){
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

function sendDeleteUserNotify(array $params):int {
    $dotenv = Dotenv::createImmutable("../../../");
    $dotenv->load();
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

