<?php

require_once("../../../../../wp-load.php");
require_once("../../interfaces/exceptionmessages.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/modeltrait.php");
require_once("../../traits/sqltrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/usertrait.php");
require_once("../../traits/userstrait.php");
require_once("../../traits/errortrait.php");
require_once("../../traits/emailmanagertrait.php");
require_once("../../vendor/autoload.php");
require_once("../../classes/database/tables/table.php");
require_once("../../classes/database/model.php");
require_once("../../classes/database/models/user.php");
require_once("../../classes/database/models/users.php");
require_once("../../classes/email/emailmanager.php");

$response = [
    'done' => false, 'msg' => ''
];

echo json_encode($response,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
?>

