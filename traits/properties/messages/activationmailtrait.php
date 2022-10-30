<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

trait ActivationMailTrait{

    /**
     * Get the activation mail <title> tag content
     * @param string $lang the user language
     * @return  string the activation mail <title> tag content
     */
    public static function activationMailTitle(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Iscrizione Newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Suscripción al boletín informativo";
        }
        else{
            return "Newsletter subscription"; 
        }
    }

    /**
     * Get the activation mail click link message
     * @param string $lang the user language
     * @param string $link the user activation URL
     * @return string the activation mail click link message
     */
    public static function clickActivationLink(string $lang, string $link): string{
        if($lang == Langs::$langs["it"]){
            return "Per completare l'iscrizione alla newsletter fare click a <a href=\"{$link}\">questo link</a>";
        }
        else if($lang == Langs::$langs["es"]){
            return "Para completar la suscripción al boletín, haga clic en <a href=\"{$link}\">este enlace</a>";
        }
        else{
            return "To complete the newsletter subscription click on <a href=\"{$link}\">this link</a>";
        }
    }

    /**
     * Get the alternative way activation mail message
     * @param string $lang the user language
     * @param string $verifyUrl the URL to verify the account
     * @param string $code the user activation code
     * @return string the alternative way activation mail message
     */
    public static function clickActivationLinkWithCode(string $lang,string $verifyUrl, string $code): string{
        if($lang == Langs::$langs["it"]){
           return <<<HTML
O in alternativa fai click su <a href="{$verifyUrl}">questo link</a><br>
E incolla questo codice: {$code}
HTML;
        }
        else if($lang == Langs::$langs["es"]){
            return <<<HTML
O, alternativamente, haga clic en <a href="{$verifyUrl}">este enlace</a><br>
Y pega este código: {$code}
HTML;
        }
        else{
            return <<<HTML
Or alternatively click on <a href="{$verifyUrl}">this link</a><br>
And paste this code: {$code}
HTML;
        }
    }

    /**
     * Get the activation mail more information message
     * @param string $lang the user language
     * @return string the activation mail more information message
     */
    public static function moreInformation(string $lang): string{
        $contactUrl = Properties::contactsUrl($lang);
        if($lang == Langs::$langs["it"]){
            return "Per maggiori informazioni <a href=\"".$contactUrl."\">contattaci</a>";
        }
        else if($lang == Langs::$langs["es"]){
            return "Para más información <a href=\"".$contactUrl."\">contáctenos</a>";
        }
        else{
            return "For more information <a href=\"".$contactUrl."\">contact us</a>";
        }
    }

    /**
     * Get the messages used in activation mail template in user language
     * @param string $lang the user language
     * @param array $params an array of values, used in the mail
     * @return array an array containing the message used in activation mail in the user language
     */
    public static  function activationMailMessages(string $lang, array $params):array {
        $code = $params['code'];
        $contactUrl = $params['contactUrl'];
        $link = $params['link'];
        $verifyUrl = $params['verifyUrl'];
        if($lang == Langs::$langs["it"]){
            return [
                "codeWithLink" => <<<HTML
O in alternativa fai click su <a href="{$verifyUrl}">questo link</a><br>
E incolla questo codice: {$code}
HTML,
                "link" => "Per completare l'iscrizione alla newsletter fare click a <a href=\"{$link}\">questo link</a>",
                "moreInfo" => "Per maggiori informazioni <a href=\"".$contactUrl."\">contattaci</a>",
                "title" => "Iscrizione Newsletter"
            ];
        }
        else if($lang == Langs::$langs["es"]){
            return [
                "codeWithLink" => <<<HTML
O, alternativamente, haga clic en <a href="{$verifyUrl}">este enlace</a><br>
Y pega este código: {$code}
HTML,
                "link" => "Para completar la suscripción al boletín, haga clic en <a href=\"{$link}\">este enlace</a>",
                "moreInfo" => "Para más información <a href=\"".$contactUrl."\">contáctenos</a>",
                "title" => "Suscripción al boletín informativo"
            ];
        }
        else{
            return [
                "codeWithLink" => <<<HTML
Or alternatively click on <a href="{$verifyUrl}">this link</a><br>
And paste this code: {$code}
HTML,
                "link" => "To complete the newsletter subscription click on <a href=\"{$link}\">this link</a>",
                "moreInfo" => "For more information <a href=\"".$contactUrl."\">contact us</a>",
                "title" => "Newsletter subscription"
            ];
        }
    }
}
?>