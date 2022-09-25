<!--
	************************************************* DESCRIZIONE DEL FLUSSO **********************************************
	Il File 00Anagrafica.php crea l'header della tabella e inizia il tbody con un id (maintable)
	Su document.ready 00Anagrafica.php chiama 00qry_Anagrafica.php al quale passa tre array:

	campo[]		: con i nomi dei campi selezionati
	ord[]		: con gli ordinamenti selezionati
	fil[]		: con i valori dei campi inseriti nei filtri

	00qry_Anagrafica.php chiama la funzione GetAlunni alla quale a sua volta passa i tre array di cui sopra.
	La funzione GetAlunni è l'ultimo pezzo della catena: riceve i tre array, li "spezza" per ottenerne i valori con cui costruire la sql.
	La sql popola dinamicamente un array e la funzione GetArraAlunnoV restituisce i campi selezionati.
	Il popolamento dell'array avviene con una Classe AlunnoV apposita di cui si fa una istanza
	
	In 00qry_Anagrafica.php la funzione GetAlunni viene richiamata con un foreach ...as $alunno per cui a quel punto
	posso accedere ad ogni campo con $alunno->nome del campo.
	In questo modo in 00Anagrafica.php e 00qry_Anagrafica.php posso "astrarmi" dai campi della tabella reale.
	L'unico "layer" in cui viene scritta la sql è quello della Classe e della Funzione
	************************************************************************************************************************
-->
<?
	include_once("database/databaseii.php");
	include_once("classi/famiglie.php"); //serve per estrarre le famiglie nel modulo di inserimento di un nuovo alunno
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Anagrafica Alunni</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
	<script src="assets/functions/functionsJS.js"></script>
	<? $_SESSION['page'] = "Anagrafica Alunni";?>
</head>
<body>
	<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres" >
			<div class="titoloPagina" >
				Anagrafica Alunni
			</div>
			<div class="sottotitoloPagina"  >
				(Elenco di tutte le anagrafiche Alunni, anche non più frequentanti, o non iscritti)
			</div>
			<div class="ml50">
				<input id="cognome_alunno_padre_uguali" value="<?=$_SESSION['cognome_alunno_padre_uguali']?>" hidden>
				<input id="IDAnagraficaAppenaInseritaHidden" hidden>
				<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>
			</div>
			<div>
				<table id="tabellaAnagrafica" style="margin-top: 20px; margin-left: 50px;">
					<thead>
						<tr>
							<th class="w25px">
								<img title="Aggiungi nuovo Alunno" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddAnagraficaAlunno();">
							</th>
							<th style="width:37px;">
							</th>
							<th style="width:139px;">
								<input class="tablelabel2 w100" type="text" value = "NOME" disabled>
							</th>
							<th style="width:139px;">
								<input class="tablelabel2 w100" type="text" value = "COGNOME" disabled>
							</th>
							<th style="width:144px;">
								<select name="selectcampo3"  class="w100" id="selectcampo3" onchange="requery();">
									<?$sel =7; 	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo4"  class="w100" id="selectcampo4" onchange="requery();">
									<?$sel =8;	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo5"  class="w100" id="selectcampo5" onchange="requery();">
									<?$sel =2;	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo6"  class="w100" id="selectcampo6" onchange="requery();">
									<?$sel =3;	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo7" class="w100" id="selectcampo7" onchange="requery();">
									<?$sel =16;	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo8" class="w100" id="selectcampo8" onchange="requery();">
									<?$sel =17;	include("00comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo9" class="w100" id="selectcampo9" onchange="requery();">
									<?$sel =1;	include("00comboAnagrafica.php");?>
								</select>
							</th>
						</tr>
						<tr>
							<th>
							</th>
							<th class="center">
								
								<span id="conteggiorecord" ></span>
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" >--</button>
								<input class="tablecell3 filtercell" type="text"   onchange="requery();" id="filter1" name="filter1"
								<? if (isset ($_POST['nomealunnoDaAltraPag'])) {echo ("value = '".$_POST['nomealunnoDaAltraPag']."'");} ?> >
							</th>
							<th>
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" >--</button>
								<input class="tablecell3 filtercell" type="text"   onchange="requery();" id="filter2" name="filter2"
								<? if (isset ($_POST['cognomealunnoDaAltraPag'])) {echo ("value = '".$_POST['cognomealunnoDaAltraPag']."'");} ?> >
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter3" name="filter3">	
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter4" name="filter4">
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter5" name="filter5">
							</th>
							<th>
								<button id="ordinacampo6" class="ordinabutton" onclick="ordina(6);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter6" name="filter6">
							</th>
							<th>
								<button id="ordinacampo7" class="ordinabutton" onclick="ordina(7);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter7" name="filter7">
							</th>
							<th>
								<button id="ordinacampo8" class="ordinabutton" onclick="ordina(8);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter8" name="filter8">
							</th>
							<th>
								<button id="ordinacampo9" class="ordinabutton" onclick="ordina(9);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter9" name="filter9">
							</th>
						</tr>
					</thead>

					<tbody class="scroll" id="maintable">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
<!--***************************************FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO **************************************************-->
	<div class="modal" id="modalAddAnagraficaAlunno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 70%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddAlunno" method="post">
						<span class="titoloModal">Inserimento nuova Anagrafica Alunno/a</span>
						<br>
						<span class="testoModal">altri dati oltre a quelli qui richiesti vanno specificati nella scheda alunno, disponibile dopo l'inserimento</span>
						<div id="remove-content" class="mt20"> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									nome
								</div>
								<div class="col-md-3">
									cognome
								</div>
								<div class="col-md-1">
									M/F
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="nome_alu_new" maxlength="50" name="nome_alu_new" required>
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="cognome_alu_new" maxlength="50" name="cognome_alu_new" required>
								</div>
								<div class="col-md-1">
									<input class="tablecell5" type="text"  id="mf_alu_new" name="mf_alu_new" maxlength="1" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 mt5" style= "font-size: 16px;">
									Nato/a
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
									il
								</div>
								<div class="col-md-3">
									comune
								</div>
								<div class="col-md-1">
									prov
								</div>
								<div class="col-md-3">
									paese
								</div>
								<div class="col-md-2">
									<input type="submit" id= "submit-btn" class="btnBlu mb5" style=" width: 40%;" onclick="trovaCF('alunnonew', event);" value ="C.F." readonly>
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
									<input type="text" class="tablecell5 datepicker"  id="datanascita_alu_new" maxlength="10" name="datanascita_alu_new">
								</div>
								<div class="col-md-3">
									<input type="text" class="tablecell5 search-comune"  id="comunenascita_alu_new" maxlength="50" name="comunenascita_alu_new">
								</div>
								<div class="col-md-1">
									<input type="text" class="tablecell5" id="provnascita_alu_new" maxlength="4" name="provnascita_alu_new">
								</div>
								<div class="col-md-3">
									<input type="text" class="tablecell5" id="paesenascita_alu_new" maxlength="50" name="paesenascita_alu_new">
								</div>
								<div class="col-md-2">
									<input type="text" class="tablecell5" id="cf_alu_new" maxlength="16" name="cf_alu_new">
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneNascita_new" id="showComuneNascita_new" ></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 subtitleModal">
									Residenza
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									via
								</div>
								<div class="col-md-3">
									comune
								</div>
								<div class="col-md-1">
									prov
								</div>
								<div class="col-md-3">
									paese
								</div>
								<div class="col-md-2">
									CAP
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<input type="text"  class="tablecell5"  id="indirizzo_alu_new"  maxlength="50" name="indirizzo_alu_new">
								</div>
								<div class="col-md-3">
									<input type="text"  class="tablecell5 search-comune" id="citta_alu_new"  maxlength="50" name="citta_alu_new">
								</div>
								<div class="col-md-1">
									<input type="text" class="tablecell5"  id="prov_alu_new"  maxlength="4" name="prov_alu_new" >
								</div>
								<div class="col-md-3">
									<input type="text" class="tablecell5"  id="paese_alu_new"  maxlength="50" name="paese_alu_new">
								</div>
								<div class="col-md-2">
									<input type="text" class="tablecell5" id="CAP_alu_new"  maxlength="5" name="CAP_alu_new">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneResidenza_new" id="showComuneResidenza_new" ></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 mt20">
									<select id="selectFamiglia" name="selectFamiglia"  onchange="aggiornaDatiFamigliaModal();">
										<option value="none" selected>-NUOVA FAMIGLIA-</option>
										<?foreach (GetArrayCognomiFamiglie () as $Famiglia) {?>
											<option value="<?=$Famiglia->ID_fam?>" ><?=$Famiglia->cognomepadre_fam." - ".$Famiglia->cognomemadre_fam?>
										<?}?>
									</select>
								</div>
								<div class="col-md-12" style= "margin-top: 0px; font-size: 12px;">
										(Selezionare dalla casella a discesa se si tratta di un fratello/sorella di altro alunno già in anagrafica)
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 subtitleModal">
									Mamma
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
									nome
								</div>
								<div class="col-md-2">
									cognome
								</div>
								<div class="col-md-2">
									tel
								</div>
								<div class="col-md-3">
									email
								</div>
								<!-- <div class="col-md-1">
									Socio
								</div> -->
							</div>
							<div class="row">
								<div class="col-md-1">
									
								</div>
								<div class="col-md-2">
									<input type="text"  class="tablecell5"  id="nomemadre_fam_new"  maxlength="50" name="nomemadre_fam_new">
								</div>
								<div class="col-md-2">
									<input type="text"  class="tablecell5"  id="cognomemadre_fam_new"  maxlength="50" name="cognomemadre_fam_new">
								</div>
								<div class="col-md-2">
									<input type="text" class="tablecell5"  id="telefonomadre_fam_new"  maxlength="20" name="telefonomadre_fam_new">
								</div>
								<div class="col-md-3">
									<input type="text" class="tablecell5"  id="emailmadre_fam_new"  maxlength="80" name="emailmadre_fam_new">
								</div>
								<!-- <div class="col-md-1" style="text-align: right">
									<input type="checkbox" class="tablecell5" id="sociomadre_fam_new" name="sociomadre_fam_new">
								</div> -->
							</div>
							
							<div class="row">
								<div class="col-md-12 subtitleModal">
									Papà
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
									
								</div>
								<div class="col-md-2">
									nome
								</div>
								<div class="col-md-2">
									cognome
								</div>
								<div class="col-md-2">
									tel
								</div>
								<div class="col-md-3">
									email
								</div>
								<!-- <div class="col-md-1">
									Socio
								</div> -->
							</div>
							<div class="row">
								<div class="col-md-1">
									
								</div>
								<div class="col-md-2">
									<input type="text"  class="tablecell5"  id="nomepadre_fam_new"  maxlength="50" name="nomepadre_fam_new">
								</div>
								<div class="col-md-2">
									<input type="text"  class="tablecell5"  id="cognomepadre_fam_new"  maxlength="50" name="cognomepadre_fam_new">
								</div>
								<div class="col-md-2">
									<input type="text" class="tablecell5"  id="telefonopadre_fam_new"  maxlength="20" name="telefonopadre_fam_new">
								</div>
								<div class="col-md-3">
									<input type="text" class="tablecell5"  id="emailpadre_fam_new"  maxlength="80" name="emailpadre_fam_new">
								</div>
								<!-- <div class="col-md-1" style="text-align: right" >
									<input type="checkbox" class="tablecell5" id="sociopadre_fam_new" name="sociopadre_fam_new">
								</div> -->
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px;">
							<h4 id="alertmsg" class="center"> 
							  Iscrizione completata con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="width:25%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_goto1" class="btnBlu pull-right" style="width:25%;" onclick="postToSchedaAlunnoNuovo();" >Vai alla Scheda</button>
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="width:25%;" onclick="addAnagrafica();" >Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO **************************************************-->

</body>
</html>
<? include("CodiceFiscale.php")?>
<script>

	$(document).ready(function(){
		//setting del datepicker
		moment.locale('en', {
          week: { dow: 1 }
        });
		$('.datepicker').datetimepicker({
			pickTime: false, 
			format: "DD/MM/YYYY",
            weekStart: 1
		});
		resetResolution();
		requery();
	});
	
	function resetResolution () {
		let offset = $("#tabellaAnagrafica > tbody").offset();
		$('#tabellaAnagrafica > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		let inputVal = $(this).val();
		if (campo == "comunenascita_alu_new"){
			resultDropdown = $("#showComuneNascita_new");
		} else if (campo == "citta_alu_new"){
			resultDropdown = $("#showComuneResidenza_new");
		}
		if(inputVal.length>2){
				$.get("06qry_DropDownComune.php", {inputVal: inputVal}).done(function(data){
				resultDropdown.html(data);
				resultDropdown.show();
				});
		} else {
			resultDropdown.empty();
		}
	});
	

	$('body').click(function () {
		$("#showComuneNascita_new").hide();
		$("#showComuneResidenza_new").hide();
	});




	$(document).on("click", ".showcomune p", function(){
		campo = $(this).parent().attr("name");
		selected = $(this).text();
		ID_cap = selected.substr(0,selected.indexOf("+"));
		comuneselected = $("#comuneselected"+ID_cap).val();
		provselected = $("#provselected"+ID_cap).val();
		paeseselected = "Italia";
		CAPselected = $("#CAPselected"+ID_cap).val();
		switch (campo) {
		case "showComuneNascita_new":
			$("#comunenascita_alu_new").val(comuneselected);
			$("#provnascita_alu_new").val(provselected);
			$("#paesenascita_alu_new").val(paeseselected);
		break;
		case "showComuneResidenza_new":
			$("#citta_alu_new").val(comuneselected);
			$("#prov_alu_new").val(provselected);
			$("#paese_alu_new").val(paeseselected);
			$("#CAP_alu_new").val(CAPselected);
		break;
		}
		$(this).parent().empty();
	});
	
	$("#mf_alu_new").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}
	
	function requery(){
		const campo = [];
		const ord = [];
		const fil = [];
		campo[1] = "nome_alu";
		campo[2] = "cognome_alu";
		//popolo array campo 
		for (i = 3; i <= 9; i++) {
			campo[i] = $( "#selectcampo"+i+" option:selected" ).val();
		}
		for (i = 1; i <= 9; i++) {
			ord[i] = $('#ordinacampo'+i).text();
		}
		for (i = 1; i <= 9; i++) {
			fil[i] = $('#filter'+i).val();
		}
		postData = { campo : campo, ord: ord, fil: fil};
		//console.log ("00anagrafica.php - requery - postData a 00qry_Anagrafica.php ");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "00qry_Anagrafica.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'");     
	        }
		});
	}
	
	function showModalAddAnagraficaAlunno() {
		document.getElementById("form_AddAlunno").reset();
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_goto1").hide();
		$("#btn_OK1").show();
		$('#modalAddAnagraficaAlunno').modal({show: 'true'});
	}
	
	
	function aggiornaDatiFamigliaModal() {
		//questa funzione serve SOLO a sparare nei campi del form modale i valori della famiglia, quando si seleziona dalla combobox, non salva dati in nessuna tabella
		//in questo senso è un "aggiornamento" del form "precario" perchè se poi non si salva, questi dati vengono persi
		let selectfamigliaTMP = document.getElementById("selectFamiglia");
		let ID_fam = selectfamigliaTMP.options[selectfamigliaTMP.selectedIndex].value;
		if (ID_fam != 'none') {
			ID_fam = parseInt(ID_fam);
			postData = { ID_fam: ID_fam };
			$.ajax({
				type: 'POST',
				url: "00qry_getDatiFamiglia.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#nomemadre_fam_new").val(data.nomemadrefam);
					$("#cognomemadre_fam_new").val(data.cognomemadre_fam);
					$("#nomepadre_fam_new").val(data.nomepadre_fam);
					$("#cognomepadre_fam_new").val(data.cognomepadre_fam);
					$("#telefonomadre_fam_new").val(data.telefonomadre_fam);
					$("#telefonopadre_fam_new").val(data.telefonopadre_fam);
					$("#emailmadre_fam_new").val(data.emailmadre_fam);
					$("#emailpadre_fam_new").val(data.emailpadre_fam);
					// if (data.sociomadre_fam == 1) {$("#sociomadre_fam_new").prop("checked", true);} else {$("#sociomadre_fam_new").prop("checked", false);} 
					// if (data.sociopadre_fam == 1) {$("#sociopadre_fam_new").prop("checked", true);} else {$("#sociopadre_fam_new").prop("checked", false);}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'"); 
				}
			});
		} else {
			//se è stata selezionata una NUOVA famiglia allora i campi vanno puliti
			//Si potrebbe  fare il reset di un form, tipo $("#formFamiglia").reset() ma sarebbe un form dentro un form
			//Ho provato e sembra funzionare ma su internet si trova che i form nested possono dare problemi, quindi tolgo il form nested
			$("#nomemadre_fam_new").val("");
			$("#cognomemadre_fam_new").val("");
			$("#nomepadre_fam_new").val("");
			$("#cognomepadre_fam_new").val("");
			$("#telefonomadre_fam_new").val("");
			$("#telefonopadre_fam_new").val("");
			$("#emailmadre_fam_new").val("");
			$("#emailpadre_fam_new").val("");
			// $("#sociomadre_fam_new").prop("checked", false);
			// $("#sociopadre_fam_new").prop("checked", false);
		}
	}

	// function controllaDataNascita (data, annomin, annomax) {
	// 	if ((data != "") && (data != null)) {
	// 		let datam = moment(data, "DD-MM-YYYY" );
	// 		let annom = moment(datam).year();
	// 		if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
	// 	} else {
	// 		return true;
	// 	}
	// }


	function addAnagrafica () {
		//attenzione: questa funzione si trova sia in 06SchedaAlunno.php che in 00Anagrafica.php

		let nome = $('#nome_alu_new').val();
		let cognome = $('#cognome_alu_new').val();
		let mf = $('#mf_alu_new').val();

		if (nome=='' || cognome=='' || mf =='') {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('Almeno nome, cognome e genere sono necessari');
			$("#alertaggiungi").show();
			return;
		}
		let datanascita = $('#datanascita_alu_new').val();
		if (controllaDataNascita(datanascita, 1990, 2050)){
		} else {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('Verificare la data inserita');
			$("#alertaggiungi").show();
			return;
		}
		if ($('#cognomepadre_fam_new').val() == '') {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('Inserire il cognome del padre - eventualmente selezionando una famiglia esistente');
			$("#alertaggiungi").show();
			return;
		}
		if ($('#cognomemadre_fam_new').val() == '') {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html('Inserire il cognome della madre - se non noto inserire xxx');
			$("#alertaggiungi").show();
			return;
		}
		if ($('#cognomepadre_fam_new').val() != cognome) {
			if ($('#cognome_alunno_padre_uguali').val() != "no") {
				//nel caso di Cittadella non si pone alcun vincolo in questo, invece nel caso di Padova l'impostazione cognome_alunni_padre_uguali = si blocca la procedura a questo livello
				$testo= ("Il cognome del padre non corrisponde a quello dell'alunno.<br>Sebbene questa situazione sia possibile, non è raccomandabile per praticità nella consultazione.<br>E' preferibile correggere, ad esempio con un doppio cognome per entrambi, anche se formalmente non esatto.");
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-warning');
				$("#alertmsg").html($testo);
				$("#alertaggiungi").show();
				return;
			}
		}

		let postData = $("#form_AddAlunno").serializeArray();
		$.ajax({
			url : "00qry_checkIfAnagraficaDuplicate.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data) {
				if (data.test != 0) {
					$("#alertaggiungi").removeClass('alert-success');
					$("#alertaggiungi").addClass('alert-danger');
					$("#alertmsg").html(nome+" "+cognome+" già presente in anagrafica. Se omonimo modificare il nome scrivendo ad es. 'Mario Rossi2'.");
					$("#alertaggiungi").show();
					return;
				} else {
					//console.log ('selezionato'+ $('#selectFamiglia').val());
					$.ajax({
						url : "00qry_checkIfFamigliaDuplicate.php",
						type: "POST",
						data : postData,
						dataType: "json",
						success:function(data1) {
							//Verifica che non si stia inserendo nuovamente una famiglia che c'è già
							//Nel caso di cognome madre E cognome padre entrambi uguali (eventualità remota)
							//attualmente impedisce di inserire, forse meglio così
							if (data1.test != 0 && $('#selectFamiglia').val() == 'none') {
								$("#alertaggiungi").removeClass('alert-success');
								$("#alertaggiungi").addClass('alert-danger');
								$("#alertmsg").html("Famiglia già presente in anagrafica. Non lasciare 'NUOVA FAMIGLIA' ma selezionare la famiglia dalla casella a discesa.<br> per inserire una famiglia OMONIMA modificare il cognome del padre, scrivendo ad es. Rossi2");
								$("#alertaggiungi").show();
								//$("#btn_cancel1").html('Chiudi');
								//$("#btn_goto1").show();
								//$("#btn_OK1").hide();
								return;
							} else {
								console.log ("00anagrafica.php - addAnagrafica - postData a 00qry_insertAnagrafica.php ");
								console.log (postData);
								$.ajax({
									url : "00qry_insertAnagrafica.php",
									type: "POST",
									data : postData,
									dataType: "json",
									success:function(data2) {
										// console.log ("00anagrafica.php - addAnagrafica - ritorno da 00qry_insertAnagrafica.php");
										// console.log("ID appena inserito", data2.test);
										$("#IDAnagraficaAppenaInseritaHidden").val(data2.ID);
										$("#remove-content").slideUp();
										$("#alertaggiungi").removeClass('alert-danger');
										$("#alertaggiungi").addClass('alert-success');
										$("#alertmsg").html('Iscrizione di '+nome+' '+cognome+' completata con successo!');
										$("#alertaggiungi").show();
										$("#btn_cancel1").html('Chiudi');
										$("#btn_goto1").show();
										$("#btn_OK1").hide();

										requery();
									},
									error: function(){
										alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'");      
									}
								});	
							}
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'");      
						}

					});	
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'"); 
			}
		});
		
	}
	
	function postToSchedaAlunno(ID, nome, cognome) {

		let form = $(document.createElement('form'));
		$(form).attr("action", "06SchedaAlunno.php");
		$(form).attr("method", "POST");
		$(form).css("display", "none");

		let input_IDalu = $("<input>")
		.attr("type", "text")
		.attr("name", "ID_aluDaAltraPag")
		.val(ID);
		$(form).append($(input_IDalu));

		let input_nomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "nome_aluDaAltraPag")
		.val(nome);
		$(form).append($(input_nomealu));

		let input_cognomealu = $("<input>")
		.attr("type", "text")
		.attr("name", "cognome_aluDaAltraPag")
		.val(cognome);
		$(form).append($(input_cognomealu));

		form.appendTo( document.body );
		$(form).submit();
		//console.log (input_cognomealu);
	}

	function postToSchedaAlunnoNuovo() {
		let ID = $("#IDAnagraficaAppenaInseritaHidden").val();
		let nome = $('#nome_alu_new').val();
		let cognome = $('#cognome_alu_new').val();

		postToSchedaAlunno(ID, nome, cognome);
	}

	function showModalDeleteThisRecord(ID_alu, nome_alu, cognome_alu) {

		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare l'alunno/a "+nome_alu+" "+cognome_alu+" ? <br>Verranno anche eliminate tutte le sue rette,<br> le classi frequentate, le pagelle, <br>e - se non ci sono fratelli - anche la famiglia...<br><br> digitare la password e confermare");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_alu+");");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE ALUNNO/A');
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_alu) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			$('.upper').css('height', '100%');
			$('.lower').css('height', '0%');
			$('#mat_icon_det').removeClass('fa-angle-double-up');
			$('#mat_icon_det').addClass('fa-angle-double-down');
			postData = { ID_alu: ID_alu};
			$.ajax({
				type: 'POST',
				url: "00qry_deleteAnagrafica.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Alunno/a eliminato/a!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '00Anagrafica ##fname##'");      
				}
			});
		}
	}
	
	function coloraRighe(ID_alu){
		//ripristino colori tabella alternati
		$('#tabellaAnagrafica tr:even td .tablecell6').css('background-color', '#e0e0e0').css('color', '#474747');
		$('#tabellaAnagrafica tr:odd td .tablecell6').css('background-color', '#fff').css('color', '#474747');
		$('.val'+ID_alu).css('background-color', '#289bce').css('color', '#fff');
	}
	
</script>
