<?php

require_once("../../../../../wp-load.php");
require_once("../../vendor/autoload.php");

use Dotenv\Dotenv;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\UserUnsubscribeErrors as Uue;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Classes\General;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\UserUnsubscribe;

$html = "";
$style = <<<HTML
div{
    padding-top: 20px; 
    text-align: center; 
    font-size: 20px; 
    font-weight: bold;
}
HTML;
$body = "";

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);
$title = Properties::newsletterUnsubscribeTitle($lang);

if(isset($_REQUEST['unsubscCode']) && $_REQUEST['unsubscCode'] != ""){
    $unsubscCode = $_REQUEST['unsubscCode'];
    try{
        $userData = [
           'tableName' => C::TABLE_USERS, 'unsubscCode' => $unsubscCode];
        $user = new User($userData);
        $userUnsubscData = ['user' => $user];
        $userUnsubsc = new UserUnsubscribe($userUnsubscData);
        $uuErrno = $userUnsubsc->getErrno();
        $uuErrno = 0;
        switch($uuErrno){
            case 0:
                $email = $userUnsubsc->getUser()->getEmail();
                $emData = [
                    'email' => $email, 'operation' => EmailManager::EMAIL_USER_UNSUBCRIBE, 'subject' => 'Rimozione dalla Newsletter'
                ];
                sendUserUnsubscribeNotify($emData);
                $message = Properties::unsubscribeComplete($lang);
                break;
            case Uue::CODE_NOT_FOUND:
                http_response_code(400);
                $message = Properties::invalidCodeUt($lang);
                break;
            default:
                throw new Exception;
        }
    }catch(Exception $e){
        http_response_code(500);
        $message = Properties::unknownError($lang);
    }
}//if(isset($_REQUEST['unsubscCode']) && $_REQUEST['unsubscCode'] != ""){
else{
    http_response_code(404);
    $message = Properties::missingFormValues($lang);
}

if(isset($_REQUEST[C::KEY_AJAX]) && $_REQUEST[C::KEY_AJAX] == '1'){
    if(http_response_code() == 200)
        $response = [ C::KEY_DONE => true, C::KEY_MESSAGE => $message ];
    else 
        $response = [ C::KEY_DONE => false, C::KEY_MESSAGE => $message ];
    echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
}//if(isset($_REQUEST[C::KEY_AJAX]) && $_REQUEST[C::KEY_AJAX] == '1'){
else{
    $style = <<<HTML
div{
    padding-top: 20px; 
    text-align: center; 
    font-size: 20px; 
    font-weight: bold;
}
HTML;
    $body = <<<HTML
<div>{$message}</div>
HTML;
    $html = HtmlCode::genericHtml($title,$body,$style);
    echo $html;
}


function sendUserUnsubscribeNotify(array $params):int{
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
    $emailManager->sendUserUnsubscribeNotify();
    return 0;
}
?>