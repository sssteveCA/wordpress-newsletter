<?php

require_once("../../wp-load.php");
require_once("../interfaces/exceptionmessages.php");
require_once("../traits/errortrait.php");
require_once("../traits/modeltrait.php");
require_once("../traits/sqltrait.php");
require_once("../traits/usercommontrait.php");
require_once("../traits/usertrait.php");
require_once("../traits/errortrait.php");
require_once("../traits/properties/messages/newusertrait.php");
require_once("../traits/properties/messages/othertrait.php");
require_once("../traits/properties/messages/verifytrait.php");
require_once("../traits/properties/propertiesmessagestrait.php");
require_once("../traits/properties/propertiesurltrait.php");
require_once("../classes/general.php");
require_once("../classes/properties.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");
require_once("../classes/subscribe/userunsubscribe.php");

use Newsletter\Classes\General;
use Newsletter\Classes\Properties;

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);

if(isset($_REQUEST['unsubscCode']) && $_REQUEST['unsubscCode'] != ""){
    $unsubscCode = $_REQUEST['unsubscCode'];
    try{

    }catch(Exception $e){

    }
}//if(isset($_REQUEST['unsubscCode']) && $_REQUEST['unsubscCode'] != ""){
else{
    http_response_code(404);
    $message = Properties::missingFormValues($lang);
}
?>