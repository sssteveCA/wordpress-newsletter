<?php

use Dotenv\Dotenv;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Classes\Settings\SettingsUpdate;
use Newsletter\Classes\Settings\SettingsCheck;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");

$response = [
    C::KEY_DONE => false, C::KEY_MESSAGE => ""
];

try{
    $dotenv = Dotenv::createImmutable("../../../../");
    $dotenv->load();
    $apiAuthArray = [
        'username' => $_SERVER['PHP_AUTH_USER'],
        'password' => $_SERVER['PHP_AUTH_PW'],
        'uuid' => $_ENV['API_REST_UUID']
    ];
    $authCheck = new AuthCheck($apiAuthArray);
    if($authCheck->getErrno() == 0){
        $input = file_get_contents("php://input");
        $put = json_decode($input,true);
        $ls_ok = (isset($put['data']['lang_status']) && $put['data']['lang_status'] != "");
        $ips_ok = (isset($put['data']['included_pages_status']) && $put['data']['included_pages_status'] != "");
        $ss_ok = (isset($put['data']['socials_status']) && $put['data']['socials_status'] != "");
        $sp_ok = (isset($put['data']['social_pages']) && $put['data']['social_pages'] != "");
        $cp_ok = (isset($put['data']['contact_pages']) && $put['data']['contact_pages'] != "");
        $ppp_ok = (isset($put['data']['privacy_policy_pages']) && $put['data']['privacy_policy_pages'] != "");
        if($ls_ok && $ips_ok && $ss_ok && $sp_ok && $cp_ok && $ppp_ok){
            try{
                $settings_update_errno = settingsUpdate($put['data']);
                if($settings_update_errno == 0){
                    $response = [
                        C::KEY_DONE => true, C::KEY_MESSAGE => "Aggiornamento delle impostazioni completato con successo"
                    ];
                }
                else throw new Exception;
            }catch(Exception $e){
                http_response_code(500);
                $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
            }
        }//if($ls_ok && $ips_ok && $ss_ok && $sp_ok && $cp_ok && $ppp_ok){
        else{
            http_response_code(400);
            $response[C::KEY_MESSAGE] = M::ERR_MISSING_FORM_VALUES;
        }
    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
    }
}catch(NotSettedException $e){
    http_response_code(401);
    $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

/**
 * Execute the query to update the settings table
 * @param array $params the updated settings data
 * @return int the error code or 0 if no error occurred
 */
function settingsUpdate(array $params): int{
    $sc_data = [
        'lang_status' => $params['lang_status'],
        'included_pages_status' => $params['included_pages_status'],
        'socials_status' => $params['socials_status'],
        'social_pages' => $params['social_pages'],
        'contact_pages' => $params['contact_pages'],
        'privacy_policy_pages' => $params['privacy_policy_pages'],
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
    $settings_update = new SettingsUpdate($su_data);
    return $settings_update->getErrno();
}

?>