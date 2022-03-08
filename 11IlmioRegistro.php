<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");?>

<!DOCTYPE html>
	<!-- This comment line needed for bootstrap to work on mobile devices -->
<html>
<head>
	<title>Il Mio Registro Settimanale</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">-->
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<? $_SESSION['page'] = "Il Mio Registro";?>
</head>

<body style="overflow: auto !important">
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="highres">
			<div style="position:absolute; margin-left: 80px;">
				<div class="row">
					<img style="width: 20px;" src='assets/img/Icone/user-check-solid-red.svg'><span style="font-size: 12px;">Lezione da firmare</span>
				</div>
				<div class="row">
					<img style="width: 20px;" src='assets/img/Icone/user-check-solid-yellow.svg'><span style="font-size: 12px;">Lezione firmata senza Argomento</span>
				</div>
				<div class="row">
					<img style="width: 20px;" src='assets/img/Icone/user-check-solid-green.svg'><span style="font-size: 12px;"> Lezione firmata</span>
				</div>
			</div>
			<div class="titoloPagina" style="margin-bottom: 20px;">
				Il Mio Orario
			</div>
			<div id="combomaestri">
			
			</div>

			<?//include("assets/functions/combomaestro.php"); ?>
			<div style="text-align: center; font-size: 24px; color: #3c3c3c; margin-bottom: 20px; " >
				<input id="usr" 								value="<?=$_SESSION ['ID_usr'];?>"		 							hidden>
				<input id="IP_Client" 							value="<?=$_SERVER	['REMOTE_ADDR']?>" 								hidden>
				<input id="IP_Authorized"						value="<?=$_SESSION ['IP_firme_registro']?>" 						hidden>
				<input id="role_usr"							value="<?=$_SESSION ['role_usr']?>"  								hidden>
				<input id="mostra_warning_certcompetenze"		value="<?=$_SESSION ['mostra_warning_certcompetenze']?>"  			hidden>
			</div>
			<div class="col-md-12 center">
				<table id="tabellaOrario" class="center" style="width: 800px;">
					<thead>
						<tr >
							<th style="text-align: center; width: 500px;">
								<img title="Settimana Precedente" style="width: 10px; cursor: pointer" src='assets/img/Icone/caret-left-solid.svg' onclick="moveOneWeek(-1);">
								<input class="tablecell3" type='text' id='weeklyDatePicker' placeholder="Seleziona la settimana" style=" width: 60%; text-align: center;" readonly>
								<img title="Settimana Successiva" style="width: 10px; cursor: pointer" src='assets/img/Icone/caret-right-solid.svg' onclick="moveOneWeek(1);">
							</th>
							<th >
								<input class="tablecell3 center" id="data1Show" type="text" value = "" disabled>
								<input class="tablecell3 center" id="data1" type="text" value = "" hidden>
							</th>
							<th >
							<input class="tablecell3 center" id="data2Show" type="text" value = "" disabled>
								<input class="tablecell3 center" id="data2" type="text" value = "" hidden>
							</th>
							<th >
							<input class="tablecell3 center" id="data3Show" type="text" value = "" disabled>
								<input class="tablecell3 center" id="data3" type="text" value = "" hidden>
							</th>
							<th >
							<input class="tablecell3 center" id="data4Show" type="text" value = "" disabled>
								<input class="tablecell3 center" id="data4" type="text" value = "" hidden>
							</th>
							<th >
								<input class="tablecell3 center" id="data5Show" type="text" value = "" disabled>
								<input class="tablecell3 center" id="data5" type="text" value = "" hidden>
							</th>
						</tr>
						<tr>
							<th>
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "LUNEDI" readonly>
								<img title="Firma tutte le lezioni del giorno" style="position: relative; float: left; width: 20px; cursor: pointer; margin-left: 10px; margin-top: -25px;  z-index: 15;" src="assets/img/Icone/signature.svg" onclick="showModalFirmaTutto(1)">
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "MARTEDI" readonly>
								<img title="Firma tutte le lezioni del giorno" style="position: relative; float: left; width: 20px; cursor: pointer; margin-left: 10px; margin-top: -25px;  z-index: 15;" src="assets/img/Icone/signature.svg" onclick="showModalFirmaTutto(2)">
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "MERCOLEDI" readonly>
								<img title="Firma tutte le lezioni del giorno" style="position: relative; float: left; width: 20px; cursor: pointer; margin-left: 10px; margin-top: -25px;  z-index: 15;" src="assets/img/Icone/signature.svg" onclick="showModalFirmaTutto(3)">
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "GIOVEDI" readonly>
								<img title="Firma tutte le lezioni del giorno" style="position: relative; float: left; width: 20px; cursor: pointer; margin-left: 10px; margin-top: -25px;  z-index: 15;" src="assets/img/Icone/signature.svg" onclick="showModalFirmaTutto(4)">
							</th>
							<th>
								<input class="tablelabel0" type="text" value = "VENERDI" readonly>
								<img title="Firma tutte le lezioni del giorno" style="position: relative; float: left; width: 20px; cursor: pointer; margin-left: 10px; margin-top: -25px;  z-index: 15;" src="assets/img/Icone/signature.svg" onclick="showModalFirmaTutto(5)">
							</th>
						</tr>
					</thead>
					<tbody id="maintable">
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!--***************************************FORM MODALE FIRMA DIGITALE **************************************************-->
	<div class="modal" id="modalFirmaDigitale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_FirmaDigitale" method="post">
						<span class="titoloModal">Firma Digitale Registro</span>
						<div id="remove-contentFirma" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->		
							<div class="row" style="text-align: center;">
								<input type="text" id ="modalhidden_ID_mae_ora" hidden>
								<div class="col-md-6">Nome maestro</div>
								<div class="col-md-6">Cognome maestro</div>
							</div>
							<div class="row" style="text-align: center;">
								<div class="col-md-6"><input type="text"  style="width: 80%;" class="tablecell5"  id="modalnome_mae" name="nome_mae" disabled></div>
								<div class="col-md-6"><input type="text"  style="width: 80%;" class="tablecell5"  id="modalcognome_mae" name="cognome_mae" disabled></div>
							</div>
							<div class="row" style="text-align: center; margin-top: 20px;">
								<div class="col-md-6">Materia</div>
								<div class="col-md-6">Classe/sezione</div>
							</div>
							<div class="row" style="text-align: center;">
								<div class="col-md-6"><input type="text"  style="width: 80%;" class="tablecell5"  id="modaldescmateria_mtt" name="codmat_ora" disabled></div>
								<div class="col-md-6"><input type="text"  style="width: 80%;" class="tablecell5"  id="modalclassesezione_ora" name="classesezione_ora" disabled></div>
							</div>
							<div class="row" style="text-align: left; margin-top: 20px; margin-left: 70px;">
								<div class="col-md-12">Ero assente <input type="checkbox" id="assente_ora" name="assente_ora" onchange="showhideSupplente();">
								<span id="selectSupplentiContainer" style="margin-left: 30px; visibility: hidden; "> Supplente: 
								<!--<select id="selectSupplente" style="margin-left:0px;">
									<option value="0" selected>-selezione supplente-</option>
									<? /*$sql = "SELECT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri WHERE tipo_per = 0 ORDER BY cognome_mae";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $id_mae, $nome_mae, $cognome_mae);
									while (mysqli_stmt_fetch($stmt)) {
									?> <option value="<?=$id_mae?>"><?=$cognome_mae." ".$nome_mae;?></option><?
									}*/?>
								</select>-->
								</span>
								</div>
							</div>
							<div class="row" style="text-align: center; margin-top: 20px; ">
								Argomento insegnato
							</div>
							<div class="row" style="text-align: center;">
								<textarea type="text" class="tablecell5"  style="width: 90%;" id="modalargomento_ora" name="argomento_ora" ></textarea>
							</div>
							<div class="row" style="text-align: center;">
								Compiti Assegnati
							</div>
							<div class="row" style="text-align: center;">
								<textarea type="text" class="tablecell5"  style="width: 90%;" id="modalcompitiassegnati_ora" name="compitiassegnati_ora" ></textarea>
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertFirma" style="display:none; margin-top:10px;">
							<h4 id="alertmsgFirma" style="text-align:center;"> 
							  Firma digitale del registro effettuata
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelFirma" class="btnBlu" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OKFirma" class="btnBlu" style="width:40%;" onclick="" >Firma Digitale</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--***************************************FINE FORM MODALE FIRMA DIGITALE **************************************************-->
	<!--***************************************FORM MODALE IO SOSTITUISCO... **************************************************-->
	<div class="modal" id="modalIoSostituisco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_IoSostituisco" method="post">
						<span class="titoloModal">Il giorno <span id="modalDataIoHoSostituito"></span> alla <span id="modalOraIoHoSostituito"></span>^ ora ho fatto supplenza in classe..</span>
						<div id="remove-contentIoSostituisco" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->		
							<div class="row" style="text-align: center; margin-top: 20px;">
								<div class="col-md-12">
									<span id="selectLezionidiQuestOraContainer" style=""> Lezioni in quest'ora:

									</span>
								</div>
							</div>
							<div class="row" style="text-align: center; margin-top: 20px; ">
								Argomento insegnato
							</div>
							<div class="row" style="text-align: center;">
								<textarea type="text" class="tablecell5"  style="width: 90%;" id="modalargomento_oraIoSost" name="argomento_ora" ></textarea>
							</div>
							<div class="row" style="text-align: center;">
								Compiti Assegnati
							</div>
							<div class="row" style="text-align: center;">
								<textarea type="text" class="tablecell5"  style="width: 90%;" id="modalcompitiassegnati_oraIoSost" name="compitiassegnati_ora" ></textarea>
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertIoSostituisco" style="display:none; margin-top:10px;">
							<h4 id="alertmsgIoSostituisco" style="text-align:center;"> 
							  Firma digitale del registro effettuata
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelIoSostituisco" class="btnBlu " style="width:25%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OKIoSostituisco" class="btnBlu " style="width:25%;" onclick="" >Firma Digitale</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--***************************************FINE FORM MODALE IO SOSTITUISCO... **************************************************-->
	

	<!--***************************************MESSAGGIO BENVENUTO MODAL **************************************************-->
	<div class="modal" id="modalWelcomeMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_Welcome" method="post">
						<span class="titoloModal">Messaggio del giorno :)</span>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<img style="width: 650px;" src="assets/img/HappyBirthday.svg">
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer" >
							<button type="button" id="btn_cancelWelcome" class="btnBlu" style="width:25%;" data-dismiss="modal">Chiudi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--***************************************WARNING MODAL **************************************************-->
	<div class="modal" id="modalWarningFirmeArretrate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_FirmeArretrate" method="post">
						<span class="titoloModal">Buongiorno <?=$_SESSION['nome_mae'];?>! Ci sono lezioni arretrate non firmate</span>
						<br>
						<span class="testoModal">Si prega di firmarle eventualmente indicando l'assenza ed il supplente</span>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div id="FirmeArretrate">
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer" >
							<button type="button" id="btn_cancelFirmeArr" class="btnBlu" style="width:25%;" data-dismiss="modal">Chiudi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	

	<!--***************************************WARNING CERT COMPETENZE CLASSE V e VIII **************************************************-->
		<div class="modal" id="modalWarningCertCompetenze" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">Buongiorno <?=$_SESSION['nome_mae'];?>!</span>
					<br>

					<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
						<div id="WarningCertCompetenze" style="max-height: 500px; overflow-y: auto">
						</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer" >
						<button type="button" class="btnBlu" style="width:25%;" data-dismiss="modal">Chiudi</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--***************************************WARNING CONS ORIENTATIVO CLASSE VIII **************************************************-->
		<div class="modal" id="modalWarningConsOrientativo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 50%">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">Buongiorno <?=$_SESSION['nome_mae'];?>!</span>
					<br>

					<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
						<div id="WarningConsOrientativo" style="max-height: 500px; overflow-y: auto">
						</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer" >
						<button type="button" class="btnBlu" style="width:25%;" data-dismiss="modal">Chiudi</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?include_once("11modalNews.php");?>
	
</body>
</html>

<script>
	
	$(document).ready(function(){
		moment.locale('en', {
		  week: { dow: 1 } // Monday is the first day of the week
		});

		$("#weeklyDatePicker").datetimepicker({
			  pickTime: false, 
			  format: 'YYYY-MM-DD'
		});
		
		let todayDate = new Date().toISOString().slice(0,10);
		$("#weeklyDatePicker").val(todayDate);
	   //Get the value of Start and End of Week
		setdates();

		
		let ID_usr = $("#usr").val();

		postData = {ID_usr: ID_usr};
		//console.log ("11ilmioRegistro.php - document ready - postData to 11qry_getBirthday");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_getBirthday.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				let todayDate = new Date().toISOString().slice(0,10);
				let monthDay = todayDate.substr(5,5);
				let monthDayB = data.monthDayB;
				//console.log (monthDay);
				//console.log (data.monthDayB);
				if ((monthDay == monthDayB)) {
					$('#modalWelcomeMessage').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro $(document).ready'");      
			}
		});

		let ID_mae_ora = $("#hidden_ID_mae").val();

		postData = { ID_mae_ora: ID_mae_ora};
		//console.log("Ilmioregistro.php - document.ready - postData a 11qry_checkConsOrientativo.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_checkConsOrientativo.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log("Ilmioregistro.php - document.ready - ritorno da 11qry_checkConsOrientativo.php");
				//console.log (html);
				$("#WarningConsOrientativo").html(html);
				documentiArretrati = $('#hiddenConsOrientativo').val();
				if (documentiArretrati != 0) {
					$('#modalWarningConsOrientativo').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro $(document).ready'");      
			}
		});
		

		//console.log("Ilmioregistro.php - document.ready - postData a 11qry_checkCertCompetenze.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_checkCertCompetenze.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log("Ilmioregistro.php - document.ready - ritorno da 11qry_checkCertCompetenze.php");
				//console.log (html);
				$("#WarningCertCompetenze").html(html);
				documentiArretrati = $('#hiddenCertCompetenze').val();
				mostra_warning_certcompetenze = $('#mostra_warning_certcompetenze').val();
				
				if (documentiArretrati != 0 && mostra_warning_certcompetenze == 1) {
					$('#modalWarningCertCompetenze').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});

		postData = {ID_usr: ID_usr};

		let role_usr = $("#role_usr").val();
		//console.log ("11ilmioRegistro.php - document ready - postData to 11qry_getNonMostrarePiu");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_getNonMostrarePiu.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log ("11ilmioRegistro.php - document ready - ritorno da 11qry_getNonMostrarePiu");
				//console.log(data);
				nonmostrarepiu_usr = data.nonmostrarepiu_usr;
				//in questa pagina mostro le news a maestri (role_usr = 2 o = 3)
				if (nonmostrarepiu_usr == 0 && (role_usr == 2 || role_usr == 3)) {
					$('#modalNews').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});
		
		
		aggiornaComboMaestri();
		


		let dateFrom = "2018-12-01";
		postData = { ID_mae_ora: ID_mae_ora, dateFrom : dateFrom};
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_checkFirmeArretrate.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#FirmeArretrate").html(html);
				let numeroArretrati = $('#hiddenNumeroArretrati').val();
				if (numeroArretrati != 0) {
					$('#modalWarningFirmeArretrate').modal({show: 'true'});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");     
			}
		});
		
		
	});

	function aggiornaComboMaestri() {
		dataperanno = $("#data1").val();
		IDmaeTMP = $("#hidden_ID_mae").val();
		postData = { dataperanno: dataperanno, IDmaeTMP : IDmaeTMP};
		//console.log("11Ilmioregistro.php - aggiornaComboMaestri - postData a 11qry_getComboMaestri.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "11qry_getComboMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#combomaestri").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});
	}
	
	
	function moveOneWeek (n) {
		firstDate = $("#data1").val();
		let date = new Date(firstDate);
		date.setDate(date.getDate() + 7*n);
		datePublish = date.toISOString().slice(0,10);
		$("#weeklyDatePicker").val(datePublish);
		setdates();
	}
	
	function showhideSupplente (){
		if ($('#assente_ora').prop('checked')){
			$("#selectSupplentiContainer").css('visibility', 'visible');
		} else {
			$("#selectSupplentiContainer").css('visibility', 'hidden');
		}
	}
	
	function setdates () {
		let value = $("#weeklyDatePicker").val();
		let firstDate = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		let firstDateShow = moment(value, "YYYY-MM-DD").day(1).format("DD/MM/YYYY");
		$("#data1").val(firstDate);
		$("#data1Show").val(firstDateShow);
		let date = new Date(firstDate);
		for (i = 2; i < 6; i++) {
			date.setDate(date.getDate() + 1);
			datePublish = date.toISOString().slice(0,10);
			datePublishShow = moment(datePublish).format("DD/MM/YYYY");
			$("#data"+i).val(datePublish);
			$("#data"+i+"Show").val(datePublishShow);
		}
		let m = moment(firstDate, 'YYYY-MM-DD');
		let settimana = m.format('W');
		$("#weeklyDatePicker").val("sett: "+settimana);

		//bisogna mettere in una variabile temporanea il valore che ha il maestro
		//quindi aggiornare eventualmente la combo maestri (in quanto potrebbe cambiare con il cambiare dell'ora!! per questo va aggiornata)
		//rigenerare l'html che determina la combo
		//passare alla 11qry_getComboMaestri il valore temporaneo
		//se c'è nella lista riselezionare quello
		//se non c'è selezionare il primo come avviene per default
		aggiornaComboMaestri();
		
		
		
		
		requery();
	}
	
	$('#weeklyDatePicker').on('dp.change', function () {
		setdates();
	});

	function requery(){
		let ID_mae_ora = $("#hidden_ID_mae").val();
		let datalunedi = $( "#data1" ).val();
		postData = { datalunedi: datalunedi, ID_mae_ora: ID_mae_ora};
		$.ajax({
			type: 'POST',
			url: "11qry_IlMioRegistro.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});
	}
	
	
	function showModalFirmaTutto(n) {
		$('#titolo02Msg_OKCancel').html('FIRMA TUTTE LE ORE DEL GIORNO');
		$('#msg02Msg_OKCancel').html("Si stanno per firmare tutte le ore del giorno, ma senza argomento nè compiti.<br>Si potranno poi per ciascuna ora inserire argomenti svolti e/o compiti assegnati.<br><br>Confermi?");
		$("#btn_OK02Msg_OKCancel").html("Firma");
		$("#btn_OK02Msg_OKCancel").attr("onclick","firmaTutto("+n+");");
		$('#modal02Msg_OKCancel').modal('show');
	}
	
	
	function firmaTutto(n) {

		let ID_mae_ora = $("#hidden_ID_mae").val();
		let datalunedi = $( "#data1" ).val();
		postData = { datalunedi: datalunedi, ID_mae_ora: ID_mae_ora, giornodafirmare: n};
		console.log ("11IlmioRegistro - firmaTutto "+n+" postData a 11qry_firmaGiornoIntero.php")
		console.log (postData);
		
		$.ajax({
			type: 'POST',
			url: "11qry_firmaGiornoIntero.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("11IlmioRegistro - ritorno da 11qry_firmaGiornoIntero.php")
				console.log (data.test);
				console.log (data.test2);
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});


	}

	function saveFirma_ChiudiModal(ID_ora, ID_mae_ora_ORIGINALE) {
		//if ( ($('#modalargomento_ora').val() == "") || ($('#modalcompitiassegnati_ora').val() == "") ) { firma_mae_ora=2; } else {firma_mae_ora =1;}
		if ($('#modalargomento_ora').val() == "") { firma_mae_ora=2; } else {firma_mae_ora =1;}
		let argomento_ora = $('#modalargomento_ora').val();
		let compitiassegnati_ora = $('#modalcompitiassegnati_ora').val();
		if ($('#assente_ora').prop('checked')) { assente_ora = 1;} else { assente_ora = 0;}
		let supplente_ora = $( "#selectSupplente option:selected" ).val();
		
		if (ID_mae_ora_ORIGINALE == 0) {
			ID_mae_ora = $("#modalhidden_ID_mae_ora").val();
		} else {
			//in questo caso significa che si sta arrivando dal form IoSostituisco, quindi assente_ora deve essere = 1 e supplente_ora = quello che ho scritto in hiddenmodalIoSostituiscoID_supplente_ora
			ID_mae_ora = ID_mae_ora_ORIGINALE;
			if ($('#modalargomento_oraIoSost').val() == "") { firma_mae_ora=2; } else {firma_mae_ora =1;}
			argomento_ora = $('#modalargomento_oraIoSost').val();
			compitiassegnati_ora = $('#modalcompitiassegnati_oraIoSost').val();
			assente_ora = 1;
			supplente_ora = $('#hidden_ID_mae').val();
		}
		postData = { ID_ora : ID_ora, ID_mae_ora : ID_mae_ora, firma_mae_ora: firma_mae_ora, argomento_ora: argomento_ora, compitiassegnati_ora: compitiassegnati_ora, assente_ora: assente_ora, supplente_ora: supplente_ora };
		//console.log("11Ilmioregistro.php - saveFirma_ChiudiModal - postData a 11qry_UpdateFirma.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "11qry_UpdateFirma.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log("11Ilmioregistro.php - saveFirma_ChiudiModal - ritorno da 11qry_UpdateFirma.php");
				console.log (data.test);
				console.log (data.sql);
				console.log (data.altrelezionitrovate);
				$("#remove-contentFirma").slideUp();
				$("#alertmsgFirma").html('Lezione firmata, grazie!');
				$("#alertFirma").removeClass('alert-danger');
				$("#alertFirma").addClass('alert-success');
				$("#alertFirma").show();
				$("#btn_cancelFirma").html('Chiudi');
				$("#btn_OKFirma").hide();

				$("#remove-contentIoSostituisco").slideUp();
				$("#alertmsgIoSostituisco").html('Lezione firmata, grazie!');
				$("#alertIoSostituisco").removeClass('alert-danger');
				$("#alertIoSostituisco").addClass('alert-success');
				$("#alertIoSostituisco").show();
				$("#btn_cancelIoSostituisco").html('Chiudi');
				$("#btn_OKIoSostituisco").hide();


				requery();
				//$('.modal.in').modal('hide'); //usa questo codice per nascondere lo sfondo del modale se stai usando più pop modali in una pagina.
				//$('#modalFirmaDigitale').modal('hide');
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});
	}
	
	
	function SalvaNonMostrarePiu() {
		let cknonmostrarepiu_usr = $('#cknonmostrarepiu_usr').is(':checked');
		let ID_usr = $("#usr").val();
		if (cknonmostrarepiu_usr) {
			postData = {cknonmostrarepiu_usr: 1, ID_usr: ID_usr};
			//console.log (postData);
			
			$.ajax({
				url : "11qry_updateNonMostrarePiu.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(){
					//console.log (data.test);
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
				}
			});
		}
	}
	
	
	function copyToHiddenAndSetSession () {
		//console.log ($('#selectmaestro').val());
		let ID_mae = $('#selectmaestro').val();
		$('#hidden_ID_mae').val(ID_mae);
		//console.log("11Ilmioregistro.php - copyToHiddenAndSetSession - hidden_ID_mae");
		//console.log ($('#hidden_ID_mae').val());
		postData = { ID_mae : ID_mae };
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "11qry_SetSessionID_mae.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log("11Ilmioregistro.php - copyToHiddenAndSetSession - ritorno da 11qry_SetSessionID_mae.php");
				//console.log (data.test);
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '11Ilmioregistro ##fname##'");      
			}
		});
		
	}
</script>
