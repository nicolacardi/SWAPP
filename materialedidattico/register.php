<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
<title>Gestionale Materiale Didattico</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/reset.css"/>
<link rel="stylesheet" href="css/main.css"/>
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
</head>
 <?php
 
 require 'core.inc.php';
 require 'connect.inc.php';
 
 
 if (!loggedin()){


if (
isset ($_POST['username']) &&
isset ($_POST['password']) &&
isset ($_POST['password_again']) &&
isset ($_POST['firstname']) &&
isset ($_POST['surname']) &&
isset ($_POST['email']) ) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_again = $_POST['password_again'];
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	$password_hash = md5($password);
	
	if (
	!empty ($username) &&
	!empty ($password) &&
	!empty ($password_again) &&
	!empty ($firstname) &&
	!empty ($surname) &&
	!empty ($email)) {
		
		if (strlen($username)>30 ||
			strlen($firstname)>40 ||
			strlen($surname)>40 ||
			strlen($email)>50
			) {
			echo '<br><h3 style="color:red">Please adhear to max length of fields!<h3>'; //questo è un controllo ulteriore oltre a maxlength nella parte html, per controllare chi fa uso improprio del form
			
		} else {
			
			if ($password!=$password_again) {
				echo '<br><h3 style="color:red">Passwords do not match<h3>';
			} else{
				//start registration process
				$query = "SELECT `username` FROM `users` WHERE `username` = '".$username."'";
				$stmt = mysqli_prepare($mysqli, $query);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $dbusername);
				mysqli_stmt_store_result($stmt);
				if (mysqli_stmt_num_rows($stmt) ==0) {
					while (mysqli_stmt_fetch($stmt)) {	
					}
				//if ($query_run = mysql_query($query)){
					//0 significa che l'utente è nuovo quindi qui bisogna inserire nel db
					$query2 ="INSERT INTO `users` VALUES ('','".mysql_real_escape_string($username)."','".mysql_real_escape_string($password_hash)."','".mysql_real_escape_string($firstname)."','".mysql_real_escape_string($surname)."','".mysql_real_escape_string($email)."', '1')";
					//$stmt2 = mysqli_prepare($mysqli, $query2);
					if ( mysqli_query($mysqli, $query2)) {
						//mysqli_stmt_execute($stmt2);
						header ('Location: register_success.php');
					} else {
						echo $query.'<br><h3 style="color:red">Sorry, we couldn\'t register you at this time, try later.<h3>';
					}
					
					
				} else if ($query_num_rows==1) {
					
					echo '<br><h3 style="color:red">The username '.$username.' already exists<h3>';
				}
				// } else{
				// 	echo ' non ha funzionato la query'.$query;
				// }
				
			}
		}
	} else {
		echo '<br><h3 style="color:red">All fields are required!<h3>';
	}


}

?>

<br />
<br />


<div class="row">
  <div class="col-sm-5">
  </div>
  <div class="col-sm-2 text-center">

<form action="register.php" method="POST">
    <h3><input type="text100" name="username" maxlength="30" placeholder="Username" value="<?php if (isset($username)){echo $username;} ?>"></h3> 
    <br />

    
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" name="password" maxlength="30" placeholder="Password">
    </div>
    <br />
    
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" name="password_again" maxlength="30" placeholder="Password again">
    </div>
    <br />
   
    <h3><input type="text100" maxlength="40" placeholder="Nome" name="firstname" value="<?php if (isset($firstname)){echo $firstname;} ?>"> </h3>
    <br />
    <h3><input type="text100" maxlength="40" placeholder="Cognome" name="surname" value="<?php if (isset ($surname)){echo $surname;} ?>"></h3> 
    <br />
    <h3><input type="text100" maxlength="50" placeholder="email" name="email" value="<?php if (isset ($email)){echo $email;} ?>"></h3>
    <br />
    
    <br><input type="submit" class="btn btn-default btn-block btn-primary" value="Register">
</form>
<br>
<p> <a href="index.php">Login page</a> </p>

	</div>
	<div class="col-sm-5">
	</div>
</div>



<?php
 } else if (loggedin()){
	 echo 'You\'re already registered and logged in';
 }
 
 
 
 ?>
<body>
<body style="background-size: cover;" background="img/bg2.png">
</body>
</html>