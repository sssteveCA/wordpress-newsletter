<?php
use Newsletter\Classes\General;
use Newsletter\Classes\HtmlCode;
use Newsletter\Classes\Properties;

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

if(!isset($_REQUEST['lang'])) $_REQUEST['lang'] = 'en';
$lang = General::languageCode($_REQUEST['lang']);

$arr_data = [
    'title' => Properties::preUnsubscribeTitle($lang),
    'body' => '',
];

if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
    $script_path = "./unsubscribe.php";
    $unsubsc_code = $_REQUEST["unsubscCode"];
    $preUnsubscribeForm = HtmlCode::preUnsubscribeForm($lang,$script_path,$unsubsc_code);
    $arr_data['body'] = <<<HTML
<div class="nl-preunsubscribe">
{$preUnsubscribeForm}
</div>
HTML;
}//if(isset($_REQUEST["unsubscCode"]) && $_REQUEST["unsubscCode"]){
else{
    $error_message = Properties::preUnsubscribeErrorMessage($lang);
    $arr_data['body'] = <<<HTML
<div class="container nl-preunsubscribe">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-10 col-lg-8">{$error_message}</div>
    </div>
</div>
HTML;
}

echo HtmlCode::genericHtml($arr_data['title'],$arr_data['body']);
?>