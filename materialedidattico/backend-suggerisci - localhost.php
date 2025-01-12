<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


$conn_error= 'Could not connect.';
$mysql_host = 'localhost'; //sostituito con localhost perchè nella stessa macchina
//$mysql_user = 'adimin-mag-waldo';
$mysql_user = 'root';
//$mysql_pass = 'U)rwe923werty87';
$mysql_pass = '';
$mysql_db ='mag-waldorf'; //era "DB: mag-waldorf"



$link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);


   
// Check connection
if($link === false){
	
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


if(isset($_REQUEST['term'])){
	
	
	
	$tipo = $_REQUEST['term'];
	
	$sql = "SELECT * FROM `tipologie` WHERE `TIP_ID` = ".$tipo;
	
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	$tip_desc = $row['TIP_DESC'];
	$tip_sc =$row['TIP_SC']; // prime tre lettere da inserire nel codice suggerito
	
	//la seguente query trova il massimo valore del codice presente guardando solo a quelli che iniziano per tip_sc e togliendo gli zeri iniziali eventualmente presenti
	$sql = "SELECT MAX(CONVERT(TRIM(LEADING '0' FROM RIGHT(`ART_COD`, LENGTH(`ART_COD`)-3)), SIGNED INTEGER)) AS 'MASSIMO'  FROM `articoli` WHERE `TIP_ID` = '".$tipo."' AND LEFT(`ART_COD`,3)='".$tip_sc."'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	$massimo = $row['MASSIMO'];
	
	$massimo = $massimo + 1;
	//echo $sql;
	//a questo punto si può costruire il codice nuovo da proporre.
	//l'unico problema è se il precedente è del tipo LIB9999999
	$strcod ="";
	for ($i = strlen($massimo); $i <= 5; ++$i) {
		$strcod = $strcod.'0';
	}
	$strcod = $strcod.$massimo;
	$strcod = $tip_sc.$strcod;
	
	echo $strcod;
	if (!($tip_desc ='Libri')) {
		
	} else {
	
	}
    

}
 
// close connection
mysqli_close($link);



function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) ){
        $output = implode( ',', $output);}

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
?>