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

    /**
     * Get the not filled required message for the new user form
     * @param string $lang the user language
     * @return string the not fileld required message
     */
    public static function fillRequiredFields(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "Compila tutti i campi richiesti per continuare";
        }
        else if($lang == Langs::$langs["es"]){
            return "Rellene todos los campos obligatorios para continuar";
        }
        else{
            return "Fill in all the required fields to continue";
        }
    }

    /**
     * Get the user email already exists message in user language
     * @param string $lang the user language
     * @return string the user email already message
     */
    public static function emailExists(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "L'indirizzo email inserito esiste già";
        }
        else if($lang == Langs::$langs["es"]){
            return "La dirección de correo electrónico ingresada ya existe";
        }
        else{
            return "The email address entered already exists";
        }
    }

    /**
     * Get the wrong email format message in user language
     * @param string $lang the user language
     * @return string the wrong email format message
     */
    public static function wrongEmailFormat(string $lang): string{
        if($lang == Langs::$langs["it"]){
            return "L'indirizzo email inserito non è valido";
        }
        else if($lang == Langs::$langs["es"]){
            return "La dirección de correo electrónico ingresada no es válida";
        }
        else{
            return "The email address entered is invalid";
        }
    }
}
?>