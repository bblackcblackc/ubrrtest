<?php

require_once('config.php');

$sPOST = file_get_contents('php://input');
$oPOST = json_decode($sPOST);

$conn = new mysqli(DB_HOST,DB_LOGIN,DB_PASS,DB_NAME);

$sData = $conn->real_escape_string(json_encode($oPOST->data));
$iID = intval($oPOST->id);

$sQuery = 'INSERT INTO `input_queries` (`advert_id`,`data`) VALUES (' . $iID . ', ' . $sData . ')';
$qResult = $conn->query($sQuery);
$idResult = $conn->insert_id;

$conn->close();

$resOut = [];

if ($qResult < 1) {
    $resOut['error'] = true;
} else {
    $resOut['id'] = $idResult;
}

header("Content-type: application/json");
print(json_encode($resOut));

?>
