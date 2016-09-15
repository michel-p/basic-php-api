<?php

require_once "classes/autoload.php";
require_once "config/dbconfig.php";

use BasicPHPAPI\API\DeezerAPI;

try {
    $API = new DeezerAPI($_REQUEST['request']);
    echo $API->processEndPointMethod();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}