<?	include_once("database/databaseii.php");
	$login_usr_new = $_POST['login'];
	$password_new = $_POST['password'];
	$password_new_hash = password_hash ($password_new, PASSWORD_BCRYPT);
	//$password_base = '$2y$10$iqyrDkUiAvWOvXkt9FGW5uifZ3weh6mxqR7YttMQj8DeoCvn3TMeq'; //password base (aaaaaa);
	$tipo = $_POST['tipo'];
	$sql = "INSERT INTO tab_users (login_usr, password_usr, role_usr, pwdlastchange_usr, currlogon_usr, lastlogon_usr) VALUES ( ? , ? , ? , now(), now(), now());";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $login_usr_new, $password_new_hash, $tipo );
	mysqli_stmt_execute($stmt);
	$return['msg'] = "Inserimento nuova Login andato a buon fine";
	$return['test']=$sql;
    echo json_encode($return);
?>
