<?php

namespace Newsletter\Traits\Properties;

use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

/**
 * URL get methods for Properties class
 */
trait PropertiesUrlTrait{

    /**
     * Get the contacts form link
     */
    public static function contactsUrl(string $lang): string{
        $home_url = Properties::homeUrl();
        if($lang == Langs::$langs["it"]){ return $home_url.'/contatti/'; }
        else if($lang == Langs::$langs["es"]){ return $home_url.'/es/contactos-2/'; }
        else { return $home_url.'/en/contacts-2/'; }
    }

    /**
     * Get the cookie policy link
     */
    public static function cookieUrl(string $lang): string{
        $home_url = Properties::homeUrl();
        if($lang == Langs::$langs["it"]){ return $home_url."/cookie-policy/";}
        else if($lang == Langs::$langs["es"]){ return $home_url."/es/cookie-policy-2/"; }
        else{ return $home_url."/en/cookie-policy-3/"; }
    }

    /**
     * Get the facebook page link
     */
    public static function facebookPageUrl(): string{
        return $_ENV["FACEBOOK_PAGE"];
    }

    /**
     * Get the facebook logo URL
     */
    public static function facebookLogoUrl(): string{
        return Properties::pluginUrl()."assets/images/facebook_logo.png";
    }

    /**
     * Get the site home URL
     */
    public static function homeUrl():string { return home_url(); }

    /**
     * Get the instagram profile URL
     */
    public static function instagramProfileUrl(): string{
        return $_ENV["INSTAGRAM_PROFILE"];
    }

    /**
     * Get the instagram logo URL
     */
    public static function instagramLogoUrl(): string{
        return Properties::pluginUrl()."assets/images/instagram_logo.png";
    }

    /**
     * Get the newsletter name
     */
    public static function newsletterName(): string{
        return $_ENV['NEWSLETTER_NAME'];
    }

    /**
     * Get the privacy policy link
     */
    public static function privacyUrl(string $lang):string {
        $home_url = Properties::homeUrl();
        if($lang == Langs::$langs["it"]){ return $home_url."/privacy-policy/";}
        else if($lang == Langs::$langs["es"]){ return $home_url."/es/privacy-policy-2/"; }
        else{ return $home_url."/en/privacy-policy-3/"; }
    }

    /**
     * Get the site plugins URL
     */
    public static function pluginsUrl():string { return plugins_url(); }

    /**
     * Get the current plugin home URL 
     */
    public static function pluginUrl():string {
        return plugin_dir_url("newsletter/newsletter.php");
    }

    /**
     * Get the terms and conditions document URL
     */
    public static function termsUrl(string $lang):string {
        $home_url = Properties::homeUrl();
        if($lang == Langs::$langs["it"]){ return $home_url."/termini-e-condizioni/";}
        else if($lang == Langs::$langs["es"]){ return $home_url."/en/terms-and-conditions/"; }
        else{ return $home_url."/en/privacy-policy-3/"; }
    }

    /**
     * Get the unsubscribe script URL
     */
    public static function unsubscribeUrl(): string{
        return Properties::pluginUrl()."scripts/browser/subscribe/preunsubscribe.php";
    }

    /**
     * Get the account verify URL
     */
    public static function verifyUrl(): string{
        return Properties::pluginUrl()."scripts/browser/subscribe/verify.php";
    }

    /**
     * Get the YouTube channerl URL
     */
    public static function youtubeChannelUrl(): string{
        return $_ENV["YOUTUBE_CHANNEL"];
    }

    /**
     * Get the YouTube logo URL
     */
    public static function youtubeLogoUrl(): string{
        return Properties::pluginUrl()."assets/images/youtube_logo.jpg";
    }
}
?>