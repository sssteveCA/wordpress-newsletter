<?php

use Dotenv\Dotenv;
use Newsletter\Classes\Email\EmailManager;

require_once("../../../../../wp-load.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/userstrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/database/models/users.php");
require_once("../../classes/email/emailmanager.php");

$input = file_get_contents("php://input");
$post = json_decode($input,true);

$response = [
    'done' => false, 'msg' => ''
];

if(isset($post['emails']) && sizeof($post['emails']) > 0){

}//if(isset($post['emails']) && sizeof($post['emails']) > 0){
else{
    http_response_code(400);
    $response['msg'] = "Inserisci almeno un indirizzo email";
}


echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

function sendDeleteUserNotify(array $params):int {
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
    $deleteUserMailData = ['lang' => $params['lang']];
    $emailManager->sendDeleteUserNotify($deleteUserMailData);
    $emErrno = $emailManager->getErrno();
    return $emErrno;
}
?>

