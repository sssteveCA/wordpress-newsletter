<?php
use Newsletter\Classes\Email\EmailManager;

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

use Dotenv\Dotenv;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\VerifyEmailErrors as Vee;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Subscribe\VerifyEmail;
use Newsletter\Classes\General;
use Newsletter\Classes\Properties;

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
$title = Properties::newsletterSubscribeTitle($lang);


if(isset($_REQUEST['verCode']) && $_REQUEST['verCode'] != ''){
    try{
        $userData = [
            'tableName' => C::TABLE_USERS
        ];
        $user = new User($userData);
        $verifyEmailData = [
            'verCode' => $_REQUEST['verCode'],
            'user' => $user
        ];
        $verifyemail = new VerifyEmail($verifyEmailData);
        $verifyemail->verifyUser();
        $verifyemailE = $verifyemail->getErrno();
        switch($verifyemailE){
            case 0:
                $message = Properties::subscribeCompleted($lang);
                $emData = [
                    'email' => $verifyemail->getVerifiedUser()->getEmail(),
                    'operation' => EmailManager::EMAIL_NEW_SUBSCRIBER,
                    'subject' => 'Nuovo iscritto alla newsletter'
                ];
                sendNewSubscriberNotify($emData);
                break;
            case Vee::FROM_USER_NOT_FOUND:
                http_response_code(400);
                $message = Properties::invalidCodeVt($lang);
                break;
            default:
                throw new Exception;
        }
    }catch(Exception $e){
        http_response_code(500);
        $message = Properties::unknownError($lang);
    }
    $body = <<<HTML
<div>{$message}</div>
HTML;
}//if(isset($_REQUEST['verCode']) && $_REQUEST['verCode'] != ''){
else{
    $params = HtmlCode::verifyFormValues($lang);
    $body = HtmlCode::wpSignupVerifyForm(basename(__FILE__),$params);
}

$css_arr = [
    ['href' => '../../node_modules/bootstrap/dist/css/bootstrap.min.css'],
    ['href' => '../../dist/css/wp/verify.css']
];
$js_arr = [
    ["../../node_modules/bootstrap/dist/js/bootstrap.min.js"]
];
$html = HtmlCode::genericHtml($title,$body,$style,$css_arr,$js_arr);

echo $html;

/**
 * Send the mail to the admin when a new user signs up to the newsletter
 */
function sendNewSubscriberNotify(array $params){
    $dotenv = Dotenv::createImmutable("../../../");
    $dotenv->load();
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
    $emailManager->sendNewSubscriberNotify();
}

?>