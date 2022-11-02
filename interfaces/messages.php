<?php

namespace Newsletter\Interfaces;

/**
 * This interface contains common messages used in many part of the plugin
 */
interface Messages{
    const ADMIN_CONTACT = "Se il problema persiste contattare l'amministratore del sito";
    const ERR_ATLEAST_ONE_EMAIL = "Inserisci almeno un indirizzo email";
    const ERR_MISSING_FORM_VALUES = "Compila tutti i campi richiesti per continuare";
    const ERR_UNAUTHORIZED = "Per effettuare questa operazione devi essere collegato come amministratore";
    const ERR_UNKNOWN = "Errore sconosciuto. ".Messages::ADMIN_CONTACT;
}
?>