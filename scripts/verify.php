<?php

require_once("../../wp-load.php");
require_once("../interfaces/constants.php");
require_once("../interfaces/exceptionmessages.php");
require_once("../interfaces/messages.php");
require_once("../exceptions/incorrectvariableformatexception.php");
require_once("../exceptions/notsettedexception.php");
require_once("../traits/errortrait.php");
require_once("../traits/modeltrait.php");
require_once("../traits/usertrait.php");
require_once("../traits/usercommontrait.php");
require_once("../classes/database/tables/table.php");
require_once("../classes/database/model.php");
require_once("../classes/database/models/user.php");
require_once("../classes/verifyemail.php");

use Newsletter\Classes\VerifyEmail;

if(isset($_GET['verCode'])){

}//if(isset($_GET['verCode'])){


?>