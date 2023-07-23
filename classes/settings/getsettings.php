<?php

namespace Newsletter\Classes\Settings;

use Newsletter\Classes\Database\Models\Settings;
use Newsletter\Classes\Properties;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Interfaces\Messages as M;
use Newsletter\Traits\ErrorTrait;
use WP_Error;
use Newsletter\Classes\Settings\GetSettingsErrors as Gse;

interface GetSettingsErrors{
    const ERR_GET_DATA = 1;
    const ERR_GET_DATA_MSG = "Impossibile ottenere i dati richiesti";
}

/**
 * This class fetch the settings from the DB and returns the proper HTML
 */
class GetSettings implements Gse{

    use ErrorTrait;

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

    private function setLangCheckboxes(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $html =<<<HTML
<div id="nl_container_langs" class="container">
    <div class="row">
        <h5>Lingue</h5>
    </div>
    <div class="row flex-column flex-md-row">
HTML;
        $checked = ($langStatus['it']) ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_lang_it"{$checked}>
            <label class="form-check-label" for="nl_cb_lang_it">Italiano</label>
        </div>
HTML;
        $checked = ($langStatus['es']) ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_lang_es"{$checked}>
            <label class="form-check-label" for="nl_cb_lang_es">Spagnolo</label>
        </div>
HTML;
        $checked = ($langStatus['en']) ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_lang_en"{$checked}>
            <label class="form-check-label" for="nl_cb_lang_en">Inglese</label>
        </div>
HTML;
        $html .= <<<HTML
    </div>
</div>
HTML;
        return $html;
    }
}

?>