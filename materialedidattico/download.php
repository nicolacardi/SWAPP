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
            <a href="movimenti.php">Movimenti Magazzino</a>
            <a href="#"class="active" style="color: white;">Report</a>
            <br />
            <a style="border-top: 1px solid #CCC" href="logout.php">Log Out</a>

</div>

<div class="header">
<span id="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>




<?php

if (!empty($_POST["optcarichi"])) {
    $optcarichi = test_input($_POST["optcarichi"]);
  } else {
    
  }
  
if (!empty($_POST["optscarichi"])) {
    $optscarichi = test_input($_POST["optscarichi"]);
  } else {
    
  }
  
if (!empty($_POST["optarticoli"])) {
    $optarticoli = test_input($_POST["optarticoli"]);
  } else {
    
  }
  

  
//la funzione test_input pulisce da schifezze il testo immesso

?>

<br>


<!----------------------------------------------------------------  FORM  ---------------------------------------------------------------------->


<div class="moduli">
    
        <!--tabella a sette colonne-->
        <form action="export.php" method="POST">
        <table id="art" style="width:60%; text-align: center;">
        
<!--------------------------------------------------------  Carichi Magazzino  ------------------------------------------------------------------>        
            <tr>
            
                <td colspan ="7" style=" border-top: 1px solid #06C;">
                <h3>Carichi Magazzino</h3>
                </td>
            
            </tr>
            
            <tr>
                <td width ="10%">
                    <input class="tutti" type="radio" name="optcarichi" checked value="tutti" onclick="nascondicarichi();">tutti
                    <?php //if (isset($optcarichi) && ($optcarichi=="tutti")) { echo "checked";}?>
                </td>
              
                <td width ="20%" colspan="2" style=" border-left: 1px solid #06C;">
                    <input type="radio" name="optcarichi" onclick="mostracarichi();" <?php if (isset($optcarichi) && ($optcarichi=="perfornitore")) { echo "checked";}?> value="perfornitore" />per fornitore
                </td>
                
                <td width ="20%" colspan="2" >
                    <!--<input type="radio" name="optcarichi" <?php //if (isset($optcarichi) && ($optcarichi=="perdate")) { echo "checked";}?> value="perdate" />per intervallo date-->				
                </td>
                
                <td width ="20%" colspan="2">
                    <input name="carichi" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>
                
        	</tr>


            <tr class="troptcarichi">
                <td>
                </td>
                
                <td colspan="2" style=" border-left: 1px solid #06C;">
                    <div class="styled-select black semi-square">
                    <select name="FOR_RAGSOCCOMBO">
                            <option class="black" value="">Seleziona...</option>';
                                <?php $sql = "SELECT `FOR_ID`, `FOR_RAGSOC` FROM `fornitori` ORDER BY `FOR_RAGSOC`";
                                $stmt = mysqli_prepare($mysqli, $sql);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $dbfor_id, $dbfor_ragsoc);
                                mysqli_stmt_store_result($stmt);
                                while (mysqli_stmt_fetch($stmt)) {
                                    echo "<option class='black' value='" . $dbfor_id . "'>" . $dbfor_ragsoc . "</option>";
                                }
                                ?>
                             
                    </select>
                    </div>
                </td>
                
                <td >
                    <!--dal <input type="textarticolo" maxlength="10" name="DATA_DA1" value="<?php //if (isset ($data_da1)){echo $data_da1;} ?>">-->
                </td>
               
                <td>
                    <!--al <input type="textarticolo" maxlength="10" name="DATA_A1" value="<?php //if (isset ($data_a1)){echo $data_a1;} ?>">-->
                </td>
                
               

            </tr>
        </form>
            <tr>
            
                <td colspan="7">
                    <br />
                </td>
            
            </tr>
        <form action="export.php" method="POST">
            <tr>

<!-------------------------------------------------------- Scarichi Magazzino  -----------------------------------------------------------------> 
                
                <td colspan ="7" style=" border-top: 1px solid #06C;">
                <h3>Scarichi Magazzino</h3>
                </td>
            
            </tr>
            
            <tr>
                <td>
                    <input class="tutti" type="radio" name="optscarichi" checked value="tutti" onclick="nascondiscarichi();">tutti
                    <?php //if (isset($optcarichi) && ($optcarichi=="tutti")) { echo "checked";}?>
                </td>
              
                <td colspan="2" style=" border-left: 1px solid #06C;">
                    <input type="radio" name="optscarichi" onclick="mostrascarichi();" <?php if (isset($optscarichi) && ($optcsarichi=="percliente")) { echo "checked";}?> value="percliente" />per cliente
                </td>
                
                <td colspan="2" >
                    <!--<input type="radio" name="optscarichi" <?php //if (isset($optscarichi) && ($optscarichi=="perdate")) { echo "checked";}?> value="perdate" />per intervallo date-->				
                </td>
                
                <td colspan="2">
                    <input name="scarichi" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>
                
        	</tr>
            
            <tr class="troptscarichi">
                <td>
                </td>
                
                <td colspan="2" style=" border-left: 1px solid #06C;">
                    <div class="styled-select black semi-square">
                    <select name="CLI_NOMECOGNOMECOMBO">
                            <option class='black' value="">Seleziona...</option>';
                                <?php $sql2 = "SELECT `CLI_ID`, `CLI_NOMECOGNOME` FROM `clienti` ORDER BY `CLI_NOME`";
                                $stmt2 = mysqli_prepare($mysqli, $sql2);
                                mysqli_stmt_execute($stmt2);
                                mysqli_stmt_bind_result($stmt2, $dbcli_id, $dbcli_nomecognome);
                                mysqli_stmt_store_result($stmt2);
                                while (mysqli_stmt_fetch($stmt2)) {
                                    echo "<option class='black' value='" . $dbcli_id . "'>" . $dbcli_nomecognome . "</option>";
                                }
                                ?>
                             
                    </select>
                    </div>
                </td>
                
                <td >
                    <!--dal <input type="textarticolo" maxlength="10" name="DATA_DA1" value="<?php //if (isset ($data_da1)){echo $data_da1;} ?>">-->
                </td>
               
                <td>
                    <!--al <input type="textarticolo" maxlength="10" name="DATA_A1" value="<?php //if (isset ($data_a1)){echo $data_a1;} ?>">-->
                </td>
                
               

            </tr>
        </form>
        
        
<!------------------------------------------------------------------  Articoli  ----------------------------------------------------------------->         
            <tr>
            
                <td colspan="7">
                    <br />
                </td>
            
            </tr>
        <form action="export.php" method="POST">
            <tr>
                
                <td colspan ="7" style="border-top: 1px solid #06C;">
                <h3>Anagrafica Articoli</h3>
                </td>
            
            </tr>
            
            <tr>
                <td>
                    <input class="tutti" type="radio" name="optarticoli" checked value="tutti" onclick="nascondiarticoli();">tutti
                    <?php //if (isset($optarticoli) && ($optarticoli=="tutti")) { echo "checked";}?>
                </td>
              
                <td colspan="2" style="border-left: 1px solid #06C;">
                    <input type="radio" name="optarticoli" onclick="mostraarticoli();" <?php if (isset($optarticoli) && ($optarticoli=="perfornitore")) { echo "checked";}?> value="perfornitore" />per fornitore
                </td>
                
                <td colspan="2" style="border-left: 1px solid #06C;">
                    <input type="radio" name="optarticoli" onclick="mostraarticoli();" <?php if (isset($optarticoli) && ($optarticoli=="pertipologia")) { echo "checked";}?> value="pertipologia" />per tipologia			
                </td>
                
				<td colspan="2">
                    <input name="articoli" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>
                
        	</tr>
            
            <tr class="troptarticoli">
                <td>
                </td>
                
                <td colspan="2" style=" border-left: 1px solid #06C;">
                    <div class="styled-select black semi-square">
                    <select name="FOR_RAGSOCCOMBO2">
                            <option class='black' value="">Seleziona...</option>';
                                <?php $sql3 = "SELECT `FOR_ID`, `FOR_RAGSOC` FROM `fornitori` ORDER BY `FOR_RAGSOC`";
                                $stmt3 = mysqli_prepare($mysqli, $sql3);
                                mysqli_stmt_execute($stmt3);
                                mysqli_stmt_bind_result($stmt3, $dbfor_id, $dbfor_ragsoc);
                                mysqli_stmt_store_result($stmt3);
                                while (mysqli_stmt_fetch($stmt3)) {
                                    echo "<option class='black' value='" . $dofor_id . "'>" . $dbfor_ragsoc . "</option>";
                                }
                                ?>
                             
                    </select>
                    </div>
                </td>
                
                <td colspan="2" style=" border-left: 1px solid #06C;">
                    <div class="styled-select black semi-square">
                    <select name="TIP_DESCCOMBO">
                            <option class='black' value="">Seleziona...</option>';
                                <?php $sql4 = "SELECT `TIP_ID`, `TIP_DESC` FROM `tipologie` ORDER BY `TIP_DESC`";
                                $stmt4 = mysqli_prepare($mysqli, $sql4);
                                mysqli_stmt_execute($stmt4);
                                mysqli_stmt_bind_result($stmt4, $dbtip_id, $dbtip_desc);
                                mysqli_stmt_store_result($stmt4);
                                while (mysqli_stmt_fetch($stmt4)) {
                                    echo "<option class='black' value='" . $dbtip_id . "'>" . $dbtip_desc . "</option>";
                                } //fine while $row
                                ?>
                             
                    </select>
                    </div>
                </td>

            </tr>
            </form>

<!------------------------------------------------------------------  Fornitori  ---------------------------------------------------------------->         
            <tr>
            
                <td colspan="7">
                    <br />
                </td>
            
            </tr>
        <form action="export.php" method="POST">
            <tr>
                
                <td colspan ="7" style="border-top: 1px solid #06C;">
                <h3>Anagrafica Fornitori</h3>
                </td>
            
            </tr>
            
            <tr>
                <td>
                    <input type="radio" name="optfornitori" checked value="tutti">tutti
                    <?php //if (isset($optfornitori) && ($optfornitori=="tutti")) { echo "checked";}?>
                </td>
              
                <td colspan="4">
                </td>
                
                <td colspan="2">
                    <input name="fornitori" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>
                
        	</tr>

            </form>
   

 
<!------------------------------------------------------------------  Clienti  ---------------------------------------------------------------->         
            <tr>
            
                <td colspan="7">
                    <br />
                </td>
            
            </tr>
        <form action="export.php" method="POST">
            <tr>
                
                <td colspan ="7" style="border-top: 1px solid #06C;">
                <h3>Anagrafica Clienti</h3>
                </td>
            
            </tr>
            
            <tr>
                <td>
                    <input type="radio" name="optclienti" checked value="tutti">tutti
                    <?php //if (isset($optclienti) && ($optclienti=="tutti")) { echo "checked";}?>
                </td>
              
                <td colspan="4">
                </td>        
               
                <td colspan="2">
                    <input name="clienti" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>

            </tr>
            </form>
            
            
            
            <!------------------------------------------------------------------  LOG  ---------------------------------------------------------------->         
            <tr>
            
                <td colspan="7">
                    <br />
                </td>
            
            </tr>
        <form action="export.php" method="POST">
            <tr>
                
                <td colspan ="7" style="border-top: 1px solid #06C;">
                <h3>LOG</h3>
                </td>
            
            </tr>
            
            <tr>
                <td>
                    <input type="radio" name="optlog" checked value="tutti">tutti
                    <?php //if (isset($optlog) && ($optlog=="tutti")) { echo "checked";}?>
                </td>
              
                <td colspan="4">
                </td>
                
                <td colspan="2">
                    <input name="log" id="submit3" type="submit" style="margin: auto; background-image: url(img/download30b.png);" value="Download Report">
                </td>
                
        	</tr>

            </form>
        </table>        

        
    
</div>


<script type="text/javascript"> 
$(document).ready(function() { 

	closeNav();
	nascondi();
	
	/*$('#checklog').change(function() {
		
			$('#checklogform').submit();
			console.log ("premuto check");
		
	}); //FINE $('#checklog').change*/

}); 

</script>


</body>
</html>