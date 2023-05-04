<?php

require_once("../../../../../wp-load.php");
require_once("../../vendor/autoload.php");

use Newsletter\Classes\Settings\SettingsCheck;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ""
];

$current_user = wp_get_current_user();
$logged = ($current_user->ID != 0);
$administrator = current_user_can('manage_options');

if($logged && $administrator){
    $input = file_get_contents("php://input");
    $put = json_decode($input,true);
    $ls_ok = (isset($put['lang_status']) && $put['lang_status'] != "");
    $ips_ok = (isset($put['included_pages_status']) && $put['included_pages_status'] != "");
    $ss_ok = (isset($put['socials_status']) && $put['socials_status'] != "");
    $sp_ok = (isset($put['social_pages']) && $put['social_pages'] != "");
    $cp_ok = (isset($put['contact_pages']) && $put['contact_pages'] != "");
    $ppp_ok = (isset($put['privacy_policy_pages']) && $put['privacy_policy_pages'] != "");
    if($ls_ok && $ips_ok && $ss_ok && $sp_ok && $cp_ok && $ppp_ok){
        try{
            $sc_data = [
                'lang_status' => json_decode($put['lang_status'],true),
                'included_pages_status' => json_decode($put['included_pages_status'],true),
                'socials_status' => json_decode($put['socials_status'],true),
                'social_pages' => json_decode($put['social_pages'],true),
                'contact_pages' => json_decode($put['contact_pages'],true),
                'privacy_policy_pages' => json_decode($put['privacy_policy_pages'],true),
            ];
            $settings_check = new SettingsCheck($sc_data);
            $su_data = [
                'lang_status' => $settings_check->getLangStatus(),
                'included_pages_status' => $settings_check->getIncludedPagesStatus(),
                'socials_status' => $settings_check->getSocialsStatus(),
                'social_pages' => $settings_check->getSocialPages(),
                'contact_pages' => $settings_check->getContactPages(),
                'privacy_policy_pages' => $settings_check->getPrivacyPolicyPages(),
            ];
        }catch(Exception $e){
            http_response_code(500);
            $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
        }
    }//if($ls_ok && $ips_ok && $ss_ok && $sp_ok && $cp_ok && $ppp_ok){
    else{
        http_response_code(400);
        $response[C::KEY_MESSAGE] = M::ERR_MISSING_FORM_VALUES;
    }
}//if($logged && $administrator){
else{
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>