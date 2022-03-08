<?	
	$ID_mae = $_POST['ID_mae'];
	$_SESSION['ID_mae'] = $ID_mae;
	$return['test'] = 'OK';
	echo json_encode($return);
?>
