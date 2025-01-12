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
            <a href="#"class="active" style="color: white;">Movimenti Magazzino</a>
            <a href="download.php">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>

<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>


<main>

<?php

	$search_c_sstr ="";
	if (isset ($_POST['search_c_s'])) {
		$search_c_s = mysqli_real_escape_string($mysqli, $_POST['search_c_s']);
			if ($search_c_s =="caricoscarico" ){
				$search_c_sstr = "";
			} else if ($search_c_s =="carico" ){
				$search_c_sstr = " AND `S_CA_TYPE` = 'carico' ";
			} else if ($search_c_s =="scarico" ){
				$search_c_sstr = " AND `S_CA_TYPE` = 'scarico'";
			} else {
				$search_c_sstr = "";
			}
			
	}
	


	$search_datefromstr = "";
	if (isset ($_POST['search_datefrom'])) {
		$search_datefrom = mysqli_real_escape_string($mysqli, $_POST['search_datefrom']);
			if (empty($search_datefrom)) {
				$search_datefromstr = "";
			} else {
				$search_datefromstr = " AND `TIME` >= '".mysqli_real_escape_string($mysqli, $search_datefrom)."'";
			}
	}
	
	$search_datetostr = "";
	if (isset ($_POST['search_dateto'])) {
		$search_dateto = mysqli_real_escape_string($mysqli, $_POST['search_dateto']);
			if (empty($search_dateto)) {
				$search_datetostr = "";
			} else {
				$search_datetostr = " AND `TIME` <= '".mysqli_real_escape_string($mysqli, $search_dateto)."'";
			}
	}
	
	$search_ragstr = "";
	if (isset ($_POST['search_rag'])) {
		$search_rag = mysqli_real_escape_string($mysqli, $_POST['search_rag']);
			if (empty($search_rag)) {
				$search_ragstr = "";
			} else {
				$search_ragstr = " AND `FOR_RAGSOC` LIKE '%".mysqli_real_escape_string($mysqli, $search_rag)."%'";
			}
	}
	
	$search_nomcogstr = "";
	if (isset ($_POST['search_nomcog'])) {
		$search_nomcog = mysqli_real_escape_string($mysqli, $_POST['search_nomcog']);
			if (empty($search_nomcog)) {
				$search_nomcogstr = "";
			} else {
				$search_nomcogstr = " AND `CLI_NOMECOGNOME` LIKE '%".mysqli_real_escape_string($mysqli, $search_nomcog)."%'";
			}
	}
	
	$search_namestr = "";
	if (isset ($_POST['search_name'])) {
		 $search_name = mysqli_real_escape_string($mysqli, $_POST['search_name']);
			if (empty($search_name)) {
				$search_namestr = "";
			} else {
				$search_namestr = " AND `ART_DESC` LIKE '%".mysqli_real_escape_string($mysqli, $search_name)."%'";	
			}
	}
	
	
	$queryANDpart = " ";	
		
	if (isset ($_POST['search_rag']) || isset ($_POST['search_nomcog']) || isset ($_POST['search_name'])|| isset ($_POST['search_c_s'])){
	
		
		$queryANDpart = " WHERE 1=1 ".$search_ragstr.$search_nomcogstr.$search_namestr.$search_datefromstr.$search_datetostr.$search_c_sstr;//.$search_tipostr;	
		
		
	}

	


if (isset($_GET['sort'])) {
			if ($_GET['sort'] == 'S_CA_TYPE')
			{
				$sqlORDERBY= " ORDER BY `S_CA_TYPE`";
			}
			elseif ($_GET['sort'] == 'TIME')
			{
				$sqlORDERBY= " ORDER BY `TIME`";
			}
			elseif ($_GET['sort'] == 'ART_DESC')
			{
				$sqlORDERBY= " ORDER BY `ART_DESC`";
			}
			elseif($_GET['sort'] == 'FOR_RAGSOC')
			{
				$sqlORDERBY= " ORDER BY `FOR_RAGSOC`";
			}
			elseif($_GET['sort'] == 'CLI_NOMECOGNOME')
			{
				$sqlORDERBY= " ORDER BY `CLI_NOMECOGNOME`";
			}		
			elseif($_GET['sort'] == 'S_CA_QTY_CARICO')
			{
				$sqlORDERBY= " ORDER BY `S_CA_QTY_CARICO`";
			}
			elseif($_GET['sort'] == 'ARTFOR_CONF')
			{
				$sqlORDERBY= " ORDER BY `ARTFOR_CONF`";
			}
			elseif($_GET['sort'] == 'S_CA_QTY_UNIT_S_CARICO')
			{
				$sqlORDERBY= " ORDER BY `S_CA_QTY_UNIT_S_CARICO`";
			}
			elseif($_GET['sort'] == 'ARTFOR_PXTOT')
			{
				$sqlORDERBY= " ORDER BY `ARTFOR_PXTOT`";
			}
			elseif($_GET['sort'] == 'S_CA_PXUNIT')
			{
				$sqlORDERBY= " ORDER BY `S_CA_PXUNIT`";
			}
			elseif($_GET['sort'] == 'S_CA_PXTOT')
			{
				$sqlORDERBY= " ORDER BY `S_CA_PXTOT`";
			}
	
	
		} else {
			$sqlORDERBY= " ORDER BY `TIME`";
		}
?>


<?php
	// Caso DELETE TRANSAZIONE
	if (isset($_GET['s_ca_iddelete'])) {
			$s_ca_iddelete=($_GET['s_ca_iddelete']);
			
			$query = "SELECT `ART_ID`, `S_CA_TYPE`, `S_CA_QTY_CARICO`, `ARTFOR_CONF`, `S_CA_QTY_UNIT_S_CARICO` FROM `s_carichi` WHERE `S_CA_ID` = ".$s_ca_iddelete;
			
			//echo $query.'<br>';
			$stmt = mysqli_prepare($mysqli, $query);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $art_id, $s_ca_type, $s_ca_qty_carico, $artfor_conf, $s_ca_qty_unit_s_carico);
			mysqli_stmt_store_result($stmt);
			while (mysqli_stmt_fetch($stmt)) {	
			}
			
			$query2 = "SELECT `ART_QTY_STOCK`, `ART_DESC` FROM `articoli` WHERE `ART_ID` = ".$art_id;
			$stmt2 = mysqli_prepare($mysqli, $query2);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_bind_result($stmt2, $art_qty_stock, $art_desc);
			mysqli_stmt_store_result($stmt2);
			while (mysqli_stmt_fetch($stmt2)) {	
			}

			$deleted = 0;
			
			//echo $art_qty_stock.'<br>';
			//echo $s_ca_qty_unit_s_carico.'<br>';
			switch ($s_ca_type) {
				case 'carico':
						if ($art_qty_stock >= $s_ca_qty_unit_s_carico){
						$newart_qty_stock = $art_qty_stock - $s_ca_qty_unit_s_carico;
					// sto cancellando un carico quindi devo ridurre le quantità ma lo posso fare solamente se non vado sotto zero!!
						$query3 = "UPDATE `articoli` SET `ART_QTY_STOCK` = '".$newart_qty_stock."' WHERE `ART_ID` = '".$art_id."'";
						$stmt3 = mysqli_prepare($mysqli, $query3);
						mysqli_stmt_execute($stmt3);
						//echo $query3.'<br>';
						$deleted = 1;
						} else {
						$deleted = 0;
						echo '<h3 class="warn"> movimento non cancellabile in quanto questo determinerebbe quantità negative a stock per : '.$art_desc.'</h3>';
						}
					break;
				case 'scarico':
					// sto cancellando uno scarico che viene inserito in tabella s_carichi con valore negativo
					// quindi l'operazione è la stessa del caso "carico" (somma algebrica) ma il risultato sarà sempre una somma
						$newart_qty_stock = $art_qty_stock - $s_ca_qty_unit_s_carico;
						$query4 = "UPDATE `articoli` SET `ART_QTY_STOCK` = '".$newart_qty_stock."' WHERE `ART_ID` = '".$art_id."'";
						$stmt4 = mysqli_prepare($mysqli, $query4);
						mysqli_stmt_execute($stmt4);
						//echo $query3.'<br>';
						$deleted = 1;
						break;
				case 'rettifica':
						if ($art_qty_stock >= $s_ca_qty_unit_s_carico){
						$newart_qty_stock = $art_qty_stock - $s_ca_qty_unit_s_carico;
					// sto cancellando una rettifica quindi nel caso più generale devo fare la differenza algebrica che quindi include i due casi precedenti
						$query5 = "UPDATE `articoli` SET `ART_QTY_STOCK` = '".$newart_qty_stock."' WHERE `ART_ID` = '".$art_id."'";
						$stmt5 = mysqli_prepare($mysqli, $query5);
						mysqli_stmt_execute($stmt5);
						//echo $query3.'<br>';
						$deleted = 1;
						} else {
						$deleted = 0;
						echo '<h3 class="warn"> movimento non cancellabile in quanto questo determinerebbe quantità negative a stock per : '.$art_desc.'</h3>';
						}
			}
			
			//a questo punto lancio la query3 che modifica le quantità a stock
			
			if ($deleted == 1) {
				echo '<h3 class="info"> cancellata transazione di '.$s_ca_type.' su articolo : '.$art_desc.' per '.$s_ca_qty_unit_s_carico.' unità</h3>';
				echo '<h3 class="info"> le quantità a stock sono ora pari a '.$newart_qty_stock.' unità</h3>';
				//e finalmente cancello dalla tabella s_carichi il movimento
				$query6 = "DELETE FROM `s_carichi` WHERE `S_CA_ID` = ".$s_ca_iddelete;
				$stmt6 = mysqli_prepare($mysqli, $query6);
				mysqli_stmt_execute($stmt6);
				
			
				//Ora aggiorna anche il Log
				$logsino = getuserfield ('LOG');
				if ($logsino == 1) {
					$query7 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `QUANTITA`, `ART_ID`, `ART_DESC`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione movimento', '".$s_ca_qty_unit_s_carico."', '".$art_id."', '".$art_desc."' )";
					$stmt7 = mysqli_prepare($mysqli, $query7);
					mysqli_stmt_execute($stmt7);
					//echo $querylog;
					//fine aggiornamento log
				}
			}
							

		
	}

// fine caso DELETE TRANSAZIONE
?>







<form id="target" action="movimenti.php" method ="POST">
	<table id="lst" style="width:80%;" class="tbl">
    
         <tr style="background-color:white;">
        <td colspan="12">
        <br /><h3>- MOVIMENTI di MAGAZZINO -</h3><br />
        </td>
        </tr>
   
  

     
        
        
  <tr class="row2">
    <th style="background-color: #FFF" id="columnlabel" > 
    <br />
    <div class="search-img">
    <input class="img_c_s" type="image" title="mostra tutti" src="img/carico_scarico_rettifica.png" name="caricoescarico" />
    <input class="img_c_s" type="image" title="solo carico" src="img/carico_PB.png" name="carico" />
    <input class="img_c_s" type="image" title="solo scarico" src="img/scarico_PB.png" name="scarico" />
    </div>
    </th>
    <th style="background-color: #FFF" id="columnlabel" >

           dal<input style="text-align: center;" class= "search-input" type="date"  name ="search_datefrom"  value ="<?php if (isset ($_POST['search_datefrom'])) {echo ($_POST['search_datefrom']);} ?>"/>
           al<input style="text-align: center" class= "search-input" type="date" name ="search_dateto" value ="<?php if (isset ($_POST['search_dateto'])) {echo ($_POST['search_dateto']);} ?>"/>

    
    
    </th>
    <th style="background-color: #FFF" id="columnlabel" >
    <div class="search-box">
            <input class= "search-input" type="text100" autocomplete="off" placeholder="Descrizione Articolo..." name ="search_name" value ="<?php if (isset ($_POST['search_name'])) {echo ($_POST['search_name']);} ?>"/>
            <div class="result" style="position: absolute; width: 12%; cursor: default;" ></div>
    </div>
    </th>
	<th style="background-color: #FFF" id="columnlabel" >
    <div class="search-box">
            <input class= "search-input" type="text100" autocomplete="off" placeholder="Ragione Sociale Fornitore..." name ="search_rag" value ="<?php if (isset ($_POST['search_rag'])) {echo ($_POST['search_rag']);} ?>"/>
            <div class="result" style="position: absolute; width: 12%; cursor: default;" ></div>
    </div>
    </th> 
    <th style="background-color: #FFF" id="columnlabel" >
    <div class="search-box">
            <input class= "search-input" type="text100" autocomplete="off" placeholder="Nome o Cognome Cliente..." name ="search_nomcog" value ="<?php if (isset ($_POST['search_nomcog'])) {echo ($_POST['search_nomcog']);} ?>"/>
            
            <div class="result" style="position: absolute; width: 12%; cursor: default;" ></div>
            
    </div>
    
    </th>
   </form>
    <th style="font-size:xx-small; border: 1px #ccc solid" id="columnlabel" ><a href="#">TOTALE<br /><br />Confezioni Caricate</a></th>
    <th style="background-color: #FFF" id="columnlabel" ></th>
    <th style="font-size:xx-small; border: 1px #ccc solid" id="columnlabel" ><a href="#">TOTALE<br /><br />Unità Caricate - Unità Scaricate</a></th>
    <th style="background-color: #FFF" id="columnlabel" ></th>
    <th style="background-color: #FFF" id="columnlabel" ></th>
    <th style="font-size:xx-small; border: 1px #ccc solid" id="columnlabel" ><a href="#">TOTALE<br /><br />Valore Totale</a></th>
	<th style="background-color: #FFF" id="columnlabel" ></th>
    
  </tr>
  
<?php




		$query8 = "SELECT SUM(`s_carichi`.`S_CA_QTY_CARICO`) as 'TOT_CONF', SUM(`s_carichi`.`S_CA_QTY_UNIT_S_CARICO`)  as 'TOT_UNITA', SUM(`s_carichi`.`S_CA_PXTOT`) as 'TOT_DENARO' FROM ((`s_carichi` LEFT JOIN `fornitori` ON `s_carichi`.`FOR_ID` = `fornitori`.`FOR_ID`) LEFT JOIN `clienti` ON `s_carichi`.`CLI_ID` = `clienti`.`CLI_ID`)  INNER JOIN `articoli` ON `s_carichi`.`ART_ID` = `articoli`.`ART_ID` ".$queryANDpart;

		$stmt8 = mysqli_prepare($mysqli, $query8);
		mysqli_stmt_execute($stmt8);
		mysqli_stmt_bind_result($stmt8, $tot_conf, $tot_unita, $tot_denaro);
		mysqli_stmt_store_result($stmt8);
		if (mysqli_stmt_num_rows($stmt8) >=1) {

			while (mysqli_stmt_fetch($stmt8)) {
				echo '<tr style="background-color: #FFF">
					<td></td>				
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right;border: 1px #ccc solid">'.$tot_conf.'</td>
					<td></td>
					<td style="text-align:right;border: 1px #ccc solid">'.$tot_unita.'</td>
					<td></td>
					<td></td>
					<td style="text-align:right;border: 1px #ccc solid">'.$tot_denaro.'</td>
					<td></td>
				</tr>';
        
		}
		
		
		
		
		
		
		}
?>  
  
 
  
   <tr>
   	<td colspan="12" style="background-color: #FFF"></td>
   </tr>





  <tr class="row2">
    <th style="width:8%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=S_CA_TYPE">CARICO <br /> o SCARICO</a></th>
    <th style="width:8%;" id="columnlabel" ><a href="movimenti.php?sort=TIME">DATA</a></th>
    <th style="width:16%;" id="columnlabel" ><a href="movimenti.php?sort=ART_DESC">DESCRIZIONE<br />ARTICOLO</a></th>
	<th style="width:16%;" id="columnlabel" ><a href="movimenti.php?sort=FOR_RAGSOC">RAGIONE SOCIALE<br />FORNITORE *</a></th> 
    <th style="width:16%;" id="columnlabel" ><a href="movimenti.php?sort=CLI_NOMECOGNOME">NOME e COGNOME<br />CLIENTE</a></th>
    <th style="width:6%; font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=S_CA_QTY_CARICO">Confezioni<br /> Caricate</a></th>
    <th style="width:6%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=ARTFOR_CONF">Unità x <br /> Confezione<br />*</a></th>
    <th style="width:6%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=S_CA_QTY_UNIT_S_CARICO">Unità <br />Caricate o Scaricate</a></th>
    <th style="width:6%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=ARTFOR_PXTOT">Prezzo <br />di acquisto <br />x Confezione<br />*</a></th>
    <th style="width:6%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=S_CA_PXUNIT">Prezzo <br />di vendita <br />Unitario<br />*</a></th>
    <th style="width:6%;font-size:xx-small" id="columnlabel" ><a href="movimenti.php?sort=S_CA_PXTOT">Valore<br />Totale<br />*</a></th>
	<th></th>
    
  </tr>
  
  
  
<?php




		$query9 = "SELECT `s_carichi`.`S_CA_ID`, `s_carichi`.`ART_ID`, `s_carichi`.`S_CA_TYPE`, DATE_FORMAT(`s_carichi`.`TIME`, '%d %m %Y') as `dataformattata`, `s_carichi`.`ART_ID`, `articoli`.`ART_DESC`, `s_carichi`.`FOR_ID`, `fornitori`.`FOR_RAGSOC`,  `s_carichi`.`CLI_ID`, `clienti`.`CLI_NOMECOGNOME`, `s_carichi`.`S_CA_QTY_CARICO`, `s_carichi`.`ARTFOR_CONF`, `s_carichi`.`S_CA_QTY_UNIT_S_CARICO`, `s_carichi`.`ARTFOR_PXTOT`, `s_carichi`.`S_CA_PXUNIT`, `s_carichi`.`S_CA_PXTOT` FROM ((`s_carichi` LEFT JOIN `fornitori` ON `s_carichi`.`FOR_ID` = `fornitori`.`FOR_ID`) LEFT JOIN `clienti` ON `s_carichi`.`CLI_ID` = `clienti`.`CLI_ID`)  INNER JOIN `articoli` ON `s_carichi`.`ART_ID` = `articoli`.`ART_ID` ".$queryANDpart.$sqlORDERBY;
		
		
		
		$stmt9 = mysqli_prepare($mysqli, $query9);;
		mysqli_stmt_execute($stmt9);
		mysqli_stmt_bind_result($stmt9, $s_ca_id, $art_id, $s_ca_type, $dataformattata, $art_id2, $art_desc, $for_id, $for_ragsoc, $cli_id, $cli_nomecognome, $s_ca_qty_carico, $artfor_conf, $s_ca_qty_unit_s_carico, $artfor_pxtot, $s_ca_pxunit, $s_ca_pxtot);
		mysqli_stmt_store_result($stmt9);
		if (mysqli_stmt_num_rows($stmt9) >=1) {

			while (mysqli_stmt_fetch($stmt9)) {
			//echo '<tr><br><h4>'.$query_num_rows.' carichi/scarichi trovati <h4><br>';
				echo '<tr>
					<td style="display:none;">'.$s_ca_id.'</td>				
					<td style="text-align:center;">';
					if ($s_ca_type == 'carico'){
						echo '<img title="carico magazzino" src="img/carico.png">';
					} else if ($s_ca_type == 'scarico') {
						echo '<img title="scarico magazzino" src="img/scarico.png">';
					} else {
						echo '<img title="rettifica magazzino" src="img/rettifica.png">';
					}
				echo'</td>
					<td style="text-align: center";>'.$dataformattata.'</td>
					<td>'.$art_desc.'</td>
					<td>'.$for_ragsoc.'</td>
					<td>'.$cli_nomecognome.'</td>
					<td style="text-align:right;">'.$s_ca_qty_carico.'</td>
					<td style="text-align:right;">'.$artfor_conf.'</td>
					<td style="text-align:right;">'.$s_ca_qty_unit_s_carico.'</td>
					<td style="text-align:right;">'.$artfor_pxtot.'</td>
					<td style="text-align:right;">'.$s_ca_pxunit.'</td>
					<td style="text-align:right;">'.$s_ca_pxtot.'</td>'
					?>
                    
					<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questa transazione?')" href="movimenti.php?s_ca_iddelete=<?php echo $s_ca_id?>"><img src="img/bidone3.png"></a>
				</td>
                
                
				<?php
				echo '</tr>';

		}
			
		} else {
			echo '<h4 style="margin-left:5px;">0 carichi/scarichi trovati<h4><br>';
		}
				
	

?>

</table>
<h3 style="font-size: xx-small;"><br />(*) valori alla data dello scarico o del carico<h4><br>
<script type="text/javascript"> 
$(document).ready(function() { 
	
	//1 fissa le righe in alto
	$('.tbl').fixedtableheader(); 
	//2 chiude il menu
	closeNav();


	
}); //FINE $(document).ready(function()



// Funzione di click sulle immagini per filtrare su carico/scarico/carico+scarico
$('.img_c_s').click(function(){
	var qualeimg = $(this).attr("name");
	if (qualeimg == "caricoescarico") { qualeimg=""};
	
	//alert (qualeimg);
	//alert ($("input[name='search_nomcog']").val());
	
	
	 
	 
	 /*$.ajax({
	  async: false,
	  type: "POST",
	  url: "movimenti.php",
	  data: "search_c_s=" + qualeimg,
	  dataType: "html",
	  success: function(return_data)
	  {
		function(return_data){
		var newDoc = document.open("text/html", "replace");
		newDoc.write(return_data);
		newDoc.close();
	  }
	  }
	 })*/
	
	
	
	$.post('movimenti.php', {
		search_datefrom : $("input[name='search_datefrom']").val() ,
		search_dateto : $("input[name='search_dateto']").val() , 
		search_name : $("input[name='search_name']").val() , 
		search_nomcog : $("input[name='search_nomcog']").val() , 
		search_rag : $("input[name='search_rag']").val() , 
		search_c_s : qualeimg
		} , function(return_data){
		var newDoc = document.open("text/html", "replace");
		newDoc.write(return_data);
		newDoc.close();
	}); //fine $.post('movimenti.php',


}); //fine $('.img_c_s').click(function()
// FINE Funzione di click sulle immagini per filtrare su carico/scarico/carico+scarico


// SEARCHASYOUTYPE **********************************************************************************************************
$('.search-box input[type="text100"]').on("keyup input", function(){
	/* Get input value on change */
	var inputVal = $(this).val();
	var resultDropdown = $(this).siblings(".result");
	if(inputVal.length){
		//console.log ($(this).attr("name"));
		if($(this).attr("name")=="search_rag") {
			$.get("backend-search2.php", {term: inputVal, cod_or_desc: "ragsoc"}).done(function(data){
				// Display the returned data in browser
			resultDropdown.html(data);
			}); //fine function
		} else if ($(this).attr("name")=="search_nomcog"){
			$.get("backend-search2.php", {term: inputVal, cod_or_desc: "nomcog"}).done(function(data){
				// Display the returned data in browser
			resultDropdown.html(data);
			}); //fine function	
		} else if ($(this).attr("name")=="search_name") {
			$.get("backend-search2.php", {term: inputVal, cod_or_desc: "desc"}).done(function(data){
				// Display the returned data in browser
			resultDropdown.html(data);
			}); //fine function
		} else if ($(this).attr("name")=="search_cod") {
			//se sto cercando un art_desc allora:
			$.get("backend-search2.php", {term: inputVal, cod_or_desc: "cod"}).done(function(data){
				// Display the returned data in browser
			resultDropdown.html(data);
			}); //fine function
		}		
	} else {
		resultDropdown.empty();
	} // fine if(inputVal.length)
}); //fine function

// Set search input value on click of result item
$(document).on("click", ".result p", function(){
	$(this).parents(".search-box").find('input[type="text100"]').val($(this).text());
	$(this).parent(".result").empty();
	$( "#target" ).submit();
}); // FINE $('.search-box input[type="text100"]').on("keyup input", function()
//FINE SEARCHASYOUTYPE *******************************************************************************************************
</script>
</main>
</body>
</html>