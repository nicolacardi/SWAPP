<?
	echo "<input type='text' id='timeout_secondi' value = '".$_SESSION['timeout_secondi']."' hidden>"
?>
<script>
	var IDLE_TIMEOUT = parseInt($("#timeout_secondi").val()); 			//secondi per il timeout presi dalla input hidden che li prende dalla $_SESSION
	//var IDLE_TIMEOUT = 10;											//per test
	var _idleSecondsCounter = 0;

	//basta un movimento del mouse, un click sul documento oppure la pressione di un tasto per resettare il counter
	document.onclick = function() {
		_idleSecondsCounter = 0;
	};
	document.onmousemove = function() {
		_idleSecondsCounter = 0;
	};
	document.onkeypress = function() {
		_idleSecondsCounter = 0;
	};
	window.setInterval(CheckIdleTime, 1000);
	
	function CheckIdleTime() {
			_idleSecondsCounter++;
			//console.log(_idleSecondsCounter+"/"+ IDLE_TIMEOUT);				//per test
			//var oPanel = document.getElementById("SecondsUntilExpire"); 		//per mostrare un counter nella pagina
			//if (oPanel)
			//oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
			if (_idleSecondsCounter >= IDLE_TIMEOUT) {
			localStorage.clear();
			sessionStorage.clear();
			//alert("Time expired!");										//per test
			document.location.href = "index.php";
		}
	}
</script>
