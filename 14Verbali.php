<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Verbali</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap337/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap337/js/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">-->
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="assets/bootstrap-select/bootstrap-select.css">
	<script src="assets/bootstrap-select/bootstrap-select.js"></script>
	<!--<script type="text/javascript" src="assets/bootstrap-select/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="assets/bootstrap-select/bootstrap-multiselect.css" type="text/css"/>-->
	<? $_SESSION['page'] = "Verbali";?>
</head>

<body>
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="highres">
			<div id="combomaestri">
				
			</div>
			<? //include("assets/functions/combomaestroCompitieVerifiche.php"); ?>
			<div class="titoloPagina" >
				Verbali
			</div>
			<div class="ml50">
				<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>
			</div>
			<div style="font-size: 12px; line-height: 12px; text-align: center; margin-bottom: 10px; ">(Compaiono i verbali delle classi del maestro e i verbali di Consiglio d'Istituto )</div>
			<div class="row">
				<div class="col-md-7" style="text-align: center; margin-left: 300px; ">
					<div class= "col-md-4" style="text-align: center;">
						anno scolastico
						<select name="selectannoscolastico"  style="text-align: center; margin-left: 30px"  id="selectannoscolastico" onchange="changedAnnoscolastico();">
							<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
								?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"  <? if ($alunno->annoscolastico_cla == $_SESSION["anno_corrente"]) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
							}?>
						</select>
					</div>
					<div class="col-md-4" style="text-align: center; " id="selectClasseContainer">
					</div>
					<div class="col-md-4" style="text-align: center; " id="selectSezioneContainer">
						<select name="selectsezione"   id="selectsezione" onchange="requery();">
							<option value="A" selected>A</option>
							<option value="B">B</option>
							<option value="C">C</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8" style="text-align: center; margin-top: 20px;">
					<table id="tabellaVerbali">
						<thead>
							<tr>
								<td style="width: 30px;">
								</td>
								<td style="width: 80px;">
									<img title="Aggiungi nuovo Verbale" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddVerbale();">
								</td>
								<td style="width: 80px;">
									<input class="tablelabel0 w100" type="text" value = "#" disabled>
								</td>
								<td style="width: 230px;">
									<input class="tablelabel0 w100" type="text" value = "Tipo Verbale" disabled>
								</td>
								<td style="width: 600px;">
									<input class="tablelabel0 w100" type="text" value = "Titolo Verbale" disabled>
								</td>
								<td style="width: 120px;">
									<input class="tablelabel0 w100" type="text" value = "Data" disabled>
								</td>
								<td style="width: 120px;">
									<input class="tablelabel0 w100" type="text" value = "Classe" disabled>
								</td>
								<td style="width: 80px;">
									<input class="tablelabel0 w100" type="text" value = "Links" disabled>
								</td>
							</tr>
						</thead>
						<tbody id="maintable">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--*******************************************MODAL FORM ADD VERBALE-->
	<div class="modal" id="modalAddVerbale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" style="font-size:14px; width: 80%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddVerbale" method="post">
						<span class="titoloModal">Dettagli Verbale</span>
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px; padding: 10px;">
							<h5 id="alertmsg" style="text-align:center;"> 
							  Inserimento completato con successo!
							</h5>
						</div>
						<div id="remove-content" style="text-align: center; margin-top: 10px; "> <!-- START REMOVE CONTENT -->
							<div class="row" style="margin-left: 100px;">
								<div class="col-md-3" style="text-align: center;">
									Tipo Verbale*
								</div>
								<div class="col-md-1" style="text-align: center;">
									ora*
								</div>
								<div class="col-md-2" style="text-align: center;">
									data*
								</div>
								<div class="col-md-3" style="text-align: center;">
									Titolo Verbale*
								</div>
								<div class="col-md-1" style="text-align: center;">
									# Ver.
								</div>

							</div>
							<div class="row" style="margin-left: 100px;">
								<div class="col-md-3" style="text-align: center;" id="TipoVerbaleContainer">
									<select style="font-size: 11px;" name="selectTipo"  id="selectTipo" class="selectpicker multiselect-ui form-control" onchange="aggiornaModal()">
										<option value="1">Consiglio di classe</option>
										<option value="2" selected>Riunione con Genitori</option>
										<option value="3">Consiglio d'Istituto</option>
										<option value="4">Consiglio di Classe verbale Votazioni</option>
									</select>
								</div>
								<div class="col-md-1">
									<input class="tablecell5" style="text-align: center;" type="text"  id="ID_ver_new" name="ID_ver_new" hidden>
									<input class="tablecell5" style="text-align: center;" type="text"  id="numeroverbali" name="numeroverbali" value="0" hidden>
									<input class="datepicker tablecell2 dpdtime" type="text"  id = "ora_ver_new" name="ora_ver_new" value = "" style="text-align: center;" required onkeydown="return false;">
								</div>
								<div class="col-md-2" style="text-align: center;  ">
									<input class="datepicker tablecell2 dpd" type="text"  id = "data_ver_new" name="data_ver_new" value = "" style="text-align: center;" required onkeydown="return false;">
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5 w100" type="text"  id="titolo_ver_new" name="titolo_ver_new">
								</div>
								<div class="col-md-1" style="text-align: center;">
									<input class="tablecell5 w100" type="text"  id="num_ver_new" name="num_ver_new" value = ".." readonly>
								</div>
								
							</div>
							<div class="row" style="margin-top: 10px; margin-left: 90px;">
								<div class="col-md-12">
									
									<div class="col-md-3" style="text-align: center;" id="InsegnantiPresentiContainer">
									</div>
									<div class="col-md-3" style="text-align: center;" id="GenitoriPresentiContainer">
									</div>
									<!--<div class="col-md-1" id="labelClasse" style="text-align: center;">
										classe<br>
										<input class="tablecell5" style="text-align: center;" type="text"  id="classe_ver_new" name="classe_ver_new" disabled>
									</div>-->
									<div class="col-md-3" style="text-align: center;">
										<span >Ulteriori Invitati</span><br>
										<textarea style="text-align: left; font-size: 11px; height: 34px; width: 222px" class="tablecell5 ml5" id="invitatiult_ver_new"></textarea>
									</div>
									<div class="col-md-1" style="text-align: center;" id="selectclasse_new_container">
										<span id="labelClasse">Classe</span><br>
										<select style="font-size: 11px;" name="selectclasse_new"  id="selectclasse_new" > <!--class="selectpicker multiselect-ui form-control" onchange="aggiornaModal()"-->
											<option value="NIDO">NIDO</option>
											<option value="ASILO">ASILO</option>
											<option value="I">I</option>
											<option value="II">II</option>
											<option value="III">III</option>
											<option value="IV">IV</option>
											<option value="V">V</option>
											<option value="VI">VI</option>
											<option value="VII">VII</option>
											<option value="VIII">VIII</option>
										</select>
									</div>
									<div class="col-md-1" id="labelSezione" style="text-align: center;">
										sezione<br>
										<input class="tablecell5" style="text-align: center;" type="text"  id="sezione_ver_new" name="sezione_ver_new" disabled>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-1" style="width: 40px; margin-left: 20px;">
								</div>
								<div class="col-md-2" style="width: 280px;">
									Argomenti trattati
								</div>
								<div class="col-md-6 w500px" style="padding-left: 5px; padding-right: 5px">
									Tematiche affrontate*
								</div>
								<div class="col-md-3 w200px" style="padding-left: 5px; padding-right: 5px">
									Decisioni assunte
								</div>
							</div>
							<div id="recordsVerbaleContainer">
							</div>
							<div class="row">
								<div class="col-md-1" style="width: 40px; margin-left: 20px; font-size: 9px; text-align: center; ">
									nuova tematica
								</div>
								<div class="col-md-2" style="width: 280px; text-align: center; " id="selecttipoargomentoContainer">
									<select name="argnum_ver_new0"  style="font-size: 11px;"  id="argnum_ver_new0" onchange="MostraNascondiAltro(0);">
										<? $sql = "SELECT numtipo_tip, desctipo_tip FROM tab_tipiargomentoverbali ORDER BY numtipo_tip";
										$stmt = mysqli_prepare($mysqli, $sql);
										mysqli_stmt_execute($stmt);
										mysqli_stmt_bind_result($stmt, $numtipo_tip, $desctipo_tip);
										while (mysqli_stmt_fetch($stmt)) {
										?> <option value="<?=$numtipo_tip?>"><?=$desctipo_tip;?></option><?
										}?>
									</select>
									<input style="width: 85%; margin-top: 5px; text-align: left; display:none;" class="tablecell5" type="text"  id="argomentoaltro_ver0" name="argomentoaltro_ver0" placeholder="...prego specificare">
								</div>
								<div class="col-md-6 w500px" style="padding-left: 5px; padding-right: 5px">
									<textarea style="text-align: left; font-size: 13px; height: 80px; resize: vertical;" class="tablecell5" id="tematiche_new"></textarea>
								</div>
								<div class="col-md-3 w200px" style="padding-left: 5px; padding-right: 5px">
									<textarea onkeyup="countChar(this)" style="text-align: left; font-size: 13px; height: 80px; resize: vertical" class="tablecell5" id="decisioni_new"></textarea>
								</div>
								<div id="charNum" class="charNum"></div>
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="width:40%;" onclick="salvaVerbale();">Salva Verbale</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


<!--***************************************FORM MODALE LINK DEL VERBALE **************************************************-->
		<div class="modal" id="modalLinksVerbale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_LinksVerbale" method="post">
						<span class="titoloModal">Gestione Links Verbale</span>
                        
						<div id="remove-contentLinksVerbale" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							

						</div>
						<div class="alert alert-success" id="alertLinksVerbale" style="display:none; margin-top:10px;">
							<h4 id="alertmsgLlinksVerbale" style="text-align:center;"> 
							  Iscrizione completata con successo!
							</h4>
						</div>
						<div class="modal-footer" >

							<button type="button" id="btn_CancelModalLinksVerbale" class="btnBlu" style="width:40%;" data-dismiss="modal">Chiudi</button>
						<button type="button" id="btn_OKModalLinksVerbale" class="btnBlu" style="width:40%;" onclick="salvaLinks();">Salva</button>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE LINK DEL VERBALE **************************************************-->



</body>
</html>

<script>


	$(document).ready(function(){
		popolaComboMaestri();
		aggiornaClassi();
		//changedAnnoscolastico();
		moment.locale('en', {
			week: { dow: 1 }
		});
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
			weekStart: 1
			//format: "DD/MM"
		});
		$('.dpdtime').datetimepicker({
			format: 'HH:mm',
			pickDate: false,
			pickSeconds: false,
			pick12HourFormat: false
		});
		//$('#selectVerbali').multiselect({
        //        includeSelectAllOption: true
        //});
		$('.selectpicker').selectpicker();
	});
	

	
	
	function aggiornaModal() {
		let tipo_ver = $('#selectTipo').val();
		
		console.log ("tipoverbale"+tipo_ver);
		//consiglio di classe
		if (tipo_ver == "1") {
			//mostra tutto
			$("#labelClasse").show();
			//$("#classe_ver_new").show();
			$("#selectclasse_new").show();
			$("#labelSezione").show();
			$("#sezione_ver_new").show();
			//deseleziona e inibisce genitori
			disableGenitori();
		}
		//riunione con genitori
		if (tipo_ver == "2") {
			//mostra tutto
			$("#labelClasse").show();
			//$("#classe_ver_new").show();
			$("#selectclasse_new").show();
			$("#labelSezione").show();
			$("#sezione_ver_new").show();
			$('#labelGenitori').css('color', 'black');
			$('#selectGenitori').prop("disabled", false);
			$('#selectGenitori').selectpicker('refresh');
		}
		//consiglio d'istituto
		if (tipo_ver == "3") {
			//inibisce/nasconde classe e sezione
			$("#labelClasse").hide();
			//$("#classe_ver_new").hide();
			$("#selectclasse_new").hide();
			$("#labelSezione").hide();
			$("#sezione_ver_new").hide();
			//deseleziona e inibisce genitori
			disableGenitori();
		}

		if (tipo_ver == "4") {
			//mostra tutto
			$("#labelClasse").show();
			//$("#classe_ver_new").show();
			$("#selectclasse_new").show();
			$("#labelSezione").show();
			$("#sezione_ver_new").show();
			//deseleziona e inibisce genitori
			disableGenitori();
		}
		
	}
	
	function disableGenitori() {
		console.log("reset select genitori");

		$('#selectGenitori option:selected').each(function() {
			$(this).prop('selected', false);
		});
		
		$('#selectGenitori').prop("disabled", true);
		$('#selectGenitori').selectpicker('refresh');
		$('#labelGenitori').css('color', 'grey');
		
	}


	function popolaComboMaestri() {
		//popola in maniera SINCRONA la combo maestri e seleziona il primo valore.
		//viene lanciata SOLO in caricamento pagina
		//console.log ("14Verbali.php - popolaComboMaestri");
		//funzione da lanciare al caricamento e su changedAnnoScolastico
		//pesca i valori da inserire nella combo in alto
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		IDmaeTMP = $("#hidden_ID_mae").val();
		postData = { annoscolastico_cma: annoscolastico_cma, IDmaeTMP : IDmaeTMP};
		//console.log ("14Verbali.php - popolaComboMaestri - postData a 14qry_getComboMaestri.php");
		//console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "14qry_getComboMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#combomaestri").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}

	function aggiornaClassi() {
		//console.log ("14Verbali.php - aggiornaClassi");
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		ID_mae = $("#hidden_ID_mae").val();
		postData = { annoscolastico_cma: annoscolastico_cma, ID_mae : ID_mae};
		//console.log ("14Verbali.php - aggiornaClassi - postData a 14qry_getSelectClassiVerbali.php");
		//console.log (postData);
		$.ajax({
			async:false,
			type: 'POST',
			url: "14qry_getSelectClassiVerbali.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectClasseContainer").html(html);
				PopolaGenitoriPresenti(""); //serve perchè la stessa combo viene usata in fase di inserimento di un nuovo verbale...allora azzerando le selezioni uno non se le trova poi segnate
				PopolaInsegnantiPresenti(""); //come sopra
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}

	function copyToHiddenAndSetSession () {
		//console.log ($('#selectmaestro').val());
		
		let ID_mae = $('#selectmaestro').val();
		$('#hidden_ID_mae').val(ID_mae);
		postData = { ID_mae : ID_mae };
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "11qry_SetSessionID_mae.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				//console.log (data.test);
				changedMaestro();
				//requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
		
	}

	function changedMaestro() {
		console.log ("14Verbali.php - changedMaestro - aggiorno le classi");
		//funzione da lanciare al caricamento e su changedAnnoScolastico
		//pesca i valori da inserire nella combo in alto
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		ID_mae = $("#hidden_ID_mae").val();
		postData = { annoscolastico_cma: annoscolastico_cma, ID_mae : ID_mae};
		console.log ("14Verbali.php - changedMaestro - postData a 14qry_getSelectClassiVerbali.php");
		console.log (postData);
		$.ajax({
			async:false,
			type: 'POST',
			url: "14qry_getSelectClassiVerbali.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectClasseContainer").html(html);
				PopolaGenitoriPresenti(""); //serve perchè la stessa combo viene usata in fase di inserimento di un nuovo verbale...allora azzerando le selezioni uno non se le trova poi segnate
				PopolaInsegnantiPresenti(""); //come sopra
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}


	function changedAnnoscolastico() {
		let annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		let ID_mae = $( "#hidden_ID_mae" ).val();
		postData = { annoscolastico_cma: annoscolastico_cma, ID_mae: ID_mae};
		//console.log (postData);
		//devo metterla ssync false altrimenti non viene selezionata la classe in tempo prima della chiamata della requery
		$.ajax({
			async:false,
			type: 'POST',
			url: "14qry_getSelectClassiVerbali.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectClasseContainer").html(html);
				popolaComboMaestri();
				aggiornaClassi();
				//PopolaGenitoriPresenti(""); //serve perchè la stessa combo viene usata in fase di inserimento di un nuovo verbale...allora azzerando le selezioni uno non se le trova poi segnate
				//PopolaInsegnantiPresenti(""); //come sopra
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}
	
	function changedClasse() {
		console.log ("14Verbali.php - changedClasse");
		// let annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		// let ID_mae = $( "#hidden_ID_mae" ).val();
		// postData = { annoscolastico_cma: annoscolastico_cma, ID_mae: ID_mae};
		// console.log ("14Verbali.php - changedClasse - postdata a 14qry_getSelectClassiVerbali.php");
		// console.log (postData);
		// //devo metterla async false altrimenti non viene selezionata la classe in tempo prima della chiamata della requery
		// $.ajax({
		// 	async:false,
		// 	type: 'POST',
		// 	url: "14qry_getSelectClassiVerbali.php",
		// 	data: postData,
		// 	dataType: 'html',
		// 	success: function(html){
		// 		$("#selectClasseContainer").html(html);
		// 		PopolaGenitoriPresenti(""); //serve perchè la stessa combo viene usata in fase di inserimento di un nuovo verbale...allora azzerando le selezioni uno non se le trova poi segnate
		// 		PopolaInsegnantiPresenti(""); //come sopra
		// 	}
		// });

		PopolaGenitoriPresenti(""); //serve perchè la stessa combo viene usata in fase di inserimento di un nuovo verbale...allora azzerando le selezioni uno non se le trova poi segnate
		PopolaInsegnantiPresenti(""); //come sopra
	}

	function PopolaGenitoriPresenti(idalunni_ver) {
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		postData = { annoscolastico_cla: annoscolastico_cla, classe_cla: classe_cla, sezione_cla: sezione_cla, idalunni_ver: idalunni_ver};
		// console.log("14Verbali.php - PopolaGenitoriPresenti - postData a 14qry_getGenitoriClasse.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "14qry_getGenitoriClasse.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#GenitoriPresentiContainer").html(html);
				//requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}
	
	function PopolaInsegnantiPresenti(iddocenti_ver) {
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		postData = { annoscolastico_cla: annoscolastico_cla, classe_cla: classe_cla, sezione_cla: sezione_cla, iddocenti_ver: iddocenti_ver};
		//console.log("PopolaInsegnantiPresenti");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "14qry_getInsegnanti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#InsegnantiPresentiContainer").html(html);
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
		
		
	}

	function requery(){
		let ID_mae = $('#hidden_ID_mae').val();
		let annoscolastico_ver = $( "#selectannoscolastico option:selected" ).val();
		let classe_selezionata = $( "#selectclasse option:selected" ).val();
		let sezione_selezionata = $( "#selectsezione option:selected" ).val();
		postData = {annoscolastico_ver: annoscolastico_ver, classe_selezionata : classe_selezionata, sezione_selezionata: sezione_selezionata, ID_mae: ID_mae};
		// console.log("14Verbali.php - requery - postData a 14qry_Verbali.php")
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "14qry_Verbali.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
	}
	
	function showModalAddVerbale (){
		//mostra il form modale in fase di primo inserimento, azzerando tutto
		resetModalAddVerbale();
		$('#form_AddVerbale')[0].reset();
		let classe_ver = $("#selectclasse option:selected" ).val();
		$("#selectclasse_new").val(classe_ver).change();
		//$("#classe_ver_new").val(classe_ver);
		let sezione_ver = $( "#selectsezione option:selected" ).val();
		$("#sezione_ver_new").val(sezione_ver);
		PopolaGenitoriPresenti('');
		PopolaInsegnantiPresenti('');
		aggiornaModal();
		$('#modalAddVerbale').modal({show: 'true'});
	}
	
	function showModalVerbale (num_ver){
		//mostra il form modale caricando i valori dal db
		resetModalAddVerbale();
		$('#form_AddVerbale')[0].reset();
			//era così ma ho effettuato la selezione della classe solo dopo aver lanciato il form modale		
			//let classe_ver = $("#selectclasse option:selected" ).val();
			//console.log (classe_ver);
			//$("#selectclasse_new").val(classe_ver).change();
		//$("#classe_ver_new").val(classe_ver);
		let sezione_ver = $( "#selectsezione option:selected" ).val();
		$("#sezione_ver_new").val(sezione_ver);
		//faccio prima una chiamata ajax post di tipo data per alcuni dati base (ora, data, titolo, numero, insegnanti presenti e genitori presenti)
		postData = {num_ver: num_ver};
		console.log("14Verbali.php - showModalVerbale - postData a 14qry_getVerbaleBasics.php")
		console.log (postData);
		$.ajax({
			url : "14qry_getVerbaleBasics.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				//console.log("14Verbali.php - showModalVerbale - ritorno da 14qry_getVerbaleBasics.php");
				//console.log (data.sql);
				//console.log ("titolo: "+data.titolo_ver);
				$('#num_ver_new').val(num_ver);
				$("#selectTipo").val(data.tipo_ver).change();
				$('#ora_ver_new').val(data.ora_ver);
				$('#data_ver_new').val(data.data_ver);
				$('#titolo_ver_new').val(data.titolo_ver);
				$('#classe_ver_new').val(data.classe_ver);
				$("#selectclasse_new").val(data.classe_ver).change();
				$('#sezione_ver_new').val(data.sezione_ver);
				$('#invitatiult_ver_new').html(data.invitatiult_ver);

				PopolaGenitoriPresenti(data.idalunni_ver);
				PopolaInsegnantiPresenti(data.iddocenti_ver);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
		//ora faccio una chiamata ajax post di tipo html per l'elenco delle tematiche
		$.ajax(
		{
			url : "14qry_getVerbaleRecords.php",
			type: "POST",
			data : postData,
			dataType: "html",
			success:function(html) {
				//console.log (data.sql);
				//reset delle varie parti del modale
				$("#recordsVerbaleContainer").html(html);
				$("#remove-content").show();
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").hide();
				$("#btn_cancel1").html('Annulla');
				$("#btn_cancel1").addClass('pull-left');
				$("#btn_goto1").hide();
				$("#btn_OK1").show();
				requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
			}
		});
		aggiornaModal();
		$('#modalAddVerbale').modal({show: 'true'});
	}
	
	function resetModalAddVerbale() {
		$('#form_AddVerbale')[0].reset();
		$('#argomentoaltro_ver0').hide();
		$("#recordsVerbaleContainer").empty();
		$("#remove-content").show();
		$("#alertaggiungi").addClass('alert-danger');
		$("#alertaggiungi").removeClass('alert-success');
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_cancel1").addClass('pull-left');
		$("#btn_OK1").show();
	}
	
	function salvaVerbale(){


		let postData = $("#form_AddVerbale").serializeArray();
		let ora_ver_new = $('#ora_ver_new').val();
		let data_ver_new = $('#data_ver_new').val();
		let titolo_ver_new = $('#titolo_ver_new').val();
		let invitatiult_ver_new = $('#invitatiult_ver_new').val();
		postData.push( {name: "invitatiult_ver_new", value: invitatiult_ver_new}  );
		let selectTipo = $('#selectTipo').val();
		let selectedInsegnanti = $('#selectInsegnanti').val();
		postData.push( {name: "selectedInsegnanti", value: selectedInsegnanti}  );
		let selectedGenitori = $('#selectGenitori').val();
		postData.push( {name: "selectedGenitori", value: selectedGenitori}  );
		//let classe_ver = $("#selectclasse option:selected" ).val();
		let classe_ver = $("#selectclasse_new option:selected" ).val();
		postData.push( {name: "classe_ver", value: classe_ver}  );
		let sezione_ver = $( "#selectsezione option:selected" ).val();
		postData.push( {name: "sezione_ver", value: sezione_ver}  );
		let annoscolastico_ver = $( "#selectannoscolastico option:selected" ).val();
		postData.push( {name: "annoscolastico_ver", value: annoscolastico_ver}  );
		/* c'è già in serializearray
		let argnum_ver_new = $( "#argnum_ver_new option:selected" ).val();
		postData.push( {name: "argnum_ver_new", value: argnum_ver_new}  );*/
		let txtargomentoaltro_ver = $( "#argomentoaltro_ver0").val();
		if (txtargomentoaltro_ver =="" ){txtargomentoaltro_ver = $( "#argnum_ver_new0 option:selected" ).text();}
		postData.push( {name: "txtargomentoaltro_ver", value: txtargomentoaltro_ver}  );
		let tematiche_new = $('#tematiche_new').val();
		postData.push( {name: "tematiche_new", value: tematiche_new}  );
		let decisioni_new = $('#decisioni_new').val();
		postData.push( {name: "decisioni_new", value: decisioni_new}  );
		let num_ver = $('#num_ver_new').val();
		postData.push( {name: "num_ver", value: num_ver}  );

		if ($('#num_ver_new').val() == "..") {
			//caso nuovo verbale
			if ((ora_ver_new =="") || (data_ver_new=="") || (titolo_ver_new=="") || (tematiche_new=="")){
				$("#alertaggiungi").removeClass('salert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Tutti i campi contrassegnati da * sono obbligatori');
				$("#alertaggiungi").show();
			} else {
				console.log("14Verbali.php - salvaVerbale - postData a 14qry_insertVerbale.php")
				console.log (postData);
				console.log("14Verbali.php - salvaVerbale - verificato che campi obbligatori sono compilati");
				$.ajax(
				{
					url : "14qry_insertVerbale.php",
					type: "POST",
					data : postData,
					dataType: "json",
					success:function(data) {
						console.log("14Verbali.php - salvaVerbale - ritorno da 14qry_insertVerbale.php")
						console.log(data.sql);
						console.log (data.test);
						$("#remove-content").slideUp();
						$("#alertaggiungi").removeClass('alert-danger');
						$("#alertaggiungi").addClass('alert-success');
						$("#alertmsg").html('Verbale inserito/aggiornato!');
						$("#alertaggiungi").show();
						$("#btn_cancel1").html('Chiudi');
						$("#btn_cancel1").removeClass('pull-left');
						$("#btn_goto1").show();
						$("#btn_OK1").hide();
						requery();
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
					}
				});
			}
		} else {
			//caso verbale esistente
			if ((ora_ver_new =="") || (data_ver_new=="") || (titolo_ver_new=="")) {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Tutti i campi contrassegnati da * sono obbligatori');
				$("#alertaggiungi").show();
			} else {
				//si mette mano con una insert se c'è un nuovo record (tematiche_new != "")
				if (tematiche_new!="") {
					console.log("Si tratta dell'edit di un verbale esistente. La tematica del nuovo è <> null -> sto inserendo il nuovo record con lo stesso num_ver");
					console.log("num_ver:"+num_ver);
					postData.push( {name: "nuovo_verbale", value: 'no'}  );
					$.ajax(
					{
						url : "14qry_insertVerbale.php",
						type: "POST",
						data : postData,
						dataType: "json",
						success:function(data) {
							console.log("14Verbali.php - salvaVerbale - ritorno da 14qry_insertVerbale.php / CASO VERBALE ESISTENTE")
							console.log ("INSERTSQL: "+ data.sql);
							console.log (data.test);
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
						}
					});
				}
				//adesso aggiorno tutti i record (escluso quello nuovo) con un ciclo for e questo lo faccio sempre, non
				//è condizionato come l'insert al fatto che ci sia o meno
				numeroRecords = $('#numeroRecords').val();
				for (i = 1; i <= numeroRecords; i++) {
					let ID_ver = $('#IDcontainer'+i).val();
					let argnum_ver_newi = $( "#argnum_ver_new"+i+" option:selected" ).val();
					let tematiche_newi = $('#tematiche_new'+i).val();
					let decisioni_newi = $('#decisioni_new'+i).val();
					let txtargomentoaltro_veri = $( "#argomentoaltro_ver"+i).val();
					if (txtargomentoaltro_veri =="" ) {txtargomentoaltro_veri = $( "#argnum_ver_new"+i+" option:selected" ).text();}
					let postData1 = [];
					postData1.push( {name: "ID_ver", value: ID_ver}  );
					postData1.push( {name: "ora_ver_new", value: ora_ver_new}  );
					postData1.push( {name: "data_ver_new", value: data_ver_new}  );
					postData1.push( {name: "selectTipo", value: selectTipo}  );
					postData1.push( {name: "selectedInsegnanti", value: selectedInsegnanti}  );
					postData1.push( {name: "selectedGenitori", value: selectedGenitori}  );
					postData1.push( {name: "invitatiult_ver_new", value: invitatiult_ver_new}  );
					postData1.push( {name: "titolo_ver_new", value: titolo_ver_new}  );
					postData1.push( {name: "argnum_ver_new", value: argnum_ver_newi}  );
					postData1.push( {name: "txtargomentoaltro_ver", value: txtargomentoaltro_veri}  );
					postData1.push( {name: "tematiche_new", value: tematiche_newi}  );
					postData1.push( {name: "decisioni_new", value: decisioni_newi}  );
					postData1.push( {name: "annoscolastico_ver", value: annoscolastico_ver}  );
					postData1.push( {name: "classe_ver", value: classe_ver}  );
					postData1.push( {name: "sezione_ver", value: sezione_ver}  );
					console.log("14Verbali.php - salvaVerbale - postData a 14qry_updateVerbale.php")
					console.log (postData1);
					$.ajax(
					{
						url : "14qry_updateVerbale.php",
						type: "POST",
						data : postData1,
						dataType: "json",
						success:function(data) {
							console.log ("UPDATESQL: "+ data.sql);
							$("#remove-content").slideUp();
							$("#alertaggiungi").removeClass('alert-danger');
							$("#alertaggiungi").addClass('alert-success');
							$("#alertmsg").html('Verbale inserito/aggiornato!');
							$("#alertaggiungi").show();
							$("#btn_cancel1").html('Chiudi');
							$("#btn_cancel1").removeClass('pull-left');
							$("#btn_goto1").show();
							$("#btn_OK1").hide();
							requery();
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
						}
					});
				}
			}
		}
	}
	
	function MostraNascondiAltro (i) {
		let argnum_ver_new = $( "#argnum_ver_new"+i+" option:selected" ).val();
		if (argnum_ver_new == 9) {$('#argomentoaltro_ver'+i).show();} else {$('#argomentoaltro_ver'+i).hide();}
	}



	function showModalDeleteArgomento(ID_ver) {
		$('#titolo02Msg_OKCancel').html('ELIMINA ARGOMENTO');
		$('#msg02Msg_OKCancel').html("Sei sicuro di voler eliminare questa tematica?");
		$("#btn_OK02Msg_OKCancel").html("Elimina");
		$("#btn_OK02Msg_OKCancel").attr("onclick","deleteArgomento("+ID_ver+");");
		$('#modal02Msg_OKCancel').modal('show');
	}



	function deleteArgomento (ID_ver) {

			postData = {ID_ver: ID_ver };
			$.ajax({
				url : "14qry_deleteTematica.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function(data) 
				{
					console.log ("DELETESQL: "+ data.sql);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html('Tematica Cancellata!');
					$("#alertaggiungi").show();
					$("#btn_cancel1").html('Chiudi');
					$("#btn_cancel1").removeClass('pull-left');
					$("#btn_goto1").show();
					$("#btn_OK1").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
				}
			});
		
	}
	

	function showModalDeleteThisRecord(num_ver, data_ver) {
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare il verbale del "+data_ver+" ? <br><br> digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+num_ver+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE VERBALE');
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}


	function deleteThisRecord (num_ver) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			postData = {num_ver: num_ver };
			$.ajax({
				url : "14qry_deleteVerbale.php",
				type: "POST",
				data : postData,
				dataType: "json",
				success:function() 
				{
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Verbale eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					//console.log ("DELETESQL: "+ data.sql);
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '14verbali ##fname##'");     
				}
			});
		}
	}
	
	function countChar(val) {
        var len = val.value.length;
        if (len > 1500) {
          val.value = val.value.substring(0, 1500);
        } else {
          $('#charNum').text((1500 - len)+ "\n car. rimanenti");
        }
      };


</script>