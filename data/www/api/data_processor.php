<?php

// here we 'process' data with random delay 10-20 sec
//
// returns number*2 and data array with number key

$sPOST = file_get_contents('php://input');
$oPOST = json_decode($sPOST);

$randomWait = rand(10,20);

sleep($randomWait);

$resOut = [];
$resOut['number'] = intval($oPOST->number);
$resOut['data'] = $oPOST->data;
$resOut['data']['number'] = $resOut['number'] * 2;

header('Content-type: application/json');
print(json_encode($resOut));



?>
