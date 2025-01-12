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
            <a href="#" class="active" style="color: white;">Elenco Fornitori</a>
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





<form id="target" name="search" action="fornitori.php" method ="POST">
	<table id="lst" style="width:80%" class="tbl">	
    <tr>
    <td colspan="10">
    <?php if (isset($POST['numrec'])){echo ($POST['numrec']); }?> <br /><h3> - FORNITORI -</h3>
    </td>
    </tr>
    
    
    
 	<tr style="background-color:white;">
    	  <th>        
        <div class="search-box">
        <input class= "search-input" type="text100" autocomplete="off" placeholder="Ricerca per Ragione Sociale..." name ="search_rag" value ="<?php if (isset ($_POST['search_rag'])) {echo ($_POST['search_rag']);} ?>"/>
        <div class="result" style="position: absolute; width: 15.5%; cursor: default;" ></div>
        </div>
        
        </th>
        <th ></th>	
		<th colspan="7" > </th>
        </form><form action="fornitore.php" method ="POST">

        <th><input type="image" title="nuovo fornitore" src="img/new.png"> </th>
	</tr>

</form>


  <tr class="row2">
    <th style="width:20%;" id="columnlabel"><a href="fornitori.php?sort=FOR_RAGSOC">RAGIONE <br />SOCIALE</a></th>
    <th style="width:10%;" id="columnlabel"><a href="fornitori.php?sort=FOR_PIVA">PARTITA IVA</a></th> 
    <th style="width:20%;" id="columnlabel"><a href="fornitori.php?sort=FOR_INDIRIZZO">INDIRIZZO</a></th>
    <th style="width:10%;" id="columnlabel"><a href="fornitori.php?sort=FOR_CITTA">CITTA'</a></th>
    <th style="width:5%;" id="columnlabel"><a href="fornitori.php?sort=FOR_PROV">PROV.</a></th>
    <th style="width:5%;" id="columnlabel"><a href="fornitori.php?sort=FOR_CAP">CAP</a></th>
    <th style="width:11%;" id="columnlabel"><a href="fornitori.php?sort=FOR_TEL">TEL</a></th>
    <th style="width:15%;" id="columnlabel"><a href="fornitori.php?sort=FOR_EMAIL">EMAIL</a></th>
    <th style="width:2%;" id="columnlabel"></th>
    <th style="width:2%;" id="columnlabel"></th>
  </tr>


<?php

if (loggedin()) {
	
	
	//se è stato passato il parametro GET[sort] allora questo vale sia nel caso in cui la lista sia filtrata sia nel caso in cui non lo sia
	//quindi meglio calcolarlo qui, prima dell'if che identifica se si sta filtrando la lista
	if (isset($_GET['sort'])) {
			if ($_GET['sort'] == 'FOR_RAGSOC')
			{
				$sqlORDERBY= " ORDER BY `FOR_RAGSOC`";
			}
			elseif ($_GET['sort'] == 'FOR_PIVA')
			{
				$sqlORDERBY= " ORDER BY `FOR_PIVA`";
			}
			elseif ($_GET['sort'] == 'FOR_INDIRIZZO')
			{
				$sqlORDERBY= " ORDER BY `FOR_INDIRIZZO`";
			}
			elseif($_GET['sort'] == 'FOR_CITTA')
			{
				$sqlORDERBY= " ORDER BY `FOR_CITTA`";
			}
			elseif($_GET['sort'] == 'FOR_PROV')
			{
				$sqlORDERBY= " ORDER BY `FOR_PROV`";
			}		
			elseif($_GET['sort'] == 'FOR_CAP')
			{
				$sqlORDERBY= " ORDER BY `FOR_CAP`";
			}
			elseif($_GET['sort'] == 'FOR_TEL')
			{
				$sqlORDERBY= " ORDER BY `FOR_TEL`";
			}
			elseif($_GET['sort'] == 'FOR_EMAIL')
			{
				$sqlORDERBY= " ORDER BY `FOR_EMAIL`";
			}
	
		} else {
			$sqlORDERBY= " ORDER BY `FOR_RAGSOC`";
		}
		

	// Caso DELETE
	//Bisognerebbe IMPEDIRE la cancellazione se il fornitore è presente in un qualunque articolo (tabella articoli e tabella articolifornitori) o se è presente nella tabella (s_carichi) 
	if (isset($_GET['for_iddelete'])) {
	
		$for_iddelete = $_GET['for_iddelete'];
		$in_tab_varie = false;
		//Verifica se il fornitore da cancellare è presente nella tabella articoli in verità questo caso è compreso in quello successivo: se è in articoli è anche in articolifornitori per forza
		/*$query= "SELECT `ART_DESC` FROM `articoli` WHERE `FOR_ID` = ".$for_iddelete;
		$query_run = mysql_query ($query);
		$query_num_rows = mysql_num_rows ($query_run) ;
		if ($query_num_rows >=1) {
			$in_tab_varie = true;
			$query_row = mysql_fetch_array($query_run);
			$art_descdel = $query_row['ART_DESC'];
			echo '<h3 class="warn"> fornitore non cancellabile in quanto associato di default almeno all\'articolo: "'.$art_descdel.'"</h3>';
		}*/
		
//Verifica se il fornitore da cancellare è presente nella tabella articolifornitori
		$query= "SELECT `articoli`.`ART_DESC` FROM ( `articoli` INNER JOIN `articolifornitori` ON  `articoli`.`ART_ID` = `articolifornitori`.`ART_ID`) WHERE `articolifornitori`.`FOR_ID` = ".$for_iddelete;
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $art_desc);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			$in_tab_varie = true;
			while (mysqli_stmt_fetch($stmt)) {
				$art_descdel = $art_desc;
			}
			
			echo '<h3 class="warn"> fornitore non cancellabile in quanto associato almeno all\'articolo: "'.$art_descdel.'"</h3>';
		}
//Verifica se il fornitore da cancellare è presente nella tabella s_carichi
		$query= "SELECT DATE_FORMAT(`TIME`, '%d %m %Y') as `dataformattata` FROM `s_carichi` WHERE `FOR_ID` = ".$for_iddelete;
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $dataformattata);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			$in_tab_varie = true;
			while (mysqli_stmt_fetch($stmt)) {
				$s_car_time = $dataformattata;
			}
			
			echo '<h3 class="warn"> articolo non cancellabile in quanto presente nella tabella carichi-scarichi, associato almeno al carico o scarico del: "'.$s_car_time.'"</h3>';
		}
		
		if (!$in_tab_varie) {
			//Metto in $for_ragsoc la ragione sociale per inserirla nel log dopo la cancellazione
			$query= "SELECT `FOR_RAGSOC` FROM `fornitori` WHERE `FOR_ID` = ".$for_iddelete;
			$stmt = mysqli_prepare($mysqli, $query);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $for_ragsoc);
			mysqli_stmt_store_result($stmt);
			if (mysqli_stmt_num_rows($stmt) >=1) {
				while (mysqli_stmt_fetch($stmt)) {
					$for_ragsoc = $for_ragsoc;
				}
			}
	
	
			$query = "DELETE FROM `fornitori` WHERE `FOR_ID` = ".$for_iddelete;
			$stmt = mysqli_prepare($mysqli, $query);
			mysqli_stmt_execute($stmt);
			
			$query = "DELETE FROM `articolifornitori` WHERE `FOR_ID` = ".$for_iddelete;
			$stmt = mysqli_prepare($mysqli, $query);
			mysqli_stmt_execute($stmt);
			
			//Ora aggiorna anche il Log
			$logsino = getuserfield ('LOG');
			if ($logsino == 1) {
				$query ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `FOR_ID`, `FOR_RAGSOC`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione fornitore', '".$for_iddelete."', '".$for_ragsoc."' )";
				$stmt = mysqli_prepare($mysqli, $query);
				mysqli_stmt_execute($stmt);
				//fine aggiornamento log
			}
		}

	} // fine DELETE

		
	
	if (isset ($_POST['search_rag'])){
		
		$search_rag = $_POST['search_rag'];
		//$queryANDpart = " WHERE `FOR_RAGSOC` LIKE '%".mysql_real_escape_string($search_rag)."%' ";	
		$queryANDpart = " WHERE `FOR_RAGSOC` LIKE '%".$search_rag."%' ";	


		
		$query = "SELECT `FOR_ID`, `FOR_RAGSOC`, `FOR_PIVA`, `FOR_INDIRIZZO`, `FOR_CITTA`, `FOR_PROV`, `FOR_CAP`, `FOR_TEL`, `FOR_EMAIL` FROM `fornitori`".$queryANDpart.$sqlORDERBY;

		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $for_id, $for_ragsoc, $for_piva, $for_indirizzo, $for_citta, $for_prov, $for_cap, $for_tel, $for_email);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			
			
			//echo '<br><h4 style="margin-left:5px;">'.$query_num_rows.' fornitori trovati <h4><br>';
		
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt)) {
				echo '<tr>
				<td style="display:none";>'.$for_id.'</td>
				
				<td>'.$for_ragsoc.'</td>
				<td>'.$for_piva.'</td>
				<td>'.$for_indirizzo.'</td>
				<td>'.$for_citta.'</td>
				<td>'.$for_prov.'</td>
				<td>'.$for_cap.'</td>
				<td>'.$for_tel.'</td>
				<td>'.$for_email.'</td>
				<td> <a href="fornitore.php?for_id='.$for_id.'"><img src="img/lente.png"></a> </td>';
				?>					
					<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo fornitore?')" href="fornitori.php?for_iddelete=<?php echo $for_id?>"><img src="img/bidone3.png"></a>
				</td>
				</tr>
        		<?
			}
			
		} else {
			echo '<h4 style="margin-left:5px;">0 fornitori trovati<h4><br>';
		}
				
				
	} else { 
		$query = "SELECT `FOR_ID`, `FOR_RAGSOC`, `FOR_PIVA`, `FOR_INDIRIZZO`, `FOR_CITTA`, `FOR_PROV`, `FOR_CAP`, `FOR_TEL`, `FOR_EMAIL` FROM `fornitori`".$sqlORDERBY; 
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $for_id, $for_ragsoc, $for_piva, $for_indirizzo, $for_citta, $for_prov, $for_cap, $for_tel, $for_email);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			
			//echo '<br><h4 style="margin-left:5px;">'.$query_num_rows.' fornitori trovati <h4><br>';
			
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt)) {
				echo '<tr>
				<td style="display:none";>'.$for_id.'</td>
					
				<td>'.$for_ragsoc.'</td>
				<td>'.$for_piva.'</td>
				<td>'.$for_indirizzo.'</td>
				<td>'.$for_citta.'</td>
				<td>'.$for_prov.'</td>
				<td>'.$for_cap.'</td>
				<td>'.$for_tel.'</td>
				<td>'.$for_email.'</td>
				<td> <a href="fornitore.php?for_id='.$for_id.'"><img src="img/lente.png"></a> </td>';
				?>					
					<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo fornitore?')" href="fornitori.php?for_iddelete=<?php echo $for_id?>"><img src="img/bidone3.png"></a>
				</td>
				</tr>
        		<?
		
			}
		}
	
	}
}
?>

</table>
<script type="text/javascript"> 
$(document).ready(function() { 
	
	//1 fissa le righe in alto
	$('.tbl').fixedtableheader(); 
	//2 chiude il menu
	closeNav();


	
}); //FINE $(document).ready(function()


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