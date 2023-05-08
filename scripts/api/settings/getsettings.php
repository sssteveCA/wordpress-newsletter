<?php
use Dotenv\Dotenv;
use Newsletter\Classes\Api\AuthCheck;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Classes\Database\Models\Settings;
use Newsletter\Exceptions\DataNotRetrievedException;

require_once("../../../../../../wp-load.php");
require_once("../../../vendor/autoload.php");


$response = [
    C::KEY_DATA => [], C::KEY_DONE => false, C::KEY_MESSAGE => ''
];

try{
    $dotenv = Dotenv::createImmutable("../../../");
    $dotenv->load();
    $apiAuthArray = [
        'username' => $_SERVER['PHP_AUTH_USER'],
        'password' => $_SERVER['PHP_AUTH_PW'],
        'uuid' => $_ENV['API_REST_UUID']
    ];
    $authCheck = new AuthCheck($apiAuthArray);
    if($authCheck->getErrno() == 0){
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
                'cookie_policy_pages' => $settings->getCookiePolicyPages(),
                'privacy_policy_pages' => $settings->getPrivacyPolicyPages(),
                'terms_pages' => $settings->getTermsPages(),
            ];
        }//if($settings->getErrno() == 0){
        else throw new DataNotRetrievedException;
    }//if($authCheck->getErrno() == 0){
    else{
        http_response_code(401);
        $response[C::KEY_MESSAGE] = M::ERR_UNAUTHORIZED;
    }
}catch(Exception $e){
    http_response_code(500);
    $response[C::KEY_MESSAGE] = M::ERR_UNKNOWN;
}

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);


?>