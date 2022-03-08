<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Anagrafica Maestri</title>
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
	<? $_SESSION['page'] = "Anagrafica Maestri";?>
</head>

<body>
<? include("NavBar.php"); ?>
	<div id="main">
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres">
			<div class="titoloPagina">
				Anagrafica Personale
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
						<option value="DownloadExcelAnagraficaMaestri">Anagrafiche Maestri</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div style="text-align: center;">
				<table id="tabellaAnagraficaMaestri" style="margin-left: 55px; margin-top: 30px; display:inline-block; ">
					<thead>
						<tr>
							<th style="width:22px;">
								<img title="Aggiungi nuova Anagrafica Personale" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddAnagraficaMaestro();">
							</th>
							<th style="width:30px;">
								
							</th>
							<th>
								<input class="tablelabel0" style="width: 150px; " type="text" id="nome_mae" name="nome_mae" value="NOME" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 150px;" type="text" id="cognome_mae" name="cognome_mae" value="COGNOME" disabled>
							</th>
							<th>
								<input class="tablelabel0 w100px" type="text" id="tipo_per" name="tipo_per" value="Tipo Personale" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 40px;" type="text" id="in_organico_mae" name="in_organico_mae" value="Dip." disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 115px;" type="text" id="telefono_mae" name="telefono_mae" value="TELEFONO" disabled>
							</th>
							<th>
								<input class="tablelabel0"  style="width: 458px;" type="text" id="note_mae" name="note_mae" value = "Note" disabled>
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
								<button id="ordinacampo6" class="ordinabutton" onclick="ordina(6);" >--</button>
							</th>
					</thead>
					<tbody class="scroll" id="maintable">
					</tbody>
				</table>
			</div>
		</div>
			
		<!--<div class="lower highres" >
			<hr style="height: 12px;   border: 0;   box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5); margin-bottom: 0px; margin-top: 0px;">
			<div id="maestrodettaglio" style="overflow: visible">
			</div>
		</div>-->
	</div>	

<!--*******************************************MODAL FORM PER Inserimento nuovo maestro-->
	<div class="modal" id="modalAddAnagraficaMaestro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 70%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddMaestro" method="post">
						<span class="titoloModal">Inserimento nuova Anagrafica (maestro o altro personale)</span>
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
									<input class="tablecell5" type="text"  id="nome_mae_new" name="nome_mae_new" required>
								</div>
								<div class="col-md-3">
									<input class="tablecell5" type="text"  id="cognome_mae_new" name="cognome_mae_new" required>
								</div>
								<div class="col-md-1">
									<input class="tablecell5" type="text"  id="mf_mae_new" name="mf_mae_new" maxlength="1" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="margin-top: 20px; font-size: 16px;">
									Login da associare*
								</div>
								<div class="col-md-3" style="margin-top: 20px; font-size: 16px;">
									Tipologia Personale
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" id="selectloginContainer">

								</div>
								<div class="col-md-3" style="font-size: 16px;">
									<select name="selecttipo"  style="margin-left: 0px; font-size: 13px;"  id="selecttipo">
											<option value="0" selected>Maestro</option>
											<option value="1" >Amministratore</option>
											<option value="2" >Altro (Segreteria, cucina ecc.)</option>
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
									<input type="submit" id= "submit-btn" class="btnBlu mb5" style=" width: 40%;" onclick="trovaCF('maestronew', event);" value ="C.F." readonly>
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5 datepicker"  id="datanascita_mae_new" name="datanascita_mae_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5 search-comune"  id="comunenascita_mae_new" name="comunenascita_mae_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5"  id="provnascita_mae_new" name="provnascita_mae_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="paesenascita_mae_new" name="paesenascita_mae_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="cf_mae_new" name="cf_mae_new">
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
									<input type="text"  class="tablecell5"  id="indirizzo_mae_new" name="indirizzo_mae_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5 search-comune"  id="citta_mae_new" name="citta_mae_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5"  id="prov_mae_new" name="prov_mae_new" >
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="paese_mae_new" name="paese_mae_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="CAP_mae_new" name="CAP_mae_new">
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
								<div class="col-md-1">
								</div>
								<div class="col-md-2">
									telefono
								</div>
								<div class="col-md-3">
									e-mail
								</div>
								<div class="col-md-6">
									Titolo
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2 center">
									<input class="tablecell5" type="text"  id="telefono_mae_new" name="telefono_mae_new">
								</div>
								<div class="col-md-3 center">
									<input class="tablecell5" type="text"  id="email_mae_new" maxlength= "100" name="email_mae_new">
								</div>
								<div class="col-md-6" style="text-align: center;">
									<input class="tablecell5 w100" type="text"  id="titolo_mae_new" name="titolo_mae_new">
								</div>
							</div>
							<div class="row" style="margin-bottom:20px;">
								<div class="col-md-1">
								</div>
								<div class="col-md-11" style="margin-top:30px;">
									Note
									<br>
									<textarea class="tablecell5 w100" type="text"  id="note_mae_new" name="note_mae_new"></textarea>
								</div>
							</div>							
						</div> <!-- END REMOVE CONTENT -->
						<div class="modal-footer">
							<button type="button" id="btn_cancel" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK" class="btnBlu pull-right" style="width:40%;" onclick="aggiungiAnagraficaMaestro();">Procedi</button>
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

	function DownloadExcelAnagraficaMaestri() {
		window.location.href='03downloadAnMaestri.php';
	}
	
	$("#mf_mae_new").keypress(function(e){
		let inputValue = event.which;
		// F = 70, M = 77
		if((inputValue != 70) && (inputValue != 77)){ 
			e.preventDefault(); 
		}
	});
	
	function resetResolution () {
		let offset = $("#tabellaAnagraficaMaestri > tbody").offset();
		$('#tabellaAnagraficaMaestri > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	$('.search-comune').on("keyup input", function(){
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
		let ord5 = $('#ordinacampo5').text();
		let ord6 = $('#ordinacampo6').text();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, ord6: ord6};
		$.ajax({
			type: 'POST',
			url: "03qry_AnagraficaMaestri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '03AnagraficaMaestri ##requery##'");      
			}
		});
		resetResolution();
	}
	
	function showModalAddAnagraficaMaestro() {


		$.ajax({
			type: 'POST',
			url: "03qry_GetFreeUsers.php",
			dataType: 'html',
			success: function(html){
				console.log(html);
				$("#selectloginContainer").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '03AnagraficaMaestri ##showModalAddAnagraficaMaestro##'");      
			}
		});



		document.getElementById("form_AddMaestro").reset();
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel").html('Annulla');
		$("#btn_cancel").addClass('pull-left');
		$("#btn_OK").show();

		/*$('.upper').css('height', '100%');
		$('.lower').css('height', '0%');
		$('#mat_icon_det').removeClass('fa-angle-double-up');
        $('#mat_icon_det').addClass('fa-angle-double-down');*/
		$('#modalAddAnagraficaMaestro').modal({show: 'true'});
	}

	// function controllaDataNascita (data, annomin, annomax) {
	// 	if ((data != "") && (data != null)) {
	// 		let datam = moment(data, "DD-MM-YYYY" );
	// 		let annom = moment(datam).year();
	// 		//console.log ("03AnagraficaMAestri.php - controllaDataNascita");
	// 		//console.log (data);
	// 		if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
	// 	} else {
	// 		return true;
	// 	}
	// }

	function aggiungiAnagraficaMaestro() {
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
			console.log ("03AnagraficaMAestri.php - aggiungiAnagraficaMaestro - postData a 03qry_insertAnagraficaMaestro.php");
			console.log (postData);
			
			$.ajax({
				type: 'POST',
				url: "03qry_insertAnagraficaMaestro.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					console.log ("03AnagraficaMAestri.php - aggiungiAnagraficaMaestro - ritorno da 03qry_insertAnagraficaMaestro.php");
					console.log(data.sql3);
					//console.log (data.test);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html('Iscrizione di '+nome_mae_new+' '+cognome_mae_new+' completata con successo!');
					$("#alertaggiungi").show();
					$("#btn_cancel").html('Chiudi');
					$("#btn_cancel").removeClass('pull-left');
					$("#btn_OK").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '03AnagraficaMaestri ##aggiungiAnagraficaMaestro##'");      
				}
			});
		}
	}
	
	function showModalDeleteThisRecord(ID_mae, nome_mae, cognome_mae) {
			$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare il/la dipendente "+nome_mae+" "+cognome_mae+" ? <br>Verranno eliminate anche le classi di insegnamento passate. <br>La scelta è sconsigliata, è preferibile togliere il flag 'in organico'.<br><br> digitare la password e confermare");
			$("#btn_OK03Msg_OKCancelPsw").attr("onclick","deleteThisRecord("+ID_mae+");");
			$("#btn_OK03Msg_OKCancelPsw").show();
			$("#titolo03Msg_OKCancelPsw").html('ELIMINAZIONE DIPENDENTE');
			$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
			$("#remove-content03Msg_OKCancelPsw").show();
			$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
			$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
			$("#alertCont03Msg_OKCancelPsw").hide();
			$("#passwordDelete").val("");
			$('#modal03Msg_OKCancelPsw').modal('show');
	}

	function deleteThisRecord(ID_mae) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		}	else  {
			postData = { ID_mae: ID_mae};
			$.ajax({
				type: 'POST',
				url: "03qry_deleteAnagraficaMaestro.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Maestro/a eliminato/a!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requery();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '03AnagraficaMaestri ##deleteThisRecord##'");      
				}
			});
		}

	}

</script>