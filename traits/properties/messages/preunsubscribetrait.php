<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait PreUnsubscribeTrait{

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