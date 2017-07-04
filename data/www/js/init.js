//////////////////////////////////////////////////////////////
// init & UI

window.onload = function() {
    console.log('AD caller loaded ok');
    
    var button = document.getElementById('advertButton');
    var block = document.getElementById('advertBlock');
    var randomIndicator = document.getElementById('advertId');
    
    initButton();
    button.onclick = function() {
		var randomIndicator = document.getElementById('advertId');
		advertCall(randomIndicator.innerHTML, null);
		initButton();
	    }
    
    block.classList.remove("hidden");
    
    setInterval(updateQueueState,1000);
}

function initButton() {
    var randomInt = getRndInt(1,1000000);
    var randomIndicator = document.getElementById('advertId');
    
    randomIndicator.innerHTML = randomInt;
}
