<?php

namespace Newsletter\Traits\Properties\Messages;

use Newsletter\Enums\Langs;

trait VerifyTrait{

    public function InsertCode(Langs $lang): string{
        if($lang == Langs::Italian){
            return "Inserisci un codice di attivazione per continuare";
        }
        else if($lang == Langs::Espanol){
            return "Introduzca el código de verificación para continuar";
        }
        else{
            return "Enter the verification code to continue";
        }
    }
}
?>