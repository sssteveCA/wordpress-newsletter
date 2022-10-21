<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait NewUserTrait{

    /**
     * Get the newsletter complete subscribe message in user language
     * @param string $lang the user language
     * @return string the newsletter complete subscribe message
     */
    public static function completeSubscribe(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Per completare l'iscrizione accedi alla tua casella di posta";
        }
        else if($lang == Langs::$langs["es"]){
            return "Para completar el registro, inicie sesión en su buzón";
        }
        else{
            return "To complete the newsletter subscription click on this link";
        }
    }
}
?>