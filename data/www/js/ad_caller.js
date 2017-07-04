var servers = [
	    'api1',
	    'api2',
	    'api3',
	    'api4',
	    'api5'
	    ];

var URLSuffix = '.bnk.alfavitt.com:8080/api/ad_caller.php';
var URLPrefix = 'http://';

////////////////////////////////////////////////////////////////
// Server ops

function getRndInt(min,max) {
    return Math.floor((Math.random() * (max - min + 1)) + min);
}

function advertCall(id,data) {
    // call data writing

    // select server
    var serverNum = getRndInt(1,servers.length);
    var selectedServer = 'api' + serverNum;
    
    var url = URLPrefix + selectedServer + URLSuffix; // generate URL
    
    // console.log('AD called with id ' + id + '; data ' + data + '; id ' + uid);

    var body = {
	    id: id,
	    data: data
	};
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.onreadystatechange = function(data) {
	    if ((xhr.readyState === 4) && (xhr.status === 200)) {
		var respObject = JSON.parse(xhr.responseText);
		console.log('Server answer ' + respObject.id);
	    }
	};

    xhr.send(JSON.stringify(body));
    
    return;
}

