<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

/**
 * Other multi-language messages
 */
trait OtherTrait{

    /**
     * Get the missing form values message in user language
     * @param string $lang the user language
     * @return string the missing form value message
     */
    public static function missingFormValues(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Compila tutti i campi richiesti per continuare";
        }
        else if($lang == Langs::$langs["es"]){
            return "Complete todos los campos requeridos para continuar";
        }
        else{
            return "Fill all required fields to continue";
        }
    }

    /**
     * Get the unknown error message in user language
     * @param string $lang the user language
     * @return string the unknown error message
     */
    public static function unknownError(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Errore sconosciuto. Se il problema persiste contattare l'amministratore del sito.";
        }
        else if($lang == Langs::$langs["es"]){
            return "Error desconocido. Si el problema persiste, comuníquese con el administrador del sitio.";
        }
        else{
            return "
            Unknown error. If the problem persists, contact the site administrator";
        }
    }

}
?>