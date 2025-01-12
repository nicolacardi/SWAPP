<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Anagrafica</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
     
</head>

<body onload="initialize()">
 <div id="map" style="width: 320px; height: 480px;"></div>
  <div>
    <input id="address" type="textbox" value="Sydney, NSW">
    <input type="button" value="Encode" onclick="codeAddress()">
  </div>
</body>
</html>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvTMrwDYwjbdw2iHa9tAJd8fKT3Czr9Dk">
</script>
<script>

  var geocoder;
  var map;
  function initialize() {
   
  }

  function codeAddress() {
	geocoder = new google.maps.Geocoder();
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
		console.log(address);
		console.log(results[0].geometry.location.lat());
    });
  }




</script>
