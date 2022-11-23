<?php

namespace Newsletter\Interfaces;

/**
 * Interface implemented by AdminUserSubscribe and UserSubscribe classes
 */
interface SubscribeErrors{
    const FROM_USER = 1;
    const INCORRECT_EMAIL = 2;
    const EMAIL_EXISTS = 3;

    const FROM_USER_MSG = "Errore dall'oggetto User";
    const INCORRECT_EMAIL_MSG = "L' indirizzo email inserito non è in un formato valido";
    const EMAIL_EXISTS_MSG = "Un utente con questo indirizzo email esiste già";
}
?>