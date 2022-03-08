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

<div id="mySidenav" class="sidenav ">
<!--<div class="w3-sidebar w3-bar-block w3-dark-grey w3-animate-left" style="display:none" id="mySidebar">
			<button class="w3-bar-item w3-button w3-large"  onclick="w3_close()">Close &times;</button>-->
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
         	<a href="articoli.php">Elenco Articoli</a>
            <a style="font-size:xx-small; margin-left: 20px;" href="console.php" >Articoli Sotto Scorta</a>
            <a href="fornitori.php">Elenco Fornitori</a>
            <a href="#"class="active" style="color: white;">Elenco Clienti</a>
            <a href="movimenti.php">Movimenti Magazzino</a>
            <a href="download.php">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>








<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>

<main>

			<form id="target" action="clienti.php" method ="POST">

	<table id="lst" style="width:80%" class="tbl">	


        <tr style="background-color:white;">
        <td colspan="7">
        <br /><h3>- CLIENTI -</h3>
        </td>
        </tr>
     	<tr style="background-color:white;">
    	<th style="width:50%;" colspan="2">
        <div class="search-box">
        	<input class= "search-input" type="text100" autocomplete="off" placeholder="Ricerca per Nome o Cognome cliente..." name ="search_nomcog" value ="<?php if (isset ($_POST['search_nomcog'])) {echo ($_POST['search_nomcog']);} ?>"/>
        <div class="result" style="position: absolute; width: 31.8%; cursor: default;" ></div>
        </div>
        </th>
        <th>
        	</form>
        </th>	
		<th>
        	<form action="cliente.php" method ="POST">
        </th>
        <th>
        	
        </th>
        <th>

        </th>
        <th>
        	<input type="image" title="nuovo cliente" src="img/new.png"> 
        </th>
	</tr>
			</form>



  <tr class="row2">
    <th style="width:20%;" id="columnlabel"><a href="clienti.php?sort=CLI_NOME">NOME</a></th>
    <th style="width:20%;" id="columnlabel"><a href="clienti.php?sort=CLI_COGNOME">COGNOME</a></th> 
    <th style="width:20%;" id="columnlabel"><a href="clienti.php?sort=CLI_CLASSE">CLASSE</a></th>
    <th style="width:15%;" id="columnlabel"><a href="clienti.php?sort=CLI_TEL">TELEFONO</a></th>
    <th style="width:19%;" id="columnlabel"><a href="clienti.php?sort=CLI_EMAIL">EMAIL</a></th>
    <th style="width:3%;" id="columnlabel">&nbsp;<br />&nbsp;</th>
    <th style="width:3%;" id="columnlabel"></th>
  </tr>


<?php

if (loggedin()) {
	
	
	//se è stato passato il parametro GET[sort] allora questo vale sia nel caso in cui la lista sia filtrata sia nel caso in cui non lo sia
	//quindi meglio calcolarlo qui, prima dell'if che identifica se si sta filtrando la lista
	if (isset($_GET['sort'])) {
			if ($_GET['sort'] == 'CLI_NOME')
			{
				$sqlORDERBY= " ORDER BY `CLI_NOME`";
			}
			elseif ($_GET['sort'] == 'CLI_COGNOME')
			{
				$sqlORDERBY= " ORDER BY `CLI_COGNOME`";
			}
			elseif ($_GET['sort'] == 'CLI_CLASSE')
			{
				$sqlORDERBY= " ORDER BY `CLI_CLASSE`";
			}
			elseif($_GET['sort'] == 'CLI_TEL')
			{
				$sqlORDERBY= " ORDER BY `CLI_TEL`";
			}
			elseif($_GET['sort'] == 'CLI_EMAIL')
			{
				$sqlORDERBY= " ORDER BY `CLI_EMAIL`";
			}		
	
	} else {
		$sqlORDERBY= " ORDER BY `CLI_COGNOME`";
	}
		
	
	// Caso DELETE
	if (isset($_GET['cli_iddelete'])) {
		
		$cli_iddelete= 	$_GET['cli_iddelete'];
		$in_tab_varie = false;
	
//Verifica se il cliente da cancellare è presente nella tabella s_carichi
	$query= "SELECT DATE_FORMAT(`TIME`, '%d %m %Y') as `dataformattata` FROM `s_carichi` WHERE `CLI_ID` = ".$cli_iddelete;
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $dataformattata);
	mysqli_stmt_store_result($stmt);

		if (mysqli_stmt_num_rows($stmt) >=1) {
			$in_tab_varie = true;
			while (mysqli_stmt_fetch($stmt)) {
			}
			$s_car_time = $dataformattata;
			echo '<h3 class="warn"> articolo non cancellabile in quanto presente nella tabella carichi-scarichi, associato almeno al carico o scarico del: "'.$s_car_time.'"</h3>';		}
			
		if (!$in_tab_varie) {
			//Metto in $cli_nomecognome il nome e cognome per inserirlo nel log dopo la cancellazione
			$query2= "SELECT `CLI_NOMECOGNOME` FROM `clienti` WHERE `CLI_ID` = ".$cli_iddelete;
			
			$stmt2 = mysqli_prepare($mysqli, $query2);
			mysqli_stmt_execute($stmt2);
			mysqli_stmt_bind_result($stmt2, $cli_nomecognome);
			mysqli_stmt_store_result($stmt2);
			if (mysqli_stmt_num_rows($stmt2) >=1) {
				while (mysqli_stmt_fetch($stmt2)) {
				}
			}
					
			$query3 = "DELETE FROM `clienti` WHERE `CLI_ID` = ".$cli_iddelete;
			
			$stmt3 = mysqli_prepare($mysqli, $query3);
			mysqli_stmt_execute($stmt3);
			
					//Ora aggiorna anche il Log
			$logsino = getuserfield ('LOG');
			if ($logsino == 1) {
				$query4 ="INSERT INTO `log` ( `USER_ID`, `OPERAZIONE`, `CLI_ID`, `CLI_NOMECOGNOME`) VALUES ( '".$_SESSION['user_id']."', 'cancellazione cliente', '".$cli_iddelete."', '".$cli_nomecognome."' )";
				$stmt4 = mysqli_prepare($mysqli, $query4);
				mysqli_stmt_execute($stmt4);
				//fine aggiornamento log
			}
		}
	} //fine DELETE
	
	
	
	
	if (isset ($_POST['search_nomcog'])){
		
		$search_nomcog = $_POST['search_nomcog'];
		//$queryANDpart = " WHERE `CLI_NOMECOGNOME` LIKE '%".mysql_real_escape_string($search_nomcog)."%' ";
		$queryANDpart = " WHERE `CLI_NOMECOGNOME` LIKE '%".$search_nomcog."%' ";	



		
		$query5 = "SELECT `CLI_ID`, `CLI_NOME`, `CLI_COGNOME`, `CLI_NOMECOGNOME`, `CLI_CLASSE`, `CLI_TEL`, `CLI_EMAIL` FROM `clienti`".$queryANDpart.$sqlORDERBY;
		$stmt5 = mysqli_prepare($mysqli, $query5);
		mysqli_stmt_execute($stmt5);
		mysqli_stmt_bind_result($stmt5, $cli_id, $cli_nome, $cli_cognome, $cli_nomecognome, $cli_classe, $cli_tel, $cli_email);
		mysqli_stmt_store_result($stmt5);

		if (mysqli_stmt_num_rows($stmt5) >=1) {
			
			//echo '<br><h4 style="margin-left:5px;">'.$query_num_rows.' clienti trovati <h4><br>';
		
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt5)) {?>
			<tr>
				<td style="display:none";><?php echo $query_row['CLI_ID'];?></td>
				
				<td><?php echo $cli_nome;?></td>
				<td><?php echo $cli_cognome;?></td>
				<td><?php echo $cli_classe;?></td>
				<td><?php echo $cli_tel;?></td>
				<td><?php echo $cli_email;?></td>
				<td> <a href="cliente.php?cli_id=<?php echo $query_row['CLI_ID'];?>"><img src="img/lente.png"></a> </td>
				
                <td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')" href="clienti.php?cli_iddelete=<?echo ($cli_id)?>"><img src="img/bidone3.png"></a>
				</td>
			</tr>
        <?php    
		}
			
		} else {
			echo '<h4 style="margin-left:5px;">0 clienti trovati<h4><br>';
		}
				
				
	} else { 

		$query6 = "SELECT `CLI_ID`, `CLI_NOME`, `CLI_COGNOME`, `CLI_NOMECOGNOME`, `CLI_CLASSE`, `CLI_TEL`, `CLI_EMAIL` FROM `clienti`".$sqlORDERBY; 
		$stmt6 = mysqli_prepare($mysqli, $query6);
		mysqli_stmt_execute($stmt6);
		mysqli_stmt_bind_result($stmt6, $cli_id, $cli_nome, $cli_cognome, $cli_nomecognome, $cli_classe, $cli_tel, $cli_email);
		mysqli_stmt_store_result($stmt6);

			
			
		
		
		
		if (mysqli_stmt_num_rows($stmt6) >=1) {
			
			//echo '<br><h4 style="margin-left:5px;">'.$query_num_rows.' clienti trovati <h4><br>';
			
			//se ne trova li mettiamo tutti in un associative array
			while (mysqli_stmt_fetch($stmt6)) {
			?>
			<tr>
				<td style="display:none";><?php echo $query_row['CLI_ID']?></td>
					
				<td><?php echo $cli_nome?></td>
				<td><?php echo $cli_cognome?></td>
				<td><?php echo $cli_classe?></td>
				<td><?php echo $cli_tel?></td>
				<td><?php echo $cli_email?></td>
				<td> <a href="cliente.php?cli_id=<?php echo $cli_id?>"><img src="img/lente.png"></a> </td>
				
				<td>
					<a onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')" href="clienti.php?cli_iddelete=<?php echo $cli_id?>"><img src="img/bidone3.png"></a>
				</td>
				
				
			</tr>
			<?php
			//<td> <a onclick="return confirm_click(); href="clienti.php?cli_iddelete='.$query_row['CLI_ID'].'"><img src="img/bidone3.png"></a> </td>
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