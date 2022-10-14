<?php

require_once("../../wp-load.php");
require_once("../interfaces/constants.php");
require_once("../interfaces/exceptionmessages.php");
require_once("../interfaces/messages.php");
require_once("../exceptions/incorrectvariableformatexception.php");
require_once("../exceptions/notsettedexception.php");
require_once("../traits/errortrait.php");
require_once("../traits/modeltrait.php");
require_once("../traits/sqltrait.php");
require_once("../traits/usertrait.php");
require_once("../traits/usercommontrait.php");
require_once("../classes/htmlcode.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");
require_once("../classes/verifyemail.php");

use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\VerifyEmailErrors as Vee;
use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\VerifyEmail;

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


if(isset($_GET['verCode']) && $_GET['verCode'] != ''){
    try{
        $user_data = [
            'tableName' => C::TABLE_USERS
        ];
        $user = new User($user_data);
        $verifyemail_data = [
            'verCode' => $_GET['verCode'],
            'user' => $user
        ];
        $verifyemail = new VerifyEmail($verifyemail_data);
        $verifyemail->verifyUser();
        $verifyemailE = $verifyemail->getErrno();
        switch($verifyemailE){
            case 0:
                $body = <<<HTML
<div>L'account è stato attivato</div>
HTML;
                break;
            case Vee::FROM_USER_NOT_FOUND:
                http_response_code(400);
                $body = <<<HTML
<div>Codice non valido</div>
HTML;
                break;
            default:
                http_response_code(500);
                $error = M::ERR_UNKNOWN;
                $body = <<<HTML
<div>{$errors}</div>
HTML;
                break;
        }

    }catch(Exception $e){
        http_response_code(500);
        $error = M::ERR_UNKNOWN;
        $body = <<<HTML
<div>{$errors}</div>
HTML;
    }
    $html = HtmlCode::genericHtml("Attivazione account", $body);
}//if(isset($_GET['verCode']) && $_GET['verCode'] != ''){
else{
    http_response_code(400);
    $body = <<<HTML
<div>Inserisci un codice di attivazione per continuare</div>
HTML;
    $html = HtmlCode::genericHtml("Attivazione account",$body);
}

echo $html;

?>