<?php

require_once("../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../interfaces/messages.php");
require_once("../../vendor/autoload.php");
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
use Dotenv\Dotenv;
use Newsletter\Exceptions\NotSettedException;

$response = [
    'done' => false, 'msg' => ''
];

$input = file_get_contents("php://input");
$post = json_decode($input,true);

if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
    if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
        try{
            $dotEnv = Dotenv::createImmutable(__DIR__."../../");
            $dotEnv->safeLoad();
            $from = isset($data['from']) ? $data['from'] : $_ENV['EMAIL_USERNAME'];
            $host = isset($data['host']) ? $data['host'] : $_ENV['EMAIL_HOST'];
            $password = isset($data['password']) ? $data['password'] : $_ENV['EMAIL_PASSWORD'];
            $port = isset($data['port']) ? $data['port'] : $_ENV['EMAIL_PORT'];
            $em_data = [
                'body' => $post['body'], 'from' => $from, 'emailList' => $post['emails'], 
                'host' => $host, 'password' => $password, 'port' => $data['port'], 'subject' => $post['subject']
            ];
        }catch(NotSettedException $nse){
            http_response_code(400);
            $response['msg'] = $nse->getMessage();
        }catch(Exception $e){

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