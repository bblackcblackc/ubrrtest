//////////////////////////////////////////////////////////////////
// Queue state ops

var qStateURL = '/api/queue_state.php';

function updateQueueState() {

    var xhr = new XMLHttpRequest();
    xhr.open("GET", qStateURL, true);
    xhr.onreadystatechange = function(data) {
	    if ((xhr.readyState === XMLHttpRequest.DONE) && (xhr.status === 200)) {
		var respObject = JSON.parse(xhr.responseText)
		var qStateDiv = document.getElementById('queue-state');
		var text = 'Workers: ' + respObject.workers +
			'<br />Processed: ' + respObject.processed +
			'<br />Processing: ' + respObject.processing +
			'<br />Unprocessed: ' + respObject.unprocessed;
		qStateDiv.innerHTML = text;
	    }
	};
    xhr.send();
}

