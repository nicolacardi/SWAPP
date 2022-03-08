<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$conn_error= 'Could not connect.';
$mysql_host = '89.46.111.73'; //sostituito con localhost perchè nella stessa macchina
$mysql_user = 'Sql1256175';
//$mysql_user = 'root';
$mysql_pass = '586531rtj5';
//$mysql_pass = '';
$mysql_db ='Sql1256175_4'; //era "DB: mag-waldorf"





$link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
//$link = mysqli_connect("localhost", "root", "", "waldorf");

 
   
   
   
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//if(isset($_REQUEST['term'])){
if(isset($_REQUEST['term']) && isset ($_REQUEST['cod_or_desc'])){
	$cod_or_desc = $_REQUEST['cod_or_desc'];
	
	//debug_to_console ($_REQUEST['term']);
	if ($cod_or_desc == "cod") {
    // Prepare a select statement
    $sql = "SELECT `ART_COD` FROM `articoli` WHERE `ART_COD` LIKE ?";
	} else if ($cod_or_desc == "desc"){
	$sql = "SELECT `ART_DESC` FROM `articoli` WHERE `ART_DESC` LIKE ?";
	debug_to_console ($sql);
	} else if ($cod_or_desc == "nomcog"){
	$sql = "SELECT `CLI_NOMECOGNOME` FROM `clienti` WHERE `CLI_NOMECOGNOME` LIKE ? ORDER BY `CLI_NOME`";
	} else if ($cod_or_desc == "ragsoc"){
	$sql = "SELECT `FOR_RAGSOC` FROM `fornitori` WHERE `FOR_RAGSOC` LIKE ?";
	}
	
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = '%'.$_REQUEST['term'].'%';
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
			
			if ($cod_or_desc == "cod") {
			$stmt->bind_result($dbART_COD);
			} else if ($cod_or_desc == "desc"){
			$stmt->bind_result($dbART_DESC);
			} else if ($cod_or_desc == "nomcog"){
			$stmt->bind_result($dbCLI_NOMECOGNOME);
			} else if ($cod_or_desc == "ragsoc"){
			$stmt->bind_result($dbFOR_RAGSOC);
			}

            //$result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            while ($stmt->fetch()) {
                // Fetch result rows as an associative array
               	
				
				
				
				if ($cod_or_desc == "cod") {
					$art_cod = $dbART_COD;
					echo "<p>" . $art_cod . "</p>";
				} else if ($cod_or_desc == "desc"){
					$art_desc = $dbART_DESC;
					echo "<p>" . utf8_decode($art_desc). "</p>";
				} else if ($cod_or_desc == "nomcog"){
					$cli_nomecognome = $dbCLI_NOMECOGNOME;
					echo "<p>" . utf8_decode($cli_nomecognome). "</p>";
				} else if ($cod_or_desc == "ragsoc"){
					$for_ragsoc = $dbFOR_RAGSOC;
					echo "<p>" . utf8_decode($for_ragsoc). "</p>";
				} 
            } // fine while
            }
        } else{
            echo "ERROR: not able to execute $sql. " . mysqli_error($link);
        }
 

}
 
// close connection
mysqli_close($link);



function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
?>