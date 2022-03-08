<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Formazione Maestri</title>
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
	
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="assets/bootstrap-select/bootstrap-select.css">
	<script src="assets/bootstrap-select/bootstrap-select.js"></script>
	<? $_SESSION['page'] = "Formazione Maestri";?>
</head>

<body>
<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">
			<div class="titoloPagina">
				Formazione del Personale in organico
			</div>
			<div class="ml50">
				<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>
			</div>
			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
						<option value="DownloadExcelFormazioneMaestri">Anagrafiche Maestri</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>
			
			<div style="text-align: center;">
				<table id="tabellaAnagraficaMaestri" style="margin-left: 55px; margin-top: 30px; display:inline-block; ">
					<thead>
						<tr>
							<th style="width:22px;">
								<img title="Aggiungi nuova Formazione Personale" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddFormazioneMaestro();">
							</th>
							<th style="width:40px;">
							</th>
							<th>
								<input class="tablelabel2 w100px" type="text" value="NOME" disabled>
							</th>
							<th>
								<input class="tablelabel2 w100px"  type="text" value="COGNOME" disabled>
							</th>
							<th>
								<input class="tablelabel2"  style="width: 180px;" type="text" value="Categoria" disabled>
							</th>
							<th>
								<input class="tablelabel2"  style="width: 70px;" type="text" value="FOR/AGG" disabled>
							</th>
							<th>
								<input class="tablelabel2"  style="width: 390px;" type="text" value="TITOLO" disabled>
							</th>
							<th>
								<input class="tablelabel2"  style="width: 115px;" type="text" value = "Conseguito il" disabled>
							</th>
							<th>
								<input class="tablelabel2"  style="width: 115px;" type="text" value = "Scade il" disabled>
							</th>
						<tr>
							<th style="width:22px;">
							</th>
							<th style="width:25px;">
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" >--</button>
								<input class="tablecell3 filtercell" style="width:70px" type="text"   onchange="requery();" id="filter1" name="filter1"
							</th>
							<th>
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" >--</button>
								<input class="tablecell3 filtercell" style="width:70px" type="text"   onchange="requery();" id="filter2" name="filter2"
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" >--</button>
								<input class="tablecell3 filtercell" style="width:150px" type="text"   onchange="requery();" id="filter3" name="filter3"
							</th>
							<th>
								
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" >--</button>
								<input class="tablecell3 filtercell" style="width:360px" type="text"   onchange="requery();" id="filter4" name="filter4"
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" >--</button>
								<input class="tablecell3 filtercell" style="width:85px" type="text"   onchange="requery();" id="filter5" name="filter5"
							</th>
							<th>
								<button id="ordinacampo6" class="ordinabutton" onclick="ordina(6);" >--</button>
								<input class="tablecell3 filtercell" style="width:85px" type="text"   onchange="requery();" id="filter6" name="filter6"
							</th>
							
					</thead>
					<tbody class="scroll" id="maintable">
					</tbody>
				</table>
			</div>
		</div>
	</div>	

<!--*************************************************FORM MODALE AGGIUNTA RECORD IN tab_titolimaestri********************************************* -->
	<div class="modal" id="modalAddFormazioneMaestro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_formazione" method="post">		
						<span class="h4" id="titolo" style="width:50%; ">Inserimento di un nuovo</span>
						<span class="h4" id="titolo" style="width:50%;">corso di Formazione</span></br>
						<span class="h4" id="titolo" style="width:50%;">per il maestro/i maestri</span></br></br>
							
							<div style="text-align: center; margin-top: 50px; width: 250px; margin: auto">
								<select id="selectInsegnanti" style="height: 80px;" class="selectpicker multiselect-ui form-control" multiple="multiple" data-selected-text-format="count" multiple data-actions-box="true">
									<? $sql = "SELECT id_mae, nome_mae, cognome_mae FROM tab_anagraficamaestri ORDER BY cognome_mae";
									$stmt = mysqli_prepare($mysqli, $sql);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_bind_result($stmt, $id_mae, $nome_mae, $cognome_mae);
									while (mysqli_stmt_fetch($stmt)) {
									?> <option value="<?=$id_mae?>" <?//if (in_array($id_mae, $iddocenti_verA )) {echo ('selected');}?>><?=$cognome_mae." ".$nome_mae;?></option><?
									}?>
								</select>
							</div>
						<div id="remove-content-tag" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row" style="margin-bottom:20px;">
								<select name="selectcat_tit"  style="margin-left: 0px"  id="selectcat_tit" onchange="ShowHideSelect2()">
										<option value="Diploma">Diploma</option>
										<option value="Laurea">Laurea</option>
										<option value="Seminario Waldorf">Seminario Waldorf</option>
										<option value="Aggiornamenti Waldorf">Aggiornamenti Waldorf</option>
										<option value="Altra Formazione Pedagogica">Altra Formazione Pedagogica</option>
										<option value="Privacy">Privacy</option>
										<option value="Sicurezza">Sicurezza</option>
										<option value="Altro">Altro</option>
								</select>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<select name="selectcatsic_tit"  style="margin-left: 0px;"  id="selectcatsic_tit" onchange="FillHours(); CalcolaScadenza();">
										<option value="Lavoratori Rischio Medio">Lavoratori Rischio Medio</option>
										<option value="Addetti Squadra Antincendio">Addetti Squadra Antincendio</option>
										<option value="Addetti Primo Soccorso">Addetti Primo Soccorso</option>
										<option value="Rappresentante Lavoratori Sicurezza">Rappresentante Lavoratori Sicurezza</option>
								</select>
							</div>
							<div class="col-md-12" id="optionsformazioneaggiornamento" style="padding-bottom: 2px;">
								<div class="col-md-4 col-sm-6 col-xs-6 col-md-offset-2" style="z-index: 100; text-align: center;">
									<input type="radio" class="ckformagg_tit" name="ckformagg_tit" value="F" checked>&nbsp;Formazione
								</div>
								<div class="col-md-4 col-sm-6 col-xs-6" style="z-index: 100; text-align: center;">
									<input type="radio" class="ckformagg_tit" name="ckformagg_tit" value="A">&nbsp;Aggiornamento
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-3">
								</div>
								<div class="col-md-6" id="titoloText">
									Titolo
									<br>
									<input class="tablecell5" type="text"  id="nome_tit_modal" name="nome_tit_modal">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-3">
								</div>
								<div class="col-md-6">
									Descrizione Titolo
									<br>
									<textarea style="height: 72px;" class="tablecell5" type="text"  id="desc_tit_modal" name="desc_tit_modal"></textarea>
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data di conseguimento
									<br>
									<input style="text-align: center; width: 50%" class="tablecell3 datepicker" type="text"  id="data_tit_modal" name="data_tit_modal" onchange="CalcolaScadenza();">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-4">
								</div>
								<div class="col-md-4">
									Data di Scadenza
									<br>
									<input style="text-align: center; width: 50%" class="tablecell3 datepicker" type="text"  id="scad_tit_modal" name="scad_tit_modal">

								</div>
							</div>
							<br>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiFO" style="display:none; margin-top:10px;">
							<h4 style="text-align:center;"></i> Inserimento Corso completato con successo!</h4>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn_cancel" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiFormazioni();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<!--************************************************* FINE FORM MODALE AGGIUNTA RECORD IN tab_titolimaestri*************************** -->



</body>
</html>
<script>

	$(document).ready(function(){
		moment.locale('en', {
          week: { dow: 1 }
        });
		$('.datepicker').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});

		$('#selectInsegnanti').selectpicker();

		resetResolution();
		requery();
		ShowHideSelect2();
	});
	
	function resetResolution () {
		let offset = $("#tabellaAnagraficaMaestri > tbody").offset();
		$('#tabellaAnagraficaMaestri > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	/*$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		let inputVal = $(this).val();
		if (campo == "comunenascita_mae_new"){
			resultDropdown = $("#showComuneNascita_new");
		} else if (campo == "citta_mae_new"){
			resultDropdown = $("#showComuneResidenza_new");
		}
		if(inputVal.length>2){
				$.get("06qry_DropDownComune.php", {inputVal: inputVal}).done(function(data){
				resultDropdown.html(data);
				});
		} else {
			resultDropdown.empty();
		}
	});*/
	
	/*$(document).on("click", ".showcomune p", function(){
		campo = $(this).parent().attr("name");
		selected = $(this).text();
		ID_cap = selected.substr(0,selected.indexOf("+"));
		comuneselected = $("#comuneselected"+ID_cap).val();
		provselected = $("#provselected"+ID_cap).val();
		paeseselected = "Italia";
		CAPselected = $("#CAPselected"+ID_cap).val();
		switch (campo) {
			case "showComuneNascita_new":
				$("#comunenascita_mae_new").val(comuneselected);
				$("#provnascita_mae_new").val(provselected);
				$("#paesenascita_mae_new").val(paeseselected);
			break;
			case "showComuneResidenza_new":
				$("#citta_mae_new").val(comuneselected);
				$("#prov_mae_new").val(provselected);
				$("#paese_mae_new").val(paeseselected);
				$("#CAP_mae_new").val(CAPselected);
			break;
		}
			$(this).parent().empty();
	});*/

	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}

	function requery(){
		let campo1 = "nome_mae";
		let campo2 = "cognome_mae";
		let campo3 = "cat_tit";
		let campo4 = "nome_tit";
		let campo5 = "data_tit";
		let campo6 = "scad_tit";
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();
		let ord5 = $('#ordinacampo5').text();
		let ord6 = $('#ordinacampo6').text();
		let fil1 = $('#filter1').val();
		let fil2 = $('#filter2').val();
		let fil3 = $('#filter3').val();
		let fil4 = $('#filter4').val();
		let fil5 = $('#filter5').val();
		let fil6 = $('#filter6').val();
		postData = {campo1 : campo1, campo2: campo2, campo3: campo3, campo4: campo4, campo5: campo5, campo6: campo6, ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, ord6: ord6, fil1: fil1, fil2: fil2, fil3: fil3, fil4: fil4, fil5: fil5, fil6: fil6};
		$.ajax({
			type: 'POST',
			url: "16qry_FormazioneMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
			},
			error: function(){
			alert("Errore: contattare l'amministratore fornendo il codice di errore '16FormazioneMaestri ##fname##'");     
			}
		});
	}
	
	function showModalAddFormazioneMaestro() {
		
		//$("#remove-content").show();
		//$("#alertaggiungi").hide();
		//$("#btn_cancel").html('Annulla');
		//$("#btn_cancel").addClass('pull-left');
		//$("#btn_OK").show();
		document.getElementById("form_formazione").reset();
		//$("#selectInsegnanti > option").attr("selected",false);
		//$('#ddlTradeShow').multiselect("clearSelection");
		//$("#selectInsegnanti > option").removeProp("selected");
		//$("#selectInsegnanti").val([]);
		$('#selectInsegnanti').selectpicker('deselectAll');
		$('#selectInsegnanti').selectpicker('refresh');
		ShowHideSelect2();
		$('#modalAddFormazioneMaestro').modal({show: 'true'});
	}
	
	
	function aggiungiFormazioni() {

		$('#selectInsegnanti option:selected').each(function(){
			aggiungiFormazione($(this).val());
			//console.log($(this).val());
		 });
		
	}
	
	function aggiungiFormazione(ID_mae_tit) {
		let ckformagg_tit = $(".ckformagg_tit:checked").val();
		let cat_tit = $('#selectcat_tit').val();
		let nome_tit = "";
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			nome_tit =  $('#selectcatsic_tit').val();
		} else {
			nome_tit =  $("#nome_tit_modal").val();
		}
		let desc_tit =  $("#desc_tit_modal").val();
		let data_tit =  $("#data_tit_modal").val();
		let scad_tit =  $("#scad_tit_modal").val();
		postData = { ID_mae_tit: ID_mae_tit, cat_tit: cat_tit, nome_tit: nome_tit, desc_tit: desc_tit, data_tit: data_tit, scad_tit: scad_tit, ckformagg_tit: ckformagg_tit};
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "16qry_insertFormazione.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				document.getElementById('alertaggiungiFO').innerHTML = data.msg;
				$("#modalAggiungiFormazione .alert").show();
				//console.log (data.sql2);
				$('#modalAddFormazioneMaestro').modal('hide');
				requery();
				//$("#pagtoshow_hidden").val("last");
			},
			error: function(){
			alert("Errore: contattare l'amministratore fornendo il codice di errore '16FormazioneMaestri ##fname##'");     
			}
		});

	}

	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}
	
	function DownloadExcelFormazioneMaestri() {
		window.location.href='16downloadFormazioneMaestri.php';
	}
	
	
	function ShowHideSelect2 () {
		
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			$('#selectcatsic_tit').css("visibility","visible");
			$('#titoloText').css("visibility","hidden");
		} else {
			$('#selectcatsic_tit').css("visibility","hidden");
			$('#titoloText').css("visibility","visible");
		}
		FillHours();
		CalcolaScadenza();
	}
	
	function FillHours() {
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			var OreSic = {LavoratoriRischioMedio:"6 Ore", AddettiSquadraAntincendio:"5 Ore", AddettiPrimoSoccorso: "5 Ore", RappresentanteLavoratoriSicurezza: "4 Ore" };
			Corso = $('#selectcatsic_tit').val();
			//console.log (Corso);
			CorsoIndex = Corso.replace(/\s+/g, '');
			//console.log (OreSic[CorsoIndex]);
			//console.log (Scadenze[CorsoIndex]);
			$("#desc_tit_modal").html(OreSic[CorsoIndex]);			
		} else {
			$("#desc_tit_modal").html("");
		}
	}
	
	function CalcolaScadenza() {
		if ($('#selectcat_tit').val() ==  'Sicurezza') {
			var Scadenze = {LavoratoriRischioMedio:5, AddettiSquadraAntincendio:3, AddettiPrimoSoccorso: 3, RappresentanteLavoratoriSicurezza: 1 };
			Corso = $('#selectcatsic_tit').val();
			console.log(Corso);
			CorsoIndex = Corso.replace(/\s+/g, '');
			console.log(CorsoIndex);
			console.log (Scadenze[CorsoIndex]);
			datacons = $("#data_tit_modal").val();
			console.log (datacons);
			if (datacons != "") {
				annocons = datacons.substring(6,10);
				console.log (annocons);
				annoscad = parseInt(annocons) + parseInt(Scadenze[CorsoIndex]);
				console.log(annoscad);
				datascad = datacons.substring(0,6)+annoscad;
				console.log (datascad);
				$("#scad_tit_modal").val(datascad);
			}
		} else {
			$("#scad_tit_modal").val("");
		}
	}
	

	function showModalDeleteThisRecord(ID_tit, nome_mae, cognome_mae) {
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare questo titolo per  "+nome_mae+" "+cognome_mae+" ? <br><br> digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_tit+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_tit) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {	
			postData = { ID_tit: ID_tit};
			$.ajax({
				type: 'POST',
				url: "16qry_deleteFormazioneMaestro.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Titolo eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '16FormazioneMaestri ##fname##'");     
				}
			});
		}
	}
	
	/*function controllaDataNascita (data, annomin, annomax) {
		if ((data != "") && (data != null)) {
			let datam = moment(data, "DD-MM-YYYY" );
			let annom = moment(datam).year();
			console.log (data);
			if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
		} else {
			return true;
		}
	}*/

	/*function aggiungiAnagraficaMaestro() {
		let nome_mae_new =  $("#nome_mae_new").val();
		let cognome_mae_new =  $("#cognome_mae_new").val();
		let login_usr_new =  $("#selectlogin").val();
		if (nome_mae_new=='' || cognome_mae_new=='' ||login_usr_new =='0') {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Almeno nome, cognome e username sono necessari');
				$("#alertaggiungi").show();
		} else {
			datanascita = $('#datanascita_mae_new').val();
			if (controllaDataNascita(datanascita, 1940, 2000)){
			} else {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Controllare la data di nascita');
				$("#alertaggiungi").show();
				return;
			}
			let postData = $("#form_AddMaestro").serializeArray();
			//console.log (postData);
			$.ajax({
				type: 'POST',
				url: "03qry_insertAnagraficaMaestro.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					console.log(data.sql3);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html('Iscrizione di '+nome_mae_new+' '+cognome_mae_new+' completata con successo!');
					$("#alertaggiungi").show();
					$("#btn_cancel").html('Chiudi');
					$("#btn_cancel").removeClass('pull-left');
					$("#btn_OK").hide();
				}
			});
			requery();
		}
	}*/
	
	/*function mostradettaglio() {
		if ($('.upper').height() == $(window).height() ) {
			$('.upper').css('height', '40%');
			$('.lower').css('height', '60%');
            $('#mat_icon_det').removeClass('fa-angle-double-down');
            $('#mat_icon_det').addClass('fa-angle-double-up');
		} else  {
			$('.upper').css('height', '100%');
			$('.lower').css('height', '0%');
            $('#mat_icon_det').removeClass('fa-angle-double-up');
            $('#mat_icon_det').addClass('fa-angle-double-down');
		}
	}*/




</script>