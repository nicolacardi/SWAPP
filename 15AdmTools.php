<?
	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	include_once("assets/functions/ifloggedin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Amministrazione SWAPP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name=”robots” content=”noindex”>
	<link rel="shortcut icon" href="assets/img/faviconbook.png" type="image/icon">
	<link rel="icon" href="assets/img/faviconbook.png" type="image/icon">
	<script src="assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<script src="assets/tinymce2/tinymce.min.js"></script>
	<? $_SESSION['page'] = "Amministrazione SWAPP";?>
</head>

<body>
	<? include("NavBar.php"); ?>
	<div id="main">
<!-- Titolo e nav tabs **************************************************************************************** -->
		<? include_once("assets/functions/lowreswarning.html"); ?>
		<div class="upper highres" >	
			<div style="text-align: center; font-size: 24px; color: #3c3c3c; margin-bottom: 3px;" >
				Strumenti di Amministrazione
			</div>
			<div class="ml50">
				<input id="pswOperazioni1" value="<?=$_SESSION['pswOperazioni1']?>" hidden>
			</div>
			<div id="TabsAdministration" style="margin-top:5px;">
				<!-- definizione labels del tab group-->
				<ul class="nav nav-tabs" id="TabsSchedaAlunnoLabels">
					<li style="margin-left: 60px;">
						<a href="#GestionePassword" data-toggle="tab" class="active">Gestione Password</a>
					</li>
					<li>
						<a href="#SetParametri" data-toggle="tab" >Set Parametri</a>
					</li>
					<li>
						<a href="#SetParametriA" data-toggle="tab" >Set Parametri x Anno</a>
					</li>
					<li>
						<a href="#MaterieOrario" data-toggle="tab" >Set Materie Orario</a>
					</li>
					<li>
						<a href="#MateriePagella" data-toggle="tab" >Set Materie Pagella</a>
					</li>
					<li>
						<a href="#ObiettiviPagella" data-toggle="tab" >Set Obiettivi Pagella</a>
					</li>
					<li>
						<a href="#BackupDB" data-toggle="tab" >Operazioni Database</a>
					</li>
					<li>
						<a href="#Test" data-toggle="tab" >Test WYSIWIG</a>
					</li>
				</ul>
<!--  *****************************OVERVIEW USERS**********************************************-->
				<div class="tab-content" id="TabsAdministrationContent">
					<div class="tab-pane active" id="GestionePassword">
						<div style="text-align:center; margin-top: 10px;">

							<table id="tabellaUseOverview" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
											<img title="Aggiungi nuovo utente" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddLogin();">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0" style="width: 150px;" type="text" value ="Username" disabled>
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value="Livello" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 70px;" type="text" value="Accessi" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 170px;" type="text" value="Curr Logon" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 80px;" type="text" value="Hide splash" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
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
											<button id="setallnonmostrarepiu" class="btnBlu20" onclick="SetNonMostrarePiu(0);" style="width: 55px; font-size: 9px;">uncheck All</button>
										</th>
								</thead>
								<tbody class="scroll" id="maintable">
								</tbody>
							</table>
						</div>
					</div>
<!--  *****************************SET PARAMETRI BASE******************************************-->
					<div class="tab-pane active" id="SetParametri">
						<div style="text-align:center; margin-top: 10px;">
							<table id="tabellaSetParametri" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w200px" type="text" value ="Nome Parametro" disabled>
										</th>
										<th>
											<input class="tablelabel0 w300px" type="text" value="Valore Parametro" disabled>
										</th>
										<th>
											<input class="tablelabel0 w300px" type="text" value="Descrizione" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<button id="ordinacampo1Par" class="ordinabutton" onclick="ordinaPar(1);" >--</button>
										</th>
										<th>
											<button id="ordinacampo2Par" class="ordinabutton" onclick="ordinaPar(2);" >--</button>
										</th>
										<th>
											<button id="ordinacampo3Par" class="ordinabutton" onclick="ordinaPar(3);" >--</button>
										</th>
								</thead>
								<tbody class="scroll" id="maintablePar">
								</tbody>
							</table>
						</div>
					</div>
<!--  *****************************SET PARAMETRI X ANNO (PAGELLA)******************************-->
					<div class="tab-pane active" id="SetParametriA">
						<div style="text-align:center; margin-top: 10px;">
						<!-- <div class="table-wrapper" style="overflow-y: scroll; height: 150px;"> -->
							<table id="tabellaSetParametriA" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value ="Anno Scolastico" disabled>
										</th>
										<th>
											<input class="tablelabel0 w150px" type="text" value ="Nome Parametro" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px" type="text" value="Val 1" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px" type="text" value="Val 2" disabled>
										</th>
										<th>
											<input class="tablelabel0 w80px"  type="text" value="Tipo Voti" disabled>
										</th>
										<th>
											<input class="tablelabel0 w80px"  type="text" value="N. Char" disabled>
										</th>
									<tr>
										<th class="stk" style="width:22px;">
										</th>
										<th class="stk" style="width:25px;">
										</th>
										<th class="stk" style="width:45px;">
										</th>
										<th class="stk" >
											<button id="ordinacampo1ParA" class="ordinabutton" onclick="ordinaParA(1);" >--</button>
										</th>
										<th class="stk" >
											<button id="ordinacampo2ParA" class="ordinabutton" onclick="ordinaParA(2);" >--</button>
										</th>
										<th class="stk" >
											<button id="ordinacampo3ParA" class="ordinabutton" onclick="ordinaParA(3);" >--</button>
										</th>
										<th class="stk" >
											<button id="ordinacampo3ParA" class="ordinabutton" onclick="ordinaParA(4);" >--</button>
										</th>
										<th class="stk" >
											<button id="ordinacampo3ParA" class="ordinabutton" onclick="ordinaParA(5);" >--</button>
										</th>
								</thead>
								<tbody class="scroll" id="maintableParA">
								</tbody>
							</table>
						</div>
						<!-- </div> -->
					</div>
<!--  *****************************MATERIE ORARIO**********************************************-->
					<div class="tab-pane active" id="MaterieOrario">
						<div style="text-align:center; margin-top: 10px;">
							<div class="row mb5">
								Materie utilizzate nell'Orario e disponibili per essere associate al singolo maestro nella singola classe
							</div>
							<table id="tabellaSetMaterie" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
											<img title="Aggiungi nuova Materia" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddMateria();">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value ="Cod. Materia" disabled>
										</th>
										<th>
											<input class="tablelabel0 w200px"  type="text" value="Descrizione Materia (Orario)" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="AS" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="EL" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="ME" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="SU" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="A-Z" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>

										<th style="width:45px;">
										</th>
										<th>
											<button id="ordinacampo1Mat" class="ordinabutton" onclick="ordinaMat(1);" >--</button>
										</th>
										<th>
											<button id="ordinacampo2Mat" class="ordinabutton" onclick="ordinaMat(2);" >--</button>
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo3Mat" class="ordinabutton" onclick="ordinaMat(3);" >--</button>
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo4Mat" class="ordinabutton" onclick="ordinaMat(4);" >--</button>
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo5Mat" class="ordinabutton" onclick="ordinaMat(5);" >--</button>
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo6Mat" class="ordinabutton" onclick="ordinaMat(6);" >--</button>
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo7Mat" class="ordinabutton" onclick="ordinaMat(7);" >--</button>
										</th>
									</tr>
								</thead>
								<tbody class="scroll" id="maintableMat">
								</tbody>
							</table>
						</div>
					</div>
<!--  *****************************MATERIE PAGELLA*********************************************-->
					<div class="tab-pane active" id="MateriePagella">
						<div style="text-align:center; margin-top: 10px;">
							<div class="row mb5">
								Materie utilizzate nella pagella a seconda del livello (AS/EL/ME) e del tipo di documento
							</div>
							<div class="row mb5">
								Attenzione: qui vengono mostrate le materie associate a ciascun template
							</div>
							<div class="row mb5">
								Quale gruppo venga MOSTRATO nel form dipende però dal PRIMO parametro (val_paa) impostato per ogni anno
							</div>
							<table id="tabellaSetMaterieP" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
											<img title="Aggiungi nuova Materia" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalAddMateriaP();">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value ="Cod. Materia" disabled>
										</th>
										<th>
											<input class="tablelabel0 w200px"  type="text" value="Descrizione Materia (Pagella)" disabled>
										</th>
										<th>
											<input class="tablelabel0 w100px"  type="text" value="Livello Classe" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 120px;" type="text" value="Tipo Documento" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="A-Z" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 60px;" type="text" value="Obiettivi" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>

										<th style="width:45px;">
										</th>
										<th>
											<button id="ordinacampo1MatP" class="ordinabutton" onclick="ordinaMatP(1);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetMaterieP();" id="filter1MatP" name="filter1" >
										</th>
										<th>
											<button id="ordinacampo2MatP" class="ordinabutton" onclick="ordinaMatP(2);" >--</button>
											<input class="tablecell3 filtercell" type="text"   onchange="requerySetMaterieP();" id="filter2MatP" name="filter2" >
										</th>
										<th>
											<button id="ordinacampo3MatP" class="ordinabutton" onclick="ordinaMatP(3);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetMaterieP();" id="filter3MatP" name="filter3" >
										</th>
										<th>
											<button id="ordinacampo4MatP" class="ordinabutton" onclick="ordinaMatP(4);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetMaterieP();" id="filter4MatP" name="filter4" >
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo5MatP" class="ordinabutton" onclick="ordinaMatP(5);" >--</button>
										</th>
										<th>

										</th>
								</thead>
								<tbody class="scroll" id="maintableMatP">
								</tbody>
							</table>
						</div>
					</div>
<!--  *****************************OBIETTIVI PAGELLA*******************************************-->
					<div class="tab-pane active" id="ObiettiviPagella">
						<div style="text-align:center; margin-top: 10px;">
							<div class="row mb5">
								Obiettivi per classe e per Materia
							</div>
							<div class="row mb5">
								Gli obiettivi associati alle materie vengono qui valorizzati
							</div>
							<div class="row mb5">
								assegnando a ciascuna classe (a seconda di AS/EL/ME) la descrizione specifica
							</div>
							<table id="tabellaSetObiettiviP" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
					
										</th>
										<th style="width:22px;">
											<img title="Aggiungi nuovo Obiettivo" class="iconaStd" src='assets/img/Icone/circle-plus.svg' onclick="showModalInsertDescObiettivoP();">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value ="Cod. Obiettivo" disabled>
										</th>
										<th>
											<input class="tablelabel0 w200px" type="text" value="Materia" disabled>
										</th>
										<th>
											<input class="tablelabel0 w100px" type="text" value="Classe" disabled>
										</th>
										<th>
											<input class="tablelabel0"  style="width: 420px;" type="text" value="Descrizione" disabled>
										</th>
										<th>
											<input class="tablelabel0 w50px"  type="text" value="A-Z" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:22px;">
										</th>

										<th style="width:45px;">
										</th>
										<th>
											<button id="ordinacampo1ObP" class="ordinabutton" onclick="ordinaObP(1);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetObiettiviP();" id="filter1ObP" name="filter1" >
										</th>
										<th>
											<button id="ordinacampo2ObP" class="ordinabutton" onclick="ordinaObP(2);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetObiettiviP();" id="filter2ObP" name="filter2" >
										</th>
										<th>
											<button id="ordinacampo3ObP" class="ordinabutton" onclick="ordinaObP(3);" >--</button>
											<input class="tablecell4 filtercell3" type="text"   onchange="requerySetObiettiviP();" id="filter3ObP" name="filter3" >
										</th>
										<th>
											<button id="ordinacampo4ObP" class="ordinabutton" onclick="ordinaObP(4);" >--</button>
											<input class="tablecell3 filtercell" type="text"   onchange="requerySetObiettiviP();" id="filter4ObP" name="filter4" >
										</th>
										<th style="text-align: center;">
											<button id="ordinacampo5ObP" class="ordinabutton" onclick="ordinaObP(5);" >--</button>
										</th>
										<th>

										</th>
								</thead>
								<tbody class="scroll" id="maintableObP">
								</tbody>
							</table>
						</div>
					</div>
<!--  *****************************BACKUP******************************************************-->
					<div class="tab-pane active" id="BackupDB">
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
							<button type="button" class="btnBlu" style="width:100%; margin-top: 20px;" data-dismiss="modal" onclick="backupDB('A');">Backup Database A</button>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
							<button type="button" class="btnBlu" style="width:100%; margin-top: 20px;" data-dismiss="modal" onclick="backupDB('B');">Backup Database B</button>
						</div>
						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
							<button type="button" class="btnBlu" style="width:100%; margin-top: 20px;" data-dismiss="modal" onclick="showModaltruncateDBB();">Cancella Contenuto Database B</button>
						</div>

					</div>
<!--  *****************************TEST********************************************************-->

					<div class="tab-pane active" id="Test">

						<div style="text-align: center; ">
							<div class="alert alert-success" id="alertModificaDocumento" style="display: none; width: 500px; z-index: 1000; position: fixed; left: 50%; margin-left: -250px; ">
								<h4 style="text-align:center;"> Aggiornamento documento completato con successo!</h4>
							</div>
						</div>

						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 mt10">
							<input class="w100" id="titolo_doc" value="" placeholder="fai clic su un documento" disabled>
						</div>

						<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 mt10">
							<textarea name="editor" id="editor">

							</textarea>	
							<button type="button" class="btnBlu w100 mt10"  data-dismiss="modal" onclick="salvaTinyMCE();">Salva</button>
						</div>
						<input id="ID_doc_hidden" value ="" hidden>
						<div style="text-align:center;">
							<table id="tabellaDocumenti" class="mt10" style="display: inline-block">
								<thead>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<input class="tablelabel0 w200px" type="text" value ="Titolo Documento" disabled>
										</th>
										<th>
											<input class="tablelabel0 w300px" type="text" value="Descrizione" disabled>
										</th>
									<tr>
										<th style="width:22px;">
										</th>
										<th style="width:25px;">
										</th>
										<th style="width:45px;">
										</th>
										<th>
											<button id="ordinacampo1Doc" class="ordinabutton" onclick="ordinaDoc(1);" >--</button>
										</th>
										<th>
											<button id="ordinacampo2Doc" class="ordinabutton" onclick="ordinaDoc(2);" >--</button>
										</th>
								</thead>
								<tbody class="scroll" id="maintableDoc">
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>	

<!--***************************************FORM MODALE INSERIMENTO NUOVA LOGIN **************************************************-->
	<div class="modal" id="modalAddLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddLogin" method="post">
						<span class="titoloModal">Inserimento nuovo Utente</span>
						<div id="remove-content" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									Login
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									<input class="tablecell5" type="text"  id="login_new" name="login_new" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Password
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									<input class="tablecell5" type="text"  id="password_new" name="password_new" required>
								</div>
							</div>
							<div class="row" style="margin-top: 20px;">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Tipologia Utente
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									<select name="selectTipo"  id="selectTipo" style="width: 98%">
										<option value="0">Amministratore del Sistema</option>
										<option value="1">Consigliere + Maestro</option>
										<option value="3">Maestro Coordinatore</option>
										<option value="2">Maestro Semplice</option>
										<option value="4">Consigliere</option>											
									</select>
								</div>
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungi" style="display:none; margin-top:10px;">
							<h4 id="alertmsg" style="text-align:center;"> 
							  Inserimento Login completato con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancel1" class="btnBlu pull-left" style="display: inline-block; width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OK1" class="btnBlu pull-right" style="display: inline-block;  width:40%;" onclick="addLogin();" >Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO NUOVA LOGIN **************************************************-->


<!--***************************************FORM MODALE INSERIMENTO NUOVA MATERIA **************************************************-->
	<div class="modal" id="modalAddMateria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddMateria" method="post">
						<span class="titoloModal">Inserimento nuova Materia</span>
						<div id="remove-contentMat" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									Codice Materia
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 col-sm-4 col-md-offset-5 col-sm-offset-4" style="text-align: center;">
									<input class="tablecell5" type="text"  id="codmat_mtt_new" name="codmat_mtt_new" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Materia
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									<input class="tablecell5" type="text"  id="descmateria_mtt_new" name="descmateria_mtt_new" required>
								</div>
							</div>
							<div class="col-md-4 col-sm-8 col-md-offset-4 col-sm-offset-2" style="border: 1px solid grey; border-radius: 4px; margin-top: 10px; margin-bottom: 20px;">
								<div class="row">
										Asilo
										<input class="tablecell5" type="checkbox"  id="as_mtt_new" name="as_mtt_new">
								</div>
								<div class="row">
										Elementari
										<input class="tablecell5" type="checkbox"  id="el_mtt_new" name="el_mtt_new">
								</div>
								<div class="row">
										Medie
										<input class="tablecell5" type="checkbox"  id="me_mtt_new" name="me_mtt_new">
								</div>
							</div>

						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiMat" style="display:none; margin-top:10px;">
							<h4 id="alertmsgMat" style="text-align:center;"> 
							  Inserimento Materia completato con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelMat" class="btnBlu pull-left" style="display: inline-block; width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OKMat" class="btnBlu pull-right" style="display: inline-block;  width:40%;" onclick="addMateria();" >Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>	
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO NUOVA MATERIA **************************************************-->


<!--***************************************FORM MODALE INSERIMENTO NUOVA MATERIA PAGELLA**************************************************-->
	<div class="modal" id="modalAddMateriaP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddMateriaP" method="post">
						<span class="titoloModal">Inserimento nuova Materia in Pagella</span>
						<div id="remove-contentMatP" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									Codice Materia
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 col-sm-4 col-md-offset-5 col-sm-offset-4" style="text-align: center;">
									<input class="tablecell5" type="text"  id="codmat_mat_new" name="codmat_mat_new" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Materia
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									<input class="tablecell5" type="text"  id="descmateria_mat_new" name="descmateria_mat_new" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Livello Classe
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-8 col-md-offset-4 col-sm-offset-2">
									<select name="selectaselme_mat_new"  style="width: 100%; margin-left: 0px; font-size: 13px;"  id="selectaselme_mat_new">
										<option value="AS" >Asilo</option>
										<option value="EL" >Elementari</option>
										<option value="ME" >Medie</option>
										<option value="SU" >Superiori</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Tipo Documento
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-8 col-md-offset-4 col-sm-offset-2">
									<select name="selecttipodoc_mat_new"  style="width: 100%; margin-left: 0px; font-size: 13px;"  id="selecttipodoc_mat_new">
										<option value="1" >Pagella Tipo 1</option>
										<option value="2" >Pagella Tipo 2</option>
										<option value="3" >Pagella Tipo 3</option>
										<option value="4" >Pagella Tipo 4</option>
										<option value="5" >Pagella Tipo 5</option>
										<option value="6" >Pagella Tipo 6</option>
										<option value="11" >Cert. Competenze</option>
									</select>
								</div>
							</div>
						</div> <!-- END REMOVE CONTENT -->
						<div class="alert alert-success" id="alertaggiungiMatP" style="display:none; margin-top:10px;">
							<h4 id="alertmsgMatP" style="text-align:center;"> 
							  Inserimento Materia completato con successo!
							</h4>
						</div>
						<div class="modal-footer" >
							<button type="button" id="btn_cancelMatP" class="btnBlu pull-left" style="display: inline-block; width:40%;" data-dismiss="modal">Annulla</button>
							<button type="button" id="btn_OKMatP" class="btnBlu pull-right" style="display: inline-block;  width:40%;" onclick="addMateriaP();" >Procedi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO NUOVA MATERIA **************************************************-->


<!--***************************************FORM MODALE INSERIMENTO DESCRIZIONE OBIETTIVI NELLE CLASSI **********************************-->
	<div class="modal" id="modalAddCodiciObiettivi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddCodiciObiettivi" method="post">
						<span class="titoloModal">Gestione Codici Obiettivi per questa materia</span>
						<div id="containerTableCodiciObiettivi" style="text-align: center; margin-top: 20px; ">
							
						</div>

						<div class="modal-footer" >
							<button type="button" id="btn_chiudiModalObiettivi" class="btnBlu" style="display: inline-block; width:40%;" data-dismiss="modal">Chiudi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO DESCRIZIONE OBIETTIVI NELLE CLASSI ******************************-->

<!--***************************************FORM MODALE ASSOCIAZIONE OBIETTIVI A CLASSI **************************************************-->
	<div class="modal" id="modalAddObiettivoDescP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px; width: 40%">
			<div class="modal-content">
				<div class="modal-body white">           
					<form id="form_AddObiettivoDescP" method="post">
						<span class="titoloModal">Inserimento Descrizione obiettivi per Classe e Materia</span>
						<div id="remove-contentObiettivoDescP" style="text-align: center; margin-top: 20px; "> <!-- START REMOVE CONTENT -->
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									Obiettivo
								</div>
							</div>
							<div class="row">

								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
								
								<select name="select_obiettivo"  style="width: 100%; margin-left: 0px; font-size: 13px;"  id="select_obiettivo" onchange="popolaSelectClassi()">
										<?
										$sql = "SELECT ID_obi, ID_mat_obi, codob_obi, descmateria_mat, aselme_mat FROM tab_materievotiobiettivi LEFT JOIN tab_materievoti ON ID_mat_obi = ID_mat ORDER BY codob_obi ";
										$stmt = mysqli_prepare($mysqli, $sql);
										mysqli_stmt_execute($stmt);
										mysqli_stmt_bind_result($stmt, $ID_obi, $ID_mat_obi, $codob_obi, $descmateria_mat, $aselme_mat);
										while (mysqli_stmt_fetch($stmt)) {?>
												<option value="<?=$aselme_mat?>-<?=$ID_obi?>"><?=$codob_obi?>-<?=$descmateria_mat?>-<?=$aselme_mat?></option><?
											
										}?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Classe
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2" style="text-align: center;">
									<div id="selectClassiContainer">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
									Descrizione
								</div>
							</div>
							<textarea class="tablecell5 w100" id ="descrizioneObiettivo" type="text" ></textarea>

						</div> <!-- END REMOVE CONTENT -->

						<div class="modal-footer" >

							<button type="button" id="btn_CancelModalObiettiviDescP" class="btnBlu" style="width:40%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKModalObiettiviDescP" class="btnBlu" style="width:40%;" data-dismiss= "modal" onclick="aggiungiDescObiettivo();">Procedi</button>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<!--***************************************FINE FORM MODALE INSERIMENTO OBIETTIVI NELLE MATERIE **************************************************-->



<!--*******************************************MODAL CHG PSW************************************-->
	<div class="modal" id="modalChgPsw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="font-size:14px;">
			<div class="modal-content">
				<div class="modal-body white">           
					<span class="titoloModal">MODIFICA PASSWORD</span><br>
					<span class="titoloModal">per utente</span>
					<div id="modalChgPsw-testo">
					</div>
					<div id="remove-contentChgPsw" style="text-align: center; margin-top: 10px; ">
						<div class="row">
							<div class="col-md-4">
							</div>
							<div class="col-md-4">
								<input class="tablecell5" type="text"  id="usr_new_hidden" maxlength="50" name="usr_new_hidden" hidden>
								<input class="tablecell5" type="text"  id="psw_new" maxlength="50" name="psw_new">
							</div>
						</div>
					</div>
					<div class="alert alert-success" id="alertChgPsw" style="display:none; margin-top:10px;">
						<h4 id="alertmsgChgPsw" style="text-align:center;"> 
							Modifica Password<br>completata con successo
						</h4>

					</div>
					<div class="modal-footer">
						<button type="button" id="btn_CancelChgPsw" class="btnBlu" style="width:40%;" data-dismiss="modal">Annulla</button>
						<button type="button" id="btn_OKChgPswr" class="btnBlu" style="width:40%;" onclick="setNewPsw(); requeryUSeOverview();">Procedi</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--*******************************************FINE MODAL CHG PSW*******************************-->

</body>
</html>

<script>







	$(document).ready(function(){
		$('#TabsAdministration a[href="#GestionePassword"]').tab('show');
		requeryUseOverview();
		requerySetParametri();
		requerySetParametriA();
		requerySetMaterie();
		requerySetMaterieP();
		requerySetObiettiviP();
		requeryDocumenti();

		tinymce.init ({
		selector: 'textarea#editor',
		// auto_focus: 'element1',
		width: "100%",
		height: "200",
		plugins: 'pagebreak wordcount table lists'


		});

	});
	
	function ordina(x) {
		let az_za_ord = $('#ordinacampo'+x).text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x).text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x).text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x).text('az');}
		requeryUseOverview();
	}
	
	function ordinaMat(x) {
		let az_za_ord = $('#ordinacampo'+x+'Mat').text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x+'Mat').text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x+'Mat').text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x+'Mat').text('az');}
		requerySetMaterie();
	}

	function ordinaMatP(x) {
		let az_za_ord = $('#ordinacampo'+x+'MatP').text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x+'MatP').text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x+'MatP').text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x+'MatP').text('az');}
		requerySetMaterieP();
	}

	function ordinaPar(x) {
		let az_za_ord = $('#ordinacampo'+x+'Par').text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x+'Par').text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x+'Par').text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x+'Par').text('az');}
		requerySetParametri();
	}
	function ordinaParA(x) {
		let az_za_ord = $('#ordinacampo'+x+'ParA').text();
		if (az_za_ord == 'az') { $('#ordinacampo'+x+'ParA').text('za'); }
		if (az_za_ord == 'za') { $('#ordinacampo'+x+'ParA').text('--'); }
		if (az_za_ord == '--') { $('#ordinacampo'+x+'ParA').text('az');}
		requerySetParametriA();
	}

	function requeryUseOverview(){
		let ord1 = $('#ordinacampo1').text();
		let ord2 = $('#ordinacampo2').text();
		let ord3 = $('#ordinacampo3').text();
		let ord4 = $('#ordinacampo4').text();
		let ord5 = $('#ordinacampo5').text();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5};
		$.ajax({
			type: 'POST',
			url: "15qry_UseOverview.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintable").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requerySetParametri(){
		let ord1 = $('#ordinacampo1Par').text();
		let ord2 = $('#ordinacampo2Par').text();
		let ord3 = $('#ordinacampo3Par').text();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3};
		$.ajax({
			type: 'POST',
			url: "15qry_SetParametri.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintablePar").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requerySetParametriA(){
		let ord1 = $('#ordinacampo1ParA').text();
		let ord2 = $('#ordinacampo2ParA').text();
		let ord3 = $('#ordinacampo3ParA').text();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3};
		// console.log ("15AdmTools.php - requerySetParametriA - postData a 15qry_SetParametriA");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetParametriA.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableParA").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requerySetMaterie(){
		let ord1 = $('#ordinacampo1Mat').text();
		let ord2 = $('#ordinacampo2Mat').text();
		let ord3 = $('#ordinacampo3Mat').text();
		let ord4 = $('#ordinacampo4Mat').text();
		let ord5 = $('#ordinacampo5Mat').text();
		let ord6 = $('#ordinacampo6Mat').text();
		let ord7 = $('#ordinacampo7Mat').text();
		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, ord6: ord6, ord7: ord7};
		console.log ("15AdmTools.php - requerySetMaterie - postData a 15qry_SetMaterie.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetMaterie.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableMat").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requerySetMaterieP(){
		let ord1 = $('#ordinacampo1MatP').text();
		let ord2 = $('#ordinacampo2MatP').text();
		let ord3 = $('#ordinacampo3MatP').text();
		let ord4 = $('#ordinacampo4MatP').text();
		let ord5 = $('#ordinacampo5MatP').text();
		let fil1 = $('#filter1MatP').val();
		let fil2 = $('#filter2MatP').val();
		let fil3 = $('#filter3MatP').val();
		let fil4 = $('#filter4MatP').val();

		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, 
					fil1: fil1, fil2: fil2, fil3: fil3, fil4: fil4};
		// console.log ("15AdmTools.php - requerySetMaterieP - postData a 15qry_SetMaterieP.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetMaterieP.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableMatP").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requerySetObiettiviP(){
		let ord1 = $('#ordinacampo1ObP').text();
		let ord2 = $('#ordinacampo2ObP').text();
		let ord3 = $('#ordinacampo3ObP').text();
		let ord4 = $('#ordinacampo4ObP').text();
		let ord5 = $('#ordinacampo5ObP').text();
		let fil1 = $('#filter1ObP').val();
		let fil2 = $('#filter2ObP').val();
		let fil3 = $('#filter3ObP').val();
		let fil4 = $('#filter4ObP').val();

		postData = {ord1: ord1, ord2: ord2, ord3: ord3, ord4: ord4, ord5: ord5, 
					fil1: fil1, fil2: fil2, fil3: fil3, fil4: fil4};
		// console.log ("15AdmTools.php - requerySetObiettiviP - postData a 15qry_SetObiettiviP.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetObiettiviP.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableObP").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function requeryDocumenti(){
		let ord1 = $('#ordinacampo1Doc').text();
		let ord2 = $('#ordinacampo2Doc').text();
		postData = {ord1: ord1, ord2: ord2};
		// console.log ("15AdmTools.php - requeryDocumenti - postData a 15qry_SetDocumenti.php");
		// console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetDocumenti.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#maintableDoc").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	


	function showModalAddLogin() {
		document.getElementById("form_AddLogin").reset();
		$("#remove-content").show();
		$("#alertaggiungi").hide();
		$("#btn_cancel1").html('Annulla');
		$("#btn_cancel1").addClass('pull-left');
		$("#btn_OK1").show();
		$('#modalAddLogin').modal({show: 'true'});
	}
	

	function showModalAddMateria() {
		document.getElementById("form_AddMateria").reset();
		$("#remove-contentMat").show();
		$("#alertaggiungiMat").hide();
		$("#btn_cancelMat").html('Annulla');
		$("#btn_cancelMat").addClass('pull-left');
		$("#btn_OKMat").show();
		$('#modalAddMateria').modal({show: 'true'});
	}

	function showModalAddMateriaP() {
		document.getElementById("form_AddMateriaP").reset();
		$("#remove-contentMatP").show();
		$("#alertaggiungiMatP").hide();
		$("#btn_cancelMatP").html('Annulla');
		$("#btn_cancelMatP").addClass('pull-left');
		$("#btn_OKMatP").show();
		$('#modalAddMateriaP').modal({show: 'true'});
	}

	function checkPassword (password){
		
		let returnA = new Array(2);
		let specialCharacters = /[_*'\^$.|?*+()#\[\]\s]/g;
		
		// Validate lowercase letters
		let lowerCaseLetters = /[a-z]/g;
		if(password.match(lowerCaseLetters)) {  
			letterelow = 1;
		} else {
			letterelow = 0;
		}
		//tolgo questo vincolo: le password possono non contenere lettere minuscole
		letterelow = 1;

		// Validate capital letters
		let upperCaseLetters = /[A-Z]/g;
		if(password.match(upperCaseLetters)) {  
			lettereUPP = 1;
		} else {
			lettereUPP= 0;
		}
		//tolgo questo vincolo: le password possono non contenere lettere Maiuscole
		lettereUPP = 1;

		// Validate numbers
		let numbers = /[0-9]/g;
		if(password.match(numbers)) {  
			numeri = 1;
		} else {
			numeri = 0;
		}
		//tolgo questo vincolo: le password possono non contenere numeri
		numeri = 1;

		// Validate length - lunghezza minima 7 caratteri
		if(password.length > 6) {
			lunghezza = 1;
		} else {
			lunghezza = 0;
		}

  		// Validate special Characters - non voglio che siano contenuti caratteri speciali
		//in verità già l'ho verificato più sopra
		if(!(password.match(specialCharacters))) {
			speciali = 1;
		} else {
			speciali = 0;
		}

		if ((letterelow*lettereUPP*numeri*lunghezza*speciali) != 0) {
			returnA[1]="OK";
		} else {
			if (letterelow == 0){
				addmsg ="Mancano lettere minuscole";
			}
			if (lettereUPP ==0) {
				addmsg ="Mancano lettere MAIUSCOLE";
			}
			if (numeri ==0) {
				addmsg ="Mancano numeri";
			}
			if (lunghezza ==0) {
				addmsg ="Password troppo breve";
			}
			if (speciali ==0) {
				addmsg ="Contiene Caratteri Speciali o spazi";
			}
			returnA[1]="NO";
			returnA[2]= addmsg + "<br>La password deve essere di almeno 7 caratteri e non può contenere nè caratteri speciali nè spazi";
		}
		return (returnA);
	}
	
	function addLogin(){
		let login = $('#login_new').val();
		let password = $('#password_new').val();
		
		if ((login == '') || (password == '')) {
			$("#alertaggiungi").removeClass('alert-danger');
			$("#alertaggiungi").addClass('alert-success');
			$("#alertmsg").html('Login e password devono entrambe essere diverse da <Null>');
			$("#alertaggiungi").show();
			return;
		}

		// Validate special characters
		let specialCharacters = /[_*'\^$.|?*+()#\[\]\s]/g;
		//let specialCharacters = /[^\w\s]/g;
		if(login.match(specialCharacters)) {  
			$("#alertaggiungi").removeClass('alert-danger');
			$("#alertaggiungi").addClass('alert-success');
			$("#alertmsg").html('Sono vietati i caratteri speciali e gli spazi nella login');
			$("#alertaggiungi").show();
			return;
		} else {

		}
		
		let validazione = checkPassword(password);
		console.log (validazione);
		
		if (validazione[1] == "OK") {
			let tipo = $('#selectTipo').val();
			postData = {login: login, password: password, tipo: tipo};
			//Bisogna prima verificare se esiste già la userid che si sta andando ad inserire
			$.ajax({
				type: 'POST',
				url: "15qry_insertLogin.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					console.log(data.test);
					$("#remove-content").slideUp();
					$("#alertaggiungi").removeClass('alert-danger');
					$("#alertaggiungi").addClass('alert-success');
					$("#alertmsg").html(data.msg);
					$("#alertaggiungi").show();
					$("#btn_cancel1").removeClass('pull-left');
					$("#btn_cancel1").html('Chiudi');
					$("#btn_OK1").hide();
					requeryUseOverview();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
				}
			});
		} else {
			$("#alertaggiungi").removeClass('alert-success');
			$("#alertaggiungi").addClass('alert-danger');
			$("#alertmsg").html(validazione[2]);
			$("#alertaggiungi").show();
		}
	}

	function addMateria(){
		//let codmat_mtt = $('#codmat_mtt_new').val();
		//let descmateria_mtt = $('#descmateria_mtt_new').val();
		let as_mtt = $('#as_mtt_new').val();
		let el_mtt = $('#el_mtt_new').val();
		let me_mtt = $('#me_mtt_new').val();

		let postData = $("#form_AddMateria").serializeArray();

		// console.log ('15AdmTools.php - addMateria - postData a 15qry_insertMateria.php');
		// console.log (postData);


		$.ajax({
			type: 'POST',
			url: "15qry_insertMateria.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				
				$("#remove-contentMat").slideUp();
				$("#alertaggiungiMat").removeClass('alert-danger');
				$("#alertaggiungiMat").addClass('alert-success');
				$("#alertmsgMat").html(data.msg);
				$("#alertaggiungiMat").show();
				$("#btn_cancelMat").removeClass('pull-left');
				$("#btn_cancelMat").html('Chiudi');
				$("#btn_OKMat").hide();
				requerySetMaterie();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function addMateriaP(){


		let postData = $("#form_AddMateriaP").serializeArray();
		console.log ('15AdmTools.php - addMateriaP - postData a 15qry_insertMateriaP.php');
		console.log (postData);

		$.ajax({
			type: 'POST',
			url: "15qry_insertMateriaP.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				
				$("#remove-contentMatP").slideUp();
				$("#alertaggiungiMatP").removeClass('alert-danger');
				$("#alertaggiungiMatP").addClass('alert-success');
				$("#alertmsgMatP").html(data.msg);
				$("#alertaggiungiMatP").show();
				$("#btn_cancelMatP").removeClass('pull-left');
				$("#btn_cancelMatP").html('Chiudi');
				$("#btn_OKMatP").hide();
				requerySetMaterieP();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
			}
		});
	}

	function showModalChgPsw(ID_usr, login_usr) {
		$('#modalChgPsw-testo').html(login_usr);
		$('#psw_new').val('');
		$('#usr_new_hidden').val(ID_usr);
		$('#alertChgPsw').removeClass('alert-danger');
		$('#alertChgPsw').addClass('alert-success');
		$("#alertChgPsw").hide();
		$("#btn_CancelChgPsw").html('Annulla');
		$("#btn_OKChgPswr").show();
		$("#remove-contentChgPsw").show();
		$('#modalChgPsw').modal({show: 'true'});
	}

	function setNewPsw () {
		let ID_usr = $('#usr_new_hidden').val();
		let password = $('#psw_new').val();
		validazione = checkPassword(password);
		if  (validazione[1] == "NO") {
			$("#alertChgPsw").removeClass('alert-success');
			$("#alertChgPsw").addClass('alert-danger');
			$("#alertmsgChgPsw").html(validazione[2]);
			$("#alertChgPsw").show();
		} else {
			postData = { ID_usr: ID_usr, psw: password};
			console.log ("15qry_UseOverview.php - setNewPsw - postData a 15qry_updatePasswordusr.php");
			console.log (postData);
			$.ajax({
				type: 'POST',
				url: "15qry_updatePasswordusr.php",
				data: postData,
				dataType: 'json',
				success: function(){
					$("#alertChgPsw").removeClass('alert-danger');
					$("#alertChgPsw").addClass('alert-success');
					$("#alertmsgChgPsw").html('Cambio password completato con successo!');
					$("#alertChgPsw").show();
					$("#btn_CancelChgPsw").html('Chiudi');
					$("#btn_OKChgPswr").hide();
					$("#remove-contentChgPsw").slideUp();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
				}
			});
		}
	}

	function backupDB (AoB) {
		//console.log ('15qry_UseOverview.php - backupDB - lancio di 15qry_backup.php');
		window.location.href = '15qry_backup.php?database='+AoB;
	}
	
	function showModaltruncateDBB () {
		//console.log ('15qry_UseOverview.php - backupDB - lancio di 15qry_backup.php');

		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare il contenuto di tutto il database B (iscrizioni)?<br><br> digitare la password e confermare");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick","truncateDBB();");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html("ATTENZIONE");
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');

	}

	function truncateDBB () {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		} else {
			$.ajax({
					type: 'POST',
					url: "15qry_truncateDBB.php",
					dataType: 'json',
					success: function(data){
						$("#remove-content03Msg_OKCancelPsw").slideUp();
						$("#alertMsg03Msg_OKCancelPsw").html('Il database B è stato vuotato!');
						$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
						$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
						$("#alertCont03Msg_OKCancelPsw").show();
						$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
						$("#btn_OK03Msg_OKCancelPsw").hide();

					}
			});
		}

	}


	function showModalDeleteThisRecord(IDtoDelete, azione, desc, titolo) {
		$('#msg03Msg_OKCancelPsw').html("Sei sicuro di voler eliminare "+desc+" ?<br><br> digitare la password e confermare");
		$("#btn_OK03Msg_OKCancelPsw").attr("onclick",azione+"("+IDtoDelete+");");
		$("#btn_OK03Msg_OKCancelPsw").show();
		$("#titolo03Msg_OKCancelPsw").html(titolo);
		$("#btn_cancel03Msg_OKCancelPsw").html('Annulla');
		$("#remove-content03Msg_OKCancelPsw").show();
		$("#alertCont03Msg_OKCancelPsw").removeClass('alert-success');
		$("#alertCont03Msg_OKCancelPsw").addClass('alert-danger');
		$("#alertCont03Msg_OKCancelPsw").hide();
		$("#passwordDelete").val("");
		$('#modal03Msg_OKCancelPsw').modal('show');
	}


	function deleteLogin(ID_usr) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		} else {
			postData = { ID_usr: ID_usr};
			$.ajax({
				type: 'POST',
				url: "15qry_deleteLogin.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Utente eliminato!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requeryUseOverview();						
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
				}
			});
		}
	}

    function deleteMateriaP(ID_mat) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		} else {
			postData = { ID_mat: ID_mat};
			$.ajax({
				type: 'POST',
				url: "15qry_deleteMateriaP.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Materia eliminata!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requerySetMaterieP();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
				}
			});
		}
	}

    function deleteMateria(ID_mtt) {
		let psw = $("#passwordDelete").val();
		let pswOperazioni1 = $("#pswOperazioni1").val();
		if (psw == null || psw == "" || psw !=pswOperazioni1 ) {
			$("#alertMsg03Msg_OKCancelPsw").html('Password Errata!');
			$("#alertCont03Msg_OKCancelPsw").show();
		} else {
			postData = { ID_mtt: ID_mtt};
			$.ajax({
				type: 'POST',
				url: "15qry_deleteMateria.php",
				data: postData,
				dataType: 'json',
				success: function(data){
					$("#remove-content03Msg_OKCancelPsw").slideUp();
					$("#alertMsg03Msg_OKCancelPsw").html('Materia eliminata!');
					$("#alertCont03Msg_OKCancelPsw").removeClass('alert-danger');
					$("#alertCont03Msg_OKCancelPsw").addClass('alert-success');
					$("#alertCont03Msg_OKCancelPsw").show();
					$("#btn_cancel03Msg_OKCancelPsw").html('Chiudi');
					$("#btn_OK03Msg_OKCancelPsw").hide();
					requerySetMaterie();
				},
				error: function(){
					alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools ##fname##'");     
				}
			});
		}
	}




	// function test () {
		
	// 	//sempre per primo l'ID
	// 	var nomiCampiA = ['ID_mtt', 'codmat_mtt', 'descmateria_mtt', 'as_mtt', 'el_mtt', 'me_mtt', 'ord_mtt'];
	// 	var tabella = 'tab_materie';
	// 	var ordinaA = ['0', '0', '1', '1', '1', '1'];
	// 	var ordinaValA = ['--', 'za', 'az', '--', '--', 'az'];
	// 	var defaultOrd = 'accessnumber_usr DESC, currlogon_usr, login_usr ';
	// 	var mostraA = ['0', '1', '1', '1', '1', '1'];


	// 	postData = { nomiCampiA: nomiCampiA, tabella: tabella, ordinaA: ordinaA, ordinaValA: ordinaValA, defaultOrd: defaultOrd};
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: "OrdinaEFiltra.php",
	// 		data: postData,
	// 		dataType: 'html',
	// 		success: function(html){
				
	// 			console.log (html)
				
	// 		}
	// 	});
	// }


	function showModalInsertCodiciObiettivi(ID_mat) {
		caricaTabellaCodiciObiettivi(ID_mat);
		$('#modalAddCodiciObiettivi').modal({show: 'true'});
	}

	function showModalInsertDescObiettivoP() {
		popolaSelectClassi();
		$('#modalAddObiettivoDescP').modal({show: 'true'});
	}

	function caricaTabellaCodiciObiettivi(ID_mat) {
		//console.log ("codob_obi_new:", $('#codob_obi_new').val());
		postData = { IDmat : ID_mat};
		console.log ("15AdmTools.php - caricaTabellaCodiciObiettivi - postData a 15qry_SetCodiciObiettivi.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SetCodiciObiettivi.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#containerTableCodiciObiettivi").html(html);
				$('#codob_obi_new').val("");
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools caricaTabellaCodiciObiettivi'");     
			}
		});

	}

	function deleteCodiceObiettivo(ID_obi, IDmat) {
		postData = { ID_obi : ID_obi };
		console.log ("15AdmTools.php - deleteCodiceObiettivo - postData a 15qry_deleteCodiceObiettivo.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_deleteCodiceObiettivo.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data.test);
				caricaTabellaCodiciObiettivi(IDmat);
				requerySetMaterieP();
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools 15qry_deleteCodiceObiettivo'");     
	        }
		});
	}

	function deleteDescObiettivoP (ID_obd) {
		postData = { ID_obd : ID_obd };
		console.log ("15AdmTools.php - deleteDescObiettivoP - postData a 15qry_deleteDescObiettivo.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_deleteDescObiettivo.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data.test);
				requerySetObiettiviP();
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools deleteDescObiettivoP'");     
	        }
		});
	}

	function aggiungiCodiceObiettivo(IDmat) {
		postData = { IDmat : IDmat, codob_obi: $('#codob_obi_new').val()};
		//console.log ("15AdmTools.php - aggiungiCodiceObiettivo - postData a 15qry_insertCodiceObiettivo.php");
		//console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_insertCodiceObiettivo.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log (data.test);
				caricaTabellaCodiciObiettivi(IDmat);
				requerySetMaterieP();
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools aggiungiCodiceObiettivo'");     
	        }
		});
	}

	function aggiungiDescObiettivo() {
		let postData = $("#form_AddObiettivoDescP").serializeArray();

		postData.push( {name: "desc_obd", value: $('#descrizioneObiettivo').val()});
		console.log ("15AdmTools.php - aggiungiDescObiettivo - postData a 15qry_insertDescObiettivo.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_insertDescObiettivo.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("data.test", data.test);
				requerySetObiettiviP();
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools 15qry_insertDescObiettivo'");     
	        }
		});
	}

	function duplicateObiettivo (ID_obd) {
		postData = {ID_obd: ID_obd};
		console.log ("15AdmTools.php - duplicateObiettivo - postData a 15qry_duplicateDescObiettivo.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_duplicateDescObiettivoP.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				console.log ("data.test", data.test);
				requerySetObiettiviP();
			},
	        error: function(){
	            alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools 15qry_duplicateDescObiettivo'");     
	        }
		});

	}

	function popolaSelectClassi () {
		select_obiettivo = $('#select_obiettivo').val();
		//console.log (select_obiettivo);
		aselme =  select_obiettivo.substring(0, 2);
		postData = {aselme: aselme};
		console.log ("15AdmTools.php - popolaSelectClassi - postData a 15qry_SelectClasse.php");
		console.log (postData);
		$.ajax({
			type: 'POST',
			url: "15qry_SelectClasse.php",
			data: postData,
			dataType: 'html',
			success: function(html){
				$("#selectClassiContainer").html(html);
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '15AdmTools popolaSelectClassi'");     
			}
		});
	}


</script>