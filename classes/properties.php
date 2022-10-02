<?php

namespace Newsletter\Classes;
use Newsletter\Enums\Langs;

class Properties{

    /**
     * Get the contacts form link
     */
    public static function contactsUrl(Langs $lang): string{
        $home_url = Properties::homeUrl();
        if($lang == Langs::Italian){ return $home_url.'/contatti/'; }
        else if($lang == Langs::Espanol){ return $home_url.'/es/contactos-2/'; }
        else { return $home_url.'/en/contacts-2/'; }
    }

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