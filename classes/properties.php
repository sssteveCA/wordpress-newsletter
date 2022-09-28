<?php

namespace Newsletter\Classes;
use Newsletter\Enums\Langs;

class Properties{

    /**
     * Get the site home URL
     */
    public static function homeUrl(){ return home_url(); }

    /**
     * Get the site plugins URL
     */
    public static function pluginsUrl(){ return plugins_url(); }

    /**
     * Get the current plugin home URL 
     */
    public static function pluginUrl(string $plugin){
        return plugin_dir_url($plugin);
    }

    /**
     * Get the values to be used in the frontend subscribe form
     */
    public static function subscribeFormValues(Langs $lang): array{
        $values = [];
        $home_url = Properties::homeUrl();
        if($lang == Langs::Italian){
            $values = [
                "title" => "Newsletter","ea_title" => "Indirizzo email",
                "cb_label1" => "Dichiaro di aver letto l' informativa sulla privacy e sui cookie, acconsento al trattamento dei miei dati personali",
                "cb_label2" => "Ho letto e accettato i Termini e condizioni del servizio",
                "subscribe_text" => "Iscriviti","lang_code" => "it"
            ];
        }//if($lang == Langs::Italian){
        else if($lang == Langs::Espanol){
            $values = [
                "title" => "Boletín informativo","ea_title" => "Correo electrónico",
                "cb_label1" => "Declaro haber leído la información sobre privacidad y cookies, acepto el tratamiento de mis datos personales",
                "cb_label2" => "He leído y acepto los Términos y condiciones del servicio",
                "subscribe_text" => "Subscribir","lang_code" => "es"
            ];
        }//else if($lang == Langs::Espanol){
        else{
           $values = [
            "title" => "Newsletter","ea_title" => "Email address",
            "cb_label1" => "I declare that I have read the information on privacy and cookies, I agree to the processing of my personal data",
            "cb_label2" => "I have read and agreed with the Terms and conditions of the service",
            "subscribe_text" => "Subscribe","lang_code" => "en"
           ]; 
        }
        return $values;
    }
}

?>