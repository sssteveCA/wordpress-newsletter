<?php

namespace Newsletter\Traits;
use Newsletter\Enums\Langs;

/**
 * Trait used by HtmlCode class
 */
trait HtmlCodeTrait{

    /**
     * Get the values to be used in the frontend subscribe form
     * @param string $lang
     */
    public static function subscribeFormValues(string $lang, array $settings):array {
        $privacyUrl = isset($settings['privacy_policy_pages'][$lang]) ? $settings['privacy_policy_pages'][$lang] : "" ;
        $cookieUrl = isset($settings['cookie_policy_pages'][$lang]) ? $settings['cookie_policy_pages'][$lang] : "" ;
        $termsUrl = isset($settings['terms_pages'][$lang]) ? $settings['terms_pages'][$lang] : "" ;
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
                "title" => "Boletín informativo", "name_title" => "
                Tu nombre (opcional)", "surname_title" => "Tu apellido (opcional)",
                "ea_title" => "Correo electrónico", 
                "cb_label1" => "Declaro haber leído la <a href=\"{$privacyUrl}\">información sobre privacidad</a> y <a href=\"{$cookieUrl}\">cookies</a>, acepto el tratamiento de mis datos personales",
                "cb_label2" => "He leído y acepto los <a href=\"{$termsUrl}\">términos y condiciones</a> del servicio",
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
                "h2_title" => "Introduzca el código de verificación",
                "label_verCode" => "Código",
                "legend_title" => "Suscripción al boletín informativo"
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

}
?>