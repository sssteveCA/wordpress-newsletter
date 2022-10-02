<?php

namespace Newsletter\Classes;
use Newsletter\Enums\Langs;

class Properties{

    /**
     * Get the cookie policy link
     */
    public static function cookieUrl(Langs $lang): string{
        $home_url = Properties::homeUrl();
        if($lang == Langs::Italian){ return $home_url."/cookie-policy/";}
        else if($lang == Langs::Espanol){ return $home_url."/es/cookie-policy-2/"; }
        else{ return $home_url."/en/cookie-policy-3/"; }
    }

    /**
     * Get the facebook logo URL
     */
    public static function facebookLogoUrl(): string{
        $home_url = Properties::homeUrl();
        return $home_url."/wp-content/uploads/2018/11/1000px-F_icon.svg_-e1541173415423.png";
    }

    /**
     * Get the site home URL
     */
    public static function homeUrl():string { return home_url(); }

    /**
     * Get the instagram logo URL
     */
    public static function instagramLogoUrl(): string{
        $home_url = Properties::homeUrl();
        return $home_url."/wp-content/uploads/2018/11/instagram_logo-e1541173378259.png";
    }

    /**
     * Get the privacy policy link
     */
    public static function privacyUrl(Langs $lang):string {
        $home_url = Properties::homeUrl();
        if($lang == Langs::Italian){ return $home_url."/privacy-policy/";}
        else if($lang == Langs::Espanol){ return $home_url."/es/privacy-policy-2/"; }
        else{ return $home_url."/en/privacy-policy-3/"; }
    }

    /**
     * Get the site plugins URL
     */
    public static function pluginsUrl():string { return plugins_url(); }

    /**
     * Get the current plugin home URL 
     */
    public static function pluginUrl(string $plugin):string {return plugin_dir_url($plugin);}

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
     * Get the terms and conditions document URL
     */
    public static function termsUrl(Langs $lang):string {
        $home_url = Properties::homeUrl();
        if($lang == Langs::Italian){ return $home_url."/termini-e-condizioni/";}
        else if($lang == Langs::Espanol){ return $home_url."/en/terms-and-conditions/"; }
        else{ return $home_url."/en/privacy-policy-3/"; }
    }

    /**
     * Get the YouTube logo URL
     */
    public static function youtubeLogoUrl(): string{
        $home_url = Properties::homeUrl();
        return $home_url."/wp-content/uploads/2018/11/youtube.jpg";
    }
}

?>