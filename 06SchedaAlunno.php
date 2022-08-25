<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Scheda Alunno</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" href="assets/croppie/croppie.css" />
	<script src="assets/croppie/croppie.js"></script>

	<link href="assets/datetimepicker/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="assets/moment/moment.js" type="text/javascript"></script>

	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/bootstrap-select/bootstrap-select.css">
	<script src="assets/bootstrap-select/bootstrap-select.js"></script>
	<script src="assets/functions/functionsJS.js"></script>

	<? $_SESSION['page'] = "Scheda Alunno";?>
</head>

<body>
<!-- INTESTAZIONE e INPUT HIDDEN *************************************************************************************-->
	<? include("NavBar.php");?>
	<div id="main">
		<div class="upper">
			<div class="titoloPagina" >
				<img title="Aggiungi nuovo Alunno" class="iconaStd" class="hideonsmalldevices" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddAnagraficaAlunno();">
				Scheda Singolo Alunno

				<input id="ID_alu_det_hidden" <? if (isset ($_POST['ID_aluDaAltraPag'])) {echo ("value ='".$_POST['ID_aluDaAltraPag']."'");}?>hidden>
				<input id="IDAnagraficaAppenaInseritaHidden" 																hidden>
				<input id="pagtoshow_hidden" 					value=	"DatiAnagrafici" 									hidden>
				<input id="cognome_alunno_padre_uguali" 		value=	"<?=$_SESSION['cognome_alunno_padre_uguali']?>" 	hidden>
				<input id="data_limite_re_hidden" 				value = "<?=$_SESSION['data_limite_re']?>" 					hidden>
				<input id="primo_giorno_re_hidden" 				value = "<?=$_SESSION['primo_giorno_re']?>" 				hidden>
				<input id="pswOperazioni1" 						value=	"<?=$_SESSION['pswOperazioni1']?>" 					hidden>
				<input id="parScalino" 							value=	"<?=$_SESSION['scalino']?>" 						hidden>

			</div>
			<div class="frameTopRight">
				<img title="Verifica classe di destinazione" class="iconaStd" class="hideonsmalldevices" src='assets/img/Icone/calendar-check-solid.svg' onclick="showModalCheckAnno();">
			</div>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-12 col-md-offset-0" style="text-align: center; font-size: 16px;">
					<div class="col-xs-12 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-4 itemSchedaAnagrafica">
						<div class="row">
							Nome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="nome_alu" name="nome_alu" <? if (isset ($_POST['nome_aluDaAltraPag'])) {echo ("value =\"".$_POST['nome_aluDaAltraPag']."\"");} ?> onchange="requery();">
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-2 itemSchedaAnagrafica">
						<div class="row">
							Cognome
						</div>
						<div class="row">
							<input style="text-align: center;" class="search-box tablecell2" type="text"  id="cognome_alu" name="cognome_alu" <?	if (isset ($_POST['cognome_aluDaAltraPag'])) { echo ("value =\"".$_POST['cognome_aluDaAltraPag']."\"");}?> onchange="requery();">
						</div>
					</div>
					<!--z-index modificato perchè andava sotto...nel caso rimodificare-->
					<div class=" col-md-12 col-xs-12 itemSchedaAnagrafica" style="margin-top: -5px; z-index: 1000;"> 
						<div class="col-xs-12 col-md-4 col-md-offset-4" style="position: absolute; left: 0px; text-align: center; padding:0px; ">
							<div id="showresult" style="text-align: center; cursor: default; z-index: 15;" ></div>
						</div>
					</div>

				</div>
            </div>
			<div class="scroll" id="SchedaAlunno_det">
			</div>
		</div>
	</div>

<!--FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO ******************************************************************-->

	<div class="modal" id="modalAddAnagraficaAlunno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 70%">
			<div class="modal-content">
				<div class="modal-body white">
					<form id="form_AddAlunno" method="post">
						<span class="titoloModal">Inserimento nuova Anagrafica Alunno/a</span>
						<br>
						<span class="testoModal">altri dati oltre a quelli qui richiesti vanno specificati nella scheda alunno, disponibile dopo l'inserimento</span>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									nome
								</div>
								<div class="col-md-3" style="text-align: center;">
									cognome
								</div>
								<div class="col-md-1" style="text-align: center;">
									M/F
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5" type="text"  id="nome_alu_new"  maxlength="50" name="nome_alu_new" required>
								</div>
								<div class="col-md-3" style="text-align: center;">
									<input class="tablecell5" type="text"  id="cognome_alu_new"  maxlength="50" name="cognome_alu_new" required>
								</div>
								<div class="col-md-1" style="text-align: center;">
									<input class="tablecell5" type="text"  id="mf_alu_new" name="mf_alu_new" maxlength="1" required>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 subtitleModal">
										Nato/a
								</div>
							</div>

							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									il
								</div>
								<div class="col-md-3 center">
									comune
								</div>
								<div class="col-md-1 center">
									prov
								</div>
								<div class="col-md-3 center">
									paese
								</div>
								<div class="col-md-2">
									<input type="submit" id= "submit-btn" class="btnBlu20 mb5" style=" width: 40%;" onclick="trovaCF('alunnonew', event);" value ="C.F." readonly>
								</div>
							</div>

							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									<input type="text" class="tablecell5 datepicker"  id="datanascita_alu_new"  maxlength="10" name="datanascita_alu_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5 search-comune"  id="comunenascita_alu_new"  maxlength="50" name="comunenascita_alu_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5" id="provnascita_alu_new"  maxlength="4" name="provnascita_alu_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5" id="paesenascita_alu_new"  maxlength="50" name="paesenascita_alu_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="cf_alu_new"  maxlength="16" name="cf_alu_new">
								</div>
							</div>
							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">

								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneNascita_new" id="showComuneNascita_new" ></div>
								</div>
								<div class="col-md-1 center">

								</div>
								<div class="col-md-3 center">

								</div>
								<div class="col-md-2" style="text-align: right">

								</div>
							</div>

							<div class="row">
								<div class="col-md-12 subtitleModal">
									Residenza
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 center">
									via
								</div>
								<div class="col-md-3 center">
									comune
								</div>
								<div class="col-md-1 center">
									prov
								</div>
								<div class="col-md-3 center">
									paese
								</div>
								<div class="col-md-2 center">
									CAP
								</div>
							</div>

							<div class="row">
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5"  id="indirizzo_alu_new"  maxlength="50" name="indirizzo_alu_new">
								</div>
								<div class="col-md-3 center">
									<input type="text"  class="tablecell5 search-comune"  id="citta_alu_new"  maxlength="50" name="citta_alu_new">
								</div>
								<div class="col-md-1 center">
									<input type="text" class="tablecell5"  id="prov_alu_new"  maxlength="4" name="prov_alu_new" >
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="paese_alu_new"  maxlength="50" name="paese_alu_new">
								</div>
								<div class="col-md-2" style="text-align: right">
									<input type="text" class="tablecell5" id="CAP_alu_new"  maxlength="5" name="CAP_alu_new">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 center">

								</div>
								<div class="col-md-3 DropDownContainer">
									<div class="showcomune" name="showComuneResidenza_new" id="showComuneResidenza_new" ></div>
								</div>
								<div class="col-md-1 center">

								</div>
								<div class="col-md-3 center">

								</div>
								<div class="col-md-2" style="text-align: right">

								</div>
							</div>
							<div class="row">
								<div class="col-md-12" style="text-align: center; margin-top: 30px; ">
									<select id="selectFamiglia" name="selectFamiglia"  onchange="aggiornaDatiFamigliaModal();">
										<? $sql = "SELECT ID_fam, cognomepadre_fam, cognomemadre_fam FROM tab_famiglie ORDER BY cognomepadre_fam";
											$stmt = mysqli_prepare($mysqli, $sql);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_bind_result($stmt, $ID_fam, $cognomepadre_fam, $cognomemadre_fam);
											?> <option value="none" selected>-NUOVA FAMIGLIA-</option> <?
											while (mysqli_stmt_fetch($stmt)) {
											?> <option value="<?=$ID_fam?>" ><?=$cognomepadre_fam." - ".$cognomemadre_fam?></option><?
											}?>
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
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									nome
								</div>
								<div class="col-md-2 center">
									cognome
								</div>
								<div class="col-md-2 center">
									tel
								</div>
								<div class="col-md-3 center">
									email
								</div>
								<div class="col-md-1 center">
									Socio
								</div>
							</div>

							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5"  id="nomemadre_fam_new"  maxlength="50" name="nomemadre_fam_new">
								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5"  id="cognomemadre_fam_new"  maxlength="50" name="cognomemadre_fam_new">
								</div>
								<div class="col-md-2 center">
									<input type="text" class="tablecell5"  id="telefonomadre_fam_new"  maxlength="20" name="telefonomadre_fam_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="emailmadre_fam_new"  maxlength="80" name="emailmadre_fam_new">
								</div>
								<div class="col-md-1" style="text-align: right">
									<input type="checkbox" class="tablecell5" id="sociomadre_fam_new" name="sociomadre_fam_new">
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 subtitleModal">
									Papà
								</div>
							</div>
							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									nome
								</div>
								<div class="col-md-2 center">
									cognome
								</div>
								<div class="col-md-2 center">
									tel
								</div>
								<div class="col-md-3 center">
									email
								</div>
								<div class="col-md-1 center">
									Socio
								</div>
							</div>

							<div class="row">
								<div class="col-md-1 center">

								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5"  id="nomepadre_fam_new"  maxlength="50" name="nomepadre_fam_new">
								</div>
								<div class="col-md-2 center">
									<input type="text"  class="tablecell5"  id="cognomepadre_fam_new"  maxlength="50" name="cognomepadre_fam_new">
								</div>
								<div class="col-md-2 center">
									<input type="text" class="tablecell5"  id="telefonopadre_fam_new"  maxlength="20" name="telefonopadre_fam_new">
								</div>
								<div class="col-md-3 center">
									<input type="text" class="tablecell5"  id="emailpadre_fam_new"  maxlength="80" name="emailpadre_fam_new">
								</div>
								<div class="col-md-1" style="text-align: right;">
									<input type="checkbox" class="tablecell5" id="sociopadre_fam_new" name="sociopadre_fam_new" >
								</div>
							</div>
						</div> <!-- END REMOVE CONTENT -->

						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px;">
							<h4 id="alertmsg" style="text-align:center;">
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
			</div><!-- fine modal-content -->
		</div><!-- fine modal-dialog -->
	</div>
<!--FINE FORM MODALE INSERIMENTO NUOVA ANAGRAFICA ALUNNO *************************************************************-->


<!--FORM MODALE VERIFICA ANNO SCOLASTICO *****************************************************************************-->
	<div class="modal" id="modalCheckAnno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 60%">
			<div class="modal-content">
				<div class="modal-body white">
					<form id="form_CheckAnno" method="post">
						<span class="titoloModal">Verifica Classe di Inserimento</span><br>
						<span class="testoModal">in base alla data di nascita</span>
						<div id="modalCheckAnno" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									anno scolastico
								</div>
								<div class="col-md-3">
									data di nascita
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									<select name="selectannoscolasticoCheck"  style="margin-left: 0px"  id="selectannoscolasticoCheck" onchange="requeryCheckAnno(); evidenziaQuale();">
										<? $sql = "SELECT anno1_asc, annoscolastico_asc FROM tab_anniscolastici";
											$stmt = mysqli_prepare($mysqli, $sql);
											mysqli_stmt_execute($stmt);
											mysqli_stmt_bind_result($stmt, $anno1_asc, $annoscolastico_asc);
											while (mysqli_stmt_fetch($stmt)) {
											?>
											<option value="<?=$anno1_asc?>"><?=$annoscolastico_asc?></option>
											<?}?>
									</select>
								</div>
								<div class="col-md-3">
									<input class="tablecell5 datepicker" type="text"  id="datanascita_tock" name="datanascita_tock" onchange="evidenziaQuale();">
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-3">

								</div>
								<div class="col-md-3" style="color: red;" id="classeDiDestinazione">
									&nbsp;
								</div>
							</div>
							<div class="row" style="margin-top: 20px;">
								<div class="col-md-1">
								</div>
								<div class="col-md-4" style="text-align: center;">
									DATA DI NASCITA
								</div>
								<div class="col-md-2" style="text-align: center;">

								</div>
								<div class="col-md-4" style="text-align: center;">
									ETA' ODIERNA
								</div>
							</div>
							<div class="row">
								<div class="col-md-1">
								</div>
								<div class="col-md-2" style="text-align: center;">
									dal
								</div>
								<div class="col-md-2" style="text-align: center;">
									al
								</div>
								<div class="col-md-2" style="text-align: center;">
									Classe
								</div>
								<div class="col-md-2" style="text-align: center;">
									tra
								</div>
								<div class="col-md-2" style="text-align: center;">
									e
								</div>
							</div>
							<?
							$classeA = array("idle", "idle", "idle", "Asilo Nido", "In Corso d'anno", "Materna 1^", "Materna 2^", "Materna 3^", "Anno del Re/Regina", "PRIMA", "SECONDA", "TERZA", "QUARTA", "QUINTA", "SESTA", "SETTIMA", "OTTAVA");

							for ($x = 4; $x <= 16; $x++) {

							?>
							<div  class="row mt5">
								<div class="col-md-1">
								</div>
								<div class="col-md-2"  style="text-align: center;">
									<input class="tablecell5" type="text"  id="datanascita<?=$x?>A" disabled>
								</div>
								<div class="col-md-2" style="text-align: center;">
									<input class="tablecell5" type="text"  id="datanascita<?=$x?>B" disabled>
								</div>
								<div class="col-md-2" style="text-align: center;">
									<?=$classeA[$x]?>
								</div>
								<div class="col-md-2" style="text-align: center;">
									<input class="tablecell5" type="text"  id="eta<?=$x?>A" disabled>
								</div>
								<div class="col-md-2" style="text-align: center;">
									<input class="tablecell5" type="text"  id="eta<?=$x?>B" disabled>
								</div>
							</div>
							<?}?>
						</div>
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px;">
							<h4 id="alertmsg" style="text-align:center;">
							  Iscrizione completata con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelVerificaAnno" class="btnBlu" style="width:25%;" data-dismiss="modal">Chiudi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--FINE FORM MODALE VERIFICA ANNO SCOLASTICO ************************************************************************-->



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
		requery();
	});

	$('.search-box').on("keyup input", function(){
		// Get input value on change
		let inputVal = $(this).val();
		let resultDropdown = $("#showresult");
		if(inputVal.length){
			campo = $(this).attr("name");
				$.get("06qry_DropDown.php", {inputVal: inputVal, campo: campo}).done(function(data){
				// Display the returned data in browser
				resultDropdown.html(data);
				});
		} else {
			resultDropdown.empty();
		}
	});

	$(document).on("click", "#showresult p", function(){
		//quando si fa clic sulla dropdown che compare, accade questo
		//si pesca l'ID dalla stringa (che è nascosto)
		//si pesca il nome (prima di -)
		//si pesca il cognome (dopo -)
		selected = $(this).text();
		ID_alu = selected.substr(0,selected.indexOf("+"));
		nome_alu = $("#nomeselected"+ID_alu).val();
		cognome_alu = $("#cognomeselected"+ID_alu).val();
		$("#nome_alu").val(nome_alu);
		$("#cognome_alu").val(cognome_alu);
		$("#ID_alu_det_hidden").val(ID_alu);
		$(this).parent("#showresult").empty();

		requery();
		$("#pagtoshow_hidden").val("DatiAnagrafici");
	});

	$('body').click(function () {
		$('.showcomune').hide();
	});


	$(document).on("click", ".showcomune p", function(){
		//campo = this.name;
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
			case "showComuneNascita_det":
				$("#comunenascita_alu_det").val(comuneselected);
				$("#provnascita_alu_det").val(provselected);
				$("#paesenascita_alu_det").val(paeseselected);
			break;
			case "showComuneResidenza_det":
				$("#citta_alu_det").val(comuneselected);
				$("#prov_alu_det").val(provselected);
				$("#paese_alu_det").val(paeseselected);
				$("#CAP_alu_det").val(CAPselected);
			break;
			case "showComuneResidenzaPadre_det":
				$("#comunepadre_fam_det").val(comuneselected);
				$("#provpadre_fam_det").val(provselected);
				$("#paesepadre_fam_det").val(paeseselected);
				$("#CAPpadre_fam_det").val(CAPselected);
			break;
			case "showComuneResidenzaMadre_det":
				$("#comunemadre_fam_det").val(comuneselected);
				$("#provmadre_fam_det").val(provselected);
				$("#paesemadre_fam_det").val(paeseselected);
				$("#CAPmadre_fam_det").val(CAPselected);
			break;
			case "showComuneNascitaPadre_det":
				$("#comunenascitapadre_fam_det").val(comuneselected);
				$("#provnascitapadre_fam_det").val(provselected);
				$("#paesenascitapadre_fam_det").val(paeseselected);
			break;
			case "showComuneNascitaMadre_det":
				$("#comunenascitamadre_fam_det").val(comuneselected);
				$("#provnascitamadre_fam_det").val(provselected);
				$("#paesenascitamadre_fam_det").val(paeseselected);
			break;
		}
			$(this).parent().empty();
	});

	function requery(){

		let ID_alu = $("#ID_alu_det_hidden").val();
		postData = { ID_alu : ID_alu };
		$.ajax({

			type: 'POST',
			url: "06qry_SchedaAlunno.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#SchedaAlunno_det").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##fname##'");      
			}
		});

	}

	function showModalAddAnagraficaAlunno() {
		document.getElementById("form_AddAlunno").reset();
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		//$("#btn_cancel1").addClass('pull-left');
		$("#btn_goto1").hide();
		$("#btn_OK1").show();
		//$('.upper').css('height', '100%');
		//$('.lower').css('height', '0%');
        //$('#mat_icon_det').removeClass('fa-angle-double-up');
        //$('#mat_icon_det').addClass('fa-angle-double-down');
		$('#modalAddAnagraficaAlunno').modal({show: 'true'});
	}

	function showModalCheckAnno() {
		//document.getElementById("form_AddAlunno").reset();
		//$("#remove-content").show();
		//$("#alertaggiungi").hide();
		requeryCheckAnno();
		$('#modalCheckAnno').modal({show: 'true'});
	}

	function calcolaEta (dataA) {
			let dataM = moment(dataA);
			var now = moment(new Date());

			var years = now.diff(dataM, 'year');

			dataM.add(years, 'years');
			var months = now.diff(dataM, 'months');

			return ((years+2)+" anni  e "+months+ " mesi");
	}

	function requeryCheckAnno(){
		data_limite_re = $('#data_limite_re_hidden').val();
		primo_giorno_re = $('#primo_giorno_re_hidden').val();

		giorno_limite_re = data_limite_re.substring(4, 6); //31
		mese_limite_re = data_limite_re.substring(1, 3);	//05 o 08

		giorno_primo_giorno_re = data_limite_re.substring(4, 6); //01
		mese_primo_giorno_re = data_limite_re.substring(1, 3); //06 o 09

	
		//annoscolastico contiene il primo dei due anni (se si seleziona 2019-20 contiene 2019)
		let annoscolastico =  $('#selectannoscolasticoCheck').val();
			//modifico le prime due colonne nelle quali sono riportate 
			//le date di nascita degli alunni che frequentano le varie classi
			//queste sono rappresentate dai campi #datanascitaA e #datanascitaB
			//e vanno da 4 a 16 (4= in corso d'anno, 16= VIII)
			//inoltre con la stessa logica modifico i campi etaA e etaB che sono le due colonne successive
			//in corso d'anno
			$('#datanascita4A').val(giorno_primo_giorno_re+"/"+mese_primo_giorno_re+"/"+(annoscolastico-3));
			$('#datanascita4B').val("31/12/"+(annoscolastico-3));
			//$('#eta4B').val(calcolaEta (annoscolastico-1+"-06-01"));
			$('#eta4B').val(calcolaEta (annoscolastico-1+primo_giorno_re));
			$('#eta4A').val(calcolaEta (annoscolastico-1+"-12-31"));
			//primo e secondo anno materna
		for (i = 5; i < 7; i++) {
			$('#datanascita'+i+'A').val(giorno_primo_giorno_re+"/"+mese_primo_giorno_re+"/"+(annoscolastico-(i-1)));
			$('#datanascita'+i+'B').val(giorno_limite_re+"/"+mese_limite_re+"/"+(annoscolastico-(i-2)));
			//$('#eta'+i+'B').val(calcolaEta (annoscolastico-(i-3)+"-06-01"));
			$('#eta'+i+'B').val(calcolaEta (annoscolastico-(i-3)+primo_giorno_re));
			//$('#eta'+i+'A').val(calcolaEta (annoscolastico-(i-4)+"-05-31"));
			$('#eta'+i+'A').val(calcolaEta (annoscolastico-(i-4)+data_limite_re));
		}
			//terzo anno
			$('#datanascita7A').val("01/01/"+(annoscolastico-5));
			$('#datanascita7B').val(giorno_limite_re+"/"+mese_limite_re+"/"+(annoscolastico-5));
			$('#eta7B').val(calcolaEta (annoscolastico-3+"-01-01"));
			//$('#eta7A').val(calcolaEta (annoscolastico-3+"-05-31"));
			$('#eta7A').val(calcolaEta (annoscolastico-3+primo_giorno_re));
			//anno del re/regina
			$('#datanascita8A').val(giorno_primo_giorno_re+"/"+mese_primo_giorno_re+"/"+(annoscolastico-6));//cambiare in primo_giorno_re ma in altro formato
			$('#datanascita8B').val("31/12/"+(annoscolastico-6));
			//$('#eta8B').val(calcolaEta (annoscolastico-4+"-06-01"));//cambiare in primo_giorno_re
			$('#eta8B').val(calcolaEta (annoscolastico-4+primo_giorno_re));
			$('#eta8A').val(calcolaEta (annoscolastico-4+"-12-31"));
			//dalle elememtari in avanti
		for (i = 9; i < 19; i++) {
			$('#datanascita'+i+'A').val(giorno_primo_giorno_re+"/"+mese_primo_giorno_re+"/"+(annoscolastico-(i-2)));//cambiare in primo_giorno_re ma in altro formato
			$('#datanascita'+i+'B').val(giorno_limite_re+"/"+mese_limite_re+"/"+(annoscolastico-(i-3)));
			//$('#eta'+i+'B').val(calcolaEta (annoscolastico-(i-4)+"-06-01"));
			$('#eta'+i+'B').val(calcolaEta (annoscolastico-(i-4)+primo_giorno_re));
			//$('#eta'+i+'A').val(calcolaEta (annoscolastico-(i-5)+"-05-31"));
			$('#eta'+i+'A').val(calcolaEta (annoscolastico-(i-5)+data_limite_re));
		}
		

	}

	$('#form_AddAlunno').on('click', function (event){ 
     //event.preventDefault(); 
	});

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
		$.ajax(
		{
			url : "00qry_checkIfAnagraficaDuplicate.php",
			type: "POST",
			data : postData,
			dataType: "json",
			success:function(data){
				if (data.test != 0) {
					$("#alertaggiungi").removeClass('alert-success');
					$("#alertaggiungi").addClass('alert-danger');
					$("#alertmsg").html(nome+" "+cognome+" già presente in anagrafica. Se omonimo modificare il nome scrivendo ad es. 'Mario Rossi2'.");
					$("#alertaggiungi").show();
					return;
				} else {
					//console.log ('selezionato'+ $('#selectFamiglia').val());
					$.ajax(
					{
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
								$("#alertmsg").html("Famiglia già presente in anagrafica. Non lasciare 'NUOVA FAMIGLIA' ma selezionare la famiglia dalla casella a discesa.<br> Per inserire una famiglia OMONIMA modificare il cognome del padre, scrivendo ad es. Rossi2");
								$("#alertaggiungi").show();
								//$("#btn_cancel1").html('Chiudi');
								//$("#btn_goto1").show();
								//$("#btn_OK1").hide();
								return;
							} else {
								$.ajax(
								{
									url : "00qry_insertAnagrafica.php",
									type: "POST",
									data : postData,
									dataType: "json",
									success:function(data)
									{
										console.log(data.test1);
										$("#IDAnagraficaAppenaInseritaHidden").val(data.ID);
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
										alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##fname##'");      
									}
								});
							}
						},
						error: function(){
							alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##fname##'");      
						}
					});
				}
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno ##fname##'");      
			}
		});
	}

	function postToSchedaAlunnoNuovo() {
		let ID = $("#IDAnagraficaAppenaInseritaHidden").val();
		let nome = $('#nome_alu_new').val();
		let cognome = $('#cognome_alu_new').val();
		console.log (ID);
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
					if (data.sociomadre_fam == 1) {$("#sociomadre_fam_new").prop("checked", true);} else {$("#sociomadre_fam_new").prop("checked", false);}
					if (data.sociopadre_fam == 1) {$("#sociopadre_fam_new").prop("checked", true);} else {$("#sociopadre_fam_new").prop("checked", false);}
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno-aggiornaDatiFamigliaModal'");      
				}
			});
		} else {
			//se è stata selezionata una NUOVA famiglia allora i campi vanno puliti
			$("#nomemadre_fam_new").val("");
			$("#cognomemadre_fam_new").val("");
			$("#nomepadre_fam_new").val("");
			$("#cognomepadre_fam_new").val("");
			$("#telefonomadre_fam_new").val("");
			$("#telefonopadre_fam_new").val("");
			$("#emailmadre_fam_new").val("");
			$("#emailpadre_fam_new").val("");
			$("#sociomadre_fam_new").prop("checked", false);
			$("#sociopadre_fam_new").prop("checked", false);
		}
	}

	function aggiornaDatiFamigliaModalF() {
		//questa funzione serve SOLO a sparare nei campi del form modale i valori della famiglia, quando si seleziona dalla combobox, non salva dati in nessuna tabella
		//in questo senso è un "aggiornamento" del form "precario" perchè se poi non si salva, questi dati vengono persi
		let selectfamigliaTMP = document.getElementById("selectFamigliaF");
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
					$("#nomemadre_fam_newF").val(data.nomemadrefam);
					$("#cognomemadre_fam_newF").val(data.cognomemadre_fam);
					$("#nomepadre_fam_newF").val(data.nomepadre_fam);
					$("#cognomepadre_fam_newF").val(data.cognomepadre_fam);
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '06SchedaAlunno-aggiornaDatiFamigliaModalF'");      
				}
			});
		} else {
			//se è stata selezionata una NUOVA famiglia allora i campi vanno puliti
			$("#nomemadre_fam_newF").val("");
			$("#cognomemadre_fam_newF").val("");
			$("#nomepadre_fam_newF").val("");
			$("#cognomepadre_fam_newF").val("");
		}
	}

	function evidenziaQuale (){

		console.log ("funzione evidenziaQuale");
		resetBordi();
		datanascitatock =  moment($('#datanascita_tock').val(), "DD-MM-YYYY");
		fromdate ="01/01/1900";
		todate = "01/01/2100";
		$('#classeDiDestinazione').html("");
		let trovato = 0;
		for (i = 4; i < 17; i++) {
			fromdate = $('#datanascita'+i+'A').val();
			let fromdateM = moment(fromdate, "DD-MM-YYYY" );
			todate = $('#datanascita'+i+'B').val();
			let todateM = moment(todate, "DD-MM-YYYY" );
			//console.log (datanascitatock);
			//console.log (fromdateM);
			//console.log (todateM);

			if ((datanascitatock.isAfter(fromdateM-1)) && datanascitatock.isBefore(todateM+1)) {
				$('#datanascita'+i+'A').css("border", "2px solid red");
				$('#datanascita'+i+'B').css("border", "2px solid red");
				$('#eta'+i+'A').css("border", "2px solid red");
				$('#eta'+i+'B').css("border", "2px solid red");
				trovato = 1;
			}
		}
		if (trovato == 0){
			maxdate = $('#datanascita4B').val();
			let maxdateM = moment(maxdate, "DD-MM-YYYY" );
			mindate = $('#datanascita16A').val();
			let mindateM = moment(mindate, "DD-MM-YYYY" );
			if ((datanascitatock.isAfter(maxdateM))) {
				$('#classeDiDestinazione').html("troppo piccolo");
			}
			if ((datanascitatock.isBefore(mindateM))) {
				$('#classeDiDestinazione').html("troppo grande");
			}
		}
	}

	function resetBordi(){
		$('#classeDiDestinazione').html("");
		for (i = 4; i < 17; i++) {
			$('#datanascita'+i+'A').css("border", "1px solid grey");
			$('#datanascita'+i+'B').css("border", "1px solid grey");
			$('#eta'+i+'A').css("border", "1px solid grey");
			$('#eta'+i+'B').css("border", "1px solid grey");
		}
	}



</script>
