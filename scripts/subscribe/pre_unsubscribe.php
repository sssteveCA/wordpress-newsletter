<?php
use Newsletter\Classes\General;
use Newsletter\Classes\Properties;

require_once("../../enums/languages.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../classes/properties.php");
require_once("../../classes/htmlcode.php");

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);

$arrData = [
    'title' => '',
    'body' => '',
    'styleTag' => '',
    'styles' => [],
    'scripts' => []
];

if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
    $arrData['body'] = <<<HTML
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
        </div>
    </div>
</div>
HTML;
}//if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
else{
    $arrData['body'] = <<<HTML
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
        </div>
    </div>
</div>
HTML;
}
?>