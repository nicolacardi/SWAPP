<? ob_start();
	include_once('connect.inc.php'); 	//database
	include_once('core.inc.php');		//funzioni
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
	<title>Gestionale Materiale Didattico</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/reset.css"/>
	<link rel="stylesheet" href="css/main.css"/>
</head>

<body style="background-size: cover;" background="img/bg.png">
	<div class="moduli">
		<br>
		<?

		if (isset ($_POST['username']) && isset($_POST['password'])) {
			
			$login_usr = $_POST['username'];
			$password_usr = $_POST['password'];
			echo (PASSWORD_BCRYPT);
			$password_hash = password_hash ($password_usr, PASSWORD_BCRYPT);
			
			if (!empty ($login_usr) && !empty ($password_usr)) {
				
				$sql = "SELECT `password` FROM `users` WHERE `username`= ? ";
				$stmt = mysqli_prepare($mysqli, $sql);
				mysqli_stmt_bind_param($stmt, "s", $login_usr);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $password_usrdb);
				$i = 0;
				while (mysqli_stmt_fetch($stmt)) {
					$i++;
				} 
				
				$ID_usr ="";
				//verifica se la password inserita corrisponde con quella in db usando la password_verify
				if (password_verify( $password_usr, $password_usrdb)) {
					$sql = "SELECT `id` FROM `users` WHERE `username`= ?";
					$stmt = mysqli_prepare($mysqli, $sql);
					mysqli_stmt_bind_param($stmt, "s", $login_usr);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $ID_usr);
					while (mysqli_stmt_fetch($stmt)) {
						
						$_SESSION['username'] = $login_usr;
						$_SESSION['user_id'] = $ID_usr;
					}
					header('Location: console.php'); 
				} else {
					echo '<h3 class="warn">
					Invalid username/password combination
					</h3>';
				}

				// if ($i==0) { //non trova record con entrambi i valori
				// 	echo '<h3 class="warn">
				// 	Invalid username/password combination
				// 	</h3>';
				// 		//quindi deve restituire codice di errore
				// } else if ($i==1) {
					
				// 	$_SESSION['user_id'] = $id; 
				// 	header('Location: index.php'); 
				// }

			} else {
				echo '<br><h3 style="color:red">You must supply a username and password<h3>';
			}
		}

	?>
	<br>
	<br>

	<div class="row">
	<div class="col-sm-5">
	</div>
		<div class="col-sm-2 text-center">
			<form action ="<?php echo $current_file; ?>" method="POST">
				<!--<label for="username">Nome Utente</label>-->
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input id="username" class="form-control" name="username" maxlength="30" placeholder="Nome Utente">
			</div>
			<br>
				<!--<label for="password">Password</label>-->
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
				<input id="password" type="password" class="form-control" name="password" maxlength="30" placeholder="Password">
			</div>
				<br><input type="submit" class="btn btn-default btn-block btn-primary" value="Login">
			
			</form>
			<br>
			<p class="text-center"><a href="register.php">Nuovo Utente</a></p>
			<img src="img/Logo-Sophia-200px.png">
		</div>
		<div class="col-sm-5">
		</div>
	</div>

	</div>
</body>
</html>



