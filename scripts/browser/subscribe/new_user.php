<?php

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Dotenv\Dotenv;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Classes\General;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\UserSubscribeError as Usee;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\UserSubscribe;
use Newsletter\Classes\Template;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Exceptions\MailNotSentException;

$inputs = file_get_contents("php://input");
$post = json_decode($inputs,true);

//var_dump($post);

$response = [
    C::KEY_DONE => false,
    C::KEY_MESSAGE => '',
];

if(!isset($post['lang'])) $post['lang'] = 'en';
$lang = General::languageCode($post['lang']);

if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] == '1'){
    $userData = [
        'tableName' => C::TABLE_USERS,'email' => trim($post['email']), 'lang' => $lang
    ];
    if(isset($post['name'],$post['surname']) && $post['name'] != '' && $post['surname'] != ''){
        $userData['firstName'] = $post['name'];
        $userData['lastName'] = $post['surname'];
    }
    //var_dump($userData);
    try{
        $user = new User($userData);
        $usData = [
            'user' => $user
        ];
        $userSubscribe = new UserSubscribe($usData);
        $us_error = $userSubscribe->getErrno();
        switch($us_error){
            case 0:
                $verCode = $userSubscribe->getUser()->getVerCode();
                $email = $userSubscribe->getUser()->getEmail();
                $subject = Template::activationMailTitle($lang);
                $verifyUrl = Properties::verifyUrl();
                $link = $verifyUrl."?lang=".$lang."&verCode=".$verCode;
                $operation = EmailManager::EMAIL_ACTIVATION;
                $aeData = [
                    'verCode' => $verCode, 'email' => $email, 'lang' => $lang, 'link' => $link, 'operation' => $operation, 'subject' => $subject, 'verifyUrl' => $verifyUrl
                ];
                $email = sendActivationMail($aeData);
                switch($email){
                    case 0:
                        $response[C::KEY_MESSAGE] = Properties::completeSubscribe($lang);
                        $response[C::KEY_DONE] = true;
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
            case Usee::INCORRECT_EMAIL:
                http_response_code(400);
                $response[C::KEY_MESSAGE] = Properties::wrongEmailFormat($lang);
                break;
            case Usee::EMAIL_EXISTS:
                http_response_code(400);
                $response[C::KEY_MESSAGE] = Properties::emailExists($lang);
                break;
            default:
                throw new Exception;
        }
    }catch(Exception $e){
        http_response_code(500);
        $response[C::KEY_MESSAGE] = Properties::unknownError($lang);
    }
}//if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms']){
else{
    http_response_code(400);
    $response[C::KEY_MESSAGE] = Properties::missingFormValues($lang);
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

/**
 * Send the activation mail
 * @param array an array of values for mail activation template
 * @return int the error code or 0 if no error occurs while email sending
 */
function sendActivationMail(array $params): int{
    $dotenv = Dotenv::createImmutable("../../");
    $dotenv->safeLoad();
    $from = isset($params['from']) ? $params['from'] : $_ENV['EMAIL_USERNAME'];
    $fromNickname = isset($params['fromNickname']) ? $params['fromNickname'] : $_ENV['EMAIL_NICKNAME'];
    $host = isset($params['host']) ? $params['host'] : $_ENV['EMAIL_HOST'];
    $password = isset($params['password']) ? $params['password'] : $_ENV['EMAIL_PASSWORD'];
    $port = isset($params['port']) ? $params['port'] : $_ENV['EMAIL_PORT'];
    $emData = [
        'from' => $from, 'email' => $params['email'], 'fromNickname' => $fromNickname,
        'host' => $host, 'operation' => $params['operation'],
        'password' => $password, 'port' => $port, 'subject' => $params['subject']
    ];
    $emailManager = new EmailManager($emData);
    $activationMailData = [
        'verCode' => $params['verCode'], 'lang' => $params['lang'], 'link' => $params['link'], 'verifyUrl' => $params['verifyUrl']
    ];
    $emailManager->sendActivationMail($activationMailData);
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>