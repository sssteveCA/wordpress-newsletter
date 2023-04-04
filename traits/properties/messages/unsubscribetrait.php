<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait UnsubscribeTrait{

    /**
     * Get the invalid unsubscribe code message in user language
     * @param string $lang the user language
     * @return string the invalid unsubscribe code message
     */
    public static function invalidCodeUt(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Codice non valido";
        }
        else if($lang == Langs::$langs["es"]){
            return "Código invalido";
        }
        else{
            return "Invalid code";
        }
    }

    /**
     * Get the newsletter unsubscribe title tag content in user language
     * @param string $lang the user language
     * @return string the newsletter unsubscribe title tag content
     */
    public static function newsletterUnsubscribeTitle(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Rimozione iscrizione newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Eliminación de la suscripción al boletín";
        }
        else{
            return "Removal of newsletter subscription";
        }
    }

    /**
     * Get the unsubscribe complete  message in user language
     * @param string $lang the user language
     * @return string the unsubscribe complete subscribe message
     */
    public static function unsubscribeComplete(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Hai rimosso la tua iscrizione alla newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Te has dado de baja del boletín";
        }
        else{
            return "You have unsubscribed from the newsletter";
        }
    }

    /**
     * Get the title of the pre unsubscribe script
     * @param string $lang the user language
     * @return string the pre unsubscribe title tag content
     */
    public static function preUnsubscribeTitle(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Conferma disiscrizione dalla newsletter";
        }
        else if($lang == Langs::$langs["es"]){
            return "Confirmar cancelación desde el boletín";
        }
        else{
            return "Confirm newsletter unsubscribe";            
        }
    }
}
?>