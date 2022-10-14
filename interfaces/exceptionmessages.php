<?php

namespace Newsletter\Interfaces;

interface ExceptionMessages{
     //Exceptions
     const EXC_INVALID_FIELD = "Il campo specificato non esiste nella tabella utenti";
    const EXC_INVALID_USERSARRAY = "L' array con gli utenti non è formattato correttamente";
    const EXC_DATA_MISSED = "Uno o più dati richiesti sono mancanti";
     const NOTISSET_EXC = "Non sono stati forniti i dati richiesti";
}
?>