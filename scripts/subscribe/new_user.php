<?php

require_once("../../config/cors.php");
require_once("../../../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../interfaces/constants.php");
require_once("../../interfaces/messages.php");
require_once("../../exceptions/notsettedexception.php");
require_once("../../traits/errortrait.php");
//require_once("../../traits/properties/messages/activationmailtrait.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/usercommontrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../traits/templatetrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/general.php");
require_once("../../classes/properties.php");
require_once("../../classes/template.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/email/emailmanager.php");
require_once("../../classes/subscribe/usersubscribe.php");

use Dotenv\Dotenv;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Classes\General;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Subscribe\UserSubscribeError as Usee;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Subscribe\UserSubscribe;
use Newsletter\Classes\Template;

$inputs = file_get_contents("php://input");
$post = json_decode($inputs,true);

file_put_contents(C::FILE_LOG, "new_user.php input => ".var_export($inputs,true)."\r\n",FILE_APPEND);
file_put_contents(C::FILE_LOG, "new_user.php post data => ".var_export($post,true)."\r\n",FILE_APPEND);

//var_dump($post);

$response = [
    'msg' => '',
    'done' => false
];

if(!isset($post['lang'])) $post['lang'] = 'en';
$lang = General::languageCode($post['lang']);

if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms'] == '1'){
    $userData = [
        'tableName' => C::TABLE_USERS,'email' => $post['email'], 'lang' => $lang
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
                //echo "new_user ae_data => ".var_export($aeData,true)."\r\n";
                $email = sendActivationMail($aeData);
                switch($email){
                    case 0:
                        $response['msg'] = Properties::completeSubscribe($lang);
                        $response['done'] = true;
                        break;
                    default:
                        http_response_code(500);
                        $response['msg'] = Properties::unknownError($lang);
                        break;
                }
                break;
            case Usee::INCORRECT_EMAIL:
                http_response_code(400);
                $response['msg'] = Properties::wrongEmailFormat($lang);
                break;
            case Usee::EMAIL_EXISTS:
                http_response_code(400);
                $response['msg'] = Properties::emailExists($lang);
                break;
            default:
                http_response_code(500);
                $response['msg'] = Properties::unknownError($lang);
                break;
        }
    }catch(Exception $e){
        //echo "Exception\n";
        http_response_code(500);
        $response['msg'] = Properties::unknownError($lang);
    }
}//if(isset($post['email'],$post['cb_privacy'],$post['cb_terms']) && $post['email'] != '' && $post['cb_privacy'] == '1' && $post['cb_terms']){
else{
    http_response_code(400);
    $response['msg'] = Properties::missingFormValues($lang);
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
    //echo "new_user sendActivationMail em_data => ".var_export($emData,true)."\r\n";
    $emailManager = new EmailManager($emData);
    $activationMailData = [
        'verCode' => $params['verCode'], 'lang' => $params['lang'], 'link' => $params['link'], 'verifyUrl' => $params['verifyUrl']
    ];
    //echo "new_user sendActivationMail activationMail_data => ".var_export($activationMailData,true)."\r\n";
    $emailManager->sendActivationMail($activationMailData);
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>