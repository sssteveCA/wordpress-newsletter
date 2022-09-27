<?php

namespace Newsletter\Classes;

class HtmlCode{
    
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