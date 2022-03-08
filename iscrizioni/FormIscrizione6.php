<?
	include_once("../database/databaseBii.php");
	include_once("../assets/functions/functions.php");
	include_once("../assets/functions/ifloggedinIscrizioni.php");
	include_once("diciture.php");
?>

<!DOCTYPE html>
<html style="overflow-x: hidden; width: 100%;  height: 100%; ">
<head>
	<title>Stampa e Logout</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="../assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="../assets/img/faviconbook.png" type="image/icon">
	<script src="../assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="../assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="../assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
	
	<!-- <link rel="stylesheet" href="../assets/croppie/croppie.css" />
	<script src="../assets/croppie/croppie.js"></script> -->
	
	<link href="../assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="../assets/moment/moment.js" type="text/javascript"></script>
	
	<script src="../assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/bootstrap-select/bootstrap-select.css">
	<script src="../assets/bootstrap-select/bootstrap-select.js"></script>

	<? $_SESSION['page'] = "Scheda Iscrizione - Stampa";?>
</head>
 
<body class="adaptpaddingbottom" style="background-image: url('../assets/img/background4.jpg'); width: auto !important; background-size: cover; overflow-x: hidden !important; ">



	<?$codscuola = $_SESSION['codscuola'];?>
	<? include("../assets/functions/autologoff.php"); ?>
	<div id="main">
		<? //include_once("../assets/functions/lowreswarningB.html"); ?>
		<div class="fixedheader" style="background-image: url('../assets/img/background4.jpg'); background-size: cover ; border-bottom: 1px solid grey; z-index: 100;   position:fixed;  width:100%;  top:0;  left:0;">
			<div class="col-md-12 center">
				<!--<img title="Status" style="text-align: center;height: 40px; cursor: pointer" src="../assets/img/12345/5.png">-->
			</div>
			<div class="col-md-8 col-sm-12 col-md-offset-2" style="text-align: center; font-size: 14px; margin-bottom: 20px; ">
				<div class="col-md-6 col-sm-12 col-md-offset-3" style="margin-top: 20px; text-align: center; font-size: 24px; color: #3c3c3c;" >
					 MODULI COMPLETATI!
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="text-align: center; font-size: 16px; margin-left: 40px; display: none;">
					<input id="ID_fam_hidden" name="ID_fam_hidden" value="<?=$_SESSION['ID_fam'];?>" hidden>
					<input id="annoscolastico_hidden" name="annoscolastico_hidden" value="<?=$_SESSION['annopreiscrizione_fam'];?>" hidden>
				</div>
			</div>
		</div>
		<?
		$sql = "SELECT `ID_alu`, `mf_alu`, `nome_alu`, `cognome_alu` FROM `tab_anagraficaalunni` WHERE `ID_fam_alu`= ? AND noniscritto_alu = 0 ORDER BY datanascita_alu ASC";
		$stmt = mysqli_prepare($mysqli, $sql);
		mysqli_stmt_bind_param($stmt, "i", $_SESSION['ID_fam']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $ID_alu, $mf_alu, $nome_alu, $cognome_alu);
		$n = 0;
		$nome_aluA = array();
		$frase = "";
		while (mysqli_stmt_fetch($stmt)) {
			$n++;
			$nomealuA[$n] = $nome_alu;
		}
		
		for ($x = 1; $x <= $n; $x++) {
			if ($x == ($n-1)) {
				$frase = $frase. $nomealuA[$x]." e ";
			} else {
				$frase = $frase. $nomealuA[$x].", ";}
		}
		$frase= substr ($frase, 0, -2);
		?>
		<form id="formiscrizione" style="margin-top: 100px; ">
			<div class="row" style="text-align: center; font-size: 14px; line-height: 1.6">
				<div class="col-md-6 col-md-offset-3">
					Grazie per aver completato i moduli online<br> per l'iscrizione di<br><?=$frase?> 
				</div>
			</div>
			<div class="row" style="text-align: center; font-size: 14px; line-height: 1.6">
				<div class="col-md-6 col-md-offset-3">
					I dati sono stati salvati e trasmessi alla Segreteria<br>tuttavia è anche necessario<br>stampare i moduli precompilati,<br><?=$scadfrase1?><span style="text-decoration: underline"><?=$scadfrase2?><?=$scadiscrizionelett?><?=$_SESSION['anno1']?>.</span>
				</div>
				<div class="col-md-6 col-md-offset-3">
					Solo la consegna in Segreteria rappresenta l'atto formale di richiesta di iscrizione <br>
					<span style="text-decoration: underline">senza del quale la richiesta stessa<br>non può ritenersi completa.</span>
				</div>
			</div>
		</form>
		<div class="row">
			<div  class="col-md-4 col-sm-8 col-md-offset-4 col-sm-offset-2">
				<div class="col-md-12 col-sm-12" style="text-align: center; font-size: 14px;">
					<input value="Torna al modulo" class="btn btn-primary btn-cons" id="TornaAlModulo1PB" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="TornaAlModulo1();" readonly></input>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; margin-top: -5px; font-size: 14px;">
					<input value=">> pdf Modulo Iscrizione Compilato" class="btn btn-primary btn-cons" id="DownloadPdfPB" style="width: 100%; margin-top: 20px; border-radius:15px; background: #218cdb; " onclick="Scaricapdf();" readonly></input>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; margin-top: -5px; font-size: 14px;">
					<input value="pdf Allegati e Informativa" class="btn btn-primary btn-cons" id="DownloadPdfPB" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " onclick="ScaricapdfAllegati('<?=$codscuola?>');" readonly></input>
				</div>
				<div class="col-md-12 col-sm-12" style="text-align: center; margin-top: -5px; font-size: 14px;">
					<input value="Esci" class="btn btn-primary btn-cons" style="width: 100%; margin-top: 20px; border-radius:15px; background: grey; " id=LogoutPB" onclick="CheckBeforeLogout();" readonly></input>
				</div>
				
			</div>
		</div>


	</div>
	
	
	<div class="modal" id="modalCheckBeforeLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">LOGOUT</span>
					<div id="remove-content1" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<br>
						Siete sicuri di voler uscire?
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btn btn-primary btn-cons" style="width:40%; border-radius:15px;" data-dismiss="modal" onclick="Logout();">Sì</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	

</body>
</html>	
<script>


	
	function TornaAlModulo1(){
		window.location.href = "FormIscrizione1.php";
	}
	
	function ScaricapdfSenzaPOST(){
		
		window.location.href = "downloadModuloIscrizione.php";
	}
	
	function Scaricapdf() {
		let url = "downloadModuloIscrizione.php";
		let form = $('<form id="tmpform" target="_blank" action="' + url + '"method="post">' + 
		'<input type="text" name ="ID_fam" value ='+$('#ID_fam_hidden').val()+' >'+
		'<input type="text" name ="annoscolastico" value ='+$('#annoscolastico_hidden').val()+' >'+
		'</form>');
		$('body').append(form);
		form.submit();
		var element =  document.getElementById('tmpform');
		element.remove();
	}
					

	function ScaricapdfAllegati(codscuola){
		window.location.href = "downloadAllegato.php?nomeallegato=Tutti";
	}
	
	function CheckBeforeLogout(){
		$('#modalCheckBeforeLogout').modal('show');
	}
	function Logout() {
		window.location.href = "Logout.php";
	}


</script>
