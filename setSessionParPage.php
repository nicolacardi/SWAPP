<?include_once("database/databaseii.php");

        $parametro = $_POST['par_name'];

		$sql = "SELECT val_par FROM tab_parametri WHERE parname_par = ? ";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "s", $parametro);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $val_par);			
		while (mysqli_stmt_fetch($stmt)) {
		}
		
		$_SESSION[$parametro] = $val_par;
?>