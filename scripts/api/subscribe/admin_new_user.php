<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");


use Dotenv\Dotenv;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Classes\General;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\AdminUserSubscribe;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\AdminUserSubscribeErrors as Ause;
use Newsletter\Enums\Langs;
use Newsletter\Exceptions\MailNotSentException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

$input = file_get_contents("php://input");
$post = json_decode($input,true);

if(!isset($post['lang'])) $post['lang'] = 'en';
$lang = General::languageCode($post['lang']);

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
        if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
            $userData = [
                'tableName' => C::TABLE_USERS, 'email' => trim($post['email']), 'lang' => $post['lang_code']
            ];
            if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
                $userData['firstName'] = $post['name'];
                $userData['lastName'] = $post['surname'];
            }//if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
            //echo "Admin new User userData => ".var_export($userData,true)."\r\n";
            $user = new User($userData);
            $ausData = ['user' => $user];
            $aus = new AdminUserSubscribe($ausData);
            $ausError = $aus->getErrno();
            switch($ausError){
                case 0:
                    $operation = EmailManager::EMAIL_USER_ADD_ADMIN;
                    $aumData = ['email' => $aus->getUser()->getEmail(),
                                'lang' => $aus->getUser()->getLang(), 
                                'operation' => $operation
                    ];
                    $email = sendSigningUpNotify($aumData);
                    switch($email){
                        case 0:
                            $response[C::KEY_DONE] = true;
                            $response[C::KEY_MESSAGE] = "L'utente inserito è stato aggiunto alla lista degli iscritti";
                            break;
                        case Eme::ERR_EMAIL_SEND:
                            $query = "WHERE `".User::$fields["email"]."` = %s";
                            $values = [$user->getEmail()];
                            $user->deleteUser($query,$values);
                            throw new MailNotSentException;
                        default:
                            throw new Exception;      
                    }
                    break;
                case Ause::INCORRECT_EMAIL:
                    http_response_code(400);
                    $response[C::KEY_MESSAGE] = Properties::wrongEmailFormat(Langs::$langs["it"]);
                    break;
                case Ause::EMAIL_EXISTS:
                    http_response_code(400);
                    $response[C::KEY_MESSAGE] = Properties::emailExists(Langs::$langs["it"]);
                    break;
                default:
                    http_response_code(500);
                    $response[C::KEY_MESSAGE] = "Impossibile aggiungere l'utente inserito a causa di un errore sconosciuto";
                    break;
            }
        }//if(isset($post['email'],$post['lang_code']) && $post['email'] != '' && $post['lang_code'] != ''){
        else{
            http_response_code(400);
            $response[C::KEY_MESSAGE] = M::ERR_MISSING_FORM_VALUES;
        }
    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
    }
}catch(NotSettedException $nse){
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}catch(MailNotSentException $mnse){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = "Impossibile inviare l'email all'utente inserito a causa di un errore sconosciuto";
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = "Impossibile aggiungere l'utente inserito a causa di un errore sconosciuto";
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

/**
 * Send the mail to notify the user of the subscription
 * @param array an array of values for mail signing up notify template
 * @return int the error code or 0 if no error occurs while email sending
 */
function sendSigningUpNotify(array $params): int{
    $from = isset($params['from']) ? $params['from'] : $_ENV['EMAIL_USERNAME'];
    $fromNickname = isset($params['fromNickname']) ? $params['fromNickname'] : $_ENV['EMAIL_NICKNAME'];
    $host = isset($params['host']) ? $params['host'] : $_ENV['EMAIL_HOST'];
    $password = isset($params['password']) ? $params['password'] : $_ENV['EMAIL_PASSWORD'];
    $port = isset($params['port']) ? $params['port'] : $_ENV['EMAIL_PORT'];
    $emData = [
        'from' => $from, 'email' => $params['email'], 'fromNickname' => $fromNickname,
        'host' => $host, 'operation' => $params['operation'],
        'password' => $password, 'port' => $port, 'subject' => ''
    ];
    $emailManager = new EmailManager($emData);
    $addUserMailData = [ 'lang' => $params['lang']];
    $emailManager->sendAddUserNotify($addUserMailData);
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>