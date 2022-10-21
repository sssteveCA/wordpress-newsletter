<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait VerifyTrait{

    /**
     * Get the insert code message in user language
     * @param string $lang the user language
     * @return string the insert code message
     */
    public static function insertCode(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Inserisci un codice di attivazione per continuare";
        }
        else if($lang == Langs::$langs["es"]){
            return "Introduzca el código de verificación para continuar";
        }
        else{
            return "Enter the verification code to continue";
        }
    }

    /**
     * Get the invalid code message in user language
     * @param string $lang the user language
     * @return string the invalid code message
     */
    public static function invalidCodeVt(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Codice di verifica non valido";
        }
        else if($lang == Langs::$langs["es"]){
            return "Código de verificación invalido";
        }
        else{
            return "Invalid verification code";
        }
    }

    /**
     * Get the newsletter subscribe title in user language
     * @param string $lang the user language
     * @return string the newsletter subscribe title
     */
    public static function newsletterSubscribeTitle(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Iscrizione newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Suscripción al boletín informativo";
        }
        else{
            return "Newsletter subscription";
        }
    }

    /**
     * Get the subscribe completed message in user language
     * @param string $lang the user language
     * @return string the subscribe completed message
     */
    public static function subscribeCompleted(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Iscrizione alla newsletter completata";
        }
        else if($lang == Langs::$langs["es"]){
            return "Suscripción al boletín completada";
        }
        else{
            return "Newsletter subscription completed";
        }
    }
}
?>