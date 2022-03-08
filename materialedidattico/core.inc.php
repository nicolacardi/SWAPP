<?php
//session_start();
$current_file = $_SERVER['SCRIPT_NAME'];
if (isset( $_SERVER['HTTP_REFERER'])&& !empty($_SERVER['HTTP_REFERER'])) {
	$http_referer = $_SERVER['HTTP_REFERER'];	
}; //tiene nota della pagina DALLA QUALE siamo arrivati ATTENZIONE PERO' FUNZIONA SOLO SE SI ARRIVA DA UN'ALTRA PAGINA

function loggedin(){
	if (isset($_SESSION['user_id']) && !empty ($_SESSION['user_id'])){
		return true;
	} else{
		return false;
	}
}


function getuserfield ($field) {
	global $mysqli;
	$sql = "SELECT `".$field."` FROM `users` WHERE `id` = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $val_par);			
	while (mysqli_stmt_fetch($stmt)) {
		//$_SESSION[$parametro] = $val_par;
		return $val_par;
	}

	// $query = "SELECT `".$field."` FROM `users` WHERE `id` = '".$_SESSION['user_id']."'";
	// if ($query_run = mysql_query($query)) {
	// 	if ($query_result = mysql_result($query_run, 0, $field)) {
	// 		return $query_result;
	// 	}
	// }
	
}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  //$data= mysqli_real_escape_string($mysqli, $data);
  $data= htmlspecialchars($data, ENT_QUOTES, "ISO-8859-1");
  return $data;
}



			


?>
