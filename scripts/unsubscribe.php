<?php

require_once("../../wp-load.php");
require_once("../enums/languages.php");
require_once("../interfaces/constants.php");
require_once("../interfaces/exceptionmessages.php");
require_once("../exceptions/incorrectvariableformatexception.php");
require_once("../exceptions/notsettedexception.php");
require_once("../traits/errortrait.php");
require_once("../traits/modeltrait.php");
require_once("../traits/sqltrait.php");
require_once("../traits/usercommontrait.php");
require_once("../traits/usertrait.php");
require_once("../traits/errortrait.php");
require_once("../traits/properties/messages/newusertrait.php");
require_once("../traits/properties/messages/othertrait.php");
require_once("../traits/properties/messages/verifytrait.php");
require_once("../traits/properties/messages/unsubscribetrait.php");
require_once("../traits/properties/propertiesmessagestrait.php");
require_once("../traits/properties/propertiesurltrait.php");
require_once("../classes/general.php");
require_once("../classes/htmlcode.php");
require_once("../classes/properties.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");
require_once("../classes/subscribe/userunsubscribe.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Subscribe\UserUnsubscribeErrors as Uue;
use Newsletter\Classes\Database\Models\User;
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
        $uu_error = $userUnsubsc->getErrno();
        switch($uu_error){
            case 0:
                $message = Properties::unsubscribeComplete($lang);
                break;
            case Uue::CODE_NOT_FOUND:
                http_response_code(400);
                $message = Properties::invalidCodeUt($lang);
                break;
            default:
                http_response_code(500);
                $message = Properties::unknownError($lang);
                break;
        }
    }catch(Exception $e){
        echo "Unsubsribe exception\n ".$e->getMessage();
        http_response_code(500);
        $message = Properties::unknownError($lang);
    }
}//if(isset($_REQUEST['unsubscCode']) && $_REQUEST['unsubscCode'] != ""){
else{
    http_response_code(404);
    $message = Properties::missingFormValues($lang);
}

$body = <<<HTML
<div>{$message}</div>
HTML;

$html = HtmlCode::genericHtml($title,$body,$style);

echo $html;
?>