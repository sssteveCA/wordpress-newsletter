<?php

namespace Newsletter\Classes\Settings;

use Newsletter\Classes\Database\Models\Settings;
use Newsletter\Classes\Properties;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Traits\ErrorTrait;
use WP_Error;
use Newsletter\Classes\Settings\GetSettingsErrors as Gse;
use Newsletter\Traits\GetSettingsTrait;

interface GetSettingsErrors{
    const ERR_GET_DATA = 1;
    const ERR_GET_DATA_MSG = "Impossibile ottenere i dati richiesti";
}

/**
 * This class fetch the settings from the DB and returns the proper HTML
 */
class GetSettings implements Gse{

    use ErrorTrait, GetSettingsTrait;

    private string $html = '';
    private array $data = [];

    public function __construct(){
        $this->getData();
        if($this->errno == 0){

        }
    }

    public function getHtml(){ return $this->html; }

    public function getError(){
        switch($this->errno){
            case Gse::ERR_GET_DATA:
                $this->error = Gse::ERR_GET_DATA_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    private function getData(): void{
        $settings = new Settings(['tableName' => C::TABLE_SETTINGS]);
        $settings->getSettings();
        if($settings->getErrno() == 0){
            $this->data =  [
                C::KEY_DONE => true,
                C::KEY_DATA => [
                    'lang_status' => $settings->getLangStatus(),
                    'included_pages_status' => $settings->getIncludedPagesStatus(),
                    'socials_status' => $settings->getSocialsStatus(),
                    'social_pages' => $settings->getSocialPages(),
                    'contact_pages' => $settings->getContactPages(),
                    'cookie_policy_pages' => $settings->getCookiePolicyPages(),
                    'privacy_policy_pages' => $settings->getPrivacyPolicyPages(),
                    'terms_pages' => $settings->getTermsPages(),
                ]
            ];
        }
        else $this->errno = Gse::ERR_GET_DATA;
        $this->data = [
            C::KEY_DONE => false,
            C::KEY_MESSAGE => M::ERR_UNAUTHORIZED
        ];
    }
}

?>