<?php

namespace Newsletter\Interfaces;

interface ExceptionMessages{
     //Exceptions
     const EXC_INVALID_FIELD = "Il campo specificato non esiste nella tabella utenti";
     const EXC_INVALID_TYPE = "La variabile è di tipo diverso da quello richiesto";
     const EXC_INVALID_USERSARRAY = "L' array con gli utenti non è formattato correttamente";
     const EXC_DATA_MISSED = "Uno o più dati richiesti sono mancanti";
     const EXC_NOTISSET = "Non sono stati forniti i dati richiesti";
}
?>