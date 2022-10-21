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
        if($lang == Langs::Italian->value){
            return "Inserisci un codice di attivazione per continuare";
        }
        else if($lang == Langs::Espanol->value){
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
    public static function invalidCode(string $lang): string{
        if($lang == Langs::Italian->value){
            return "Codice di verifica non valido";
        }
        else if($lang == Langs::Espanol->value){
            return "Código de verificación invalido";
        }
        else{
            return "Invalid verification code";
        }
    }

    /**
     * Get the subscribe completed message in user language
     * @param string $lang the user language
     * @return string the subscribe completed message
     */
    public static function subscribeCompleted(string $lang): string{
        if($lang == Langs::Italian->value){
            return "Iscrizione alla newsletter completata";
        }
        else if($lang == Langs::Espanol->value){
            return "Suscripción al boletín completada";
        }
        else{
            return "Newsletter subscription completed";
        }
    }
}
?>