<?php
use Newsletter\Classes\General;

require_once("../../enums/languages.php");
require_once("../../traits/properties/propertiesmessagestrait.php");
require_once("../../traits/properties/propertiesurltrait.php");
require_once("../../classes/properties.php");
require_once("../../classes/htmlcode.php");

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);

$arrData = [
    'title' => 'Conferma di',
    'body' => '',
    'styleTag' => '',
    'styles' => [],
    'scripts' => []
];

if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){

}//if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
else{

}
?>