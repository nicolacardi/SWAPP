<?	include_once("database/databaseii.php");
	include_once("assets/functions/functions.php");
	$ID_mae_ora = $_POST['ID_mae_ora'];
	$ID_alu_ass = $_POST['ID_alu_ora'];
	$classe_ora = $_POST['classe_ora'];
	$sezione_ora = $_POST['sezione_ora'];
	$ritirato_cla = $_POST['ritirato_cla'];
	$dataritiro_cla = $_POST['dataritiro_cla'];
	$ore_orario = intval($_SESSION['ore_orario']);
	$datagg[1] = $_POST['datalunedi'];
	$datagg[2] = date('Y-m-d',strtotime("+1 day", strtotime($datagg[1])));
	$datagg[3] = date('Y-m-d',strtotime("+2 day", strtotime($datagg[1])));
	$datagg[4] = date('Y-m-d',strtotime("+3 day", strtotime($datagg[1])));
	$datagg[5] = date('Y-m-d',strtotime("+4 day", strtotime($datagg[1])));
	//$codmat_mttA = array();
	//$descmateria_mtt = array();
	$giorni = array("lun", "mar", "mer", "gio", "ven");
	$codmat_oraA = array();
	$classe_oraA = array();
	$sezione_oraA =array();
	$assenzeA = array();
	$DADA = array();


	$sql = "SELECT ID_ore, orainizio_ore, orafine_ore FROM tab_ore ORDER BY N_ore";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ore, $orainizio_ore, $orafine_ore);
	$orariA = array("idle");
	while (mysqli_stmt_fetch($stmt)) {
		$orainizio_ore = substr($orainizio_ore, 0, strlen($orainizio_ore)-3);
		$orafine_ore = substr($orafine_ore, 0, strlen($orafine_ore)-3);
		array_push($orariA, $orainizio_ore."-".$orafine_ore) ;
	}


	//$orariA = array("idle", "8.15-9.15", "9.15-10.15", "10.45-11.45", "11.35-12.25", "12.25-13-15", "13.15-14.05", "14.05-14.55");
	$dateSeq = array("idle", $datagg[1], $datagg[2], $datagg[3], $datagg[4], $datagg[5]);
	//inizializzo le matrici
	//5 giorni
	for ($j = 1; $j <= 5; $j++) {
		//ore_orario è dinamico
		for ($x = 1; $x <= $ore_orario; $x++) {
			$codmat_oraA[$j*10+$x] = '-';
			$classe_oraA[$j*10+$x] = '';
			$sezione_oraA[$j*10+$x] = '';
			$assenzeA[$j*10+$x] = '';
			$DADA[$j*10+$x] = '';

		}
	}
	$sql = "SELECT ID_ass, data_ass, ora_ass, tipo_ass FROM tab_assenze WHERE (data_ass BETWEEN ? AND ?) AND ID_alu_ass = ?";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "iss", $datagg[1], $datagg[5], $ID_alu_ass);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ass, $data_ass, $ora_ass, $tipo_ass);
	while (mysqli_stmt_fetch($stmt)) {
		//inserisco/modifico SOLO i valori dell'array di cui vengono trovati data e ora in tab_assenze
		$j = array_search($data_ass, $dateSeq);
		$x = $ora_ass;
		if ($tipo_ass == 0) {$assenzeA[$j*10+$x] = 1;}
		if ($tipo_ass == 2) {$DADA[$j*10+$x] = 1;}
	}
	$sql = "SELECT ID_ora, data_ora, ora_ora, descmateria_mtt, classe_ora, sezione_ora, firma_mae_ora FROM tab_orario LEFT JOIN tab_materie ON codmat_ora = codmat_mtt WHERE (data_ora BETWEEN ? AND ?) AND ID_mae_ora = ? AND (classe_ora = ? AND sezione_ora = ?)";
	$stmt = mysqli_prepare($mysqli, $sql);
	mysqli_stmt_bind_param($stmt, "ssiss", $datagg[1], $datagg[5], $ID_mae_ora, $classe_ora, $sezione_ora);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $ID_ora, $data_ora, $ora_ora, $codmat_ora, $classe_ora, $sezione_ora, $firma_mae_ora);
	while (mysqli_stmt_fetch($stmt)) {
		//metto tutto in una specie di matrice a due dimensioni: giorno+ora
		$j = array_search($data_ora, $dateSeq);
		$x = $ora_ora;
		$ID_oraA[$j*10+$x] = $ID_ora;
		$codmat_oraA[$j*10+$x] = $codmat_ora;
		$classe_oraA[$j*10+$x] = $classe_ora;
		$sezione_oraA[$j*10+$x] = $sezione_ora;
		$firma_mae_oraA[$j*10+$x] = $firma_mae_ora;
	}
	for ($x = 1; $x <= $ore_orario; $x++) { ?>
	<tr>
		<td>
			<input class="tablelabel0" style="height: 60px;" type="text" value = "<?=$x?>^ ora  [<?=$orariA[$x]?>]" disabled>
		</td>
		<?
		//una colonna per ogni giorno
		for ($j = 1; $j <= 5; $j++) { ?>
			
			<td  style="position: relative; width: 90px; border-bottom: 1px grey solid;">
				<?//if(($ritirato_cla ==1)&&($dataritiro_cla < $dateSeq[$j]) ){echo ("data successiva");}?>
				<input class="absolute" style="top: 0px; left: 0px; height: 15px; text-align: center; background: transparent; border: transparent; font-size: 10px; " name="codmat_ora" id="<? echo ("codmat_ora".$j.$x) ?>" value ="<?=$codmat_oraA[$j*10+$x]?>" disabled>
				
				<?
				//devo mostrare il segnaposto (verde o rosso che sia) solo se
				//1. la materia c'è e non è stata impostata uguale a - (materia di altro maestro) : $codmat_oraA[$j*10+$x] != "-"
				//2. il bambino non è stato ritirato in data precedente : !(($ritirato_cla ==1) && ($dataritiro_cla > $dateSeq[$j]))
				if (($codmat_oraA[$j*10+$x] != "-") &&(!(($ritirato_cla ==1)&&($dataritiro_cla < $dateSeq[$j])))){?>
					<div id="AssentePresente" class="pointer absolute ml25 mt-10" onclick="setAssDAD(<?=$ID_alu_ass?>, '<?=$datagg[$j]?>', <?=$x?>, 0);">
						<img class="imgAssenza" 
						src="assets/img/Icone/<? if ($assenzeA[$j*10+$x]==1) { echo('user-slash-solid.svg');} else {echo('user-solid.svg');}?>" 
						title="fare clic per impostare l'assenza o la presenza" 
						id="DAD<?=$j?><?=$x?>" >
					</div>

					<div id="DADNoDAD" class="pointer absolute ml60 mt-10"  onclick="setAssDAD(<?=$ID_alu_ass?>, '<?=$datagg[$j]?>', <?=$x?>, 2);">
						<img class="imgDAD" 
						src="assets/img/Icone/<? if ($DADA[$j*10+$x]==1) { echo('DAD_on.svg');} else {echo('DAD_off.svg');}?>" 
						title="fare clic per impostare la DAD" 
						id="DAD<?=$j?><?=$x?>" >
					</div>
				<?}
				if (($codmat_oraA[$j*10+$x] != "-") &&(($ritirato_cla ==1)&&($dataritiro_cla < $dateSeq[$j]))){?>
					<div id="ritirato">
						<i title="alunno ritirato" class="fa fa-user-alt-slash" style="width: 70%; font-size: 12px; color: grey"></i>
					</div>
				<?}?>
			</td>
		<?}?>
	</tr>
	<? } ?>


<script>
	
	function setAssDAD (ID_alu_ass, data_ass, ora_ass, assDAD) {
		annoscolastico = $( "#selectannoscolastico option:selected" ).val();
		postData = { data_ass : data_ass, ora_ass: ora_ass, ID_alu_ass: ID_alu_ass, annoscolastico: annoscolastico, assDAD: assDAD };
		 console.log("02qry_AssenzeRegistro.php - setAssDAD - postData a 02qry_updateAssenza.php");
		 console.log(postData);
		$.ajax({
			type: 'POST',
			url: "02qry_updateAssenza.php",
			data: postData,
			dataType: 'json',
			success: function(data){
				 console.log("02qry_AssenzeRegistro.php - setAssenza - ritorno da 02qry_updateAssenza.php");
				 console.log(data.sql);
				 console.log(data.classe);
				 console.log(data.sezione);
				 console.log(data.ore);
				requeryAssenze();
			},
			error: function(){
				alert("Errore: contattare l'amministratore fornendo il codice di errore '02qry_AssenzeRegistro ##fname##'");      
			}
		});
	}

	
// 
</script>


