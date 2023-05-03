<?php
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Database\Models\Settings;
use Newsletter\Exceptions\DataNotRetrievedException;

require_once("../../../../../wp-load.php");
require_once("../../vendor/autoload.php");

$response = [
    C::KEY_DATA => [], C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    try{
        $settings = new Settings(['tableName' => C::TABLE_SETTINGS]);
        $settings->getSettings();
        if($settings->getErrno() == 0){
            $response[C::KEY_DONE] = true;
            $response[C::KEY_DATA] = [
                'lang_status' => $settings->getLangStatus(),
                'included_pages_status' => $settings->getIncludedPagesStatus(),
                'socials_status' => $settings->getSocialsStatus(),
                'social_pages' => $settings->getSocialPages(),
                'contact_pages' => $settings->getContactPages(),
                'privacy_policy_pages' => $settings->getPrivacyPolicyPages(),
            ];
        }//if($settings->getErrno() == 0){
        else throw new DataNotRetrievedException;
    }catch(Exception $e){
        http_response_code(500);
        $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);


?>