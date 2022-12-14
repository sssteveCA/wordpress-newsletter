<?php

namespace Newsletter\Classes;

use Newsletter\Enums\Langs;

class HtmlCode{

    /**
     * Admin subscriber add form
     */
    public static function adminAddForm(): string{
        $html = <<<HTML
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
        return $html;
    }
    
    /**
     * Admin subscriber delete form
     */
    public static function adminDelForm(): string{
        $html =<<<HTML
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
                return $html; 
    }

    /**
     * Admin newsletter send form
     */
    public static function adminSenderForm(): string{
        $html =<<<HTML
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
        return $html;
    }

    /**
     * Create an HTML page
     * @param string $title page title
     * @param string $body the content inside the body tag
     * @param string $styleTag (optional) <style> tag content
     * @param array $styles (optional) an array that contains css files
     * @param array $sripts (optional) an array that contains js files
     * @return string the HTML page content
     */
    public static function genericHtml(string $title, string $body, string $styleTag = "",array $styles = [], array $scripts = []):string{
        $stylesS = "";
        $scriptsS = "";
        if(!empty($styles)){
            foreach($styles as $css)
                $stylesS .= '<link rel="stylesheet" href="'.$css.'">';
        }
        if(!empty($scripts)){
            foreach($scripts as $script)
                $scriptsS .= '<script src="'.$script.'"></script>';
        }
        $html = <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$title}</title>
        <meta charset="utf-8">
        {$stylesS}
        {$scriptsS}
        <style>
            {$styleTag}
        </style>
    </head>
    <body>
        {$body}
    </body>
</html>
HTML;
        return $html;
    }

    /**
     * Get the values to be used in the frontend subscribe form
     * @param string $lang
     */
    public static function subscribeFormValues(string $lang):array {
        $privacyUrl = Properties::privacyUrl($lang);
        $cookieUrl = Properties::cookieUrl($lang);
        $termsUrl = Properties::termsUrl($lang);
        if($lang == Langs::$langs["it"]){
            return [
                "title" => "Newsletter",
                "name_title" => "Il tuo nome (opzionale)", "surname_title" => "Il tuo cognome (opzionale)",
                "ea_title" => "Indirizzo email",
                "cb_label1" => "Dichiaro di aver letto l' <a href=\"{$privacyUrl}\">informativa sulla privacy</a> e sui <a href=\"{$cookieUrl}\">cookie</a>, acconsento al trattamento dei miei dati personali",
                "cb_label2" => "Ho letto e accettato i <a href=\"{$termsUrl}\">termini e condizioni</a> del servizio",
                "subscribe_text" => "Iscriviti","lang_code" => "it"
            ];
        }//if($lang == Langs::Italian){
        else if($lang == Langs::$langs["es"]){
            return [
                "title" => "Bolet??n informativo", "name_title" => "
                Tu nombre (opcional)", "surname_title" => "Tu apellido (opcional)",
                "ea_title" => "Correo electr??nico", 
                "cb_label1" => "Declaro haber le??do la <a href=\"{$privacyUrl}\">informaci??n sobre privacidad</a> y <a href=\"{$cookieUrl}\">cookies</a>, acepto el tratamiento de mis datos personales",
                "cb_label2" => "He le??do y acepto los <a href=\"{$termsUrl}\">t??rminos y condiciones</a> del servicio",
                "subscribe_text" => "Subscribir","lang_code" => "es"
            ];
        }//else if($lang == Langs::Espanol){
        else{
           return [
            "title" => "Newsletter", "name_title" => "
            Your name (optional)", "surname_title" => "
            Your surname (optional)",
            "ea_title" => "Email address",
            "cb_label1" => "I declare that I have read the <a href=\"{$privacyUrl}\">information on privacy</a> and <a href=\"{$cookieUrl}\">cookies</a>, I agree to the processing of my personal data",
            "cb_label2" => "I have read and agreed with the <a href=\"{$termsUrl}\">terms and conditions</a> of the service",
            "subscribe_text" => "Subscribe","lang_code" => "en"
           ]; 
        }
    }

    /**
     * Get the values to be used in the verify page form
     * @param string $lang
     */
    public static function verifyFormValues(string $lang):array {
        if($lang == Langs::$langs["it"]){
            return [
                "bt_text" => "VERIFICA",
                "h2_title" => "Inserisci il codice di verifica",
                "label_verCode" => "Codice",
                "legend_title" => "Iscrizione newsletter"
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                "bt_text" => "VERIFICAR",
                "h2_title" => "Introduzca el c??digo de verificaci??n",
                "label_verCode" => "C??digo",
                "legend_title" => "Suscripci??n al bolet??n informativo"
            ];
        }
        else{
            return [
                "bt_text" => "VERIFY",
                "h2_title" => "Enter the verification code",
                "label_verCode" => "Code",
                "legend_title" => "Newsletter subscription"
            ];
        }
    }

    /**
     * Frontend newsletter register form
     * @param array $params
     */
    public static function wpSignupForm(array $params): string{
        $html =<<<HTML
<fieldset id="nl_form_fieldset" class="position-relative w-50 mx-auto border border-primary d-flex flex-column align-items-center" style="margin-bottom: 50px; min-width: 300px;">
    <legend class="text-center">{$params['title']}</legend>
    <h2 class="text-center"></h2>
    <form id="nl_form" class="ml-5 mb-5 d-flex flex-column" action="#" method="post"> 
        <div class="container">
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_name" class="form-label">{$params['name_title']}</label>
                    <input type="text" class="form-control" id="nl_name" name="name">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_surname" class="form-label">{$params['surname_title']}</label>
                    <input type="text" class="form-control" id="nl_surname" name="surname">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12">
                    <label for="nl_email" class="form-label">{$params['ea_title']}</label>
                    <input type="email" class="form-control" id="nl_email" name="email" required>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12 form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="nl_cb_privacy" name="cb_privacy" required>
                    <label class="form-check-label" for="nl_cb_privacy">{$params['cb_label1']}</label>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12 form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="nl_cb_terms" name="cb_terms" required>
                    <label class="form-check-label" for="nl_cb_terms">{$params['cb_label2']}</label>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-7 text-end">
                    <button id="nl_submit" type="submit" class="btn btn-dark mb-5" disabled>{$params['subscribe_text']}</button>
                </div>
                <div class="col-5">
                    <div id="nl_spinner" class="spinner-border text-dark invisible" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="nl_lang" name="lang" value="{$params['lang_code']}">
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