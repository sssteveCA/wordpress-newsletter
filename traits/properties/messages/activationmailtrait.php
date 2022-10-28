<?php

namespace Newsletter\Traits\Properties\Messages;

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
}
?>