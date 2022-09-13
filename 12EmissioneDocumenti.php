<?header('Content-Type: text/html; charset=utf-8');
	//nella sezione EMISSIONE DOCUMENTI CLASSE la combo annoscolastico è quella che comanda, insieme all'ID_mae l'elenco delle classi mostrate.
	//tuttavia sarebbe necessario che anche la selezione delle settimane (riga sopra alla combo annoscolastico) determinasse un aggiornamento dell'elenco della combo
	//altrimenti non sarà possibile fare una selezione nel passato per il primo dei due documenti
	//attualmente esiste questo limite. Il filtro funziona (IL DOWNLOAD AVVIENE LEGGENDO I VALORI SELEZIONATI IN QUEL MOMENTO), ma non consnte di scegliere la classe dell'anno precedente per il primo dei due docs...da ricordare.
	//inoltre la sezione non viene attualmente limitata da annoscolastico+ID_mae, ma è semplicemente una selezione statica di A B C
	//se dovessero (in altra scuola) esserci altre sezioni su cui sia necessario lavorare...provvedere.
	//un'altra possibilità per svincolarsi dagli aggiornamenti delle combo combinati e altri casini questo sarebbe che la combo riportasse non solo la classe ma anche la sezione, tutta insieme.
	//cioè ad es I A, II A, III A, III B , IV A, IV B, IV C ecc.
	//in questo caso, tuttavia, sarebbe necessario che il valore della combo fosse non V ma V.A o V.B o VIII.B...e che sezione e classe venissero POI "separate" al momento in cui le si legge
	//per poter usare il dato
	//PER ORA COSì è SUFFICIENTE MA PER SVILUPPI FUTURI SI DOVREBBE METTERE MANO
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>
<!DOCTYPE html>
	
<html>
<head>
	<title>Emissione Documenti</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous">-->
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<? $_SESSION['page'] = "Emissione Documenti";?>
</head>
<body>
	<? include("NavBar.php"); ?>
	<div id="main">
		<? //include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper">
			<?
			$ID_mae = $_SESSION['ID_mae'];
			$nome_mae =  $_SESSION['nome_mae'];
			$cognome_mae =  $_SESSION['cognome_mae'];
			?>
			
			<div id="combomaestri" style="text-align: center; font-size: 14px; color: #3c3c3c;" >
				<? //include("assets/functions/combomaestroEmissioneDocumenti.php"); ?>
			</div>
			
			<div class="titoloPagina" >
				Console Emissione Documenti
				<input id="aselme_cla_hidden"	hidden>
				<input id="tipopagella_hidden" 	hidden>
				<input id="tipopagella2_hidden" hidden>
			</div>
			<div style="text-align: center; font-size: 14px; color: #3c3c3c;" >
				(per primaria e secondaria)	
			</div>
			<div class="row" style="text-align: center;" >
				<div class="col-md-8 col-md-offset-2" >
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-sm-2 col-sm-offset-3 col-md-2 col-md-offset-3">
							<div class="row">
								anno scolastico
							</div>
							<div class="row">
								<select name="selectannoscolastico"  style="margin-left: 0px;"  id="selectannoscolastico" onchange="aggiornaComboMaestri(); PopolaSelectClasse(); PopolaSelectAlunno();">
									<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
										?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"  <? if ($alunno->annoscolastico_cla == $_SESSION["anno_corrente"]) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
									}?>
								</select>
							</div>
						</div>
						<div id="selectClasseContainer" class="col-xs-10 col-xs-offset-1 col-sm-2 col-sm-offset-0 col-md-2 col-md-offset-0">
							
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-md-2 col-sm-2 col-sm-offset-0 col-md-offset-0">
							<div class="row">
								Sezione
							</div>
							<div class="row">
								<select name="selectsezione"   id="selectsezione">
									<option value="A" selected>A</option>
									<option value="B">B</option>
									<option value="C">C</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="border-top: 1px solid grey; margin-top: 5px; ">
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu" style="width: 100%; margin-top: 10px;" id="Pagelle" onclick="ShowModalGiornaledellaClasse();" title="Registro di Classe->pdf"><img style="width: 17px; position: absolute; left:20px; " src='assets/img/Icone/pdf.svg'>Giornale della classe ...</button>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu w100 mt5" id="Votazioni" onclick="scaricaVotazioniPOST();" title="Registro Votazioni->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Giornale dell'Insegnante</button>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu w100 mt5" id="Verbali" onclick="ShowModalVerbalidellaClasse();" title="Verbale->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Verbali della classe...</button>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu w100 mt5" id="Elenco Assenze" onclick="ShowModalElencoAssenze();" title="Elenco Assenze->Excel"><img style="width: 20px; position: absolute; left:20px;" src='assets/img/Icone/logoexcel2019.svg'>Giorni di Assenza della classe per mese ...</button>	
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu w100 mt5" id="CalcoloAssenze" onclick="ShowModalCalcoloAssenze();" title="Calcolo Assenze->Excel"><img style="width: 20px; position: absolute; left:20px;" src='assets/img/Icone/logoexcel2019.svg'>Calcolo Ore di Assenza ...</button>	
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
							<button class="btnBlu w100 mt5" id="ElencoVoti" onclick="scaricaVotazioniExcel();" title="Votazioni per Alunno->Excel"><img style="width: 20px; position: absolute; left:20px;" src='assets/img/Icone/logoexcel2019.svg'>Elenco Votazioni per Alunno e Medie</button>	
						</div>
					</div>
					<div class="row" style="border-top: 1px solid grey; margin-top: 5px; ">
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3" style="font-size: 18px; margin-top: 10px;">
							DOCUMENTI DEGLI ALUNNI
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1" >
							<div id="boxalunni1" style="border: 1px solid grey; border-radius: 4px; margin-top: 5px; height: 285px; ">
								<div class="col-xs-12">
									PER CLASSE INTERA
								</div>
								<div class="col-xs-12" style="width: 100%; text-align: center; font-size: 14px; margin-top: 0px;">
									&nbsp;
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 " id="Sinottico pagelle" onclick="scaricaSinotticoPagelle();" title="Sinottico Pagelle->Excel"><img style="width: 20px; position: absolute; left:20px;" src='assets/img/Icone/logoexcel2019.svg'>Sinottico Pagelle</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" id="Pagelle Batch" onclick="scaricaPagellePOST(1, 'PagUff');" title="Pagelle della classe->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Pagelle della classe - I Quad.</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" id="Pagelle Batch" onclick="scaricaPagellePOST(2, 'PagUff');" title="Pagelle della classe->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Pagelle della classe - II Quad.</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" id="Pagelle Batch" onclick="scaricaPagellePOST(1, 'DocInt');" title="Documenti di Valutazione Interni->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Doc. Interni della classe - I Quad.</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" id="Pagelle Batch" onclick="scaricaPagellePOST(2, 'DocInt');" title="Documenti di Valutazione Interni->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Doc. Interni della classe - II Quad.</button>
								</div>

							</div>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-5 col-sm-offset-0 col-md-5 col-md-offset-0" >
							<div style="border: 1px solid grey; border-radius: 4px; margin-top: 5px; height: 285px; ">
								<div class="col-xs-12">
									PER SINGOLO ALUNNO
								</div>
								<div class="col-xs-12" style="font-size: 9px;">
									(disponibili anche nella vista -I miei alunni-)
								</div>
								<div class="col-xs-12" id="selectAlunnoPagella1" style="margin-top:12px;">
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(1, 'PagUff');" title="Pagella 1^quad->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Pagella I Quadrimestre</button>	
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(2, 'PagUff');" title="Pagella 2^quad->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Pagella II Quadrimestre</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(1, 'DocInt');" title="Doc Interno 1^quad->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Doc. Interno I Quad.</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(2, 'DocInt');" title="Doc Interno 2^quad->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Doc. Interno II Quad.</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(2, 'CerCom');" title="Cert.Competenze->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Cert. Competenze</button>
								</div>
								<div class="col-xs-12">
									<button class="btnBlu w100 mt5" onclick="scaricaPagellaPOST(2, 'ConOri');" title="Cons.Orientativo->pdf"><img style="width: 17px; position: absolute; left:20px;" src='assets/img/Icone/pdf.svg'>Cons. Orientativo</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2" >
					
					<table id="layoutEmissioneDocumenti2" class="w100">
						<!--***************************************************** EMISSIONE DOCUMENTI ALUNNI ***************************************************-->

						<tr>
							<td>
							</td>
							<td style="padding-top: 5px;">
								
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td style="padding-top: 5px;">
								
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalGiornaledellaClasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">DOWNLOAD GIORNALE DELLA CLASSE</span>
					<div id="remove-content1" style="text-align: center; font-size: 14px; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<span>Selezionare la settimana di inizio</span>
							</div>
							<div class="row">
								<input class="tablecell3" type='text' id='weeklyDatePicker' placeholder="Seleziona la settimana" style="z-index: 1; text-align: center;" readonly>
								<input id="hidden_datalunedi" type="text" hidden>
							</div>
							<div class="row" style="margin-top: 10px;">
								Indicare il numero di settimane da scaricare
							</div>
							<div class="row">	
								<input class="tablecell3" type='text' id='settimane' style="width: 40px; text-align: center; " value ="1">
							</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="scaricaGiornaleClassePOST();">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalVerbali" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">DOWNLOAD VERBALI DELLA CLASSE</span>
					<div id="remove-content1" style="text-align: center; font-size: 14px; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div id="selectVerbaliContainer">
								</div>
							</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="scaricaVerbalePOST();">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<div class="modal" id="modalElencoAssenzePerMese" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">DOWNLOAD<br>ELENCO ASSENZE DELLA CLASSE<br>PER MESE</span>
					<div id="remove-content1" style="text-align: center; font-size: 14px; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<select name="selectmese"  style="margin-left: 0px; width: 140px;"  id="selectmese">
									<option value="9">Settembre</option>
									<option value="10">Ottobre</option>
									<option value="11">Novembre</option>
									<option value="12">Dicembre</option>
									<option value="1">Gennaio</option>
									<option value="2">Febbraio</option>
									<option value="3">Marzo</option>
									<option value="4">Aprile</option>
									<option value="5">Maggio</option>
									<option value="6">Giugno</option>
								</select>
							</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="scaricaAssenze();">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal" id="modalCalcoloAssenze" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">DOWNLOAD<br>CALCOLO ASSENZE DELLA CLASSE<br>DAL..AL..</span>
					<div id="remove-content1" style="text-align: center; font-size: 14px; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								Dal
							</div>
							<div class="row">
								<input style="text-align: center;" class="tablecell3 dpd" type="text"  id="date_from" name="date_from">
							</div>
							<div class="row" style="margin-top: 10px; ">
								Al
							</div>
							<div class="row" style="margin-bottom: 20px;">
								<input style="text-align: center; " class="tablecell3 dpd" type="text"  id="date_to" name="date_to">
							</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="modal-footer">
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_cancelUscita" class="btnBlu" style="width:40%;" data-dismiss="modal" onclick="scaricaCalcoloAssenze();">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>


</body>
</html>
<script>
	
	function copyToHidden () {
		console.log ($('#selectmaestro').val());
		$('#hidden_ID_mae').val($('#selectmaestro').val());
		//requery();
	}
		
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

	
		$('.dpd').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
			weekStart: 1
		});
		
		$('#settimane').val(1);
		$('#paginauno').val(1);
		aggiornaComboMaestri();
		PopolaSelectClasse();
		PopolaSelectAlunno();
		Popola_aselme_cla();
		Popola_tipopagella();
		PopolaVerbali();
		
		var viewportWidth = $(window).width();
		if (viewportWidth < 1280) { $("#boxalunni1").height(220);}

		
		
	});
	
	function aggiornaComboMaestri() {
		annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		IDmaeTMP = $("#hidden_ID_mae").val();
		postData = { annoscolastico_cma: annoscolastico_cma, IDmaeTMP : IDmaeTMP};
		console.log (postData);
		$.ajax({
			async: false,
			type: 'POST',
			url: "12qry_getComboMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#combomaestri").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});
	}
	

	$('#weeklyDatePicker').on('dp.change', function () {
		setdates();
	});
	
	function setdates () {
		let datascritta = $("#weeklyDatePicker").val();
		let firstDate = moment(datascritta, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
		firstDatePublish = convert_YYYYMMDD_to_ddmmyyyy (firstDate);
		$("#hidden_datalunedi").val(firstDate);
		$("#weeklyDatePicker").val(firstDatePublish);
		//$("#settimana_al").val(lastDate);
		//console.log (lastDate);
	}
	
	function convert_YYYYMMDD_to_ddmmyyyy(dateStr)
	{
	  dArr = dateStr.split("-");  // ex input "2010-01-18"
	  return dArr[2]+ "/" +dArr[1]+ "/" +dArr[0]; //ex out: "18/01/10"
	}

	function PopolaSelectAlunno(){
		let ID_mae = $("#hidden_ID_mae").val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		postData = { ID_mae : ID_mae, annoscolastico_cla: annoscolastico_cla, classe_cla: classe_cla, sezione_cla: sezione_cla};
		//console.log ("passo a 12qry_getElencoAlunni:_");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "12qry_getElencoAlunni.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectAlunnoPagella1").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});
	}

	
	function PopolaSelectClasse () {
		let annoscolastico_cma = $( "#selectannoscolastico option:selected" ).val();
		let ID_mae = $( "#hidden_ID_mae" ).val();
		postData = { annoscolastico_cma: annoscolastico_cma, ID_mae: ID_mae};
		//console.log ("12EmissioneDocumenti.php - PopolaSelectClasse");
		$.ajax({
			async: false,
			type: 'POST',
			url: "12qry_getSelectClassiEmissioneDocumenti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectClasseContainer").html(html);
				PopolaVerbali();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");     
			}
		});
	}
	
	function Popola_aselme_cla() {
		let classe_cls = $( "#selectclasse option:selected" ).val();
		postData = {classe_cls: classe_cls};
		//console.log ("12EmissioneDocumenti.php - Popola_aselme_cla");
		$.ajax({
			type: 'POST',
			url: "12qry_getaselme.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				$('#aselme_cla_hidden').val(data.aselme_cls);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});
	}

	function Popola_tipopagella() {
		let classe_cls = $( "#selectclasse option:selected" ).val();
		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		postData = {classe_cls: classe_cls};
		//console.log ("12EmissioneDocumenti.php - Popola_tipopagella - postData a 12qry_getaselme");
		//console.log(postData);
		$.ajax({
			type: 'POST',
			url: "12qry_getaselme.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				postData = {aselme: data.aselme_cls, annoscolastico: annoscolastico};
				//console.log ("12EmissioneDocumenti.php - Popola_tipopagella - postData a 12qry_getTipoPagella");
				//console.log(postData);
				$.ajax({
					type: 'POST',
					url: "12qry_getTipoPagella.php",
					data: postData,
					dataType: 'json',
					success: function(data2){
						//console.log ("12EmissioneDocumenti.php - Popola_tipopagella - ritorno da 12qry_getTipoPagella");
						//console.log(data2.val_paa);
						$('#tipopagella_hidden').val(data2.val_paa);
						$('#tipopagella2_hidden').val(data2.val2_paa);
					},
					error: function(){
						alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
					}
				});
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});



		
		//console.log ("12EmissioneDocumenti.php - Popola_tipopagella");

	}

	function PopolaVerbali() {
		let annoscolastico_ver = $( "#selectannoscolastico option:selected" ).val();
		let classe_ver = $( "#selectclasse option:selected" ).val();
		let sezione_ver = $( "#selectsezione option:selected" ).val();
		postData = { annoscolastico_ver: annoscolastico_ver, classe_ver: classe_ver, sezione_ver: sezione_ver};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "12qry_getVerbali.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectVerbaliContainer").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");     
			}
		});
	}
	
	// INIZIO DEI DOWNLOAD VARII******************************************************************
	
	// GIORNALE DELLA CLASSE **********************************************************************
	function ShowModalGiornaledellaClasse(){
		$('#modalGiornaledellaClasse').modal('show');
	}
	function scaricaGiornaleClasseGET (){
		//Download File excel
		//serve classe, sezione e data
		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		let classe_ora = $( "#selectclasse option:selected" ).val();
		let datalunedi = $( "#hidden_datalunedi" ).val();
		let settimane = $( "#settimane").val();
		let paginauno = $( "#paginauno").val();
		window.location.href='12downloadGiornaleClasseExcel.php?classe_ora='+classe_ora+'&annoscolastico='+annoscolastico+'&sezione_ora=A&datalunedi='+datalunedi+'&settimane='+settimane+'&paginauno='+paginauno;
		
	}
	
	function scaricaGiornaleClassePOST (){
		//Download pdf
		//serve classe, sezione e data
		let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		let classe_ora = $( "#selectclasse option:selected" ).val();
		let sezione_ora = $( "#selectsezione option:selected" ).val();
		let datalunedi = $( "#hidden_datalunedi" ).val();
		let settimane = $( "#settimane").val();
		let paginauno = $( "#paginauno").val();

		console.log (annoscolastico, classe_ora, sezione_ora, datalunedi, settimane, paginauno);
		url = "12downloadGiornaleClasse.php";
		
		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');
		
		let input_classe_ora = $("<input>")
		.attr("type", "text")
		.attr("name", "classe_ora")
		.val(classe_ora);
		$(form).append($(input_classe_ora));
		
		let input_annoscolastico = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico")
		.val(annoscolastico);
		$(form).append($(input_annoscolastico));
		
		let input_datalunedi = $("<input>")
		.attr("type", "text")
		.attr("name", "datalunedi")
		.val(datalunedi);
		$(form).append($(input_datalunedi));
		
		let input_settimane = $("<input>")
		.attr("type", "text")
		.attr("name", "settimane")
		.val(settimane);
		$(form).append($(input_settimane));
		
		let input_paginauno = $("<input>")
		.attr("type", "text")
		.attr("name", "paginauno")
		.val(paginauno);
		$(form).append($(input_paginauno));
	
		let input_sezione_ora = $("<input>")
		.attr("type", "text")
		.attr("name", "sezione_ora")
		.val(sezione_ora);
		$(form).append($(input_sezione_ora));
		
		form.appendTo( document.body );
		
		$(form).submit();
	}
	// FINE GIORNALE DELLA CLASSE *****************************************************************

	
	// GIORNALE DELL'INSEGNANTE *******************************************************************
	function scaricaVotazioni (){
		//serve classe, sezione e data
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let ID_mae = $('#hidden_ID_mae').val();
		let strLink = '12downloadCompitieVerificheExcel.php?classe_cla='+classe_cla+'&sezione_cla='+sezione_cla+'&annoscolastico_cla='+annoscolastico_cla+'&ID_mae='+ID_mae;
		console.log(strLink);
		window.location.href=strLink;
	}
	
	function scaricaVotazioniPOST (){
		//serve classe, sezione e data
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let ID_mae = $('#hidden_ID_mae').val();

		let url = "12downloadCompitieVerifiche.php";
		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');
		
		let input_classe_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "classe_cla")
		.val(classe_cla);
		$(form).append($(input_classe_cla));
		
		let input_sezione_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "sezione_cla")
		.val(sezione_cla);
		$(form).append($(input_sezione_cla));
		
		let input_annoscolastico_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico_cla")
		.val(annoscolastico_cla);
		$(form).append($(input_annoscolastico_cla));
		
		let input_ID_mae = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_mae")
		.val(ID_mae);
		$(form).append($(input_ID_mae));
		
		form.appendTo( document.body );
		$(form).submit();
	}
	// FINE GIORNALE DELL'INSEGNANTE **************************************************************
	
	// VERBALI*************************************************************************************
	// function scaricaVerbale (){
	// 	//serve numero verbale, classe, sezione e data e anno scolastico
	// 	let num_ver = $( "#selectverbale option:selected" ).val();
	// 	let classe_cla = $( "#selectclasse option:selected" ).val();
	// 	let sezione_cla = $( "#selectsezione option:selected" ).val();
	// 	let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
	// 	let strLink = '12downloadVerbaleExcel.php?num_ver='+num_ver+'&classe_cla='+classe_cla+'&sezione_cla='+sezione_cla+'&annoscolastico_cla='+annoscolastico_cla;
	// 	window.location.href=strLink;
	// 	//console.log(strLink);
	// }
	
	function ShowModalVerbalidellaClasse(){
		$('#modalVerbali').modal('show');
	}
	
	function scaricaVerbalePOST (){
		//serve numero verbale, classe, sezione e anno scolastico
		let num_ver = $( "#selectverbale option:selected" ).val();

		let url = "12downloadVerbale.php";
		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');
		
		let input_num_ver = $("<input>")
		.attr("type", "text")
		.attr("name", "num_ver")
		.val(num_ver);
		$(form).append($(input_num_ver));
		
		form.appendTo( document.body );
		$(form).submit();
	}
	
	// FINE VERBALI********************************************************************************

	

	//SINOTTICO ASSENZE (EXCEL) *******************************************************************
	
	function ShowModalElencoAssenze(){
		$('#modalElencoAssenzePerMese').modal('show');
	}
	
	function scaricaAssenze (){
		//serve classe, sezione mese e anno scolastico
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let mese = $( "#selectmese option:selected" ).val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let strLink = '12downloadElencoAssenze.php?classe_cla='+classe_cla+'&sezione_cla='+sezione_cla+'&mese='+mese+'&annoscolastico_cla='+annoscolastico_cla;
		window.location.href=strLink;
		//console.log(strLink);
	}
	//FINE SINOTTICO ASSENZE **********************************************************************
	
	//CALCOLO ASSENZE (EXCEL) *********************************************************************
	
	function ShowModalCalcoloAssenze(){
		$('#modalCalcoloAssenze').modal('show');
	}
	
	function scaricaCalcoloAssenze (){
		//serve classe, sezione mese e anno scolastico
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let date_from = $( "#date_from" ).val();
		let date_to = $( "#date_to" ).val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let strLink = '12downloadCalcoloAssenze.php?classe_cla='+classe_cla+'&sezione_cla='+sezione_cla+'&date_from='+date_from+'&date_to='+date_to+'&annoscolastico_cla='+annoscolastico_cla;
		window.location.href=strLink;
		//console.log(strLink);
	}
	//CALCOLO ASSENZE *****************************************************************************
	
	//VOTAZIONI PER ALUNNO (EXCEL) *******************************************************************
	
	function scaricaVotazioniExcel (){
		//serve classe, sezione mese e anno scolastico
		let classe_cov = $( "#selectclasse option:selected" ).val();
		let sezione_cov = $( "#selectsezione option:selected" ).val();
		let annoscolastico_cov = $( "#selectannoscolastico option:selected" ).val();
		let strLink = '12downloadVotazioniExcel.php?classe_cov='+classe_cov+'&sezione_cov='+sezione_cov+'&annoscolastico_cov='+annoscolastico_cov;
		window.location.href=strLink;
		//console.log(strLink);
	}
	//FINE SINOTTICO ASSENZE ********************************************************************


	//SINOTTICO PAGELLE (EXCEL)********************************************************************
	function scaricaSinotticoPagelle (){
		//serve classe, sezione e anno scolastico
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let strLink = '12downloadSinotticoPagelle.php?classe_cla='+classe_cla+'&sezione_cla='+sezione_cla+'&annoscolastico_cla='+annoscolastico_cla;
		window.location.href=strLink;
		//console.log(strLink);
	}
	//FINE SINOTTICO PAGELLE **********************************************************************
	
	
		
	// // PAGELLA SINGOLA, DOC ORIENTATIVO, CERT COMPETENZE ******************************************
	// function scaricaPagellaGET (quadrimestre, pag_doc_cer){
	// 	//Download file excel
	// 	let aselme_IDalu = $( "#selectalunno option:selected" ).val();
	// 	//Il valore di selectalunno è fatto da DUE CARATTERI ASELME_CLA + 1 CARATTERI 1/0 a seconda che la classe sia V/VIII oppure no e poi ID_alu.
	// 	let aselme_cla = aselme_IDalu.substr (0,2);
	// 	//console.log (aselme_cla);
	// 	let ID_alu_det = aselme_IDalu.slice(3); //taglia via i primi tre caratteri, ciò che resta è ID_alu
	// 	let CerComOK = aselme_IDalu.substr (2,1);
	// 	//console.log (CerComOK);
	// 	//console.log (pag_doc_cer);
	// 	if ((pag_doc_cer =="CerCom") && (CerComOK == 0)) {
	// 		alert ("L'alunno non frequenta nè la classe V nè la classe VIII");
	// 	}else {
	// 		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
	// 		window.location.href='02downloadPagellaExcel.php?ID_alu_cla='+ID_alu_det+'&annoscolastico_cla='+annoscolastico_cla+'&aselme_cla='+aselme_cla+'&quadrimestre='+quadrimestre+'&datapagella=1900-01-01&pag_doc_cer='+pag_doc_cer;//console.log('02downloadPagella.php?ID_alu_cla='+ID_alu_det+'&annoscolastico_cla='+annoscolastico_cla+'&aselme_cla='+aselme_cla+'&quadrimestre='+quadrimestre+'&datapagella=0000-00-00&pag_doc_cer='+pag_doc_cer);
	// 	}
	// }



// PAGELLE BATCH*******************************************************************************
	function scaricaPagellePOST (quadrimestre, Doc){
		console.log("12EmissioneDocumenti.php - scaricaPagellePOST");



		//ERA: let aselme_cla = $( "#aselme_cla_hidden" ).val();
		//ma non funzionava: pesco allora i primi due caratteri del valore della SELECT
		let aselme_IDalu = $( "#selectalunno option:selected" ).val();
		let aselme_cla = aselme_IDalu.substr (0,2); //estrae i primi due caratteri

		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let tipopagella = $( "#tipopagella_hidden").val();
		let tipopagella2 = $( "#tipopagella2_hidden").val();

		if (Doc =="PagUff") { Doc = tipopagella;}
		if (Doc =="DocInt") { Doc = tipopagella2;}

		if (Doc == 0) {
			$('#titolo01Msg_OK').html('DOWNLOAD DOCUMENTI');
			$('#msg01Msg_OK').html("Il Documento Interno di valutazione è disponibile<br>solo per le 'vecchie' pagelle");
			$('#modal01Msg_OK').modal('show');
			return;
		}
		

		url = "12downloadPDF.php";

		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');
		
		let input_classe_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "classe_cla")
		.val(classe_cla);
		$(form).append($(input_classe_cla));
		
		let input_sezione_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "sezione_cla")
		.val(sezione_cla);
		$(form).append($(input_sezione_cla));
		
		let input_annoscolastico_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico_cla")
		.val(annoscolastico_cla);
		$(form).append($(input_annoscolastico_cla));
		
		let input_aselme_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "aselme_cla")
		.val(aselme_cla);
		$(form).append($(input_aselme_cla));

		let input_quadrimestre = $("<input>")
		.attr("type", "text")
		.attr("name", "quadrimestre")
		.val(quadrimestre);
		$(form).append($(input_quadrimestre));

		let input_datapagella = $("<input>")
		.attr("type", "text")
		.attr("name", "datapagella")
		.val('1900-01-01');
		$(form).append($(input_datapagella));
		
		let input_Doc = $("<input>")
		.attr("type", "text")
		.attr("name", "Doc")
		.val(Doc);
		$(form).append($(input_Doc));

		form.appendTo( document.body );
		
		$(form).submit();

	
	}
	// FINE PAGELLE BATCH *************************************************************************


	function scaricaPagellaPOST (quadrimestre, Doc) {

		//Mentre scaricaPagelle gestisce solo PagUff e DocInt scaricaPagella deve contemplare anche CerCom e ConOri
		//Nel caso di download di una singola pagella faccio delle verifiche preliminari
		//non contemplate nel caso di downloadPagellE

		//anzitutto verifico se è stata richiesta una certificazione competenze per un alunno non di V o di VIII
		//Il valore di selectalunno è fatto da DUE CARATTERI ASELME_CLA + 1 CARATTERI 1/0 a seconda che la classe sia V/VIII oppure no e poi ID_alu.
		let aselme_IDalu = $( "#selectalunno option:selected" ).val();
		let aselme_cla = aselme_IDalu.substr (0,2); //estrae i primi due caratteri
		let ID_alu_cla = aselme_IDalu.slice(3);
		let CerComOK = aselme_IDalu.substr (2,1);
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let classe_cla = $( "#selectclasse option:selected" ).val();
		let sezione_cla = $( "#selectsezione option:selected" ).val();
		let tipopagella = $( "#tipopagella_hidden").val();
		let tipopagella2 = $( "#tipopagella2_hidden").val();

		if (Doc =="PagUff") { Doc = tipopagella;}
		if (Doc =="DocInt") { Doc = tipopagella2;}

		if ((Doc =="CerCom")&& (CerComOK == 0)) {
			$('#titolo01Msg_OK').html('DOWNLOAD DOCUMENTI');
			$('#msg01Msg_OK').html("L'alunno non frequenta nè la classe V nè la classe VIII");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		exit = false;
		if ((Doc =="ConOri")&& (classe_cla != 'VIII')) {
			$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
			$('#msg01Msg_OK').html("L'alunno non frequenta la classe VIII");
			$('#modal01Msg_OK').modal('show');
			exit = true;
		}

		//VERIFICARE SE IL CHECK FUNZIONA
		if ((Doc =="ConOri")&& (classe_cla == 'VIII')) {				
			//verifico se ci sono tutti i dati necessari
			postData = { annoscolastico: annoscolastico_cla, ID_alu: ID_alu_cla, ottava: 1 };
			$.ajax({
				async: false,
				type: 'POST',
				url: "12qry_checkConsOrientativo.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					if (data.stopgo == "STOP") {
						$('#titolo01Msg_OK').html('CONSIGLIO ORIENTATIVO');
						$('#msg01Msg_OK').html(data.result_alert);
						$('#modal01Msg_OK').modal('show');
						exit =  true;
						
					}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");     
				}
			});
		}

		if (exit == true) { return;}
		//VERIFICARE SE ConOri scarica correttamente...si deve usare sempre 12downloadpagelle




		if (Doc == 0) {
			$('#titolo01Msg_OK').html('DOWNLOAD DOCUMENTI');
			$('#msg01Msg_OK').html("Il Documento Interno di valutazione è disponibile<br>solo per le 'vecchie' pagelle");
			$('#modal01Msg_OK').modal('show');
			return;
		}

		//verifico se il documento in questione è stato compilato a dovere per dare un warning quando non lo è
		procedi = 'OK';
		postData = { ID_alu : ID_alu_cla, annoscolastico_cla: annoscolastico_cla, quadrimestre: quadrimestre, Doc: Doc};
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "12qry_checkDocumentiCompilati.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				// console.log ("CkPagUff1="+data.CkPagUff1);
				// console.log ("CkPagUff2="+data.CkPagUff2);
				// console.log ("CkDocInt1="+data.CkDocInt1);
				// console.log ("CkDocInt2="+data.CkDocInt2);
				// console.log ("CkCerCom="+data.CkCerCom);
				// console.log (data.Ck);
				if (data.Ck == 'NO') {
					if (! confirm('Sembra che il documento richiesto non sia ancora completo procedere comunque?')) {
						procedi = 'NO';
					}
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");     
			}
		});
		if (procedi != 'OK') {return;}

		//in più rispetto a downloadPagellE c'è anche la possibilità di scaricare 
		//la Certificazione delle Competenze e del Consiglio orientativo
		//PagUff, DocInt e CerCom funzionano resta da vedere se ConOri funziona
		url ="12downloadPDF.php";

		let form = $('<form target="_blank" action="' + url + '"method="post"></form>');

		//rispetto al downloadPagelle downloadPagella posta anche l'ID_alu_cla
		let input_ID_alu_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_alu_cla")
		.val(ID_alu_cla);
		$(form).append($(input_ID_alu_cla));

		let input_classe_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "classe_cla")
		.val(classe_cla);
		$(form).append($(input_classe_cla));

		let input_sezione_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "sezione_cla")
		.val(sezione_cla);
		$(form).append($(input_sezione_cla));

		let input_annoscolastico_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "annoscolastico_cla")
		.val(annoscolastico_cla);
		$(form).append($(input_annoscolastico_cla));

		let input_aselme_cla = $("<input>")
		.attr("type", "text")
		.attr("name", "aselme_cla")
		.val(aselme_cla);
		$(form).append($(input_aselme_cla));

		let input_quadrimestre = $("<input>")
		.attr("type", "text")
		.attr("name", "quadrimestre")
		.val(quadrimestre);
		$(form).append($(input_quadrimestre));

		let input_datapagella = $("<input>")
		.attr("type", "text")
		.attr("name", "datapagella")
		.val('1900-01-01');
		$(form).append($(input_datapagella));

		let input_Doc = $("<input>")
		.attr("type", "text")
		.attr("name", "Doc")
		.val(Doc);
		$(form).append($(input_Doc));

		form.appendTo( document.body );

		$(form).submit();
		$(form).remove();


	}
	// FINE PAGELLA SINGOLA, DOC ORIENTATIVO, CERT COMPETENZE *************************************
	
	//CONSIGLIO ORIENTATIVO ***********************************************************************
	// function scaricaConsOrientativo (){
	// 	//Download Excel
	// 	let aselme_IDalu = $( "#selectalunno option:selected" ).val();
	// 	//Il valore di selectalunno è fatto da DUE CARATTERI ASELME_CLA + 1 CARATTERI 1/0 a seconda che la classe sia V/VIII oppure no e poi ID_alu.
	// 	let ID_alu = aselme_IDalu.slice(3); // indica ID_alu
	// 	let ottava = aselme_IDalu.substr (2,1); //è 1 o 0 a seconda che sia V/VIII oppure no
	// 	//serve classe, sezione e data
	// 	let annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		
	// 	//verifico se ci sono tutti i dati necessari
	// 	postData = { annoscolastico: annoscolastico, ID_alu: ID_alu, ottava: ottava };
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: "12qry_checkConsOrientativo.php",
	// 		data: postData,
	// 		dataType: 'json',
	// 		success: function(data){
	// 			if (data.stopgo == "STOP") {
	// 				alert (data.result_alert);
	// 			} else {
	// 				window.location.href='12downloadConsOrientativo.php?ID_alu_cor='+ID_alu+'&annoscolastico_cor='+annoscolastico+'&sezione=A';
	// 			}
	// 		}
	// 	});
	// }

	function scaricaConsOrientativoPOST (){
		//funzione soppiantata da scaricaPagellaPOST
		//Download pdf
		let aselme_IDalu = $( "#selectalunno option:selected" ).val();
		let sezione_cor = $( "#selectsezione option:selected" ).val();
		let ID_alu = aselme_IDalu.slice(3); // indica ID_alu
		let ottava = aselme_IDalu.substr (2,1); //è 1 o 0 a seconda che sia VIII oppure no
		let annoscolastico_cor = $( "#selectannoscolastico option:selected" ).val();
		
		//verifico se ci sono tutti i dati necessari
		postData = {
			annoscolastico: annoscolastico_cor,
			ID_alu: ID_alu,
			ottava: ottava
		};
		$.ajax({
			type: 'POST',
			url: "12qry_checkConsOrientativo.php",
			data: postData,
			dataType: 'json',
			success: function (data) {
				if (data.stopgo == "STOP") {
					$('#msg01Msg_OK').html(data.result_alert);
					$('#modal01Msg_OK').modal({show: 'true'});
				} else {
					let url = "12downloadConsOrientativo.php";
					let form = $('<form action="' + url + '"method="post"></form>');
	
					let input_ID_alu_cor = $("<input>")
					.attr("type", "text")
					.attr("name", "ID_alu_cor")
					.val(ID_alu);
					$(form).append($(input_ID_alu_cor));
					
					let input_sezione_cor = $("<input>")
					.attr("type", "text")
					.attr("name", "sezione_cor")
					.val(sezione_cor);
					$(form).append($(input_sezione_cor));
					
					let input_annoscolastico_cor = $("<input>")
					.attr("type", "text")
					.attr("name", "annoscolastico_cor")
					.val(annoscolastico_cor);
					$(form).append($(input_annoscolastico_cor));
					
					form.appendTo( document.body );
					$(form).submit();
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});
	}
	//FINE CONSIGLIO ORIENTATIVO*******************************************************************
	
	
	function copyToHiddenAndSetSession () {
		let ID_mae = $('#selectmaestro').val();
		$('#hidden_ID_mae').val(ID_mae);
		postData = { ID_mae : ID_mae };
		$.ajax({
			type: 'POST',
			url: "11qry_SetSessionID_mae.php",
			data: postData,
			dataType: 'json',
			success: function(){
				//console.log (data.test);
				//requerySelectAlunno();
				//changedAnnoscolastico();
				//requery();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '12EmissioneDocumenti ##fname##'");      
			}
		});
		
	}
</script>
