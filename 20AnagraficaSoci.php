<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Anagrafica Soci</title>
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
	<script src="assets/functions/functionsJS.js"></script>
	<? $_SESSION['page'] = "Anagrafica Soci";?>
</head>

<body>
<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">
			<div class="titoloPagina">
				Anagrafica Soci
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
						<option value="DownloadExcelAnagraficaSoci">Anagrafiche Soci</option>
						<option value="DownloadExcelLibroSoci">Libro Soci</option>

					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div style="text-align: center;">
				<table id="tabellaAnagraficaSoci" style="margin-left: 55px; margin-top: 30px; display:inline-block; ">
					<thead>
						<tr>
							<th style="width:22px;">
								<img title="Aggiungi nuova Anagrafica Socio" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddAnagraficaSocio();">
							</th>
							<th style="width:30px;">
								
							</th>
							<th>
								<input class="tablelabel0" style="width: 200px; " type="text" value="NOME" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 200px;" type="text" value="COGNOME" disabled>
							</th>
							<th>
								<input class="tablelabel0 w150px" type="text" id="tipo_per" name="tipo_per" value="Tipo Socio" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 150px;" type="text" value="Data Iscrizione" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 150px;" type="text" value="Data Disiscrizione" disabled>
							</th>
							<th>
							</th>
						<tr>
							<th style="width:22px;">
							</th>
							<th style="width:25px;">
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" >--</button>
							</th>
							<th>
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" >--</button>
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" >--</button>
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" >--</button>
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" >--</button>
							</th>
							<th>
							</th>
							<th>
							</th>
					</thead>
					<tbody class="scroll" id="maintable">
					</tbody>
				</table>
			</div>
		</div>

	</div>	

<!--*******************************************MODAL FORM PER Inserimento nuovo Socio-->
	<div class="modal" id="modalAddAnagraficaSocio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 70%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddSocio" method="post">
						<span class="titoloModal">Inserimento nuova Anagrafica Socio</span>
						<div style="text-align: center;">
							Attenzione! Se si desidera associare un genitore è necessario farlo dalla scheda Alunno di uno dei figli<br>
							In questo modo i dati anagrafici verranno direttamente importati!
						</div>
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px; padding: 10px;">
							<h5 id="alertmsg" style="text-align:center;"> 
							  Iscrizione completata con successo!
							</h5>
						</div>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									nome*
								</div>
								<div class="col-md-3" style="text-align: center;">
									cognome*
								</div>
								<div class="col-md-1">
									M/F
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="nome_soc_new" name="nome_soc_new" required>
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="cognome_soc_new" name="cognome_soc_new" required>
								</div>
								<div class="col-md-1">
									<input class="tablecell5" type="text"  id="mf_soc_new" name="mf_soc_new" maxlength="1" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style="margin-top: 20px; font-size: 16px;">
									Tipologia Socio
								</div>
							</div>
                            <div class="row">
								<div class="col-md-12" style="font-size: 16px;">
									<select name="selecttipo"  style="margin-left: 0px; font-size: 13px;"  id="selecttipo">
											<option value="0" selected>Fruitore</option>
											<option value="1" >Lavoratore</option>
											<option value="2" >Volontario</option>
                                            <option value="3" >Altro</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style= "margin-top: 20px; font-size: 16px;">
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
									<input type="submit" id= "submit-btn" class="btnBlu mb5" style=" width: 40%;" onclick="trovaCF('socionew', event);" value ="C.F." readonly>
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5 datepicker"  id="datanascita_soc_new" name="datanascita_soc_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5 search-comune"  id="comunenascita_soc_new" name="comunenascita_soc_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5"  id="provnascita_soc_new" name="provnascita_soc_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="paesenascita_soc_new" name="paesenascita_soc_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="cf_soc_new" name="cf_soc_new">
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneNascita_new" id="showComuneNascita_new"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style= "margin-top: 20px; font-size: 16px;">
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
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5"  id="indirizzo_soc_new" name="indirizzo_soc_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5 search-comune"  id="comune_soc_new" name="comune_soc_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5"  id="prov_soc_new" name="prov_soc_new" >
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="paese_soc_new" name="paese_soc_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="CAP_soc_new" name="CAP_soc_new">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneResidenza_new" id="showComuneResidenza_new"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style= "margin-top: 20px; font-size: 16px;">
									Altri Dati
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									telefono
								</div>
								<div class="col-md-3">
									e-mail
								</div>

							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3 center">
									<input class="tablecell5" type="text"  id="telefono_soc_new" name="telefono_soc_new">
								</div>
								<div class="col-md-3 center">
									<input class="tablecell5" type="text"  id="email_soc_new" maxlength= "100" name="email_soc_new">
								</div>

							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-1">
								</div>
								<div class="col-md-11" style="margin-top:30px;">
									Note
									<br>
									<textarea class="tablecell5 w100" type="text"  id="note_soc_new" name="note_soc_new"></textarea>
								</div>
							</div>							
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiAnagraficaSocio();">Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<? include("CodiceFiscale.php")?>
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
		//resetResolution();
		requery();
	});
	
	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelAnagraficaSoci() {

		template =		"AnagraficaSoci";
		filetitle = 	"AnagraficaSoci";
		title=			"Anagrafica Soci";
		from = 			" tab_anagraficasoci LEFT JOIN tab_tipisoci ON tipo_soc = ID_tsc ";
		where =			" 1=1 ";
		orderBY = 		" cognome_soc ";
		nomiCampiA = 	[ "idle", "descrizione_tsc", "dataiscrizione_soc", "cognome_soc", "nome_soc", "telefono_soc", "altrotel_soc", "email_soc", "datanascita_soc", "comunenascita_soc", "provnascita_soc", "paesenascita_soc", "cittadinanza_soc", "cf_soc", "indirizzo_soc", "comune_soc", "CAP_soc", "prov_soc", "paese_soc"];
		dataNonDataA = 	["idle", 0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0];
		columnColoring =	"";
		postToDownload(template, filetitle, title, from, where, orderBY, nomiCampiA, dataNonDataA, columnColoring);


		//window.location.href='20DownloadAnSoci.php';

	}


	function DownloadExcelLibroSoci() {

		template =		"LibroSoci";
		filetitle = 	"LibroSoci";
		title=			"Libro Soci";
		from = 			" tab_anagraficasoci LEFT JOIN tab_tipisoci ON tipo_soc = ID_tsc ";
		where =			" 1=1 ";
		orderBY = 		" dataiscrizione_soc, cognome_soc ";
		nomiCampiA = 	[ "idle", "descrizione_tsc", "cognome_soc", "nome_soc", "dataiscrizione_soc", "datadisiscrizione_soc", "motivocessazione_soc", "datanascita_soc", "comunenascita_soc", "provnascita_soc", "paesenascita_soc", "cittadinanza_soc", "cf_soc", "indirizzo_soc", "comune_soc", "CAP_soc", "prov_soc", "paese_soc"];
		dataNonDataA = 	["idle", 0,0,0,1,1,0,1,0,0,0,0,0,0,0,0,0,0];
		columnColoring =	"";
		postToDownload(template, filetitle, title, from, where, orderBY, nomiCampiA, dataNonDataA, columnColoring);

		//window.location.href='20DownloadAnSoci.php';

	}


	$("#mf_soc_new").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
	
	function resetResolution () {
		let offset = $("#tabellaAnagraficaSoci > tbody").offset();
		$('#tabellaAnagraficaSoci > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	$('.search-comune').on("keyup input", function(){
		campo = $(this).attr("name");
		let inputVal = $(this).val();
		if (campo == "comunenascita_soc_new"){
			resultDropdown = $("#showComuneNascita_new");
		} else if (campo == "comune_soc_new"){
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
				$("#comunenascita_soc_new").val(comuneselected);
				$("#provnascita_soc_new").val(provselected);
				$("#paesenascita_soc_new").val(paeseselected);

			break;
			case "showComuneResidenza_new":
				$("#comune_soc_new").val(comuneselected);
				$("#prov_soc_new").val(provselected);
				$("#paese_soc_new").val(paeseselected);
				$("#CAP_soc_new").val(CAPselected);

			break;
		}
			$(this).parent().empty();
	});




	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		
		requery();
	}

	function requery(){
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();

		
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4};
		$.ajax({
			type: 'POST',
			url: "20qry_AnagraficaSoci.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '20AnagraficaSoci ##requery##'");      
			}
		});
		resetResolution();
	}
	
	function showModalAddAnagraficaSocio() {





		document.getElementById("form_AddSocio").reset();
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel").html('Annulla');
		$("#btn_cancel").addClass('pull-left');
		$("#btn_OK").show();

		$('#modalAddAnagraficaSocio').modal({show: 'true'});
	}


	function aggiungiAnagraficaSocio() {
		let nome_soc_new =  $("#nome_soc_new").val();
		let cognome_soc_new =  $("#cognome_soc_new").val();
        let cf_soc_new =  $("#cf_soc_new").val();
        console.log ("CF", cf_soc_new);

		if (nome_soc_new=='' || cognome_soc_new=='' || cf_soc_new =='') {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Almeno nome, cognome e codice fiscale sono necessari');
				$("#alertaggiungi").show();
		} else {
			datanascita = $('#datanascita_soc_new').val();
			if (controllaDataNascita(datanascita, 1930, 2006)){
			} else {
				$("#alertaggiungi").removeClass('alert-success');
				$("#alertaggiungi").addClass('alert-danger');
				$("#alertmsg").html('Controllare la data di nascita');
				$("#alertaggiungi").show();
				return;
			}
			let postData = $("#form_AddSocio").serializeArray();
			console.log ("03AnagraficaSoci.php - aggiungiAnagraficaSocio - postData a 20qry_insertAnagraficaSocio.php");
			console.log (postData);

			$.ajax({
				type: 'POST',
				url: "20qry_insertAnagraficaSocio.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					console.log ("03AnagraficaSoci.php - aggiungiAnagraficaSocio - ritorno da 20qry_insertAnagraficaSocio.php");
					console.log(data.sql3);
					//console.log (data.test);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html('Iscrizione di '+nome_soc_new+' '+cognome_soc_new+' completata con successo!');
					$("#alertaggiungi").show();
					$("#btn_cancel").html('Chiudi');
					$("#btn_cancel").removeClass('pull-left');
					$("#btn_OK").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '03AnagraficaSoci ##aggiungiAnagraficaSocio##'");      
				}
			});
		}
	}
	
	function showModalDeleteThisRecord(ID_soc, nome_soc, cognome_soc) {
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare il socio "+nome_soc+" "+cognome_soc+" ? <br>La scelta è sconsigliata, è preferibile modificare la data di uscita.<br><br> digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_soc+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE SOCIO');
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_soc) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			postData = { ID_soc: ID_soc};
			$.ajax({
				type: 'POST',
				url: "20qry_deleteAnagraficaSocio.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Socio/a eliminato/a!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '20AnagraficaSoci ##deleteThisRecord##'");      
				}
			});
		}

	}

</script>