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
    <div id="nl_del_content" class="mt-4 mx-auto container-fluid">
        <div class="row">
            <div class="col-12 col-md-3">
                <label for="nl_email" class="form-label">Email</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_email" class="form-control" name="email">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <label for="nl_lang_code" class="form-label">Codice lingua</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_lang_code" class="form-control" name="lang_code">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <label for="nl_unsubscibe_code" class="form-label">Codice disiscrizione</label>
            </div>
            <div class="col-12 col-md-9">
                <input type="text" id="nl_unsubscibe_code" class="form-control" name="unsubscibe_code">
            </div>
        </div>
        <div class="row justify-content-between justify-content-md-evenly">
            <div class="col-4 col-md-3">
                <button type="submit" class="btn btn-primary">AGGIUNGI</button>
            </div>
            <div class="col-4 col-md-3">
                <button type="reset" class="btn btn-danger">ANNULLA</button>
            </div>
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
            <div id="nl_del_content" class="mt-4 mx-auto">
                <div id="nl_del_content_email" class="border border-dark overflow-auto">
                </div>
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
            <div id="nl_del_button" class="text-center mt-4">
                <button type="submit" id="nl_bt_del_email" class="btn btn-primary mt-4">RIMUOVI ISCRITTI</button>
            <div>
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
    <div class="d-lg-flex justify-content-lg-between">
        <div id="nl_send_message" class="mt-4 mx-auto">
            <textarea id="nl_msg_text" name="message" required></textarea>
        </div>
        <div class="mt-4 mx-auto">
            <div id="nl_send_content" class="border border-dark overflow-auto">
            </div>
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
    <div id="nl_send_button" class="text-center mt-4">
        <button type="submit" id="nl_bt_send_content" class="btn btn-primary">INVIA MAIL</button>
    <div>
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
     */
    public static function subscribeFormValues(Langs $lang):array {
        $privacyUrl = Properties::privacyUrl($lang);
        $cookieUrl = Properties::cookieUrl($lang);
        $termsUrl = Properties::termsUrl($lang);
        if($lang == Langs::Italian){
            return [
                "title" => "Newsletter","ea_title" => "Indirizzo email",
                "cb_label1" => "Dichiaro di aver letto l' <a href=\"{$privacyUrl}\">informativa sulla privacy</a> e sui <a href=\"{$cookieUrl}\">cookie</a>, acconsento al trattamento dei miei dati personali",
                "cb_label2" => "Ho letto e accettato i <a href=\"{$termsUrl}\">termini e condizioni</a> del servizio",
                "subscribe_text" => "Iscriviti","lang_code" => "it"
            ];
        }//if($lang == Langs::Italian){
        else if($lang == Langs::Espanol){
            return [
                "title" => "Boletín informativo","ea_title" => "Correo electrónico",
                "cb_label1" => "Declaro haber leído la <a href=\"{$privacyUrl}\">información sobre privacidad</a> y <a href=\"{$cookieUrl}\">cookies</a>, acepto el tratamiento de mis datos personales",
                "cb_label2" => "He leído y acepto los <a href=\"{$termsUrl}\">términos y condiciones</a> del servicio",
                "subscribe_text" => "Subscribir","lang_code" => "es"
            ];
        }//else if($lang == Langs::Espanol){
        else{
           return [
            "title" => "Newsletter","ea_title" => "Email address",
            "cb_label1" => "I declare that I have read the <a href=\"{$privacyUrl}\">information on privacy</a> and <a href=\"{$cookieUrl}\">cookies</a>, I agree to the processing of my personal data",
            "cb_label2" => "I have read and agreed with the <a href=\"{$termsUrl}\">terms and conditions</a> of the service",
            "subscribe_text" => "Subscribe","lang_code" => "en"
           ]; 
        }
    }

    /**
     * Frontend newsletter register form
     */
    public static function wpSignupForm(array $params): string{
        $html =<<<HTML
<fieldset id="nl_form_fieldset" class="position-relative w-50 mx-auto border border-primary d-flex flex-column align-items-center" style="margin-bottom: 50px; min-width: 300px;">
    <legend class="text-center">{$params['title']}</legend>
    <form id="nl_form" class="ml-5 mb-5 d-flex flex-column" action="#" method="post"> 
        <div class="m-4">
            <label for="nl_email" class="form-label">{$params['ea_title']}</label>
            <input type="email" class="form-control" id="nl_email" required>
        </div>
        <div class="m-4 form-check">
            <input class="form-check-input" type="checkbox" value="1" id="nl_check_pc" name="privcook">
            <label class="form-check-label" for="nl_check_pc">{$params['cb_label1']}</label>
        </div>
        <div class="m-4 form-check">
            <input class="form-check-input" type="checkbox" value="1" id="nl_check_terms" name="terms">
            <label class="form-check-label" for="nl_check_terms">{$params['cb_label2']}</label>
        </div>
        <div class="d-flex justify-content-center">
            <button id="nl_submit" type="submit" class="btn btn-dark mb-5" disabled>{$params['subscribe_text']}</button>
        </div>
        <input type="hidden" id="nl_lang" name="lang" value="{$params['lang_code']}">
    </form>
</fieldset>
HTML;
        return $html;
    }
}
?>