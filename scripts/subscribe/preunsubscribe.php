<?php
use Newsletter\Classes\General;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Properties;

require_once("../../../../../wp-load.php");
require_once("../../enums/languages.php");
require_once("../../traits/properties/messages/newusertrait.php");
require_once("../../traits/properties/messages/othertrait.php");
require_once("../../traits/properties/messages/verifytrait.php");
require_once("../../traits/properties/messages/preunsubscribetrait.php");
require_once("../../traits/properties/messages/unsubscribetrait.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../classes/properties.php");
require_once("../../classes/general.php");
require_once("../../classes/htmlcode.php");

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);

$arrData = [
    'title' => Properties::preUnsubscribeTitle($lang),
    'body' => '',
    'styleTag' => '',
    'styles' => [],
    'scripts' => [
        '../../js/scripts/preunsubscribe.js'
    ]
];

if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
    $script_path = "./unsubscribe.php";
    $unsubsc_code = $_REQUEST["unsubscCode"];
    $arr_data['body'] = HtmlCode::preUnsubscribeForm($lang,$script_path,$unsubsc_code);
}//if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
else{
    $error_message = Properties::preUnsubscribeErrorMessage($lang);
    $arr_data['body'] = <<<HTML
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-10 col-lg-8">{$error_message}</div>
    </div>
</div>
HTML;
}
?>