<?php
use Newsletter\Classes\Email\EmailManager;

require_once("../../../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../interfaces/messages.php");
require_once("../../exceptions/incorrectvariableformatexception.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/properties/messages/activationmailtrait.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/preunsubscribetrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../traits/templatetrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/general.php");
require_once("../../classes/properties.php");
require_once("../../classes/htmlcode.php");
require_once("../../classes/template.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/email/emailmanager.php");
require_once("../../classes/subscribe/verifyemail.php");

use Dotenv\Dotenv;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Subscribe\VerifyEmailErrors as Vee;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Subscribe\VerifyEmail;
use Newsletter\Enums\Langs;
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
    ['href' => '../../css/wp/verify.css']
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
    $emailManager->sendNewSubscriberNotify();
}

?>