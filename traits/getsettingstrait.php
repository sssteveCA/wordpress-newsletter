<?php

namespace Newsletter\Traits;

use Newsletter\Interfaces\Constants as C;

/**
 * Trait used by GetSettings class
 */
trait GetSettingsTrait{

    private function setFormButtons(): string{
        return <<<HTML
<div id="nl_container_buttons" class="container mt-5">
        <div class="row flex-column flex-md-row justify-content-center justify-content-md-around">
            <div class="col d-flex justify-content-center">
                <div>
                    <button id="nl_primary_button" type="button" class="btn btn-primary">AGGIORNA</button>
                </div>
                <div id="nl_spinner" class="spinner-border text-dark invisible ms-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col text-center">
                <button type="reset" class="btn btn-danger">ANNULLA</button>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div id="nl_update_settings_response" class="col-12 text-center fw-bold fs-4"></div>
    </div>
HTML;
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
        $html .= $this->setSocialProfileURLs();
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

    private function setPrivacyPolicyPageURLs(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $privacyPolicyPages = $this->data[C::KEY_DATA]['privacy_policy_pages'];
        $html = <<<HTML
<div id="nl_container_privacy_pages" class="container mt-5">
    <div class="row">
        <h5>Pagine Privacy Policy</h5>
    </div>
HTML;
        $disabled = !$langStatus['it'] ? ' disabled' : '';
        $value = $privacyPolicyPages['it'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_privacy_policy_it" class="form-label">Pagina italiana</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_privacy_policy_it" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['es'] ? ' disabled' : '';
    $value = $privacyPolicyPages['es'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_privacy_policy_es" class="form-label">Pagina spagnola</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_privacy_policy_es" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['en'] ? ' disabled' : '';
    $value = $privacyPolicyPages['en'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_privacy_policy_en" class="form-label">Pagina inglese</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_privacy_policy_en" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        return $html;
    }

    private function setTermsPageURLs(): string{
        $langStatus = $this->data[C::KEY_DATA]['lang_status'];
        $termsPages = $this->data[C::KEY_DATA]['terms_pages'];
        $html = <<<HTML
<div id="nl_container_privacy_pages" class="container mt-5">
    <div class="row">
        <h5>Pagine Termini e condizioni</h5>
    </div>
HTML;
        $disabled = !$langStatus['it'] ? ' disabled' : '';
        $value = $termsPages['it'];
        $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_terms_it" class="form-label">Pagina italiana</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_terms_it" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['es'] ? ' disabled' : '';
    $value = $termsPages['es'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_terms_es" class="form-label">Pagina spagnola</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_terms_es" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
    $disabled = !$langStatus['en'] ? ' disabled' : '';
    $value = $termsPages['en'];
    $html .= <<<HTML
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="nl_page_terms_en" class="form-label">Pagina inglese</label>
        </div>
        <div class="col-12 col-md-8">
            <input type="text" class="form-control" id="nl_page_terms_en" value="{$value}"{$disabled}>
        </div>
    </div>
HTML;
        return $html;
    }

    private function containerButtonsHtml(): string{
        return <<<HTML
    <div id="nl_container_buttons" class="container mt-5">
        <div class="row flex-column flex-md-row justify-content-center justify-content-md-around">
            <div class="col d-flex justify-content-center">
                <div>
                    <button id="nl_primary_button" type="button" class="btn btn-primary">AGGIORNA</button>
                </div>
                <div id="nl_spinner" class="spinner-border text-dark invisible ms-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col text-center">
                <button type="reset" class="btn btn-danger">ANNULLA</button>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div id="nl_update_settings_response" class="col-12 text-center fw-bold fs-4"></div>
    </div>
HTML;
    }

}
?>