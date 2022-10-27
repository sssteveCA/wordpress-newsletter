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

$response = [
    'done' => false, 'msg' => ''
];

$input = file_get_contents("php://input");
$post = json_decode($input,true);

if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
    if(is_array($post['emails'] && sizeof($post['emails']) > 0)){

    }//if(is_array($post['emails'] && sizeof($post['emails']) > 0)){
}//if(isset($post['emails'],$post['subject'],$post['body']) && $post['body'] != ''){
else{
    http_response_code(400);
    $response['msg'] = M::ERR_MISSING_FORM_VALUES;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>