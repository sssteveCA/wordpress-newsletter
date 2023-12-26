<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;
use Newsletter\Traits\HtmlCodeTrait;

class HtmlCode{

    use HtmlCodeTrait;

    /**
     * Admin subscriber add form
     */
    public static function adminAddForm(): string{
        return <<<HTML
<div>
    <h2 class="text-center">Aggiungi utente alla newsletter</h2>
</div>
<form id="nl_form_add" method="post" action="#">
    <div id="nl_add_content" class="mt-4 mx-auto container-fluid">
        <div class="row mb-4">
            <div class="col-12 col-md-3">
                <label for="nl_email" class="form-label">Email</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_email" class="form-control" name="email">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-3">
                <label for="nl_name" class="form-label">Nome</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_name" class="form-control" name="name">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-3">
                <label for="nl_surname" class="form-label">Cognome</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_surname" class="form-control" name="surname">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-3">
                <label for="nl_lang_code" class="form-label">Lingua</label>
            </div>
            <div class="col-12 col-md-9">
                <select id="nl_lang_code" class="form-select" name="lang_code">
                    <option value="it" selected>Italiano</option>
                    <option value="es">Spagnolo</option>
                    <option value="en">Inglese</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-between justify-content-md-evenly">
            <div class="col-12 col-sm-6 d-flex justify-content-center align-items-center my-5 my-sm-0">
                <div>
                    <button type="submit" class="btn btn-primary">AGGIUNGI</button>
                </div>
                <div class="ms-3">
                    <div id="nl_add_spinner" class="spinner-border text-dark invisible" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 text-center">
                <button type="reset" class="btn btn-danger">ANNULLA</button>
            </div>
        </div>
        <div class="row my-4">
            <div id="nl_add_user_response" class="col-12 text-center fw-bold fs-4"></div>
        </div>
    </div>
</form>
HTML;
    }
    
    /**
     * Admin subscriber delete form
     */
    public static function adminDelForm(): string{
        return <<<HTML
        <div>
            <h2 class="text-center">Elimina iscritti dalla newsletter</h2>
        </div>
        <form id="nl_form_del" method="post" action="#">
            <div id="nl_del_content" class="mt-4 mx-auto d-flex flex-column flex-md-row justify-content-md-around">
                <div id="nl_del_content_email" class="border border-dark overflow-auto">
                </div>
                <div id="nl_del_checkbox" class="my-3 my-md-0">
                    <div>
                        <input type="checkbox" id="nl_check_all" value="1">
                        <label for="nl_check_all">Seleziona tutto</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nl_check_all_it" value="1">
                        <label for="nl_check_all_it">Seleziona tutti gli italiani</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nl_check_all_es" value="1">
                        <label for="nl_check_all_es">Seleziona tutti gli spagnoli</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nl_check_all_en" value="1">
                        <label for="nl_check_all_en">Seleziona tutti gli inglesi</label>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row my-4">
                    <div class="col-7 text-end">
                        <button type="submit" id="nl_bt_del_email" class="btn btn-primary">RIMUOVI ISCRITTI</button>
                    </div>
                    <div class="col-5">
                        <div id="nl_delete_spinner" class="spinner-border text-dark invisible" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div id="nl_delete_users_response" class="col-12 text-center fw-bold fs-4"></div>
                </div>
            </div>
        </form>
        HTML;
    }

    /**
     * Admin newsletter send status form
     */
    public static function adminLogForm(): string{
        return <<<HTML
        <div>
            <h2 class="text-center">Stato di invio delle newsletter ai destinatari indicati</h2>
        </div>
        <form id="nl_log_newsletter" class="d-flex flex-column align-items-center" method="post" action="#">
            <div id="nl_table_container" class="mb-3 mt-4">
            </div>
            <div class="container">
                <div class="row my-4">
                    <div class="col-7 text-end">
                        <button id="nl_log_bt_delete" type="button" class="btn btn-danger">CANCELLA</button>
                    </div>
                    <div class="col-5">
                        <div id="nl_delete_log_spinner" class="spinner-border text-dark invisible" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div id="nl_log_delete_response" class="col-12 text-center fw-bold fs-4"></div>
                </div>
            </div>
        </form>
HTML;
    }

    /**
     * Admin newsletter send form
     */
    public static function adminSenderForm(): string{
        return <<<HTML
<div>
    <h2 class="text-center">Invia mail agli iscritti</h2>
</div>
<form id="nl_form_send" method="post" action="#">
    <div class="input-group mb-3 mt-4">
        <div class="input-group-prepend">
            <span class="input-group-text" id="nl_label_subject">Titolo</span>
        </div>
        <input type="text" id="nl_subject" class="form-control" name="subject" aria-label="Oggetto" aria-describedby="nl_label_subject">
    </div>
    <div class="d-flex flex-column justify-content-center flex-lg-row justify-content-lg-between">
        <div id="nl_send_message" class="mt-4 mx-auto">
            <textarea id="nl_msg_text" name="message" required></textarea>
        </div>
        <div id="nl_send_emails_content" class="mt-4 mx-auto">
            <div id="nl_send_content" class="overflow-auto">
            </div>
            <div id="nl_send_checkbox">
                <div>
                    <input type="checkbox" id="nl_check_all" value="1">
                    <label for="nl_check_all">Seleziona tutto</label>
                </div>
                <div>
                    <input type="checkbox" id="nl_check_all_it" value="1">
                    <label for="nl_check_all_it">Seleziona tutti gli italiani</label>
                </div>
                <div>
                    <input type="checkbox" id="nl_check_all_es" value="1">
                    <label for="nl_check_all_es">Seleziona tutti gli spagnoli</label>
                </div>
                <div>
                    <input type="checkbox" id="nl_check_all_en" value="1">
                    <label for="nl_check_all_en">Seleziona tutti gli inglesi</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row my-4">
            <div id="nl_send_button" class="col-7 text-end">
                <button type="submit" id="nl_bt_send_content" class="btn btn-primary">INVIA MAIL</button>
            </div>
            <div class="col-5">
                <div id="nl_send_spinner" class="spinner-border text-dark invisible" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div id="nl_email_send_response" class="col-12 text-center fw-bold fs-4"></div>
        </div>
    </div>
</form>
HTML;
    }

    /**
     * Admin newsletter settings form
     */
    public static function adminSettingsForm(): string{
        return <<<HTML
<div>
    <h2 class="text-center">Impostazioni</h2>
</div>
<form id="nl_form_settings" method="post" action="#">
    <div id="nl_container_langs" class="container">
        <div class="row">
            <h5>Lingue</h5>
        </div>
        <div class="row flex-column flex-md-row">
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_lang_it">
                <label class="form-check-label" for="nl_cb_lang_it">Italiano</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_lang_es">
                <label class="form-check-label" for="nl_cb_lang_es">Spagnolo</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_lang_en">
                <label class="form-check-label" for="nl_cb_lang_en">Inglese</label>
            </div>
        </div>
    </div>
    <div id="nl_container_pages_enabled" class="container mt-5">
        <div class="row">
            <h5>Pagine da includere</h5>
        </div>
        <div class="row flex-column flex-md-row flex-md-wrap">
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_contacts_pages" disabled>
                <label class="form-check-label" for="nl_cb_contacts_pages">Pagine contatti</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_cookie_policy" disabled>
                <label class="form-check-label" for="nl_cb_cookie_policy">Pagine cookie policy</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_privacy_policy" disabled>
                <label class="form-check-label" for="nl_cb_privacy_policy">Pagine privacy policy</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_terms" disabled>
                <label class="form-check-label" for="nl_cb_terms">Pagine Termini e condizioni</label>
            </div>
        </div>
    </div>
    <div id="nl_container_social" class="container mt-5">
        <div class="row">
            <h5>Social</h5>
        </div>
        <div class="row flex-column flex-md-row">
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_facebook">
                <label class="form-check-label" for="nl_cb_facebook">Facebook</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_instagram">
                <label class="form-check-label" for="nl_cb_instagram">Instagram</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="nl_cb_youtube">
                <label class="form-check-label" for="nl_cb_youtube">Youtube</label>
            </div>
        </div>
        <div id="nl_row_social_links" class="row mt-3">
            <div class="col-12 col-md-4">
                <label for="nl_input_facebook" class="form-label">Pagina facebook</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_input_facebook" disabled>
            </div>
            <div class="col-12 col-md-4">
                <label for="nl_input_instagram" class="form-label">Pagina instagram</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_input_instagram" disabled>
            </div>
            <div class="col-12 col-md-4">
                <label for="nl_input_youtube" class="form-label">Pagina youtube</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_input_youtube" disabled>
            </div>
        </div>
    </div>
    <div id="nl_container_contacts_pages" class="container mt-5">
        <div class="row">
            <h5>Pagine contatti</h5>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_contacts_it" class="form-label">Pagina italiana</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_contacts_it" disabled>
            </div>
        <div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_contacts_es" class="form-label">Pagina spagnola</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_contacts_es" disabled>
            </div>
        <div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_contacts_en" class="form-label">Pagina inglese</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_contacts_en" disabled>
            </div>
        <div>
    </div>
    <div id="nl_container_cookie_pages" class="container mt-5">
        <div class="row">
            <h5>Pagine Cookie Policy</h5>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_cookie_policy_it" class="form-label">Pagina italiana</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_cookie_policy_it" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_cookie_policy_es" class="form-label">Pagina spagnola</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_cookie_policy_es" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_cookie_policy_en" class="form-label">Pagina inglese</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_cookie_policy_en" disabled>
            </div>
        </div>
    </div>
    <div id="nl_container_privacy_pages" class="container mt-5">
        <div class="row">
            <h5>Pagine Privacy Policy</h5>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_privacy_policy_it" class="form-label">Pagina italiana</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_privacy_policy_it" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_privacy_policy_es" class="form-label">Pagina spagnola</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_privacy_policy_es" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_privacy_policy_en" class="form-label">Pagina inglese</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_privacy_policy_en" disabled>
            </div>
        </div>
    </div>
    <div id="nl_container_terms_pages" class="container mt-5">
        <div class="row">
            <h5>Pagine Termini e condizioni</h5>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_terms_it" class="form-label">Pagina italiana</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_terms_it" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_terms_es" class="form-label">Pagina spagnola</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_terms_es" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="nl_page_terms_en" class="form-label">Pagina inglese</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" class="form-control" id="nl_page_terms_en" disabled>
            </div>
        </div>
    </div>
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
</form>
HTML;
    }

    /**
     * Create an HTML page
     * @param string $title page title
     * @param string $body the content inside the body tag
     * @return string the HTML page content
     */
    public static function genericHtml(string $title, string $body):string{
        $header = get_header();
        $sidebar = get_sidebar();
        $footer = get_footer();
        $content = <<<HTML
{$header}
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        {$body}
    </main>
</div>
{$sidebar}
{$footer}
HTML;
    return $content;
    }

    /**
     * Get the pre unsubscribe form
     * @param string $lang the user language
     * @param string $script_path the unsubscribe script path
     * @param string $unsusbc_code the unsubscribe code
     * @return string the pre unsubscribe form 
     */
    public static function preUnsubscribeForm(string $lang, string $script_path, string $unsubsc_code): string{
        $params = Properties::preUnsubscribeFormMessages($lang);
        return <<<HTML
<form id="fUnsubscribe" method="get" action="{$script_path}?unsubscCode={$unsubsc_code}">
    <input type="hidden" name="lang" value="{$lang}">
    <input type="hidden" name="unsubsc_code" value="{$unsubsc_code}">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-10 col-lg-8 h4 text-center">{$params['message']}</div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary btn-lg">{$params['confirm']}</button>
                <div id="nl_spinner" class="spinner-border text-dark invisible ms-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div id="nl_unsubscribe_user_response" class="col-12 text-center fw-bold fs-4"></div>
        </div>
        
    </div>
</form> 
HTML;
    }

    /**
     * Frontend newsletter register form
     * @param array $params
     */
    public static function wpSignupForm(array $params): string{
        $langParams = $params['lang'];
        $settings = $params['settings'];
        $html = <<<HTML
<fieldset id="nl_form_fieldset" class="position-relative w-50 mx-auto border border-primary d-flex flex-column align-items-center" style="margin-bottom: 50px; min-width: 300px;">
    <legend class="text-center">{$langParams['title']}</legend>
    <h2 class="text-center"></h2>
    <form id="nl_form" class="ml-5 mb-5 d-flex flex-column w-100" action="#" method="post"> 
        <div class="container">
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_name" class="form-label">{$langParams['name_title']}</label>
                    <input type="text" class="form-control" id="nl_name" name="name">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_surname" class="form-label">{$langParams['surname_title']}</label>
                    <input type="text" class="form-control" id="nl_surname" name="surname">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_email" class="form-label">{$langParams['ea_title']}</label>
                    <input type="email" class="form-control" id="nl_email" name="email" required>
                </div>
            </div>
HTML;
    if($settings['included_pages_status']['cookie_policy_pages'] && $settings['included_pages_status']['privacy_policy_pages']){
        $html .= <<<HTML
            <div class="row my-4">
                <div class="col-12 form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="nl_cb_privacy" name="cb_privacy" required>
                    <label class="form-check-label" for="nl_cb_privacy">{$langParams['cb_label1']}</label>
                </div>
            </div>
HTML;
    }//if($settings['included_pages_status']['cookie_policy_pages'] && $settings['included_pages_status']['privacy_policy_pages']){
    if($settings['included_pages_status']['terms_pages']){
        $html .= <<<HTML
            <div class="row my-4">
                <div class="col-12 form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="nl_cb_terms" name="cb_terms" required>
                    <label class="form-check-label" for="nl_cb_terms">{$langParams['cb_label2']}</label>
                </div>
            </div>
HTML;
    }//if($settings['included_pages_status']['terms_pages']){
    $html .= <<<HTML
            <div class="row my-4">
                <div class="col-7 text-end">
                    <button id="nl_submit" type="submit" class="btn btn-dark mb-5" disabled>{$langParams['subscribe_text']}</button>
                </div>
                <div class="col-5">
                    <div id="nl_spinner" class="spinner-border text-dark invisible" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="nl_lang" name="lang" value="{$langParams['lang_code']}">
    </form>
</fieldset>
HTML;
    return $html;
    }

    /**
     * User account verify page form
     * @param string $actionUrl
     * @param array $params
     */
    public static function wpSignupVerifyForm(string $actionUrl, array $params): string{
        return <<<HTML
<fieldset id="nl_form_fieldset" class="position-relative w-50 mx-auto border border-primary d-flex flex-column align-items-center">
    <legend class="text-center">{$params['legend_title']}</legend>
    <h2 class="text-center">{$params['h2_title']}</h2>
    <form id="nl_form" class="ml-5 mb-5 d-flex flex-column" action="{$actionUrl}">
        <div class="container">
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_vercode" class="form-label">{$params['label_verCode']}</label>
                    <input type="text" class="form-control" id="nl_vercode" name="verCode">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12 text-center">
                    <button id="nl_submit" type="submit" class="btn btn-dark mb-5">{$params['bt_text']}</button>
                </div>
            </div>
        </div>
    </form>    
</fieldset>
HTML;
    }
}
?>