<?

//Procedura di recupero dei dati per mostrarli all'utente e consentirgli di scegliere quali importare
	include_once("database/databaseii.php");

	include_once("iscrizioni/diciture.php");
//Arrays per tab_anagraficaalunni ******************************************************************************
	$ID_fam_alu = $_POST['ID_fam_alu'];

	//Array nomi dei campi da estrarre  ATTENZIONE: noniscritto_alu va lasciato per ultimo
	//per aggiungere un campo modificare 
	//$nomicampi, $desccampi, $tooltipcampi, $visinvis $modnonmod
	$nomicampi = array("idle",
	"ID_alu",
	"nome_alu",
	"cognome_alu",
	"indirizzo_alu",
	"citta_alu", 
	"CAP_alu", 
	"prov_alu", 
	"paese_alu", 
	"cf_alu", 
	"mf_alu", 
	"datanascita_alu", 
	"comunenascita_alu", 
	"provnascita_alu", 
	"paesenascita_alu", 
	"cittadinanza_alu", 
	"scuolaprovenienza_alu", 
	"indirizzoscproven_alu", 
	"ckautfoto_alu", 
	"ckautmateriale_alu", 
	"ckautuscite_alu", 
	"quotapromessa_alu", 
	"ratepromesse_alu", 
	"disabilita_alu", 
	"DSA_alu", 
	"tipoquota_alu", 
	"ckautuscitaautonoma_alu",
	"ckdoposcuola_alu",
	"ckreligione_alu",
	"altreligione_alu",
	"ckmensa_alu",
	"cktrasportopubblico_alu",
	"noniscritto_alu");

	//Array descrizione dei campi (comparirà sulla sinistra nel form)
	$desccampi = array("idle", "ID_alu", 
	"Nome", 
	"Cognome", 
	"Indirizzo Res.", 
	"Comune Res.", 
	"CAP Res.", 
	"Prov. Res.", 
	"Paese Res.", 
	"CF", 
	"MF", 
	"Data di nascita", 
	"Comune di nascita", 
	"Prov. Nascita", 
	"Paese Nascita", 
	"Cittadinanza", 
	"Scuola di Provenienza", 
	"Indirizzo Scuola Provenienza", 
	"Aut. Foto", 
	"Aut. uso Materiale", 
	"Aut. Uscite", 
	"Quota", 
	"Rate", 
	"Disabilità", 
	"Disturbo DSA", 
	"Tipo di quota",
	"Aut. Uscita Autonoma",
	"Scelta Doposcuola",
	"Insegnamento Religione",
	"Alternativa alla Religione",
	"Mensa",
	"Trasporto Pubblico",
	"Alunno NON iscritto");

	//Array Tooltip (Comparirà mettendo il mpuse sopra la descrizione del campo)
	$tooltipcampi = array("idle", "", 
	"Nome", 
	"Cognome", 
	"Indirizzo di residenza", 
	"Comune di residenza", 
	"CAP Comune di residenza", 
	"Sigla provincia di residenza", 
	"Paese di residenza", 
	"Codice Fiscale", 
	"Genere", 
	"Data di nascita", 
	"Comune di nascita", 
	"Provincia di Nascita", 
	"Paese di Nascita", 
	"Cittadinanza", 
	"Scuola di Provenienza", 
	"Indirizzo Scuola Provenienza", 
	"Autorizzazione Foto (1=concessa, 0=non concessa)", 
	"Autorizzazione uso Materiale (1=concessa, 0=non concessa)", 
	"Autorizzazione Uscite (1=concessa, 0=non concessa)", 
	"Quota Selezionata", 
	"Numero rate indicate", 
	"Disabilità", 
	"Disturbo DSA", 
	"Tipo di quota selezionata (0=Completa, 1=Ridotta, 2=Minima)", 
	"Autorizzazione Uscita Autonoma (1=concessa, 0=non concessa)",
	"Scelta del Doposcuola (1=richiesto, 0=non richiesto)",
	"Insegnamento Religione (1=scelto, 0=non scelto)",
	"Alternativa scelta alla religione (1=Att. Didattiche, 2=Att. Studio, 3=Non Frequenza)",
	"Mensa (1=scelta, 0=non scelta)",
	"Trasporto Pubblico (1=richiesto, 0=non richiesto)",
	"Alunno NON iscritto");

	//campi visibili (ID_alu ad es non va mostrato e nemmeno i ckmateriale, autfoto e uscite ...perchè?)
	$visinvis  = array("idle", 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1); 
	//campi modificabili dall'utente, cioè in cui l'utente può scegliere quale dei due valori tenere:
	// non vale per ID alu e per i check: non ha senso che la segreteria scelga quali check tenere e quali no. 
	$modnonmod = array("idle", 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1); 

	$numcampi = count($nomicampi); //questa rende il tutto dinamico anche inserendo nuovi campi
//Estrazione dinamica dei valori di tab_anagraficaalunni *******************************************************	
	$alufromDBBTMP = 	array();
	$alufromDBB = 		array();
	$alufromDBATMP = 	array();
	$alufromDBA = 		array();
	
//Costruzione degli elenchi di campi che userò per le query e degli array con i nomi dei campi *****************
	$campiDBB = ""; //questa è la lista dei campi da inserire nella SELECT da databaseA
	$campiDBA = ""; //questa è la lista dei campi da inserire nella SELECT da databaseB

	for ($campo = 1; $campo < $numcampi; $campo++) {
		$alufromDBB[$campo][0] = $nomicampi[$campo];
		$alufromDBA[$campo][0] = $nomicampi[$campo];
		$campiDBB = $campiDBB.", ".$nomicampi[$campo];
	}

	//l'estrazione dal dbA non seleziona anche non iscritto_alu quindi lì l'elenco dei campi deve fermarsi al penultimo
	for ($campo = 1; $campo < $numcampi - 1; $campo++) {
		$campiDBA = $campiDBA.", ".$nomicampi[$campo];
	}

	//tolgo i primi due caratteri che sono ", "
	$campiDBB = substr($campiDBB, 2); 
	$campiDBA = substr($campiDBA, 2); 


//Estrazione da DbB *********************************************************************************************
	$sqlB = "SELECT ".$campiDBB." FROM ".$_SESSION['databaseB'].".tab_anagraficaalunni WHERE ID_fam_alu = ".$ID_fam_alu;
	$stmtB = mysqli_prepare($mysqli, $sqlB);
	//il numero di campi è dinamico quindi la bind_result deve usare un ARRAY ($fields) di variabili.
	//attenzione: non interessa qui il VALORE di questi campi ma la REFERENCE ad essi per cui sono richiamati con la sintassi &$
	$fieldsB = array(&$stmtB); //il primo elemento sarà $stmt, infatti $fieldsB va poi passato a mysqli_stmt_bind_result che richiede stmt come primo argomento.
	//In questa riga potrei anche aggiungere altri campi di nome fisso...ma in verità li aggiungo tutti in maniera dinamica
	for ($campo = 1; $campo < $numcampi; $campo++) {
		$fieldsB[$campo] = & $alufromDBBTMP[$campo]; //anche qui aggiungo non il campo ma la REFERENCE a quel campo (c'è la & davanti)
	}
	//a questo punto ho (numcampi-1) campi nell'array fields  di tipo referenced (&...) di cui il primo è $stmt...
	//ora i campi in numero dinamico inseriti tramite reference in $fields possono essere utilizzati con la funzione call_user_func_array
	call_user_func_array ("mysqli_stmt_bind_result", $fieldsB);
	$stmtB->execute();
	mysqli_stmt_store_result($stmtB);
	//print_r($fieldsB);
	$alunno = 0;
	while (mysqli_stmt_fetch($stmtB)) {
		//I valori sono stati estratti ed inseriti in (numcampi-1) campi che si chiamano tutti $alufromDBBTMP[$x]
		//ora i valori vanno travasati a $alufromDBB[1][1], $alufromDBB[2][1] ecc.
		//ci sono tanti record quanti i fratelli presenti in questa famiglia, quindi PER OGNI FRATELLO popolo un array
		$alunno++;
		for ($campo = 1; $campo < $numcampi; $campo++) {
			//voglio mostrare e quindi poi importare sempre 0 e non -1 dove ci sono dei campi di tipo "ck"
			//lascio in DBB -1 perchè lì SERVE che -1 resti -1:
			//i valori delle radio button vuoti devono essere -1 se non selezionati altrimenti non vengono poi riprodotti
			if (substr ($nomicampi[$campo], 0, 2)  == "ck" && $alufromDBBTMP[$campo] == -1) {$alufromDBBTMP[$campo] = 0;} 
			$alufromDBB[$campo][$alunno] = $alufromDBBTMP[$campo];
		}

		//sto estraendo uno ad uno gli alunni dal DB B
		//ora per ciascun alunno vado a cercare in DB A
		//metto l'id (che si trova nella posizione 1) in una variabile
		$aluidtosearch = $alufromDBB[1][$alunno];
		//estraggo da DB A i valori dei campi
		$sqlA = "SELECT ".$campiDBA." , 0 FROM ".$_SESSION['databaseA'].".tab_anagraficaalunni WHERE ID_alu = ".$aluidtosearch;
		$stmtA = mysqli_prepare($mysqli, $sqlA);
		//il numero di campi è dinamico quindi la bind_result deve usare un ARRAY ($fields) di variabili.
		//attenzione: non interessa qui il VALORE di questi campi ma la REFERENCE ad essi per cui sono richiamati con la sintassi &$
		$fieldsA = array(&$stmtA); //il primo elemento sarà stmtA, infatti $fieldsA va passato a mysqli_stmt_bind_result che richiede stmt come primo argomento.
		//In questa riga potrei anche aggiungere altri campi di nome fisso...ma in verità li aggiungo tutti in maniera dinamica
		for ($campo = 1; $campo < $numcampi; $campo++) {
			$fieldsA[$campo] = & $alufromDBATMP[$campo];
		}
		//a questo punto ho n campi nell'array fields (numcampi - 1) di cui il primo è $stmtA...ora i campi in numero dinamico inseriti tramite reference in $fields possono essere utilizzati con la funzione call_user_func_array
		call_user_func_array ("mysqli_stmt_bind_result", $fieldsA);
		$stmtA->execute();
		mysqli_stmt_store_result($stmtA);
		
		while (mysqli_stmt_fetch($stmtA)) {
			//Le info estratte vengono inserite in (numcampi -1) campi che si chiamano tutti $alufromDBBA e precisamente in $alufromDBA[1][nalunno], $alufromDBA[2][nalunno] ecc.
			for ($campo = 1; $campo < $numcampi; $campo++) {
				$alufromDBA[$campo][$alunno] = $alufromDBATMP[$campo];
			}
		}
	}

	//sono uscito dopo n iterazioni e quindi il numero di fratelli è = $alunno
	$fratelli = $alunno;

	
	
//Arrays per tab_famiglie **************************************************************************************

	//Array nomi dei campi da estrarre
	//per aggiungere un campo modificare 
	//$nomicampi, $desccampi, $tooltipcampi, $visinvis $modnonmod
	$nomicampifam = array("idle", "cognome_fam", "sociopadre_fam", "cognomepadre_fam", "nomepadre_fam", "datanascitapadre_fam", "comunenascitapadre_fam", "provnascitapadre_fam", "paesenascitapadre_fam", "cfpadre_fam", "indirizzopadre_fam", "comunepadre_fam", "CAPpadre_fam", "provpadre_fam", "paesepadre_fam", "telefonopadre_fam", "altrotelpadre_fam", "emailpadre_fam", "titolopadre_fam", "profpadre_fam", "ckcarpoolingpadre_fam", "sociomadre_fam", "cognomemadre_fam", "nomemadre_fam", "datanascitamadre_fam", "comunenascitamadre_fam", "provnascitamadre_fam", "paesenascitamadre_fam", "cfmadre_fam", "indirizzomadre_fam", "comunemadre_fam", "CAPmadre_fam", "provmadre_fam", "paesemadre_fam", "telefonomadre_fam", "altrotelmadre_fam", "emailmadre_fam", "titolomadre_fam", "profmadre_fam", "ckcarpoolingmadre_fam", "quotacontraggiuntivo_fam", "ratecontraggiuntivo_fam", "intestazionefatt_fam", "modalitapag_fam", "pulizie_fam", "richcolloquio_fam", "ratepromesse_fam", "ibanpadre_fam", "ibanmadre_fam", "ruolopadre_fam","ruolomadre_fam");
	$desccampifam = array("idle", "Cognome Famiglia", "Socio padre", "Cognome padre", "Nome padre", "Data nascita padre", "Comune nascita padre", "Prov nascita padre", "Paese nascita padre", "CF padre", "Indirizzo padre", "Comune Res padre", "CAP Res. padre", "Prov. Res. padre", "Paese Res. padre", "Tel padre", "Altro Tel padre", "email padre", "Titolo padre", "Professione padre", "Carpooling Padre", "Socio madre", "Cognome madre", "Nome madre", "Data nascita madre", "Comune nascita madre", "Prov nascita madre", "Paese nascita madre", "CF madre", "Indirizzo madre", "Comune Res madre", "CAP Res. madre", "Prov. Res. madre", "Paese Res. madre", "Tel madre", "Altro Tel madre", "email madre", "Titolo madre", "Professione madre", "Carpooling Madre", "Quota Contributo Agg.", "Rate Contributo Agg.", "Intestazione Fattura", "Modalità Pagamento", "Pulizie", "Richiesto Colloquio", "Numero rate Indicate", "IBAN Padre", "IBAN madre", "Ruolo Padre", "Ruolo Madre");
	$tooltipcampifam = array("idle", "Cognome Famiglia", "Socio padre", "Cognome padre", "Nome padre", "Data di nascita padre", "Comune di nascita padre", "Provincia di nascita padre", "Paese di nascita padre", "Codice Fiscale padre", "Indirizzo padre", "Comune di Residenza padre", "CAP di Residenza padre", "Provincia di Residenza padre", "Paese di Residenza padre", "Telefono padre", "Altro Telefono padre", "email padre", "Titolo padre", "Professione padre", "Adesione a Progetto Carpooling Padre", "Socio madre", "Cognome madre", "Nome madre", "Data di nascita madre", "Comune di nascita madre", "Provincia di nascita madre", "Paese di nascita madre", "Codice Fiscale madre", "Indirizzo madre", "Comune di Residenza madre", "CAP di Residenza madre", "Provincia di Residenza madre", "Paese di Residenza madre", "Telefono madre", "Altro Telefono madre", "email madre", "Titolo madre", "Professione madre", "Adesione a Progetto Carpooling Madre",  "Quota Contributo Aggiuntivo liberale", "Rate Contributo Aggiuntivo liberale", "Intestazione della Fattura", "Modalità di Pagamento (0=Disposizione Permanente, 1=Bonifico, 2=Contanti) ", "Pulizie (0=svolte, 1=pagate)", "Richiesto Colloquio (0=no, 1=si)", "Numero rate Indicate", "IBAN Padre - per SDD", "IBAN Madre - per SDD", "Ruolo Padre", "Ruolo Madre");
	$visinvisfam = array("idle", 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1 );
	$modnonmodfam = array("idle", 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1 ,1, 1, 1, 1, 1, 1, 1 );

	$numcampifam = count($nomicampifam); //questa rende il tutto dinamico anche inserendo nuovi campi
//Estrazione dinamica dei valori di tab_anagraficaalunni *******************************************************	

	$famfromDBBTMP = array();
	$famfromDBB = array();
	
	$famfromDBATMP = array();
	$famfromDBA = array();
	$fieldsB = array();
	$fieldsA = array();

	$stringaSQLfam1 = "";
	for ($x = 1; $x < $numcampifam; $x++) {
		$famfromDBB[$x][0] = $nomicampifam[$x];
		$famfromDBA[$x][0] = $nomicampifam[$x];
		$stringaSQLfam1 = $stringaSQLfam1.", ".$nomicampifam[$x];
	}

	$stringaSQLfam1 = substr($stringaSQLfam1, 2);

	//per la descrizione del procedimento vedi come è stata fatta per tab_anagraficaalunni poco più sopra
	$sqlB = "SELECT ".$stringaSQLfam1." FROM ".$_SESSION['databaseB'].".`tab_famiglie` WHERE `ID_fam`= ".$ID_fam_alu;
	$stmtB = mysqli_prepare($mysqli, $sqlB);
	$fieldsB = array(&$stmtB);
	for ($x = 1; $x < $numcampifam; $x++) {
		$fieldsB[$x] = & $famfromDBBTMP[$x]; //aggiungo le reference ai campi
	}
	call_user_func_array ("mysqli_stmt_bind_result", $fieldsB);
	$stmtB->execute();
	mysqli_stmt_store_result($stmtB);
	$n = 0; //in verità n non serve, viene tenuto per omogenietà con gli alunni (nel caso delle famiglie sarà sempre = 1)
	while (mysqli_stmt_fetch($stmtB)) {
		$n++;
		for ($campo = 1; $campo < $numcampifam; $campo++) {

			if (substr ($nomicampifam[$campo], 0, 2)  == "ck" && $famfromDBBTMP[$campo] == -1) {$famfromDBBTMP[$campo] = 0;} 
			$famfromDBB[$campo][$n] = $famfromDBBTMP[$campo];
		}
	}
	
	//per la descrizione del procedimento vedi come è stata fatta per tab_anagraficaalunni poco più sopra
	$sqlA = "SELECT ".$stringaSQLfam1." FROM ".$_SESSION['databaseA'].".`tab_famiglie` WHERE `ID_fam`= ".$ID_fam_alu;
	$stmtA = mysqli_prepare($mysqli, $sqlA);
	$fieldsA = array(&$stmtA);
	for ($x = 1; $x < $numcampifam; $x++) {
		$fieldsA[$x] = & $famfromDBATMP[$x];
	}
	call_user_func_array ("mysqli_stmt_bind_result", $fieldsA);
	$stmtA->execute();
	mysqli_stmt_store_result($stmtA);
	$n = 0;
	while (mysqli_stmt_fetch($stmtA)) {
		$n++;
		for ($campo = 1; $campo <= $numcampifam; $campo++) {
			$famfromDBA[$campo][$n] = $famfromDBATMP[$campo];
		}
	}
	
	

	//alufromDBB[numerocampo (da 1 a (numcampi-1))][numerofratello]
	//alufromDBA[numerocampo (da 1 a (numcampi-1))][numerofratello]
	//famfromDBB[numerocampo (da 1 a (numcampifam-1)][1]
	//famfromDBA[numerocampo (da 1 a (numcampifam-1))][1]	
	
	

	?>
<!-- Costruzione dinamica della <table> html con i dati presenti nelle matrici costruite più sopra ********* -->
<!-- Intestazione ****************************************************************************************** -->
			<div id="messaggionorecords" class="alert alert-success">
				
			Non ci sono dati diversi da quelli già presenti in SWAPP<br>L'importazione non andrà a modificare alcun valore, eventualmente ad aggiungerne.
			</div>
			
			<div style="font-size: 14px;">Se si desidera non importare qualche dato scegliere l'opzione di sinistra del campo interessato</div>
			<div style="margin-bottom: 10px;">
				<input type="radio" id="ck_visibilitadiversi" name="ck_visibilita" value="1" checked onclick="Visibilita();"> Mostra solo i valori diversi 
				<input style="margin-left: 20px;" type="radio" name="ck_visibilita" value="2" onclick="Visibilita();"> Mostra tutti i valori in importazione
			</div>
			<div>
				<input type="text" id="n_alunni" name="n_alunni" value="<?=$alunno?>" hidden>
				<input type="text" id="ID_fam" name="ID_fam" value="<?=$ID_fam_alu?>" hidden>
			</div>
	<table style="margin-bottom: 10px; ">
		
		<thead>
			<tr>
				<td>
					<input class="tablelabel4" " type="text"  value = "Descrizione" style="width:250px" disabled>
				</td>

				<td>
					<input class="tablelabel4" " type="text"  value = "Valore già presente in SWAPP" style="width:250px" disabled>
				</td>
				<td>
					<input class="tablelabel4" " type="text"  value = "Opzione scelta" style="width:100px; " disabled>
				</td>
				<td>
					<input class="tablelabel4" type="text"  value = "Compilato dai Genitori" style="width:250px" disabled>
				</td>
				<?//if ($alufromDBB[$x][$y] != $alufromDBA[$x][$y]) {};?>
			</tr>
		</thead>
		<tbody>
<!-- Estrazione Famiglia *********************************************************************************** -->
			<?
				$j = 1; //(tengo per uniformità con i figli anche questo parametro che però sarà sempre = 1)
					for ($x = 1; $x < $numcampifam; $x++) { //x rappresenta il campo
						?>
						<tr <?if (($famfromDBB[$x][$j] == $famfromDBA[$x][$j]) || ($visinvisfam[$x] == 0) || ($famfromDBA[$x][$j] == "1900-01-01")) {echo ("class='tabinvis' style='display: none'");};?>>
							<td>
								<input class="tablecell5" " data-toggle="tooltip" title="<?=$tooltipcampifam[$x]?>"type="text"  value = "<?=$desccampifam[$x]?>" style="width:250px" disabled>
							</td>

							<td>
								<input class="tablecell5" " type="text"  name="<?="fam-".$ID_fam_alu."-".$famfromDBA[$x][0]?>-1" value = "<?=$famfromDBA[$x][$j]?>" style="width:250px" readonly>
							</td>
							<td >
								<input type="radio" <?if ($modnonmodfam[$x]==0) {echo "style='display:none'";}?> name="fam-<?=$ID_fam_alu."-".$famfromDBA[$x][0]?>-ck" value="1" <?//if($famfromDBB[$x][$j]==""){echo("checked");}?>>
								<input type="radio" <?if ($modnonmodfam[$x]==0) {echo "style='display:none'";}?> name="fam-<?=$ID_fam_alu."-".$famfromDBA[$x][0]?>-ck" value="2" <?//if($famfromDBB[$x][$j]!=""){echo("checked");}?> checked>
							</td>
							<td>
								<input class="tablecell5" type="text"  name="<?="fam-".$ID_fam_alu."-".$famfromDBB[$x][0]?>-2" value = "<?=$famfromDBB[$x][$j]?>" style="width:250px">
							</td>
							
						</tr>
						<?
					}
				
			?>
<!-- Estrazione Fratelli *********************************************************************************** -->
			<?
				for ($j = 1; $j <=$fratelli; $j++) { //j rappresenta l'alunno, potrebbero essercene n
					?><tr>
						<td colspan="4" 
							<?if ($alufromDBB[$numcampi - 1][$j] == 1) {
								echo ("style='background-color: red; color: white'");
							} else {
								echo ("style='background-color: grey; color: white'");
							}?>
						>
							<?if ($alufromDBB[$numcampi-1][$j] == 1) {
								echo("- Alunno: ".$alufromDBB[2][$j]." ".$alufromDBB[3][$j]." NON ISCRITTO -");
							} else {
								echo("- Importazione dati di: ".$alufromDBB[2][$j]." ".$alufromDBB[3][$j]." -");
							}
							?>
						</td>
					</tr><?
					for ($x = 1; $x < $numcampi; $x++) {//x rappresenta il campo ?>
						
						<tr <? if (($alufromDBB[$x][$j] == $alufromDBA[$x][$j]) || ($visinvis[$x] == 0)) { 
							//cioè se sono uguali oppure se non sono da mostrare non li mostro e aggiungo la classe tabinvis
							echo ("class='tabinvis' style='display: none'");
						}
						?>
						>
							<td>
							<?//=$alufromDBB[$x][$j]?>
							<?//=$alufromDBA[$x][$j]?>
							<?//=$visinvis[$x]?>
							<?//if (($alufromDBB[$x][$j] == $alufromDBA[$x][$j]) || ($visinvis[$x] == 0) || ($alufromDBA[$x][$j] == ""))  {echo ("una delle tre");}?>
								<input class="tablecell5" " type="text"  data-toggle="tooltip" title="<?=$tooltipcampi[$x]?>" value = "<?=$desccampi[$x]." ".$alufromDBA[2][$j]?>" style="width:250px" disabled>
							</td>

							<td>
								<input class="tablecell5" " type="text"  name="<?="alu-".$alufromDBA[1][$j]."-".$alufromDBA[$x][0]?>-1" value = "<?=$alufromDBA[$x][$j]?>" style="width:250px" readonly>
							</td>
							<td >
								<input type="radio" <?if ($modnonmod[$x]==0) {echo "style='display:none'";}?> name="alu-<?=$alufromDBA[1][$j]."-".$alufromDBA[$x][0]?>-ck" value="1" <?//if($alufromDBB[$x][$j]==""){echo("checked");}?>>
								<input type="radio" <?if ($modnonmod[$x]==0) {echo "style='display:none'";}?> name="alu-<?=$alufromDBA[1][$j]."-".$alufromDBA[$x][0]?>-ck" value="2" <?//if($alufromDBB[$x][$j]!=""){echo("checked");}?> checked>
							</td>
							<td>
								<input class="tablecell5" type="text"  name="<?="alu-".$alufromDBB[1][$j]."-".$alufromDBB[$x][0]?>-2" value = "<?=$alufromDBB[$x][$j]?>" style="width:250px">
							</td>
							
						</tr>
						<?
					}
				}
			?>
		</tbody>

	</table>
	<input id="campialu_hidden" 	value = "<?=$numcampi?>"			hidden>
	<input id="campifam_hidden" 	value = "<?=$numcampifam?>"			hidden>
	<input id="fratelli_hidden" 	value = "<?=$fratelli?>"			hidden>
	<script>
		function Visibilita() {
			if ($('#ck_visibilitadiversi').is(':checked')) { $('.tabinvis').hide();} else { $('.tabinvis').show();}
			//conto quanti sono con tabinvis
			campialu = $("#campialu_hidden").val();
			campifam = $("#campifam_hidden").val();
			fratelli = $("#fratelli_hidden").val();
			numItemsTot = (campialu -1) * fratelli + (campifam -1);
			var numItems = numItemsTot - $('.tabinvis').length;
			console.log (numItems);
			if (numItems == 0) {
				$('#messaggionorecords').show();
			} else {
				$('#messaggionorecords').hide();
			}
			
		}
	</script>


