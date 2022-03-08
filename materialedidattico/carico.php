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
<?php

require 'core.inc.php';
require 'connect.inc.php';

if (!loggedin()) {
echo "<h3><br>E' richiesto il login</h3><br>";
echo '<h3><a href="index.php">Pagina di Login</a></h3>';
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
		//significa che si arriva da altra pagina e non da submit
		$art_id = ($_GET['art_id']);
	} else {
		//significa che si arriva da submit ed in questo caso il valore di $art_id necessario a valorizzare tutta la pagina arriva dal S_POST del form di fine pagina
		$art_id = ($_POST['ART_ID']);
	} //fine if (isset($_GET['art_id']))
		
		//query per estrarre articolo in questione
		
		$query = "SELECT `articoli`.`ART_ID`, `articoli`.`ART_COD`, `articoli`.`ART_DESC`, `articoli`.`ART_QTY_STOCK`, `articoli`.`ART_QTY_REORDER`, `articoli`.`FOR_ID`, `articoli`.`TIP_ID`, `fornitori`.`FOR_RAGSOC` FROM `articoli` INNER JOIN `fornitori` ON `articoli`.`FOR_ID` = `fornitori`.`FOR_ID` WHERE `articoli`.`ART_ID`='".$art_id."'"; 
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $art_id, $art_cod, $art_desc, $art_qty_stock, $art_qty_reorder, $for_id, $tip_id, $for_ragsoc);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
		
			while (mysqli_stmt_fetch($stmt)) {
			} //fine while
		
		} else {
		    echo "più di un record?";
		} //fine if ($query_num_rows =1)
			
		$query2 = "SELECT `ARTFOR_ID`, `ARTFOR_CODEXT`, `ARTFOR_PXTOT`, `ARTFOR_CONF`, `ARTFOR_PXUNIT`, `ARTFOR_GG_REORDER` FROM `articolifornitori` WHERE `ART_ID`='".$art_id."' AND `ARTFOR_DEFAULT`= '1'"; 
		$stmt2 = mysqli_prepare($mysqli, $query2);
		mysqli_stmt_execute($stmt2);
		mysqli_stmt_bind_result($stmt2, $artfor_id, $artfor_codext, $artfor_pxtot, $artfor_conf, $artfor_pxunit, $artfor_gg_reorder);
		mysqli_stmt_store_result($stmt2);
		if (mysqli_stmt_num_rows($stmt2) >=1) {
			while (mysqli_stmt_fetch($stmt2)) {
			} //fine while articolifornitori*/
		} else {
	    	echo "più di un record?";
		} //fine if ($query_num_rows =1)
		
	
	
	//<!---------------------------------------- INIZIO SUBMIT------------------------------------------->
	//questa parte si fa SOLO in fase di SUBMIT
	
	if(isset($_POST['salva'])) {
		
	
		// è stato premuto il pulsante salva
		// se manca ART_ID allora trattasi di uno nuovo e quindi non devo fare una UPDATE ma una INSERT!!
		//prima di tutto cerco di capire quanti record ci sono nella tabella dei fornitori, se uno solo no problem, ma se più di uno devo ciclare su tutti
	
	   
		if (isset($_POST['ART_QTY_LOAD'])) { //significa: "se è stato premuto il tasto submit"
			//assegna le variabili
			$art_qty_load = $_POST['ART_QTY_LOAD'];
			if (!empty ($art_qty_load)) {
							
							
							$art_qty_stock = $art_qty_stock + ( $artfor_conf * $art_qty_load);
							$query3 = "UPDATE `articoli` SET `ART_QTY_STOCK` = '".$art_qty_stock."' WHERE `ART_ID` = '".$art_id."'";
                            $stmt3 = mysqli_prepare($mysqli, $query3);
                            mysqli_stmt_execute($stmt3);
							
							
							//Ora aggiorna la tabella s_carichi
							$query4 ="INSERT INTO `s_carichi` ( `S_CA_TYPE`, `ART_ID`, `FOR_ID`, `ARTFOR_ID`, `S_CA_QTY_CARICO`, `ARTFOR_CONF`, `S_CA_QTY_UNIT_S_CARICO`, `ARTFOR_PXTOT`, `S_CA_PXUNIT`, `S_CA_PXTOT` ) VALUES ( 'carico', '".$art_id."', '".$for_id."', '".$artfor_id."','".$art_qty_load."', '".$artfor_conf."', '".($art_qty_load * $artfor_conf)."', '".$artfor_pxtot."', '".$artfor_pxunit."', '".($art_qty_load * $artfor_pxtot)."'  )";
                            //echo $query4;
                            $stmt4 = mysqli_prepare($mysqli, $query4);
                            mysqli_stmt_execute($stmt4);
							
							
							//Ora aggiorna anche il Log
							$logsino = getuserfield ('LOG');
							if ($logsino == 1) {
								$query5 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `QUANTITA`, `ART_ID`, `ART_DESC`, `FOR_ID`, `FOR_RAGSOC`, `PXTOT` ) VALUES ( '".$_SESSION['user_id']."', 'carico', '".$art_qty_load."', '".$art_id."', '".$art_desc."', '".$for_id."', '".$for_ragsoc."', '".($art_qty_load * $artfor_pxtot)."'  )";
                                $stmt5 = mysqli_prepare($mysqli, $query5);
                                mysqli_stmt_execute($stmt5);
								//echo $querylog;
								//fine aggiornamento log
							}
							
	
							echo '<h3 class="info"> Caricate '.$artfor_conf.' confezioni pari a '.($artfor_conf * $art_qty_load).' unità</h3>';
							$art_qty_load = 0;
						} else {
		
							echo '<h3 class="info"> Inserire un valore diverso da 0</h3>';
						} //fine if (!empty($art_qty_load))
		
			
		} else {
			echo '<h3 class="warn"> not all set</h3>';
		
		} //fine if (isset($_POST['ART_QTY_LOAD']))
	} //fine isset($_POST['salva']))

} //fine if (loggedin())

//<!---------------------------------------- FINE SUBMIT------------------------------------------->
?>






<div class="moduli">
    <form action="carico.php" method="POST">
    <input type="hidden" name="ART_ID" value="<?php if (isset($art_id)){echo $art_id;} ?>"></div>

        <!--tabella a otto colonne-->
        <table id="art" style="width:50%; text-align: center;">
        
        <tr style="background-color:white;">
            <td colspan="8">
            <h3>- CARICO ARTICOLO -</h3><br />
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <h3>Codice</h3>
            </td>
            <td colspan="6">
                <h3>Descrizione</h3>
            </td>

            
        </tr>
        
        <tr>
            <td colspan="2">
                <h5><?php if (isset($art_cod)){echo $art_cod;} ?></h5>
            </td>
            <td colspan ="6">
                <h5><?php if (isset($art_desc)){echo $art_desc;} ?></h5>
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
			<td colspan="2">
                
            </td>
            
            
        </tr>
        <tr>
            <td colspan="2">
                	<h5><?php
                    $query6 = "SELECT `TIP_DESC` FROM `tipologie` WHERE `TIP_ID` = '".$tip_id."'";
                    $stmt6 = mysqli_prepare($mysqli, $query6);
                    mysqli_stmt_execute($stmt6);
                    mysqli_stmt_bind_result($stmt6, $tip_desc);
                    mysqli_stmt_store_result($stmt6);
                    while (mysqli_stmt_fetch($stmt6)) {
                        echo ($tip_desc);
                    }
                    ?></h5>
            </td>
            <td colspan="2">
            	<h5><?php if (isset($art_qty_stock)){echo $art_qty_stock;} ?></h5>	
            </td>
            <td colspan="2">
            	<h5><?php if (isset($art_qty_reorder)){echo $art_qty_reorder;} ?></h5>		
            </td>
            <td colspan="2">
            </td>
        </tr>
           
        <tr>
            <td width="12.5%">
				<br>&nbsp;
            </td>
            <td width="12.5%">
            </td>
            <td width="12.5%">
            </td>
			<td width="12.5%">
            </td>
            <td width="12.5%">
            </td>
            <td width="12.5%">
            </td>
			<td width="12.5%">
            </td>
            <td width="12.5%">
            </td>

        </tr>
        <tr>
            <td colspan="2">
				<h3>Fornitore di default</h3>
                <h3 style="font-size: xx-small;">Per scegliere un altro fornitore impostarlo di default nella <br /><a href="articolo.php?art_id=<?php echo $art_id ?>">scheda articolo<a></h3>
            </td>
            
            <td>
            	<h3>Codice Articolo Fornitore</h3>
        
           
            </td>
            	
            <td>
            	<h3>Prezzo di acquisto a confezione</h3>
            </td>
			
            <td>
            	<h3>Pezzi a confezione</h3>
            </td>
			
            <td>
            	<h3>Carico Confezioni</h3>
            </td>

            <td>
            	<h3>Prezzo Unitario di acquisto</h3>
            </td>
            
            <td>
            	<h3>Giorni Riordino</h3>
            </td>
			

 
        </tr>
        
        
        <tr>
            <td colspan="2">
				<h5><?php if (isset($for_ragsoc)){echo $for_ragsoc;} ?></h5>	
            </td>
            
            <td>
            	<h5><?php if (isset($artfor_codext)){echo $artfor_codext;} ?></h5>
            </td>
            	
            <td>
            	<h5><?php if (isset($artfor_pxtot)){echo $artfor_pxtot;} ?></h5>
            </td>
			
            <td>
            	<h5><?php if (isset($artfor_conf)){echo $artfor_conf;} ?></h5>
            </td>
			
            <td>
            	<input class="evident" id="qtytoorder" type="textarticolo" maxlength="6" name="ART_QTY_LOAD" value="<?php if (isset ($art_qty_load)){echo $art_qty_load ;} ?>">
            </td>

            <td>
            	<h5><?php if (isset($artfor_pxunit)){echo $artfor_pxunit;} ?></h5>
            </td>
            
            <td>
            	<h5><?php if (isset($artfor_gg_reorder)){echo $artfor_gg_reorder;} ?></h5>
            </td>
			

 
        </tr>

<!--Qui inserisco i valori solamente di codice fornitore, prezzo totale, prezzo a confezione, prezzo unitario-->
<!-- e poi invece la INPUT quantità richiesta di confezioni, il numero di unità che questo significa per la scuola e il prezzo totale -->
		
		

    	<tr>
        	<td colspan="3">
            </td>
        	<td colspan="2">
        		<br><br> <input name="salva" id="submit3" type="submit" style="margin: auto;" value="Lancia Carico" Onclick="return confirm ('ATTENZIONE: OPERAZIONE DI CARICO IRREVERSIBILE')">
        	</td>
        	<td colspan="3">
            </td>
        </tr>
        </table>
        
        
        
        
        
        
        
    
        
        
    </form>
    

</div>
<script type="text/javascript"> 
$(document).ready(function() { 
   openNav();
}); 
</script>

</main>
</body>
</html>