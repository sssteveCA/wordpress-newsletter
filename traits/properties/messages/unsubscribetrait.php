<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait UnsubscribeTrait{

    /**
     * Get the invalid unsubscribe code message in user language
     * @param string $lang the user language
     * @return string the invalid unsubscribe code message
     */
    public static function invalidCode(string $lang): string{
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
}
?>