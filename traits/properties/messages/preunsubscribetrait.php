<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Classes\Properties;
use Newsletter\Enums\Langs;

trait PreUnsubscribeTrait{

    /**
     * Get the title of the pre unsubscribe script
     * @param string $lang the user language
     * @return string the pre unsubscribe title tag content
     */
    public static function preUnsubscribeErrorMessage(string $lang): string{
        $contactsUrl = Properties::contactsUrl($lang);
        if($lang == Langs::$langs["it"]){
            return <<<HTML
Impossibile trovare i dati richiesti per completare la disiscrizione, riprova.
Se il problema persiste <a href="{$contactsUrl}">contatta l'amministratore del sito</a>
HTML;
        }
        else if($lang == Langs::$langs["es"]){
            return <<<HTML
No se pudieron encontrar los datos necesarios para completar la cancelación desde el boletín, inténtelo de nuevo.
Si el problema persiste <a href="{$contactsUrl}">comuníquese con el administrador del sitio</a>
HTML;
        }
        else{
            return <<<HTML
Could not find the data required to complete the unsubscription, try again.
If the problem persists <a href="{$contactsUrl}">contact the site administrator</a>
HTML;            
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