<?php
require 'core.inc.php';
require 'connect.inc.php';

if (isset($_GET['search_text'])) {
	$search_text = $_GET['search_text'];
}

if(!empty($search_text)){
		$query = "SELECT `FOR_RAGSOC` FROM `fornitori`"; //WHERE `FOR_RAGSOC` LIKE '%".mysql_real_escape_string ($search_text)."%'";
		$stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $for_ragsoc);
        while (mysqli_stmt_fetch($stmt)) {	
			//echo $name = $query_row['name'].'<br>';
			echo $name = '<a href="anotherpage.php?search_text='.$for_ragsoc.'>';
		}
}
?>