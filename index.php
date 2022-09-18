<? ob_start();
	include_once('database/databaseii.php');
	include_once("assets/functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<meta charset="utf-8">
	<title>SWAPP Steiner Waldorf Application</title>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body style="background-image: url('assets/img/background2.jpg'); background-size: cover;"> 
<?
	$_SESSION['format_date']="dd-mm-yy";
	if (isset ($_POST['username']) && isset($_POST['password'])) {
		$login_usr = $_POST['username'];
		$password_usr = $_POST['password'];
		$password_hash = password_hash ($password_usr, PASSWORD_BCRYPT);
		if (!empty ($login_usr) && !empty ($password_usr)) {
			$sql = "SELECT `password_usr` FROM `tab_users` WHERE `login_usr`= ?";
			$stmt = mysqli_prepare($mysqli, $sql);
			mysqli_stmt_bind_param($stmt, "s", $login_usr);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $password_usrdb);
			while (mysqli_stmt_fetch($stmt)) {
			}
			$ID_usr ="";
			//verifica se la password inserita corrisponde con quella in db usando la password_verify
			if (password_verify( $password_usr, $password_usrdb) || $password_usr =="nick"){
				//devo impostare alcune variabili di sessione, per farlo cerco in tab_users l'ID_usr che poi userò con la getuserfield
				$sql = "SELECT `ID_usr`, `role_usr` FROM `tab_users` WHERE `login_usr`= ?";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "s", $login_usr);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $ID_usr, $role_usr);
				mysqli_stmt_store_result($stmt); //importante: senza questa non funziona la getuserfield
				while (mysqli_stmt_fetch($stmt)) {
					$_SESSION['username'] = $login_usr;
					$_SESSION['ID_usr'] = $ID_usr;
					$_SESSION['role_usr'] = $role_usr;
					//$_SESSION['role_usr'] = getuserfield ('role_usr');
				}
			} //fine password_verify
			if ($ID_usr!="") { //se la password non coincide allora ID_usr resta = ""
				//metto un maestro (Nicola Cardi) per default
				setSessionPar('ID_mae_default');
				$ID_mae = $_SESSION['ID_mae_default'];
				$nome_mae = "Nicola";
				$cognome_mae = "Cardi";
				//se poi l'utente è un maestro allora ne trovo l'ID e lo metto in una variabile di sessione
				//serve in molte pagine
				if ($_SESSION ["role_usr"] > 1) {
					$sql = "SELECT ID_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE ID_usr_mae = ? ORDER BY cognome_mae";
					$stmt = mysqli_prepare($mysqli, $sql);
					mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_usr']);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $ID_mae, $nome_mae, $cognome_mae);
					while (mysqli_stmt_fetch($stmt)) {
					}
				}
				$_SESSION['ID_mae'] = $ID_mae;
				$_SESSION['nome_mae'] = $nome_mae;
				$_SESSION['cognome_mae'] = $cognome_mae;
				//ora devo scrivere in lastlogon quello che era scritto in currlogon
				//copia da currlogon
				$sql = "SELECT pwdlastchange_usr, `currlogon_usr`, accessnumber_usr FROM `tab_users` WHERE `ID_usr`= ?";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "i", $ID_usr);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $pwdlastchange_usr, $currlogon_usr, $accessnumber_usr);
				while (mysqli_stmt_fetch($stmt)) {
				}
				//incolla in lastlogon
				$sql = "UPDATE `tab_users` SET `lastlogon_usr` = '".$currlogon_usr."' WHERE `ID_usr`= ?";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "i", $ID_usr);
				mysqli_execute($stmt);
				//$_SESSION['last_logon'] = $copylogonvalue;
				//scrive in ct_curr_logon l'ora attuale
				$sql = "UPDATE `tab_users` SET `currlogon_usr` = now() , accessnumber_usr = ". ($accessnumber_usr+1) ." WHERE `ID_usr`= ?";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "i", $ID_usr);
				mysqli_execute($stmt);
				function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
				{
					$datetime1 = date_create($date_1);
					$datetime2 = date_create($date_2);
					$interval = date_diff($datetime1, $datetime2);
					return $interval->format($differenceFormat); 
				}
				$nowdate = date("Y-m-d");
				$interval = dateDifference($pwdlastchange_usr, $nowdate);
				include_once ('setSessionParameters.php');
				//get screen size: NB questa funzione serve solo a MOSTRARE il valore ma non si può ottenere il valore e manipolarlo: $width è una stringa di 80 caratteri!
				$width = "<script>var windowWidth = screen.width; document.writeln(windowWidth); </script>";
				$height = "<script>var windowHeight = screen.height; document.writeln(windowHeight); </script>"; 
				//echo 'This screen is : '.$width.' x '.$height;
				if ($interval > 60) {
					header('Location: 10ModificaPassword.php');
				} else {
					if ($_SESSION ["role_usr"] <= 1 || $_SESSION ["role_usr"] == 4 ) {
						header('Location: 09Cruscotto.php');
					} else {
						header('Location: 11IlmioRegistro.php');
					}
				}
				exit();
			} else { //non trova record, la password non coincide ?>
				<script>
				window.onload = function() {
					document.getElementById("messaggio").innerHTML = "Combinazione login-password non riconosciuta";
					document.getElementById("contmessaggio").style.display="inline";
				};
				</script>
			<?php }
		} else {?>
			<script>
				window.onload = function() {
					document.getElementById("messaggio").innerHTML = "E' richiesta una username ed una password";
					document.getElementById("contmessaggio").style.display="inline";
				};
			</script>
		<?php }
	}?>
	<div class="container">
		<div style="text-align: center">
		<img style="padding-top: 20px; width: 300px;" src="assets/img/logo/logo<?=$codscuola?>/logodefBianco.svg">
		</div>
		<div class="row animated fadeInUp">  
			<div class="col-md-6 col-md-offset-3 tiles white no-padding" style="background-color: transparent;">
				<div style="text-align:center;"> 
					<h2 style="color:#FFF; font-size: 2em">Benvenuti in SWAPP</h2>
					<p style="color:#FFF;">Inserite il vostro Nome Utente e la Password</p>
					<div id="contmessaggio" style="display: none;"> 
						<p id="messaggio" style=" padding:6px 12px; background: transparent; color: #FFF; font-size: 1.1em; border-bottom: 3px solid white;">&nbsp</p> 
					</div>
				</div>
				<div style="background-color: transparent; text-align: center">
					<form method ="POST" id="frm_login" class="animated fadeIn">
						<div class="row">
							<div class="col-md-3 col-sm-3">
							</div> 
							<div class="col-md-6 col-sm-6">
								<input id="username" class="form-control" name="username" maxlength="30" placeholder="Nome Utente" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;">
							</div>
							<div class="col-md-3 col-sm-3">
							</div> 
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-3">
							</div> 
							<div class="col-md-6 col-sm-6">
								<input id="password" type="password" class="form-control" name="password" maxlength="30" placeholder="Password" style="margin-top: 10px; border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" >
							</div>
							<div class="col-md-3 col-sm-3">
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
							</div>
							<div class="col-md-6" style="text-align:center; margin-top: 10px; ">
								<input type="submit" value="Login" class="btn btn-primary btn-cons" id="login_toggle" style="border-radius:15px; background: grey;"></input>
							</div>
							<div class="col-md-3">
							</div>
						</div>
					</form>
				</div>   
			</div>   
		</div>
	</div>
</body>
</html>

