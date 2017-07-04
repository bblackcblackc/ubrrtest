<?php

require_once('config.php');

$conn = new mysqli(DB_HOST,DB_LOGIN,DB_PASS,DB_NAME);

// query unprocessed
$sQueryUnproc = 'SELECT COUNT(*) AS unproc FROM `' . INPUT_TABLE . '` WHERE `processing_worker` IS NULL';
$oUnproc = $conn->query($sQueryUnproc);
$resUnproc = intval($oUnproc->fetch_assoc()['unproc']);

// query processing
$sQueryProc = 'SELECT COUNT(*) AS proc FROM `' . INPUT_TABLE . '` WHERE `processing_worker` IS NOT NULL';
$oProc = $conn->query($sQueryProc);
$resProc = intval($oProc->fetch_assoc()['proc']);

// query processed
$sQueryProcessed = 'SELECT COUNT(*) AS processed FROM `' . OUTPUT_TABLE . '`';
$oProcessed = $conn->query($sQueryProcessed);
$resProcessed = intval($oProcessed->fetch_assoc()['processed']);

// query workers
$sQueryWorkers = 'SELECT COUNT(DISTINCT processing_worker) AS workers FROM `' . INPUT_TABLE . '` WHERE `processing_worker` IS NOT NULL';
$oWorkers = $conn->query($sQueryWorkers);
$resWorkers = intval($oWorkers->fetch_assoc()['workers']);

$conn->close();

$result = [
	'unprocessed' => $resUnproc,
	'processing' => $resProc,
	'processed' => $resProcessed,
	'workers' => $resWorkers
    ];

header('Content-type: application/json');
print(json_encode($result));

?>
