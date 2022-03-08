<?
	//ATTENZIONE ************************************* QUESTO MODIFICAPASSWORD E' QUELLO DELLE ISCRIZIONI!!!! DA NON CONFONDERE CON QUELLO DI SWAPP ORIGINAL!!! ****************************
	include_once("../database/databaseii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifica password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="../assets/img/faviconbook.png" type="image/icon">
	<script src="../assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="../assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
	<? $_SESSION['page'] = "Modifica Password";?>
</head>
<body style="background-image: url('../assets/img/background4.jpg'); background-size: cover;" >

	
	<? include("../assets/functions/autologoff.php"); ?>
	<div id="main">
		<div class="col-md-12" style="text-align: center; font-size: 20px; margin-bottom: 20px; ">
			Modifica Password per utente<br> '<?=$_SESSION['username']?>'		
		</div>
		<!--<div class="col-md-12" style="text-align: center; font-size: 14px; margin-bottom: 20px; ">
			Si raccomanda di modificare la password una volta ogni 60 giorni almeno	
		</div>-->
		<form id="form_password" method="post">
			<div class="col-md-4">
			</div>
			<div class="col-md-4" id="remove-content-messages">
				<div class="col-md-12" style="text-align: center; margin-top: 10px;">
					<span>Password Attuale</span>
				</div>
				<div class="col-md-12">
					<input id="ct_oldPassword" type="password" class="form-control inputstandard" name="ct_oldPassword" maxlength="10" placeholder="Password" title="digita la password corrente" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" required>
				</div>
				<div class="col-md-12" style="text-align: center; margin-top: 40px;">
					<span>Nuova Password</span>
				</div>
				<div class="col-md-12">
					<input id="ct_newPassword" type="password" class="form-control inputstandard" name="ct_newPassword" maxlength="10" placeholder="digita la nuova password" title="Password" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" required>
				</div>
				<div class="col-md-12" style="text-align: center; margin-top: 10px; ">
					<span>Ripetizione Nuova Password</span>
				</div>
				<div class="col-md-12">
					<input id="ct_newPassword_again" type="password" class="form-control inputstandard" name="ct_newPassword_again" maxlength="30" placeholder="ripeti la nuova password" title="Ripetizione Password" style="border-radius: 10px; text-align:center; height:34px; padding:6px 12px;" required>
				</div>
			</div>
			<div>
			<div class="col-md-12" style="text-align: center; margin-top: 30px; ">
				<input value="Salva" type="submit" class="btn btn-primary btn-cons" id="btn_save" style="width: 150px; border-radius:15px; background: grey;"></input>
			</div>
			<div class="col-md-12" style="text-align: center; margin-top: 30px;">
				<input value="Procedi al form di iscrizione" class="btn btn-primary btn-cons" id="btn_proceed" style="width: 250px; border-radius:15px; background: grey; display:none;" onclick="GoToForm();"></input>
			</div>
			</div>
		</form>
		<div class="col-md-12">
			<div class="col-md-4">
			</div>
			<div class="col-md-4 alert alert-success" id=alert" style="margin-top: 60px; display:none; padding: 5px; margin-bottom: 10px; border-radius: 5px; border: #16af00 solid 1px; background-color: #daffc2">
				<h5 style="text-align:center; color: #16af00"> La password è stata modificata con successo!</h5>
			</div>
			<div class="col-md-4 alertFail alert-error" id=alertFail" style="margin-top: 60px; display:none; padding: 5px; margin-bottom: 10px; border-radius: 5px; border: #e73b3b solid 1px; background-color: #ffe9d9">
				<h5 style="text-align:center; color: #e73b3b;" id="TextError"></i></h5>
			</div>
		</div>
	</div>	
</body>
</html>

<script>
	$("#form_password").submit(function(e){
		e.preventDefault(); //STOP default action
	    let postData = $(this).serializeArray();
	    $.ajax({
	        url : "qry_updatePassword.php", //qui andrà indicato il file che fa l'update della password nel database
	        type: "POST",
	        data : postData,
	        dataType: "json",
	        success:function(data){
				console.log (data.status);
				console.log(data.message);
				//di ritorno da edit_password che ha usato le 3 password ho due valori: data.status e data.message
		        if ((data.status) == 'fail') {
					$("#TextError").text(data.message);
					$(".alertFail").show();
					$(".alert").hide();
				} else {
					
					$("#remove-content-messages").slideUp();
					$("#btn_save").hide();
					$("#btn_proceed").show();
					$(".alertFail").hide();
					$(".alert").show();
					//$("#btn_save").hide();
				}
	        },
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore 'ModificaPassword ##fname##'");      
	        }
	    });
		return false;
	    //e.preventDefault(); //STOP default action
	});
	
	

	function GoToForm() {
		location.href = "FormIscrizione1.php";
	}
</script>
