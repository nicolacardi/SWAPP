<?session_start()?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" type="image/png" href="img/favicon2.png"/>
<title>Gestionale Materiale Didattico</title>
<link rel="stylesheet" href="css/reset.css"/>
<link rel="stylesheet" href="css/main.css"/>
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
</head>


<body style="background-size: cover;" background="img/bg2b.jpg">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/funzioni_jquery.js"></script>
<script type="text/javascript" src="js/clock.js"></script>


<div id="content"></div>

    
<?php

require 'core.inc.php';
require 'connect.inc.php';

if (!loggedin()) {
echo "<h3>You are not Logged in</h3><br>";
echo '<h3><a href="index.php">Login page</a></h3>';
die();
}
?>



   
    
<div id="logo">
<h6><a onclick="return confirm('LOGOUT: Sei sicuro di voler uscire?')" href="logout.php"><img src="img/user2.png"></a><br /><?php $username = getuserfield ('username'); echo $username;?> <br /></h6>
<h6><div id="clockbox"></div></h6>
</div>

<div id="mySidenav" class="sidenav">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


            <a href="articoli.php">Elenco Articoli</a>
            <a style="font-size:xx-small; margin-left: 20px;" href="console.php" >Articoli Sotto Scorta</a>
            <a href="fornitori.php">Elenco Fornitori</a>
            <a href="clienti.php">Elenco Clienti</a>
            <a href="movimenti.php">Movimenti Magazzino</a>
            <a href="download.php">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>
<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>
<main>
<?php

if (loggedin()) {
	
	
	//questa prima parte attribuisce i valori (utilizzando la chiave GET[art_id] alle variabili, che poi vengono usate nel form  come values
	if (isset($_GET['art_id'])){
		
		$art_id = ($_GET['art_id']);
		
		//query per estrarre articolo in questione
		
		$query = "SELECT `articoli`.`ART_ID`, `articoli`.`ART_COD`, `articoli`.`ART_DESC`, `articoli`.`ART_QTY_STOCK`, `articoli`.`ART_QTY_REORDER`, `articoli`.`FOR_ID`, `articoli`.`TIP_ID` FROM `articoli` WHERE `articoli`.`ART_ID`='".$art_id."'"; 
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $art_id, $art_cod, $art_desc, $art_qty_stock, $art_qty_reorder, $for_id, $tip_id);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			
			while (mysqli_stmt_fetch($stmt)) {
					
					$art_cod = $art_cod;
					$art_desc = $art_desc;
					$for_id = $for_id;
					$tip_id = $tip_id;
					$art_qty_stock = $art_qty_stock;
					$art_qty_reorder = $art_qty_reorder;
			}
		} else {
		echo "più di un record?";
		}
	}
}

//<!---------------------------------------- CASO DELETE------------------------------------------->
if (isset($_GET['artfor_iddelete'])){
	$artfor_iddelete=($_GET['artfor_iddelete']);
	//verifico che in tabella s_carichi non sia presente
	//Verifica se l'articolo da cancellare è presente nella tabella 

	$query2= "SELECT DATE_FORMAT(`TIME`, '%d %m %Y') as `dataformattata` FROM `s_carichi` WHERE `ARTFOR_ID` = ".$artfor_iddelete;
		$stmt2 = mysqli_prepare($mysqli, $query2);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $dataformattata);
		mysqli_stmt_store_result($stmt2);
		if (mysqli_stmt_num_rows($stmt2) >=1) {
			while (mysqli_stmt_fetch($stmt2)) {
			}
			$s_car_time = $dataformattata;
			echo '<h3 class="warn"> fornitore non cancellabile da questo articolo in quanto presente nella tabella carichi-scarichi, associato almeno al carico o scarico del: "'.$s_car_time.'"</h3>';
		} else {
			
			//Metto in $art_desc la descrizione per inserirla nel log dopo la cancellazione
			$query3= "SELECT `fornitori`.`FOR_RAGSOC` FROM (`fornitori` INNER JOIN `articolifornitori` ON `fornitori`.`FOR_ID` = `articolifornitori`.`FOR_ID`) WHERE `articolifornitori`.`ARTFOR_ID` = '".$artfor_iddelete."'";
			$stmt3 = mysqli_prepare($mysqli, $query3);
			mysqli_stmt_execute($stmt3);
			mysqli_stmt_bind_result($stmt3, $for_ragsoc);
			mysqli_stmt_store_result($stmt3);
			if (mysqli_stmt_num_rows($stmt3) >=1) {
				while (mysqli_stmt_fetch($stmt3)) {
				}
			}
			
			$query4 = "DELETE FROM `articolifornitori` WHERE `ARTFOR_ID` = ".$artfor_iddelete;
			$stmt4 = mysqli_prepare($mysqli, $query4);
			mysqli_stmt_execute($stmt4);
			
		
			//Ora aggiorna anche il Log
			$logsino = getuserfield ('LOG');
			if ($logsino == 1) {
				$query5 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `FOR_ID`, `FOR_RAGSOC`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione articolofornitore', '".$artfor_iddelete."', '".$for_ragsoc."' )";
				$stmt5 = mysqli_prepare($mysqli, $query5);
				mysqli_stmt_execute($stmt5);
				//fine aggiornamento log
			}
		}
}



//<!---------------------------------------- INIZIO SUBMIT------------------------------------------->



if(isset($_POST['salva'])) {
	// è stato premuto il pulsante salva
   	// se manca ART_ID allora trattasi di uno nuovo e quindi non devo fare una UPDATE ma una INSERT!!
	//prima di tutto cerco di capire quanti record ci sono nella tabella dei fornitori, se uno solo no problem, ma se più di uno devo ciclare su tutti
	
	
	
   
	if (
	isset ($_POST['ART_ID']) &&
	isset ($_POST['ART_COD']) &&
	isset ($_POST['ART_DESC']) &&
	isset ($_POST['TIP_DESCCOMBO']) &&
	//isset ($_POST['ART_QTY_STOCK']) &&
	isset ($_POST['ART_QTY_REORDER']) &&
	isset ($_POST['FOR_RAGSOCCOMBO1']) &&
	isset ($_POST['ARTFOR_CODEXT1']) &&
	isset ($_POST['ARTFOR_PXLISTTOT1']) &&
	isset ($_POST['ARTFOR_DISC1']) &&
	//isset ($_POST['ARTFOR_PXTOT1']) &&
	isset ($_POST['ARTFOR_CONF1']) &&
	isset ($_POST['ARTFOR_PXUNIT_V1'])
	) { //significa: "se è stato premuto il tasto submit"
		
		//assegna le variabili dai vari POST
		$art_id = $_POST['ART_ID'];
		$art_cod = $_POST['ART_COD'];
		$art_desc = $_POST['ART_DESC'];
		$tip_id = $_POST['TIP_DESCCOMBO'];
		//$art_qty_stock = $_POST['ART_QTY_STOCK'];
		$art_qty_reorder = $_POST['ART_QTY_REORDER'];  
		$for_ragsoccombo1 = $_POST['FOR_RAGSOCCOMBO1'];
		$artfor_codext1 = $_POST['ARTFOR_CODEXT1'];
		$artfor_pxlisttot1 = $_POST['ARTFOR_PXLISTTOT1'];
		$artfor_disc1 = $_POST['ARTFOR_DISC1'];
		//$artfor_pxtot1 = $_POST['ARTFOR_PXTOT1'];
		$artfor_conf1 = $_POST['ARTFOR_CONF1'];
		$artfor_pxunit_v1 = $_POST['ARTFOR_PXUNIT_V1'];
		if ($artfor_conf1 == 0) { $artfor_conf1=1;}
		
		//if (empty($art_qty_stock)) {$art_qty_stock='0';}	
		if (empty($art_qty_reorder)){$art_qty_reorder='0';}


		$nfornitori = 0;
		if (isset ($_POST['NFORNITORI'])){
		$nfornitori = ($_POST['NFORNITORI']);
		//echo $nfornitori;
		} //fine isset $_POST['NFORNITORI']
		
		//In teoria non è + necessario contare quanti ne vengono messi di default, perchè le funzioni jquery impediscono che ne venga selezionato + di uno
		$contaquantidefault = 0;
		for ( $fornitore = 1 ; $fornitore <= ($nfornitori+1) ; $fornitore++) {
						if (empty($_POST['ARTFOR_DEFAULT'.$fornitore])) {
							} else {
							$contaquantidefault++;
							}
		} // fine for
		//echo 'default'.$contaquantidefault.'<br>';	


		/*//riempio temporaneamente una tabella TMP con i fornitori, prima la cancello però.
		$query = "DELETE FROM `articolifornitoriTMP`";
		$query_run = mysql_query ($query);
		for ( $fornitore = 1 ; $fornitore <= $nfornitori ; $fornitore++) {
							$for_ragsoccomboX = $_POST['FOR_RAGSOCCOMBO'.$fornitore];							
							$queryTMP = "INSERT INTO `articolifornitoriTMP` (`ART_ID`, `FOR_ID`) VALUES ('".$art_id."', '".$for_ragsoccomboX."')";
							$query_runTMP = mysql_query ($queryTMP);
		} // fine for $fornitore
		//ora conto quanti di goni fornitore: devono essere al massimo 1 altrimenti significa che ho selezionato due volte 
		$querycount = "SELECT MAX(`counted`) FROM
						(
							SELECT COUNT(`FOR_ID`) AS `counted`
							FROM `articolifornitoriTMP`
							GROUP BY `FOR_ID`
						) AS `counts`;";
		$query_runcount = mysql_query ($querycount);
		$doppioni = 0;
		$query_row = mysql_fetch_array($query_runcount);
		if(!($query_row['counts']==1)){
			$doppioni= 1;
		}*/
		
		
		
		$testedart_cod = (test_input($art_cod));
		$testedart_desc = (test_input($art_desc));
		
		//echo ("testedart_cod".$testedart_cod." testedart_desc".$testedart_desc." tip_id".$tip_id." for_ragsoccombo1".$for_ragsoccombo1);
				
				
		if (
		!empty ($testedart_cod) &&  	//Codice Articolo Scuola "Tested"
		!empty ($testedart_desc) &&		//Descrizione "Tested"
		!empty ($tip_id) &&				//Tipologia
		!empty ($for_ragsoccombo1) /*&&	//Ragione Sociale
		!empty ($artfor_codext1) /*&&
		!empty ($artfor_pxtot1) &&
		!empty ($artfor_conf1)/*&&
		//!empty ($for_ragsoc) &&
		!empty ($art_qty_stock) &&
		!empty ($art_qty_reorder)*/ ) {
			// devo verificare che ci sia uno e un solo fornitore con default = 1. Altrimenti va in casino tutto perchè aggiorno for_id in articoli tutte le 		volte che trova default = 1. Ma peggio ancora se non c'è alcun default segnato allora non ne mette nessuno e questo èa cneh + grave
			if ($contaquantidefault==1) {
				//if($doppioni==1) {	
					//se nessuno è vuoto allora il codice va aggiornato
					// se ART_ID è vuoto allora sto creando un articolo nuovo e quindi non devo fare una UPDATE ma una INSERT
					
					if (empty ($art_id)) {
						
						$query6 = "INSERT INTO `articoli` (`ART_COD`, `ART_DESC`, `TIP_ID`, `ART_QTY_STOCK`, `ART_QTY_REORDER`) VALUES ('".test_input($art_cod)."', '".test_input($art_desc)."', '".test_input($tip_id)."', 0, '".test_input($art_qty_reorder)."')";
						//ora bisogna estrarre e mettere in $art_id il valore dell'ultimo art_id inserito automaticamente, serve per il seguito
						echo $query6;
						$stmt6 = mysqli_prepare($mysqli, $query6);
						mysqli_stmt_execute($stmt6);

						
						//Ora aggiorna anche il Log
						$logsino = getuserfield ('LOG');
						
						if ($logsino == 1) {
							$query7 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `ART_ID`, `ART_DESC`) VALUES ( '".$_SESSION['user_id']."', 'aggiunta articolo', '".test_input($art_id)."', '".test_input($art_desc)."' )";
							$stmt7 = mysqli_prepare($mysqli, $query7);
							mysqli_stmt_execute($stmt7);
							//echo $querylog;
							//fine aggiornamento log
						}
									
						
						

						$query8 = "SELECT MAX(`ART_ID`) FROM `articoli` ";
						$stmt8 = mysqli_prepare($mysqli, $query8);
						mysqli_stmt_execute($stmt8);
						mysqli_stmt_bind_result($stmt8, $art_id);
						while (mysqli_stmt_fetch($stmt8)) {
						}

						//$art_id = mysql_result(mysql_query($query_last_id), 0);
						
	
						//echo $query;
						echo '<h3 class="info"> Record Inserito</h3>';
					} else {
						
						$query9 = "UPDATE `articoli` SET `ART_COD`='".test_input($art_cod)."', `ART_DESC`='".test_input($art_desc)."', `TIP_ID`='".test_input($tip_id)."', `ART_QTY_REORDER`='".test_input($art_qty_reorder)."' WHERE `ART_ID`='".$art_id."'"; 
						
						$stmt9 = mysqli_prepare($mysqli, $query9);
						mysqli_stmt_execute($stmt9);

						echo '<h3 class="info"> Record Salvato</h3>';
						
						//Ora aggiorna anche il Log
						$query10 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `ART_ID`, `ART_DESC`) VALUES ( '".$_SESSION['user_id']."', 'modifica articolo', '".test_input($art_id)."', '".test_input($art_desc)."' )";
						$stmt10 = mysqli_prepare($mysqli, $query10);
						mysqli_stmt_execute($stmt10);
						//echo $querylog;
						//fine aggiornamento log
						
						
					} //fine empty($art_id)
					
					
					
					
					//a questo punto mi occupo della tabella sottostante che riguarda la tabella articolofornitore dove andare a fare la INSERT oppure l UPDATE
					//sono già dentro la if che verifica se i campi dell'articolo e quelli del primo record articolofornitori sono compilati
		
					
					
		
					
					
						//Cancello prima tutti i record in articolofornitore con ART_ID = a quello attuale
						
						if (!empty ($art_id)) {
							$query11 ="DELETE FROM `articolifornitori` WHERE `ART_ID` ='".$art_id."'";
							$stmt11 = mysqli_prepare($mysqli, $query11);
							mysqli_stmt_execute($stmt11);
							//echo '<br>'.$querydelete;
							
							//Ora aggiorna anche il Log
							$query12 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `ART_ID`, `ART_DESC`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione tutti articolifornitori', '".test_input($art_id)."', '".test_input($art_desc)."' )";
							$stmt12 = mysqli_prepare($mysqli, $query12);
							mysqli_stmt_execute($stmt12);
							//echo $querylog;
							//fine aggiornamento log
						
						
						} //fine empty($art_id)
						
						//E poi inserisco quelli che si trovano sulla pagina al momento
						//mi serve sapere se ce ne sia uno nuovo, anche
						$ceunrecordnuovo = 0;
						if (!(empty ($_POST['FOR_RAGSOCCOMBO'.($nfornitori+1)]))){
							$ceunrecordnuovo = 1;
						}
						
						
						for ( $fornitore = 1 ; $fornitore <= ($nfornitori + $ceunrecordnuovo) ; $fornitore++) {
								
								$for_ragsoccomboX = $_POST['FOR_RAGSOCCOMBO'.$fornitore];
								if (empty($_POST['ARTFOR_DEFAULT'.$fornitore])) {
									$artfor_defaultX= '0';
									} else {
									$artfor_defaultX= '1';
									//e qui devo fare la UPDATE della ARTICOLI, anche, ma solo in fase UPDATE e non INSERT
										if (!empty ($art_id)) {
											$query13 ="UPDATE `articoli` SET `FOR_ID` ='".$for_ragsoccomboX."' WHERE `ART_ID`='".$art_id."'";
											//echo '<br>'.$queryupdate;
											$stmt13 = mysqli_prepare($mysqli, $query13);
											mysqli_stmt_execute($stmt13);
											
													//Ora aggiorna anche il Log
													$query14 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `ART_ID`, `ART_DESC`, `FOR_ID`) VALUES ( '".$_SESSION['user_id']."', 'inserimento articolifornitori', '".test_input($art_id)."', '".test_input($art_desc)."', '".test_input($for_ragsoccomboX)."' )";
													$stmt14 = mysqli_prepare($mysqli, $query14);
													mysqli_stmt_execute($stmt14);
													//echo $querylog;
													//fine aggiornamento log
							
							
										} // fine !empty ($art_id))
									} //fine empty($_POST['ARTFOR_DEFAULT'.$fornitore])) 
								
								$artfor_codextX= $_POST['ARTFOR_CODEXT'.$fornitore];
								$artfor_confX= $_POST['ARTFOR_CONF'.$fornitore];
								$artfor_pxlisttotX= $_POST['ARTFOR_PXLISTTOT'.$fornitore];
								$artfor_discX= $_POST['ARTFOR_DISC'.$fornitore];
								$artfor_pxtotX= $artfor_pxlisttotX*(1-($artfor_discX/100));
								$artfor_pxunit_vX = $_POST['ARTFOR_PXUNIT_V'.$fornitore];
								if ($artfor_confX == 0) { $artfor_confX = 1 ;}
								if (!($artfor_confX==0)) {
								$artfor_pxunitX= ($artfor_pxtotX / $artfor_confX) ;
								} else {
								$artfor_pxunitX= 0;
								}//$_POST['ARTFOR_PXUNIT'.$fornitore];
								$artfor_gg_reorderX= $_POST['ARTFOR_GG_REORDER'.$fornitore];
								//se sono nulli li trasformo in 0;

								$artfor_pxlisttotX = $artfor_pxlisttotX +0 ;
								$artfor_defaultX = $artfor_defaultX + 0;
								$artfor_pxtotX = $artfor_pxtotX +0;
								$artfor_codextX = $artfor_codextX."";
								$artfor_discX=  $artfor_discX +0;
								$artfor_confX = $artfor_confX +0;
								$artfor_pxunitX = $artfor_pxunitX +0;
								$artfor_pxunit_vX = $artfor_pxunit_vX +0;
								$artfor_gg_reorderX = $artfor_gg_reorderX+0;

								$query15 = "INSERT INTO `articolifornitori` (`ART_ID`, `FOR_ID`, `ARTFOR_DEFAULT`, `ARTFOR_CODEXT`, `ARTFOR_DISC`, `ARTFOR_PXLISTTOT`, `ARTFOR_PXTOT`, `ARTFOR_CONF`, `ARTFOR_PXUNIT`, `ARTFOR_PXUNIT_V`, `ARTFOR_GG_REORDER`) VALUES (".test_input($art_id).", ".test_input($for_ragsoccomboX).", ".test_input($artfor_defaultX).", '".test_input($artfor_codextX)."', ".test_input($artfor_discX).", ".test_input($artfor_pxlisttotX).", ".test_input($artfor_pxtotX).", ".test_input($artfor_confX).", ".test_input($artfor_pxunitX).", ".test_input($artfor_pxunit_vX).", ".test_input($artfor_gg_reorderX).")";
								//echo $query15;
								$stmt15 = mysqli_prepare($mysqli, $query15);
								mysqli_stmt_execute($stmt15);
								//echo '<h3 class="info"> Record Salvato</h3>';
								//echo '<br>'.$query;	
								
						} // fine for $fornitore
		
		
		
		
		
		
		
				//} else {
				//	echo '<h3 class="warn"> è stato selezionato due volte lo stesso fornitore</h3>';
				//}
			} else {
				
				if ($contaquantidefault==0) {echo '<h3 class="warn"> almeno un fornitore fra quelli valorizzati va impostato come default</h3>';
				} else { echo '<h3 class="warn"> un solo fornitore fra quelli valorizzati va impostato come default</h3>';
				}
			}// fine if (!($contaquantidefault=1))
		} else {
			echo '<h3 class="warn"> tutti i campi sono obbligatori</h3>';
		} //fine sequenza tutti empty
		
	} else {
		echo '<h3 class="warn"> not all set</h3>';
	
	} //fine sequenza tutti SET
} //fine isset($_POST['salva']))



//<!---------------------------------------- FINE SUBMIT------------------------------------------->
?>






<div class="moduli">
    <form id="forminput" action="articolo.php" method="POST">
    <input id="artid" type="hidden" name="ART_ID" value="<?php if (isset($art_id)){echo $art_id;} ?>"></div>
		
        <!--tabella a 12 colonne-->
        <table id="art" style="width:70%; text-align: center;">
        <tr style="background-color:white;">
            <td colspan="12">
            <h3>- SINGOLO ARTICOLO -</h3><br />
            </td>
        </tr>
        <tr>

        <!--SELECT MAX(TRIM(LEADING '0' FROM RIGHT(`ART_COD`, LENGTH(`ART_COD`)-3))) FROM `articoli` WHERE LEFT(`ART_COD`, 3) = 'LIB'-->
            <td colspan="2">
                <h3>Codice</h3>
                <h3><button style="background-color: #39F;border: none;color: white;border-radius: 8px;vertical-align: middle;margin-top: 5px;" id="Sugg_cod">Suggerisci</button></h3>
            </td>
            <td colspan="10">
                <h3>Descrizione</h3>
                <h3><button style="background-color: #39F;border: none;color: white;border-radius: 8px;vertical-align: middle;margin-top: 5px;" id="ISBN">Ottieni descrizione da codice ISBN</button></h3>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input class="evident" id="ISBNinput" type="textarticolo" name="ART_COD" maxlength="20" value="<?php if (isset($art_cod)){echo $art_cod;} ?>">
            </td>

            <td colspan ="10">
            	
                <input class="evident" id="ISBNresult" type="textarticolo" name="ART_DESC" maxlength="255" value="<?php if (isset($art_desc)){echo $art_desc;} ?>">
                
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h3>Tipologia</h3>	            
            </td>
            <td colspan="2">
                <h3>Quantità a Magazzino</h3>
            </td>
            <td colspan="2">
                <h3>Soglia Riordino</h3>
            </td>
			<td colspan="6">
                
            </td>
            
            
        </tr>
        <tr>
            <td colspan="2">
                <div class="styled-select black semi-square">
                <select id="typecombo" name="TIP_DESCCOMBO">
                <option value="">Seleziona...</option>
                	<?php
                    $query16 = "SELECT `TIP_ID`, `TIP_DESC` FROM `tipologie` ORDER BY `TIP_DESC`";
					$stmt16 = mysqli_prepare($mysqli, $query16);
					mysqli_stmt_execute($stmt16);
					mysqli_stmt_bind_result($stmt16, $dbtip_id, $dbtip_desc);
					mysqli_stmt_store_result($stmt16);

					while (mysqli_stmt_fetch($stmt16)) {

                        if ($dbtip_id == $tip_id) { //manca verificare prima se isset $tip_id ??(caso form blank)
                            echo "<option value='" . $dbtip_id . "' selected>" . $dbtip_desc . "</option>";
                        } else {echo "<option value='" . $dbtip_id . "'>" . $dbtip_desc . "</option>";
                        }
                    }
                    ?>
                </select>
                </div>
            </td>
            <td colspan="2">
            	<h5><?php if (isset ($art_qty_stock)){echo $art_qty_stock;} else {echo '0';} ?></h5>
				<!--<input type="textarticolo" maxlength="6" name="ART_QTY_STOCK" value="<?php //if (isset ($art_qty_stock)){echo $art_qty_stock;} ?>">-->
            </td>
            <td colspan="2">
            	<input type="textarticolo" maxlength="6" name="ART_QTY_REORDER" value="<?php if (isset ($art_qty_reorder)){echo $art_qty_reorder;} ?>">
            </td>
            <td colspan="6">
            </td>
        </tr>
           
        <tr>
            <td width="9%">
            </td>
            <td width="9%">
            </td>
            <td width="9%">
            </td>
			<td width="9%">
            </td>
            <td width="9%">
            </td>
            <td width="9%">
            </td>
			<td width="9%">
            </td>
            <td width="9%">
            </td>
            <td width="9%">
            </td> 
            <td width="9%">
            </td> 
            <td width="9%">
            </td>
            <td width="9%">
            </td>
        </tr>
        <tr>
            <td colspan="2">
				<h3>Fornitore/i</h3>
            </td>
            
            <td>
            	<h3>Default</h3>
            </td>
            
            <td colspan="2">
            	<h3>Codice Articolo Fornitore <h6>(opzionale)</h6></h3>
            </td>
            
            <td>
            	<h3>Prezzo di Listino a confezione</h3>
            </td>
            
            <td>
            	<h3>Sconto Percentuale <h6>(opzionale)</h6></h3>
            </td>
            
            <td>
            	<h3>Prezzo di acquisto a confezione</h3>
            </td>
			
            <td>
            	<h3>Pezzi a confezione <h6>(opzionale)</h6></h3>
            </td>
            
            <td>
            	<h3>Prezzo Unitario di acquisto</h3>
            </td>
            
            <td>
            	<h3>Prezzo Unitario di vendita</h3>
            </td>
            
            <td>
            	<h3>Giorni Riordino</h3>
            </td>
			

 
        </tr>

<!--Qui inserisco la tabella con tutti i fornitori dell'articolo in questione-->
		
		<?php
		if (isset($art_id)) { //SE NON SI TRATTA DI RECORD NUOVO allora devo caricarlo dal database
			$query17 = "SELECT `ARTFOR_ID`, `ART_ID`, `FOR_ID`, `ARTFOR_DEFAULT`, `ARTFOR_CODEXT`, `ARTFOR_PXLISTTOT`, `ARTFOR_DISC`, `ARTFOR_PXTOT`, `ARTFOR_CONF`, `ARTFOR_PXUNIT`, `ARTFOR_PXUNIT_V`, `ARTFOR_GG_REORDER` FROM `articolifornitori` WHERE `ART_ID` = '".$art_id."'";
			//echo $query17;
			$stmt17 = mysqli_prepare($mysqli, $query17);
			mysqli_stmt_execute($stmt17);
			mysqli_stmt_bind_result($stmt17, $dbartfor_id, $dbart_id, $dbfor_id, $dbartfor_default, $dbartfor_codext, $dbartfor_pxlisttot, $dbartfor_disc, $dbartfor_pxtot, $dbartfor_conf, $dbartfor_pxunit, $dbartfor_pxunit_v, $dbartfor_gg_reorder);
			mysqli_stmt_store_result($stmt17);
			$riga = 0;
			while (mysqli_stmt_fetch($stmt17)) {
			//while ($row_artfor = mysql_fetch_array($result_artfor)) { //PER OGNI Articolofornitore dell'articolo art_id fai quanto segue
			$riga ++;
			echo '<tr>
					<td colspan="2">
					<div class="styled-select black semi-square">
						<select id="typecombo" name="FOR_RAGSOCCOMBO'.$riga.'">
						<option value="">Seleziona...</option>'; 
							$query18 = "SELECT `FOR_ID`, `FOR_RAGSOC` FROM `fornitori` ORDER BY `FOR_RAGSOC`";
							$stmt18 = mysqli_prepare($mysqli, $query18);
							mysqli_stmt_execute($stmt18);
							mysqli_stmt_bind_result($stmt18, $db2for_id, $db2for_ragsoc);
							mysqli_stmt_store_result($stmt18);
							while (mysqli_stmt_fetch($stmt18)) {
								if (($db2for_id) == ($dbfor_id)) {
									echo "<option value='" . $db2for_id . "' selected>" . $db2for_ragsoc . "</option>";
								} else {echo "<option value='" . $db2for_id . "'>" . $db2for_ragsoc . "</option>";
								//e qui dovrei inibire quelli che già sono sopra???? difficilissimo
								}
							} //fine while $row
							
						 echo '</select>
						 </div>
						 
					</td>	
					<td style="text-align: center;">
					<input type="checkbox"  class="cb" id="cb'.$riga.'" name="ARTFOR_DEFAULT'.$riga.'" ';
					if ($dbartfor_default=='1') {
						echo 'checked="checked"';
					} else {
					
					}
					echo '" >
					</td>
					<td colspan="2">
					<input type="textarticolo" maxlength="11" name="ARTFOR_CODEXT'.$riga.'" value="'.$dbartfor_codext.'" >
					</td>
					<td>
					<input type="textarticolo" class="setpxunit evident" id="artfor_pxlisttot'.$riga.'" maxlength="11" name="ARTFOR_PXLISTTOT'.$riga.'" value="'.$dbartfor_pxlisttot.'"  >	
					</td>
					<td>
					<input type="textarticolo" class="setpxunit" id="artfor_disc'.$riga.'" maxlength="11" name="ARTFOR_DISC'.$riga.'" value="'.$dbartfor_disc.'" >	
					</td>
					<td>
					<h6 class="artfor_pxtot" id="artfor_pxtot'.$riga.'">';
						echo round($dbartfor_pxlisttot*(1-($dbartfor_disc/100)),2);
					echo '</h6>	
					</td>
					<td>
					<input type="textarticolo" maxlength="11" class="setpxunit" id="artfor_conf'.$riga.'" name="ARTFOR_CONF'.$riga.'" value="'.$dbartfor_conf.'" >
					</td>
					<td>
					<h6 class="artfor_pxunit" id="artfor_pxunit'.$riga.'">';
					if (!($dbartfor_conf == 0)){
						echo round($dbartfor_pxtot/$dbartfor_conf,2);
					} else {
						echo '0';
					}
					echo '</h6>
					</td>
					<td>
					<input type="textarticolo" maxlength="11" class="artfor_pxunit_v" id="artfor_pxunit_v'.$riga.'" name="ARTFOR_PXUNIT_V'.$riga.'" value="'.$dbartfor_pxunit_v.'" >
					</td>
					<td>
					<input type="textarticolo" maxlength="11" name="ARTFOR_GG_REORDER'.$riga.'" value="'.$dbartfor_gg_reorder.'" >
					</td>'; ?>
					
					<td>
					<a onclick="return confirm('Sei sicuro di voler togliere da questo articolo questo fornitore?')"
					<?php echo 'href="articolo.php?art_id='.$art_id.'&artfor_iddelete='.$dbartfor_id.'" class="dl" id="DELETE'.$riga.'" '?> > <img src="img/bidone3.png"></a>
					
                    </td>
				</tr>
			
			<?php

			} //fine while $row_artfor. Per ogni articolofornitore ha creato e popolato una riga nel form
			
			echo '<input type="hidden" name="NFORNITORI" value="'.$riga.'"  >';
			$riga++;
			// alla fine aggiungo una riga vuota senza valori pronta per essere compilata
			echo '<tr>
					<td colspan="2">
					<div class="styled-select black semi-square">
						<select id="typecombo" name="FOR_RAGSOCCOMBO'.$riga.'">
						<option value="">Seleziona...</option>';
							$query19 = "SELECT `FOR_ID`, `FOR_RAGSOC` FROM `fornitori` ORDER BY `FOR_RAGSOC`";
							$stmt19 = mysqli_prepare($mysqli, $query19);
							mysqli_stmt_execute($stmt19);
							mysqli_stmt_bind_result($stmt19, $db3for_id, $db3for_ragsoc);
							mysqli_stmt_store_result($stmt19);
							while (mysqli_stmt_fetch($stmt19)) {
								echo "<option value='" . $db3for_id . "'>" . $db3for_ragsoc . "</option>";
								//e qui dovrei inibire quelli che già sono sopra???? difficilissimo
							} 
							
						 echo '</div>
						 </select>
					</td>	
					<td style="text-align: center;">
					<input type="checkbox"  class="cb"  id="cb'.$riga.'" name="ARTFOR_DEFAULT'.$riga.'" >
					</td>
					<td colspan="2">
					<input type="textarticolo" maxlength="11" name="ARTFOR_CODEXT'.$riga.'" >
					</td>
					<td>
					<input type="textarticolo" class="setpxunit evident" id="artfor_pxlisttot'.$riga.'" maxlength="11" name="ARTFOR_PXLISTTOT'.$riga.'"  >	
					</td>
					<td>
					<input type="textarticolo" class="setpxunit" id="artfor_disc'.$riga.'" maxlength="11" name="ARTFOR_DISC'.$riga.'"  >	
					</td>
					<td>
					<h6 class="artfor_pxtot" id="artfor_pxtot'.$riga.'"></h6>	
					</td>
					<td>
					<input type="textarticolo" class="setpxunit" id="artfor_conf'.$riga.'" maxlength="11" name="ARTFOR_CONF'.$riga.'"  >
					</td>
					<td>
					<h6 class="artfor_pxunit" id="artfor_pxunit'.$riga.'"></h6>
					</td>
					<td>
					<input type="textarticolo" class="artfor_pxunit_v" id="artfor_pxunit_v'.$riga.'" maxlength="11" name="ARTFOR_PXUNIT_V'.$riga.'"  >
					</td>
					<td>
					<input type="textarticolo" maxlength="11" name="ARTFOR_GG_REORDER'.$riga.'" >
					</td>
		
	
			</tr>';
			
		} else { //SE SIAMO IN FASE DI CREAZIONE NUOVO RECORD ALLORA CREA UNA SOLA RIGA
		
		
		$riga = 1;
		echo '<input type="hidden" name="NFORNITORI" value="'.$riga.'"  >';
		
		echo '<tr>
					<td colspan="2">
					<div class="styled-select black semi-square">
						<select id="typecombo" name="FOR_RAGSOCCOMBO'.$riga.'">
						<option value="">Seleziona...</option>';
							$query20 = "SELECT `FOR_ID`, `FOR_RAGSOC` FROM `fornitori` ORDER BY `FOR_RAGSOC`";
							$stmt20 = mysqli_prepare($mysqli, $query20);
							mysqli_stmt_execute($stmt20);
							mysqli_stmt_bind_result($stmt20, $db4for_id, $db4for_ragsoc);
							mysqli_stmt_store_result($stmt20);
							while (mysqli_stmt_fetch($stmt20)) {
								echo "<option value='" . $db4for_id . "'>" . $db4for_ragsoc . "</option>";
								//e qui dovrei inibire quelli che già sono sopra???? difficilissimo
							}
							
						 echo '</select>
					</div>
					</td>	
					<td style="text-align: center;">
					<input type="checkbox"  class="cb" id="cb'.$riga.'" name="ARTFOR_DEFAULT'.$riga.'" >
					</td>
					<td colspan="2">
					<input type="textarticolo" maxlength="11" name="ARTFOR_CODEXT'.$riga.'" >
					</td>
					<td>
					<input type="textarticolo" class="setpxunit evident" id="artfor_pxlisttot'.$riga.'" maxlength="11" name="ARTFOR_PXLISTTOT'.$riga.'"  >	
					</td>
					<td>
					<input type="textarticolo" class="setpxunit" id="artfor_disc'.$riga.'" maxlength="11" name="ARTFOR_DISC'.$riga.'"  >	
					</td>
					<td>
					<h6 class="artfor_pxtot" id="artfor_pxtot'.$riga.'"></h6>	
					</td>
					<td>
					<input type="textarticolo" class="setpxunit" id="artfor_conf'.$riga.'" maxlength="11" name="ARTFOR_CONF'.$riga.'"  >
					</td>
					<td>
					<h6 class="artfor_pxunit" id="artfor_pxunit'.$riga.'"></h6>
					</td>
					<td>
					<input type="textarticolo" class="art_for_pxunit_v" id="artfor_pxunit_v'.$riga.'" maxlength="11" name="ARTFOR_PXUNIT_V'.$riga.'"  >
					</td>
					<td>
					<input type="textarticolo" maxlength="11" name="ARTFOR_GG_REORDER'.$riga.'" >
					</td>
		
	
			</tr>';
		}
		?>

        
        
    	<tr>
        	<td colspan="12">
            </td>
           </tr>
    	<tr>
        	<td colspan="4">
            </td>
        	<td colspan="4">
        		<input name="salva" id="submit3" type="submit" style="margin: auto;" value="Salva Modifica">
                </form>
        	</td>

            
            <td colspan="4">

            </td>
        </tr  >
            	<tr style="text-align: center;">
        	<td colspan="4">
            </td>
        	<td colspan="4" style="text-align: center;">
            	<a class="caricoscarico" href="carico.php?art_id=<?php echo ($art_id); ?>"><img src="img/carico40f.png" title="Carico Magazzino"/></a>
				<a class="caricoscarico" href="scarico.php?art_id=<?php echo ($art_id); ?>"><img src="img/scarico40f.png" title="Scarico Magazzino"/></a>
				<a class="caricoscarico" href="rettifica.php?art_id=<?php echo ($art_id); ?>"><img src="img/rettifica40f.png" title="Rettifica Magazzino"/></a>
        	</td>

            
            <td colspan="4">

            </td>
        </tr>
        



        </table>
        
        
        
        
        
        
        
    
        
        
    
</div>


<script type="text/javascript"> 
$(document).ready(function() { 
   openNav();
   
   // al caricamento se il valore di #artid è nullo nascondo le due icone di carico e scarico
   var artid=$('#artid').val();
   //console.log ("artid="+artid);
   if (artid=="") {
	   //console.log ("artid=vuoto");
	   $('.caricoscarico').hide();
	   $('#qty').val("0");
	   
   }
  
  
/*$('.search-box input[type="text100"]').on("keyup input", function(){
	
	var inputVal = $(this).val();
	var resultDropdown = $(this).siblings(".result");
	if(inputVal.length){
		//console.log ($(this).attr("name"));
		if($(this).attr("name")=="search_rag") {
			$.get("backend-search2.php", {term: inputVal, cod_or_desc: "ragsoc"}).done(function(data){
				// Display the returned data in browser
			resultDropdown.html(data);
			}); //fine function*/
 
//devo nascondere il bidone dell'articolofornitore di default


		//conta quante sono le checkboxes
		var cbs = document.getElementsByClassName("cb");
		var dls = document.getElementsByClassName("dl");
		for (var i = 0; i < cbs.length; i++) {
			if ($('#cb'+i).is(':checked')) { dls[i-1].style.visibility = 'hidden';}
		}
		
	




   
}); //FINE operazioni da farsi al caricamento del documento


/*$('.cb').click(function(){
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
        cbs[i].checked = false;
    }
	
	nomeinput = $(this).attr("name");
	console.log ("nomeinput:"+$(this).attr("name"));
    $(this).prop("checked", true);
	console.log ("i:"+i);
	
	cbs[i-1].checked = false;

});*/

// FUNZIONE PER FAR COMPORTARE LE CHECKBOXES COME DELLE OPTION
$('.cb').click(function(){
	//conta quante sono le checkboxes
	var count = $("[type='checkbox']").length;
	//se sto cliccando sull'ultima me lo deve impedire
	nomeinput = $(this).attr("name");
	var numinput = nomeinput.replace( /^\D+/g, '');
	//console.log ("nomeinput:"+$(this).attr("name"));
	var cbs = document.getElementsByClassName("cb");
	var dls = document.getElementsByClassName("dl");
	
	if ((nomeinput != "ARTFOR_DEFAULT"+(count)) || (count == 1)){ //se non è l'ultimo, oppure se ce n'è uno solo...
		    
			for (var i = 0; i < cbs.length; i++) {
				cbs[i].checked = false;
			}
			
			for (var i = 0; i < (dls.length); i++) {
				dls[i].style.visibility = 'visible';
			}
			
			$(this).prop("checked", true);
			
			var deletetohide = document.getElementById("DELETE"+numinput);
			deletetohide.style.visibility = 'hidden';



			//console.log ("i:"+i);
	} else {
	cbs[count-1].checked = false;
	//console.log ("utente ha cliccato sull'ultimo");
	}

});
// FINE FUNZIONE CHECKBOXES



$('.setpxunit').on("keyup input", function(){
	//se metto mano a un qualsiasi artfor_pxtot devo trovare di quale si tratta e mettere mano ai corrispondenti pxunit e pxunit_v
	
	nomeinput = $(this).attr("name");
	console.log ("nomeinput:"+$(this).attr("name"));
	
	var numinput = nomeinput.replace( /^\D+/g, '');
	console.log ("numinput:"+numinput);
	confezionitosearch = "artfor_conf"+numinput
	console.log ("confezionitosearch:"+confezionitosearch);
	pxtottosearch = "artfor_pxtot"+numinput
	console.log ("pxtottosearch:"+pxtottosearch);
	pxlisttosearch = "artfor_pxlisttot"+numinput
	console.log ("pxlisttosearch:"+pxlisttosearch);
	disctoosearch = "artfor_disc"+numinput
	console.log ("disctosearch:"+disctoosearch);
	
	var pezziaconfezione = (document.getElementById(confezionitosearch).value);
	console.log ("pezziaconfezione:"+pezziaconfezione);
	var pxtot = (document.getElementById(pxtottosearch).innerHTML);
	console.log ("pxtot:"+pxtot);
	var listino = (document.getElementById(pxlisttosearch).value);
	console.log ("prezzolistino:"+listino);
	var sconto = (document.getElementById(disctoosearch).value);
	console.log ("sconto:"+sconto);
	
	if (pezziaconfezione == null || pezziaconfezione == "" || pezziaconfezione == 0) { pezziaconfezione = 1};
	
	if (pxtot == null) { pxtot = 0};
	
	//devo modificare i valori di px tot, px unitario, px unitario di vendita
	pxtottowrite = listino * (1-sconto/100);
	pxtottowrite = (Math.round(pxtottowrite*100)/100);
	
	//if (!(pezziaconfezione == 0)) { 
		pxunittowrite = pxtottowrite/pezziaconfezione;
		pxunittowrite = (Math.round(pxunittowrite*100)/100);
		pxunit_vtowrite =listino/pezziaconfezione
		pxunit_vtowrite = (Math.round(pxunit_vtowrite*100)/100);
	//	} else {
	//	pxunittowrite = 0;
	//	pxunit_vtowrite = 0;
	//	}
	
		
	console.log ("pxunittowrite:"+pxunittowrite);
	
	//definisco quali sono gli id in cui scrivere
	pezziaconfezionetosearch = "artfor_conf"+numinput
	console.log ("pezziaconfezionetosearch:"+pezziaconfezionetosearch);
	
	pxtottosearch = "artfor_pxtot"+numinput
	console.log ("pxtottosearch:"+pxtottosearch);
	
	pxunittosearch = "artfor_pxunit"+numinput
	console.log ("pxunittosearch:"+pxunittosearch);
	
	pxunit_vtosearch = "artfor_pxunit_v"+numinput
	console.log ("pxunit_vtosearch:"+pxunit_vtosearch);
	
	//e ci scrivo
	console.log ("pezziaconfezione:"+pezziaconfezione);
	document.getElementById(pezziaconfezionetosearch).value = pezziaconfezione;
	document.getElementById(pxtottosearch).innerHTML = pxtottowrite;
	document.getElementById(pxunittosearch).innerHTML = pxunittowrite;
	document.getElementById(pxunit_vtosearch).value = pxunit_vtowrite;
	
	
	
	
});




$("#Sugg_cod").click(function(){
	event.preventDefault();
	var typecombo = $('#typecombo').val();
	
		if (typecombo == 2) {
			if (!confirm("Il suggerimento non viene di norma utilizzato per i codici dei libri. Per quelli è consigliabile utilizzare il codice ISBN. Continuare comunque?") == true) {
				return;
			}
		}
		
		
		var inputVal = $('#typecombo').val();
		 //legge il valore selezionato nella combo typecombo
		if (inputVal) {
		$.get("backend-suggerisci.php", {term: inputVal}).done(function(data){
				// Display the returned data in browser
				document.getElementById("ISBNinput").value = data;
			
			}); //fine function*/
		} else {
			alert ("E' prima necessario selezionare un valore per la Tipologia");
		}
	
	
}); //FINE funzione
  
  

//questa funzione spedisce in ISBNresult il titolo del libro trovato dalla src
function handleResponse(response) {
	   if (response.items) {
		  for (var i = 0; i < response.items.length; i++) {
			var item = response.items[i];
			// in production code, item.text should have the HTML entities escaped.
			document.getElementById("ISBNresult").value = item.volumeInfo.title+" - "+item.volumeInfo.authors;
			//console.log (item.volumeInfo.title);
		  }
	   } else {
		 var ISBNinput = $('#ISBNinput').val(); 
	    alert ("Non è stato possibile trovare un titolo con ISBN ="+ISBNinput);
	   }
	   //document.body.style.cursor = "default";
	   $("*").css("cursor", "default");
}// FINE funzione handleResponse


	
//FUNZIONE per prendere il valore in #ISBNinput e con quello cercare il risultato. Questo avviene lanciando la src esterna che utilizza a sua volta la funzioen handleResponse come callback
$("#ISBN").click(function(){
		
	event.preventDefault();
	
	var ISBNinput = $('#ISBNinput').val();
	$("*").css("cursor", "wait");
	//document.body.style.cursor = "wait";
	file = "https://www.googleapis.com/books/v1/volumes?q=isbn:"+ISBNinput+"&callback=handleResponse"
	// DOM: Create the script element
	var jsElm = document.createElement("script");
	// set the type attribute
	jsElm.type = "application/javascript";
	// make the script element load file
	jsElm.src = file;
	
	//$.ajax({ url: "a.js", dataType: "script", timeout: 1000});
	// finally insert the element to the body element in order to load the script
	document.body.appendChild(jsElm);
	
}); //FINE funzione ISBN

</script>
    


    
</main>
</body>
</html>



