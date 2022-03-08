<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
	include_once("classi/alunni.php");
	?>
	

<!DOCTYPE html>
<html>
<head>
	<title>Quote Per Alunno</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

	<!-- PRESO DA WG-->
	<script src="assets/moment/moment.js" type="text/javascript"></script>
	<!-- <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script> -->
	<script src="assets/datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>

	<? $_SESSION['page'] = "Quote Mensili per Alunno";?>
</head>

<body>
	<? include("NavBar.php"); ?>
	<div id="main" >

		<? include_once("assets/functions/lowreswarning.html"); ?>
<!-- IMPOSTAZIONE VARIABILI HIDDEN + DOWNLOAD + SELECT ANNO ***************************************************** -->
		<div class="upper highres">
			<!--<span onclick="openNav();"><img style="padding-top: 5px; padding-left: 5px;" src="assets/img/menu.png"></span>-->
			<div id="titolopagina" class="titoloPagina" >
				Quote mensili per Alunno
			</div>
			<div class="ml250">
				<input id="quote_fratelli_diverse" 	value="<?=$_SESSION['quote_fratelli_diverse']?>"	hidden>
				<input id="pswOperazioni1" 			value="<?=$_SESSION['pswOperazioni1']?>" 			hidden>
				<input id="pswOperazioni0" 			value="<?=$_SESSION['pswOperazioni0']?>" 			hidden> <!-- PASSWORD DI MASSIMO LIVELLO -->
				<input id="seqMesiDefault" 			value="<?=$_SESSION['seqMesiDefault']?>" 			hidden> <!-- SEQUENZA MESI DEFAULT PER CALCOLO TUTTE QUOTE -->
				<?$seqMesiDefault = $_SESSION['seqMesiDefault']?>
				<?$mesiA = ["G", "F", "M", "A", "M", "G", "L", "A", "S", "O", "N", "D"];?>
			</div>
			<div class="frameXlDownload">
				<div class="row center">
					download excel
				</div>
				<div>
					<select class="selectXl" id="selectDownloadExcel">
						<option value="DownloadExcelRette">Tutte le Rette</option>
					</select>
					<img onclick="DownloadExcel()" class="miniButtonXl" src='assets/img/Icone/logoexcel2019.svg'>
				</div>
			</div>

			<div class="frameTopLeft">
				<div class="row mt5">
					<select name="selectannoscolastico"  style="width: 140px;"  id="selectannoscolastico" onchange="requery(1);">
						<?foreach (GetArrayAnniScolasticiFrequentati() as $alunno) {
						?> <option value="<? echo ($alunno->annoscolastico_cla) ?>"
						<?
						if (isset ($_POST['annoscolasticoDaRettePerFamiglia'])) {
							if ($alunno->annoscolastico_cla == $_POST['annoscolasticoDaRettePerFamiglia']) { echo 'selected';}
						} else if ($alunno->annoscolastico_cla == $_SESSION['anno_corrente']) { echo 'selected';}	?>><? echo ($alunno->annoscolastico_cla) ?></option><?
						}?>
					</select>
					a.s.
				</div>

				<div class="row mt5">
					<select name="selectlistaattesa"  style="width: 140px;"  id="selectlistaattesa" onchange="requery(1);">
						<option value="0" selected>Nascondi lista d'attesa</option>
						<option value="1">Solo lista d'Attesa</option>
						<option value="All">Mostra Tutti</option>
					</select>
				</div>

			</div>
			

<!-- INTESTAZIONI TABELLA *************************************************************************************** -->
			<table id="tabellaRette" style= "table-layout: fixed; width: 95%; margin-top: 30px; margin-left: 55px;">
				<thead>
					<tr>
						<th style="width: 3%;">	
						</th>
						<th style="width: 6%;">
							<input class="tablelabel2" type="text" value = "NOME" disabled>
						</th>
						<th style="width: 6%;">
							<input class="tablelabel2" type="text" value = "COGNOME" disabled>
						</th>
						<th style="width: 3%;">
							<input class="tablelabel2"  type="text" value = "CLASSE" disabled>
						</th>
						<th style="width: 4%;">
							<input class="tablelabel2" type="text" value = "SEZ" disabled>
						</th>
						<th style="width: 3.5%;">
							<!-- <span style="margin-left: 1px;">D</span><span style="margin-left: 7px;">C</span><span style="margin-left: 7px;">P</span><span style="margin-left: 7px;">dt</span><br> -->
							<span style="margin-left: 1px;">D</span><span style="margin-left: 7px;">C</span><span style="margin-left: 7px;">P</span><br>
							<input type="checkbox"  onchange="mostraNascondi('D');" id="ckD" name="CkD" checked>
							<input type="checkbox"  onchange="mostraNascondi('C');" id="ckC" name="CkC" checked>
							<input type="checkbox"  onchange="mostraNascondi('P');" id="ckP" name="CkP" checked>
							<!-- <input type="checkbox"  onchange="mostraNascondi('PD');" id="ckPD" name="CkPD" checked> -->
						</th>
						<th style="width: 2.1%;">
						<button style="width: 20px; padding: 0px;" data-toggle="modal" onclick="showModalCalcolaTutteQuote();">
							<img title="Calcola Tutte le Quote..." style="width: 15px; cursor: pointer;" src='assets/img/Icone/magic-solid-grey.svg'>
							</button>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" style="background-color: green" type="text" value = "altro" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "SET" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "OTT" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "NOV" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "DIC" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "GEN" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "FEB" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "MAR" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "APR" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "MAG" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "GIU" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "LUG" disabled>
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "AGO" disabled>
						</th>
						<th style="width: 1%;">
						</th>
						<th style="width: 2.4%;">
							<input class="tablelabel2" type="text" value = "TOT" disabled>
						</th>
					</tr>
					<tr>
						<th>
							<span id="conteggiorecord"></span><span id="righeperpagina" hidden></span>
						</th>
						<th>
							<button id="ordinacampo1" class="ordinabutton" onclick="ordina(1);" style="font-size:8px">--</button>
							<input class="tablecell3 filtercell2" type="text"  onchange="requery(1);" id="filter1" name="filter1">				
						</th>
						<th>
							<button id="ordinacampo2" class="ordinabutton" onclick="ordina(2);" style="font-size:8px">--</button>
							<input class="tablecell3 filtercell2" type="text"  onchange="requery(1);" id="filter2" name="filter2" <? if (isset ($_POST['cognomeDaRettePerFamiglia'])) {echo ("value = ".$_POST['cognomeDaRettePerFamiglia']);} ?>>				
						</th>
						<th>
							<button id="ordinacampo3" class="ordinabutton" onclick="ordina(3);" style="font-size:8px">--</button>
							<input style="width: 50%;" class="tablecell3 filtercell2" type="text"  onchange="requery(1);" id="filter3" name="filter3">
						</th>
						<th>
							<button id="ordinacampo4" class="ordinabutton" onclick="ordina(4);" style="font-size:8px">--</button>
							<input class="tablecell3 filtercell2" style="width: 50%;" type="text"  onchange="requery(1);" id="filter4" name="filter4">
						</th>
						<th>
						</th>
						<th>
						</th>
						<th>
						</th>
						<th colspan="4">

						</th>
						<!-- <th colspan="2"> -->
							<? //if ($_SESSION['inviodatirette_altrisistemi'] == 1) {?>
								<!-- <button type="button" id="btnResetInvii" class="btnBlu w100" onclick="resetInvii()">Reset Invii</button> -->
							<?//}?>	
						<!-- </th> -->
						<th>
						</th>


						<th colspan="7" style= "text-align: right;">
							<button id="mostradettaglio" onclick="moveFirst();"><img style="width: 15px; cursor: pointer;" src='assets/img/Icone/angle-double-left-solid.svg'></button>
							<button id="mostradettaglio" onclick="movePage(-1);"><img style="width: 15px; cursor: pointer;" src='assets/img/Icone/chevron-left-solid.svg'></button>
							<input id="numeroPagina" class="tablecell" style="width: 8%; margin-left: 3px; margin-right: 3px; text-align: center;" type="text"  hidden>
							<input id="pag_tot" class="tablecell" style="width: 15%; margin-left: 3px; margin-right: 3px; text-align: center;" type="text"  disabled>
							<button id="mostradettaglio" onclick="movePage(1);"><img style="width: 15px; cursor: pointer;" src='assets/img/Icone/chevron-right-solid.svg'></button>
							<button id="mostradettaglio" onclick="moveLast();"><img style="width: 15px; cursor: pointer;" src='assets/img/Icone/angle-double-right-solid.svg'></button>
						</th>
						<th>
						</th>
						<th class="center">
							<? if ($_SESSION['inviodatirette_altrisistemi'] == 1) {?>
								<button type="button" title="Esporta per contabilità" id="btnResetInvii" class="btnBlu w90 " onclick="showModalExportPagamenti()"> <img class="iconaStd" src='assets/img/Icone/export-white.svg'></button>
							<?}?>
						</th>
					</tr>
				</thead>
				<tbody class="scroll" id="maintable">
				</body>
			</table>
		</div>		
	</div>

<!-- FORM MODALE CALCOLO QUOTE *************************************************************************************** -->

	<div class="modal" id="modalMostraQuoteCalcolate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">Calcolo quote di default per</span>
					<br>
					<span class="titoloModal" id="NomeCognomeAlu" style="width:50%; font-size: 20px; "></span>
					<br>
					<div id="remove-content2" style="text-align: center; margin-top: 20px;"> <!-- START REMOVE CONTENT -->
					<input id="ID_alu_hidden" type="text" hidden>
						<?if ($_SESSION['quote_fratelli_diverse'] == 'si') {?>
							<div>
								La famiglia dell'alunno/a nell'a.s. selezionato ha iscritto
								
							</div>
							<div>
								<!-- <input id="test" style= "text-align: center; width: 50%;" class="tablecell maintable disab" type="text" disabled><br>
								<span id="test"></span> -->
								<input id="NumeroFratelli" style= "text-align: center; width: 5%;" class="tablecell disab" type="text" disabled><br>
								fratelli<span id="ResponsoFratelli"></span> pertanto
							</div>
						<?}?>
						<br>
						<div>
							l'iscrizione in classe
						</div>
						<div>
							<input id="Classe" style= "text-align: center; width: 10%;" class="tablecell disab" type="text" disabled>
						</div>
						<div>
							comporta una quota annuale di Default di euro
						</div>
						<div>
							<input id="QuotaAnno" style= "text-align: center; width: 10%;" class="tablecell disab" type="text" onchange="RicalcolaRateMensili();">
						</div>
						<div>
							e per ogni rata sui seguenti mesi
						</div>

						<table class="ma">
							<tr>

								<?for ($x = 8; $x <= 11; $x++) {?>
									<td class="w5 center">
										<?echo($mesiA[$x]);?><input type="checkbox" class="tablecell5 ckMeseSingolo" id="meseRipartizioneSingolo<?=($x+1)?>" <? if (substr($seqMesiDefault, $x, 1) == 1) {echo ("checked");}?>>
									</td>
								<?}?>
								<?for ($x = 0; $x <= 7; $x++) {?>
									<td class="w5 center">
										<?echo($mesiA[$x]);?><input type="checkbox" class="tablecell5 ckMeseSingolo" id="meseRipartizioneSingolo<?=($x+1)?>" <? if (substr($seqMesiDefault, $x, 1) == 1) {echo ("checked");}?>>
									</td>
								<?}?>
							</tr>
						</table>


						<!-- <div class="row mt5">
							<div class="col-12">
								<div class="col-md-3 col-md-offset-3" >
									<input id="Rate" style= "text-align: center; width: 30%;" class="tablecell disab" type="text" value="10" onchange="RicalcolaRateMensili();"> <br>rate
								</div>
								<div class="col-md-3" >
									<input type="checkbox" class="tablecell5" id="treratetrimestrali_ck" name="treratetrimestrali_ck" onclick="checkTreRate();"> <br>3 rate<br>(Ott, Gen, Apr)
								</div>
							</div>
						</div> -->


						<div>
							 di euro
						</div>
						<div>
							<input id="QuotaMese" style= "text-align: center; width: 10%;" class="tablecell disab" type="text" disabled>
						</div>
						<br>

						<div>
							Di seguito la quota concordata
						</div>
						<div>
							<input id="QuotaConcordata" style= "text-align: center; width: 10%;" class="tablecell disab" type="text" onchange="RicalcolaRateMensili();">
						</div>
						<div>
							E la quota concordata per ogni rata
						</div>
						<div>
							<input id="QuotaMeseConcordata" style= "text-align: center; width: 10%;" class="tablecell disab" type="text" disabled>
						</div>
						<div>
							Quota concordata già presente: non applicare <input id="ckConcordataNo" style= "text-align: center; width: 10%;" class="tablecell disab" type="checkbox">
						</div>
					</div> <!-- END REMOVE CONTENT -->
					<div class="alert alert-success" id="alerteliminaAS" style="display:none; margin-top:10px;">
						<h4 style="text-align:center;"> 
						Disiscrizione completata con successo!</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn_cancel2" class="btnBlu pull-left" style="width:40%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OK2" class="btnBlu pull-right" style="width:40%;" onclick="ApplicaRateCalcolate();">Applica e Salva</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- FINE FORM MODALE CALCOLO QUOTE *************************************************************************************** -->

<!-- FORM MODALE CALCOLO TUTTE QUOTE *************************************************************************************** -->
	<div class="modal" id="modalCalcolaTutteQuote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<img class="iconaWarning" src='assets/img/Icone/warning.svg' >
					<span class="titoloModal">Calcolo quote di default per tutti gli alunni</span>
					
					<div id="remove-contentTutteQuote" style="text-align: left; margin-top: 20px; margin-left: 50px; "> <!-- START REMOVE CONTENT -->
						Questa routine è molto RISCHIOSA in quanto  per l'anno selezionato:
						<br>
						1. Calcola per ciascun alunno  attualmente filtrato la quota annuale e la distribuisce<br>nei mesi secondo questa sequenza di default (qui modificabile)
						<br>
						<table class="ma w90">
							<tr>
								<td class="center bordered" colspan="12">
									MESI (da Set. a Ago.)
								</td>	
							</tr>
							<tr>
								<?for ($x = 8; $x <= 11; $x++) {?>
									<td class="w5 center">
										<?echo($mesiA[$x]);?><input type="checkbox" class="tablecell5" id="meseRipartizione<?=($x+1)?>" <? if (substr($seqMesiDefault, $x, 1) == 1) {echo ("checked");}?>>
									</td>
								<?}?>
								<?for ($x = 0; $x <= 7; $x++) {?>
									<td class="w5 center">
										<?echo($mesiA[$x]);?><input type="checkbox" class="tablecell5" id="meseRipartizione<?=($x+1)?>" <? if (substr($seqMesiDefault, $x, 1) == 1) {echo ("checked");}?>>
									</td>
								<?}?>
							</tr>
						</table>
						2. Salva nel database le quote così distribuite
						<br>
						3. Imposta le quote concordate nella stessa maniera
						<br>
						4. Imposta a ZERO tutte le quote pagate nell'anno (!)
						<br>
						<br>
						Tutto ciò CANCELLA ogni input precedente per questo anno scolastico.
						<br>
						<br>
						VERIFICARE CHE L'ANNO PER IL QUALE SI STA OPERANDO <br>
						(quello selezionato nella casella a discesa in alto a sx)
						<br>SIA QUELLO DESIDERATO.
						<br>
						E' FORTEMENTE CONSIGLIATO un backup preventivo del database nel vostro PC!

						<div class="w200px mrl-a mb20">
							<button type="button" class="btnBlu" style="width:100%; margin-top: 20px;" data-dismiss="modal" onclick="backupDB('A');">Backup Database</button>
						</div>

						<div class="row">
							Inserire la password di MASSIMO livello e confermare
							<input type="password" id="passwordTutteQuote">
						</div>



					</div> <!-- END REMOVE CONTENT -->

					<textarea class="mt10" style="width: 90%; height: 80px;" id="statusInserimenti">
						
					</textarea>
					<div class="alert alert-success" id="alertTutteQuote" style="display:none; margin-top:10px;">
						<h4 style="text-align:center;" id="alertmsgTutteQuote"> 
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn_cancelTutteQuote" class="btnBlu" style="width:40%;" onclick="requery(1);" data-dismiss="modal">Chiudi</button>
						<button type="button" id="btn_OKTutteQuote" class="btnBlu" style="width:40%;" onclick="calcolaTutteQuote();">Vai!</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE CALCOLO TUTTE QUOTE *************************************************************************************** -->

<!-- FORM MODALE PAGAMENTI *************************************************************************************** -->

	<div class="modal" id="modalPagamenti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal" id="titoloModalPagamenti">Pagamenti della retta</span>
					
					<div id="remove-contentModalPagamenti" class="mt20 mb10" style="text-align: center;"> <!-- START REMOVE CONTENT -->
						<div id="TabellaPagamenti">
						</div>
					</div> <!-- END REMOVE CONTENT -->

					<div class="alert alert-success" id="alertModalPagamenti" style="display:none; margin-top:10px;">
						<h4 style="text-align:center;" id="alertmsgModalPagamenti"> 
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn_CancelModalPagamenti" class="btnBlu" style="width:40%;" onclick="requerySamePage();" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKModalPagamenti" class="btnBlu" style="width:40%;" onclick="salvaNuovoPagamento();">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE PAGAMENTI *************************************************************************************** -->

<!-- FINE FORM MODALE ESPORTAZIONE QUOTE *************************************************************************************** -->
	<div class="modal" id="modalExportQuote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal" id="titoloModalExportQuote">Esportazione <br> Rette Concordate o Pagamenti</span>
					
					<div id="remove-contentModalExportQuote" class="mt20" style="text-align: center;"> 


						<div  class=" col-sm-12 mt10" id="optionsContainer">
							<div class="col-sm-6" >
								<input type="radio" id="concordate" name="tipoQuoteExport" value="concordate" checked>
								<br>
								<label for="concordate">rette Concordate<span class="smalltext mt10"><br><br>esporta SOLO <br>le rette concordate
								a preventivo</span></label>
							</div>

							<div class="col-sm-6" style= "border-left: 1px solid grey;">
								<input type="radio" id="pagate" name="tipoQuoteExport" value="pagate">
								<br>
								<label for="pagate">Pagamenti avvenuti<span class="smalltext mt10"><br><br>esporta, oltre alle rette pagate:<br>
								iscrizioni, quote associative, donazioni, spese didattiche pagate...</span></label>
								
							</div>
						</div>

						<div class=" col-sm-12 mt10 mb20">
							<div class="col-sm-4 col-sm-offset-2" >
								dal
								<br>
								<input class="tablecell6 dpd" id="dateFrom" type="text" 
								value="<?=date("d/m/Y", strtotime("first day of previous month"));?>"
								>
							</div>

							<div class="col-sm-4">
								al
								<br>
								<input class="tablecell6 dpd" id="dateTo" type="text"
								value="<?=date("d/m/Y", strtotime("last day of previous month"));?>"
								>
							</div>
						</div>
						<div class=" col-sm-12 mt10 mb20">
							Alunno
							<div id="selectAlunniContainer" >
							</div>
						</div>
					</div>

					<div class="alert alert-success" id="alertModalExportQuote" style="display:none; margin-top:10px;">
						<h4 style="text-align:center;" id="alertmsgModalExportQuote"> 
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn_CancelModalExportQuote" class="btnBlu" style="width:40%;" onclick="requery(1);" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKModalExportQuote" class="btnBlu" style="width:40%;" onclick="downloadFilePagamenti(0);">OK</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- FINE FORM MODALE ESPORTAZIONE QUOTE *************************************************************************************** -->


	<!-- *********************************** VECCHIO FORM MODALE METODO PAGAMENTO ****************************************************-->
	<!-- <div class="modal" id="modalMetodoPagamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">Metodo di questo pagamento</span>
					
					<div id="remove-contentMetodoPagamento" class="mt20 mb10" style="text-align: left;"> 
						<input id="ID_ret_hidden" hidden>
						<div class="col-md-4 col-md-offset-4">	
							<div>
								<input id="metodoPag1" type="radio" name="metodoPagamento" value="1"> Contanti
							</div>
							<div>
								<input id="metodoPag2" type="radio" name="metodoPagamento" value="2"> Bonifico
							</div>
							<div>
								<input id="metodoPag3" type="radio" name="metodoPagamento" value="3"> Carta di Credito
							</div>
						</div>
					</div> 

					<div class="alert alert-success" id="alertMetodoPagamento" style="display:none; margin-top:10px;">
						<h4 style="text-align:center;" id="alertmsgMetodoPagamento"> 
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn_OKMetodoPagamento" class="btnBlu mt10" style="width:40%;" data-dismiss="modal" onclick="setMetodoPagamento();">Chiudi</button>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<!-- *********************************** FINE FORM MODALE****************************************************-->


</body>
</html>

<script>
	
	$(document).ready(function(){
		requery(1);
		//$("body").css("cursor", "default");
		PopolaSelectAlunno();
	});
	
	function moveFirst(x) {
		requery (1);
	}
	
	function moveLast(x) {
		numRecord = parseInt($("#conteggiorecord").html());
		recordperpagina = $("#recordperpagina_hidden").val();
		maxPage = Math.ceil(numRecord/recordperpagina);
		requery (maxPage);
	}
	
	function movePage(x) {
		righeperPagina = 15;
		currPage = parseInt($('#numeroPagina').val());
		numRecord = parseInt($("#conteggiorecord").html());
		recordperpagina = $("#recordperpagina_hidden").val();
		maxPage = Math.ceil(numRecord/recordperpagina);
		if ((currPage + x < 1) || (currPage +x > maxPage)) { } else{requery(currPage+x);}
	}
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az'); }
		requery(1);
	}
	
	function requery(numPag){
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();

		let fil1 = $('#filter1').val();
		let fil2 = $('#filter2').val();
		let fil3 = $('#filter3').val();
		let fil4 = $('#filter4').val();

		let annoscolastico = $("#selectannoscolastico").val();
		let selectlistaattesa = document.getElementById("selectlistaattesa");
		let listaattesa = selectlistaattesa.options[selectlistaattesa.selectedIndex].value;
		
		ckDVal = $("#ckD").is(':checked');
		ckCVal = $("#ckC").is(':checked');
		ckPVal = $("#ckP").is(':checked');
		ckPDVal = $("#ckPD").is(':checked');
		
		postData = { numPag: numPag, campo1 : "nome_alu", campo2: "cognome_alu", campo3: "classe_cla", campo4: "sezione_cla", annoscolastico: annoscolastico, ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, fil1: fil1, fil2: fil2, fil3: fil3, fil4: fil4, ckDVal: ckDVal, ckCVal: ckCVal, ckPVal: ckPVal, ckPDVal: ckPDVal, listaattesa: listaattesa};
		// console.log ("04rette.php - requery - posta a 04qry_Rette.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "04qry_Rette.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log (html);
				$("#maintable").html(html);
				$("#conteggiorecord").html( $("#contarecord_hidden").val());
				recordperpagina = $("#recordperpagina_hidden").val();
				$('#numeroPagina').val(parseInt(numPag));
				numRecord = parseInt($("#conteggiorecord").html());
				maxPage = Math.ceil(numRecord/recordperpagina);
				$('#pag_tot').val(parseInt(numPag)+"/"+maxPage);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '04Rette ##fname##'");      
			}
		});
	}
	
	function mostraNascondi(x) {
		//console.log(x);
		switch(x) {
			case 'D':
				if(!($("#ckD").is(':checked'))) { $('.Rdefault').css('display', 'none'); } else { $('.Rdefault').css('display', 'block'); }
		break;
			case 'C':
				if(!($("#ckC").is(':checked'))) { $('.Rconcordato').css('display', 'none'); } else { $('.Rconcordato').css('display', 'block'); }
		break;
			case 'P':
				if(!($("#ckP").is(':checked'))) { $('.Rpagato').css('display', 'none'); } else { $('.Rpagato').css('display', 'block'); }
		break;
			case 'PD':
				if(!($("#ckPD").is(':checked'))) { $('.RDpagato').css('display', 'none'); } else { $('.RDpagato').css('display', 'block'); }
		break;
			default:
		}
		//currPage = parseInt($('#numeroPagina').val());
		requery(1); //era precedentemente settato a requery(currPage) ma se uno cambia le opzioni delle checkbox allora non posso rimandarlo alla stessa pagina perchè cambia il numero di record per pagina
	}

	function DownloadExcel() {
		let downloadType = $( "#selectDownloadExcel option:selected" ).val();
		window[downloadType]();
	}

	function DownloadExcelRette() {

		let annoscolastico_ret = $("#selectannoscolastico").val();
		window.location.href='04downloadRette.php?annoscolastico_cla='+annoscolastico_ret;
	}

	// function checkTreRate() {
	// 	if ($('#treratetrimestrali_ck').prop('checked')) {
	// 		$('#Rate').prop("disabled", true);
	// 		$('#Rate').css("color", '#ededed' );
	// 	} else {
	// 		$('#Rate').prop("disabled", false);
	// 		$('#Rate').css("color", 'black' );
	// 	}
	// 	RicalcolaRateMensili();
	// }


	function showModalCalcolaTutteQuote() {
			$("#btn_OKTutteQuote").show();
			$("#btn_cancelTutteQuote").html('Annulla');
			$("#remove-contentTutteQuote").show();
			$("#alertTutteQuote").removeClass('alert-success');
			$("#alertTutteQuote").addClass('alert-danger');
			$("#alertTutteQuote").hide();
			$("#passwordTutteQuote").val("");
			$('#statusInserimenti').val("");
			$('#statusInserimenti').css("width", "90%");
			$('#statusInserimenti').css("height", "80px");
			$('#modalCalcolaTutteQuote').modal('show');
	}

	function calcolaTutteQuote () {

		let psw = $("#passwordTutteQuote").val();
		let pswOperazioni0 = $("#pswOperazioni0").val();

		//costruisce una stringa di 1 e 0 conforme alla serie di checkboxes
		seqMesi ="";
		for (i = 1; i <= 12; i++) {
			if (!$('#meseRipartizione'+i).prop('checked')) {seqMesi=seqMesi+"0";} else {seqMesi=seqMesi+"1";}
		}

		//ora mette i valori da 1 a 12 in un array meseSiNo e calcola quanti mesi sono stati posti = 1 (mesiTot)
		let meseSiNo = [];
		mesiTot = 0;
		for (i = 1; i <= 12; i++) {
			meseSiNo[i] = seqMesi.substr(i-1, 1);
			mesiTot = mesiTot + parseInt(meseSiNo[i]);
		}


		if (psw == null || psw == "" || psw !=pswOperazioni0 ) {
			$("#alertmsgTutteQuote").html('Password Errata!');
			$("#alertTutteQuote").show();
		}	else  {
			//questa routine mette insieme:
			//0. una prima routine 04qry_getID_aluA per costruire un array degli ID_alu dell'anno
			//1. ciclando sugli elementi dell'array con una callback foreach si effettua il calcolo della quota di default che avviene tramite la 04qry_getFratellieQuote
			//2. con il valore estratto si costruisce la postData3 che viene passata a 04qry_updateQuote.php 
			//SONO TANTISSIME QUERY DI UPDATE: ALMENO 12 PER OGNI ALUNNO: quindi se gli alunni sono 249 (cittadella) sono 2976 query!!! si pianterà tutto?
			let annoscolastico = $("#selectannoscolastico").val();
			
			let quote_fratelli_diverse = $("#quote_fratelli_diverse").val();
			//estraggo un array di tutti gli ID_alu dell'anno scolastico per il quale si devono inserire le quote
			let where_hidden = $('#where_hidden').val();
			postData = { annoscolastico : annoscolastico, where_hidden: where_hidden};
			// console.log ("04Rette - calcolaTutteQuote - postData a 04qry_getID_aluA");
			// console.log (postData);
			$.ajax({
				type: 'POST',
				url: "04qry_getID_aluA.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					// console.log ("04Rette - calcolaTutteQuote - ritorno da 04qry_getID_aluA - array di alunni");
					// console.log(data);
					//per ogni alunno...
					$msgstatusInserimenti = 'VALORI INSERITI IN DATABASE';
					data.ID_aluA.forEach(function(ID_alu, index) {
						postData = { ID_alu : ID_alu, annoscolastico_ret : annoscolastico, quote_fratelli_diverse : quote_fratelli_diverse};
						console.log ("04Rette - calcolaTutteQuote - postData a 04qry_getFratellieQuote");
						console.log (postData);
						$.ajax({
							
							type: 'POST',
							url: "04qry_getFratellieQuote.php",
							data: postData,
							dataType: 'json',
							success: function(data2){
								// console.log ("index: "+index);
								// console.log ("ID_alu: "+ID_alu);
								// console.log ("alunno: "+data.nome_aluA[index]+" "+data.cognome_aluA[index]);
								// console.log ("Fratelli: "+data2.numfratelli);
								// console.log ("Gemelli: "+data2.gemelli);
								// console.log ("GemelloB: "+data2.gemelloB);
								// console.log ("Classe: "+data2.classe_cla);
								// console.log ("Quota mese (/10): "+data2.quotacalcolata/10);
								// console.log ("Quota anno: "+data2.quotacalcolata);
								// console.log ("---------------------------------------------");
								$msgstatusInserimenti = $msgstatusInserimenti + "\r\n"+index+" : "+data2.classe_cla+" . "+ID_alu+" . "+data.nome_aluA[index]+" "+data.cognome_aluA[index]+"  ...   "+data2.quotacalcolata;
								
										//con seqMesiDefault ho impostato i valori di default
										//ho ora calcolato seqMesi a partire dalle checkbox inserite nel modale
										//per calcolare la quota da inserire nei vari mesi
										//seqMesiDefault è un parametro (in tab_parametri) scritto così 111111001111
										//ossia 12 valori 0 o 1 che indicano in quali mesi inserire per default le quote
										//metto i valori 0 e 1 in un array di 12 valori
										//ATTENZIONE: l'array è ordinato come i mesi, quindi 111111001111 significa i mesi GFMAMGLASOND
										//cioè prima Gennaio-Agosto dell'anno successivo, poi Settembre-Dicembre

										//calcolo la prima quota in modo che sistemo gli arrotondamenti
										quotaarrot = Math.floor(data2.quotacalcolata/mesiTot); //la quota da inserire nei mesi indicati con 1 in seqMesiDefault
										primaquota = quotaarrot + (data2.quotacalcolata - quotaarrot * mesiTot); //la prima quota deve essere così per non arrotondare il totale

										let postData3 = [];
										postData3.push( {name: "prova", value: "prova"}  );
										primaquotaCk = 1;

										for (i = 9; i <= 12; i++) {
											
											if (primaquotaCk == 1) {
												quotamese = primaquota * meseSiNo[i];
											} else {
												quotamese =  quotaarrot * meseSiNo[i]
											}

											//dalla prima volta che trova una quota da inserire non si tratta più della primaquota 
											if (meseSiNo[i] == "1" ) {primaquotaCk = 0;}

											postData3.push( {name: i+"D", value: quotamese}  );
											postData3.push( {name: i+"C", value: quotamese}  ); //imposto la concordata = alla calcolata
											postData3.push( {name: i+"P", value: 0}  );
											postData3.push( {name: i+"Date", value: ""}  );
										}

										for (i = 1; i <= 8; i++) {
											
											if (primaquotaCk == 1) {
												quotamese = primaquota * meseSiNo[i];
											} else {
												quotamese =  quotaarrot * meseSiNo[i]
											}

											//dalla prima volta che trova una quota da inserire non si tratta più della primaquota 
											if (meseSiNo[i] == "1" ) {primaquotaCk = 0;}

											postData3.push( {name: i+"D", value: quotamese}  );
											postData3.push( {name: i+"C", value: quotamese}  ); //imposto la concordata = alla calcolata
											postData3.push( {name: i+"P", value: 0}  );
											postData3.push( {name: i+"Date", value: ""}  );
										}

										console.log ("postData3", postData3);

								// In precedenza per default mettevo le quote sui 10 mesi, quindi sui mesi 1-6, poi 0 su luglio e agosto, poi sui mesi 9-12
								// //ora devo andare ad inserire tutte le quote, uso la 04qry_updateQuote
								// let postData3 = [];
								// postData3.push( {name: "prova", value: "prova"}  );
								// //nei primi 10 mesi metto la quota di default e concordata = a quella calcolata/10
								// for (i = 1; i <= 6; i++) {
								// 	postData3.push( {name: i+"D", value: data2.quotacalcolata/10}  );
								// 	postData3.push( {name: i+"C", value: data2.quotacalcolata/10}  ); //imposto la concordata = alla calcolata
								// 	postData3.push( {name: i+"P", value: 0}  );
								// 	postData3.push( {name: i+"Date", value: ""}  );
								// }
								// //nei mesi di luglio e agosto metto 0
								// for (i = 7; i <= 8; i++) {
								// 	postData3.push( {name: i+"D", value: 0}  );
								// 	postData3.push( {name: i+"C", value: 0}  );
								// 	postData3.push( {name: i+"P", value: 0}  );
								// 	postData3.push( {name: i+"Date", value: ""}  );
								// }
								// for (i = 9; i <= 12; i++) {
								// 	postData3.push( {name: i+"D", value: data2.quotacalcolata/10}  );
								// 	postData3.push( {name: i+"C", value: data2.quotacalcolata/10}  ); //imposto la concordata = alla calcolata
								// 	postData3.push( {name: i+"P", value: 0}  );
								// 	postData3.push( {name: i+"Date", value: ""}  );
								// }

								postData3.push( {name: "ID_alu_ret", value: ID_alu} );
								postData3.push( {name: "annoscolastico_ret", value: annoscolastico} );

								$.ajax({
									type: 'POST',
									url: "04qry_updateQuote.php",
									data: postData3,
									dataType: 'json',
									success: function(data3){
										$("#remove-contentTutteQuote").slideUp();
										$("#alertmsgTutteQuote").html('Inserimento quote completato!');
										$("#alertTutteQuote").removeClass('alert-danger');
										$("#alertTutteQuote").addClass('alert-success');
										$("#alertTutteQuote").show();
										$("#btn_cancelTutteQuote").html('Chiudi');
										$("#btn_OKTutteQuote").hide();
										$('#statusInserimenti').val($msgstatusInserimenti);
									},
									error: function(){
										alert("Errore: contattare l'amministratore fornendo il codice di errore '04Rette ##fname##'");      
									}
								});

							},
							error: function(){
								alert("Errore: contattare l'amministratore fornendo il codice di errore '04Rette ##fname##'");      
							}
						});
					});


				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '04Rette ##fname##'");      
				}
			});
		}
	}

	// function resetInvii(){
	// 	//vecchia funzione reset flag invio Dati
	// 	postData = { idle : "reset" };
	// 	// console.log ("04Rette - resetInvii - postData a 04qry_resetFlagInvioDati.php");
	// 	// console.log (postData);
	// 	$.ajax({
	// 	type: 'POST',
	// 	url: '04qry_resetFlagInvioDati.php',
	// 	data: postData,
	// 	dataType: 'json',
	// 	success: function(data){
	// 			//console.log ("04qry_Rette - flagInvioDati - ritorno da 04qry_updateFlagInvioDati.php");
	// 			//console.log (data.test);
	// 			requery(1);
	// 		},
	// 	error: function(){
	// 			alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette resetInvii'");      
	// 		}
	// 	});

	// }

	function showModalExportPagamenti() {
		$('#modalExportQuote').modal('show');
	}

	function downloadFilePagamenti (ID_pag) {

			
			let tipoQuoteExport = $("input[name='tipoQuoteExport']:checked").val();
			let dateFrom = moment($('#dateFrom').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
			let dateTo = moment($('#dateTo').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
			let annoscolastico = $( "#selectannoscolastico option:selected" ).val();			
			let ID_alu = $('#selectalunno').val(); 

			if (ID_pag != 0) {
				//uso questa routine anche per il singolo pagamento, in quel caso però vanno annullati gli altri valori 
				tipoQuoteExport = 'pagate';
				dateFrom = '1900-01-01';
				dateTo = '2100-12-31'
				ID_alu = 'Tutti';
			}

			console.log ("04Rette.php - downloadFilePagamenti - dati GET per 04exportPagamentiContabilita.php");
			console.log ("04exportPagamentiContabilita.php?tipoQuoteExport="+tipoQuoteExport+"&ID_alu="+ID_alu+"&ID_pag="+ID_pag+"&dateFrom="+dateFrom+"&dateTo="+dateTo+"&annoscolastico="+annoscolastico);
			//prima di lanciare la creazione del file è bene verificare che i pagamenti siano tutti correttamente compilati
			window.location.href = "04exportPagamentiContabilita.php?tipoQuoteExport="+tipoQuoteExport+"&ID_alu="+ID_alu+"&ID_pag="+ID_pag+"&dateFrom="+dateFrom+"&dateTo="+dateTo+"&annoscolastico="+annoscolastico;
		
	}

	function PopolaSelectAlunno(){
		let annoscolastico_cla = $( "#selectannoscolastico option:selected" ).val();

		postData = { annoscolastico_cla: annoscolastico_cla};

		//console.log ("04Rette.php - postData a 12qry_getElencoAlunni.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "04qry_getElencoAlunni.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				//console.log ("04Rette.php - ritorno da 12qry_getElencoAlunni.php");
				//console.log (html);
				$("#selectAlunniContainer").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '04Rette ##PopolaSelectAlunno##'");      
			}
		});
	}

	//function flagInvioDati(ID_ret){
		//vecchia funzione per invio Dati:
		//aggiornava il flag invio dati nella tabella tab_mensilirette e
		//mostrava il modale modalMetodoPagamento che ora non serve più
		// let flagInvioDatiVal = $("#ckInvioDatiRette_"+ID_ret).is(":checked");
		// //solo se si sta flaggando allora mostriamo il modale


		// postData = { ID_ret : ID_ret, flagInvioDatiVal : flagInvioDatiVal };
		// console.log ("04Rette - flagInvioDati - postData a 04qry_updateFlagInvioDati.php");
		// console.log (postData);
		// $.ajax({
		// type: 'POST',
		// url: '04qry_updateFlagInvioDati.php',
		// data: postData,
		// dataType: 'json',
		// success: function(data){
		// 		//console.log ("04qry_Rette - flagInvioDati - ritorno da 04qry_updateFlagInvioDati.php");
		// 		//console.log (data.test);
		// 		if (flagInvioDatiVal) {
		// 			$('#ID_ret_hidden').val(ID_ret);
		// 			$("#metodoPag1").prop('checked', true);
		// 			$('#modalMetodoPagamento').modal('show');
		// 		} else {
		// 			numpag = $('#numeroPagina').val();
		// 			requery(numpag);
		// 		}
		// 	},
		// error: function(){
		// 		alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette flagInvioDati'");      
		// 	}
		// });
	//}

	// function setMetodoPagamento() {
	// 	ID_ret = $('#ID_ret_hidden').val();
	// 	metodopag_ret = $("input[name='metodoPagamento']:checked").val();
	// 	postData = {ID_ret : ID_ret, metodopag_ret: metodopag_ret};
	// 	console.log ("04Rette - setMetodoPagamento - postData a 04qry_setMetodoPagamento.php");
	// 	console.log (postData);
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: '04qry_setMetodoPagamento.php',
	// 		data: postData,
	// 		dataType: 'json',
	// 		success: function(data){
	// 			console.log (data.test);

	// 			numpag = $('#numeroPagina').val();
	// 			requery(numpag);
	// 			},
	// 		error: function(){
	// 			alert("Errore: contattare l'amministratore fornendo il codice di errore '04qry_Rette 04qry_setMetodoPagamento'");      
	// 		}
	// 	});
	// }

	function backupDB (AoB) {
		//console.log ('15qry_UseOverview.php - backupDB - lancio di 15qry_backup.php');
		window.location.href = '15qry_backup.php?database='+AoB;
	}

	function requerySamePage() {

		numPag = $('#numeroPagina').val();
        requery(numPag);    //per qualche motivo c'è forse un altro requery(1) prima di questo ######TODO

	}

</script>
