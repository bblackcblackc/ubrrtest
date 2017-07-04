<?php

require_once('../api/config.php');

$externalProcessURL = GEN_URL . 'api/data_processor.php';

//$conn = new mysqli(DB_HOST,DB_LOGIN,DB_PASS,DB_NAME);

while(true) {

    print('------------------------' . PHP_EOL);

    $conn = new mysqli(DB_HOST,DB_LOGIN,DB_PASS,DB_NAME);

    // get total unproc records
    $sQueryUnproc = 'SELECT * FROM `' . INPUT_TABLE . '` WHERE `processing_worker` IS NULL';
    $oUnproc = $conn->query($sQueryUnproc);
    $unprocRecords = $conn->affected_rows;
    print($unprocRecords . ' unprocessed records total' . PHP_EOL);

    if ($unprocRecords <= 0) {
	print('No data for processing' . PHP_EOL);
    }

    // get total queued rec
    $sQueryQueued = 'SELECT * FROM `' . INPUT_TABLE . '` WHERE `processing_worker` IS NOT NULL';
    $oProc = $conn->query($sQueryQueued);
    $procRecords = $conn->affected_rows;
    print($procRecords . ' processing records total' . PHP_EOL);

    if ($procRecords >= MAX_WORKERS) {
	print('Workers limit reached' . PHP_EOL);
	sleep(1);
	continue;
    }

    for($i = 0; $i < MAX_WORKERS_START; $i++) {

	// fetch data
	$forProcessing = $oUnproc->fetch_assoc();

	if ($forProcessing == null) {
	    continue;
	}

	print('Worker starting...' . PHP_EOL);
	$childPID = pcntl_fork();
	if ($childPID == 0) {
	    // parent process
	    continue;
	} else {

	    //////////////////////////////////////////////////////////
	    // child process
	    
	    print('Worker[' . $childPID . '] goes on' . PHP_EOL);
	    $workerConn = new mysqli(DB_HOST,DB_LOGIN,DB_PASS,DB_NAME);
	    
	    $id = $forProcessing['id'];
	    $advertId = $forProcessing['advert_id'];
	    $advertData = $forProcessing['data'];
	    
	    // lock records for working
	    $lockQuery = 'UPDATE ' . INPUT_TABLE . ' SET processing_worker = ' . $childPID . ' WHERE id = ' . $id;
	    $workerConn->query($lockQuery);
	
		//////////////////////////////////////////
		// SLOW STAT REQUEST
		$oData = [];
		$oData['number'] = $advertId;
		$oData['data'] = json_decode($advertData);
		$sData = json_encode($oData);
	
		$oCURL = curl_init($externalProcessURL);
		curl_setopt($oCURL, CURLOPT_POST, TRUE);
		curl_setopt($oCURL, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($oCURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($oCURL, CURLOPT_POSTFIELDS, $sData);
		$sResult = curl_exec($oCURL);
		//
		/////////////////////////////////////////

	    print('Worker[' . $childPID . '] got answer from slow query.' . PHP_EOL);
	    $oResult = json_decode($sResult);
	    
	    $respData = $workerConn->real_escape_string(json_encode($oResult->data));
	    $respID = intval($oResult->number);
	    
	    // save data from SLOW QUERY
	    $writeQuery = 'INSERT INTO `' . OUTPUT_TABLE . '` (response_id,advert_id,data) VALUES (' . $respID . ', ' . $id . ', "' . $respData . '")';
	    $workerConn->query($writeQuery);

	    // delete processing record
	    $deleteQuery = 'DELETE FROM ' . INPUT_TABLE . ' WHERE id = ' . $id;
	    $workerConn->query($deleteQuery);
	    
	    $workerConn->close();
	    $conn->close();
	    print('Worker[' . $childPID . '] mission complete' . PHP_EOL);
	    
	    exit(0);
	    
	    //
	    //////////////////////////////////////////////////////////
	}
    }
    
    $conn->close();

    sleep(1);

}

$conn->close();


?>
