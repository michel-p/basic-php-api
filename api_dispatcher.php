<?php

require_once 'DeezerAPI.php';

try {
    $API = new DeezerAPI($_REQUEST['request']);
    echo $API->processEndPointMethod();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}