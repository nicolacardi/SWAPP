<?header('Content-Type: text/html; charset=utf-8');
	
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>
<!DOCTYPE html>
	
<html>
<head>
	<title>Tutorials</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<? $_SESSION['page'] = "Tutorials";?>
</head>

<body>

	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">
			
			<div class="titoloPagina" style="margin-bottom: 10px;" >
				Tutorials				
			</div>
			<div class="row" style="text-align: center;" >
				<div class="row" style="display: inline-block;" >
					<table id="layoutTutorials" class="w100">
						<tr style="margin-top: 10px; text-align: center; font-size: 16px; color: #3c3c3c; " >
							<td style="margin-left: 30px; ">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/SwappOverview.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Visione d'insieme
							</td>
							<td style="margin-left: 30px;">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/FirmaESupplenze.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Firma del registro e Supplenze
							</td>
						</tr>
						
						<tr style="margin-top: 10px; border-top:1px solid black; text-align: center; font-size: 16px; color: #3c3c3c; " >
							<td style="margin-left: 30px; padding-top:10px;">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/Pagelle.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Compilazione <br> delle pagelle
							</td>
							<td style="margin-left: 30px; padding-top:10px;">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/CertCompetenze.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Certificazione delle Competenze <br> e Consiglio Orientativo
							</td>
						</tr>
						<tr style="margin-top: 10px; border-top:1px solid black; text-align: center; font-size: 16px; color: #3c3c3c; " >
							<td style="margin-left: 30px; padding-top:10px;">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/CalcoloVotieMedie_.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Calcolo <br> votazioni medie
							</td>
							<td style="margin-left: 30px; padding-top:10px;">
								<video width="320" height="180" controls>
								<source style="margin-left: 30px;" src="assets/tutorials/DAD.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>
								<br>
								Impostazione e Gestione <br> della DAD
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>
	
	
	
</script>
