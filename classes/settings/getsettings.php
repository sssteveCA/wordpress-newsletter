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
        $checked = $langStatus['it'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_lang_it"{$checked}>
            <label class="form-check-label" for="nl_cb_lang_it">Italiano</label>
        </div>
HTML;
        $checked = $langStatus['es'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_lang_es"{$checked}>
            <label class="form-check-label" for="nl_cb_lang_es">Spagnolo</label>
        </div>
HTML;
        $checked = $langStatus['en'] ? ' checked': '';
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

    private function setPageEnabledCheckboxes(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $disabled = (!$langStatus['it'] && !$langStatus['es'] && !$langStatus['en']) ? ' disabled': '';
        $includedPagesStatus = $this->data[C::KEY_DATA]['included_pages_status'];
        $html = <<<HTML
<div id="nl_container_pages_enabled" class="container mt-5">
        <div class="row">
            <h5>Pagine da includere</h5>
        </div>
        <div class="row flex-column flex-md-row flex-md-wrap">
HTML;
        
        $checked = $includedPagesStatus['contacts_pages'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_contacts_pages" {$checked}{$disabled}>
            <label class="form-check-label" for="nl_cb_contacts_pages">Pagine contatti</label>
        </div>
HTML;
        $checked = $includedPagesStatus['cookie_policy_pages'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_cookie_policy" {$checked}{$disabled}>
            <label class="form-check-label" for="nl_cb_cookie_policy">Pagine cookie policy</label>
        </div>
HTML;
        $checked = $includedPagesStatus['privacy_policy_pages'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_privacy_policy" {$checked}{$disabled}>
            <label class="form-check-label" for="nl_cb_privacy_policy">Pagine privacy policy</label>
        </div>
HTML;
        $checked = $includedPagesStatus['terms_pages'] ? ' checked': '';
        $html .= <<<HTML
        <div class="col">
            <input type="checkbox" class="form-check-input" id="nl_cb_terms" {$checked}{$disabled}>
            <label class="form-check-label" for="nl_cb_terms">Pagine Termini e condizioni</label>
        </div>
HTML;
        $html .= <<<HTML
    </div>
</div>
HTML;
        return $html;
    }

    private function setSocialCheckBoxes(): string{
        $socialsStatus = $this->data[C::KEY_DATA]['socials_status'];
        $html = <<<HTML
<div id="nl_container_social" class="container mt-5">
    <div class="row">
        <h5>Social</h5>
    </div>
    <div class="row flex-column flex-md-row">
HTML;
        $checked = $socialsStatus['facebook'] ? ' checked' : '';
        $html .= <<<HTML
        <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_facebook"{$checked}>
                <label class="form-check-label" for="nl_cb_facebook">Facebook</label>
        </div>
HTML;
        $checked = $socialsStatus['instagram'] ? ' checked' : '';
        $html .= <<<HTML
        <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_instagram"{$checked}>
                <label class="form-check-label" for="nl_cb_instagram">Instagram</label>
        </div>
HTML;
        $checked = $socialsStatus['youtube'] ? ' checked' : '';
        $html .= <<<HTML
        <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_youtube"{$checked}>
                <label class="form-check-label" for="nl_cb_youtube">Youtube</label>
        </div>
HTML;
        $html .= <<<HTML
    </div>
</div>
HTML;
        return $html;
    }

    private function setSocialProfileURLs(): string{
        $socialsStatus = $this->data[C::KEY_DATA]['socials_status'];
        $socialPages = $this->data[C::KEY_DATA]['social_pages'];
        $html = <<<HTML
<div id="nl_row_social_links" class="row mt-3">
HTML;
        $disabled = !$socialsStatus['facebook'] ? ' disabled': '';
        $url = $socialPages['facebook'];
        $html .= <<<HTML
    <div class="col-12 col-md-4">
        <label for="nl_input_facebook" class="form-label">Pagina facebook</label>
    </div>
    <div class="col-12 col-md-8">
        <input type="text" class="form-control" id="nl_input_facebook" value="{$url}" {$disabled}>
    </div>
HTML;
    $disabled = !$socialsStatus['instagram'] ? ' disabled': '';
    $url = $socialPages['instagram'];
    $html .= <<<HTML
    <div class="col-12 col-md-4">
    <label for="nl_input_instagram" class="form-label">Pagina instagram</label>
    </div>
    <div class="col-12 col-md-8">
    <input type="text" class="form-control" id="nl_input_instagram" value="{$url}" {$disabled}>
    </div>
HTML;
    $disabled = !$socialsStatus['youtube'] ? ' disabled': '';
    $url = $socialPages['youtube'];
    $html .= <<<HTML
    <div class="col-12 col-md-4">
    <label for="nl_input_youtube" class="form-label">Pagina youtube</label>
    </div>
    <div class="col-12 col-md-8">
    <input type="text" class="form-control" id="nl_input_youtube" value="{$url}" {$disabled}>
    </div>
HTML;
        $html .= <<<HTML
</div>
HTML;
        return $html;
    }

    private function setContactPagesUrl(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $contactPages = $this->data[C::KEY_DATA]['contact_pages'];
        $html = <<<HTML
 <div id="nl_container_contacts_pages" class="container mt-5">
    <div class="row">
        <h5>Pagine contatti</h5>
    </div>
HTML;
        $disabled = $langStatus['it'] ? '': ' disabled';
        $value = $contactPages['it'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_contacts_it" class="form-label">Pagina italiana</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_contacts_it" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        $disabled = $langStatus['es'] ? '': ' disabled';
        $value = $contactPages['es'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_contacts_es" class="form-label">Pagina spagnola</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_contacts_es" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        $disabled = $langStatus['en'] ? '': ' disabled';
        $value = $contactPages['en'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_contacts_en" class="form-label">Pagina inglese</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_contacts_en" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        $html .= <<<HTML
</div>
HTML;
        return $html;
    }

    private function setCookiePolicyPageURLs(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $cookiePolicyPages = $this->data[C::KEY_DATA]['cookie_policy_pages'];
        $html = <<<HTML
<div id="nl_container_cookie_pages" class="container mt-5">
    <div class="row">
        <h5>Pagine Cookie Policy</h5>
    </div>
HTML;
        $disabled = !$langStatus['it'] ? ' disabled' : '';
        $value = $cookiePolicyPages['it'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_cookie_policy_it" class="form-label">Pagina italiana</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_cookie_policy_it" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['es'] ? ' disabled' : '';
    $value = $cookiePolicyPages['es'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_cookie_policy_es" class="form-label">Pagina spagnola</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_cookie_policy_es" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['en'] ? ' disabled' : '';
    $value = $cookiePolicyPages['en'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_cookie_policy_en" class="form-label">Pagina inglese</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_cookie_policy_en" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        return $html;
    }
}

?>