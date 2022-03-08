<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Anagrafica x Anno Scolastico</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<? $_SESSION['page'] = "Anagrafica x as";?>
</head>

<body>
	<? include("NavBar.php"); ?>
<!-- Titolo + select selezione anno e lista d'attesa + download ************************************************************ -->
	<div id="main" >
		<? include_once("assets/functions/lowreswarning.html"); ?>	
		<div class="upper highres">
			<div class="titoloPagina" >
				Anagrafica Alunni per classe
			</div>
			<div class="sottotitoloPagina" >
				(Elenco delle sole anagrafiche Alunni frequentanti, divise per anno scolastico)
			</div>
			<input id="data_limite_re_hidden" value = "<?=$_SESSION['data_limite_re']?>" hidden>
			<input id="primo_giorno_re_hidden" value = "<?=$_SESSION['primo_giorno_re']?>" hidden>
			<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>

			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
					<option value="DownloadExcelTutti">Tutti gli alunni + Famiglie</option>
					<option value="DownloadExcelFiltered">Alunni filtrati - tutti i dati</option>
					<option value="DownloadExcelFilteredMin">Alunni filtrati - dati minimi</option>
					<option value="DownloadExcelFilteredEGen">Alunni filtrati - dati minimi + Genitori</option>
					<option value="DownloadExcelFilteredASL">Alunni filtrati - per ASL Contagi</option>
					<option value="DownloadExcelEmail">e-mail</option>
					<option value="DownloadExcelElisa">Elisa</option>
					<option value="DownloadExcelRappresentanti">Rappresentanti</option>
					<option value="DownloadExcelStatisticaScuoleSucc">Statistica Scuole Successive</option>

					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div class="frameTopRight">

			</div>


			<div class="frameTopLeft">
				<div class="row mt5">
					<select name="selectannoscolastico"  style="width: 140px;"  id="selectannoscolastico" onchange="requery();">
							<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {?>
									<option value="<?=$alunno->annoscolastico_cla?>"
									<?
									if (isset ($_POST['annoscolasticoDaCruscotto'])) {
										if ($alunno->annoscolastico_cla == $_POST['annoscolasticoDaCruscotto']) {echo 'selected';}
									} else if ($alunno->annoscolastico_cla == $_SESSION['anno_corrente']) { 
										echo 'selected';
									}?>
									>
									<?=$alunno->annoscolastico_cla?>
									</option>
									
								<?=$alunno->annoscolastico_cla?></option>
							<?}?>
							<option value="all">Tutti gli anni scolastici</option>
					</select> 
					a.s.
				</div>

				<div class="row mt5">
					<select name="selectlistaattesa"  style=" width: 140px;"  id="selectlistaattesa" onchange="requery();">
						<option value="0" 	<? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == '0'  )){ echo 'selected';} else if (!(isset ($_POST['listaattesaDaCruscotto']))) { echo 'selected';} ?> >Nascondi lista d'attesa</option>
						<option value="1" 	<? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == '1'  )){ echo 'selected';}?> >Solo lista d'attesa</option>
						<option value="All" <? if (isset ($_POST['listaattesaDaCruscotto']) && ($_POST['listaattesaDaCruscotto'] == 'All')){ echo 'selected';}?>>Mostra Tutti</option>
					</select>
				</div>

			</div>

			<div class="frameTopLeftB">
				<div class="row mt5" style="padding-left: 8px;">
					<input type="checkbox" id="evidenzaAlunniNuovi" onchange ="aggiornaEvidenzaAlunniNuovi();"> Evidenzia Nuovi/Ritirati 
				</div>
				<div class="row mt5">
					<a id="mailtotutti" ><img href="" onclick="copyEmailsToTutti()" title="Invia Mail a tutti gli alunni selezionati" style="width: 25px; cursor: pointer" src='assets/img/Icone/envelope-regular.svg'></a>Invia mail 
				</div>
			</div>
			<div>
<!-- Table: etichette, filtri e pulsanti az ******************************************************************************** -->
				<table id="tabellaAnagraficaPerAnno" style="margin-top: 20px; margin-left: 50px;">
					<thead>
						<tr>
							<th style="width:38px;">
							</th>
							<th style="width:139px;">
								<input class="tablelabel4" type="text" id="nome_alu" name="nome_alu" value = "NOME" disabled style="width:139px;">
							</th>
							<th style="width:139px;">
								<input class="tablelabel4"  type="text" id="cognome_alu" name="cognome_alu" value = "COGNOME" disabled style="width:139px;">
							</th>
							<th style="width:144px;">
								<select name="selectcampo3" id="selectcampo3" onchange="requery();" style="width:144px;">
									<?$sel =1; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo4" id="selectcampo4" onchange="requery();" style="width:144px;">
									<?$sel =2; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo5"  id="selectcampo5" onchange="requery();" style="width:144px;">
									<?$sel =3; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo6" id="selectcampo6" onchange="requery();" style="width:144px;">
									<?$sel =6; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo7" id="selectcampo7" onchange="requery();" style="width:144px;">
									<?$sel =7; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo8" id="selectcampo8" onchange="requery();" style="width:144px;">
									<?$sel =12; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:144px;">
								<select name="selectcampo9" id="selectcampo9" onchange="requery();" style="width:144px;">
									<?$sel =11; include("01comboAnagrafica.php");?>
								</select>
							</th>
							<th style="width:34px;">
								<button type="button" id="btnPromuoviTutti" class="btnBlu" onclick="showModalPromuoviTutti();" >
								<img style="width: 20px; cursor: pointer;" title="Promuovi gli alunni selezionati..." src='assets/img/Icone/promuovi.svg' ></button>							
							</th>
						</tr>
						<tr>
							<th>
								<span id="conteggiorecord"></span>
							</th>
							<th>
								<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter1" name="filter1">				
							</th>
							<th>
								<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter2" name="filter2">				
							</th>
							<th>
								<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter3" name="filter3" <? if (isset ($_POST['classeDaCruscotto'])) {echo ("value = ".$_POST['classeDaCruscotto']);} ?>	>
							</th>
							<th>
								<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter4" name="filter4" <? if (isset ($_POST['sezioneDaCruscotto'])) {echo ("value = ".$_POST['sezioneDaCruscotto']);} ?>>
							</th>
							<th>
								<button id="ordinacampo5" class="ordinabutton" onclick="ordina(5);" >--</button>
								<input class="tablecell3 filtercell" type="text"  onchange="requery();" id="filter5" name="filter5" <? if (isset ($_POST['aselmeDaCruscotto'])) {echo ("value = ".$_POST['aselmeDaCruscotto']);} ?>>
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
							<th>
								<input id="allckbox" type="checkbox" onclick="ckboxtutti();" style="margin-left: 3px;">
							</th>
						</tr>
					</thead>
					<tbody class="scroll" id="maintable">
					</tbody>
				</table>
			</div>
		</div>		
	</div>

<!-- FORM MODALE PROMUOVI TUTTI ******************************************************************************************** -->
	<!--Questo modale lo tengo distinto da quelli base in quanto contiene non solo OK e Cancel e Password ma anche il radio button-->
	<div class="modal" id="modalPromuovi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">
					<img class="iconaWarning" src='assets/img/Icone/warning.svg' >
					<span class="titoloModal">ISCRIZIONE IN BLOCCO ALL'A.S. SUCCESSIVO</span>
					<div id="remove-contentmodalPromuovi" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<div id="message" style="margin-top: 15px;">
							Questa funzione iscrive gli/le alunni/e selezionati/e<br>all'anno scolastico successivo.<br><br>Gli/le alunni/e selezionati/e:
						</div>
						
						<div  class="col-sm-12" id="optionsContainer" style="margin-top: 15px; ">
							<div class="col-sm-6" >
								<input type="radio" id="aumenta" name="tipopromozione" value="aumenta" selected>
								<br>
								<label for="aumenta">vanno iscritti/e alla classe successiva<br><br>e quelli/e dell'asilo alla prima</label>
							</div>
							<div class="col-sm-6" style= "border-left: 1px solid grey;">
								<input type="radio" id="mantieni" name="tipopromozione" value="mantieni">
								<br>
								<label for="mantieni">vanno re-iscritti/e alla stessa classe<br><br><span class="smalltext">da utilizzare SOLO per iscrivere<br>nuovamente in asilo<br>Iscrivere individualmente<br>eventuali bocciati della primaria e secondaria</span></label>
							</div>
						</div>
						
						<div class= "row" >
							Inserire la password e dare conferma:
						</div>
						<div id="passwordContainer" class="mt10">
							
							<input type="password" id="passwordPromuovi">
						</div>
						<br>
					</div> <!-- END REMOVE CONTENT -->
					<textarea class="mt10" style="width: 90%; height: 90px;" id="statusInserimenti">
						
					</textarea>

					<div class="alert alert-danger" id="alertModalPromuovi" style="display:none; margin-top:10px;">
							<h4 id="alertmsgModalPromuovi" style="text-align:center;"> 
							  
							</h4>
						</div>
					<div class="modal-footer">
						<button type="button" id="btn_cancelModalPromuovi" class="btnBlu" style="width:40%;" data-dismiss="modal" >Annulla</button>
						<button type="button" id="btn_OKModalPromuovi" class="btnBlu" style="width:40%;" >OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE PROMUOVI TUTTI *************************************************************************************** -->


</body>
</html>

<script>

	
	$(document).ready(function(){
		resetResolution();
		//ecco il default delle selezioni
		//PopolaSelect ("selectcampo3", 1);
		//PopolaSelect ("selectcampo4", 2);
		//PopolaSelect ("selectcampo5", 4);
		//PopolaSelect ("selectcampo6", 6);
		//PopolaSelect ("selectcampo7", 7);
		//PopolaSelect ("selectcampo8", 11);
		//PopolaSelect ("selectcampo9", 12);
		requery();
	});
	
	function PopolaSelect(selectnome, selected_n) {
		postData = { selected_n: selected_n};
		$.ajax({
			type: 'POST',
			url: "01qry_elencoOpzioni.php",
			async: false,
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#"+selectnome).html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '01AnagraficaPerAnno ##fname##'");      
			}
			
		});
	}
	
	function resetResolution () {
		let offset = $("#tabellaAnagraficaPerAnno > tbody").offset();
		$('#tabellaAnagraficaPerAnno > tbody').css('max-height', (($(window).height())-offset.top-30)+'px');
	}
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery();
	}
	
	function requery(){
		//cancello la selezione eventuale di tutti i record
		$("#allckbox").prop('checked', false);

		const campo = [];
		const ord = [];
		const fil = [];
		campo[1] = "nome_alu";
		campo[2] = "cognome_alu";
		for (i = 3; i <= 9; i++) {
			campo[i] = $( "#selectcampo"+i+" option:selected" ).val();
		}
		for (i = 1; i <= 9; i++) {
			ord[i] = $('#ordinacampo'+i).text();
		}
		for (i = 1; i <= 9; i++) {
			fil[i] = $('#filter'+i).val();
		}
		
		//PER CORONCINE ANNO DEL RE
		//individuo il primo campo in cui sia mostrata la data di nascita in quanto qui andro' a mostrare la coroncina dell'anno del re
		campodata = 0;
		for (i = 3; i <= 9; i++) {
			if (campo[i] =='datanascita_alu') {campodata = i;  break; }
		}
		//passo inoltre le date limite estratte dalla tabella parametri (ed inserite in due input di tipo hidden),
		//perchè serviranno per stabilire se nel campo data mettere la coroncina
		let data_limite_re = $('#data_limite_re_hidden').val();
		let primo_giorno_re = $('#primo_giorno_re_hidden').val();


		//altre variabili necessarie
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();
		let selectlistaattesa = document.getElementById("selectlistaattesa");
		let listaattesa = selectlistaattesa.options[selectlistaattesa.selectedIndex].value;



		postData = { campo: campo, ord: ord, fil: fil, annoscolastico_cla: annoscolastico_cla,  listaattesa: listaattesa, campodata: campodata, data_limite_re: data_limite_re, primo_giorno_re: primo_giorno_re};
		//console.log ("01AnagraficaPerAnno - requery - postData a 01qry_AnagraficaPerAnno.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "01qry_AnagraficaPerAnno.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
				aggiornaEvidenzaAlunniNuovi();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '01AnagraficaPerAnno ##fname##'");      
			}
		});
	}

	function showModalPromuoviTutti() {
			$("#statusInserimenti").html("");
			$("#btn_OKModalPromuovi").attr("onclick","promuoviTutti();");
			$("#btn_OKModalPromuovi").show();
			$("#btn_cancelModalPromuovi").html('Annulla');
			$("#remove-contentmodalPromuovi").show();
			$("#alertModalPromuovi").removeClass('alert-success');
			$("#alertModalPromuovi").addClass('alert-danger');
			$("#alertModalPromuovi").hide();
			$("#passwordPromuovi").val("");
			$('#modalPromuovi').modal({show: 'true'});
	}

	function promuoviTutti(){

		totIscritti= 0;
		totNonIscrittiPerAltreRagioni = 0;
		totNonIscrittiPerUltimoAnno = 0;
		totGiaIscritti = 0;
		totProcessati = 0;
		let psw = $("#passwordPromuovi").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertModalPromuovi").removeClass('alert-success');
			$("#alertModalPromuovi").addClass('alert-danger');
			$("#alertmsgModalPromuovi").html('Password Errata!');
			$("#alertModalPromuovi").show();
		} else {
			var radioValue = $("input[name='tipopromozione']:checked").val();
			asilosuasilo=2;
			switch (radioValue) {
				case "mantieni" :
					//caso ASILO
					asilosuasilo=0;
					break;
				case "aumenta" :
					//caso PROMOZIONE a CLASSE SUCCESSIVA
					asilosuasilo=1;
					break;
				default :
					//caso NON FARE NULLA
					asilosuasilo=2;
			}
			console.log("asilosuasilo", asilosuasilo);
			if (asilosuasilo==2) {
				$("#alertModalPromuovi").removeClass('alert-success');
				$("#alertModalPromuovi").addClass('alert-danger');
				$("#alertmsgModalPromuovi").html('Selezionare una delle due opzioni');
				$("#alertModalPromuovi").show();
			} else {
				let i;
				  //console.log ("01AnagraficaPerAnno - promuoviTutti - contarecord_hidden");
				  //console.log ($("#contarecord_hidden").val());

				//verifico che almeno uno degli alunni visibili sia selezionato, se nessuno lo è fermo tutto
				noselection = true;
				for (i = 1; i < (parseInt($("#contarecord_hidden").val())+1); i++) {
					if ($('#'+i+"ck").prop('checked')) {						
						noselection = false;
					}
				}
				if (noselection) {
					$("#alertModalPromuovi").removeClass('alert-success');
					$("#alertModalPromuovi").addClass('alert-danger');
					$("#alertmsgModalPromuovi").html('Non ci sono alunni selezionati');
					$("#alertModalPromuovi").show();
					return;
				}


				//devo estrarre l' "ultima classe"
				$.ajax({
					type: 'POST',
					url: "01qry_getMaxClassi.php",
					dataType: 'json',
					success: function(data){
						maxOrdcls = parseInt(data.maxOrd_cls);

						//almeno uno è selezionato, procedo dunque a promuovere quelli selezionati
						for (i = 1; i < (parseInt($("#contarecord_hidden").val())+1); i++) {

							if ($('#'+i+"ck").prop('checked')) {			
								totProcessati++;			
								nomeinput = $('#'+i+"ck").attr('name');
								// console.log ("01AnagraficaPerAnno - promuoviTutti - trovo selezionato l'alunno con id nel campo ck:");
								// console.log ("i="+i+":"+nomeinput);
								//a questo punto posso effettuare la promozione per ciascuno
								//nomeinput contiene  00zzyyyy-yy-ck-00nn-cls-zS
								//dove 00zz rappresenta il valore di ID_asc (ID nella tabella anniscolastici) dell'anno scolastico del record, padded ( serve per trovare l'a.s. successivo nella pagina php 01qry_Promuovi.php richiamata))
								//yyyy-yy è l'anno scolastico CORRENTE (serve solo per verifica di ID_asc in fase debug, poi si potrebbe togliere)
								//00nn è ID_alu padded (usare parseInt per fare l'unpad in js - o intval in php).
								//z è ord_cls estratto dalla tab_classi
								//S è la sezione
								//
								//si estrae e passa ord_cls a 01qry_Promuovi.php ed è facile inserire la classe "+1" (salvo che non sia una VIII)...per il bambino corrente
								//gli unici per i quali non posso sono i bambini dell'asilo in quanto potrebbero essere in asilo anche l'anno successivo (infatti scrivevo da 2 a 8, esclusi 1=ASILO e 9=VIII)
								//devo decidere se quelli flaggati sono quelli da promuovere o quelli da NON promuovere.
								ID_asc = parseInt(nomeinput.substr(0, 4), 10); 				//è l'id dell'anno scolastico e serve per estrarre l'anno successivo
								annoscolastico = nomeinput.substr(5, 7); 					//serve solo per mostrarlo in console.log
								ID_alu = parseInt(nomeinput.substr(16,4), 10); 				//è l'ID_alu ...parseInt dovrebbe togliere gli zeri...
								ord_clsold = parseInt(nomeinput.substr(26, 1),10);			//ord_cls estratto dalla stringa
								sezione_cla = nomeinput.substr(27, 1);						//sezione classe
								console.log ("01AnagraficaPerAnno.php - promuoviTutti - estrazione dei parametri da passare a 01qry_Promuovi.php");
								console.log("i="+i+": ID anno scolastico = "+ID_asc);
								console.log ("i="+i+": anno scolastico = "+annoscolastico);
								console.log("i="+i+": ID alunno = "+ID_alu);
								console.log("i="+i+": ordine classe old = "+ord_clsold);
								console.log("i="+i+": sezione = "+sezione_cla);
								ID_asc =  ID_asc +1;
								//ordclsold è ord_cls estratto per la classe CORRENTE: quindi
								// 0 per nido (se c'è)
								// 1 per asilo
								// 2 per la prima
								// 3 per la seconda e così via
								// ...
								// 9 per l'ottava

								//asilosuasilo vale 0 per iscrizione a stesso anno e 1 per iscrizione a anno successivo

								ord_cls = ord_clsold + asilosuasilo; //in questo modo se è stata indicata la A (reiscrizione all'asilo) non c'è la 'promozione' ma solo la 'reiscrizione'. E nel caso si siano selezionate delle classi el o me e indicata la A non dovrebbe fare nulla. Invece se si è indicata la S (promozione), la classe è quella successiva in quanto asilosuasilo = 1
								console.log ("ordcls dopo che ord_cls = ord_clsold + asilosuasilo", ord_cls);
								//quindi ord_cls ora varrà IN CASO DI PROMOZIONE

								// 3 per il passaggio in seconda classe
								// 4 per il passaggio in terza classe
								//....
								// 10 per il passaggio in nona classe

								

										
								// data.maxOrd_cls contiene il valore massimo di ord_cls nella tabella classi: 14 per la XIII (5 superiore), 9 per l'VIII (3 media)
								
								if (ord_cls >= (maxOrdcls + 1) ) {

									totNonIscrittiPerUltimoAnno++;
								
								} else if (ord_clsold > 1 && asilosuasilo == 0) { 
									//caso in cui si cerchi di promuovere ragazzi dall'VIII classe oppure si cerchi di reiscrivere bambini a classi uguali non essendo in asilo

									totNonIscrittiPerAltreRagioni++;

								} else {
									//console.log("prima del passaggio a qryPromuovi i è ="+i+":");
									postData = { ID_asc : ID_asc, ID_alu: ID_alu, ord_cls: ord_cls, sezione_cla: sezione_cla};
									$.ajax({
										async: false,
										type: 'POST',
										url: "01qry_Promuovi.php",
										data: postData,
										dataType: 'json',
										success: function(data){
											//con i dati di ritorno vado a sua volta a chiamare la qry_insertAnnoScolastico che dovrebbe in teoria procedere alla iscrizione all'anno successivo senza blocchi.
											//l'unico caso in cui non procederà sarà l'iscrizione di un alunno delle elementari o delle medie al medesimo anno (caso in cui uno abbia risposto di mantenere nella stessa classe ma selezionando bambini non dell'asilo: la routine qry_insertAnnoScolastico infatti non inserisce nuovamente bambini alle EL o ME allo stesso anno salvo che si indichi che è bocciato)
											ID_alu_cla_new = data.ID_alu;
											annoscolastico_asc_new = data.annoscolastico_asc;
											classe_cla_new = data.classe_cla;
											sezione_cla_new = data.sezione_cla;
											if (classe_cla_new == "I" && radioValue == "aumenta") {sezione_cla_new = "A";}
											bocciato = false;
											A= ("i="+i+":"+"iscriverò l'alunno con ID_alu_cla "+ID_alu_cla_new);
											B= (" per l'a.s. "+annoscolastico_asc_new);
											C= (" alla classe "+classe_cla_new);
											D= (" sezione "+sezione_cla_new);
											console.log (A+B+C+D);
											//ATTENZIONE!!! ERA 01qry_insertAnnoScolastico.php *******
											//Ho voluto tenere SOLO la 06qry_InsertAnnoScolastico.php per ridurre
											//il numero di file e non avere due ROUTINE IDENTICHE
											//se non funzionasse ripristinare la 01...messa nei backup da tenere
											postData2 = { ID_alu_cla : ID_alu_cla_new, annoscolastico_asc: annoscolastico_asc_new, classe_cla: classe_cla_new, sezione_cla: sezione_cla_new, bocciato: bocciato};
											//console.log ("01AnagraficaPerAnno.php - promuoviTutti(): postData2 a 06qry_insertAnnoScolastico", postData2);

												$.ajax({
												async: false, 
												type: 'POST',
												url: "06qry_insertAnnoScolastico.php",
												data: postData2,
												dataType: 'json',
												success: function(data){	
													console.log ("processato/a alunno/a con ID "+data.ID_alu_cla+" per a.s. "+data.annoscolastico_asc+" a classe "+data.classe_cla+" sezione "+data.sezione_cla);
													console.log ("esito:", data.result);

													if (data.result == 'OK') {
														totIscritti++;
													}

													if (data.result != 'OK') {
														totGiaIscritti++;
													}




													
												},
												error: function(){
													alert("Errore: contattare l'amministratore fornendo il codice di errore '01AnagraficaPerAnno ##fname##'");      
												}
											});
										},
										error: function(){
											alert("Errore: contattare l'amministratore fornendo il codice di errore '01AnagraficaPerAnno ##fname##'");      
										}
									});
								}
							}
						}


						finalMsg ="ALUNNI PROCESSATI: " + totProcessati + "\nIscritti all'a.s. successivo: "+totIscritti+"\nNon iscritti in quanto già iscritti all'a.s. successivo: "+totGiaIscritti+"\nNon iscritti in quanto iscritti all' ultima classe: "+totNonIscrittiPerUltimoAnno+"\nNon iscritti per altre ragioni: "+totNonIscrittiPerAltreRagioni;
						$("#remove-contentmodalPromuovi").slideUp();
						$("#statusInserimenti").html(finalMsg);
						$("#btn_cancelModalPromuovi").html('Chiudi');
						$("#btn_OKModalPromuovi").hide();


					}
				});
			}
		}
	}
	//IMPORTANTE: SEMBRA CHE VENGA PRIMA ESEGUITA N VOLTE LA PARTE FINO ALLA CHIAMATA DI 01qry_Promuovi.php e SOLO DOPO VENGANO LANCIATE LE PROMOZIONI VERE E PROPRIE!!!!!!!!
	//E' IMPORTANTE DA SAPERE PERCHE' L'ORDINE IN CUI VENGONO FATTE LE COSE E' BIZZARRO!!!

	function ckboxtutti (){
		for (i = 1; i < (($("#contarecord_hidden").val())+1); i++) {
			$('#'+i+"ck").prop("checked", $("#allckbox").prop('checked'));
		}
	}
	
	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelTutti() {
		let annoscolastico_cla = $("#selectannoscolastico").val();
		window.location.href='01downloadAnPerAnno.php?annoscolastico_cla='+annoscolastico_cla;
	}
	
	function DownloadExcelFiltered (){
		let annoscolastico_cla = $("#selectannoscolastico").val();
		let sql_hidden = $("#sql_hidden").val();
		//console.log (sql_hidden);
		window.location.href='01downloadAnPerAnno.php?annoscolastico_cla='+annoscolastico_cla+'&where='+sql_hidden;
	}
	
	function DownloadExcelFilteredMin (){
		let annoscolastico_cla = $("#selectannoscolastico").val();
		let sql_hidden = $("#sql_hidden").val();
		window.location.href='01downloadAnPerAnnoMin.php?annoscolastico_cla='+annoscolastico_cla+'&where='+sql_hidden;
	}

	function DownloadExcelFilteredEGen (){
		let annoscolastico_cla = $("#selectannoscolastico").val();
		let sql_hidden = $("#sql_hidden").val();
		window.location.href='01downloadAnPerAnnoMinEGen.php?annoscolastico_cla='+annoscolastico_cla+'&where='+sql_hidden;
	} 

	function DownloadExcelElisa() {
		let annoscolastico_cla = $("#selectannoscolastico").val();
		window.location.href='01downloadAnPerAnnoElisa.php?annoscolastico_cla='+annoscolastico_cla;
	}

	function DownloadExcelEmail() {
		let annoscolastico_cla = $("#selectannoscolastico").val();
		window.location.href='01downloadEmail.php?annoscolastico_cla='+annoscolastico_cla;
	}

	function DownloadExcelFilteredASL (){
		let annoscolastico_cla = $("#selectannoscolastico").val();
		let sql_hidden = $("#sql_hidden").val();
		//console.log (sql_hidden);
		window.location.href='01downloadAnPerASL.php?annoscolastico_cla='+annoscolastico_cla+'&where='+sql_hidden;
	}

	function DownloadExcelRappresentanti() {
		let annoscolastico_cla = $("#selectannoscolastico").val();
		window.location.href='01downloadRappresentanti.php?annoscolastico_cla='+annoscolastico_cla;
	}

	function DownloadExcelStatisticaScuoleSucc() {
		window.location.href='01downloadStatisticaScuoleSucc.php';
	}


	function aggiornaEvidenzaAlunniNuovi() {
		let checkBox = document.getElementById("evidenzaAlunniNuovi");
		if (checkBox.checked == true){
			$(".alunnoritirato").css("background-color", "red").css("color", "white");
			$(".alunnonuovo").css("background-color", "#10a03c").css("color", "white");
		} else {
			$(".alunnoritirato").css("background-color", "").css("color", "");
			$(".alunnonuovo").css("background-color", "").css("color", "");
		}
	}
	
	
</script>
