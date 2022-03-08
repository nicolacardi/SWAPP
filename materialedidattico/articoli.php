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
echo "<br><h3>You are not Logged in</h3>";
echo '<br><h3><a href="index.php">Login</a></h3>';
die();
}



?>

<div id="logo">
<h6><a onclick="return confirm('LOGOUT: Sei sicuro di voler uscire?')" href="logout.php"><img src="img/user2.png"></a><br /><?php $username = getuserfield ('username'); echo $username;?> <br /></h6>
<h6><div id="clockbox"></div></h6>
</div>


<div id="mySidenav" class="sidenav ">
<!--<div class="w3-sidebar w3-bar-block w3-dark-grey w3-animate-left" style="display:none" id="mySidebar">
			<button class="w3-bar-item w3-button w3-large"  onclick="w3_close()">Close &times;</button>-->
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         	<a href="#"class="active" style="color: white;">Elenco Articoli</a>
            <a style="font-size:xx-small; margin-left: 20px;" href="console.php" >Articoli Sotto Scorta</a>
            <a href="fornitori.php">Elenco Fornitori</a>
            <a href="clienti.php">Elenco Clienti</a>
            <a href="movimenti.php">Movimenti Magazzino</a>
            <a href="download.php">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>

<div>
  <!--<button class="w3-button w3-white w3-xxlarge" onclick="w3_open()">&#9776;</button>-->
<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>

<main>

<form id="target" action="articoli.php" method ="POST">
	<table id="lst" style="width:80%;" class="tbl">
         <tr style="background-color:white;">
        <td colspan="11">
        <br /><h3>- ARTICOLI -</h3>
        </td>
        </tr>
    <tr style="background-color:white;">
    	<th><div class="search-box">
        <input class= "search-input" type="text100" autocomplete="off" placeholder="Ricerca per Codice..." name ="search_cod" value ="<?php if (isset ($_POST['search_cod'])) {echo ($_POST['search_cod']);} ?>"/>
        <div class="result" style="position: absolute; width: 11.5%; cursor: default;" ></div>
        </div>
        </th>
        
        <!--<th class="nopadding"> <input type = "text100" maxlength="20" name ="search_cod"  value ="<?php //if (isset ($_POST['search_cod'])) {echo ($_POST['search_cod']);} ?>"> </th>-->
        <!--<th class="nopadding">  <input type = "text100" maxlength="255" name ="search_name" value ="<?php //if (isset ($_POST['search_name'])) {echo ($_POST['search_name']);} ?>"> </th>-->
        <th>
        <div class="search-box">
        <input class= "search-input" type="text100" autocomplete="off" placeholder="Ricerca per Descrizione..." name ="search_name" value ="<?php if (isset ($_POST['search_name'])) {echo ($_POST['search_name']);} ?>"/>
        <div class="result" style="position: absolute; width: 21%; cursor: default;" ></div>
        </div>
        </th>
        
        
        <th> </th>
		<th > </th>
        </form><form action="articolo.php" method ="POST">
        <th > </th>
        <th > </th>
        <th > </th>
        <th > </th>
        <th > </th>
        <th > </th>
        <th ><input type="image" title="nuovo articolo" src="img/new.png"> </th>
    </tr>


</form>



  <tr class="row2">
    <th style="width:16%;" id="columnlabel" ><a href="articoli.php?sort=ART_COD">CODICE</a></th>
    <th style="width:28%;" id="columnlabel" ><a href="articoli.php?sort=ART_DESC">DESCRIZIONE</a></th>
    <th style="width:16%;" id="columnlabel" ><a href="articoli.php?sort=FOR_RAGSOC">FORNITORE <br /> di DEFAULT</a></th>
	<th style="width:16%;" id="columnlabel" ><a href="articoli.php?sort=TIP_DESC">TIPOLOGIA</a></th> 
    <th style="width:8%;" id="columnlabel" ><a href="articoli.php?sort=ART_QTY_STOCK">QUANTITA' <br />A MAGAZZINO</a></th>
    <th style="width:8%;" id="columnlabel" ><a href="articoli.php?sort=ART_QTY_REORDER">SOGLIA <br /> DI RIORDINO</a></th>
	<th style="width:2%;"></th>
    <th style="width:2%;"></th>
    <th style="width:2%;"></th>
    <th style="width:2%;"></th>
    <th style="width:2%;"></th>
    
  </tr>
  
  
  
<?php


if (loggedin()) {
	
	if (isset ($_POST['search_name'])) {

		$search_name = $_POST['search_name']; {
			if (empty($search_name)) {
				$search_name = "any";
			}
		} 
	}
	

	if (isset ($_POST['search_cod'])) {
		$search_cod = $_POST['search_cod']; {
			if (empty($search_cod)) {
				$search_cod = "any";
			}
		}
	}

	//se è stato passato il parametro GET[sort] allora questo vale sia nel caso in cui la lista sia filtrata sia nel caso in cui non lo sia
	//quindi meglio calcolarlo qui, prima dell'if che identifica se si sta filtrando la lista
	if (isset($_GET['sort'])) {
			if ($_GET['sort'] == 'ART_COD')
			{
				$sqlORDERBY= " ORDER BY `ART_COD`";
			}
			elseif ($_GET['sort'] == 'ART_DESC')
			{
				$sqlORDERBY= " ORDER BY `ART_DESC`";
			}
			elseif ($_GET['sort'] == 'FOR_RAGSOC')
			{
				$sqlORDERBY= " ORDER BY `FOR_RAGSOC`";
			}
			elseif($_GET['sort'] == 'TIP_DESC')
			{
				$sqlORDERBY= " ORDER BY `TIP_DESC`";
			}
			elseif($_GET['sort'] == 'ART_QTY_STOCK')
			{
				$sqlORDERBY= " ORDER BY `ART_QTY_STOCK`";
			}		
			elseif($_GET['sort'] == 'ART_QTY_REORDER')
			{
				$sqlORDERBY= " ORDER BY `ART_QTY_REORDER`";
			}
	
	
		} else {
			$sqlORDERBY= " ORDER BY `ART_COD`";
		}
		
		
		
		// Caso DELETE
	if (isset($_GET['art_iddelete'])) {
		$art_iddelete=($_GET['art_iddelete']);
		
	
//Verifica se l'articolo da cancellare è presente nella tabella 

	$query= "SELECT DATE_FORMAT(`TIME`, '%d %m %Y') as `dataformattata` FROM `s_carichi` WHERE `ART_ID` = ".$art_iddelete;
		$stmt = mysqli_prepare($mysqli, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $data_formattata);
		mysqli_stmt_store_result($stmt);
		if (mysqli_stmt_num_rows($stmt) >=1) {
			while (mysqli_stmt_fetch($stmt)) {
			}
			$s_car_time = $dataformattata;
			echo '<h3 class="warn"> articolo non cancellabile in quanto presente nella tabella carichi-scarichi, associato almeno al carico o scarico del: "'.$s_car_time.'"</h3>';
		} else {
			
			//Metto in $art_desc la descrizione per inserirla nel log dopo la cancellazione
			$query2= "SELECT `ART_DESC` FROM `articoli` WHERE `ART_ID` = ".$art_iddelete;
			$stmt2 = mysqli_prepare($mysqli, $query2);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_bind_result($stmt2, $art_desc);
			mysqli_stmt_store_result($stmt2);
			if (mysqli_stmt_num_rows($stmt2) >=1) {
				while (mysqli_stmt_fetch($stmt2)) {
					$art_desc = $qart_desc;
				}
			}
			
			$query3 = "DELETE FROM `articoli` WHERE `ART_ID` = ".$art_iddelete;
			$stmt3 = mysqli_prepare($mysqli, $query3);
			mysqli_stmt_execute($stmt3);
			
			$query4 = "DELETE FROM `articolifornitori` WHERE `ART_ID` = ".$art_iddelete;
			$stmt4 = mysqli_prepare($mysqli, $query4);
			mysqli_stmt_execute($stmt4);
		
			//Ora aggiorna anche il Log
			$logsino = getuserfield ('LOG');
			if ($logsino == 1) {
				$query5 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `ART_ID`, `ART_DESC`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione articolo', '".$art_iddelete."', '".$art_desc."' )";
				$stmt5 = mysqli_prepare($mysqli, $query5);
				mysqli_stmt_execute($stmt5);
				//fine aggiornamento log
			}
		}
	}
		
		
		
	if (isset ($_POST['search_name']) || isset ($_POST['search_cod'])){
		
		if (($search_name == "any") && ($search_cod =="any")) {
		$queryANDpart = " ";
		}
		
		if (($search_name == "any") && !($search_cod =="any")) {
		$queryANDpart = " WHERE `ART_COD` LIKE '%".mysqli_real_escape_string($mysqli, $search_cod)."%' ";	
		}
		
		if (!($search_name == "any") && ($search_cod =="any")) {
		$queryANDpart = " WHERE `ART_DESC` LIKE '%".mysqli_real_escape_string($mysqli, $search_name)."%' ";	
		}
		
		if (!($search_name == "any") && !($search_cod =="any")) {
		$queryANDpart = " WHERE `ART_DESC` LIKE '%".mysqli_real_escape_string($mysqli, $search_name)."%' AND `ART_COD` LIKE '%".mysqli_real_escape_string($mysqli, $search_cod)."%' ";	
		}
	
		
		
		$query6 = "SELECT `articoli`.`ART_ID`, `articoli`.`ART_COD`, `articoli`.`ART_DESC`, `articoli`.`ART_QTY_STOCK`, `articoli`.`ART_QTY_REORDER`,  `fornitori`.`FOR_RAGSOC`, `fornitori`.`FOR_ID`, `tipologie`.`TIP_ID`, `tipologie`.`TIP_DESC` FROM (`articoli` INNER JOIN `fornitori` ON `articoli`.`FOR_ID` = `fornitori`.`FOR_ID`) INNER JOIN `tipologie` ON `articoli`.`TIP_ID` = `tipologie`.`TIP_ID` ".$queryANDpart.$sqlORDERBY;
		
		$stmt6 = mysqli_prepare($mysqli, $query6);
		mysqli_stmt_execute($stmt6);
		mysqli_stmt_bind_result($stmt6, $art_id, $art_cod, $art_desc, $art_qty_stock, $art_qty_reorder, $for_ragsoc, $for_id, $tip_id, $tip_desc);
		mysqli_stmt_store_result($stmt6);
		
		if (mysqli_stmt_num_rows($stmt6) >=1) {
			//echo '<tr><br><h4>'.$query_num_rows.' articoli trovati <h4><br>';
			//echo '</table><table table id="lst" style="width:80%;">';
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt6)) {
				echo '<tr>
					<td style="display:none";>'.$art_id.'</td>
										
					<td>'.$art_cod.'</td>
					<td>'.$art_desc.'</td>
					<td>'.$for_ragsoc.'</td>
					<td>'.$tip_desc.'</td>';
					if (($art_qty_stock) <= ($art_qty_reorder)) {
						echo '<td class="warnstock">'.$art_qty_stock.'</td>';
					} else { echo '<td>'.$art_qty_stock.'</td>';
					}
					
					echo '<td>'.$art_qty_reorder.'</td>
					
					
					<td> <a href="articolo.php?art_id='.$art_id.'" title="Apri Singolo Articolo"><img src="img/lente.png"></a> </td>
					<td> <a href="carico.php?art_id='.$art_id.'" title="Carico Magazzino"><img src="img/carico.png"></a> </td>
					<td> <a href="scarico.php?art_id='.$art_id.'" title="Scarico Magazzino"><img src="img/scarico.png"></a> </td>
					<td> <a href="rettifica.php?art_id='.$art_id.'" title="Rettifica Magazzino"><img src="img/rettifica.png"></a> </td>'
					?>					
					<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')" href="articoli.php?art_iddelete=<?php echo $art_id?>"><img src="img/bidone3.png"></a>
				</td>
				</tr>
        <?php
		}
			
		} else {
			echo '<h4 style="margin-left:5px;">0 articoli trovati<h4><br>';
		}
				
				
	} else { 
		
		
		
		$query7 = "SELECT `articoli`.`ART_ID`, `articoli`.`ART_COD`, `articoli`.`ART_DESC`, `articoli`.`ART_QTY_STOCK`, `articoli`.`ART_QTY_REORDER`, `fornitori`.`FOR_RAGSOC`, `fornitori`.`FOR_ID`, `tipologie`.`TIP_ID`, `tipologie`.`TIP_DESC` FROM (`articoli` INNER JOIN `fornitori` ON `articoli`.`FOR_ID` = `fornitori`.`FOR_ID`) INNER JOIN `tipologie` ON `articoli`.`TIP_ID` = `tipologie`.`TIP_ID` ".$sqlORDERBY;
		
		
		$stmt7 = mysqli_prepare($mysqli, $query7);
		mysqli_stmt_execute($stmt7);
		mysqli_stmt_bind_result($stmt7, $art_id, $art_cod, $art_desc, $art_qty_stock, $art_qty_reorder, $for_ragsoc, $for_id, $tip_id, $tip_desc);
		mysqli_stmt_store_result($stmt7);
		
		if (mysqli_stmt_num_rows($stmt7) >=1) {
			
			//echo '<br><h4 style="margin-left:5px;">'.$query_num_rows.' articoli trovati <h4><br>';
			//echo '</table><table table id="lst" style="width:80%;">';
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt7)) {
			echo '<tr>
				<td style="display:none";>'.$art_id.'</td>
				
				<td>'.$art_cod.'</td>
				<td>'.$art_desc.'</td>
				<td>'.$for_ragsoc.'</td>
				<td>'.$tip_desc.'</td>';
					if ((($art_qty_stock) <= ($art_qty_reorder))) {
						echo '<td id="warnstock">'.$art_qty_stock.'</td>';
					} else { echo '<td>'.$art_qty_stock.'</td>';
					}	
				echo '<td>'.$art_qty_reorder.'</td>
				
				
				<td> <a href="articolo.php?art_id='.$art_id.'" title="Apri Singolo Articolo"><img src="img/lente.png"></a> </td>
				<td> <a href="carico.php?art_id='.$art_id.'" title="Carico Magazzino"><img src="img/carico.png"></a> </td>
				<td> <a href="scarico.php?art_id='.$art_id.'" title="Scarico Magazzino"><img src="img/scarico.png"></a> </td>
				<td> <a href="rettifica.php?art_id='.$art_id.'" title="Rettifica Magazzino"><img src="img/rettifica.png"></a> </td>';
			
			?>					
					<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo articolo?')" href="articoli.php?art_iddelete=<?php echo $art_id?>"><img src="img/bidone3.png"></a>
				</td>
				</tr>
        <?php
			
			
			
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
			console.log (inputVal);
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